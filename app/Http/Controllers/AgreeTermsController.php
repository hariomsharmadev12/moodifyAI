<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgreeTermsController extends Controller
{
    public function showTerms()
    {
        return view('auth.terms');
    }
}
