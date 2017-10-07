<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = Report::all();
        $data['page_title'] = 'Reports';
        return view('admin.reports.index', $data);
    }

    public function create()
    {
        //$data['model'] = new ;
        $data['page_title'] = 'Add Reports';
        return view('admin.reports.create', $data);
    }

    public function store(Request $request)
    {
        //return $request->all();

        $model = new Report();

        $this->validate($request,$model->getRules());

       /* $validator = \Validator::make($request->all(), $model->getRules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }*/

        $model->setData($request);

        if ($model->save()) {
            return redirect('/admin/reports')->with('success', 'Successfully Added Report');
        }

        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }
}
