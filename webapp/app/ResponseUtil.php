<?php

namespace App;

class ResponseUtil
{
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
    }

    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];
        if (!empty($data)) {
            $res['data'] = $data;
        }
        return $res;
    }
}
