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

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_id')->constrained(table: 'user_addresses')->onDelete('cascade');
            $table->foreignId('coupon_id')->constrained()->onDelete('cascade');

            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('delivery_amount')->default(0);
            $table->unsignedInteger('coupon_amount')->default(0);
            $table->unsignedInteger('paying_amount');
            $table->enum('payment_type' , ['online' , 'cash' , 'shabaNumber' , 'cardToCard' , 'pos']);
            $table->tinyInteger('payment_status')->default(0);
            $table->text('description')->nullable();

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
