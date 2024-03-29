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
            $table->integer('address_id');
            $table->string('stripe_id')->nullable();
            $table->string('transaction_id');
            $table->integer ('total')->default(0);
            $table->timestamp('payed_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();

            $table->string('order_id');
            $table->string('product_id');
            $table->integer('quantity')->default(1);
            $table->string('meta')->nullable();
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
