<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ChangePasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change passwords for specific users and log the changes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('document', '99999999999')->where('seller', 'IZA')->get();

        // Caminho do arquivo de log
        $filePath = storage_path('password_changes.txt');

        // Conteúdo do relatório
        $report = "Relatório de Troca de Senha - " . now() . "\n";
        $report .= "Senha: Futuro" . "\n\n";
        $report .= "Usuários:\n";

        // Itere sobre cada usuário, altere a senha e registre no relatório
        foreach ($users as $user) {
            $user->name = $user->username;
            $user->lastname = $user->username;
            $user->email = $user->username . "@profissionalizaead.com.br";
            $user->cellphone = $user->username;
            $user->city = 'Cidade';
            $user->uf = "UF";
            $user->first = null;
            $user->image = 'avatar/default.jpeg';
            $user->password = Hash::make('futuro');
            $user->access_date = null;
            $user->ip = null;
            $user->save();

            // Adicione informações do usuário ao relatório
            $report .= "ID: " . $user->id . ", Username: " . $user->username . "\n";

            // Retorne a linha alterada para o terminal
            $this->info('ID: ' . $user->id . ', Username: ' . $user->username . ' password changed successfully.');
        }

        // Salve o relatório em um arquivo TXT
        Storage::append('password_changes.txt', $report);

        $this->info('Senhas alteradas com sucesso e relatório gerado!');
        
        return Command::SUCCESS;
    }
}
