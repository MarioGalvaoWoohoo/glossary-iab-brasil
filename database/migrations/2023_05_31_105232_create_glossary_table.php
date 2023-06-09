<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlossaryTable extends Migration
{
    public function up()
    {
        Schema::create('glossary', function (Blueprint $table) {
            $table->id();

            $table->integer('metric');
            $table->string('topic');
            $table->string('subtopic');
            $table->text('content');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('glossary');
    }
}
