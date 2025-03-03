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
        Schema::table('individuelles', function (Blueprint $table) {
            $table->string('confirmation', 200)->nullable();
            $table->longText('motif_declinaison')->nullable();
            $table->string('provenance', 200)->nullable();
            $table->double('frais_transport', 200)->nullable();
            $table->double('frais_hebergement', 200)->nullable();
            $table->double('frais_restauration', 200)->nullable();
            $table->double('frais_formation', 200)->nullable();
            $table->double('frais', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individuelles', function (Blueprint $table) {
            $table->dropColumn('confirmation');
            $table->dropColumn('motif_declinaison');
            $table->dropColumn('provenance');
            $table->dropColumn('frais_transport');
            $table->dropColumn('frais_hebergement');
            $table->dropColumn('frais_restauration');
            $table->dropColumn('frais_formation');
            $table->dropColumn('frais');
        });
    }
};
