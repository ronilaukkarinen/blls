<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
use Auth;
use DB;
use Response;

class SubscriptionController extends Controller {

  // Add subscription
  public function addSubscription(Request $request) {

    // Let's format the date
    $date_to_db = date( 'Y-m-d H:i:s', strtotime( $request->duedate_subscription ) );

    // Define stuff that we will add to the database
    DB::table('subscriptions')
    ->insert([
      'biller' => $request->biller_subscription,
      'amount' => $request->amount_subscription,
      'date' => $date_to_db,
      'plan' => $request->plan_subscription,
      'created' => date('Y-m-d H:i:s'),
      'active' => 1,
      'userid' => Auth::id(),
    ]);

    /// Variables
    $old_date = $request->duedate_subscription;
    $old_date_timestamp = strtotime( $old_date );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $request->amount_subscription );
    $biller = strtolower( $request->biller_subscription );

    // Print results
    echo '<div class="item item-' . $biller . '">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->biller_subscription . '</span>
          <span class="type">' . $request->plan_subscription . '</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->amount_subscription . '</span></li>
          <li class="subscription-due"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

  // Edit Subscription
  public function editSubscription(Request $request) {

    // Let's format the date
    $date_to_db = date( 'Y-m-d H:i:s', strtotime( $request->duedate_subscription ) );

    // Define stuff that we will edit
    DB::table('subscriptions')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->update([
      'biller' => $request->biller_subscription,
      'amount' => $request->amount_subscription,
      'date' => $date_to_db,
      'plan' => $request->plan_subscription,
      'userid' => Auth::id(),
    ]);

    /// Variables
    $old_date = $request->duedate_subscription;
    $old_date_timestamp = strtotime( $old_date );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $request->amount_subscription );
    $biller = strtolower( $request->biller_subscription );

    // Print results
    echo '<div class="item item-' . $biller . '">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->biller_subscription . '</span>
          <span class="type">' . $request->plan_subscription . '</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->amount_subscription . '</span></li>
          <li class="subscription-due"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

  // Cancel Subscription
  public function cancelSubscription(Request $request) {

    // Let's format the date
    $date_to_db = date( 'Y-m-d H:i:s', strtotime( $request->duedate_subscription ) );

    // Define stuff that we will edit
    DB::table('subscriptions')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->update([
      'biller' => $request->biller_subscription,
      'amount' => $request->amount_subscription,
      'date' => $date_to_db,
      'plan' => $request->plan_subscription,
      'userid' => Auth::id(),
      'active' => '0',
    ]);

    /// Variables
    $old_date = $request->duedate_subscription;
    $old_date_timestamp = strtotime( $old_date );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $request->amount_subscription );
    $biller = strtolower( $request->biller_subscription );

    // Print results
    echo '<div class="item item-' . $biller . ' inactive">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->biller_subscription . '</span>
          <span class="type">' . $request->plan_subscription . '</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->amount_subscription . '</span></li>
          <li class="subscription-due"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

}
