<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Sobre este estudo de Laravel

Este estudo sobre o Laravel visa dar os primeiros passos, primeiras definições e padrões de trabalho.

-   [Laravel](https://laravel.com).
-   [Laravel in Github](https://github.com/laravel).
-   [Laravel Docs](https://laravel.com/docs/)
-   [ORM with eloquent](https://laravel.com/docs/eloquent).
-   [Laravel schema migrations](https://laravel.com/docs/migrations).

### Questions, sugestões e críticas

Se você tem perguntas, sugestões e críticas por favor, contate-nos por [lamp@rc12.net](mailto:lamp@rc12.net)

## Arquitetura MVC

O padrão **MVC (Model-View-Controller)** é um padrão de arquitetura de software que separa as responsabilidades de uma aplicação em três componentes principais: o Modelo (Model), a Visão (View) e o Controlador (Controller).  
O Modelo é responsável pela representação e manipulação dos dados da aplicação. A Visão é responsável pela apresentação dos dados ao usuário, ou seja, pela interface gráfica. O Controlador é responsável por receber as entradas do usuário, manipular os dados do Modelo e atualizar a Visão.  
Essa separação de responsabilidades torna a aplicação mais organizada e fácil de manter, uma vez que as mudanças em um componente não afetam diretamente os outros. Além disso, o padrão MVC permite a reutilização de código, já que cada componente pode ser desenvolvido de forma independente.

## Estrutura de diretórios.

**M Models** - /resources/views  
**V Views** - /app/Models  
**C Controllers** - /app/Http/Controllers

## Outros diretórios importantes

| Caminho| Descrição|  
| --- | --- |
| app/console| comandos básicos para o laravel|
| app/http/middleware | onde fica o middleware|
| app/http/kernel.php | onde se registram os middlewares|
| app/http/requests   | onde ficam as classes de validações.|
| app/http/models     | onde ficam os models|
| app/http/providers  | onde ficam os provedores de serviços|
| bootstrap           | responsavel pela inicialização do framework|
| config              | configurações do sistema|
| config/cors         | configurações de cors|
| database/factories  | para popular o database durante o desenvolvimento|
| database/seeders    | onde ficam os seeds para popular os databases|
| database/migrations | onde ficam as migrations|
| lang                | diretorio onde ficam os idiomas|
| public              | é o único diretorio visivel na web|
| resources           | é onde ficam as telas e os assets no desenvolvimento|
| routes/api          | é onde ficam a s nossa routes de api|
| routes/channels     | para broadcasts|
| routes/console| |
| routes/web          | onde ficam as rotas para as páginas da web |
| storage             | para upload de arquivos (imagens publica/private)|
| storage/logs        | onde ficam os logs do sistema.|
| Stubs               | modelos de classes e de páginas|
| tests               | onde se configuram os testes|
| vendor              | é onde ficam os pacotes de terceiros. (não alterar)|

# Models, Migrations, Seeders, Factories, Databases, Tinker e Eloquent
## Models e Migrations
```php
// Para criar um Model e uma Migration Correspondente
// O nome deve sempre ser criado no singular e em CamelCase
> php artisan make:model SiteContato -m

// Outra alternativa seria:
// Para criar o Model
> php artisan make:model SiteContato
// Para criar uma Migration
> php artisan make:migration create_site_contato_table
// desta maneira o model e sua respectiva migration seriam criados 
// separadamente de maneira manual.
```   
## Migrations
É onde é definido os campos das tabelas.  
O método **up()** criado na migration, cria a tabela através do método create, já o método **down()** nos permite reverter a migration.  
É na migration que se definem os campos que farão parte da tabela.  
Detalhes para a codificação dos campos da migration estão aqui: [Laravel Migration](https://laravel.com/docs/10.x/migrations#creating-columns)  
Exemplo:  
```php
    // Run the migrations.
    public function up(): void
    {
        Schema::create('site_contatos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome',50);
            $table->string('telefone',20);
            $table->string('email',80);
            $table->integer('motivo_contato');
            $table->text('mensagem');
        });
    }
    // Reverse the migrations.  
    public function down(): void
    {
        Schema::dropIfExists('site_contatos');
    }
```

## Instalação do SQLite
É aconselhavel usar SQLite somente em desenvolvimento no arquivo: `/config/database.php `é onde se definem as conexões. Já no arquivo: `.env` define-se as db_conectios cfe. abaixo:
```bash
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
```
Elimina-se a definição `DB_DATABASE=laravel` e cria-se o arquivo: `/database/database.sqlite`  

## Executando-se a migration
```php
> php artisan migrate            // para executar uma migration
> php artisan migrate:rollback   // para voltar uma migration 
> php artisan migrate:rollback –step=3 	// para voltar 3 migrations 
> php artisan migrate:reset	   // para voltar todas as migrations
```

Alguns erros em migrations  
No Laravel, você pode definir uma coluna de chave UUID usando o tipo de coluna `uuid` e definir a coluna como única usando o método `unique`  
`$table->uuid('uuid')->unique();`  
Para as demais chaves como e-mail devemos utilizar a definição:  
`$table->string(’email’, 80)->primary();`  




