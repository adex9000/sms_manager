<?php

namespace Binghamuni\Forms;

use Laracasts\Validation\FormValidator;

class StaffValidationForm extends FormValidator {

    protected $rules = [
        'staff_search' => 'required',
    ];

} 