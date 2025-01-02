<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecurringsTable extends Migration {

    public function up() {
        Schema::create(
            'recurrings',
            function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'space_id' )->unsigned();
            $table->integer( 'tag_id' )->unsigned()->nullable();
            $table->string( 'type' );
            $table->integer( 'day' );
            $table->date( 'starts_on' );
            $table->date( 'ends_on' )->nullable();
            $table->string( 'description' );
            $table->decimal( 'amount', 10, 2 );
            $table->timestamps();
            $table->softDeletes();
        }
            );
    }

    public function down() {
        Schema::dropIfExists( 'recurrings' );
    }
}
