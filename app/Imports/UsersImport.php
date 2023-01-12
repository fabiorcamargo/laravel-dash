<?php

namespace App\Imports;

use App\Http\Controllers\CademiController;
use App\Models\Cademi;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Events\AfterImport;

class UsersImport implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow, WithUpserts
{
    
    /**
     * @param array $row
     *
     * @return User|null
     */
    use Importable;

    public function model(array $row)
    {
        $s = count($row);
        
        $usr = (User::where('username', $row['username']));
    
        if (!empty($usr->first)){
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
        //dd($city);
        $document = preg_replace('/[^0-9]/', '', $row['document']);
        $city2 = City::where('id', $city)->first();
        $uf = State::where('id', $city2->state_id)->first();

        

        
        
        new User([
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
           'document' => $document,
           'seller' => $row['seller'],
           'courses' => $row['courses'],
           'active' => $row['active'],
        ]);
        //sleep($s*2);
        (new CademiController)->lote($row);
        
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