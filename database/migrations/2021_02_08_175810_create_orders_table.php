<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('user_id');
            $table->string('transaction_id');
            $table->integer ('total')->default(0);
            $table->timestamp('payed_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('total')->nullable();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();

            $table->integer('product_id');
            $table->integer('order_id');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
    }
}
