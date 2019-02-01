<?php

namespace App\Http\Controllers;

use App\scoreModel;
use App\anonymousUserModel;

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

        $modelAnonymousUser = new anonymousUserModel();
        $currentUser = $modelAnonymousUser->where('user_id', $request->user_id)->get();
        if(count($currentUser) == 0) {
            $modelAnonymousUser->user_id = $request->user_id;
            $modelAnonymousUser->user_name = $request->user_name;
            $modelAnonymousUser->save();
        }else{
            //名前を更新
            if($currentUser[0]->user_name !== $request->user_name) {
                $currentUser[0]->update(array('user_name' => $request->user_name));
            }
        }

        $model = new scoreModel();
        $currentScore = $model->where([['country_code', '=', $request->country_code], ['user_id', '=', $request->user_id]])->get();
        if(count($currentScore) == 0) {
            $model->user_id = $request->user_id;
            $model->country_code = $request->country_code;
            $model->score = $request->score;
            $model->save();
        }else{
            //短時間でゴールする方が優位なので不等号は小さい方
            if($currentScore[0]->score > $request->score) {
                $currentScore[0]->update(array('score' => $request->score));
            }
        }
    }

    public function getScoreByCountry(Request $request)
    {
        Log::debug($request);

        //$model = new scoreModel();
        // $result = $model->where('country_code', $request->country_code)->orderBy('score', 'desc')->get();

        $model = new scoreModel();
        $result = $model->join('anonymous_users', 'score.user_id', '=', 'anonymous_users.user_id')
                        ->select('score.*', 'anonymous_users.user_name')
                        ->where('score.country_code', $request->country_code)
                        ->orderBy('score', 'desc')
                        ->get();

        Log::debug($result);

        return ['score' => $result];
    }

    public function getScoreByUser(Request $request)
    {
        Log::debug($request);

        $model = new scoreModel();
        $result = $model->join('anonymous_users', 'score.user_id', '=', 'anonymous_users.user_id')
                        ->select('score.*', 'anonymous_users.user_name')
                        ->where('score.user_id', $request->user_id)
                        ->orderBy('country_code', 'desc')
                        ->get();

        return ['score' => $result];
    }
}
