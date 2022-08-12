<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ZipCodeData;

class ZipCodeController extends Controller
{
    use ZipCodeData;

    /**
     * Display the specified resource.
     *
     * @param  string  $zipCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function info($zipCode)
    {
        $this->fillData($zipCode);
        return response()->json($this->result, $this->status);
    }
}
