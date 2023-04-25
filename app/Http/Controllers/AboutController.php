<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AboutController extends Controller
{
    public function about(){
        //echo 'Olá, Quer saber alguma coisa sobre nós??? pelo Controller.';
        return view('site.about');
    }
}
