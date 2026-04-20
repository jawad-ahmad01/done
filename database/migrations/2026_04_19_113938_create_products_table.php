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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Core Product Data
            $table->string('name');
            $table->string('sku')->unique(); // Unique identifier for inventory
            $table->text('description')->nullable();
            
            // Pricing and Inventory
            $table->decimal('price', 10, 2); // Supports up to 99,999,999.99
            $table->integer('stock')->default(0);
            
            // Classification
            $table->string('category');
            $table->string('status')->default('active'); // e.g., active, draft, archived
            
            $table->timestamps();
            $table->softDeletes(); // Optional: keeps record in DB but "deletes" from UI
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};