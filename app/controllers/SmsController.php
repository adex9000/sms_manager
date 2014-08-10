<?php

use Binghamuni\Helpers\Utilities;
use Binghamuni\SMS\SMS;

class SmsController extends \BaseController {

    protected $utilities;

    protected $sms;

    function __construct(Utilities $utilities, SMS $sms)
    {
        $this->utilities = $utilities;

        $this->sms = $sms;
    }


    public function send_sms()
    {
        $input = Input::all();

        $gsm_numbers = $this->sms->sendSMSFromSearch($input);

        return View::make('sms.send_sms')
            ->with('active_menu_item','sms')
            ->with('gsm_numbers', $gsm_numbers);
    }

}