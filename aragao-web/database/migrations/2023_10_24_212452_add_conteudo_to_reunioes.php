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
        Schema::table('reunioes', function (Blueprint $table) {
            $table->mediumText('conteudo')->nullable();
            $table->enum('situacao', ['agendada', 'confirmada', 'adiada', 'cancelada', 'concluida', 'negada', 'conteudo_pendente'])
                ->default('agendada')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reunioes', function (Blueprint $table) {
            $table->dropColumn('conteudo');
            $table->enum('situacao', ['agendada', 'confirmada', 'adiada', 'cancelada', 'concluida', 'negada'])
                ->default('agendada')->change();
        });
    }
};
