<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('name');
            $table->float('amount');
            $table->integer('occurances');
            $table->string('occurance_syntax');
            $table->boolean('is_active');

            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('templates');
    }
}
