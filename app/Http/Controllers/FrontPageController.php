<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function index()
    {
        $users = User::count();
        return view('layout.frontpage', compact('users'));
    }
}
