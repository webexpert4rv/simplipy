<?php

namespace App\Http\Controllers;

use App\Email;
use App\Report;
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
        $model = new Report();

        $this->validate($request,$model->getRules());

        $model->setData($request);
        if ($model->save()) {

            return redirect('/reports')->with('success', 'Successfully Added Report');
        }

        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

    public function edit($id)
    {
        $data['model'] = Report::find($id);
        $data['page_title'] = 'View Report';
        return view('admin.reports.edit', $data);
    }

    public function update(Request $request,$id)
    {
        // Send Email code Here

        $model = Report::find($id);

        $email = Email::where('center_id',$model->center_id)
                        ->where('type_id',Email::TYPE_INSTANT_REPORT)
                        ->pluck('email')->toArray();
        try {

            Mail::send('emails.instant_report',[], function($message) use ($email) {
                $message->to($email);
                $message->subject('Instant Email');
            });
        }catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors( $e->getMessage());
        }
        
        /*$model = Report::find($id);

        $this->validate($request,$model->getRules());

        $model->setData($request);
        if ($model->save()) {
            return redirect('/reports')->with('success', 'Successfully Updated Report');
        }*/

        return redirect('/reports')->with('success', 'Email send!!');
    }

    public function destroy($id)
    {
        $model = Report::find($id);
        if ($model->delete()) {
            return redirect('/reports')->with('success', 'Successfully Delete Report');
        }
        return redirect()->back()->withInput()->with('error', 'Something Went Wrong!!!');

    }
}
