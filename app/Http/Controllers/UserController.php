<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    protected $model;

    public function __construct(User $user, State $state, City $cities)
    {
        $this->user = $user;
        $this->state = $state;
        $this->cities = $cities;
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
                        ->getUsers(
                            search: $request->search ?? ''
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

}


