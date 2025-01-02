<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsTable extends Migration {

    public function up() {
        Schema::create(
            'earnings',
            function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'space_id' )->unsigned();
            $table->date( 'happened_on' );
            $table->string( 'description' );
            $table->decimal( 'amount', 10, 2 );
            $table->timestamps();
            $table->softDeletes();
        }
            );
    }

    public function down() {
        Schema::dropIfExists( 'earnings' );
    }
}
