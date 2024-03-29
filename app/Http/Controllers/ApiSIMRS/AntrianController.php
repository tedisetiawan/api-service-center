<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Transform\TransformAntrian;
use Illuminate\Http\Request;
use App\Repository\Antrian;
use App\Validation\PostAntrian;
use App\Validation\PostRekap;

class AntrianController extends Controller
{
    protected $antrian;

    public function __construct()
    {
        $this->antrian = new Antrian;
        $this->transform = new TransformAntrian;
    }

    public function Register(Request $r, PostAntrian $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            // dd($validate->erros());
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, implode(",",$message));    
        }

        $result = $this->antrian->postAntrian($r);
        
        if ($result['code'] == 200) {
            unset($result['code']);
            return response()->jsonApiBpjs(200, "OK", $result);
        }

        // dd($result);
        unset($result['code']);
        return response()->jsonApiBpjs(201, $result['messageError']);
    }

    public function getRekapAntrian(Request $r, PostRekap $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonApiBpjs(422, implode(",", $message));    
        }

        $result = $this->antrian->postRekap($r);

        if ($result['code'] == 200) {
            unset($result['code']);
            return response()->jsonApiBpjs(200, "OK", $result);
        }

        unset($result['code']);
        return response()->jsonApiBpjs(201, $result['messageError']);
    }
}