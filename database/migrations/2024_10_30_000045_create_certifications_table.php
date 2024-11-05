<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationsTable extends Migration
{
    public function up()
    {
        // Crée la table 'certifications' avec tous les attributs nécessaires
        Schema::create('certifications', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->string('nom');
            $table->text('description')->nullable();
            $table->date('date_validation');
            $table->string('statut');

            // Ajoute une colonne produit_id avec clé étrangère
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->foreign('produit_id')->references('id')->on('produits_alimentaires')->onDelete('cascade');

            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        // Supprime la table 'certifications'
        Schema::dropIfExists('certifications');
    }
}
