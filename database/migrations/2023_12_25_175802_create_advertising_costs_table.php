<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name');

            $table->decimal('january', 10, 2)->index()->nullable();
            $table->decimal('february', 10, 2)->index()->nullable();
            $table->decimal('march', 10, 2)->index()->nullable();
            $table->decimal('april', 10, 2)->index()->nullable();
            $table->decimal('may', 10, 2)->index()->nullable();
            $table->decimal('june', 10, 2)->index()->nullable();
            $table->decimal('july', 10, 2)->index()->nullable();
            $table->decimal('august', 10, 2)->index()->nullable();
            $table->decimal('september', 10, 2)->index()->nullable();
            $table->decimal('october', 10, 2)->index()->nullable();
            $table->decimal('november', 10, 2)->index()->nullable();
            $table->decimal('december', 10, 2)->index()->nullable();
            $table->decimal('total', 10, 2)->index()->nullable();

            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs');
    }
};
