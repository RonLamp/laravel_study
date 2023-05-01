<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fornecedor;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // instanciando o objeto
        $fornec = new Fornecedor();
        $fornec->nome = 'Fornecedor100';
        $fornec->site = 'fornecedor100.com.br';
        $fornec->uf = 'CE';
        $fornec->email = 'contato@fornecedor100.com.br';
        $fornec->save();
        // ou podemos fazer da seguinte maneira
        // o método create (mas atenção para a propriedade fillable())
        Fornecedor::create([
            'nome'=>'Fornecedor200',
            'site'=>'fornecedor200.com.br',
            'uf'=>'RS',
            'email'=>'contato@fronecedor200.com.br'
        ]);
        Fornecedor::create([
            'nome'=>'Fornecedor300',
            'site'=>'fornecedor300.com.br',
            'uf'=>'SC',
            'email'=>'contato@fronecedor300.com.br'
        ]);
        // ou podemos usar o método insert(), embora como não passa pelo
        // eloquent, não é aconselhável o uso
        // DB::table('fornecedors')->insert([
        //     'nome'=>'Fornecedor300',
        //     'site'=>'fornecedor300.com.br',
        //     'uf'=>'SC',
        //     'email'=>'contato@fronecedor300.com.br'
        // ]);
    }
}
