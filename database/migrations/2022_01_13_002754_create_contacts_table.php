<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact_number');
            // $table->foreignId('arena_id')->index()->nullable()->constrained()->onDelete('cascade');;
            $table->string('area_code');
            $table->foreign('area_code')->references('area_code')->on('arenas')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('contacts_area_code_foreign');
            $table->dropIndex('contacts_area_code_index');
            $table->dropColumn('area_code');
       });
   }
}
