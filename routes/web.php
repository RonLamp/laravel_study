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
Route::get('/',[\App\Http\Controllers\PrincipalController::class,'principal'])->name('site.index');

// Route::get('/about', function () {
//     return 'Olá, Quer saber alguma coisa sobre nós???';
// });
Route::get('/about',[\App\Http\Controllers\AboutController::class,'about'])->name('site.about');

// Route::get('/contato', function () {
//     return 'Olá, para entrar em contato faça uma oração, Amém...';
// });
Route::get('/contato',[\App\Http\Controllers\ContatoController::class,'contato'])->name('site.contato');
Route::get('/login', function(){ return 'Login';})->name('site.login');

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

// Rotas agrupadas, estas rotas agrupadas te  a finalidade de separar, por exemplo
// rotas públicas de rotas privadas
// os names só podem ser utilizadas dentro da aplicação, por exemplo dentro de links
Route::prefix('/app') -> group(function(){
    Route::get('/clientes', function(){return 'Clientes';})->name('app.clientes');
    Route::get('/fornecedores', function(){return 'Fornecedores';})->name('app.fornecedores');
    Route::get('/produtos', function(){return 'Produtos';})->name('app.produtos');
});

// Redirecionamento de rotas
Route::get('/rota1', 
    function(){
        return 'Rota numero 1';
    })->name('app.rota1'
    );

// Redirecionamento por redirect
// RRoute::get('/rota2', 
// function(){
//     return 'Rota numero 2';
// })->name('app.rota2'
// );
Route::redirect('/rota2','/rota1');

// Ou podemos redirecionar na função de callback de uma rota
// Route::get('/rota2', function(){
//     return redirect()->route('site.rota1');
// })->name('site.rota2');

// Função de callback
Route::fallback(function(){
    echo 'a rota acessada não existe. <a href='/'>clique aqui</a> para ir para a página inicial';
});

// Encaminhando parametros de rota para o controlador
Route::get('/teste/{p1}/{p2}',[\App\Http\Controllers\TesteController::class,'teste'])
->name('teste')
-> where('p1','[0-9]+')
-> where('p2','[0-9]+');