<?php
namespace Binghamuni\Students;

use Binghamuni\Helpers\Utilities;
use Eloquent;
use Str;
use Excel;

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
        $dept = static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->whereIn('levelid',[1,2,3,4,5,6]);
        if($data['level'] != 'all'){ $dept->where('levelid','=',$data['level']); }
        if($data['search'] != 'all'){ $dept->where('deptid','=',$data['search']); }
        $dept->where('telno','!=','')
                ->orderBy('deptid','asc')
                ->orderBy('regno','asc');
        return $dept->get(['regno','firstname','surname','telno','nokgsm','deptid', 'levelid']);
    }

    public static function statesSearch($data)
    {
        $state = static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->where('stateid','!=','');
        if($data['search'] != 'all'){ $state->where('stateid','=',$data['search']); }
        return $state->where('telno','!=','')
                ->whereIn('levelid',[1,2,3,4,5,6])
                ->orderBy('stateid','asc')
                ->orderBy('regno','asc')
                ->get(['regno','firstname','surname','telno','nokgsm','stateid']);
    }

    public static function genderSearch($data)
    {
        $gender = static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->where('sexid','!=','');
        if($data['search'] != 'all'){ $gender->where('sexid','=',$data['search']); }
        return $gender->where('telno','!=','')
                ->whereIn('levelid',[1,2,3,4,5,6])
                ->orderBy('sexid','asc')
                ->orderBy('regno','asc')
                ->get(['regno','firstname','surname','telno','nokgsm','sexid']);
    }

    public static function exportCsv($data)
    {
        $type ='';
        if(isset($data['csv'])){
            $type = 'csv';
        } elseif(isset($data['xls'])){
            $type = 'xls';
        } else {
            $type = 'xlsx';
        }
        $csvdata = unserialize(Utilities::simpleDecode($data[$type]));

        if($data['source'] == 'search'){
            $csv_array = static::searchCsvData($csvdata);
        } elseif($data['source'] == 'department'){
            $csv_array = static::departmentCsvData($csvdata);
        } elseif($data['source'] == 'gender'){
            $csv_array = static::genderCsvData($csvdata);
        } elseif($data['source'] == 'states'){
            $csv_array = static::statesCsvData($csvdata);
        } else {
            $csv_array = [];
        }

        // var_dump($csv_array);
            Excel::create('Bingham_ICT_Exported', function($excel) use($csv_array) {
                $excel->sheet('BinghamICT', function($sheet) use($csv_array) {
                    $sheet->fromArray($csv_array);
                });
            })->export($type);
        }

    protected static function searchCsvData($data)
    {
        $csv_array = [];
        if(is_object($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv->regno,
                    'First Name' => $csv->firstname,
                    'Surname' => $csv->surname,
                    'GSM' => $csv->telno,
                    'Parent GSM' => $csv->nokgsm,
                ];
            }
        }
        return $csv_array;
    }

    protected static function departmentCsvData($data)
    {
        $csv_array = [];
        if(is_object($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv->regno,
                    'First Name' => $csv->firstname,
                    'Surname' => $csv->surname,
                    'GSM' => $csv->telno,
                    'Parent GSM' => $csv->nokgsm,
                    'Department' => Utilities::expandDepartment($csv->deptid),
                    'Level' => Utilities::expandLevel($csv->levelid)
                ];
            }
        }
        return $csv_array;
    }

    protected static function genderCsvData($data)
    {
        $csv_array = [];
        if(is_object($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv->regno,
                    'First Name' => $csv->firstname,
                    'Surname' => $csv->surname,
                    'GSM' => $csv->telno,
                    'Parent GSM' => $csv->nokgsm,
                    'Gender' => Utilities::expandGender($csv->sexid),
                ];
            }
        }
        return $csv_array;
    }

    protected static function statesCsvData($data)
    {
        $csv_array = [];
        if(is_object($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv->regno,
                    'First Name' => $csv->firstname,
                    'Surname' => $csv->surname,
                    'GSM' => $csv->telno,
                    'Parent GSM' => $csv->nokgsm,
                    'State of Origin' => Utilities::expandState($csv->stateid),
                ];
            }
        }
        return $csv_array;
    }

}


