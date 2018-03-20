<?php

namespace App\Http\Controllers\Admin;

use App\BccEmail;
use App\Client;
use App\ReplyToEmail;
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

    public function replyToIndex(){

        $models = ReplyToEmail::with('userProfile')->latest()->get();
        $data['page_title'] = 'Répondre à l\'email';
        $data['models'] = $models;
        $data['add_link'] = link_to_route('replyto.create', 'Nouvel Répondre à l\'email', [], ['class' => 'btn btn-success']);
        return view('admin.replyto.index', $data);
    }

    public function replyToCreate(){

        $data['page_title'] = 'Nouvel Répondre à l\'email';
        $data['cancel_link'] = 'replyto-index';
        $data['agents'] = User::where('role_id',User::ROLE_AGENT)->get();
        $data['add_link'] = route('replyto.store');
        $data['back_link'] = link_to_route('replyto.index', 'Répondre à');

        //return $data;
        return view('admin.replyto.create', $data);
    }

    public function replyToStore(Request $request){

        $validator = \Validator::make($request->all(), [
            'agent' => 'required',
            'email' => 'required|unique:replyto_emails,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $replyto = new ReplyToEmail();
        $replyto->user_id = $request->agent;
        $replyto->email = $request->email;
        if($replyto->save()){
            return redirect(route('replyto.index'))->with('success', 'Répondre à l\'e-mail créé avec succès');
        }
        return redirect()->back()->withInput()->with('error', 'Something went wrong');

    }

    public function replyToDestroy($id){

        $model = ReplyToEmail::findOrFail($id);

        if ($model->delete()) {
            return redirect()->back()->with('success', 'Supprimé');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function bccIndex(){

        $models = BccEmail::latest()->get();
        $data['page_title'] = 'Email Bcc';
        $data['models'] = $models;
        $data['add_link'] = link_to_route('bcc.create', 'Nouvel Email Bcc', [], ['class' => 'btn btn-success']);
        return view('admin.bcc.index', $data);
    }

    public function bccCreate(){

        $data['page_title'] = 'Nouvel Email Bcc';
        $data['cancel_link'] = 'bcc-index';
        $data['add_link'] = route('bcc.store');
        $data['back_link'] = link_to_route('bcc.index', 'Email Bcc');
        return view('admin.bcc.create', $data);
    }

    public function bccStore(Request $request){

        $validator = \Validator::make($request->all(), [
            'email' => 'required|unique:bcc_emails,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $bcc = new BccEmail();
        $bcc->email = $request->email;
        if($bcc->save()){
            return redirect(route('bcc.index'))->with('success', 'Email bcc créé avec succès');
        }
        return redirect()->back()->withInput()->with('error', 'Something went wrong');

    }

    public function bccDestroy($id){

        $model = BccEmail::findOrFail($id);

        if ($model->delete()) {
            return redirect()->back()->with('success', 'Supprimé');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }


}
