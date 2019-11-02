<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cart_id')->nullable();
            $table->unsignedDecimal('amount');
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('customer_type')->index();
            $table->string('status', 40)->index();

            $table->timestamps();
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('RESTRICT')
                ->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
