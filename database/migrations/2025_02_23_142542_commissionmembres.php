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
        Schema::create('commissionmembres', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->char('uuid', 36);
            $table->string('civilite')->nullable();
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->string('fonction')->nullable();
            $table->string('structure')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('signature')->nullable();
            $table->longText('description')->nullable();

            $table->softDeletes();
            $table->nullableTimestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissionmembres');
    }
};
