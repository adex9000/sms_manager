<?php
namespace Binghamuni\Students;

use Eloquent;
use Str;

class Student extends Eloquent {

    protected $table = 'studentbiodata';

    protected $fillable = [];

    public static function studentSearch($data)
    {
        $search = trim(Str::upper($data['student_search']));
        $result = static::where('regno','LIKE', $search . '%')
                        ->where('regno','LIKE','BHU%')
                        ->orWhere('firstname','LIKE', $search . '%')
                        ->orWhere('surname','LIKE', $search . '%')
                        ->where('telno','!=','')
                        ->whereIn('levelid',[1,2,3,4,5,6])
                        ->get(['regno','firstname','surname','telno','nokgsm']);
        return $result;
    }

    public static function departmentSearch($data)
    {
        return static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->where('levelid','=',$data['level'])
                ->where('deptid','=',$data['search'])
                ->where('telno','!=','')
                ->orderBy('regno','asc')
                ->orderBy('deptid','asc')
                ->orderBy('regno','asc')
                ->get(['regno','firstname','surname','telno','nokgsm','deptid', 'levelid']);
    }

    public static function statesSearch($data)
    {
        return static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->whereIn('levelid',[1,2,3,4,5,6])
                ->where('stateid','=',$data['search'])
                ->where('telno','!=','')
                ->orderBy('regno','asc')
                ->orderBy('deptid','asc')
                ->orderBy('regno','asc')
                ->get(['regno','firstname','surname','telno','nokgsm','stateid']);
    }

    public static function genderSearch($data)
    {
        return static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->whereIn('levelid',[1,2,3,4,5,6])
                ->where('sexid','=',$data['search'])
                ->where('telno','!=','')
                ->orderBy('regno','asc')
                ->orderBy('deptid','asc')
                ->orderBy('regno','asc')
                ->get(['regno','firstname','surname','telno','nokgsm','sexid']);
    }

}