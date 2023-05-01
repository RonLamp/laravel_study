<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use App\Models\SiteContato;
class SiteContatoSeeder extends Seeder
{
    public function run(): void
    {
        // $contato = new SiteContato();
        // $contato->nome = 'Sistema SG1';
        // $contato->telefone = '(11)999101039';
        // $contato->email = 'lamp@rc12.net';
        // $contato->motivo_contato = 1;
        // $contato->mensagem = 'Estamos por aqui para reclamar!';
        // $contato->save();
        \App\Models\SiteContato::factory()->count(30)->create();
    }
}
