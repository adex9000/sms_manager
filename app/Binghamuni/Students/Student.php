<?php
namespace Binghamuni\Students;

use Binghamuni\Helpers\Utilities;
use Eloquent;
use Excel;
use Str;

class Student extends Eloquent {

    protected $table = 'studentbiodata';

    protected $fillable = [];

    public static function studentSearch($data)
    {
        $search = trim(Str::upper($data['student_search']));
        $result = Student::where('regno','LIKE', $search . '%')
                        ->where('regno','LIKE','BHU%')
                        ->orWhere('firstname','LIKE', $search . '%')
                        ->orWhere('surname','LIKE', $search . '%')
                        ->where('telno','!=','')
                        ->whereIn('levelid',[1,2,3,4,5,6]);
        $allResult = $result->get(['regno','firstname','surname','telno','nokgsm']);
        $paginatedResult = $result->paginate(30,['regno','firstname','surname','telno','nokgsm']);
        return ['allResult' => $allResult, 'paginatedResult' => $paginatedResult];
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
        $allResult = $dept->get(['regno','firstname','surname','telno','nokgsm','deptid', 'levelid']);
        $paginatedResult = $dept->paginate(30,['regno','firstname','surname','telno','nokgsm','deptid', 'levelid']);
        return ['allResult' => $allResult, 'paginatedResult' => $paginatedResult];
    }

    public static function statesSearch($data)
    {
        $state = static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->where('stateid','!=','');
        if($data['search'] != 'all'){ $state->where('stateid','=',$data['search']); }
        $state->where('telno','!=','')
                ->whereIn('levelid',[1,2,3,4,5,6])
                ->orderBy('stateid','asc')
                ->orderBy('regno','asc');
        $allResult = $state->get(['regno','firstname','surname','telno','nokgsm','stateid']);
        $paginatedResult = $state->paginate(30,['regno','firstname','surname','telno','nokgsm','stateid']);
        return ['allResult' => $allResult, 'paginatedResult' => $paginatedResult];
    }

    public static function genderSearch($data)
    {
        $gender = static::where('levelid','NOT LIKE','Gradu%')
                ->where('regno','LIKE','BHU%')
                ->where('sexid','!=','');
        if($data['search'] != 'all'){ $gender->where('sexid','=',$data['search']); }
        $gender->where('telno','!=','')
                ->whereIn('levelid',[1,2,3,4,5,6])
                ->orderBy('sexid','asc')
                ->orderBy('regno','asc');
        $allResult = $gender->get(['regno','firstname','surname','telno','nokgsm','sexid']);
        $paginatedResult = $gender->paginate(30,['regno','firstname','surname','telno','nokgsm','sexid']);
        return ['allResult' => $allResult, 'paginatedResult' => $paginatedResult];
    }

    public static function exportCsv($data)
    {
        $type = '';
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
        $data = isset($data['data']) ? $data['data'] : $data;
        if(is_array($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv['regno'],
                    'First Name' => $csv['firstname'],
                    'Surname' => $csv['surname'],
                    'GSM' => $csv['telno'],
                    'Parent GSM' => $csv['nokgsm'],
                ];
            }
        }
        return $csv_array;
    }

    protected static function departmentCsvData($data)
    {
        $csv_array = [];
        $data = isset($data['data']) ? $data['data'] : $data;
        if(is_array($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv['regno'],
                    'First Name' => $csv['firstname'],
                    'Surname' => $csv['surname'],
                    'GSM' => $csv['telno'],
                    'Parent GSM' => $csv['nokgsm'],
                    'Department' => Utilities::expandDepartment($csv['deptid']),
                    'Level' => Utilities::expandLevel($csv['levelid'])
                ];
            }
        }
        return $csv_array;
    }

    protected static function genderCsvData($data)
    {
        $csv_array = [];
        $data = isset($data['data']) ? $data['data'] : $data;
        if(is_array($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv['regno'],
                    'First Name' => $csv['firstname'],
                    'Surname' => $csv['surname'],
                    'GSM' => $csv['telno'],
                    'Parent GSM' => $csv['nokgsm'],
                    'Gender' => Utilities::expandGender($csv['sexid']),
                ];
            }
        }
        return $csv_array;
    }

    protected static function statesCsvData($data)
    {
        $csv_array = [];
        $data = isset($data['data']) ? $data['data'] : $data;
        if(is_array($data)){
            foreach ($data as $csv) {
                $csv_array[] = [
                    'Matric Number' => $csv['regno'],
                    'First Name' => $csv['firstname'],
                    'Surname' => $csv['surname'],
                    'GSM' => $csv['telno'],
                    'Parent GSM' => $csv['nokgsm'],
                    'State of Origin' => Utilities::expandState($csv['stateid']),
                ];
            }
        }
        return $csv_array;
    }

}


