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
        Schema::create('purchaseorderc', function (Blueprint $table) {
            $table->id();
            $table->double('discount');
            $table->date('pODate')->nullable();
            $table->integer('pONumber');
            $table->text('pOObservation')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->integer('supplierCode');
            $table->double('total');
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchaseorderc');
    }
};
