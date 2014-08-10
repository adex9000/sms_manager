<?php namespace Binghamuni\Staff;

use Auth;
use DB;
use Str;

class Staff extends \Eloquent {

    protected $fillable = ['firstname','lastname','staffno','gsmno'];

    public static function staffTypes()
    {
        $opts = [];
        $types = DB::table('staff_types')->remember(120)->get();
        foreach ($types as $type) {
            $opts[$type->id] = $type->typename;
        }

        return $opts;
    }

    public static function createStaff($data)
    {
        $staff_types = isset($data['staff_types'])? $data['staff_types'] : [];

        $staffId = DB::table('staff_addressbooks')->insertGetId([
            'firstname' => $data['first_name'],
            'lastname' => $data['surname'],
            'staffno' => $data['staffno'],
            'gsmno' => $data['gsm_no'],
        ]);

        if($staffId){
            if(count($staff_types) > 0){
                $array = [];
                foreach ($staff_types as $type) {
                    $array[] = [
                        'staff_addressbook_id' => $staffId,
                        'staff_type_id' => $type,
                    ];
                }

                return DB::table('staff_addressbook_staff_type')->insert($array);
            }
        }

        return $staffId;
    }

    public static function updateStaff($data)
    {
        $staff_types = isset($data['staff_types'])? $data['staff_types'] : [];

        $id = $data['staff_id'];

        $staff = DB::table('staff_addressbooks')->where('id','=',$id)->update([
            'firstname' => $data['first_name'],
            'lastname' => $data['surname'],
            'gsmno' => $data['gsm_no'],
        ]);

        if($staff){

            // TODO: Find a better way of doing this
            DB::table('staff_addressbook_staff_type')->where('staff_addressbook_id','=',$id)->delete();

            if(count($staff_types) > 0){
                $array = [];
                foreach ($staff_types as $type) {
                    $array[] = [
                        'staff_addressbook_id' => $id,
                        'staff_type_id' => $type,
                    ];
                }

                return DB::table('staff_addressbook_staff_type')->insert($array);
            }
        }

        return $staff;
    }

    public static function deletStaff($data)
    {
        $id = $data['staff_id'];

        $staff = DB::table('staff_addressbooks')->where('id','=', $id)->delete();
        if($staff){
            return DB::table('staff_addressbook_staff_type')->where('staff_addressbook_id','=',$id)->delete();
        }
        return $staff;
    }

    public static function searchStaff($data)
    {
        $search = trim(Str::lower($data['staff_search']));

        $result = DB::table('staff_addressbooks')->where('staffno','LIKE', $search . '%')
            ->orWhere('firstname','LIKE', $search . '%')
            ->orWhere('lastname','LIKE', $search . '%')
            ->orderBy('staffno','asc')
            ->get(['id','staffno','firstname','lastname','gsmno']);

        return $result;

    }

    public static function findStaff($id)
    {
        $result = DB::table('staff_addressbooks')->where('id','=',$id)->first(['id','staffno','firstname','lastname','gsmno']);

        $staff_type = DB::table('staff_addressbook_staff_type')->where('staff_addressbook_id','=',$id)->get(['staff_type_id']);

        return $staff_type ? array_merge((array)$result,['staff_types' => $staff_type]) : (array)$result;
    }

}