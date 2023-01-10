<?php

namespace App\Imports;

use App\Models\Cademi;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class UsersImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    use Importable;

    public function model(array $row)
    {
        
        
        
        return new User([
           'username' => $row['username'],
           'email' => $row['email'],
           'name' => $row['name'],
           'lastname' => $row['lastname'],
           'password' => Hash::make($row['password']),
           'cellphone' => $row['cellphone'],
           'city' => $row['city'],
           'uf' => $row['uf'],
           'payment' => $row['payment'],
           'role' => $row['role'],
           '10courses' => $row['10courses'],
           'secretary' => $row['secretary'],
           'document' => $row['document'],
           'seller' => $row['seller'],
           'courses' => $row['courses'],
           'active' => $row['active'],
        ]);

        
    }
    public function chunkSize(): int
    {
        return 10;
    }
    public function uniqueBy()
    {
        return 'username';
    }
   
}