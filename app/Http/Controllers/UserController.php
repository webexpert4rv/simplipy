<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Campaign;
use App\Mail\EmailVerification;
use App\SystemFile;
use App\User;
use App\UserProfile;
use Cartalyst\Stripe\Api\Cards;
use Cartalyst\Stripe\Api\Recipients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Null_;
use Stripe\Token;

class UserController extends Controller
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
     * Show the profile of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $user = \Auth::user();
        $profile = $user->userProfile;
        if ($user->isInfluencer())
            return view('user.profile', compact('user', 'profile'));
        return view('retailer.profile', compact('user', 'profile'));
    }

    /**
     * Show the list of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = \Auth::user();
        $profile = $user->userProfile;
        $validator = \Validator::make($request->all(), $profile->getRules(), $profile->getMessages());

        if ($validator->fails()) {
            return array_merge(['errors' => $validator->errors()->toArray()]);
        }
        $profile->update($request->all());
        SystemFile::saveUploadedFile($request->file('profile_pic'), $profile, 'profile_pic');
        $result = $profile->saveCustomer();
        if (isset($result['errors'])) {
            return [
                'errors' => [
                    'all_errors' => implode('<br/>', $result['errors'])
                ]
            ];
        }

        return $user->profileArrayJson();
    }

    /**
     * Show the list of retailers.
     *
     * @return \Illuminate\Http\Response
     */
    public function retailers()
    {
        return $this->users(User::ROLE_RETAILER);
    }

    /**
     * Show the list of influencers.
     *
     * @return \Illuminate\Http\Response
     */
    public function influencers()
    {
        return $this->users(User::ROLE_INFLUENCER);
    }


    /**
     * Show the list of admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admins()
    {
        $models = User::where('role_id', User::ROLE_ADMIN)->get();
        $admins = true;
        return view('admin.user.index', compact('models', 'admins'));
    }

    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if ($id == null)
            $id = \Auth::guard('admins')->user()->id;
        $model = Admin::find($id);
        return view('admin.user.view', compact('model'));
    }

    /**
     * Create the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($role = User::ROLE_USER)
    {
        $model = new User();
        return view('admin.user.create', compact('model', 'role'));
    }


    public function store(Request $request)
    {
        $model = new User();

        $validator = \Validator::make($request->all(), $model->rules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $model->setData($request);
        $model->password = bcrypt($request->get('password'));
        $model->role_id = $request->get('role_id');

        if ($model->save()) {
            if ($model->role_id == User::ROLE_RETAILER)
                return redirect('/admin/retailers')->with('success', 'Successfully Added Retailer');
            elseif ($model->role_id == User::ROLE_INFLUENCER)
                return redirect('/admin/influencers')->with('success', 'Successfully Added Influencer');
            return redirect('/admin/admins')->with('success', 'Successfully Added User');
        }

        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

    /**
     * Edit the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::find($id);
        $role = $model->role_id;
        $profile = $model->userProfile;

        if ($profile == null)
            $profile = new UserProfile();

        return view('admin.user.edit', compact('model', 'role', 'profile'));
    }


    public function update(Request $request, $id)
    {
        //return $request;

        $model = User::find($id);
        $profile = $model->userProfile;

        if ($profile == null)
            $profile = new UserProfile();

        $validator = \Validator::make($request->all(), $model->rules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $model->setData($request);

        if ($model->save()) {
            if ($profile->setData($request, $model->id) && $profile->save()) {
                if (method_exists($request, 'file')) {
                    SystemFile::saveUploadedFile($request->file('file'), $profile, 'image');
                }

                return redirect()->back()->withInput()->with('success', 'Successfully Updated.');

                /*if ($model->role_id == User::ROLE_ADMIN)
                    return redirect('/admin/admins')->with('success', 'Successfully Added Admin');

                if ($model->role_id == User::ROLE_RETAILER)
                    return redirect('/admin/retailers')->with('success', 'Successfully Updated Retailer');
                elseif ($model->role_id == User::ROLE_INFLUENCER)
                    return redirect('/admin/influencers')->with('success', 'Successfully Updated Influencer');

                return redirect('/admin/admins')->with('success', 'Successfully Updated User');*/
            }
        }

        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

    public function resentVerificationLink($id)
    {
        $user = User::find($id);
        $email = new EmailVerification(new User(['email_token' => $user->email_token, 'name' => $user->name]));
        Mail::to($user->email)->send($email);
        return redirect()->back()->with('success', 'Successfully sent the link in mail');
    }

    public function destroy($id)
    {
        $model = User::findOrFail($id);

        if ($model->customDelete()) {
            return redirect()->back()->with('success', 'Successfully Deleted!!!');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function uploadFiles(Request $request)
    {
        $model = new Campaign();
        $img_ar = [];
        if (!empty($request->file('files'))) {
            foreach ($request->file('files') as $file) {                
                $img_ar[] = SystemFile::saveUploadedFile($file, $model, 'image');
            }
        }
        return [
            'success' => true,
            'files' => $img_ar
        ];
    }

    public function influencerProfile($id)
    {
        $user = User::find($id);
        return view('retailer.user-profile', compact('user'));
    }

    public function createCustomer()
    {
        $customer = \Stripe\Customer::create(array(
            "description" => Auth::user()->email,
            "email" => Auth::user()->email,
        ));
        $model = \Auth::user()->userProfile;
        echo '<pre>'; print_r($customer);exit;
    }

    public function createCard(Request $request)
    {
        $token = Token::create([
            'card' => [
                'number'    => $request->number,
                'exp_month' => $request->expiry_month,
                'cvc'       => $request->cvc,
                'exp_year'  => $request->expiry_year,
            ],
        ]);

        $card = Cards::create(\Auth::user()->customer_id, $token['id']);

        echo '<pre>'; print_r($card);exit;
    }

    public function createRecipient(Request $request)
    {
        $token = Token::create([
            'card' => [
                'number'    => $request->number,
                'exp_month' => $request->expiry_month,
                'cvc'       => $request->cvc,
                'exp_year'  => $request->expiry_year,
            ],
        ]);

        \Stripe\Token::create(array(
            "bank_account" => array(
                "country" => "US",
                "currency" => "usd",
                "account_holder_name" => "Sophia Jones",
                "account_holder_type" => "individual",
                "routing_number" => "110000000",
                "account_number" => "000123456789"
            )
        ));
        $customer = \Stripe;

        \Customer::retrieve("cus_BMo0IAvPymKHnD");
        $customer->sources->create(array("source" => "btok_1B04fR2eZvKYlo2CodEVJdvH"));
        $bank_account = [];

        $recipient = Recipients::create([
            'name' => Auth::user()->name,
            'type' => 'individual',
            'card' => $token['id'],
            'tax_id' => 'SSN',
            'bank_account' => $bank_account['id'],
            "description" => Auth::user()->email,
            "email" => Auth::user()->email,
        ]);

        $recipient = Recipients::update('rp_5jSK7FKTY7mMbr', [
            'name' => Auth::user()->name,
            'type' => 'individual',
            'card' => $token['id'],
            'tax_id' => 'SSN',
            'bank_account' => $bank_account['id'],
            "description" => Auth::user()->email,
            "email" => Auth::user()->email,
        ]);

        echo '<pre>'; print_r($recipient);exit;
    }

}
