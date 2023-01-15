<?php
namespace App\Helpers;


class Response{
    public static function send($code,$message)
    {
        return response()->json($message,$code);
    }
}
