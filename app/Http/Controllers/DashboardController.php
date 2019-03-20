<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Recurring;
use Auth;
use Bills;
use DB;

class DashboardController extends Controller {
  public function __invoke() {
    return view('dashboard');
  }

  public function testfunction(Illuminate\Http\Request $request) {
        if ($request->isMethod('post')) {
            return response()->json(['response' => 'This is post method']);
        }

        return response()->json(['response' => 'This is get method']);
    }
}
