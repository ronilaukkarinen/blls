<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;

use App\Mail\VerifyRegistration;
use App\Currency;
use App\User;
use App\Space;
use Hash;
use Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
  public function index()
  {
    $currencies = Currency::all();

    return view('register', compact('currencies'));
  }

  public function store(Request $request)
  {
    $request->validate([
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|confirmed',
          'currency' => 'required|exists:currencies,id'
      ]);

        // User
    $user = new User();

    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->verification_token = Str::random(100);
    $user->currency_id = $request->currency;
    $user->ebillprovider = $request->ebillprovider;

    $user->save();

        // Space
    $space = new Space();

    $space->name = $user->name . '\'s Space';

    $space->save();

    $user->spaces()->attach($space->id, ['role' => 'admin']);

    Mail::to($user->email)->send(new VerifyRegistration($user));

    return redirect()
            ->route('login')
            ->with([
              'alert_type' => 'success',
              'alert_message' => 'You\'ve succesfully registered, check your e-mail to verify'
          ]);
  }
}
