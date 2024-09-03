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
        Schema::create('discentes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('mail');
            $table->string('data_nascimento');
            $table->foreignId('curso_id');
            $table->foreignId('periodo_id');
            $table->foreignId('turno_id');
            $table->foreignId('modalidade_id');
            $table->string('guid');
            $table->string('domain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discentes');
    }
};
