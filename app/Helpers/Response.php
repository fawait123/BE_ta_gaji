<?php
namespace App\Helpers;
use Illuminate\Routing\ResponseFactory;


class Response {
    public static function send($code,$message)
    {
        return response()->json($message,$code);
    }
}
