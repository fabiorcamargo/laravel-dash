<?php

namespace App\Jobs\Cademi;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ProductProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $product;
    protected $cademi_user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $cademi_user, $product)
    {
        $this->user = $user;
        $this->cademi_user = $cademi_user;
        $this->product = $product;
        
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product_status = new stdClass;
        $product_status->id = $this->product->product;   
        sleep(1);
        $response = Http::withToken(env('CADEMI_TOKEN_API'))->get('https://profissionaliza.cademi.com.br/api/v1/usuario/progresso_por_produto/' . $this->cademi_user . '/' . $this->product->product);
        
                    if ($response->status() == 200) {
                        $data = (json_decode($response->body(), true));
                        $product_status->percent = (float)str_replace('%', '', $data['data']['progresso']['total']);

                       
                        $this->product->update([
                                'percent' => (float)$product_status->percent
                            ]);
                        }else{
                            $this->product->update([
                                'percent' => 0
                            ]);
                        }
                    }
    }