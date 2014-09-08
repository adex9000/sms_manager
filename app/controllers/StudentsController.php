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

    public function search_students($data = '')
	{
        $searchResults = empty($data) ? false : $this->student->studentSearch($data);
        return View::make('students.search')
                    ->with('active_menu_item','search_students')
                    ->with('active_menu_item_dropdown','dropdown')
                    ->with('results',$searchResults)
                    ->with('serial_number', 1);
	}

    public function student_search()
	{
        $this->searchValiation->validate(Input::only('student_search'));

        return $this->search_students(Input::all());

	}

    public function search_departments($data = '')
	{
        $searchResults = empty($data) ? false : $this->student->departmentSearch($data);
        return View::make('students.departments')
                    ->with('active_menu_item','department')
                    ->with('active_menu_item_dropdown','dropdown')
                    ->with('departments', $this->utilities->departments())
                    ->with('levels', $this->utilities->levels())
                    ->with('results',$searchResults)
                    ->with('serial_number', 1)
                    ->with('search',isset($data['search'])? $data['search'] : '')
                    ->with('level',isset($data['level'])? $data['level'] : '');
	}

    public function department_search()
	{
        return $this->search_departments(Input::all());
	}

    public function search_states($data = '')
	{
        $searchResults = empty($data) ? false : $this->student->statesSearch($data);
        return View::make('students.states')
                    ->with('active_menu_item','states')
                    ->with('active_menu_item_dropdown','dropdown')
                    ->with('states', $this->utilities->states())
                    ->with('results',$searchResults)
                    ->with('serial_number', 1)
                    ->with('search',isset($data['search'])? $data['search'] : '');
	}

    public function state_search()
	{
        return $this->search_states(Input::all());
	}

    public function search_genders($data = '')
	{
        $searchResults = empty($data) ? false : $this->student->genderSearch($data);
        return View::make('students.gender')
                    ->with('active_menu_item','gender')
                    ->with('active_menu_item_dropdown','dropdown')
                    ->with('gender', $this->utilities->gender())
                    ->with('results',$searchResults)
                    ->with('serial_number', 1)
                    ->with('search',isset($data['search'])? $data['search'] : '');
	}

    public function gender_search()
	{
        return $this->search_genders(Input::all());
	}

    public function export_csv()
	{
        Student::exportCsv(Input::all());
	}


}