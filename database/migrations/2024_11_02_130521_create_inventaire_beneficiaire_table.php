<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaire_beneficiaire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // clé étrangère vers la table users
            $table->foreignId('produit_id')->constrained('produits_alimentaires')->onDelete('cascade'); // clé étrangère vers la table produits_alimentaires
            $table->integer('quantite');
            $table->string('localisation')->nullable(); // localisation, peut être null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventaire_beneficiaire');
    }
};
