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
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('fname');
            $table->string('lname');
            $table->string('sex');
            $table->string('hometown');
            $table->string('phone');
            $table->text('address',180);
            $table->string('occupation');
            $table->date('dob');
            $table->string('email')->unique();
            $table->string('bank');
            $table->string('accno');
            $table->string('passport');
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
