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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code');
            $table->date('transaction_date');
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('method_id');
            $table->tinyInteger('transaction_type')->nullable()->comment('0=Inflow, 1=Outflow');
            $table->text('detail')->nullable();
            $table->text('description')->nullable();
            $table->decimal('transaction_amount', 10, 2);
            $table->string('transaction_doc_name')->nullable();

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
