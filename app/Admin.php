<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    const VERIFIED = 'verified';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'dob',
        'phone_num',
        'address',
        'address2',
        'state',
        'city',
        'country',
        'zip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return true;
    }

    public function setData($data)
    {
        $this->first_name = $data->get('first_name');
        $this->last_name = $data->get('last_name');
        $this->dob = $data->get('dob');
        $this->phone_num = $data->get('phone_num');
        $this->address = $data->get('address');
        $this->address2 = $data->get('address2');
        $this->state = $data->get('state');
        $this->city = $data->get('city');
        $this->country = $data->get('country');
        $this->zip = $data->get('zip');

    }

    public static function rules()
    {
        return [
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            //  'dob' => 'date|min:' . date("Y-m-d", strtotime("-18 years")),
            // 'phone_num' => 'required|regex:/^\+\d+$/|max:255',
            'address' => 'required|string',
            'address2' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'zip' => 'required',
        ];
    }

}