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
    public $tableName = 'emargementsindividuelles';

    /**
     * Run the migrations.
     * @table emargementsindividuelles
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('emargements_id');
            $table->unsignedInteger('individuelles_id');

            $table->index(["individuelles_id"], 'fk_emargementsindividuelles_individuelles1_idx');

            $table->index(["emargements_id"], 'fk_emargementsindividuelles_emargements1_idx');
            $table->softDeletes();
            $table->nullableTimestamps();

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
