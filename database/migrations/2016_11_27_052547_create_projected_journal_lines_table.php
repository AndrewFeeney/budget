<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectedJournalLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projected_journal_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('projected_journal_id');
            $table->foreign('projected_journal_id')->references('id')->on('projected_journals');
            $table->unsignedInteger('account_xero_id');
            $table->foreign('account_xero_id')->references('xero_id')->on('accounts');
            $table->float('net_amount');
            $table->float('gross_amount');
            $table->float('tax_amount');
            $table->string('tax_type')->nullable();
            $table->string('account_type');
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
        Schema::dropIfExists('projected_journal_lines');
    }
}
