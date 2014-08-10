<?php

use Binghamuni\Forms\LoginForm;
use Binghamuni\Forms\SmsForm;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Binghamuni\Users\User;
use Binghamuni\SMS\SMS;

class UsersController extends \BaseController {

    protected $loginValidation;

    protected $smsValidation;

    protected $user;

    protected $sms;

    function __construct(LoginForm $loginValidation, SmsForm $smsValidation, User $user, SMS $sms)
    {
        $this->beforeFilter('auth',['except' => ['signin','logout']]);

        $this->loginValidation = $loginValidation;

        $this->smsValidation = $smsValidation;

        $this->user = $user;

        $this->sms = $sms;
    }


    public function signin()
	{

        $this->loginValidation->validate(Input::only('username','password'));

        if($this->user->authenticate(Input::all())){

            return Redirect::to('users/dashboard');

        } else {
            Flash::error('Username/Password combination is invalid.');

            return Redirect::back()->withInput();
        }
	}

    public function dashboard()
    {
        return View::make('users.dashboard')
                    ->with('active_menu_item','dashboard')
                    ->with('sms_balance', number_format($this->user->smsBalance(),1))
                    ->with('sms_balance_status', $this->user->smsBalanceStatus())
                    ->with('sent_sms', $this->sms->sentSms())
                    ->with('serial_number', 1);
    }

    public function new_sms()
    {
        return View::make('users.new_sms')
                    ->with('active_menu_item','sms');
    }

    public function edit_sms($id)
    {
        return View::make('users.edit_sms')
                    ->with('active_menu_item','sms')
                    ->with('sms',$this->sms->editSms($id));
    }

    public function send_sms()
    {
        $this->smsValidation->validate(Input::only('sender_id','destination_nos','sms_message'));

        $sms = $this->sms->sendSms(Input::all());

        if(! $sms ){

            Flash::error('Oops...Something went wrong and we might be experiencing network issues, try again later');

            return Redirect::back()->withInput();

        } else {
            Flash::success('SMS sent successfully! We used <strong>' . $sms . '</strong> units to send the message.');

            return Redirect::back();
        }

    }

	public function logout()
	{
		Auth::logout();
        Flash::message('You are now logged out.');
        return Redirect::to('/');
	}

}