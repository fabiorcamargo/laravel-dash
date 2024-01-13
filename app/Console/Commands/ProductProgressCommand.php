<?php

namespace App\Console\Commands;

use App\Jobs\Cademi\ProductProgress;
use App\Models\Cademi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProductProgressCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProductProgressCommand:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $users = User::all();

        foreach($users as $user){

            $inputDate = Carbon::parse($user->access_date == null ? Carbon::now() : $user->access_date);
            
            $now = Carbon::now();
            $differenceInHours = $inputDate->diffInHours($now);

        if ($differenceInHours < 24) {
            //Passa por todos os usuários
            if($user->CademiProgress()->first() !== null){
                
                $products = $user->CademiProgress()->get();
                $cademi = $user->cademis()->first();

                //Passa por todos os produtos
                foreach($products as $product){
                    (new ProductProgress($user, $cademi->user, $product));
                }
            }
        }
    }

        return Command::SUCCESS;
    }
}
