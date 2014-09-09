<?php
namespace Binghamuni\SMS;
use Binghamuni\Helpers\Utilities;
use Eloquent;
use Binghamuni\Helpers\SmsApi;
use Cache;
use Carbon\Carbon;
use Whoops\Exception\ErrorException;

class SMS extends Eloquent {

    protected $fillable = ['destinationnos','messagebody','senderno','long_sms'];

    protected $table = 'sent_sms';

    public static function sentSms()
    {
        return static::orderBy('created_at','desc')->take(5)->get();
    }

    public static function editSms($id)
    {
        return static::findOrFail($id);
    }

    public static function sendSms($data)
    {
        $destinationNos = $data['destination_nos'];
        $senderId = $data['sender_id'];
        $messageBody = $data['sms_message'];
        $longSms = isset($data['long_sms'])? 1 : 0;

        $smsApi = new SmsApi();
        // Set API Credentials before calling getSmsBalance()
        $smsApi->setUsername(getenv('SMS_USERNAME'));
        $smsApi->setPassword(getenv('SMS_PASSWORD'));
        $smsApi->setUrl('http://98.102.204.231/smsapi/Send.aspx?');
        $smsApi->setDestinationNos($destinationNos);
        $smsApi->setLongSms($longSms);
        $smsApi->setSmsMessage($messageBody);
        $smsApi->setSenderId($senderId);

        $response = $smsApi->send();

        // Persist Sent SMS to DB
        if(! $response){
            return false;
        } else {
            static::create([
                'destinationnos' => $destinationNos,
                'senderno' => $senderId,
                'messagebody' => $messageBody,
                'long_sms' => $longSms,
            ]);

            // Cache result and return value
            $smsApi->setUrl('http://98.102.204.231/smsapi/GetCreditBalance.aspx?');

            $balance = $smsApi->getSmsBalance();

            if($balance) {
                $time = Carbon::now()->addMinutes(360); // Cache for 6 hours
                if(Cache::has('sms_balance')){
                    // Force a Refresh
                    Cache::forget('sms_balance');
                    // Add new balance to Cache
                    Cache::put('sms_balance', $balance, $time);
                } else {
                    // Add new balance to Cache
                    Cache::add('sms_balance', $balance, $time);
                }

            }

            return $response;
        }
    }

    public static function sendSMSFromSearch($input)
    {
        $gsm = '';

        if(isset($input['sms_all'])){
            $gsm = $input['sms_all'];
        }
        elseif(isset($input['single'])){
            $gsm = $input['sms_single'];
        }
        elseif(isset($input['parents'])) {
            $gsm = $input['sms_parents'];
        }

        $data = unserialize(Utilities::simpleDecode($gsm));
        $data = isset($data['data']) ? $data['data'] : $data;
        $idTypes = is_array($data) ? 1 : 2;

        $gsm_numbers = '';

        if($idTypes == 1){
            $gsm_numbers = implode(', ', Utilities::prepareGsmArray($data));
        }
        elseif($idTypes == 2){
            $gsm_numbers = $data;
        }

        return $gsm_numbers;
    }


}