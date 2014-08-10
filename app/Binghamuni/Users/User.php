<?php
namespace Binghamuni\Users;

use Carbon\Carbon;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Eloquent;
use Auth;
use Binghamuni\Helpers\SmsApi;
use Cache;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sms_manager_users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    public static function authenticate($data)
    {
        $remember = isset($data['remember']) ? true : false;

        $auth = Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $remember);

        return $auth;
    }

    public static function smsBalance()
    {
        $smsApi = new SmsApi();
        // Set API Credentials before calling getSmsBalance()
        $smsApi->setUsername(getenv('SMS_USERNAME'));

        $smsApi->setPassword(getenv('SMS_PASSWORD'));

        $smsApi->setUrl('http://98.102.204.231/smsapi/GetCreditBalance.aspx?');

        // Cache result and return value
        if (Cache::has('sms_balance'))
        {
            return Cache::get('sms_balance',0);
        } else {

            $balance = $smsApi->getSmsBalance();

            if($balance){
                // Cache for 1 hour before checking for balance
                $time = Carbon::now()->addMinutes(360); // Cache for 6 Hours

                Cache::add('sms_balance', $balance, $time);

                return Cache::get('sms_balance');
            }

            return false;
        }

    }

    public static function smsBalanceStatus()
    {
        $balance = static::smsBalance();

        if($balance){
            if($balance >= 4000){
                return '<span class="label label-success">Great</span>';
            } else if($balance >= 500){
                return '<span class="label label-warning">Warning</span>';
            } else {
                return '<span class="label label-danger">Danger</span>';
            }
        }
        else {
            return '<span class="label label-danger">Danger</span>';
        }
    }

}
