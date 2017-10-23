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
        $data['models'] = Report::orderBy('created_at','desc')->get();
        $data['page_title'] = 'Reports';
        return view('admin.reports.admin_index', $data);
    }

    public function edit($id)
    {
        $data['model'] = Report::find($id);
        $data['page_title'] = 'View Report';
        return view('admin.reports.admin_edit', $data);
    }

    public function destroy($id)
    {
        $model = Report::find($id);
        if ($model->delete()) {
            return redirect('admin/adminReports')->with('success', 'Successfully Delete Report');
        }
        return redirect()->back()->withInput()->with('error', 'Something Went Wrong!!!');

    }


}
