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
        Schema::create('work_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('working_status',['نعم','لا'])->comment('حالة الدوام');
            $table->string('type_appointment')->comment('نوع التعين');
            $table->string('field_action')->comment('مجال العمل');
            $table->smallInteger('allowance')->default(0)->comment('العلاوة في سلم الرواتب');
            $table->string('grade',3)->default(10)->comment('الدرجة في سلم الرواتب');
            $table->smallInteger('grade_allowance_ratio')->default(0)->comment('نسبة علاوة درجة');
            $table->string('government_official')->comment('موظف حكومة')->nullable();
            $table->enum('dual_function',['موظف','غير موظف'])->comment('مزدوج الوظيفة');
            $table->integer('years_service')->nullable()->comment('سنوات الخدمة');
            $table->string('nature_work')->comment('طبيعة العمل');
            $table->string('state_effectiveness')->comment('حالة الفعالية');
            $table->string('association')->comment('جمعية');
            $table->string('workplace');
            $table->string('section');
            $table->string('dependence')->comment('التبعية');
            $table->date('working_date')->comment('تاريخ العمل');
            $table->date('date_installation')->comment('تاريخ التثبيت');
            $table->date('date_retirement')->comment('تاريخ التقاعد');
            $table->string('payroll_statement')->comment('بيان الراتب');
            $table->string('branch')->comment('الفرع');
            $table->string('establishment')->comment('المنشاءة');
            $table->string('foundation_E')->comment('المؤسسة E');
            $table->string('salary_category')->comment('فئة الراتب المستخدمة للنظام');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_data');
    }
};
