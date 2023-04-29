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
```js
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
```
Elimina-se a definição `DB_DATABASE=laravel` e cria-se o arquivo: `/database/database.sqlite`  

## Instalação do Mysql
No arquivo: `/config/database.php` é onde se definem as conexões.  
Testar a conexão, na linha de comando, com mysql, deve dar true.
```js 
λ php -r "var_dump(extension_loaded('pdo_mysql'));"
``` 
No arquivo: `.env` define-se as db_conectios cfe abaixo:

```js
DB_CONNECTION=mysql
DB_HOST=mysql.host.com
DB_DATABASE=dbhost
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=rootpassw
```  

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
  
## Adicionando campos em uma tabela já existente
```php 
> php artisan make:migration alter_fornecedors_novas_colunas 
```  
No método **up()** colocaremos as seguintes instruções  
```php
public function up(): void
    {
        Schema::table('fornecedors', function (Blueprint $table) {
            $table->string('uf',2);
            $table->string('email',150);
        });
    }
```   

Note que em vez da função `create` usamos `table`, e nas colunas simplesmente colocamos as novas definições.  
Para efetivarmos as alterações no banco de dados
```php
> php artisan migrate
```
   

## Método de RollBack das migrações
O function **up()** cria as migrações através do comando 
```php
> php artisan migrate
```
Já o método **down()** reverte o que as migrations fizeram. Então ali devemos colocar o inverso do método **up()**.  

```php
public function down(): void
    {
        Schema::table('fornecedors', function (Blueprint $table) {
            // para remover as colunas
            // $table->dropColumn('uf');
            // $table->dropColumn('email');
            //  OU
            // para remover as colunas
            $table->dropColumn(['uf','email']);
        });
    }
```

```php
> php artisan migrate:rollback   // para voltar uma migration 
> php artisan migrate:rollback –step=3 	// para voltar 3 migrations 
> php artisan migrate:reset	   // para voltar todas as migrations
```
## Modificadores nullable() e default()  
O modificador nullable faz com que os valores do campo possam ser nullos.  
Já o modificador default define um valor default para o campo no instante da criação do registro, caso este esteja indefinido.  
Vejamos um exemplo de uso, na migration.
```php
> php artisan migrate
```

```php
public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->text('descricao')->nullable();
            $table->integer('peso')->nullable();
            $table->float('preco_venda', 8, 2)->default(0.01);
            $table->integer('estoque_minimo')->default(1);
            $table->integer('estoque_maximo')->default(1);
            $table->timestamps();
        });
    }
```  
## Chaves estrangeiras (1 para 1)
![Chaves estrangeiras (1 para 1)](/mdImages/chavesEstrangeiras_1_1.png)
```php 
> php artisan make:migration create_produto_detalhes_table 
```  
Por padrão a chave da tabela mais forte, mais importante é a que viaja para a tabela mais fraca ou menos importante.  
No nosso caso a tabela produtos viaja para a tabela produtos_detalhe. Logo é na tabela de produto_detalhe que recebemos o campo de relacionamento.  

```php
public function up(): void
    {
        Schema::create('produto_detalhes', function (Blueprint $table) {
            // Tabela  ------------------------------------------------
            $table->id();
            $table->unsignedBigInteger('produto_id');
            // utilizamos o nome da tabela no singular, underline, id
            // e o tipo da chave de origem deve ser igual ao usado aki
            // confirmar na base de dados
            $table->float('comprimento', 8, 2);
            $table->float('largura', 8, 2);
            $table->float('altura', 8, 2);
            $table->timestamps();
            // Constraints  ------------------------------------------
            $table->foreign('produto_id')->references('id')->on('produtos');
            // Como o relacioanmento é de 1 para 1 precisamos dizer que o
            // produto_id é unico. caso contrário teríamos um
            // relacionamento 1 para n
            $table->unique('produto_id');
        });
    }
```  
```php
> php artisan migrate
```
## Chaves estrangeiras (1 para muitos)
![Chaves estrangeiras (1 para 1)](/mdImages/chavesEstrangeiras_1_n.png)
```php
> php artisan make:migration create_unidades_table
```

No caso de relacionamentos 1 para muitos, a chave da tabela que tem cardinalidade 1 viaja para as tabelas com cardinalidade muitos.  
Logo os comandos `foreign` e os `campos_id` ficam nas tabelas onde existe a cardinalidade muitos.

