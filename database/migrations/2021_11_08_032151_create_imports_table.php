<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->string('arena_name');
            $table->string('date_of_soa');
            $table->string('date_of_event');
            $table->string('total_meron_wala_bets');
            $table->string('total_cancelled_bets');
            $table->string('total_draw_bets');
            $table->string('total_payout_paid');
            $table->string('total_CD_paid');
            $table->string('total_draw_paid');
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
        Schema::dropIfExists('imports');
    }
}
