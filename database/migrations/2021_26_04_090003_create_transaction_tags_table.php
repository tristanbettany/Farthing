<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTagsTable extends Migration
{
    public function up(): void
    {
        Schema::create('transactions_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('tag_id');

            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('transactions_tags');
    }
}
