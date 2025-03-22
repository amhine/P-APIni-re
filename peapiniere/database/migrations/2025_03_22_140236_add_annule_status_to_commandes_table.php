<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up(): void
    {
        // Ajouter une nouvelle colonne status avec les valeurs enum mises à jour
        Schema::table('commandes', function (Blueprint $table) {
            $table->enum('status_new', ['en attente', 'en preparer', 'livree', 'annulee'])
                  ->default('en attente')
                  ->after('status');
        });

        // Copier les données de l'ancienne colonne status vers la nouvelle
        DB::statement("UPDATE commandes SET status_new = status");

        // Supprimer l'ancienne colonne status
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Renommer la nouvelle colonne status avec le nom original
        Schema::table('commandes', function (Blueprint $table) {
            $table->renameColumn('status_new', 'status');
        });
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        // Pour revenir en arrière, vous devez effectuer les opérations inverses
        Schema::table('commandes', function (Blueprint $table) {
            $table->enum('status_old', ['en attente', 'en préparation', 'livrée'])
                  ->default('en attente')
                  ->after('status');
        });

        // Copier les données compatibles
        DB::statement("UPDATE commandes SET status_old = status WHERE status IN ('en attente', 'en préparation', 'livrée')");

        // Supprimer la nouvelle colonne
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Renommer pour revenir au nom original
        Schema::table('commandes', function (Blueprint $table) {
            $table->renameColumn('status_old', 'status');
        });
    }
};