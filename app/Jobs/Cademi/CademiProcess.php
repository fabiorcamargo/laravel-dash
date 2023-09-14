<?php

namespace App\Jobs\Cademi;

use App\Jobs\CademiProgress;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CademiProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $i;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $i)
    {
        $this->users = $users;
        $this->i = $i;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->users as $user) {
            $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
            if ($user->CademiProgress()->first() !== null) {
                $products = $user->CademiProgress()->orderBy('updated_at', 'desc')->get();
                $update_date = Carbon::parse($products[0]->updated_at);
                //if ($inputDate > $update_date) {
                    dispatch(new CademiProgress($user))->delay(now()->addSeconds($this->i));
                //}
                $this->i++;
            }else{
                dispatch(new CademiProgress($user))->delay(now()->addSeconds($this->i));
                $this->i++;
            }
        }


    
    foreach ($this->users as $user) {
        $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
        if ($user->CademiProgress()->first() !== null) {
            $products = $user->CademiProgress()->orderBy('updated_at', 'desc')->get();
            $update_date = Carbon::parse($products[0]->updated_at);
            //if ($inputDate > $update_date) {
                $cademi = $user->cademis()->first();
                //Passa por todos os produtos
                foreach ($products as $product) {
                    dispatch(new ProductProgress($user, $cademi->user, $product))->delay(now()->addSeconds($this->i));
                    $this->i++;
                }
            //}
        }
    }

    }
}
