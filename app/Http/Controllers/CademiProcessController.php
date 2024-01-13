<?php

namespace App\Http\Controllers;

use App\Jobs\Cademi\ProductProgress;
use App\Jobs\CademiProgress;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CademiProcessController extends Controller
{
    public function execute($users, $i){

            foreach ($users as $user) {
                $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
                if ($user->CademiProgress()->first() !== null) {
                    $products = $user->CademiProgress()->orderBy('updated_at', 'desc')->get();
                    $update_date = Carbon::parse($products[0]->updated_at);
                    //if ($inputDate > $update_date) {
                        dispatch(new CademiProgress($user))->delay(now()->addSeconds($i));

                    //}
                    $i++;
                }else{
                    dispatch(new CademiProgress($user))->delay(now()->addSeconds($i));
                    $i++;
                }
            }
    

        
        foreach ($users as $user) {
            $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
            if ($user->CademiProgress()->first() !== null) {
                $products = $user->CademiProgress()->orderBy('updated_at', 'desc')->get();
                $update_date = Carbon::parse($products[0]->updated_at);
                //if ($inputDate > $update_date) {
                    $cademi = $user->cademis()->first();
                    //Passa por todos os produtos
                    foreach ($products as $product) {
                        dispatch(new ProductProgress($user, $cademi->user, $product))->delay(now()->addSeconds($i));
                        $i++;
                    }
                    
                //}
            }
        }


    }
}
