<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Order;
use App\OrderProduct;
use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Overtrue\LaravelSocialite\Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (\Route::getFacadeRoot()->current()->uri() == 'home')
            $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = \Auth::user();

        if(\Auth::user()->role_id == \App\User::ROLE_AGENT){
            $data['page_title'] = 'Nouveau Message';
            return view('admin.reports.create', $data);
        }
        if(\Auth::user()->role_id == \App\User::ROLE_MANAGER){
            /*$data['models'] = Report::orderBy('created_at','desc')->get();
            $data['page_title'] = 'Gestion Messagerie';
            return view('admin.reports.index', $data);*/
            return redirect(route('reports.index'));
        }

    }



}
