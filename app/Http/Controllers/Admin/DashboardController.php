<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use App\User;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        //return view('admin.dashboard.admin');
        /*$data['models'] = Report::orderBy('created_at','desc')->get();
        $data['page_title'] = 'Gestion Messagerie';
        $data['agents'] = User::where('role_id',User::ROLE_AGENT)->get();
        return view('admin.reports.admin_index', $data);*/

        return redirect()->route('adminReports.index');
    }

    public function admin2()
    {
        //return view('admin.dashboard.admin');
        //$data['models'] = Report::orderBy('created_at','desc')->get();
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
                ->select('reports.*','users.id','user_profiles.user_id','user_profiles.first_name','user_profiles.last_name');

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
                            ->select('reports.*','users.id','user_profiles.user_id','user_profiles.first_name','user_profiles.last_name')
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
            foreach ($reports as $model)
            {
                $edit   =  route('adminReports.edit',[$model->id]);
                $delete =  route('adminReports.destroy',[$model->id]);

                $nestedData['agent']        =   User::getFullName($model->user_id);
                $nestedData['created_at']   =   (string)$model->created_at;
                $nestedData['report']       =   Report::getCivilOptions((int)$model->civil_id).' '.$model->name.' '.$model->first_name;
                $nestedData['company']      =   $model->company;
                $nestedData['mobile']       =   $model->mobile;
                $nestedData['center']       =   Report::getCenterOptions($model->center_id);
                $nestedData['physician']    =   Report::getPhysicianOptions($model->physician_id);
                $nestedData['options']      =   "<a href='{$edit}' title='EDIT' >Voir</a>
                                                   <form action='{$delete}' method='post' onsubmit='return confirm(\'Supprimer ? \');'>
                                                    <input type='hidden' name='_method' value='delete'>
                                                    ".csrf_field()."
                                                    <button type='submit' class='btn btn-xs btn-danger'><i class='fa fa-remove'></i></button>
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
}
