<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Order;
use App\OrderProduct;
use App\Report;
use App\User;
use Illuminate\Http\Request;
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

        $data['page_title'] = 'Add Reports';
        return view('admin.reports.create', $data);
    }


}
