<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('user_id');
            $table->string('uuid');

            $table->string('postcode');
            $table->string('type');
            $table->string('flat_no')->nullable();
            $table->string('house_name')->nullable();
            $table->string('house_no')->nullable();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('town');
            $table->string('county')->nullable();
            $table->string('country');
            $table->string('state')->nullable();
            $table->text('description')->nullable();
            $table->boolean('default');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
