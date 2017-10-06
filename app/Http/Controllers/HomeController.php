<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Order;
use App\OrderProduct;
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
        return view('home', compact('user'));
    }


    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        echo '<pre>';
        print_r($user);
        exit;
        // $user->token;
    }

    public function checkout(Request $request)
    {
        $data = $request->data;
        $order = Order::create([
            'user_id' => \Auth::user()->id,
            'transaction_id' => 'Transaction-' . time(),
            'shipping_charges' => $data['shipping'],
            'tax' => $data['tax'],
            'tax_rate' => $data['taxRate'],
            'sub_total' => $data['subTotal'],
            'total_price' => $data['totalCost'],
        ]);

        foreach ($data['items'] as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
            ]);
        }
        return 'success';
    }

}
