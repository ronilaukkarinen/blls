<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use Validator;
use Auth;
use DB;
use Response;

class BillController extends Controller {

  // Get total amount of bills that are not paid
  public function showBills() {

    $balance = DB::table('bills')
    ->where('userid', Auth::user()->id)
    ->where('paid', '0')
    ->sum('amount');

    $balance_overdue = DB::table('bills')
    ->where('userid', Auth::user()->id)
    ->where('paid', '0')
    ->where('duedate', '<=', date('Y-m-d H:i:s') )
    ->sum('amount');

    $balance_subscriptions = DB::table('subscriptions')
    ->where('userid', Auth::user()->id)
    ->where('active', '1')
    ->sum('amount');

    $bills = DB::table('bills')
    ->orderBy('duedate', 'asc')
    ->where('userid', Auth::user()->id)
    ->get();

    $subscriptions = DB::table('subscriptions')
    ->orderBy('active', 'desc')
    ->orderBy('date', 'asc')
    ->where('userid', Auth::user()->id)
    ->get();

    $paymentplans = DB::table('paymentplans')
    ->where('userid', Auth::user()->id)
    ->get();

    $creditcards = DB::table('creditcards')
    ->where('userid', Auth::user()->id)
    ->get();

    return view( 'dashboard', compact( 'balance', 'balance_overdue', 'balance_subscriptions', 'bills', 'subscriptions', 'paymentplans', 'creditcards' ) );
  }

  // Add bill
  public function addBill(Request $request) {
    $validator = Validator::make($request->all(), [
      'biller' => 'required|nullable|max:100|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!?\/ ]*$/',
      'billnumber' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'virtualcode' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'refnumber' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'accountnumber' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'description' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!?\/ ]*$/',
      'amount' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'duedate' => 'required|nullable|date|date_format:"d.m.Y"|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
    ]);

    if ( $validator->passes() ) {

      // Let's format the date
      $date_to_db = date( 'Y-m-d H:i:s', strtotime( $request->duedate ) );

      // Define stuff that we will add to the database
      DB::table('bills')
      ->insert([
        'biller' => $request->biller,
        'billnumber' => $request->billnumber,
        'virtualcode' => $request->virtualcode,
        'refnumber' => $request->refnumber,
        'accountnumber' => $request->accountnumber,
        'description' => $request->description,
        'amount' => $request->amount,
        'duedate' => $date_to_db,
        'created' => date('Y-m-d H:i:s'),
        'paid' => 0,
        'userid' => Auth::user()->id,
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

  // Edit bill
  public function editBill(Request $request) {

    $validator = Validator::make($request->all(), [
      'biller' => 'required|nullable|max:100|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!?\/ ]*$/',
      'billnumber' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'virtualcode' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'refnumber' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'accountnumber' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'type' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9\-,.!? ]*$/',
      'description' => 'nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!?\/ ]*$/',
      'amount' => 'required|nullable|max:255|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
      'duedate' => 'required|nullable|date|date_format:"d.m.Y"|regex:/^[a-zA-ZäöåÄÖÅ0-9,.!? ]*$/',
    ]);

    if ( $validator->passes() ) {

      // Let's format the date
      $date_to_db = date( 'Y-m-d H:i:s', strtotime( $request->duedate ) );

      // Define stuff that we will edit
      DB::table('bills')
      ->where('userid', Auth::user()->id)
      ->where('id', $request->id)
      ->where('paid', '0')
      ->update([
        'biller' => $request->biller,
        'billnumber' => $request->billnumber,
        'virtualcode' => $request->virtualcode,
        'refnumber' => $request->refnumber,
        'accountnumber' => $request->accountnumber,
        'type' => $request->type,
        'description' => $request->description,
        'amount' => $request->amount,
        'duedate' => $date_to_db,
        'userid' => Auth::user()->id,
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

  // Mark bill as paid
  public function markasPaid(Request $request) {

    // Update the bill in question
    DB::table('bills')
      ->where('userid', Auth::user()->id)
      ->where('id', $request->id)
      ->where('paid', '0')
      ->update([
        'paid' => 1,
        'datepaid' => date('Y-m-d H:i:s')
    ]);
  }

  // Mark bill as unpaid
  public function markasunPaid(Request $request) {

    // Update the bill in question
    DB::table('bills')
      ->where('userid', Auth::user()->id)
      ->where('id', $request->id)
      ->where('paid', '1')
      ->update([
        'paid' => 0,
    ]);
  }

  // Remove bill
  public function removeBill(Request $request) {
    DB::table('bills')
    ->where('userid', Auth::user()->id)
    ->where('id', $request->id)
    ->delete();
  }

}
