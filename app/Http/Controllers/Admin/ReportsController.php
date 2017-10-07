<?php

namespace App\Http\Controllers\Admin;

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
        //$data['models'] = Email::all();
        $data['page_title'] = 'Reports';
        return view('admin.reports.index', $data);
    }

    /*public function create()
    {
        //$data['model'] = new ;
        $data['page_title'] = 'Add Email';
        return view('admin.emails.create', $data);
    }*/
}
