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
        Schema::table('orders', function (Blueprint $table) {
             // Drop foreign key and remove columns
             $table->dropForeign(['product_id']);
             $table->dropColumn(['product_id', 'count', 'total']);
 
             $table->decimal('grand_total', 10, 2)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->after('user_id');
            $table->integer('count')->after('product_id');
            $table->decimal('total', 10, 2)->after('count');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->dropColumn('grand_total');
        });
    }
};
