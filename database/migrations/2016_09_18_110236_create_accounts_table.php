<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('xero_id')->unique()->nullable();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('bank_account_number')->nullable();
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('bank_account_type')->nullable();
            $table->string('currency_code') -> nullable();
            $table->string('tax_type')->nullable();
            $table->boolean('is_system_account');
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
        Schema::dropIfExists('accounts');
    }
}
