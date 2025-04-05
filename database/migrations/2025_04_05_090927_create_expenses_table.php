<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('expense_type'); // Type of expense
            $table->string('description'); // Description of the expense
            $table->decimal('amount', 10, 2); // Amount spent
            $table->date('date'); // Date of expense
            $table->string('category'); // Category (e.g., Farm, Ecommerce)
            $table->text('notes')->nullable(); // Additional notes (optional)
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
