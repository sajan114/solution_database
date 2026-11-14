<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // A product can solve a solution completely or only in part.
    public function up(): void
    {
        Schema::table('product_solution', function (Blueprint $table) {
            $table->boolean('is_partial')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('product_solution', function (Blueprint $table) {
            $table->dropColumn('is_partial');
        });
    }
};
