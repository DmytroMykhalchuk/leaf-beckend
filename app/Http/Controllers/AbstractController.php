<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class AbstractController extends Controller
{
    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnResponse(array $data): JsonResponse
    {
        return response()->json($data, $data['code'], [], JSON_UNESCAPED_UNICODE);
    }
}
