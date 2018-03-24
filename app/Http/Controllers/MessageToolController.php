<?php

namespace App\Http\Controllers;

use App\BccEmail;
use App\Client;
use App\ReplyToEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageToolController extends Controller
{
    //
    public function create(){
        //return "Hello";
        $data['page_title'] = 'Messaging Tool';
        $data['clients'] = Client::latest()->get();
        return view('admin.messages.create', $data);
    }

    public function sendMessageEmail(Request $request){
        if(empty($request->client_id)){
            return redirect()->back()->withInput()->with('error', 'Email not send.Please select the client.');
        }
        if(!empty($request)){

            $emailTo = Client::where('id',$request->client_id)->pluck('email')->toArray();
            $client_name = Client::where('id',$request->client_id)->first();
            $request->merge(['client_name'=>$client_name->name]);
            $replyTo = ReplyToEmail::where('user_id',$request->agent_id)->pluck('email')->toArray();
            $emailBcc = BccEmail::pluck('email')->toArray();

            //return $request->all();
            $formdata = $request->all();
            $subject_content = $request->email_subject;
            try {
                Mail::send('emails.message_report', $formdata, function ($message) use ($emailTo, $replyTo, $emailBcc, $subject_content) {
                    //$message->to("rajat_jain@rvtechnologies.co.in");
                    if(empty($emailTo)){
                        //$message->to("admin@simplify-crm.com");
                        $message->to("rajat_jain@rvtechnologies.co.in");
                    }else{
                        $message->to($emailTo);
                        //$message->to("rajat_jain@rvtechnologies.co.in");
                    }if(!empty($replyTo)){
                        $message->replyTo($replyTo);
                    }if(!empty($emailBcc)){
                        $message->bcc($emailBcc);
                    }
                    if(!empty($subject_content)) {
                        $message->subject($subject_content);
                    }else{
                        $message->subject("Message");
                    }
                });

            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors($e->getMessage());
            }
        }
        return redirect(route('message.create'))->with('success', 'Message envoyé');

    }
}
