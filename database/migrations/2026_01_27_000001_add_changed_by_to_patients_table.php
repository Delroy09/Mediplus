<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add changed_by to patients table
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Remove changed_by from patients table
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['changed_by']);
            $table->dropColumn('changed_by');
        });
    }
};
