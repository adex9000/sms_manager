<?php

use Binghamuni\Forms\StudentSearchForm;
use Binghamuni\Helpers\Utilities;
use Binghamuni\Students\Student;

class StudentsController extends \BaseController {

    protected  $searchValiation;

    protected $student;

    protected $utilities;

    function __construct(Utilities $utilities, StudentSearchForm $searchValiation, Student $student)
    {
        $this->searchValiation = $searchValiation;

        $this->student = $student;

        $this->utilities = $utilities;
    }

    public function student_search()
	{
        $data = Input::only('student_search');

        if(!empty($data['student_search'])) $this->searchValiation->validate($data);

        $searchResults = empty($data['student_search']) ? false : $this->student->studentSearch($data);
        return View::make('students.search')
            ->with('active_menu_item','search_students')
            ->with('active_menu_item_dropdown','dropdown')
            ->with('results',$searchResults)
            ->with('search',isset($data['student_search'])? $data['student_search'] : '')
            ->with('serial_number', 1);
	}

    public function department_search()
	{
        $input = Input::all();
        $searchResults = empty($input['search']) ? false : $this->student->departmentSearch($input);
        return View::make('students.departments')
            ->with('active_menu_item','department')
            ->with('active_menu_item_dropdown','dropdown')
            ->with('departments', $this->utilities->departments())
            ->with('levels', $this->utilities->levels())
            ->with('results',$searchResults)
            ->with('serial_number', 1)
            ->with('search',isset($input['search'])? $input['search'] : '')
            ->with('level',isset($input['level'])? $input['level'] : '');
	}

    public function search_states()
	{
        $input = Input::all();
        $searchResults = empty($input['search']) ? false : $this->student->statesSearch($input);
        return View::make('students.states')
                    ->with('active_menu_item','states')
                    ->with('active_menu_item_dropdown','dropdown')
                    ->with('states', $this->utilities->states())
                    ->with('results',$searchResults)
                    ->with('serial_number', 1)
                    ->with('search',isset($input['search'])? $input['search'] : '');
	}

    public function search_genders()
	{
        $input = Input::all();
        $searchResults = empty($input['search']) ? false : $this->student->genderSearch($input);
        return View::make('students.gender')
                    ->with('active_menu_item','gender')
                    ->with('active_menu_item_dropdown','dropdown')
                    ->with('gender', $this->utilities->gender())
                    ->with('results',$searchResults)
                    ->with('serial_number', 1)
                    ->with('search',isset($input['search'])? $input['search'] : '');
	}

    public function export_csv()
	{
        Student::exportCsv(Input::all());
	}


}