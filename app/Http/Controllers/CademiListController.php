<?php

namespace App\Http\Controllers;

use App\Models\CademiTag;
use Illuminate\Http\Request;

class CademiListController extends Controller
{

    public function req($url, $type, $payload){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => $type,
          CURLOPT_POSTFIELDS => $payload,
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . env('CADEMI_TOKEN_API'),
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        return $response;

        

        
    }


    public function list(){
        $products = CademiTag::all();
        return view('pages.app.cademi.list', compact('products'));
    }

    public function img_up(Request $request, $id){

        $product = CademiTag::find($id);
                      if($request->hasFile('image')){
                          $image = $request->file('image');
                          $file_name = $image->getClientOriginalName();
    
                          $image->storePubliclyAs("/cademi/$product->id" , $file_name, ['visibility'=>'public', 'disk'=>'product']);
                              $img = "/product/cademi/$product->id" . '/' .$file_name;
                              $product->img = $img;
                              $product->save();
                      }
  
                         return "$img";
      }
  
      public function img_rm(Request $request, $id){
        dd($request->all());
      }

      public function create_name(Request $request){
        //dd($request->all());
        $tag = CademiTag::find($request->id);
        //dd($tag);
        $tag->title = $request->title;
        $tag->save();

        $msg = "Tag $tag->tag_id | $tag->name, atualizado nome $tag->title com sucesso!";
        return back()->with('status', $msg);
      }

      public function get_courses_list(){

        $url = 'https://profissionaliza.cademi.com.br/api/v1/tag';
        $type = 'GET';
        $payload = '';
        $response = $this->req($url, $type, $payload);
        
        $tags = json_decode($response);
        $tags = $tags->data->itens;
        //dd($courses[0]->id);
        

        foreach($tags as $tag){
          if(CademiTag::where('tag_id', $tag->id)->first()){
          }else{
            
            CademiTag::create([
              'tag_id' => $tag->id,
              'name' => $tag->nome,
            ]);
          }
        }
        $status = "Lista atualizada com sucesso!";
        return back()->with('status', __($status));
        exit();
      }
  
}
