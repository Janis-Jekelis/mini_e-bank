<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_account_id');
            $table->string('name');
            $table->decimal('amount');
            $table->decimal('open_rate');
            $table->timestamps();
            $table->foreign('investment_account_id')
                ->references('id')
                ->on('investment_accounts')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
