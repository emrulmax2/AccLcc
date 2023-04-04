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
        Schema::create('transaction_csv_datas', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 199);
            $table->date('trans_date')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('transaction_type')->nullable()->comment('0=Inflow, 1=Outflow');
            $table->unsignedBigInteger('bank_id');
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
        Schema::dropIfExists('transaction_csv_datas');
    }
};
