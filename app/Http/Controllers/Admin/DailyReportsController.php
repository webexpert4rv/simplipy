<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DailyReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Daily/ Monthly Emails';
        return view('admin.reports.daily_monthly',$data);
    }

    public function store(Request $request)
    {


        $type = $request->get('type_id');
        if($type == '1'){

            $reportData = Report::where('created_at', '>' ,Carbon::now()->format('Y-m-d'))
                ->distinct('center_id')
                ->pluck('center_id');

            if(count($reportData) > 0) {

                $emailTo = Report::getToAddress($reportData);
                $emailCc = Report::getCcAddress($reportData);
                $emailBcc = Report::getBccAddress($reportData);

                if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                    $dataCenterOne = Report::where('center_id',Report::CENTER_ONE)
                        ->where('created_at', '>' ,Carbon::now()->format('Y-m-d'))
                        ->count();
                    $dataCenterTwo = Report::where('center_id',Report::CENTER_TWO)
                        ->where('created_at', '>' ,Carbon::now()->format('Y-m-d'))
                        ->count();

                    $total =  $dataCenterOne+$dataCenterTwo;

                    if($total > 0) {
                        $data = array('centerOne' => $dataCenterOne,
                            'centerTwo' => $dataCenterTwo,
                            'total' => $total,
                        );

                        $subject_content = "[Rapport​ Quotidien​ Messagerie​ Simplify]​ ".Carbon::now()->format('d-m-Y');
                        try {
                            Mail::send('emails.daily_report', $data, function ($message) use ($subject_content,$emailTo,$emailCc,$emailBcc) {
                                if(empty($emailTo)){
                                    $message->to("testing.rvtech@gmail.com");
                                }else{
                                    $message->to($emailTo);
                                }
                                //$message->to("testing.rvtech@gmail.com");
                                 $message->cc($emailCc);
                                  $message->bcc($emailBcc);
                                $message->subject($subject_content);
                            });
                        } catch (\Exception $e) {
                            return redirect()->back()->withInput()->withErrors($e->getMessage());
                        }
                        return redirect(route('dailyReports.index'))->with('success', 'Email send!!');
                    }
                    return redirect(route('dailyReports.index'))->with('success', 'Email send!!');
                }
                return redirect(route('dailyReports.index'))->with('success', 'Email not send!!');
            }
            return redirect(route('dailyReports.index'))->with('success', 'Center Id Not Available!!');

        }
        if($type == '2'){

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
                            Mail::send('emails.monthly_report', $data, function ($message) use ($subject_content,$emailTo,$emailCc,$emailBcc) {
                                if(empty($emailTo)){
                                    $message->to("testing.rvtech@gmail.com");
                                }else{
                                    $message->to($emailTo);
                                }
                                //$message->to("rajat_jain@rvtechnologies.co.in");
                                  $message->cc($emailCc);
                                  $message->bcc($emailBcc);
                                $message->subject($subject_content);
                            });

                        } catch (\Exception $e) {
                            return redirect()->back()->withInput()->withErrors($e->getMessage());
                        }
                        return redirect(route('dailyReports.index'))->with('success', 'Message envoyé');
                    }
                    return redirect(route('dailyReports.index'))->with('success', 'Message envoyé');
                }
                return redirect(route('dailyReports.index'))->with('success', 'Email not send!!');
            }
            return redirect(route('dailyReports.index'))->with('success', 'Center Id Not Available!!');
        }

    }
}
