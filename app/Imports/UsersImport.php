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

class UsersImport implements ToModel, WithChunkReading, WithHeadingRow, WithUpserts, SkipsEmptyRows
{

    
    /**
     * @param array $row
     *
     * @return User|null
     */
    use Importable;

    public function model(array $row)
    {
        //dd($_COOKIE['city']);
        $city = (preg_replace('/[^0-9]/', '', $_COOKIE['city']));
        $state = (City::find($city)->state_id);
        $state = State::find($state)->abbr;
        $city = (City::find($city)->name);
        
                
        $s = count($row);
        $user = User::where('username', $row['username'])->first();
        $r = str_replace(" ", "", $row['courses']);
        $courses = explode(",",  $r);

        foreach ($courses as $course){
        if(!isset($user->codesale)){
            $user->codesale = "CODD-$course-$user->username";
            } else {
                if(!str_contains($user->codesale, "CODD-$course-$user->username") ){
                    $user->codesale = $user->codesale . ", CODD-$course-$user->username";
                }
           }
        }
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
        $document = preg_replace('/[^0-9]/', '', $row['document']);

           $user->username = $row['username'];
           $user->email = $email;
           $user->email2 = $row['email2'];
           $user->name = $row['name'];
           $user->lastname = $row['lastname'];
           $user->password = $password;
           $user->cellphone2 = $row['cellphone2'];
           $user->city2 = $city;
           $user->uf2 = $state;
           $user->payment = $row['payment'];
           $user->role = $row['role'];
           $user->ouro = $row['ouro'];
           $user->secretary = $row['secretary'];
           $user->document = $document;
           $user->seller = $row['seller'];
           $user->courses = $row['courses'];
           $user->active = $row['active'];
           $user->observation = $row['observation'];
           $user->save();

        (new CademiController)->lote($row);

        (new CademiController)->get_user($user->id);
 
    }

    public static function afterImport(AfterImport $event)
    {
        
    }

    
    public function chunkSize(): int
    {
        return 200;
    }
    public function uniqueBy()
    {
        return 'username';
    }
}