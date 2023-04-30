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
| app/http/controllers| **<u>onde ficam os Controllers</u>**|
| app/http/middleware | onde fica o middleware|
| app/http/kernel.php | onde se registram os middlewares|
| app/http/requests   | onde ficam as classes de validações.|
| app/http/models     | **<u>onde ficam os Models</u>**|
| app/http/providers  | onde ficam os provedores de serviços|
| bootstrap           | responsavel pela inicialização do framework|
| config              | configurações do sistema|
| config/cors         | **<u>configurações de CORs</u>**|
| database/factories  | para popular o database durante o desenvolvimento|
| database/seeders    | onde ficam os seeds para popular os databases|
| database/migrations | **<u>onde ficam as Migrations</u>**|
| lang                | diretorio onde ficam os idiomas|
| public              | é o único diretorio visivel na web|
| resources           | é onde ficam as telas e os assets no desenvolvimento|
| routes/api          | **<u>onde ficam as nossa Routes das APIs</u>**|
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
![Chaves estrangeiras (1 para n)](/mdImages/chavesEstrangeiras_1_n.png)
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
![Chaves estrangeiras (1 para n)](/mdImages/chavesEstrangeiras_n_n.png)
```php
> php artisan make:migration ajuste_produtos_filiais
```
```php
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
```

## Modificador after
Serve para posicionar a coluna após uma coluna específica da tabela.

```php
public function up(): void
    {
        Schema::table('fornecedors', function (Blueprint $table) {
            // adicionar as colunas da tabela produtos
            $table->string('site', 150)->nullable()->after('nome');
        });
    }
```

## Comandos Status, Reset, Refresh e Fresh
### <u>Status</u>

```php
> php artisan migrate:status
```
```plaintext 
Migration name ................................................ Batch / Status  
  2014_10_12_000000_create_users_table ............................... [1] Ran  
  2014_10_12_100000_create_password_reset_tokens_table ............... [1] Ran  
  2019_08_19_000000_create_failed_jobs_table ......................... [1] Ran  
  2019_12_14_000001_create_personal_access_tokens_table .............. [1] Ran  
  2023_04_25_191920_create_site_contatos_table ....................... [1] Ran  
  2023_04_26_140723_create_fornecedors_table ......................... [2] Ran  
  2023_04_26_143714_alter_fornecedors_novas_colunas .................. [3] Ran  
  2023_04_26_151157_create_produtos_table ............................ [4] Ran  
  2023_04_26_170549_create_produto_detalhes_table .................... [5] Ran  
  2023_04_26_175248_create_unidades_table ............................ [6] Ran  
  2023_04_26_184644_ajuste_produtos_filiais .......................... [7] Ran  
  2023_04_27_133628_alter_fornecedores_nova_coluna_com_after ......... [8] Ran 
  ```
   
### <u>Reset</u>
Faz com que o metodo down de todas as migrations seja executado, ai o banco de dados volta a posição inicial.

```php
> php artisan migrate:reset
```
### <u>Refresh</u>
Faz o mesmo que o método Reset e depois executa uma migrate de novo.

```php
> php artisan migrate:refresh
```
### <u>Fresh</u>
Parecido com refresh, mas ele dropa todos os objetos e após executa o migrate.
```php
> php artisan migrate:fresh
```

# Eloquent - ORM
Mapeamento Objeto Relacional ou ORM faz com que a parte de programação se torne mais agil, pois fornece recursos para a gravação, atualização, seleção e remoção de registros que independem da base de dados e da linguagem de programação.
Existem dois padrões de ORM, a saber: **Data Mapper** e **Active Record.**
## Tinker
Console interativo que nos permite testar os Models e o Eloquent, sem a necessidade de construirmos applicativos front-end.
```php
> php artisan tinker
```

## <u>Query Builder - Construindo consultas</u>
Inserir registros no banco com Tinker
```php 
> $contato = new \App\Models\SiteContato();
> $contato->nome = 'Ronaldo Lamp';
> $contato->telefone = '(51)999101039';
> $contato->email = 'lamp@r12.net';
> $contato->motivo_contato = 1;
> $contato->mensagem = 'Esta mensagem é sobre o tinker'
> print_r($contato->getAttributes());
> $contato->save();
```
## Ajustando o nome da tabela no Model  

```php
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
}
```
## Inserindo Registros com Create e Fillable  
Primeiro se mouda no Model a propriedade $fillable para permitirmos a inserção de registros com os campos especificados
```php
class Fornecedor extends Model
{
    use HasFactory;
    protected $table = 'fornecedors';
    protected $fillable = ['nome','site','uf','email'];
}
```
Depois parte-se para a inserção propriamente dita.
```php
> \App\Models\Fornecedor::create([
    'nome'=>'Fornecedor ABC',
    'site'=>'fornecedorabc.com.br',
    'uf'=>'RS',
    'email'=>'mail@gmail.com'
    ]);
```
Resposta  
```plaintext
= App\Models\Fornecedor {#6227
    nome: "Fornecedor ABC",
    site: "fornecedorabc.com.br",
    uf: "RS",
    email: "mail@gmail.com",
    updated_at: "2023-04-27 15:19:48",
    created_at: "2023-04-27 15:19:48",
    id: 1,
  }
  ```
