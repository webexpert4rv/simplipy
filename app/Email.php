<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    const CENTER_ONE = 1;
    const CENTER_TWO = 2;
    const CENTER_BOTH = 3;

    const TYPE_DAILY_MONTHLY_REPORT = 1;
    const TYPE_INSTANT_REPORT = 2;

    const HEADER_TO = 1;
    const HEADER_CC = 2;
    const HEADER_BCC = 3;


    protected $fillable = [
        'email',
        'center_id',
        'type_id',
        'status',
    ];

    protected $table = 'emails';

    public function setData($data, $id = null)
    {

        if (!is_object($data)) {
            $data = new Collection($data);
        }

        $this->email = $data->get('email');
        $this->header_id = $data->get('header_id');
        $this->center_id = $data->get('center_id');
        $this->type_id = $data->get('type_id');
        return $this;


    }


    public function getRules()
    {
        if ($this->id != null) {
            $rules = [
                'email' => 'email|required',
                'center_id' => 'required',
                'type_id' => 'required',
            ];
        }else{
            $rules = [
                'email' => 'email|required',
                'center_id' => 'required',
                'type_id' => 'required',
            ];
        }
        return $rules;
    }

    public static function getCenterOptions($id = null)
    {
        $list = [
            self::CENTER_ONE => 'Cardif 1',
            self::CENTER_TWO => 'Cardif 2',
        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }

    public static function getTypeOptions($id = null)
    {
        $list = [
            self::TYPE_DAILY_MONTHLY_REPORT => 'Daily/Monthly Reports',
            self::TYPE_INSTANT_REPORT => 'Patient data Reports',
        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }

    public static function getHeaderOptions($id = null)
    {
        $list = [
            self::HEADER_TO => 'To',
            self::HEADER_CC => 'Cc',
            self::HEADER_BCC => 'Bcc',
        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }

    public function customDelete()
    {
        $this->delete();
        return true;
    }

    public function checkEmail()
    {
        $emails = Email::where([
            'center_id' => $this->center_id,
            'type_id' => $this->type_id
        ])->count();
        if ($emails >= 4) {
            return false;
        }
        return true;
    }
}
