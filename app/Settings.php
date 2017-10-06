<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    const DEAFULT_CURRENCY = "EUR";
    const DEAFULT_CURRENCY_SYMBOL = "€";
    public static function saveUploadedFile($image_file, $id = NULL, $multiple = false,$folder_name = 'uploads') {

        $path = '';

        if($image_file != null) {
            $path = $image_file->store($folder_name);

            $image = new WebImage();
            $image->image_file = $path;
            $image->title = $image_file->getClientOriginalName();

            if ($image->save()) {
                if ($multiple == false) {
                    if($id != null) {
                        $old_image = WebImage::find($id);
                        if($old_image != null)
                            $old_image->delete();
                    }

                    return $image->id;
                }
                else
                    return $id . ',' . $image->id;
            }
        }
        return $id;
    }

    protected static function getMIMETYPE($base64string){
        preg_match("/^data:(.*);base64/",$base64string, $match);
        if(isset($match[1])){
            return $match[1];
        }
        return false;
    }

    public static function saveImageData($imageURL, $name = null) {
        $image_type = self::getMIMETYPE($imageURL);
        $img_ar =  explode('image/',$image_type);
        if (isset($img_ar[1])) {
            $image_type = explode('image/', $image_type)[1];
            // echo $imageURL;exit;
            $image_content = base64_decode(str_replace("data:image/" . $image_type . ";base64,", "", $imageURL)); // remove "data:image/png;base64,"
            $tempfile = tmpfile(); // create temporary file
            fwrite($tempfile, $image_content); // fill data to temporary file
            $metaDatas = stream_get_meta_data($tempfile);
            $tmpFilename = $metaDatas['uri'];
            /* echo $tmpFilename;exit;*/

            if ($name == null) {
                $name = 'image-' . time() . '.png';
            }

            $file_storage_path = storage_path() . '/app/uploads/'.$name;
            /*print_r($file_storage_path);exit;
            chmod($file_storage_path, 0777);*/
            file_put_contents($file_storage_path, file_get_contents($tmpFilename));
            $imgname = 'uploads/' . basename($file_storage_path);

            $image = new WebImage();
            $image->image_file = $imgname;

            if ($image->save()) {
                return $image->id;
            }
        }
        return 0;
    }

    public static function getImageUrl($file) {
        return url('images/' . base64_encode($file));
    }

    public static function getTimeAgo($date) {
        $timestamp = strtotime($date);

        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff     = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . str_plural($strTime[$i],$diff) . " ago ";
        }else{
            $diff     = $timestamp - $currentTime;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . str_plural($strTime[$i],$diff) . " to go ";
        }
    }

    public static function getLatLong($address) {
        if(!empty($address)) {
            try {
                //Formatted address
                $formattedAddr = urlencode($address);
                $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=false&key='.env('GOOGLE_API_KEY');

                //Send request and receive json data by address
                $geocodeFromAddr = file_get_contents($url);
                $output = json_decode($geocodeFromAddr);
                if(isset( $output->results[0])) {
                    //Get latitude and longitute from json data
                    $data['latitude'] = $output->results[0]->geometry->location->lat;
                    $data['longitude'] = $output->results[0]->geometry->location->lng;
                    //Return latitude and longitude of the given address

                    if (!empty($data)) {
                        return $data;
                    }
                }else{
                    return ['latitude'=> 34.052234, 'longitude' => -118.243685];
                }
            }catch (\Exception $e) {
                return ['latitude'=> 34.052234, 'longitude' => -118.243685];
            }
        }

        return ['latitude'=> 34.052234, 'longitude' => -118.243685];
    }

    public static  function getDownloadLink($id) {
        $image = WebImage::find($id);
        if($image != null) {
            return url('images/' . base64_encode($image->image_file));
        }

        return '';
    }

    public static function getFullDate($date) {
        return date('l, F d, Y', strtotime($date));
    }

    public static function checkUrl($url)
    {
        if ($url != null && $url != "") {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                if (!preg_match("~^(?:f|ht)tp?://~i", $url)) {
                    $url = "http://" . $url;
                }

            }
            return $url;
        }
        return false;
    }

    public static function getTime($date, $format)
    {
        $timezone = 'Europe/Rome';
        // if(\Auth::check()) {
        if(\Session::has('timezone')) {
            $timezone = \Session::get('timezone');
        }
        // }

        $date = new \DateTime($date, new \DateTimeZone('UTC'));

        $date->setTimezone(new \DateTimeZone($timezone));
        return $date->format($format);
    }

    public static function convertPrice($from,$to,$am) {
        $converted = $am;
        if($from == null)
            $from = Settings::DEAFULT_CURRENCY;
        if($to == null)
            $to = Settings::DEAFULT_CURRENCY;
        $to = trim($to);
        $from = trim($from);

        if($to != $from && $am > 0) {
            $url = "https://www.google.com/finance/converter?a=$am&from=$from&to=$to";
            $data = file_get_contents($url);
            preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
            $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        }
        return round($converted, 3);
    }

    public static function getDate($date, $format = "d/m/Y")
    {
        $timezone = 'Europe/Rome';

        if(\Session::get('timezone') != '') {
            $timezone = \Session::get('timezone');
        }else{
            if(\Auth::check()) {
                $timezone = \Auth::user()->timezone;
                if ($timezone == "")
                    $timezone = 'Europe/Rome';
                \Session::put('user_timezone', $timezone);
            }
        }
        $date = new \DateTime($date, new \DateTimeZone($timezone));

        $date->setTimezone(new \DateTimeZone('UTC'));

        return $date->format($format);
    }


    public static function daysLeft($start_date, $end_date)
    {
        $now = strtotime($end_date); // or your date as well
        $your_date = strtotime(date("Y-m-d"));
        $datediff = $now - $your_date;

        $days = floor($datediff / (60 * 60 * 24));
        if ($days > 0)
            return $days;
        return '-';
    }
}
