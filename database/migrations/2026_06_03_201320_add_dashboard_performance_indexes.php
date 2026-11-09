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
        Schema::table('leaves', function (Blueprint $table): void {
            $table->index(['user_id', 'created_at'], 'leaves_user_id_created_at_index');
        });

        Schema::table('overtime_entries', function (Blueprint $table): void {
            $table->index(['user_id', 'work_date'], 'overtime_entries_user_id_work_date_index');
        });

        Schema::table('earnings', function (Blueprint $table): void {
            $table->index(['user_id', 'pay_date'], 'earnings_user_id_pay_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('earnings', function (Blueprint $table): void {
            $table->dropIndex('earnings_user_id_pay_date_index');
        });

        Schema::table('overtime_entries', function (Blueprint $table): void {
            $table->dropIndex('overtime_entries_user_id_work_date_index');
        });

        Schema::table('leaves', function (Blueprint $table): void {
            $table->dropIndex('leaves_user_id_created_at_index');
        });
    }
};
