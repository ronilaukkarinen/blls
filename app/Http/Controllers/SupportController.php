<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SupportController extends Controller {
  public function __invoke() {
    return view('support');
  }
}
