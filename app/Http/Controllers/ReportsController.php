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
        return view('admin.reports.index_optimize', $data);
    }

    public function indexOptimize(Request $request){
        //return "ok";


        $columns = [
            0   =>  'reports.created_at',
            1   =>  'reports.name',
            2   =>  'company',
            3   =>  'mobile',
            4   =>  'center_id',
            5   =>  'physician_id',
        ];

        $totalData = Report::count();
        $limit  =   $request->input('iDisplayLength');
        $start  =   $request->input('iDisplayStart');
        $order  =   $columns[$request->input('iSortCol_0')];
        $dir    =   $request->input('sSortDir_0');

        if(empty($request->input('sSearch')))
        {
            $query = Report::select('reports.*');

            $totalFiltered  =   $query->count();

            $reports    =   $query->skip($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();



        }else {

            $search = $request->input('sSearch');


            if(strtolower($search) == "cardif 1"){
                $query = Report::select('reports.*')->where('center_id',Report::CENTER_ONE);

            }elseif(strtolower($search) == "cardif 2"){
                $query = Report::select('reports.*')->where('center_id',Report::CENTER_TWO);

            }else{
                $physician_id = Report::getPhysicianId($search);

                //echo  $physician_id;

                if(strlen($physician_id) == 1){

                    $query = Report::select('reports.*')->where('physician_id',$physician_id);

                    if(count($query) == 0){
                        $query   =   Report::leftJoin('users', 'reports.user_id', '=', 'users.id')
                            ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')->select('reports.*')
                            ->where(function ($query) use ($search) {
                                $query->orWhere('company', 'LIKE',"%{$search}%")
                                    ->orWhere('reports.mobile', 'LIKE',"%{$search}%")
                                    ->orWhere('reports.created_at', 'LIKE',"%{$search}%")
                                    ->orWhere('reports.name', 'LIKE',"%{$search}%")
                                    ->orWhere('reports.first_name', 'LIKE',"%{$search}%")
                                    ->orWhere('users.name', 'LIKE',"%{$search}%")
                                    ->orWhere('user_profiles.first_name', 'LIKE',"%{$search}%")
                                    ->orWhere('user_profiles.last_name', 'LIKE',"%{$search}%");

                            });
                    }

                }else{

                    $query   =   Report::leftJoin('users', 'reports.user_id', '=', 'users.id')
                        ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')->select('reports.*')
                        ->where(function ($query) use ($search) {
                            $query->orWhere('company', 'LIKE',"%{$search}%")
                                ->orWhere('reports.mobile', 'LIKE',"%{$search}%")
                                ->orWhere('reports.created_at', 'LIKE',"%{$search}%")
                                ->orWhere('reports.name', 'LIKE',"%{$search}%")
                                ->orWhere('reports.first_name', 'LIKE',"%{$search}%")
                                ->orWhere('users.name', 'LIKE',"%{$search}%")
                                ->orWhere('user_profiles.first_name', 'LIKE',"%{$search}%")
                                ->orWhere('user_profiles.last_name', 'LIKE',"%{$search}%");

                        });
                }


            }

            $totalFiltered  =   $query->count();

            $reports    =   $query->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }

        $data = array();
        if(!empty($reports))
        {
            foreach ($reports as $model) {

                $edit = url("user/reports/" . $model->id . '/edit');
                $delete = route('reports.destroy', [$model->id]);



                $nestedData['date']        =   (string)$model->created_at;
                $nestedData['patient']   =   Report::getCivilOptions((int)$model->civil_id).' '.$model->name.' '.$model->first_name;
                $nestedData['social']       =   $model->company;
                $nestedData['mobile']       =   $model->mobile;
                $nestedData['center']       =   Report::getCenterOptions($model->center_id);
                $nestedData['medecin']    =   Report::getPhysicianOptions($model->physician_id);
                $nestedData['options']      =   "<a href='{$edit}' title='EDIT' ><i class='fa fa-eye'></i></a>
                                                   <form action='{$delete}' method='post' id='deleteReport'>
                                                    <input type='hidden' name='_method' value='delete'>
                                                    ".csrf_field()."
                                                    <button type='button' class='btn btn-xs btn-danger deleteConfirm'><i class='fa fa-remove'></i></button>
                                                   </form>";

                if (\Auth::user()->role_id == \App\User::ROLE_AGENT){
                    $duplicate = url("user/reports/" . $model->id . '/duplicate');

                    $nestedData['options'].= "<a href='{$duplicate}'>Dupliquer</a>";
                }
                $data[] = $nestedData;

            }
        }


        $json_data = array(
            "draw"            => intval($request->input('sEcho')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
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

    /*public function sendEmail()
    {
        Mail::raw('This is test email',function($message){
            $message->to('rajat_jain@rvtechnologies.co.in');
        });

        return phpinfo();
    }*/

}
