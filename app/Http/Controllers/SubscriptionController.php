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

    // Get day from inserted date
    $date_inserted = new \DateTime($request->subscription_month_day);
    $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
    $timestamp_day = $date_inserted->format('d');
    $timestamp_month = $date_inserted->format('m');

    // If day has passed, let's get next month
    if ( date( 'd' ) > $timestamp_day && $timestamp_month == date( 'm' ) ) :
      $relative_month = date( 'm', strtotime('+1 month') );
    else :
      $relative_month = $timestamp_month;
    endif;

    $timestamp = $date_inserted->format('Y-' . $relative_month . '-d') . ' 00:00:00';

    // Define stuff that we will add to the database
    DB::table('subscriptions')
    ->insert([
      'biller' => $request->subscription_biller,
      'amount' => $request->subscription_amount,
      'day' => $timestamp_day,
      'date' => $timestamp,
      'plan' => $request->subscription_plan,
      'created' => date('Y-m-d H:i:s'),
      'active' => 1,
      'userid' => Auth::id(),
    ]);

    /// Variables
    $old_date_timestamp = strtotime( $timestamp );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $request->subscription_amount );
    $subscription_biller = strtolower( $request->subscription_biller );

    // Print results
    echo '<div class="item item-' . $subscription_biller . '">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$subscription_biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->subscription_biller . '</span>
          <span class="type">' . $request->subscription_plan . '</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->subscription_amount . '</span></li>
          <li class="subscription-due"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

  // Edit Subscription
  public function editSubscription(Request $request) {

    // Get day from inserted date
    $date_inserted = new \DateTime($request->subscription_month_day);
    $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
    $timestamp_day = $date_inserted->format('d');
    $timestamp_month = $date_inserted->format('m');

    // If day has passed, let's get next month
    if ( date( 'd' ) > $timestamp_day && $timestamp_month == date( 'm' ) ) :
      $relative_month = date( 'm', strtotime('+1 month') );
    else :
      $relative_month = $timestamp_month;
    endif;

    $timestamp = $date_inserted->format('Y-' . $relative_month . '-d') . ' 00:00:00';

    // Define stuff that we will edit
    DB::table('subscriptions')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->update([
      'biller' => $request->subscription_biller,
      'amount' => $request->subscription_amount,
      'day' => $timestamp_day,
      'date' => $timestamp,
      'plan' => $request->subscription_plan,
      'userid' => Auth::id(),
    ]);

    /// Variables
    $old_date_timestamp = strtotime( $timestamp );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $request->subscription_amount );
    $subscription_biller = strtolower( $request->subscription_biller );

    // Print results
    echo '<div class="item item-' . $subscription_biller . '">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$subscription_biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->subscription_biller . '</span>
          <span class="type">' . $request->subscription_plan . '</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->subscription_amount . '</span></li>
          <li class="subscription-due"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

  // Cancel Subscription
  public function handleSubscription(Request $request) {

    // Get day from inserted date
    $date_inserted = new \DateTime($request->subscription_month_day);
    $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
    $timestamp_day = $date_inserted->format('d');
    $timestamp_month = $date_inserted->format('m');

    // If day has passed, let's get next month
    if ( date( 'd' ) > $timestamp_day && $timestamp_month == date( 'm' ) ) :
      $relative_month = date( 'm', strtotime('+1 month') );
    else :
      $relative_month = $timestamp_month;
    endif;

    $timestamp = $date_inserted->format('Y-' . $relative_month . '-d') . ' 00:00:00';

    // Define stuff that we will edit
    DB::table('subscriptions')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->update([
      'biller' => $request->subscription_biller,
      'amount' => $request->subscription_amount,
      'day' => $timestamp_day,
      'date' => $timestamp,
      'plan' => $request->subscription_plan,
      'userid' => Auth::id(),
      'active' => $request->subscription_active,
    ]);

    /// Variables
    $old_date_timestamp = strtotime( $timestamp );
    $formatted_date = date( 'd.m.Y', $old_date_timestamp );
    $stylish_date = date( 'd/m/Y', $old_date_timestamp );
    setlocale( LC_TIME, "fi_FI" );
    $formatted_amount = str_replace( '.', ',', $request->subscription_amount );
    $subscription_biller = strtolower( $request->subscription_biller );

    // Print results
    if ( 0 == $request->subscription_active ) : $activeclass = ' inactive'; else : $activeclass = ' active'; endif;
    echo '<div class="item item-' . $subscription_biller . '' . $activeclass . '">
    <div class="logo">
      ' . file_get_contents( "svg/subscriptions/{$subscription_biller}.svg" ) . '

        <div class="details">
          <span class="biller">' . $request->subscription_biller . '</span>
          <span class="type">' . $request->subscription_plan . '</span>
        </div>
      </div>

      <div class="content">
        <ul>
          <li class="amount"><span class="value">€ ' . $request->subscription_amount . '</span></li>
          <li class="subscription-due"><span class="value">' . $stylish_date . '</span></li>
        </ul>
      </div>
    </div>';
  }

}
