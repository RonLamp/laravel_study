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
        Schema::create('produto_detalhes', function (Blueprint $table) {
            // Tabela  ------------------------------------------------
            $table->id();
            $table->unsignedBigInteger('produto_id');
            // utilizamos o nome da tabela no singular, underline, id
            // e o tipo da chave de origem deve ser igual ao usado aki
            // confirmar na base de dados
            $table->float('comprimento', 8, 2);
            $table->float('largura', 8, 2);
            $table->float('altura', 8, 2);
            $table->timestamps();
            // Constraints  ------------------------------------------
            $table->foreign('produto_id')->references('id')->on('produtos');
            // Como o relacioanmento é de 1 para 1 precisamos dizer que o
            // produto_id é unico. caso contrário teríamos um relacionamento
            // 1 para n
            $table->unique('produto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto_detalhes');
    }
};
