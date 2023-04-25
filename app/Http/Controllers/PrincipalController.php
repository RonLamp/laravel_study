<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class PrincipalController extends Controller
{
    public function principal() {
        //echo 'Seja bem vindo a applicação gestão super!!! pelo Controller.';
        return view('site.principal');
    }
}
