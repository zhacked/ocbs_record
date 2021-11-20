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
            $table->string('meron');
            $table->string('wala');
            $table->string('total_meron_wala');
            $table->string('total_payout_paid');
            $table->string('unclaimed');
            $table->string('rake');
            $table->string('draw_cancelled');
            $table->string('draw_cancelled_paid');
            $table->string('draw_paid');
            $table->string('draw_unpaid');
            $table->string('cancelled_unpaid');
            $table->string('draw');
            $table->string('draw_unclaimed');
            $table->string('draw_gain_loss');
            $table->string('draw_2_percent');
            $table->string('type');
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
