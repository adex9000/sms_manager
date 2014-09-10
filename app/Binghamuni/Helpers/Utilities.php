<?php

namespace Binghamuni\Helpers;

use DB;
use Binghamuni\Staff\Staff;

class Utilities {

    // Dropdown
    public static function departments()
    {
        $opts = ['all' => 'All'];

        $departments = DB::table('department')->remember(3600)->orderBy('deptname', 'asc')->get(['deptid','deptname']);
        foreach ($departments as $dept) {
            $opts[$dept->deptid] = $dept->deptname;
        }

        return $opts;

    }

    public static function levels()
    {
        $opts = ['all' => 'All'];

        $levels = DB::table('level')->remember(3600)->get();
        foreach ($levels as $level) {
            $opts[$level->levelid] = $level->levelno;
        }

        return $opts;

    }

    public static function states()
    {
        $opts = ['all' => 'All'];

        $states = DB::table('state')->remember(3600)->get();
        foreach ($states as $state) {
            $opts[$state->stateid] = $state->statename;
        }

        return $opts;

    }

    public static function gender()
    {
        $opts = ['all' => 'All'];

        $genders = DB::table('sex')->remember(3600)->get();
        foreach ($genders as $gender) {
            $opts[$gender->sexid] = $gender->sexname;
        }

        return $opts;

    }


    // Expand
    public static function expandDepartment($id)
    {
        $query = DB::table('department')->where('deptid','=',trim($id))->first(['deptname']);
        return $query ? $query->deptname : '';
    }

    public static function expandLevel($id)
    {
        $query = DB::table('level')->where('levelid','=',trim($id))->first(['levelno']);
        return $query ? $query->levelno : '';
    }

    public static function expandState($id)
    {
        $query = DB::table('state')->where('stateid','=',trim($id))->first(['statename']);
        return $query ? $query->statename : '';
    }

    public static function expandGender($id)
    {
        $query = DB::table('sex')->where('sexid','=',trim($id))->first(['sexname']);
        return $query ? $query->sexname : '';
    }

    // Encoding URL Strings
    public static function simpleEncode($string)
    {
        return base64_encode($string);
    }

    public static function simpleDecode($string)
    {
        return base64_decode($string);
    }

    // Preparing GSM numbers for SMS
    public static function prepareGsmArray($data)
    {
        $gsmNumbers = [];

        foreach($data as $gsm){
//            $gsmNumbers[] = isset($gsm->gsmno) ? static::formatGsmNumber($gsm->gsmno) : static::formatGsmNumber($gsm->telno);
            $gsmNumbers[] = isset($gsm['gsmno']) ? static::formatGsmNumber($gsm['gsmno']) : static::formatGsmNumber($gsm['telno']);
        }
        return $gsmNumbers;
    }

    public static function formatGsmNumber($number)
    {
        if(strlen($number) == 13){
            return $number;
        } else {
            if(strlen($number) == 11){
                return '234'. substr($number,1,10);
            }
        }
    }
    
    // Misc
    public static function gsmNoValidation($value)
    {
        if(strlen($value) < 11) { return false; }

        if(strlen($value) > 11){
            if(strlen($value) == 13) {
                return is_numeric($value)? true : false;
            } elseif(strlen($value) > 13){
                $nos = explode(',',trim($value));
                if(count($nos) < 0){
                    return false;
                } else {
                    $count = static::cleanGsmNos($nos);
                    if(count($count) > 0){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }

    public static function checkedStatus($key, $selected)
    {
        foreach($selected as $select){
            if($select->staff_type_id == $key){
                return 'checked="checked"';
            }
        }
    }

    public static function cleanGsmNos($nos, $string = false)
    {
        $allNos = [];

        if($string){ $nos = explode(',',$nos); }
        $unique = array_unique($nos);
        foreach ($unique as $number) {
            $number = trim($number);
            if(is_numeric($number)){
                $allNos[] = $number;
            }
        }
        return $string ? implode(',',$allNos) : $allNos;

    }
} 