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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->text('title');
            $table->text('slug');
            $table->text('deskripsi');
            $table->unsignedBigInteger('stok');
            $table->string('harga', 100);
            $table->string('diskon', 100)->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('berat')->nullable();
            $table->string('kondisi')->default('baru');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('terjual')->default(0);
            $table->text('url_sumber')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
