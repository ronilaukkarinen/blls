<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recurring;
use Auth;
use DB;

class DashboardController extends Controller {
  public function __invoke() {
    return view('dashboard');
  }

  public function getUsers(){
    // Call getuserData() method of Page Model
    $userData['data'] = Page::getuserData();

    echo json_encode($userData);
    exit;
  }
}
