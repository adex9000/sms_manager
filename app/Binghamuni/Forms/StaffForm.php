<?php

namespace Binghamuni\Forms;

use Laracasts\Validation\FormValidator;
use Binghamuni\Helpers\Utilities;

class StaffForm extends FormValidator {

    protected $rules = [
        'first_name' => 'required',
        'surname' => 'required',
        'gsm_no' => 'required|gsm',
        'staffno' => 'required|unique:staff_addressbooks',
        'staff_types' => 'required'
    ];

    public function validateGsm($attribute, $value, $parameters)
    {
       return Utilities::gsmNoValidation($value);
    }

} 