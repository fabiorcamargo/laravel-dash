<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Models\Avatar;
use App\Models\City;
use App\Models\State;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    protected $model;

    public function __construct(User $user, State $state, City $cities, TemporaryFile $file, Avatar $avatar)
    {
        $this->user = $user;
        $this->state = $state;
        $this->cities = $cities;
        $this->file = $file;
        $this->avatar = $avatar;
        
    }

    public function index(Request $request)
    {
        $users = $this->user
                        ->getUsers(
                            search: $request->search ?? ''
                        );

        return view('users.index', compact('users'));
        
    }

    public function show($id)
    {
        // $user = $this->model->where('id', $id)->first();
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        return view('users.show', compact('user'));
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        $data = $request->all();
        $user = auth()->user();
        
        $data['password'] = bcrypt($request->password);
        $de = array('.','-');
        $para = array('','');
        $data['document'] = str_replace($de, $para, $request->document);
        $de = array('(',')',' ','-');
        $para = array('','','','');
        $data['cellphone'] = str_replace($de, $para, $request->cellphone);
        if ($request->image) {
            $data['image'] = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }
        
        $response = json_decode(($this->model->create($data)), true);

        $id = ($response['id']);
        //return redirect()->route('users.show', $id);
        
        return redirect()->route('cademi.create', $id);
        

        //return redirect()->route("/users/$id/cademi/create")->$response;

        // $user = new User;
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // $user->save();
    }

    public function edit($id)
    {
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        return view('users.edit', compact('user'));
    }

    public function update(StoreUpdateUserFormRequest $request, $id)
    {
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        $data = $request->only('name', 'email');
        if ($request->password)
            $data['password'] = bcrypt($request->password);

        if ($request->image) {
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            $data['image'] = $request->image->store('users');
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        if (!$user = $this->user->find($id))
            return redirect()->route('users.index');

        $user->delete();

        return redirect()->route('users.index');
    }

    public function getUsers() {
        $students = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
      }

    public function list(Request $request)
    {
        $users = $this->user
                        ->all(
                            
                        );

                       

        return view('pages.app.user.list', ['title' => 'Alunos | teste', 'breadcrumb' => 'This Breadcrumb'], compact('users'));
    }

    public function resp(Request $request)
    {
        $users = $this->user
                        ->getUsers(
                            search: $request->search ?? ''
                        );

        return view('pages.app.user.list', ['title' => 'Alunos | teste', 'breadcrumb' => 'This Breadcrumb'], compact('users'));
    }

    public function create(Request $request)
    {

        
        return view('pages.app.user.create', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function lote(Request $request)
    {

        
        return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function username()
    {
        $field = [['name'=> Auth::user()->name],
        ['email'=> Auth::user()->email]
    ];
        return compact($field);
    }

    public function post(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);
        $user->first = 1;
        ;
        $data = $request->all();
        $user->password = bcrypt($request->password);
        $de = array('.','-');
        $para = array('','');
        $user->document = str_replace($de, $para, $request->document);
        $de = array('(',')',' ','-');
        $para = array('','','','');
        $user->cellphone = str_replace($de, $para, $request->cellphone);
        if ($request->image) {
            $user->image = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }
        $user->name = $request->name;
        $user->lastname = $request->name;
        $user->email = $request->email;

        $city = preg_replace('/[^0-9]/', '', $data['city']);
        $city2 = City::where('id', $city)->first();
        $uf = State::where('id', $city2->state_id)->first();
        

        $user->city = $city2->name;
        $user->uf = $uf->abbr;
        
        //dd($user);
        $user->update();
        
        
        
        return view('pages.aluno.second', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
    }


    public function my(){
/*
        $avatar = $this->avatar->where('user_id', Auth::user()->id)->first();
        
        

        return view('pages.aluno.my', ['title' => 'Alunos | teste', 'breadcrumb' => 'This Breadcrumb', 'avatar' => 'teste']);
        */
        

        $data = $this->avatar->where('user_id', Auth::user()->id)->first();
        if ( $data != null ){
            $avatar =  $data->folder . "/" . $data->file;
        } else {
            $avatar = "/default.jpeg";
        }
        
        


        return view('pages.aluno.my', ['title' => 'Alunos | teste', 'breadcrumb' => 'This Breadcrumb', 'avatar' => $avatar]);

    }

    public function newids(Request $request){

        $users = User::factory()
                ->count(10)
                ->state(new Sequence(
                    ['admin' => 'Y'],
                    ['admin' => 'N'],
                ))
                ->create();
        
        $data = $request->all();
        dd($data);
        $data['password'] = bcrypt($request->password);
        $de = array('.','-');
        $para = array('','');
        $data['document'] = str_replace($de, $para, $request->document);
        $de = array('(',')',' ','-');
        $para = array('','','','');
        $data['cellphone'] = str_replace($de, $para, $request->cellphone);
        if ($request->image) {
            $data['image'] = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }
            
        
        $response = json_decode(($this->model->create($data)), true);

        $id = ($response['id']);
        
               
                
                
        
        
                return view('pages.aluno.my', ['title' => 'Alunos | teste', 'breadcrumb' => 'This Breadcrumb']);
        
            }


        public function charge(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['image'] = 'avatar/default.jpeg';
        dd($data);
        $user->update($data);
        
        
        return view('pages.aluno.charge', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
    }

    public function reset(Request $request)
    {
        
        $data = $request->all();
        //dd($data['username']);
        $user = $this->user->where('username', $data['username'])->first();
        
        $data['password'] = bcrypt($request->password);
        
        //dd($data);
        $user->update($data);
        
        
        return view('pages.aluno.my', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb', 'avatar' => "Auth::user()->id"]);
    }
    
}


