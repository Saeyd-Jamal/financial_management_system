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
        Schema::table('exchanges', function (Blueprint $table) {
            $table->decimal('receivables_addition', 10, 2)->default(0)->after('receivables_discount');
            $table->decimal('savings_addition', 10, 2)->default(0)->after('savings_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exchanges', function (Blueprint $table) {
            $table->dropColumn('receivables_addition');
            $table->dropColumn('savings_addition');
        });
    }
};
