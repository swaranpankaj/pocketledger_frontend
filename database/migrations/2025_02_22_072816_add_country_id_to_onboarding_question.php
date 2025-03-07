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
        Schema::table('onboarding_question', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->default(1)->after('id'); // Adjust the column order
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onboarding_question', function (Blueprint $table) {
            $table->dropColumn('country_id');
        });
    }
};
