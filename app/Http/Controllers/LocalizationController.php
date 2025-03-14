<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function setLang($locale)
    {
        // dd($locale);
        Session::put('locale', $locale);
        App::setlocale($locale);
        return redirect()->back();
    }
}
