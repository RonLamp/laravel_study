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
        // Criação da tabela filiais
        Schema::create('filiais', function (Blueprint $table) {
            $table->id();
            $table->string('filial', 30);
            $table->timestamps();
        });
        Schema::create('produto_filiais', function (Blueprint $table) {
            // Tabela
            $table->id();
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('produto_id');
            $table->float('preco_venda', 8, 2)->default(0.01);
            $table->integer('estoque_minimo')->default(1);
            $table->integer('estoque_maximo')->default(1);
            $table->timestamps();
            // Foreign key (constraints)
            $table->foreign('filial_id')->references('id')->on('filiais');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
        // excluir as colunas ['preco_venda','estoque_minimo','estoque_maximo']
        // da tabela produtos, pois agora os produtos estarão nas filiais
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['preco_venda','estoque_minimo','estoque_maximo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // adicionar as colunas da tabela produtos
            $table->float('preco_venda', 8, 2)->default(0.01);
            $table->integer('estoque_minimo')->default(1);
            $table->integer('estoque_maximo')->default(1);
        });
        Schema::table('produto_filiais', function (Blueprint $table) {
            // Remover a foreignKey   {table}_{coluna}_foreign
            // convem confirmar na base de dados o nome da foreinKey
            $table->dropForeign('produto_filiais_produto_id_foreign');
            $table->dropForeign('produto_filiais_filial_id_foreign');
            // quando se dá o drop na tabela, as chaves não precisam 
            // ser excluidas anteriormente como aqui
        });
        Schema::dropIfExists('produto_filiais');
        Schema::dropIfExists('filiais');
        
    }
};
