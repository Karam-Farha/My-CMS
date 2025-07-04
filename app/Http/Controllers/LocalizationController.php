<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(String $local)
    {
        if(!in_array($local , config('languages'))){
            abort(400);
        }
        session(['localization' => $local]);
        return redirect()->back();
    }
}
