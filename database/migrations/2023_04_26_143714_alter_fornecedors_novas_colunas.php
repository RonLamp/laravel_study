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
        Schema::table('fornecedors', function (Blueprint $table) {
            $table->string('email',150)->after('nome');
            $table->string('uf',2)->after('nome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fornecedors', function (Blueprint $table) {
            // para remover as colunas
            // $table->dropColumn('uf');
            // $table->dropColumn('email');
            //  OU
            // para remover as colunas
            $table->dropColumn(['uf','email']);
        });
    }
};
