<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Mail\EmailVerification;
use App\SystemFile;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
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
     * Show the list of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = User::latest()->get();
        return view('admin.user.index', compact('models', 'role'));
    }

    /**
     * Show the list of admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admins()
    {
        $models = User::where('role_id', User::ROLE_ADMIN)->orderBy('created_at', 'DESC')->get();
        $admins = true;
        return view('admin.user.index', compact('models', 'admins'));
    }

    /**
     * Show the list of admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function managers()
    {
        $models = User::where('role_id', User::ROLE_MANAGER)->orderBy('created_at', 'DESC')->get();
        $data['page_title'] = 'Managers';
        $data['models'] = $models;
        $data['add_link'] = link_to_route('admin.managers.create', 'Create Manager', [], ['class' => 'btn btn-success']);
        return view('admin.user.index', $data);
    }

    /**
     * Show the list of admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function agents()
    {
        $models = User::where('role_id', User::ROLE_AGENT)->orderBy('created_at', 'DESC')->get();
        $data['page_title'] = 'Agents';
        $data['models'] = $models;
        $data['add_link'] = link_to_route('admin.agents.create', 'Create Agent', [], ['class' => 'btn btn-success']);
        return view('admin.user.index', $data);
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

    public function profileUpdate(Request $request)
    {
        $id = \Auth::guard('admins')->user()->id;
        $model = Admin::find($id);

        $validator = \Validator::make($request->all(), $model->rules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $model->setData($request);

        if ($model->save()) {
            if (method_exists($request, 'file')) {
                $image_id = SystemFile::saveUploadedFile($request->file('profile_pic'), $model, 'profile_pic');
                $model->profile_pic = $image_id;
            }
            $model->save();
            if (isset($result['errors'])) {
                return redirect()->back()->withInput()->with('errors', implode('<br/>', $result['errors']));
            }
            return redirect()->back()->withInput()->with('success', 'Mis à jour');
        }

        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

    /**
     * Create the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new User();
        $profile = new UserProfile();
        return view('admin.user.create', compact('model', 'profile'));
    }
    /**
     * Create the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function managerCreate()
    {
        $model = new User();
        $profile = new UserProfile();
        $data['page_title'] = 'Create Manager';
        $data['cancel_link'] = 'managers';
        $data['model'] = $model;
        $data['profile'] = $profile;
        $data['role_id'] = User::ROLE_MANAGER;
        $data['back_link'] = link_to_route('admin.managers', 'Managers');
        $data['add_link'] = route('admin.managers.store');
        return view('admin.user.create', $data);
    }
    /**
     * Create the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentCreate()
    {
        $model = new User();
        $profile = new UserProfile();

        $data['page_title'] = 'Create Agent';
        $data['cancel_link'] = 'agents';
        $data['model'] = $model;
        $data['profile'] = $profile;
        $data['role_id'] = User::ROLE_AGENT;
        $data['add_link'] = route('admin.agents.store');
        $data['back_link'] = link_to_route('admin.agents', 'Agents');
        return view('admin.user.create', $data);
    }

    public function store(Request $request)
    {
        $model = new User();
        $profile = new UserProfile();
        $validator = \Validator::make($request->all(), $model->rules());

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $model->setData($request);
        $model->password = bcrypt($request->get('password'));
        $model->status = User::STATUS_ACTIVE;
        $model->name = "-";
        if ($model->save()) {
            $profile->user_id = $model->id;
            $profile->first_name = $request->get('first_name');
            $profile->last_name = $request->get('last_name');
            $profile->center_id = $request->get('center_id');
            $profile->save();
            if ($model->role_id == User::ROLE_AGENT)
                return redirect('/admin/agents')->with('success', 'Agent créé avec succès');
            return redirect('/admin/managers')->with('success', 'Manager créé avec succès');
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
        $profile = $model->userProfile;

        if ($profile == null)
            $profile = new UserProfile();

        $data['page_title'] = 'Edit '.$model->getName();
        $data['model'] = $model;

        $data['profile'] = $profile;
        if($model->role_id == User::ROLE_MANAGER) {
            $data['cancel_link'] = 'managers';
        }
        if($model->role_id == User::ROLE_AGENT) {
            $data['cancel_link'] = 'agents';
        }

        return view('admin.user.edit',$data);
    }


    public function update(Request $request, $id)
    {
        //return $request->all();
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
                    SystemFile::saveUploadedFile($request->file('profile_pic'), $profile, 'profile_pic');
                }
                $profile->save();

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

    public function toggleStatus($id)
    {
        $model = User::findOrFail($id);
        $message = $model->toggleStatus();
        return redirect()->back()->with('success',$message);
    }

    public function adminChangePassword($id)
    {
        $model = Admin::find($id);

        $data['page_title'] = 'Change Password';
        $data['model'] = $model;
        $data['route'] = 'admin.change-password.store';
        return view('admin.user.change_password', $data);
    }

    public function adminChangePasswordStore(Request $request, $id)
    {
        $model = Admin::find($id);

        $this->validate($request,Admin::passwordRules());

        if(!empty($request->password)) {
            $model->password = bcrypt($request->password);
            $model->save();
            return redirect()->back()->withInput()->with('success', 'Successfully Updated.');
        }
        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }

    public function managerChangePassword($id)
    {
        $model = User::find($id);
        $profile = $model->userProfile;

        $data['page_title'] = 'Change Password';
        $data['model'] = $model;
        $data['profile'] = $profile;
        $data['route'] = 'user.change-password.store';
        return view('admin.user.change_password', $data);
    }

    public function agentChangePassword($id)
    {
        $model = User::find($id);
        $profile = $model->userProfile;

        $data['page_title'] = 'Change Password';
        $data['model'] = $model;
        $data['profile'] = $profile;
        $data['route'] = 'user.change-password.store';
        return view('admin.user.change_password', $data);
    }

    public function userChangePasswordStore(Request $request, $id)
    {
        $model = User::find($id);

        $this->validate($request,User::passwordRules());

        if(!empty($request->password)) {
            $model->password = bcrypt($request->password);
            $model->save();
            return redirect()->back()->withInput()->with('success', 'Mot de passe mis à jour');
        }
        return redirect()->back()->withInput()->with('error', 'Something went wrong');
    }
}
