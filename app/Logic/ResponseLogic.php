<?php

namespace App\Logic;

class ResponseLogic
{
    protected static $code = 0;
    protected static $message = '';
    protected static $data = [];

    public static function setMsg($message){
        self::$message = $message;
    }

    public static function getMsg(): string
    {
        return self::$message;
    }

    public static function apiResult($code = 0,$message = '',$data = []): \Illuminate\Http\JsonResponse
    {
        $result = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($result, 200);
    }

    public static function apiErrorResult($message = ''): \Illuminate\Http\JsonResponse
    {
        $result = [
            'code' => -1,
            'message' => $message,
            'data' => [],
        ];
        return response()->json($result, 200);
    }
}
