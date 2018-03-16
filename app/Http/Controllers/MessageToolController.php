<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageToolController extends Controller
{
    //
    public function create(){
        //return "Hello";
        $data['page_title'] = 'Messaging Tool';
        return view('admin.messages.create', $data);
    }

    public function store(Request $request){

    }
}