```php
public function up(): void
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('unidade', 5);
            $table->string('descricao', 30);
            $table->timestamps();
        });
        // Relacionamemto com a tabela produtos
        Schema::table('produtos', function(Blueprint $table){
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
        });

        // Relacionamento com a tabela produto_detalhes
        Schema::table('produto_detalhes', function(Blueprint $table){
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidades');
        });
    }

public function down(): void
    {
        // Remover os relacionamentos e depois Remover as tabelas
        // Sempre na ordem inversa de criação
        Schema::table('produto_detalhes', function(Blueprint $table){
            // Remover a foreignKey   {table}_{coluna}_foreign
            // convem confirmar na base de dados o nome da foreinKey
            $table→dropForeign('produto_detalhes_unidade_id_foreign');
            $table->dropColumn('unidade_id');
        });

        Schema::table('produtos', function(Blueprint $table){
            $table→dropForeign('produtos_unidade_id_foreign');
            $table->dropColumn('unidade_id');
        });
        
        Schema::dropIfExists('unidades');
    }
```

## Chaves estrangeiras (muitos para muitos)
> php artisan make:migration ajuste_produtos_filiais

public function up(): void
    {
        // Criação da tabela filiais
        Schema::create('filiais', function (Blueprint $table) {
            $table->id();
            $table->string('filial', 30);
            $table->timestamps();
        });
        Schema::create('produto_filiais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filial_id');
            $table->unsignedBigInteger('produto_id');
            $table->float('preco_venda', 8, 2)->default(0.01);
            $table->integer('estoque_minimo')->default(1);
            $table->integer('estoque_maximo')->default(1);
            $table->timestamps();
            $table->foreign('filial_id')->references('id')->on('filiais');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
        // excluir as colunas ['preco_venda','estoque_minimo','estoque_maximo']
        // da tabela produtos, pois agora os produtos estarão nas filiais
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['preco_venda','estoque_minimo','estoque_maximo']);
        });
    }
    /** Reverse the migrations. * */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            // adicionar as colunas da tabela produtos
            $table->float('preco_venda', 8, 2)->default(0.01);
            $table->integer('estoque_minimo')->default(1);
            $table->integer('estoque_maximo')->default(1);
        });
        Schema::table('produto_filiais', function (Blueprint $table) {
            // Remover a foreignKey   {table}_{coluna}_foreign
            // convem confirmar na base de dados o nome da foreinKey
            $table->dropForeign('produto_filiais_produto_id_foreign');
            $table->dropForeign('produto_filiais_filial_id_foreign');
            // quando se dá o drop na tabela, as chaves não precisam 
            // ser excluidas anteriormente como aqui
        });
        Schema::dropIfExists('produto_filiais');
        Schema::dropIfExists('filiais');
        
    }

Modificador after
Serve para posicionar a coluna após uma coluna específica da tabela
public function up(): void
    {
        Schema::table('fornecedors', function (Blueprint $table) {
            // adicionar as colunas da tabela produtos
            $table->string('site', 150)->after('nome')->nullable();
        });
    }

Comandos Status, Reset, Refresh e Fresh
Status
> php artisan migrate:status
Migration name .................................................................................. Batch / Status  
  2014_10_12_000000_create_users_table ................................................................... [1] Ran  
  2014_10_12_100000_create_password_reset_tokens_table ................................................... [1] Ran  
  2019_08_19_000000_create_failed_jobs_table ............................................................. [1] Ran  
  2019_12_14_000001_create_personal_access_tokens_table .................................................. [1] Ran  
  2023_04_25_191920_create_site_contatos_table ........................................................... [1] Ran  
  2023_04_26_140723_create_fornecedors_table ............................................................. [2] Ran  
  2023_04_26_143714_alter_fornecedors_novas_colunas ...................................................... [3] Ran  
  2023_04_26_151157_create_produtos_table ................................................................ [4] Ran  
  2023_04_26_170549_create_produto_detalhes_table ........................................................ [5] Ran  
  2023_04_26_175248_create_unidades_table ................................................................ [6] Ran  
  2023_04_26_184644_ajuste_produtos_filiais .............................................................. [7] Ran  
  2023_04_27_133628_alter_fornecedores_nova_coluna_com_after ............................................. [8] Ran  
Reset
Faz com que o metodo down de todas as migrations seja executado, ai o banco de dados volta a posição inicial do banco de dados
> php artisan migrate:reset
Refresh
Faz o mesmo que o método Reset e depois da uma migrate de novo
> php artisan migrate:refresh
Fresh
Parecido com refresh, mas ele dropa todos os objetos e após executa o migrate.
> php artisan migrate:fresh




