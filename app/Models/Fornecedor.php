<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;
    // quando se define assim o nome da tabela, este nome se sobrepões
    // ao nome padrão dado pelo laravel. 
    // Se a classe fosse : SpecialFornecedor
    // o nome padrão da tabela seria:
    // Special_Fornecedor
    // special_fornecedor
    // special_fornecedors
    // mas que passa a ser fornecedors
    protected $table = 'fornecedors';
    protected $fillable = ['nome','site','uf','email'];
}
