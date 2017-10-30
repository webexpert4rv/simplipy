<?php

namespace App\Http\Controllers;

use App\Email;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = Report::orderBy('created_at','desc')->get();
        $data['page_title'] = 'Historique des Messages';
        return view('admin.reports.index', $data);
    }

    public function create()
    {
        //$data['model'] = new ;
        $data['page_title'] = 'Nouveau Message';
        return view('admin.reports.create', $data);
    }

    public function store(Request $request)
    {
        $model = new Report();

        if(isset($request->status_submit)){
            $this->validate($request, $model->getRules());
        }

        $model->setData($request);
        if ($model->save()) {

            $emailTo = Report::getToAddress($model->center_id);
            $emailCc = Report::getCcAddress($model->center_id);
            $emailBcc = Report::getBccAddress($model->center_id);

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                $fields = "  " . $model->name . '/' . $model->first_name .
                    '/' . Report::getPhysicianOptions($model->physician_id) .
                    '/' . date('d-m-Y') .
                    '/' . Carbon::now()->format('H:i');

                if (isset($model->emergency_id)) {
                    $subject_content = "[MESSAGERIE SIMPLIFY]​[URGENT]" . $fields;
                    if ($model->attempt > 1) {
                        $subject_content = "[MESSAGERIE SIMPLIFY]​​[URGENT][RAPPEL]​" . $fields;
                    }
                } elseif ($model->attempt > 1) {
                    $subject_content = "[MESSAGERIE SIMPLIFY]​[RAPPEL]" . $fields;
                } else {
                    $subject_content = "[MESSAGERIE SIMPLIFY]​​" . $fields;
                }
                $formdata = Report::find($model->id)->toArray();
                try {
                    Mail::send('emails.instant_report', $formdata, function ($message) use ($emailTo, $emailCc, $emailBcc, $subject_content) {
                        if(empty($emailTo)){
                            $message->to("admin@simplify-crm.com");
                        }else{
                            $message->to($emailTo);
                        }if(!empty($emailCc)){
                            $message->cc($emailCc);
                        }if(!empty($emailBcc)){
                            $message->bcc($emailBcc);
                        }
                        $message->subject($subject_content);
                    });
                } catch (\Exception $e) {
                    return redirect()->back()->withInput()->withErrors($e->getMessage());
                }

                return redirect('user/reports')->with('success', 'Message envoyé');
            }
            return redirect('user/reports')->with('success', 'Message envoyé');
        }
        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

    public function edit($id)
    {

        $data['model'] = Report::find($id);
        $data['page_title'] = 'View Report';

        //return $data;

        return view('admin.reports.edit', $data);
    }

    public function update(Request $request,$id)
    {


        $model = Report::find($id);
        $emailTo = Report::getToAddress($model->center_id);
        $emailCc = Report::getCcAddress($model->center_id);
        $emailBcc = Report::getBccAddress($model->center_id);

        if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

            $fields = "  " . $request->name . '/' . $request->first_name .
                '/' . Report::getPhysicianOptions($request->physician_id) .
                '/' . date('d-m-Y') .
                '/' . Carbon::now()->format('H:i');

            if (isset($request->emergency_id)) {
                $subject_content = "[MESSAGERIE SIMPLIFY]​[URGENT]" . $fields;
                if ($request->attempt > 1) {
                    $subject_content = "[MESSAGERIE SIMPLIFY]​​[URGENT][RAPPEL]" . $fields;
                }
            } elseif ($request->attempt > 1) {
                $subject_content = "[MESSAGERIE SIMPLIFY]​[RAPPEL]" . $fields;
            } else {
                $subject_content = "[MESSAGERIE SIMPLIFY]" . $fields;
            }

            $formdata = $model->toArray();

            try {

                Mail::send('emails.instant_report', $formdata, function ($message) use ($emailTo, $emailCc, $emailBcc, $subject_content) {
                    if(empty($emailTo)){
                        $message->to("admin@simplify-crm.com");
                    }else{
                        $message->to($emailTo);
                    }if(!empty($emailCc)){
                        $message->cc($emailCc);
                    }if(!empty($emailBcc)){
                        $message->bcc($emailBcc);
                    }
                    $message->subject($subject_content);
                });
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors($e->getMessage());
            }

            /*$model = Report::find($id);

            $this->validate($request,$model->getRules());

            $model->setData($request);
            if ($model->save()) {
                return redirect('/reports')->with('success', 'Message à jour');
            }*/

            return redirect('user/reports')->with('success', 'Message envoyé');
        }
        return redirect('user/reports')->with('success', 'Email not send!!');
    }

    public function destroy($id)
    {
        $model = Report::find($id);
        if ($model->delete()) {
            return redirect('user/reports')->with('success', 'Message supprimé');
        }
        return redirect()->back()->withInput()->with('error', 'Something Went Wrong!!!');

    }

    public function duplicate(Request $request,$id)
    {
        $data['model'] = Report::find($id);
        $data['page_title'] = 'Edit Report';
        return view('admin.reports.duplicate', $data);
    }


    public function dailyReport123()
    {

        //return $reportData;
        $reportData = Report::where('created_at', '>' ,Carbon::yesterday()->format('Y-m-d'))
                      ->distinct('center_id')
            ->pluck('center_id');

        if(count($reportData) > 0) {

            $emailTo = Report::getToAddress($reportData);


            $emailCc = Report::getCcAddress($reportData);

            $emailBcc = Report::getBccAddress($reportData);

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                $dataCenterOne = Report::where('center_id',Report::CENTER_ONE)
                            ->where('created_at', '>' ,Carbon::yesterday()->format('Y-m-d'))
                            ->count();
                $dataCenterTwo = Report::where('center_id',Report::CENTER_TWO)
                    ->where('created_at', '>' ,Carbon::yesterday()->format('Y-m-d'))
                    ->count();

                $total =  $dataCenterOne+$dataCenterTwo;

                if($total > 0) {
                    $data = array('centerOne' => $dataCenterOne,
                        'centerTwo' => $dataCenterTwo,
                        'total' => $total,
                    );

                    $subject_content = "[Rapport​ Quotidien​ Messagerie​ Simplify]​ ".Carbon::now()->format('d-m-Y');
                    try {
                        Mail::send('emails.daily_report', $data, function ($message) use ($subject_content) {
                            /*if(empty($emailTo)){
                                $message->to("testing.rvtech@gmail.com");
                            }else{
                                $message->to($emailTo);
                            }*/
                            $message->to("testing.rvtech@gmail.com");
                          /*  $message->cc($emailCc);
                            $message->bcc($emailBcc);*/
                            $message->subject($subject_content);
                        });
                    } catch (\Exception $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }
                    return redirect('user/reports')->with('success', 'Email send!!');
                }
                return redirect('user/reports')->with('success', 'Email send!!');
            }
            return redirect('user/reports')->with('success', 'Email not send!!');
        }
        return redirect('user/reports')->with('success', 'Center Id Not Available!!');
    }

    public function monthlyReport123()
    {

        //return $reportData;
        $reportData = Report::where('created_at', '>' ,Carbon::now()->format('Y-m'))
            ->distinct('center_id')
            ->pluck('center_id');

        if(count($reportData) > 0) {

            $emailTo = Report::getToAddress($reportData);
            $emailCc = Report::getCcAddress($reportData);
            $emailBcc = Report::getBccAddress($reportData);

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                $dataCenterOne = Report::where('center_id',Report::CENTER_ONE)
                    ->where('created_at', '>' ,Carbon::now()->format('Y-m'))
                    ->count();
                $dataCenterTwo = Report::where('center_id',Report::CENTER_TWO)
                    ->where('created_at', '>' ,Carbon::now()->format('Y-m'))
                    ->count();

                $total =  $dataCenterOne+$dataCenterTwo;

                if($total > 0) {
                    $data = array('centerOne' => $dataCenterOne,
                        'centerTwo' => $dataCenterTwo,
                        'total' => $total,
                    );

                    $subject_content = "[Rapport​ Mensuel​ ​Messagerie​ Simplify]​ ".Carbon::now()->format('F Y');
                    try {
                        Mail::send('emails.monthly_report', $data, function ($message) use ($subject_content) {
                            /*if(empty($emailTo)){
                                $message->to("testing.rvtech@gmail.com");
                            }else{
                                $message->to($emailTo);
                            }*/
                            $message->to("rajat_jain@rvtechnologies.co.in");
                            /*  $message->cc($emailCc);
                              $message->bcc($emailBcc);*/
                            $message->subject($subject_content);
                        });

                    } catch (\Exception $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }
                    return redirect('user/reports')->with('success', 'Message envoyé');
                }
                return redirect('user/reports')->with('success', 'Message envoyé');
            }
            return redirect('user/reports')->with('success', 'Email not send!!');
        }
        return redirect('user/reports')->with('success', 'Center Id Not Available!!');
    }

    /*public function sendEmail()
    {
        Mail::raw('This is test email',function($message){
            $message->to('rajat_jain@rvtechnologies.co.in');
        });

        return phpinfo();
    }*/


}
