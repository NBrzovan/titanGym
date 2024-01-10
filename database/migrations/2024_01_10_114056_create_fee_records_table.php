<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeRecords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clientID')->constrained('client');
            $table->date('dateOfPayment');
            $table->date('dateExpiry');
            $table->decimal('membershipFee', 8, 2);
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
        Schema::dropIfExists('feeRecords');
    }
}
