<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
use Auth;
use DB;
use Response;

class PaymentplanController extends Controller {

  // Add payment plan
  public function addPaymentplan(Request $request) {

    // Define stuff that we will add to the database
    DB::table('paymentplans')
    ->insert([
      'userid' => Auth::id(),
      'name' => $request->paymentplan_name,
      'months_paid' => $request->paymentplan_months_paid,
      'months_total' => $request->paymentplan_months_total,
      'created' => date('Y-m-d H:i:s'),
    ]);

    // Percents and colors
    $percent = round( ( $request->paymentplan_months_paid / $request->paymentplan_months_total ) * 100 );

    if ( $percent < 40 ) :
      $percent_class = ' low';
    elseif ( $percent > 40 ) :
      $percent_class = ' medium';
    else :
      $percent_class = ' high';
    endif;

    // Print results
    echo '<div class="items items-playmentplans">

    <div class="item">
    <h2>' . $request->paymentplan_name . '</h2>

    <div class="progress-bar">
      <div class="progress' . $percent_class . '" style="width: ' . $percent . '%;">
      <p>' . $request->paymentplan_months_paid . ' paid of total ' . $request->paymentplan_months_total . ' rounds. (' . $percent . '%)</p>
      </div>
    </div>
    </div>';
  }

  // Edit payment plan
  public function editPaymentplan(Request $request) {

    // Define stuff that we will add to the database
    DB::table('paymentplans')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->update([
      'name' => $request->paymentplan_name,
      'months_paid' => $request->paymentplan_months_paid,
      'months_total' => $request->paymentplan_months_total,
    ]);

    // Percents and colors
    $percent = round( ( $request->paymentplan_months_paid / $request->paymentplan_months_total ) * 100 );

    if ( $percent < 40 ) :
      $percent_class = ' low';
    elseif ( $percent > 40 ) :
      $percent_class = ' medium';
    else :
      $percent_class = ' high';
    endif;

    // Print results
    echo '<div class="items items-playmentplans">

    <div class="item item-' . $request->id . '" data-id="' . $request->id . '">
    <h2>' . $request->paymentplan_name . '</h2>

    <div class="progress-bar">
      <div class="progress' . $percent_class . '" style="width: ' . $percent . '%;">
      <p>' . $request->paymentplan_months_paid . ' paid of total ' . $request->paymentplan_months_total . ' rounds. (' . $percent . '%)</p>
      </div>
    </div>
    </div>';
  }

}
