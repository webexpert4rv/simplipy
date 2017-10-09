<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    const CENTER_ONE = 1;
    const CENTER_TWO = 2;

    const PHYSICIAN_ONE = 1;
    const PHYSICIAN_TWO = 2;
    const PHYSICIAN_THREE = 3;
    const PHYSICIAN_FOUR = 4;
    const PHYSICIAN_FIVE = 5;
    const PHYSICIAN_SIX = 6;
    const PHYSICIAN_SEVEN = 7;
    const PHYSICIAN_EIGHT = 8;
    const PHYSICIAN_NINE = 9;

    const EXAM_ONE = 1;
    const EXAM_TWO = 2;
    const EXAM_THREE = 3;
    const EXAM_FOUR = 4;
    const EXAM_FIVE = 5;
    const EXAM_SIX = 6;
    const EXAM_SEVEN = 7;

    const Emergency_ONE = 1;
    const Emergency_TWO = 2;

    const STATUS_SUBMIT = 0;
    const STATUS_CALL = 1;

    use SoftDeletes;

    protected $table = 'reports';

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

    public static function getPhysicianOptions($id = null)
    {
        $list = [
            self::PHYSICIAN_ONE => 'DR El Husseini',
            self::PHYSICIAN_TWO => 'DR Pigné',
            self::PHYSICIAN_THREE => 'DR Sahut D\'Izran',
            self::PHYSICIAN_FOUR => 'DR Benazzouz',
            self::PHYSICIAN_FIVE => 'DR Mounedji',
            self::PHYSICIAN_SIX => 'DR Vial Dupuy',
            self::PHYSICIAN_SEVEN => 'DR Lanouar',
            self::PHYSICIAN_EIGHT => 'DR Caussanel',
            self::PHYSICIAN_NINE => 'Other',

        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;

    }

    public static function getExamOptions($id = null)
    {
        $list = [
            self::EXAM_ONE => 'EFR (Functional Respiratory Explorations)',
            self::EXAM_TWO => 'DLCO',
            self::EXAM_THREE => 'Blood gas',
            self::EXAM_FOUR => 'Walking test',
            self::EXAM_FIVE => 'Holters Cardiac and Tensionnel - MAPA',
            self::EXAM_SIX => 'Polygraphy and Polysomnography',
            self::EXAM_SEVEN => 'Other',
        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }

    public static function getEmergencyOptions($id = null)
    {
        $list = [
            self::Emergency_ONE => 'Yes',
            self::Emergency_TWO => 'No',
        ];

        if ($id === null)
            return $list;

        if (isset($list[$id]))
            return $list[$id];

        return $id;
    }

    public function getRules()
    {
        $rules = [
            'center_id' => 'required',
            'name' => 'required',
            'first_name' => 'required',
            'company' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'email' => 'email|required',
            'mobile' => 'required',
            'physician_id' => 'required',
            'reason' => 'required',
            'exam_id' => 'required',
            'attempt' => 'required',
        ];

        return $rules;
    }

    public function setData($data, $id = null)
    {

        if (!is_object($data)) {
            $data = new Report($data);
        }

        $this->center_id = $data->get('center_id');
        $this->name = $data->get('name');
        $this->first_name = $data->get('name');
        $this->company = $data->get('company');
        $this->dob = $data->get('dob');
        $this->address = $data->get('address');
        $this->city = $data->get('city');
        $this->postal_code = $data->get('postal_code');
        $this->email = $data->get('email');
        $this->mobile = $data->get('mobile');
        $this->phone = $data->get('phone');
        $this->physician_id = $data->get('physician_id');
        $this->reason = $data->get('reason');
        $this->exam_id = $data->get('exam_id');
        $this->emergency_id = $data->get('emergency_id');
        $this->attempt = $data->get('attempt');
        $status_submit =$data->get('status_submit');
        $status_call =$data->get('status_call');
        if(isset($status_submit)) {
            $this->status = self::STATUS_SUBMIT;
        }
        if(isset($status_call)) {

            $this->status = self::STATUS_CALL;
        }

        return $this;
    }

}
