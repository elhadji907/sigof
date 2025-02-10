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
            $table->double('indemnite_transport_jour')->nullable();
            $table->double('indemnite_transport')->nullable();
            $table->double('indemnite_hebergement_jour')->nullable();
            $table->double('indemnite_hebergement')->nullable();
            $table->double('indemnite_restauration_jour')->nullable();
            $table->double('indemnite_restauration')->nullable();
            $table->double('indemnite')->nullable();
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
            $table->dropColumn('indemnite_transport_jour');
            $table->dropColumn('indemnite_transport');
            $table->dropColumn('indemnite_hebergement_jour');
            $table->dropColumn('indemnite_hebergement');
            $table->dropColumn('indemnite_restauration_jour');
            $table->dropColumn('indemnite_restauration');
            $table->dropColumn('indemnite');
        });
    }
};