## Selecionando registros com all()
```php
> $fornec = \App\Models\Fornecedor::all();
ou
> use \App\Models\Fornecedor
> $fornec = Fornecedor::all();
e também
> print_r($fornec->toArray());
```

## Selecionando registros com find()  
É igual ao all, mas esta função aguarda uma key referente à primaryKey.
```php 
> use \App\Models\Fornecedor
> $fornec = Fornecedor::find(2);
> $fornec->nome;
> $fornec = Fornecedor::find([1,2]);
> foreach($fornec as $f) {echo $f->nome; echo' - ';}
```

## Selecionando registros com where() 
Ele é um construtor que permite seu uso com diversos outros métodos.  
O where permite comparações complexas da seguinte maneira:  
***where (comparação) operadorLógico (comparação)***  
Vamos começar com a mais simples, do tipo ***where (comparação)***  
os operadores de comparação são: ***<, >, <=, >=, ==, <>,like*** e outros...  

```php
> use \App\Models\SiteContato;
// $cont = SiteContato::where('nome_coluna', 'operador', 'valor'); 
> $cont = SiteContato::where('id','>',1);         //Retorna um Build
> $cont = SiteContato::where('id','>',1)->get();  //Retorna uma Collection
> foreach($ cont as $f) {echo $f->nome; echo' - ';}

// se o operador for == podemos escrever o where como abaixo 
> $cont = SiteContato::where('nome','Ronaldo Lamp')->get();

// Para acessar somente o segundo elemento da coleção,
// você pode usar o método get() ao invés do find(), e especificar
// o índice do elemento desejado
// (no caso, o índice 1 para o segundo elemento)
// usando o método get novamente.
> $colecao = SiteContato::whereIn('id', [1, 2])->get();
> $primeiroNome = $colecao->first()->nome; 
> $segundoNome = $colecao->get(1)->nome;
> echo $segundoNome;

> $c = SiteContato::where('mensagem','like','%para%')->get();
> $c = SiteContato::where('mensagem','like','%para%')->get()->get(1)->nome;
```

## Selecionando registros com whereIn() e whereNotIn()
Vamos utilizar o código abaixo para popularmos a base de dados
```php
> use \App\Models\SiteContato;
> SiteContato::create(['nome'=>'João','telefone'=>'(88) 91111-2222','email'=>'joao@contato.com.br','motivo_contato'=>3,'mensagem'=>'É muito difícil localizar a opção de listar todos os produtos']);
> SiteContato::create(['nome'=>'Rosa','telefone'=>'((33) 92222-3333','email'=>'rosa@contato.com.br','motivo_contato'=>1,'mensagem'=>'Quando custa essa aplicação?']);
SiteContato::create(['nome'=>'Fernando','telefone'=>'(11) 94444-5555','email'=>'fernando@contato.com.br','motivo_contato'=>1,'mensagem'=>'Como consigo criar multiplos usuários para minha empresa?']);
SiteContato::create(['nome'=>'Andre','telefone'=>'(88) 95555-6666','email'=>'andre@contato.com.br','motivo_contato'=>2,'mensagem'=>'Parabéns pela ferramenta, estou obtendo ótimos resultados!']);
> SiteContato::create(['nome'=>'Ana','telefone'=>'(33) 96666-7777','email'=>'ana@contato.com.br','motivo_contato'=>3,'mensagem'=>'Não gostei muito das cores, consigo mudar de tema?']);
> SiteContato::create(['nome'=>'Helena','telefone'=>'(11) 97777-8888','email'=>'helena@contato.com.br','motivo_contato'=>2,'mensagem'=>'Consigo controlar toda a minha empresa de modo fácil e prático.']);
```
Agora aos comandos  

```php 
> use \App\Models\SiteContato;
> $cont = SiteContato::whereIn('campo_a_ser_comparado_por_igual','[array_de_parametros]');  // Retorna um Builder
> $cont = SiteContato::whereNotIn('campo_a_ser_comparado_por_diferente',
'[array_de_parametros]');   // Retorna um Builder
> $cont->get();  // Retorna uma Collection
> $cont = SiteContato::whereIn('Motivo',[1,2])->get();  // Retorna uma Collection
> $cont = SiteContato::whereNotIn('Motivo',[1,2])->get();  // Retorna uma Collection
```
## Selecionando registros com whereBetween() e whereNotBetween()  
```php 
> use \App\Models\SiteContato;
> $cont = SiteContato::whereBetween('campo_a_ser_comparado_por_entre', '[array_de_parametros]'); // Retorna um Builder
> cont = SiteContato::whereBetween('id',[2,4])->get();  // Retorna uma Collection
> cont = SiteContato::whereNotBetween('id',[2,4])->get(); // Retorna uma Collection
```
## Selecionando registros com dois ou mais where()  
```php 
$contatos = SiteContato::where('nome','<>','Fernando')
        ->whereIn('motivo_contato',[1,2])
        ->whereBteween('created_at',['2020-08-01 00:00:00','2020-08-01 23:59:59'])->get();
// atenção que estamos trabalhando com o operador lógico AND 
```

