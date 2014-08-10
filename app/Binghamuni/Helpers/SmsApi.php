<?php

namespace Binghamuni\Helpers;

use Whoops\Exception\ErrorException;

class SmsApi {

    protected $username;

    protected $password;

    protected $url;

    protected $senderId;

    protected $longSms;

    protected $smsMessage;

    protected $destinationNos;

    public function __construct()
    {
        // Catch any exception from fsocketopen network operations
        set_error_handler(function ($errno, $errstr, $errfile, $errline ) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });
    }

    /**
     * Utiware SMS Gateway
     * @param $url string URL for API call
     * @param $_data array Array of Data
     * @return array
     */
    public function PostRequest($url, $_data)
    {
        // convert variables array to string:
        $data = array();
        while(list($n,$v) = each($_data)){
            $data[] = "$n=$v";
        }
        $data = implode('&', $data);
        // format --> test1=a&test2=b etc.

        // parse the given URL
        $url = parse_url($url);
        if ($url['scheme'] != 'http') {
            die('Only HTTP request are supported !');
        }

        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];

        // open a socket connection on port 80
        $fp = fsockopen($host, 80);

        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: ". strlen($data) ."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);

        $result = '';
        while(!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }

        // close the socket connection:
        fclose($fp);

        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);

        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';

        // return as array:
        return array($header, $content);
    }

    /**
     * @return bool
     */
    public function getSmsBalance()
    {
        if(!empty($this->getUsername()) && !empty($this->getPassword()) && !empty($this->getUrl())){
            try
            {
                $response = $this->PostRequest($this->getUrl(), ['UN' => $this->getUsername(), 'P' => $this->getPassword()]);
                $code = explode(' ', $response[0]);
                $balance = explode(' ', $response[1]);

                if($code[1] == '200'){
                    return $balance[1];
                }
            }
            catch (ErrorException $e)
            {
                return false;
            }

        }
        return false;
    }

    /**
     * @return bool
     */
    public function send()
    {
        if(!empty($this->getUsername()) && !empty($this->getPassword()) && !empty($this->getUrl()) &&
            !empty($this->getSenderId()) && !empty($this->getSmsMessage())
            && !empty($this->getdestinationNos())){
            $data = [
                'UN' => $this->getUsername(),
                'P' => $this->getPassword(),
                'SA' => $this->getSenderId(),
                'DA' => $this->getDestinationNos(),
                'L' => $this->getLongSms(),
                'M' => $this->getSmsMessage(),
            ];

            try
            {
                $response = $this->PostRequest($this->getUrl(), $data);

                $code = explode(' ', $response[0]);

                $units = explode(' ', $response[1]);

                if($code[1] == '200'){
                    return $units[1];
                } else {
                    return false;
                }
            }
            catch (ErrorException $e)
            {
                return false;
            }
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getLongSms()
    {
        return $this->longSms;
    }

    /**
     * @param mixed $longSms
     */
    public function setLongSms($longSms)
    {
        $this->longSms = $longSms;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    /**
     * @return mixed
     */
    public function getSmsMessage()
    {
        return $this->smsMessage;
    }

    /**
     * @param mixed $smsMessage
     */
    public function setSmsMessage($smsMessage)
    {
        $this->smsMessage = $smsMessage;
    }

    /**
     * @return mixed
     */
    public function getDestinationNos()
    {
        return $this->destinationNos;
    }

    /**
     * @param mixed $destinationNos
     */
    public function setDestinationNos($destinationNos)
    {
        $this->destinationNos = $destinationNos;
    }

} 