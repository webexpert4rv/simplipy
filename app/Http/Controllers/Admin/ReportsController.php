<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\Report;
use App\User;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
        $this->middleware('auth.admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$data['models'] = Report::orderBy('created_at','desc')->get();
        $data['page_title'] = 'Gestion Messagerie';
        $data['agents'] = User::where('role_id',User::ROLE_AGENT)->get();
        return view('admin.reports.admin_index', $data);*/

        $data['page_title'] = 'Gestion Messagerie';
        $data['agents'] = User::where('role_id',User::ROLE_AGENT)->get();
        return view('admin.reports.admin_index_2', $data);
    }


    public function adminOptimize(Request $request)
    {

        $columns = [
            0   =>  'user_profiles.first_name',
            1   =>  'reports.created_at',
            2   =>  'reports.name',
            3   =>  'company',
            4   =>  'mobile',
            5   =>  'center_id',
            6   =>  'physician_id',
        ];

        $user_ids = [];
        if($request->has('filter_agent')){
            $user_ids = UserProfile::where(DB::raw("CONCAT(TRIM(`first_name`), ' ', TRIM(`last_name`))"), 'like', "%$request->filter_agent%")->pluck('user_id');
        }

        $totalData = Report::count();
        $limit  =   $request->input('iDisplayLength');
        $start  =   $request->input('iDisplayStart');
        $order  =   $columns[$request->input('iSortCol_0')];
        $dir    =   $request->input('sSortDir_0');

        if(empty($request->input('sSearch')))
        {
            $query = Report::leftJoin('users', 'reports.user_id', '=', 'users.id')
                ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                ->select('reports.*','users.id as uid','user_profiles.user_id','user_profiles.first_name','user_profiles.last_name','reports.first_name as pname');

            if(!empty($user_ids)){
                $query->whereIn('reports.user_id',$user_ids);
            }

            if($request->has('filter_center')){
                $query->where('reports.center_id',$request->filter_center);
            }

            if($request->has('filter_daily')){
                $query->whereDate('reports.created_at',$request->filter_daily);
            }

            if($request->has('filter_monthly')){
                $query->whereMonth('reports.created_at',$request->filter_monthly);
            }

            $totalFiltered  =   $query->count();

            $reports    =   $query->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();



        }else {

            $search = $request->input('sSearch');

            $query   =   Report::leftJoin('users', 'reports.user_id', '=', 'users.id')
                ->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                ->select('reports.*','users.id as uid','user_profiles.user_id','user_profiles.first_name','user_profiles.last_name','reports.first_name as pname')
                ->where(function ($query) use ($search) {
                    $query->orWhere('company', 'LIKE',"%{$search}%")
                        ->orWhere('mobile', 'LIKE',"%{$search}%")
                        ->orWhere('reports.name', 'LIKE',"%{$search}%")
                        ->orWhere('reports.first_name', 'LIKE',"%{$search}%")
                        ->orWhere('users.name', 'LIKE',"%{$search}%")
                        ->orWhere('user_profiles.first_name', 'LIKE',"%{$search}%")
                        ->orWhere('user_profiles.last_name', 'LIKE',"%{$search}%");

                });

            if(!empty($user_ids)){
                $query->whereIn('reports.user_id',$user_ids);
            }

            if($request->has('filter_center')){
                $query->where('reports.center_id',$request->filter_center);
            }

            if($request->has('filter_daily')){
                $query->whereDate('reports.created_at',$request->filter_daily);
            }

            if($request->has('filter_monthly')){
                $query->whereMonth('reports.created_at',$request->filter_monthly);
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
            //echo $reports."=="; die;

            foreach ($reports as $model)
            {
                //echo $model->id."--";
                $edit   =  route('adminReports.edit',[$model->id]);
                $delete =  route('adminReports.destroy',[$model->id]);

                $nestedData['agent']        =   User::getFullName($model->user_id);
                $nestedData['created_at']   =   (string)$model->created_at;
                $nestedData['report']       =   Report::getCivilOptions((int)$model->civil_id).' '.$model->name.' '.$model->pname;
                $nestedData['company']      =   $model->company;
                $nestedData['mobile']       =   $model->mobile;
                $nestedData['center']       =   Report::getCenterOptions($model->center_id);
                $nestedData['physician']    =   Report::getPhysicianOptions($model->physician_id);
                $nestedData['options']      =   "<a href='{$edit}' title='EDIT' >Voir</a>
                                                   <form action='{$delete}' method='post' id='deleteReport'>
                                                    <input type='hidden' name='_method' value='delete'>
                                                    ".csrf_field()."
                                                    <button type='submit' class='btn btn-xs btn-danger deleteConfirm'><i class='fa fa-remove'></i></button>
                                                   </form>";
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

    public function edit($id)
    {
        $data['model'] = Report::find($id);
        $data['page_title'] = 'View Report';
        return view('admin.reports.admin_edit', $data);
    }


    public function update(Request $request,$id)
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

            return redirect(route('adminReports.index'))->with('success', 'Message envoyé');
        }
        return redirect(route('adminReports.index'))->with('success', 'Email not send!!');
    }

    public function destroy($id)
    {
        $model = Report::find($id);
        if ($model->delete()) {
            return redirect(route('adminReports.index'))->with('success', 'Message supprimé');
        }
        return redirect()->back()->withInput()->with('error', 'Erreur de suppression!');

    }

}
