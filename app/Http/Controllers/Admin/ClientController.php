<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index(){

        $models = Client::latest()->get();
        $data['page_title'] = 'Client';
        $data['models'] = $models;
        $data['add_link'] = link_to_route('client.create', 'Nouvel Client', [], ['class' => 'btn btn-success']);
        return view('admin.client.index', $data);
    }

    public function create(){

        $data['page_title'] = 'Nouvel Client';
        $data['cancel_link'] = 'client-index';
        $data['add_link'] = route('client.store');
        $data['back_link'] = link_to_route('client.index', 'Client');

        return view('admin.client.create', $data);
    }

    public function store(Request $request){

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:clients,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        if($client->save()){
            return redirect(route('client.index'))->with('success', 'Client créé avec succès');
        }
        return redirect()->back()->withInput()->with('error', 'Something went wrong');

    }

    public function destroy($id){

        $model = Client::findOrFail($id);

        if ($model->delete()) {
            return redirect()->back()->with('success', 'Supprimé');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}
