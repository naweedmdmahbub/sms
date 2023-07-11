<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperDashboardController extends Controller
{
    public function getModelData(Request $request)
    {
        $models = [];
        foreach($request->all() as $model){
            $mdl = 'App\Laravue\Models\\'.$model;
            $mdl = $mdl::all();
            array_push($models, $mdl);
        }
        return $models;
    }
}
