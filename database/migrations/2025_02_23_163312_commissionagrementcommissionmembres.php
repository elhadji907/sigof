<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'commissionagrementcommissionmembres';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commissionagrementcommissionmembres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commissionagrement_id')
                ->constrained('commissionagrements')
                ->onDelete('cascade')
                ->name('fk_agrement_membre_agrement');

            $table->foreignId('commissionmembre_id')
                ->constrained('commissionmembres')
                ->onDelete('cascade')
                ->name('fk_agrement_membre_membre');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
