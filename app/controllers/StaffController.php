<?php

use Binghamuni\Forms\StaffUpdateForm;
use Binghamuni\Forms\StaffValidationForm;
use Binghamuni\Helpers\Utilities;
use Binghamuni\Staff\Staff;

class StaffController extends \BaseController {

    protected $staff;

    protected $staffValidation;

    protected $staffUpdateValidation;

    protected $staffSearchValidation;

    protected $utilities;

    function __construct(Staff $staff, StaffUpdateForm $staffValidation, StaffValidationForm $staffSearchValidation, StaffUpdateForm  $staffUpdateValidation, Utilities $utilities)
    {
        $this->staff = $staff;

        $this->staffValidation = $staffValidation;

        $this->staffSearchValidation = $staffSearchValidation;

        $this->staffUpdateValidation = $staffUpdateValidation;

        $this->utilities = $utilities;
    }

    public function new_staff()
    {
        return View::make('staff.new_staff')
            ->with('active_menu_item','new_staff')
            ->with('active_menu_item_dropdown','dropdown')
            ->with('staff_types',$this->staff->staffTypes());
    }

    public function new_staff_member()
    {
        $input = Input::all();

        $this->staffValidation->validate($input);

        $staff = $this->staff->createStaff($input);

        if($staff){
            Flash::success('Staff Added successfully.');
            return Redirect::back();
        } else {
            Flash::error('An error occurred while adding the Staff.');
            return Redirect::back();
        }
    }

    public function edit_staff_member()
    {
        $input = Input::all();

        $this->staffUpdateValidation->validate($input);

        if(isset($input['update'])){
            $staff = $this->staff->updateStaff($input);
            $flash_string_success = 'updated';
            $flash_string_error = 'updating';
        }
        elseif(isset($input['delete'])){
            $staff = $this->staff->deletStaff($input);
            $flash_string_success = 'deleted';
            $flash_string_error = 'deleting';
        }
        else {
            Flash::error('An error occurred, try again later.');
            return Redirect::back();
        }

        if($staff){
            Flash::success('Staff '. $flash_string_success .' successfully.');
            return Redirect::back();
        } else {
            Flash::error('An error occurred while '. $flash_string_error .' the Staff.');
            return Redirect::back();
        }
    }

    public function search_staff($data = '')
    {
        $searchResults = empty($data) ? false : $this->staff->searchStaff($data);
        return View::make('staff.search')
            ->with('active_menu_item','search_staff')
            ->with('active_menu_item_dropdown','dropdown')
            ->with('results',$searchResults)
            ->with('serial_number', 1);
    }

    public function staff_search()
    {
        $input = Input::all();

        $this->staffSearchValidation->validate($input);

        return $this->search_staff($input);

    }

    public function edit_staff($id)
    {
        return View::make('staff.edit_staff')
            ->with('active_menu_item','new_staff')
            ->with('active_menu_item_dropdown','dropdown')
            ->with('staff',$this->staff->findStaff($id))
            ->with('staff_types',$this->staff->staffTypes());
    }

}