<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use Illuminate\Http\Request;

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
        $data['models'] = Report::orderBy('created_at','desc')->get();
        $data['page_title'] = 'Reports';
        return view('admin.reports.admin_index', $data);
    }
}
