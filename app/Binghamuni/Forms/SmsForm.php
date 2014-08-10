<?php

namespace Binghamuni\Forms;

use Binghamuni\Helpers\Utilities;
use Laracasts\Validation\FormValidator;

class SmsForm extends FormValidator {

    protected $rules = [
        'sender_id' => 'required|max:11|min:3|alpha_num',
        'destination_nos' => 'required|destinationnos',
        'sms_message' => 'required'
    ];

    public function validateDestinationnos($attribute, $value, $parameters)
    {
        return Utilities::gsmNoValidation($value);
}

} 