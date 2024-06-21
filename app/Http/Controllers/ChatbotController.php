<?php

namespace App\Http\Controllers;

use App\Models\Cademi;
use App\Models\CademiTag;
use App\Models\ChatbotGroup;
use App\Models\City;
use App\Models\EcoSeller;
use App\Models\State;
use App\Models\User;
use App\Models\WpGroup;
use App\Models\WpGroupCategory;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function group_create(Request $request)
    {

        $group = new ChatbotGroup();
        $group->create([]);
    }

    public function list()
    {

        // $users = User::where('role', 7)->get();
        // $sellers = EcoSeller::where('type', 2)->get();
        $groups = WpGroup::all();

        return view('pages.app.group.list', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('groups'));
    }

    public function category()
    {

        // $users = User::where('role', 7)->get();
        // $sellers = EcoSeller::where('type', 2)->get();
        $categories = WpGroupCategory::all();

        return view('pages.app.group.category', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('categories'));
    }

    public function category_create(Request $request)
    {
        //dd($request->all());
        WpGroupCategory::create([
            'name' => $request->name
        ]);

        return back();
    }

    public function img_up(Request $request, $id)
    {


        $product = WpGroupCategory::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();

            $image->storePubliclyAs("/group/$product->id", $file_name, ['visibility' => 'public', 'disk' => 'product']);
            $img = "/product/group/$product->id" . '/' . $file_name;
            $product->img = $img;
            $product->save();
        }

        return "$img";
    }

    public function img_rm(Request $request, $id)
    {
        dd($request->all());
    }

    public function group_add_show()
    {

        // $users = User::where('role', 7)->get();
        // $sellers = EcoSeller::where('type', 2)->get();
        $tags = CademiTag::all();
        $groups = WpGroup::all();

        //dd($groups->first()->wpGroupCategory);
        $categories = WpGroupCategory::all();


        return view('pages.app.group.add', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'This Breadcrumb'], compact('tags', 'groups', 'categories'));
    }

    public function group_add_create(Request $request)
    {

        $request->validate([
            'category' => 'required',
            'cademi_code' => 'required',
            'name' => 'required|string',
            'link' => 'required|url',
            'inicio' => 'required|date|before_or_equal:fim',
            'fim' => 'required|date|after_or_equal:inicio',
        ]);

        $category = WpGroupCategory::find($request->category);


        $category->wpGroups()->create([
            'cademi_code' => $request->cademi_code,
            'name' => $request->name,
            'description' => $request->description,
            'link' => $request->link,
            'inicio' => $request->inicio,
            'fim' => $request->fim,
        ]);

        return back()->with('success', 'Grupo criado com sucesso');
    }

    public function group_update(Request $request)
    {

        //dd($request->all());
        $group = WpGroup::find($request->id);

        $group->update([
            'name' => $request->name,
            'description' => $request->description,
            'link' => $request->link,
            'inicio' => $request->inicio1,
            'fim' => $request->fim1,
        ]);

        return back()->with('success', 'Grupo atualizado com sucesso');
    }

    public function group_delete($id){

        //dd($request->all());
        $group = WpGroup::find($id);
        $group->delete();
        

    return back()->with('success', 'Grupo excluído com sucesso');  

}
    public function my_group()
    {
    }
}
