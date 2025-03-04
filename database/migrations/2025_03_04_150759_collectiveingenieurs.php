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
    protected $tableName = 'collectiveingenieurs';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('collectives_id');
            $table->unsignedInteger('ingenieurs_id');

            $table->index(["ingenieurs_id"], 'fk_collectives_has_ingenieurs_ingenieurs1_idx');

            $table->index(["collectives_id"], 'fk_collectives_has_ingenieurs_collectives1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('collectives_id', 'fk_collectives_has_ingenieurs_collectives1_idx')
                ->references('id')->on('collectives')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ingenieurs_id', 'fk_collectives_has_ingenieurs_ingenieurs1_idx')
                ->references('id')->on('ingenieurs')
                ->onDelete('no action')
                ->onUpdate('no action');
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
