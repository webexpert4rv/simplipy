<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;
    const GENDER_NOT_SPECIFIED = 0;

    protected $fillable = [
        'user_id',
        'center_id',
        'first_name',
        'last_name',
        'gender',
        'bio',
        'dob',
        'address2',
        'address',
        'country',
        'city',
        'state',
        'zip',
        'currency',
        'phone_num',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'google_plus_url',
        'instagram_url',
        'youtube_url',
        'pinterest_url',
    ];

    protected $table = 'user_profiles';

    public function setData($data, $id = null)
    {

        if (!is_object($data)) {
            $data = new Collection($data);
        }

        // $this->gender = $data->get('gender');
        $this->dob = $data->get('dob') != null ? $data->get('dob') : null;

        if (\Auth::check()) {
            if ($id == null) {
                $id = \Auth::user()->id;
            }
        }

        $this->user_id = $id;
        $this->center_id = $data->get('center_id');
        $this->first_name = $data->get('first_name');
        $this->last_name = $data->get('last_name');
        $this->bio = $data->get('bio');
        $this->dob = $data->get('dob');
        $this->phone_num = $data->get('phone_num');
        $this->address = $data->get('address');
        $this->address2 = $data->get('address2');
        $this->city = $data->get('city');
        $this->country = $data->get('country');
        $this->facebook_url = $data->get('facebook_url');
        $this->twitter_url = $data->get('twitter_url');
        $this->youtube_url = $data->get('youtube_url');
        $this->linkedin_url = $data->get('linkedin_url');
        $this->google_plus_url = $data->get('google_plus_url');
        $this->instagram_url = $data->get('instagram_url');
        $this->pinterest_url = $data->get('pinterest_url');
        $this->zip = $data->get('zip');
        $this->state = $data->get('state');
        return $this;
    }

    public function getProfileAttributes()
    {
        $arr = [
            'first_name',
            'last_name',
            'address',
            'country',
            'city',
            'zip',
            'currency',
            'phone_num',
        ];
        return $arr;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function getRules()
    {
        $rules = [
            // 'phone_num' => 'regex:/^\+\d+$/|max:255',
            'phone_num' => 'numeric|digits:10',
            'bank_name' => 'regex:/^[a-zA-Z][a-zA-Z ]*$/|max:255',
            'bank_account_name' => 'regex:/^[a-zA-Z][a-zA-Z ]*$/|max:255',
            'city' => 'required|regex:/^[a-zA-Z][a-zA-Z ]*$/|max:255',
            'bic_swift' => 'regex:/^[a-zA-Z][a-zA-Z ]*$/|max:255',
            'zip' => 'required|digits:5',
            'state' => 'required',
            'address' => 'required',
            'address2' => 'required',
            'country' => 'required'
            /*'bank_account_name' => 'regex:/^[a-zA-Z]+$/u|max:255',
            'city' => 'regex:/^[a-zA-Z]+$/u|max:255',
            'bic_swift' => 'regex:/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i'*/
        ];

        return $rules;
    }

    public static function getMessages()
    {
        $rules = [
            'bank_account_name.regex' => 'Account Holder Name format is not valid',
            'bic_swift' => 'Swift or Bic code format is not valid',

            //'phone_num.regex' => 'Phone number should be numeric and must start with + sign.'
        ];

        return $rules;
    }

    public static function getGenderOptions($id = null)
    {
        $list = [
            self::GENDER_FEMALE => 'Female',
            self::GENDER_MALE => 'Male',
        ];

        if ($id === null)
            return $list;

        $list[self::GENDER_NOT_SPECIFIED] = 'Not Specified';

        return $list[$id];
    }

    public function getAge()
    {
        $age = 'NA';
        if ($this->age != null) {
            return $this->age;
        }

        if (!empty($this->dob) && $this->dob != NUll) {
            $from = new \DateTime($this->dob);
            $to = new \DateTime('today');
            $age = $from->diff($to)->y;
        }
        return $age;
    }

    public function customDelete()
    {
        $this->delete();
        return true;
    }
}
