<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
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
        //$data['page_title'] = 'Daily Reports';
        //return view('admin.reports.daily_monthly',$data);
        $data['models'] = Report::where('created_at', '>=', Carbon::now()->format('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $data['page_title'] = 'Daily Reports';
        return view('admin.daily.index', $data);
    }

    public function edit($id)
    {
        $data['model'] = Report::find($id);
        $data['page_title'] = 'View Report';
        return view('admin.daily.edit', $data);
    }

    public function dailyMonthly()
    {
        $data['page_title'] = 'Daily/Monthly Reports';
        return view('admin.reports.daily_monthly', $data);
    }

    public function store(Request $request)
    {


        $type = $request->get('type_id');
        if ($type == '1') {

            $reportData = Report::where('created_at', '>', Carbon::now()->format('Y-m-d'))
                ->distinct('center_id')
                ->pluck('center_id');

            if (count($reportData) > 0) {

                $emailTo = Report::getToAddress($reportData);
                $emailCc = Report::getCcAddress($reportData);
                $emailBcc = Report::getBccAddress($reportData);

                if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                    $dataCenterOne = Report::where('center_id', Report::CENTER_ONE)
                        ->where('created_at', '>', Carbon::now()->format('Y-m-d'))
                        ->count();
                    $dataCenterTwo = Report::where('center_id', Report::CENTER_TWO)
                        ->where('created_at', '>', Carbon::now()->format('Y-m-d'))
                        ->count();

                    $total = $dataCenterOne + $dataCenterTwo;

                    if ($total > 0) {
                        $data = array('centerOne' => $dataCenterOne,
                            'centerTwo' => $dataCenterTwo,
                            'total' => $total,
                        );

                        $subject_content = "[Rapport​ Quotidien​ Messagerie​ Simplify]​ " . Carbon::now()->format('d-m-Y');
                        try {
                            Mail::send('emails.daily_report', $data, function ($message) use ($subject_content, $emailTo, $emailCc, $emailBcc) {
                                if (empty($emailTo)) {
                                    $message->to("testing.rvtech@gmail.com");
                                } else {
                                    $message->to($emailTo);
                                }
                                if (!empty($emailCc)) {
                                    $message->cc($emailCc);
                                }
                                if (!empty($emailBcc)) {
                                    $message->bcc($emailBcc);
                                }
                                $message->subject($subject_content);
                            });
                        } catch (\Exception $e) {
                            return redirect()->back()->withInput()->withErrors($e->getMessage());
                        }
                        return redirect(route('reports.dailyMonthly'))->with('success', 'Rapport quotidien envoyé');
                    }
                    return redirect(route('reports.dailyMonthly'))->with('success', 'Rapport quotidien envoyé');
                }
                return redirect(route('reports.dailyMonthly'))->with('success', 'Email not send!!');
            }
            return redirect(route('reports.dailyMonthly'))->with('success', 'Center Id Not Available!!');

        }
        if ($type == '2') {

            $reportData = Report::where('created_at', '>', Carbon::now()->format('Y-m'))
                ->distinct('center_id')
                ->pluck('center_id');

            if (count($reportData) > 0) {

                $emailTo = Report::getToAddress($reportData);
                $emailCc = Report::getCcAddress($reportData);
                $emailBcc = Report::getBccAddress($reportData);

                if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                    $dataCenterOne = Report::where('center_id', Report::CENTER_ONE)
                        ->where('created_at', '>', Carbon::now()->format('Y-m'))
                        ->count();
                    $dataCenterTwo = Report::where('center_id', Report::CENTER_TWO)
                        ->where('created_at', '>', Carbon::now()->format('Y-m'))
                        ->count();

                    $total = $dataCenterOne + $dataCenterTwo;

                    if ($total > 0) {
                        $data = array('centerOne' => $dataCenterOne,
                            'centerTwo' => $dataCenterTwo,
                            'total' => $total,
                        );

                        $subject_content = "[Rapport​ Mensuel​ ​Messagerie​ Simplify]​ " . Carbon::now()->format('F Y');
                        try {
                            Mail::send('emails.monthly_report', $data, function ($message) use ($subject_content, $emailTo, $emailCc, $emailBcc) {
                                if (empty($emailTo)) {
                                    $message->to("testing.rvtech@gmail.com");
                                } else {
                                    $message->to($emailTo);
                                }
                                //$message->to("rajat_jain@rvtechnologies.co.in");
                                if (!empty($emailCc)) {
                                    $message->cc($emailCc);
                                }
                                if (!empty($emailBcc)) {
                                    $message->bcc($emailBcc);
                                }
                                $message->subject($subject_content);
                            });

                        } catch (\Exception $e) {
                            return redirect()->back()->withInput()->withErrors($e->getMessage());
                        }
                        return redirect(route('reports.dailyMonthly'))->with('success', 'Rapport mensuel envoyé');
                    }
                    return redirect(route('reports.dailyMonthly'))->with('success', 'Rapport mensuel envoyé');
                }
                return redirect(route('reports.dailyMonthly'))->with('success', 'Email not send!!');
            }
            return redirect(route('reports.dailyMonthly'))->with('success', 'Center Id Not Available!!');
        }

    }


    public function update(Request $request, $id)
    {
        //return $request->all();
        /*$data['model'] = Report::find($id);
        $data['page_title'] = 'View Report';
        return view('admin.reports.admin_edit', $data);*/

        $model = Report::find($id);
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
                    if (empty($emailTo)) {
                        $message->to("admin@simplify-crm.com");
                    } else {
                        $message->to($emailTo);
                    }
                    if (!empty($emailCc)) {
                        $message->cc($emailCc);
                    }
                    if (!empty($emailBcc)) {
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

            return redirect(route('dailyReports.index'))->with('success', 'Message envoyé');
        }
        return redirect(route('dailyReports.index'))->with('success', 'Email not send!!');
    }

    public function dailyStatus()
    {
        $data['page_title'] = 'Daily Reports';
        $dateReport = DB::table("reports")
                        ->select(DB::raw("date(created_at) as date"))
                        ->groupBy(DB::raw("date(created_at)"))
                        ->orderBy(DB::raw("date(created_at)"),'desc')
                        ->get();

        if (!empty($dateReport)){

            $total['cardif1_comp'] = [];
            $total['cardif1_drop'] = [];
            $total['cardif2_comp'] = [];
            $total['cardif2_drop'] = [];
            $total['totalReport'] = [];
            foreach ($dateReport as $key=>$date1){
                $center1_completed = Report::where('center_id',Report::CENTER_ONE)
                    ->where('status',Report::STATUS_SUBMIT)
                    ->where('created_at', '>=', $date1->date)
                    ->count();

                $center1_dropped = Report::where('center_id',Report::CENTER_ONE)
                    ->where('status',Report::STATUS_CALL)
                    ->where('created_at', '>=', $date1->date)
                    ->count();

                $center2_completed = Report::where('center_id',Report::CENTER_TWO)
                    ->where('status',Report::STATUS_SUBMIT)
                    ->where('created_at', '>=', $date1->date)
                    ->count();

                $center2_dropped = Report::where('center_id',Report::CENTER_ONE)
                    ->where('status',Report::STATUS_CALL)
                    ->where('created_at', '>=', $date1->date)
                    ->count();

                $totalCenter = $center1_completed+$center1_dropped+$center2_completed+$center2_dropped;


                $total['cardif1_comp'][] += $center1_completed;
                $total['cardif1_drop'][] += $center1_dropped;
                $total['cardif2_comp'][] += $center2_completed;
                $total['cardif2_drop'][] += $center2_dropped;
                $total['totalReport'][] +=$totalCenter;

                $data1[$key]['date'] = $date1->date;
                $data1[$key]['cardif1_comp'] = $total['cardif1_comp'][$key];
                $data1[$key]['cardif1_drop'] = $total['cardif1_drop'][$key];
                $data1[$key]['cardif2_comp'] = $total['cardif2_comp'][$key];
                $data1[$key]['cardif2_drop'] = $total['cardif2_drop'][$key];
                $data1[$key]['totalReport'] = $total['totalReport'][$key];
            }
        }

        $data['total'] =$data1;
        return view('admin.daily.daily_index', $data);
    }

    public function dailyStatusResend(Request $request)
    {
        if(!empty($request->get('date'))){
            $date =  $request->get('date');
        }else{
            $date = Carbon::now()->format('Y-m-d');
        }

        $reportData = Report::where('created_at', '>', $date)
            ->distinct('center_id')
            ->pluck('center_id');

        //return $reportData;
        if (count($reportData) > 0) {

            $emailTo = Report::getToAddress($reportData);
            $emailCc = Report::getCcAddress($reportData);
            $emailBcc = Report::getBccAddress($reportData);

            //return $emailBcc;

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                $dataCenterOne = Report::where('center_id', Report::CENTER_ONE)
                    ->where('created_at', '>',$date)
                    ->count();
                $dataCenterTwo = Report::where('center_id', Report::CENTER_TWO)
                    ->where('created_at', '>', $date)
                    ->count();

                $total = $dataCenterOne + $dataCenterTwo;

                if ($total > 0) {
                    $data = array('centerOne' => $dataCenterOne,
                        'centerTwo' => $dataCenterTwo,
                        'total' => $total,
                    );

                    $subject_content = "[Rapport​ Quotidien​ Messagerie​ Simplify]​ " . $date;
                    try {
                        Mail::send('emails.daily_report', $data, function ($message) use ($subject_content, $emailTo, $emailCc, $emailBcc) {
                            if (empty($emailTo)) {
                                $message->to("testing.rvtech@gmail.com");
                            } else {
                                $message->to($emailTo);
                            }
                            if (!empty($emailCc)) {
                                $message->cc($emailCc);
                            }
                            if (!empty($emailBcc)) {
                                $message->bcc($emailBcc);
                            }
                            $message->subject($subject_content);
                        });
                    } catch (\Exception $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }
                    return redirect(route('status.daily'))->with('success', 'Rapport quotidien envoyé');
                }
                return redirect(route('status.daily'))->with('success', 'Rapport quotidien envoyé');
            }
            return redirect(route('status.daily'))->with('success', 'Email not send!!');
        }
        return redirect(route('status.daily'))->with('success', 'Center Id Not Available!!');
    }
}
