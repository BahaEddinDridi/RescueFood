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
    Schema::create('don', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ajoutez cette ligne
        $table->string("type_aliment");
        $table->integer('quantité');
        $table->date('date_peremption'); 
        $table->date('date_don');
        $table->enum('statut', ['disponible', 'récupéré']);
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
        Schema::dropIfExists('don');
    }
};
