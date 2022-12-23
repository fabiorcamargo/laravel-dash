<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new User([
           'username' => $row['username'],
           'name' => $row['name'],
           'email' => $row['email'],
           'password' => Hash::make($row['password']),
           'role' => $row['role'],
           'cellphone' => $row['cellphone'],
           'city' => $row['city'],
           'uf' => $row['uf'],
           'payment' => $row['payment'],
           '10courses' => $row['10courses'],
           'secretary' => $row['secretary'],
           'document' => $row['document'],
           'seller' => $row['seller'],
           'courses' => $row['courses']
        ]);
    }
}