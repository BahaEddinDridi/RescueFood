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
        Schema::table('produits_alimentaires', function (Blueprint $table) {
            $table->boolean('approuve')->default(false);
        });
    }
    
 
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produit_alimentaires', function (Blueprint $table) {
            //
        });
    }
};
