<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
  public function up()
  {
    Schema::create('bills', function (Blueprint $table) {
      $table->id();
      $table->string('biller');
      $table->string('billnumber')->nullable();
      $table->string('virtualcode')->nullable();
      $table->string('refnumber');
      $table->string('accountnumber');
      $table->string('description')->nullable();
      $table->decimal('amount', 10, 2);
      $table->datetime('duedate');
      $table->datetime('created');
      $table->boolean('paid')->default(0);
      $table->datetime('datepaid')->nullable();
      $table->foreignId('userid');
      $table->string('type')->nullable();
    });
  }

  public function down()
  {
    Schema::dropIfExists('bills');
  }
}
