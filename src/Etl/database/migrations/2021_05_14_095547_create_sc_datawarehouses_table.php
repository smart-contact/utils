<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScDatawarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_datawarehouses', function (Blueprint $table) {
            $table->id();
            $table->string('datawarehouse');
            $table->string('table');
            $table->jsonb('data');
            $table->boolean('inserted')->default(false);
            $table->timestamps();

            $table->index(['inserted']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_datawarehouses');
    }
}
