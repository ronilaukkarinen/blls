<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Bills;
use DB;

class DashboardController extends Controller {
  public function __invoke() {
    return view('dashboard');
  }
}
