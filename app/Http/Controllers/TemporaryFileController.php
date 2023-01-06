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
        

        $file = "/tmp/" . $data->folder . "/" . $data->file;
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

        

       return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('users', 'file'));

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
            $folder = uniqid('tmp', true);
            $image->storeAs('tmp/' . $folder, $file_name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name
            ]);
            return $folder;
        }
        return '';

    }

    public function AvatarUpload(Request $request)
    {
        
        if($request->hasFile('image')){
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $folder = uniqid('avatar', true);
            $image->storeAs('avatar/' . $folder, $file_name);
            Avatar::create([
                'folder' => $folder,
                'file' => $file_name,
                'user_id' => Auth::user()->id
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

    

    public function AvatarDelete(Request $request)
    {
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        
        if (isset($tmp_file)) {
            Storage::deleteDirectory('avatar/' . $tmp_file->folder);
            $tmp_file->delete();
            return "Delete: " . $tmp_file->folder;
        }
        return '';
    }



    public function openCsv(Request $request){
        
        
            $file = $request->file;
            $users = Excel::import(new UsersImport, "$file");
            //dd($users);
            $success = "Verdade";
            return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('success'));
        

        
    
    }
}
