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
        Schema::create('additionals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('additionable');
            $table->string('title')->default('Не вказано');
            $table->string('description',3000)->default('');
            $table->smallInteger('additional_type')->unsigned()->default(0)->comment('0 - file, 100 - URL, 101 - youtube');
            $table->string('link',3000)->default('')->comment('URL ресурса або шлах у ФС');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additionals');
    }
};
