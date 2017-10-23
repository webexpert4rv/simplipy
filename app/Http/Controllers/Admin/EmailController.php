<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
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
        $data['models'] = Email::all();
        $data['page_title'] = 'Emails';
        return view('admin.emails.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model'] = new Email;
        $data['page_title'] = 'Add Email';
        return view('admin.emails.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();

        $model = new Email();
        $validator = \Validator::make($request->all(), $model->getRules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        if($request->center_id == 3)
        {
            $request->merge(['center_id'=>1]) ;
            $model->setData($request);
            if ($model->save()) {
                $model = new Email();
                $request->merge(['center_id'=>2]) ;
                $model->setData($request);
                if ($model->save()) {
                    return redirect('/admin/emails')->with('success', 'Successfully Added Email');
                }
                return redirect('/admin/emails')->with('success', 'Successfully Added Email');
            }
            return redirect('/admin/emails')->with('error', 'Something Went Wrong!!!');
        }else{
            $model->setData($request);
            if ($model->save()) {
                return redirect('/admin/emails')->with('success', 'Successfully Added Email');
            }
            return redirect()->back()->withInput()->with('error', 'Something Went Wrong!!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['model'] = Email::find($id);
        $data['page_title'] = 'Edit Email';
        return view('admin.emails.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Email::find($id);
        $validator = \Validator::make($request->all(), $model->getRules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $model->setData($request);
        if ($model->save()) {
            return redirect('/admin/emails')->with('success', 'Successfully Updated Email');
        }

        return redirect()->back()->withInput()->with('error', 'Something Went Wrong!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Email::find($id);
        if ($model->delete()) {
            return redirect('/admin/emails')->with('success', 'Successfully Delete Email');
        }

        return redirect()->back()->withInput()->with('error', 'Something Went Wrong!!!');

    }
}
