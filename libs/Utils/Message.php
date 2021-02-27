<?php

namespace Lib\Utils;

class Message
{
    public static function SetMessage(string $name, string $message)
    {
        unset($_SESSION[$name]);
        $_SESSION[$name] = $message;
    }

    public static function GetMessage(string $name)
    {
        if (!isset($_SESSION[$name])) 
            return false;
        $message = $_SESSION[$name];
        unset($_SESSION[$name]);
        return $message;
    }
}
