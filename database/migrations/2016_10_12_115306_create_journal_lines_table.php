<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('xero_id')->unique();
            $table->integer('journal_id')->unsigned();
            $table->foreign('journal_id')->references('id')->on('journals');
            $table->string('account_xero_id');
            $table->string('account_type');
            $table->string('account_name');
            $table->string('description')->nullable();
            $table->float('net_amount');
            $table->float('gross_amount');
            $table->float('tax_amount');
            $table->string('tax_type')->nullable();
            $table->string('tax_name')->nullable();
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
        Schema::dropIfExists('journal_lines');
    }
}
