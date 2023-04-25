<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ContatoController extends Controller
{
    public function contato(){
        //echo 'Olá, para entrar em contato faça uma oração, Amém...  pelo Controller.';
        return view('site.contato');
    }
}
