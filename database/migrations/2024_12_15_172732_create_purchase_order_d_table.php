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
        Schema::create('purchaseorderd', function (Blueprint $table) {
            $table->id();
            $table->double('deliveredQuantity')->nullable();
            $table->double('discountPercent');
            $table->date('pODateDelivery')->nullable();
            $table->integer('pONumber');
            $table->string('productCode');
            $table->string('productFamily');
            $table->string('productUnit');
            $table->double('quantity')->nullable();
            $table->double('sellingPrice')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->integer('taxRateCode');
            $table->double('unitPrice')->nullable();
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
        Schema::dropIfExists('purchaseorderd');
    }
};
