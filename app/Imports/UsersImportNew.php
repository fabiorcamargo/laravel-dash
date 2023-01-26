<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImportNew implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        if (DB::table('users')->where('username', $row["username"])->doesntExist()) {

        $user = new User([
            'username' => $row['username'],
            'email' => $row['email'],
            'name' => $row['username'],
            'lastname' => $row['username'],
            'password' => Hash::make($row['password']),
            'cellphone' => $row['username'],
            'city' => "Cidade",
            'uf' => "UF",
            'payment' => "VAZIO",
            'role' => "1",
            'ouro' => "0",
            'secretary' => "NÃO",
            'document' => 99999999999,
            'seller' => "IZA",
            'courses' => "NÃO",
            'active' => "1",
         ]);
        }
    }
    

    public function chunkSize(): int
    {
        return 200;
    }
}