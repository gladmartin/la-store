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
            $table->string('invoice')->unique();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('nama');
            $table->string('email');
            $table->string('no_wa');
            $table->text('alamat');
            $table->json('variants')->nullable();
            $table->unsignedBigInteger('kuantitas');
            $table->string('status_order', 100);
            $table->string('status_pembayaran', 100);
            $table->string('bayar');
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
        Schema::dropIfExists('orders');
    }
}
