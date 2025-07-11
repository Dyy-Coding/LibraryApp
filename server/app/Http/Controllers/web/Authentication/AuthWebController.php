<?php

namespace App\Http\Controllers\web\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthWebController extends Controller
{
    //
      /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