## Selecionando registros com orWhere()
```php 
$contatos = SiteContato::where('nome','<>','Fernando')
        ->orWhereIn('motivo_contato',[1,2])
        ->orWhereBteween('created_at',['2020-08-01 00:00:00','2020-08-01 23:59:59'])->get();
// atenção que estamos trabalhando com o operador lógico OR 
```

## Selecionando registros com WhereNull() e whereNotNull()
```php 
> $contatos = SiteContato::whereNull('updated_at')->get();
> $contatos = SiteContato::whereNotNull('updated_at')->get();
```

## Selecionando registros com base em parametros data e hora
```php
> $cont = SiteContato::whereDate('created_at','2020-08-03')->get();
> $cont = SiteContato::whereDay('created_at','30')->get();
> $cont = SiteContato::whereMounth('created_at','8')->get();
> $cont = SiteContato::whereYear('created_at','2020')->get();
> $cont = SiteContato::whereTime('created_at','=','23:21')->get();
> $cont = SiteContato::whereTime('created_at','>=','23:21')->get();
```

## Selecionando registros com whereColumn() e orWhereColumn()
Este comando serve para comparar o conteudo de duas colunas,  
e ***<u>não considera valores null</u>***
```php
> contatos = SiteContato::whereColumn('created_at','updated_at')->get();
// quando se colocam somente o nome das colunas, a igualdade é testada.
> contatos = SiteContato::whereDate('created_at','updated_at')->get();
> contatos = SiteContato::whereDate('created_at','<>','updated_at')->get();
```

## Selecionando registros aplicando precedência em operações lógicas
Exemplo: **(nome = 'Jorge' or nome = 'Ana') and (motivo_contato in [1,2] or id entre [4 ,6])**
```php
> $cont = SiteContato::where(function($query){})->where(function($query){})

> $cont = SiteContato::where(function($query){
    $query->where('nome','Jorge')
    ->orWhere('nome','Ana');
    })
        ->where(function($query){
    $query->whereIn('motivo_contato',[1,2])
    ->orWhereBettwen('id',[4,6]);
    })->get()   //Retorna uma Collection
```

## Ordenando Registros
```php
> $cont = SiteContato::orderBy('nome')->ger();        //ordem ascendente
> $cont = SiteContato::orderBy('nome','asc')->ger();  //ordem ascendente
> $cont = SiteContato::orderBy('nome','desc')->ger(); //ordem descendente
```
Para ordenarmos mais de uma coluna ao mesmo tempo  
```php
> $cont = SiteContato::orderBy('motivo_contato')->orderBy('nome')->get();
```

## <u>Collections</u>
Métodos Disponíveis 
## Collection methods first, last e reverse
```php
$cont = SiteContato::where('id', '>', 3)->get()  // Temos uma collection
$cont->first();       // Retorna o primeiro elemento
$cont->last();        // Retorna o último elemento
$cont->reverse();     // Reverte a ordem da collection
```
## Collection toArray() e toJson()
```php
$cont->toArray();     // Converte a collection em um Array
$cont->toJson();      // Converte a collection em Json
```

## Collection pluck()
```php
$cont = SiteContato::all()
$cont->pluck('email');               //seleciona somente os campos email
$cont->pluck('email','nome');   //cria uma collection associativa
```
Outros métodos:  
Veja a documentação no link [collections](https://laravel.com/docs/10.x/collections#available-methods)

## Atualizando os registros com save()
```php
> use \App\MOdels\Fornecedor;
> $forn::Fornecedor::find(1);     // recuperamos o primeiro registro
> $forn->nome = 'Fornecedor 123';
> $forn->site = 'fornecedor123.com.br';
> $forn->email = 'contato@fornecedor123.com.br';
> $forn->save();
```

## Atualizando registros com fill() e save()
```php
> use \App\MOdels\Fornecedor;
> $forn2::Fornecedor::find(2);     // recuperamos o segundo registro
> $forn2->fill(['nome'=>'Fornecedor 789',
             'site'=>'fornecedor789.com.br',
             'email'=>'contato@fornecedor123.com.br'
             ]);
> $forn->save();
```

## Atualizando registros where() e update()






