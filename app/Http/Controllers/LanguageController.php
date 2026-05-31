<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'ru'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }

}
