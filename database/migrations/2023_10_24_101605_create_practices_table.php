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
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('journal_id')->unsigned();
            $table->bigInteger('lesson_id')->unsigned();
            $table->date('practice_date_start')->nullable();
            $table->date('practice_date_end')->nullable();
            $table->string('title',512)->default('Тема не вказана');
            $table->smallInteger('max_grade')->default(-2);
            $table->smallInteger('practice_type')->default(11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practices');
    }
};
