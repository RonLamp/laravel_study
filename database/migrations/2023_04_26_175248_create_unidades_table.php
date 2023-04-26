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
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('unidade', 5);
            $table->string('descricao', 30);
            $table->timestamps();
        });
        // Relacionamemto com a tabela produtos
        Schema::table('produtos', function(Blueprint $table){
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
        });

        // Relacionamento com a tabela produto_detalhes
        Schema::table('produto_detalhes', function(Blueprint $table){
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remover os relacionamentos e depois Remover as tabelas
        // Sempre na ordem inversa de criação
        Schema::table('produto_detalhes', function(Blueprint $table){
            // Remover a foreignKey   {table}_{coluna}_foreign
            // convem confirmar na base de dados o nome da foreinKey
            $table->dropForeign('produto_detalhes_unidade_id_foreign');
            $table->dropColumn('unidade_id');
        });

        Schema::table('produtos', function(Blueprint $table){
            $table->dropForeign('produtos_unidade_id_foreign');
            $table->dropColumn('unidade_id');
        });

        Schema::dropIfExists('unidades');
    }
};
