<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

    public function up() {
        Schema::create(
            'tags',
            function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'space_id' )->unsigned();
            $table->string( 'name' );
            $table->timestamps();
            $table->softDeletes();
        }
      );
    }

    public function down() {
        Schema::dropIfExists( 'tags' );
    }
}
