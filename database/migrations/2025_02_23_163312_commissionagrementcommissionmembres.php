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
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->unsignedInteger('commissionagrements_id');
            $table->unsignedInteger('commissionmembres_id');
            
            // Indexes
            $table->index(['commissionmembres_id'], 'idx_commissionmembres');
            $table->index(['commissionagrements_id'], 'idx_commissionagrements');
            
            // Timestamps and soft deletes
            $table->softDeletes();
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
