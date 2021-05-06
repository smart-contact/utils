<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScApiHttpLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_api_http_logs', function (Blueprint $table) {
            $table->id();
            $table->string('request_referer')->nullable();
            $table->string('request_method')->nullable();
            $table->json('request_header')->nullable();
            $table->json('request')->nullable();
            $table->string('response_code')->nullable();
            $table->json('response')->nullable();
            $table->timestamp('request_at')->useCurrent();
            $table->timestamp('response_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sc_api_http_logs');
    }

    public function timestamps()
    {
        $this->timestamp('request_at');
        $this->timestamp('response_at');
    }
}
