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
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Events\AfterImport;

class UsersImport implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow, WithUpserts, SkipsEmptyRows
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
        //dd($row);
        //$usr = (User::where('username', $row['username']));
        $user = User::where('username', $row['username'])->first();
        //dd($user);
        if (!empty($user->first)){
            $name = $user->name;
            $lastname = $user->lastname;
            $email = $user->email;
            $password = $user->password;
            $cellphone = $user->cellphone;
            $image = $user->image;
            $first = $user->first;
        } else {
            $email = $row['email2'];
            $password = Hash::make($row['password']);
        }

        $city = preg_replace('/[^0-9]/', '', $row['city2']);
        //dd($city);
        $document = preg_replace('/[^0-9]/', '', $row['document']);
        //$city2 = City::where('id', $city)->first();
        //$uf = State::where('id', $city2->state_id)->first();

        //dd($uf);

           $user->username = $row['username'];
           $user->email = $email;
           $user->email2 = $row['email2'];
           $user->name = $row['name'];
           $user->lastname = $row['lastname'];
           $user->password = $password;
           $user->cellphone2 = $row['cellphone2'];
           $user->city2 = $row['city2'];
           $user->uf2 = $row['city2'];
           $user->payment = $row['payment'];
           $user->role = $row['role'];
           //$user->ouro = $row['ouro'];
           $user->secretary = $row['secretary'];
           $user->document = $document;
           $user->seller = $row['seller'];
           $user->courses = $row['courses'];
           $user->active = $row['active'];
           //dd($user);
           $user->save();
                 
       
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