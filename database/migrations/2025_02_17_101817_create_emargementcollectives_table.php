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
        Schema::create('emargementcollectives', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->uuid('uuid');
            $table->unsignedInteger('formations_id');
            $table->string('jour', 50);
            $table->dateTime('date')->nullable(true);
            $table->longText('observations')->nullable();
            $table->string('file', 200)->nullable();
            $table->unsignedInteger('listecollectives_id')->nullable();
            $table->softDeletes();
            $table->nullableTimestamps();
            
            $table->index(["listecollectives_id"], 'fk_emargementcollectives_listecollectives1_idx');
            
            $table->foreign('formations_id')->references('id')->on('formations')
            ->onDelete('cascade') // ou 'set null' selon votre besoin
            ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emargementcollectives');
    }
};
