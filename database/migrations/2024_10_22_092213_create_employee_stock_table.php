<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeStockTable extends Migration
{
    public function up()
    {
        Schema::create('employee_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->integer('assigned_quantity'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_stock');
    }
}