<?php

namespace App\Http\Controllers;

use App\scoreModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Input;
use Log;
use Config;

class gameController extends Controller
{
    public function getCountry(Request $request)
    {
        $country = Config::get('game.country_data.normal');
        $countryIndex = rand(0, count($country) - 1);

        return $country[$countryIndex];
    }

    public function putScore(Request $request)
    {
        Log::debug($request);

        $model = new scoreModel();
        $model->user_id = $request->user_id;
        $model->country_code = $request->country_code;
        $model->score = $request->score;
        $model->save();
    }
}
