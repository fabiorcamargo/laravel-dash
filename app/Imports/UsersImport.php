<?php

namespace App\Imports;

use App\Models\Cademi;
use App\Models\City;
use App\Models\State;
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
        
        $usr = (User::where('username', $row['username'])->first());
        //dd($usr);
        if ($usr->first == 1){
            $name = $usr->name;
            $lastname = $usr->lastname;
            $email = $usr->email;
            $password = $usr->password;
            $cellphone = $usr->cellphone;
            $image = $usr->image;
            $first = $usr->first;
        } else {
            $email = $row['email2'];
            $password = Hash::make($row['password']);
        }

        $city = preg_replace('/[^0-9]/', '', $row['city2']);
        $city2 = City::where('id', $city)->first();
        $uf = State::where('id', $city2->state_id)->first();
        //dd($email);

        
        
        return new User([
           'username' => $row['username'],
           'email' => $email,
           'email2' => $row['email2'],
           'name' => $row['name'],
           'lastname' => $row['lastname'],
           'password' => $password,
           'cellphone2' => $row['cellphone2'],
           'city2' => $city2->name,
           'uf2' => $uf->abbr,
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