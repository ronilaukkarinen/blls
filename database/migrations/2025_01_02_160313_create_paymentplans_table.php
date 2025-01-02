<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentplansTable extends Migration
{
  public function up()
  {
    Schema::create('paymentplans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('userid');
      $table->string('name');
      $table->integer('months_paid');
      $table->integer('months_total');
      $table->datetime('created');
      $table->boolean('paid')->default(0);
      $table->datetime('datepaid')->nullable();
    });
  }

  public function down()
  {
    Schema::dropIfExists('paymentplans');
  }
}
