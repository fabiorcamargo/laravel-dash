<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImportNew implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow, SkipsEmptyRows
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

        $user = new User();
            $user->username = $row['username'];
            $user->email = $row['email'];
            $user->name = $row['username'];
            $user->lastname = $row['username'];
            $user->password = Hash::make($row['password']);
            $user->cellphone = $row['username'];
            $user->city = "Cidade";
            $user->uf = "UF";
            $user->payment = "VAZIO";
            $user->role = "1";
            $user->ouro = "0";
            $user->secretary = "NÃO";
            $user->document = 99999999999;
            $user->seller = "IZA";
            $user->courses = "NÃO";
            $user->active = "1";
            $user->save();
        }
    }
    

    public function chunkSize(): int
    {
        return 200;
    }
}