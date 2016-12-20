<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Checks if the user owns the model with the relation user()
     * TODO: redo this in a proper way.... pas le temps de nièsé
     * @param $model
     * @return bool
     */
    protected function checkUserOnModel($model)
    {
        return \Auth::check() && $model->user->id == \Auth::user()->id;
    }
}
