<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
  public function up()
  {
    Schema::create('subscriptions', function (Blueprint $table) {
      $table->id();
      $table->string('biller');
      $table->decimal('amount', 10, 2);
      $table->integer('day');
      $table->datetime('date');
      $table->string('plan')->nullable();
      $table->datetime('created');
      $table->boolean('active')->default(1);
      $table->foreignId('userid');
    });
  }

  public function down()
  {
    Schema::dropIfExists('subscriptions');
  }
}
