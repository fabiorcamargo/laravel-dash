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
}