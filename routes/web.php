<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/* Route::get($uri,$callback_function) */

// Route::get('/', function () {
//     // return view('welcome');
//     return 'Olá, seja bem vindo ao curso de Laravel!!!';
// });
Route::get('/',[\App\Http\Controllers\PrincipalController::class,'principal']);

// Route::get('/about', function () {
//     return 'Olá, Quer saber alguma coisa sobre nós???';
// });
Route::get('/about',[\App\Http\Controllers\AboutController::class,'about']);

// Route::get('/contato', function () {
//     return 'Olá, para entrar em contato faça uma oração, Amém...';
// });
Route::get('/contato',[\App\Http\Controllers\ContatoController::class,'contato']);

// Para recebermos os seguintes parametros
//  nome, categoria, assunto, mensagem
// o que importa é a sequencia de envio de parametros e não o nome da variavel.
// por isto é uma boa pratica usar parametros e variaveis com o  mesmo nome.
// os parametros com ? no final são parametros opcionais e devem ser os ultimos
Route::get('/contato/{nome}/{categoria}/{assunto?}/{mensagem?}',
    function (string $xyz,
              string $categoria, 
              string $assunto = 'assunto inexistente', 
              string $mensg = 'sem mensagem'){
        echo 'Estamos aqui: '.$xyz.' aguardando sua categoria: '.$categoria.' - '.$assunto.' - '.$mensg;
});

// Verificação de parametros atraves de RegExp
Route::get('/regexp/{nome}/{categoria_id}',
    function (string $nome,
              int $categoria_id = 1  // representa a categoria informação
              ) {
        echo 'RegExp Verification: '.$nome.' OK/NOK : '.$categoria_id;
}) -> where('categoria_id','[0-9]+') -> where('nome','[A-Za-z]+');