<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;



class UsersImportNew implements ToModel, ShouldQueue, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    public function model(array $row)
    {
        return new User([
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
            '10courses' => "0",
            'secretary' => "NÃO",
            'document' => $row['username'],
            'seller' => "IZA",
            'courses' => "NÃO",
            'active' => "1",
         ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
    
}