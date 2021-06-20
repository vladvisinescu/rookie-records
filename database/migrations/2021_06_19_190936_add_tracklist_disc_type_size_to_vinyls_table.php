<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTracklistDiscTypeSizeToVinylsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vinyls', function (Blueprint $table) {
            $table->text('tracklist')->nullable();
            $table->string('type')->nullable(); // album, single etc
            $table->string('size')->nullable(); // 12, 10, 7 etc
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vinyls', function (Blueprint $table) {
            $table->removeColumn('tracklist');
            $table->removeColumn('type');
            $table->removeColumn('size');
        });
    }
}
