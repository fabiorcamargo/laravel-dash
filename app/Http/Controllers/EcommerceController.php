<?php

namespace App\Http\Controllers;

use App\Models\EcoProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EcommerceController extends Controller
{
    public function add(Request $request){
        if (EcoProduct::where('course_id', $request->course_id)->first()){
            return back()->with('success', 'Id do curso já existe');
        } else if (EcoProduct::where('name', $request->name)->first()) {
            return back()->with('success', 'Nome do Curso já existe');
        }
       
        //dd($course);
    //dd($request->all());
        $product = $request->all();
        $product['image'] = json_encode(Storage::disk('product')->allFiles($product['name']));
        
        $product['price'] = (float)str_replace(",", ".", $product['price']);
        $product['public'] = ($request->public ? "1" : "0");
        $product['percent'] = (float)$request->percent/100;

        $eco = EcoProduct::create([
            "course_id" => $product['course_id'],
            "name" => $product['name'],
            "description" => $product['description'],
            "specification" => $product['specification'],
            "tag" => $product['tag'],
            "category" => $product['category'],
            "image" => $product['image'],
            "public" => $product['public'],
            "price" => $product['price'],
            "percent" => $product['percent'],
            "specification" => $product['specification'],
        ]);

        return redirect(getRouterValue() . "/eco/product/$eco->id");

        
        
    }

    public function product_show($id){
        $product = (EcoProduct::find($id));
        if($product->perc > 15 || $product->percent < 30){
            $product->perc = "<span class='badge badge-light-success mb-3'>" . $product->percent*100 . "% off</span>";
        }else if($product->perc > 30 || $product->percent < 60){
            $product->percent = "<span class='badge badge-light-warning mb-3'>" . $product->percent*100 . "% off</span>";
        }else if($product->perc > 60 || $product->percent < 80){
            $product->perc = "<span class='badge badge-light-danger mb-3'>" . $product->percent*100 . "% off</span>";
        }

        $product->oprice = ($product->price / (1-$product->percent));
        $product->image = json_decode($product->image);
        //dd($product);

        

        return view('pages.eco.detail', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('product'));
    }

    public function checkout_show($id){
        
        $product = (EcoProduct::find($id));
        if($product->perc > 15 || $product->percent < 30){
            $product->perc = "<span class='badge badge-light-success mb-3'>" . $product->percent*100 . "% off</span>";
        }else if($product->perc > 30 || $product->percent < 60){
            $product->percent = "<span class='badge badge-light-warning mb-3'>" . $product->percent*100 . "% off</span>";
        }else if($product->perc > 60 || $product->percent < 80){
            $product->perc = "<span class='badge badge-light-danger mb-3'>" . $product->percent*100 . "% off</span>";
        }

        $product->oprice = ($product->price / (1-$product->percent));

        //dd($product);

        

        return view('pages.eco.checkout', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb', 'prefixRouters' => 'modern-light-menu'], compact('product'));
    }
    public function checkout_post(Request $request){

        
        dd($request->all());


    }
}
