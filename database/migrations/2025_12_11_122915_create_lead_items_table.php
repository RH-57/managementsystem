<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->string('item_name');
            $table->integer('qty')->default(1);
            $table->text('notes')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();
            $table->enum('status', [
                'waiting',
                'analyzing',
                'need_revision',
                'finalized'
            ])->default('waiting');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_items');
    }
};
