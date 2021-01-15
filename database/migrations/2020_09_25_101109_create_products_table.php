<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('slug');
            $table->string('uuid');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('product_type');
            $table->string('price');
            $table->integer('user_id');

            $table->string('status')->nullable();

            $table->timestamp('published_at')->nullable();
            $table->timestamp('sold_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('vinyls', function (Blueprint $table) {
            $table->id();

            $table->integer('product_id')->nullable();
            $table->integer('discogs_id')->nullable();
            $table->string('title')->nullable();
            $table->string('year')->limit(4)->nullable();
            $table->string('country')->nullable();
            $table->string('grading')->nullable();
            $table->text('description')->nullable();
            $table->text('discogs_image_url')->nullable();

            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::create('vinyl_genre', function (Blueprint $table) {
            $table->integer('vinyl_id');
            $table->integer('genre_id');
        });

        Schema::create('labels', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->string('discogs_id')->nullable();
            $table->string('api_url')->nullable();
            $table->string('web_url')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::create('vinyl_label', function (Blueprint $table) {
            $table->integer('vinyl_id');
            $table->integer('label_id');
        });

        Schema::create('artists', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->string('discogs_id')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });

        Schema::create('vinyl_artist', function (Blueprint $table) {
            $table->integer('vinyl_id');
            $table->integer('artist_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Main Models
        Schema::dropIfExists('products');
        Schema::dropIfExists('vinyls');

        // Details
        Schema::dropIfExists('genres');
        Schema::dropIfExists('vinyl_genre');

        Schema::dropIfExists('labels');
        Schema::dropIfExists('vinyl_label');

        Schema::dropIfExists('artists');
        Schema::dropIfExists('vinyl_artist');
    }
}
