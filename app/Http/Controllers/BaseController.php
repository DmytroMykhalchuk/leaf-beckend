<?php

namespace App\Http\Controllers;

abstract class BaseController extends Controller
{
    public function formatResponse(array $data)
    {
        return response()->json($data, $data['code'], [], JSON_UNESCAPED_UNICODE);
    }
}
