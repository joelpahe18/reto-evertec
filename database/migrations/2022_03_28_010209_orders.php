<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
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
            $table->string('customer_name');
            $table->string('customer_surname');
            $table->string('customer_email');
            $table->string('customer_mobile');
            $table->integer('payment_requestId')->unique();
            $table->integer('payment_internalReference')->nullable();
            $table->string('payment_status', 18)->nullable();
            $table->string('payment_message', 200)->nullable();
            $table->string('payment_date', 200);
            $table->string('payment_reference', 30);
            $table->string('payment_description', 200);
            $table->string('payment_currency', 3);
            $table->decimal('payment_total', 18, 2);
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
