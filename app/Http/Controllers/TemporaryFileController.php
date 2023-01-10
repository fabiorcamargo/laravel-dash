<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;




use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TemporaryFileController extends Controller
{

    public function __construct(TemporaryFile $file, User $user, Avatar $avatar)
    {
        $this->file = $file;
        $this->user = $user;
        $this->avatar = $avatar;
    }
    

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/storage/app/');

        $this->artisan('migrate');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    public function store(Request $request)
    {
       
        
        $data = $this->file->where('folder', $request->image)->first();
        
        $folder =  $data->folder;
        $file =  "tmp/" . $data->folder . "/" . $data->file;
        $users = Excel::toArray(new UsersImport, "$file");
        //$users = $response[0];

        foreach ($users[0] as &$user)
        {
            $username = $user["username"];
            if ( (User::where('username', $username)->first())){
            $user["exist"] = 1;
            }else{
            $user["exist"] = 0;
            }
            
        }

        

       return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('users', 'file', 'folder'));

    }
    public function tmpUpload(Request $request)
    {



        /*
        $filepond = app(\Sopamo\LaravelFilepond\Filepond::class);
        $disk = config('filepond.temporary_files_disk');
        
        $data = (object)$request->all();
        $serverId = $data->file;
        $path = $filepond->getPathFromServerId($serverId);
        
        Storage::move($path, 'files/csv/' . Str::random());

        $filepond->delete($serverId);
            dd($request);
            //$this->file->create($data);
        
*/
    }

    public function FilepondUpload(Request $request)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $folder = date('d-m-Y H:i:s');
            $image->storeAs('tmp/' . $folder, $file_name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name
            ]);
            return $folder;
        }
        return '';

    }

    public function FilepondDelete(Request $request)
    {
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        
        
        if (isset($tmp_file)) {
            Storage::deleteDirectory('tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            
            return "Delete: " . $tmp_file->folder;
        }
        return '';
    }

    public function AvatarUpload(Request $request)
    {
        $user = $this->user->where('id', Auth::user()->id)->first();
        if ($avatar = $this->avatar->where('user_id', Auth::user()->id)->first()){
           // dd($data);
            if($request->hasFile('image')){
                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
                $folder = Auth::user()->username;

                //$path = $request->file('image')->store('avatars', 'public');
                $image->storePubliclyAs('/' . $folder, $file_name, ['visibility'=>'public', 'disk'=>'avatar']);
    
                $avatar->update([
                    'folder' => 'avatar/' . $folder,
                    'file' => $file_name,
                ]);
                $user->update([
                    'image' => 'avatar/' . $folder . "/" . $file_name,
                ]);
                return $folder;
            }

        } else if($request->hasFile('image')){
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $folder = Auth::user()->username;
            $image->storePubliclyAs('/' . $folder, $file_name, ['visibility'=>'public', 'disk'=>'avatar']);

            Avatar::create([
                'folder' => $folder,
                'file' => $file_name,
                'user_id' => Auth::user()->id
            ]);
            $user->update([
                'image' => $folder . "/" . $file_name,
            ]);
            return $folder;
        }
        return '';

    }

     

    public function AvatarDelete(Request $request)
    {
        $user = $this->user->where('id', Auth::user()->id)->first();
        $avatar = Avatar::where('folder', request()->getContent())->first();
        
        if (isset($avatar)) {
            Storage::deleteDirectory('avatar/' . $avatar->folder);
            $avatar->delete();
            $user->update([
                'image' => null,
            ]);
            return "Delete: " . $avatar->folder;
        }
        return '';
    }



    public function openCsv(Request $request){


            $file = $request->file;
            $folder = $request->folder;
            $users = Excel::toArray(new UsersImport, "$file");
            //dd($users[0][0]);
            foreach ($users[0] as &$user){
                $username = $user["username"];
                
                return redirect()->route('cademi.lote', $username);
                dd($username);
            }

            //return redirect()->route('cademi.lote', ['file'=>$file, 'folder'=>$folder]);
            
            /*
            $tmp = TemporaryFile::where('folder', $folder);

            $users = Excel::import(new UsersImport, "$file");
            
            $success = "Verdade";
            Storage::deleteDirectory("tmp/" . $folder);
            $tmp->delete();

            return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('success'));
        */

        
    
    }
}
