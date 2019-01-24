<?php

namespace App\Http\Controllers;

use App\Model\fuelRecordModel;

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
}
