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
        Schema::create('Supplier', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->unique();
            $table->string('name');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('town')->nullable();
            $table->string('postalCode')->nullable();
            $table->tinyInteger('status')->default();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('supplier');
    }
};
