<?php

namespace App;

use function foo\func;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_MANAGER = 0;
    const ROLE_AGENT = 1;
    const ROLE_ADMIN = 2;

    const STATUS_PENDING = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SUSPEND = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'email_token', 'verify', 'last_action_time', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userProfile()
    {
        return $this->hasOne('App\UserProfile', 'user_id');
    }

    public function isAdmin()
    {
        if ($this->role_id == self::ROLE_ADMIN)
            return true;
        return false;
    }

    public function isManager()
    {
        if ($this->role_id == self::ROLE_MANAGER) {
            return true;
        }

        return false;
    }

    public function isAgent()
    {
        if ($this->role_id == self::ROLE_AGENT) {
            return true;
        }

        return false;
    }


    public function hasRole($roles)
    {
        // Check if the user is a root account
        if ($this->isAdmin()) {
            return true;
        }

        if (is_array($roles)) {

            foreach ($roles as $need_role) {

                if ($this->checkIfUserHasRole($need_role)) {
                    return true;
                }

            }

        } else {
            return $this->checkIfUserHasRole($roles);
        }


        return false;
    }

    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role) == strtolower($this->role_id)) ? true : false;
    }

    public function rules()
    {
        $rules = [];

        if ($this->id != null) {
            $rules['email'] = 'required|email|max:255|unique:users,id,' . $this->id;
        } else {
            $rules = array_merge($rules, ['password' => 'required|confirmed|min:6', 'email' => 'required|max:255|email|unique:users',
            ]);
        }

        return $rules;
    }

    public function setData($data)
    {
        if ($data->get('name') != null)
            $this->name = $data->get('name');

        if ($data->get('email') != null)
            $this->email = $data->get('email');

        if ($data->get('role_id') != null)
            $this->role_id = $data->get('role_id');

        return $this;
    }

    public static function getRoleOptions($id = null)
    {
        $list = [
            self::ROLE_MANAGER => 'Manager',
            self::ROLE_AGENT => 'Agent'
        ];

        if ($id === null)
            return $list;

        /*$list[self::ROLE_USER] = 'User';*/
        $list[self::ROLE_ADMIN] = 'Admin';

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }


    public static function getStatusOptions($id = null)
    {
        $list = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_SUSPEND => 'Suspend'
        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }


    public function verified()
    {
        $this->verified = 1;
        $this->email_token = null;
        $this->save();
    }

    public function customDelete()
    {
        $profile = $this->userProfile;
        if ($profile != null) {
            $profile->customDelete();
        }
        $this->delete();
        return true;
    }

    public function profileArrayJson()
    {
        $profile = UserProfile::with(['selectedCountry', 'selectedCurrency'])->where(['user_id' => $this->id])->first();
        if ($profile == null)
            $profile = new UserProfile();
        return $profile->toArray();
    }

    public function getName()
    {
        return @$this->userProfile->first_name . ' ' . @$this->userProfile->last_name;
    }

    public function updateProfile($attr, $val)
    {
        $profile = $this->userProfile;
        if ($profile == null) {
            $profile = UserProfile::create([
                'user_id' => $this->id,
                $attr => $val
            ]);
        } else {
            $profile->update([
                $attr => $val
            ]);
        }
    }

    public function getViewLink($store = false)
    {
        if ($this->role_id == User::ROLE_AGENT) {
            if ($store == true) {
                return ['admin.agents.store'];
            }
            return link_to_route('admin.agents.show', '', ['id' => $this->id], ['class' => 'fa fa-eye', 'title' => 'View']);
        }elseif ($this->role_id == User::ROLE_MANAGER) {
            if ($store == true) {
                return ['admin.managers.store'];
            }
            return link_to_route('admin.managers.show', '', ['id' => $this->id], ['class' => 'fa fa-eye','title' => 'View']);
        }

        if ($store == true) {
            return ['admin.users.store'];
        }

        return link_to_route('admin.users.show', '', ['id' => $this->id], ['class' => 'fa fa-eye','title' => 'Edit']);
    }

    public function getEditLink($update = false)
    {
        if ($this->role_id == User::ROLE_AGENT) {
            if ($update == true) {
                return ['admin.agents.update','id' => $this->id];
            }
            return link_to_route('admin.agents.edit', '', ['id' => $this->id], ['class' => 'fa fa-pencil', 'title' => 'Edit']);
        }elseif ($this->role_id == User::ROLE_MANAGER) {
            if ($update == true) {
                return ['admin.managers.update','id' => $this->id];
            }
            return link_to_route('admin.managers.edit', '', ['id' => $this->id], ['class' => 'fa fa-pencil','title' => 'Edit']);
        }

        if ($update == true) {
            return ['admin.users.update', 'id' => $this->id];
        }

        return link_to_route('admin.users.edit', '', ['id' => $this->id], ['class' => 'fa fa-pencil','title' => 'Edit']);
    }

    public function getChangePasswordLink($update = false)
    {
        if ($this->role_id == User::ROLE_AGENT) {
            return link_to_route('admin.agent.change-password', 'Change Password', ['id' => $this->id]);
        }elseif ($this->role_id == User::ROLE_MANAGER) {
            return link_to_route('admin.manager.change-password', 'Change Password', ['id' => $this->id]);
        }
        return link_to_route('admin.users.edit', '', ['id' => $this->id], ['class' => 'fa fa-pencil','title' => 'Edit']);
    }

    public function getListLink()
    {

        if ($this->role_id == User::ROLE_AGENT) {
            return link_to_route('admin.agents', 'Agents');
        }elseif ($this->role_id == User::ROLE_MANAGER) {
            return link_to_route('admin.managers', 'Managers');
        }

        return link_to_route('admin.users', 'Users');
    }

    public function toggleStatus()
    {
        $status = User::STATUS_ACTIVE;
        $message = 'Successfully Activate the account';
        if ($this->status == User::STATUS_ACTIVE) {
            $status = User::STATUS_SUSPEND;
            $message = 'Successfully Suspended the account';
        }
        $this->update([
            'status' => $status
        ]);
        return $message;

    }

    public static function passwordRules()
    {
        return [
            'password' => 'required|min:6|confirmed',
        ];
    }

    public static function getFirstName($id)
    {
        if(!empty($id)) {
            $name = UserProfile::select('first_name')->where('user_id',$id)->first();
            if(!empty($name)) {
                return $name->first_name;
            }
            return "--";
        }
        return "--";

    }

    public static function getFullName($id)
    {
        if(!empty($id)) {
            $name = UserProfile::select('first_name','last_name')->where('user_id',$id)->first();
            if(!empty($name)) {
                return $name->first_name. " " . $name->last_name;
            }
            return "--";
        }
        return "--";

    }


    public static function months(){
        $list = [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',

        ];

        return $list;
    }
}
