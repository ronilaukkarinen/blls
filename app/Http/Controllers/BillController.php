<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Recurring;
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

    $bills = DB::table('bills')
    ->orderBy('duedate', 'asc')
    ->where('userid', Auth::user()->id)
    ->get();

    $subscriptions = DB::table('subscriptions')
    ->orderBy('active', 'desc')
    ->orderBy('date', 'asc')
    ->where('userid', Auth::user()->id)
    ->get();

    return view( 'dashboard', compact('balance', 'bills', 'subscriptions') );
  }

  // Add bill
  public function addBill(Request $request) {

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
      'type' => $request->type,
      'description' => $request->description,
      'amount' => $request->amount,
      'duedate' => $date_to_db,
      'created' => date('Y-m-d H:i:s'),
      'paid' => 0,
      'userid' => Auth::user()->id,
    ]);

    // Print results
    echo '<tr class="row-clickable">
    <td data-heading="Laskuttaja" class="row-biller biller_text">' . $request->biller . '</td>
    <td data-heading="Eräpäivä" class="formatted-duedate row-duedate duedate_text past">' . $request->duedate . '</td>
    <td data-heading="Summa" class="row-amount amount amount_text">€ <span class="formatted-amount">' . $request->amount . '</span></td>
    </tr>';
  }

  // Edit bill
  public function editBill(Request $request) {

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

    // Print results
    echo '<tr class="row-clickable">
    <td data-heading="Laskuttaja" class="row-biller biller_text">' . $request->biller . '</td>
    <td data-heading="Eräpäivä" class="formatted-duedate row-duedate duedate_text past">' . $request->duedate . '</td>
    <td data-heading="Summa" class="row-amount amount amount_text">€ <span class="formatted-amount">' . $request->amount . '</span></td>
    </tr>';
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

}
