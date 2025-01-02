<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditcardsTable extends Migration
{
  public function up()
  {
    Schema::create('creditcards', function (Blueprint $table) {
      $table->id();
      $table->foreignId('userid');
      $table->string('creditor');
      $table->string('expirationdate');
      $table->string('lastfourdigits');
      $table->decimal('monthlyamount', 10, 2);
      $table->decimal('amount_paid', 10, 2);
      $table->decimal('amount_total', 10, 2);
      $table->datetime('created');
    });
  }

  public function down()
  {
    Schema::dropIfExists('creditcards');
  }
}
