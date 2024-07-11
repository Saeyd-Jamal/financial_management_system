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
        Schema::create('nature_work_increases', function (Blueprint $table) {
            $table->id();
            $table->string('nature_work')->comment('طبيعة العمل');
            $table->string('scientific_qualification')->comment('المؤهل العلمي');
            $table->smallInteger('percentage')->default(0)->comment('النسبة');
            $table->unique(['nature_work', 'scientific_qualification'],'unique_nature_work_increases');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nature_work_increases');
    }
};
