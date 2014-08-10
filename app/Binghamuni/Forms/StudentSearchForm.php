<?php

namespace Binghamuni\Forms;

use Laracasts\Validation\FormValidator;

class StudentSearchForm extends FormValidator {

    protected $rules = [
        'student_search' => 'required'
    ];


} 