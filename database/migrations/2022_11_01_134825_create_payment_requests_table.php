<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->date('request_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->string('upload', 199)->nullable();
            $table->unsignedBigInteger('request_by');
            $table->date('payment_date')->nullable();
            $table->unsignedBigInteger('method_id');
            $table->unsignedBigInteger('bank_id');
            $table->tinyInteger('status')->default(3)->comment('1=Paid, 2=Hold, 3=Unpaid');
            $table->unsignedBigInteger('approved_by');
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
        Schema::dropIfExists('payment_requests');
    }
};
