<?php

namespace AppBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;

class Custom {

    public $sessionAbc;

    public function __construct()
    {
        $session = new Session();
        $this->sessionAbc = $session;
    }

    public function getCaptchaValue()
    {
        $a = rand(1,20);
        $b = rand(1,20);

        $this->sessionAbc->set('abc', $a+$b);
        $res = $a.' плюс '.$b.' равно ';

        return $res;
    }

    public function StrjsonToArr($str)
    {
        $arr = (array)json_decode($str, true);
        return $arr;
    }

    public function get_ip() 
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    public function GenerateStr($length = 10) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;  

        while (strlen($code) < $length) 
            $code .= $chars[mt_rand(0, $clen)];  

        return $code;
    }    

    public function CutUserFieldForm($length, $str)
    {
        $res = trim(mb_substr($str, 0, $length, 'UTF-8'));
        return $res = strip_tags($res);
    }
  

}