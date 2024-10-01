<?php

use App\IsActiveEnum;
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
        Schema::create('account_natures', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150)->nullable();
            $table->integer('is_active')->default(IsActiveEnum::ACTIVE->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_natures');
    }
};
