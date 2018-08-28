<?php

namespace App\Http\Controllers;

use App\BccEmail;
use App\Client;
use App\NewMessage;
use App\ReplyToEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        //return $request->all();

        if(empty($request->client_id)){
            return redirect()->back()->withInput()->with('error', 'Email not send.Please select the client.');
        }
        if(!empty($request)){

            $emailTo = Client::where('id',$request->client_id)->pluck('email')->toArray();
            $client_name = Client::where('id',$request->client_id)->first();
            $request->merge(['client_name'=>$client_name->name]);
            $replyTo = ReplyToEmail::where('user_id',$request->agent_id)->pluck('email')->toArray();
            $defaultReplyTo = ReplyToEmail::where('user_id',0)->pluck('email')->toArray();
            $emailBcc = BccEmail::pluck('email')->toArray();

            //return $request->all();
            $formdata = $request->all();
            $subject_content = $request->email_subject;
            //$this->changeSMTP();
            try {
                Mail::send('emails.message_report', $formdata, function ($message) use ($emailTo, $replyTo, $defaultReplyTo, $emailBcc, $subject_content) {
                    //$message->to("rajat_jain@rvtechnologies.co.in");
                    if(empty($emailTo)){
                        //$message->to("admin@simplify-crm.com");
                        $message->to("rajat_jain@rvtechnologies.co.in");
                    }else{
                        $message->to($emailTo);
                        //$message->to("rajat_jain@rvtechnologies.co.in");
                    }if(!empty($replyTo)){
                        $message->replyTo($replyTo);
                    }else{
                        $message->replyTo($defaultReplyTo);
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

            $newMessage = new NewMessage();
            $parent_id = null;
            if(!empty($request->message_id)){
                $getMessage     = NewMessage::find($request->message_id);
                $parent_id  =   ($getMessage->parent_message_id != null) ? $getMessage->parent_message_id : $request->message_id;
            }
            $newMessage->client_id = $request->client_id;
            $newMessage->agent_id = $request->agent_id;
            $newMessage->pre_name = $request->civil_id;
            $newMessage->client_name = $request->client_name;
            $newMessage->name = $request->name;
            $newMessage->first_name = $request->last_name;
            $newMessage->birth_date = $request->dob;
            $newMessage->address = $request->address;
            $newMessage->address2 = $request->complete_address;
            $newMessage->phone = $request->mobile;
            $newMessage->fax = $request->fax;
            $newMessage->email = $request->to_email;
            $newMessage->security_no = $request->security;
            $newMessage->exam_type = $request->exam;
            $newMessage->date_of_exam = $request->dateexam;
            $newMessage->subject = $request->email_subject;
            $newMessage->message = $request->message_body;
            $newMessage->parent_message_id = $parent_id;
            $newMessage->save();

        }
        if(!empty($request->message_id)){
            return redirect(route('message.search'))->with('success', 'Message envoyé');
        }

        return redirect(route('message.create'))->with('success', 'Message envoyé');

    }

    public function changeSMTP(){

        $transport = \Swift_SmtpTransport::newInstance('pro1.mail.ovh.net', 587, 'tls');
        $transport->setUsername('secretariat@simplify-crm.fr');
        $transport->setPassword('Messagerie$123');

        $gmail = new \Swift_Mailer($transport);

        Mail::setSwiftMailer($gmail);
    }

    public function messageSearch(){
        $data['models'] = NewMessage::orderBy('created_at','desc')->get();
        $data['page_title'] = 'Messages';
        return view('newmessage.index_optimize', $data);
    }

    public function messageSearchOptimize(Request $request){
        //return "ok";

        $columns = [
            0   =>  'client_name',
            1   =>  'name',
            2   =>  'first_name',
            3   =>  'address',
            4   =>  'phone',
            5   =>  'email',
            6   =>  'date',
            7   =>  'exam_type',
        ];
        //echo "sdada".$request->input('sSortDir_0');

        $totalData = NewMessage::where('agent_id',Auth::user()->id)->count();
        $limit  =   $request->input('iDisplayLength');
        $start  =   $request->input('iDisplayStart');
        $order  =   $columns[$request->input('iSortCol_0')];
        $dir    =   $request->input('sSortDir_0');

        if(empty($request->input('sSearch')))
        {
            $query = NewMessage::select('new_messages.*');

            $totalFiltered  =   $query->count();

            $messages   =   $query->offset($start)
                ->where('agent_id',Auth::user()->id)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();



        }else {

            $search = $request->input('sSearch');

            $query   =   NewMessage::select('new_messages.*')
                        ->where('agent_id',Auth::user()->id)
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('first_name', 'LIKE',"%{$search}%")
                        ->orWhere('client_name', 'LIKE',"%{$search}%")
                        ->orWhere('address', 'LIKE',"%{$search}%")
                        ->orWhere('phone', 'LIKE',"%{$search}%")
                        ->orWhere('email', 'LIKE',"%{$search}%")
                        ->orWhere('created_at', 'LIKE',"%{$search}%")
                        ->orWhere('exam_type', 'LIKE',"%{$search}%");


            $totalFiltered  =   $query->count();

            $messages    =   $query->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }

        $data = array();
        if(!empty($messages))
        {
            foreach ($messages as $model) {

                $edit = url("user/message-search-edit/" . $model->id );
                //$delete = route('reports.destroy', [$model->id]);

                $nestedData['client_name'] =   (string)($model->client_name) ? ($model->client_name) : '--';
                $nestedData['lastname']    =   (string)($model->name) ? ($model->name) : '--';
                $nestedData['name']        =   (string)($model->first_name) ? ($model->first_name) : '--';
                $nestedData['address']     =   ($model->address) ? ($model->address) : '--';
                $nestedData['phone']       =   ($model->phone) ? ($model->phone) : '--';
                $nestedData['email']       =   ($model->email) ? ($model->email) : '--';
                $nestedData['date']        =   (string)($model->created_at) ? (string)($model->created_at) : '--';
                $nestedData['exam']        =   ($model->exam_type) ? ($model->exam_type) : '--';
                $nestedData['options']     =   "<a href='{$edit}' title='EDIT' ><i class='fa fa-pencil'></i></a>";

                $data[] = $nestedData;

            }
        }


        $json_data = array(
            "draw"            => intval($request->input('sEcho')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }


    public function editMessage($id)
    {

        $data['model'] = NewMessage::find($id);
        $data['page_title'] = 'View Message';
        $data['clients'] = Client::latest()->get();

        return view('newmessage.edit', $data);
    }
}
