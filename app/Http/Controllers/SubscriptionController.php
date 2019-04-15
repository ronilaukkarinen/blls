<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use Validator;
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

    $validator = Validator::make($request->all(), [
      'subscription_biller' => 'nullable|max:100|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!?\/ ]*$/',
      'subscription_amount' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'subscription_month_day' => 'required|nullable|date|date_format:"d.m.Y"|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'subscription_plan' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!?\/\$ ]*$/',
    ]);

    if ( $validator->passes() ) {

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

      return response()->json([
        'success' => 'true',
      ]);

    } else {

      // If validator didn't pass
      return response()->json([
        'errors' => $validator->errors()->keys()
      ]);

    }
  }

  // Edit Subscription
  public function editSubscription(Request $request) {

    // Get day from inserted date
    $date_inserted = new \DateTime($request->subscription_month_day);
    $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
    $timestamp_day = $date_inserted->format('d');
    $timestamp_month = $date_inserted->format('m');

    $validator = Validator::make($request->all(), [
      'subscription_biller' => 'nullable|max:100|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!?\/ ]*$/',
      'subscription_amount' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'subscription_month_day' => 'required|nullable|date|date_format:"d.m.Y"|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'subscription_plan' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!?\/\$ ]*$/',
    ]);

    if ( $validator->passes() ) {

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

    } else {

      // If validator didn't pass
      return response()->json([
        'errors' => $validator->errors()->keys()
      ]);

    }
  }

  // Edit Subscription
  public function updateSubscriptionDate(Request $request) {

    // Get day from inserted date
    $date_inserted = new \DateTime($request->subscription_date);
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
      'date' => $timestamp,
    ]);
  }

  // Remove Subscription
  public function removeSubscription(Request $request) {
    DB::table('subscriptions')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->delete();
  }

  // Cancel Subscription
  public function handleSubscription(Request $request) {

    // Get day from inserted date
    $date_inserted = new \DateTime($request->subscription_month_day);
    $timestamp = $date_inserted->format('Y-m-d') . ' 00:00:00';
    $timestamp_day = $date_inserted->format('d');
    $timestamp_month = $date_inserted->format('m');

    $validator = Validator::make($request->all(), [
      'subscription_biller' => 'nullable|max:100|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!?\/ ]*$/',
      'subscription_amount' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'subscription_month_day' => 'required|nullable|date|date_format:"d.m.Y"|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'subscription_plan' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!?\/\$ ]*$/',
      'subscription_active' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
    ]);

    if ( $validator->passes() ) {

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

      return response()->json([
        'success' => 'true',
      ]);

    } else {

      // If validator didn't pass
      return response()->json([
        'errors' => $validator->errors()->keys()
      ]);

    }
  }
}
