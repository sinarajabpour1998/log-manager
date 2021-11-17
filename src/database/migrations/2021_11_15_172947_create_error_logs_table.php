<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id")->default(0)->comment("table:users, column:id");
            $table->string("ip");
            $table->string("os")->nullable();
            $table->string("browser")->nullable();
            $table->text("error_message");
            $table->string("error_code");
            $table->text("target_file");
            $table->string("target_line");
            $table->text("error_trace");
            $table->tinyInteger("seen")->default(0);
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
        Schema::dropIfExists('error_logs');
    }
}
