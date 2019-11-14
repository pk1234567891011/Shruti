<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('shipping_method');
            $table->string('AWB_NO',100);
            $table->integer('transcation_id');
            $table->string('status');
            $table->float('grand_total',12,2);
            $table->float('shipping_charges',12,2);
            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupon');
            $table->string('billing_address',100);
            $table->string('billing_city',45);
            $table->string('billing_state',45);
            $table->string('billing_country',45);
            $table->string('billing_pincode',45);
            $table->string('shipping_address',100);
            $table->string('shipping_city',45);
            $table->string('shipping_state',45);
            $table->string('shipping_country',45);
            $table->string('shipping_pincode',45);
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
        Schema::dropIfExists('user_order');
    }
}
