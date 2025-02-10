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
        Schema::table('formations', function (Blueprint $table) {
            $table->string('duree_formation', 200)->nullable();
            $table->string('file_etat_hebergement', 200)->nullable();
            $table->string('file_etat_restauration', 200)->nullable();
            $table->string('file_etat_transport', 200)->nullable();
            $table->timestamp('date_etat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn('duree_formation');
            $table->dropColumn('file_etat_hebergement');
            $table->dropColumn('file_etat_restauration');
            $table->dropColumn('file_etat_transport');
            $table->dropColumn('date_etat');
        });
    }
};
