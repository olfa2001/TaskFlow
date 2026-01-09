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
         Schema::create('projects', function (Blueprint $table) {
            $table->id(); // id bigint auto increment
            $table->string('nom_projet')->unique();
            $table->text('description')->nullable();
            $table->date('deadline');
             $table->unsignedBigInteger('id_user')->nullable()->change();
            $table->unsignedBigInteger('id_etat'); // clé étrangère vers etat
            $table->timestamps(); // created_at + updated_at

            // clés étrangères
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_etat')->references('id')->on('etat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
