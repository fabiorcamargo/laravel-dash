<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CademiController;
use App\Imports\UsersImportNew;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Avatar;
use App\Models\Cademi;
use App\Models\User;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TemporaryFileController extends Controller
{

    public function __construct(TemporaryFile $file, User $user, Avatar $avatar, Cademi $cademi)
    {
        $this->file = $file;
        $this->user = $user;
        $this->avatar = $avatar;
        $this->cademi = $cademi;
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
       
        $city = $request->city;
        $data = $this->file->where('folder', $request->image)->first();
        
        $folder =  $data->folder;
        $file =  "tmp/" . $data->folder . "/" . $data->file;
        $users = Excel::toArray(new UsersImport, "$file");
        //$users = $response[0];

        foreach ($users[0] as &$user)
        {
            $username = $user["username"];
            if ( ($u = User::where('username', $username)->first())){
                if($u->first == 2){
                    //dd('2');
                    $user["first"] = 2;
                } else if($u->first == 1){
                    //dd('1');
                    $user["first"] = 1;
                } else {
                    //dd('0');
                    $user["first"] = 0;
                }
            $user["exist"] = 1;
            }else{
            $user["exist"] = 0;
            }
            
        }

        

       return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('users', 'file', 'folder', 'city'));

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
        //dd($request->file());
        //dd('1');
        if ($this->avatar->where('user_id', Auth::user()->id)->first()){
            $avatar = $this->avatar->where('user_id', Auth::user()->id)->first();
            //dd($request->all());
            if($request->hasFile('filepond')){
                $image = $request->file('filepond');
               // dd($image);
                $file_name = $image->getClientOriginalName();
                $folder = Auth::user()->username;

                //$path = $request->file('image')->store('avatars', 'public');
                $image->storePubliclyAs('/' . $folder, $file_name, ['visibility'=>'public', 'disk'=>'avatar']);
    
                $avatar->update([
                    'folder' => 'avatar/' . $folder,
                    'file' => $file_name,
                ]);
                $user->update([
                    'image' => "avatar/$folder/$file_name",
                ]);
                //dd($user);
                return $folder;
            } else if($request->hasFile('image')){
                //dd("image");
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $folder = Auth::user()->username;
            $image->storePubliclyAs('/' . $folder, $file_name, ['visibility'=>'public', 'disk'=>'avatar']);

            Avatar::create([
                'folder' => 'avatar/' . $folder,
                'file' => $file_name,
                'user_id' => Auth::user()->id
            ]);
            //dd($user);
            $user->update([
                'image' => "avatar/$folder/$file_name",
            ]);
            return $folder;
        }
    } else if($request->hasFile('image')){
        //dd("image");
    $image = $request->file('image');
    $file_name = $image->getClientOriginalName();
    $folder = Auth::user()->username;
    $image->storePubliclyAs('/' . $folder, $file_name, ['visibility'=>'public', 'disk'=>'avatar']);

    Avatar::create([
        'folder' => 'avatar/' . $folder,
        'file' => $file_name,
        'user_id' => Auth::user()->id
    ]);
    //dd($user);
    $user->update([
        'image' => "avatar/$folder/$file_name",
    ]);
    return $folder;
}
        //dd("fim");
        
        return "";

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
        
            //return redirect()->route('cademi.store', "fabiotb");
           
            $file = $request->file;
            $folder = $request->folder;
            $users1 = Excel::toArray(new UsersImport, "$file");
           // dd($users1[0]);
            
            
            //dd("fim");
            //return redirect()->route('cademi.lote', $users[0][0]['username']);
            //Excel::import(new UsersImport, "$file");
            (new UsersImport)->queue(public_path($file));



            
           // (new CademiController)->lote($users1);
            
            
            

            //return redirect()->route('cademi.lote', ['file'=>$file, 'folder'=>$folder]);
            
            
            $tmp = TemporaryFile::where('folder', $folder);
            
            $success = "Verdade";
            Storage::deleteDirectory("tmp/" . $folder);
            $tmp->delete();

            return view('pages.app.user.lote', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('success'));
        

        
    
    }

    public function charge(Request $request)
    {
       
        $data = $this->file->where('folder', $request->image)->first();
        
        $folder =  $data->folder;
        $file =  "tmp/" . $data->folder . "/" . $data->file;
        $users = Excel::toArray(new UsersImport, "$file");
        //$users = $response[0];
        
        (new UsersImportNew)->queue(public_path($file));
        
        //(new UsersImportNew)->queue("storage/app/tmp/11-01-2023 12:47:34/User.xlsx");
        //dd($file);
        //Excel::Import(new UsersImportNew, "$file");
        
        //Excel::import(new UsersImportNew,"$file");

        //Excel::import(new UsersImportNew, "$file");
                
        $tmp = TemporaryFile::where('folder', $folder);
        
        $success = "Verdade";
        //Storage::deleteDirectory("tmp/" . $folder);
        $tmp->delete();

        return view('pages.app.user.charge', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('success'));
    


        
        /*
        foreach ($users[0] as &$user)
        {
            $username = $user["username"];

            if ( (User::where('username', $username)->first())){
            $user["exist"] = 1;
            }else{
            $user["exist"] = 0;
            }
            
        }
*/
    
       //return view('pages.app.user.charge', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('users', 'file', 'folder'));

    }

    public function getcharge()
    {
       
        $faileds = DB::select('select * from failed_jobs order by `failed_jobs`.`failed_at` desc');
 
        //dd($faileds);
        //dd(strstr($faileds[0]->exception,"\n",true));
        $i = 0;
        foreach($faileds as $failed){
            $fails[$i] = ["fail" => (strstr($failed->exception,"\n",true)), "date" => Carbon::createFromFormat('Y-m-d H:i:s', $failed->failed_at)->format('d/m/Y H:i:s')];
            $i++;
        }
        //dd($fails);
        
   

        return view('pages.app.user.charge', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('fails'));

    }

    public function openCsv2(Request $request){
        
       
        $file = $request->file;
        $folder = $request->folder;


        $users = Excel::toArray(new UsersImportNew, "$file");

        
        foreach ($users[0] as &$usr){
           
           $usr['cellphone'] = 61010;
           $usr['city'] = "Cidade";
           $usr['uf'] = "UF";
           $usr['payment'] = "VAZIO";
           $usr['10courses'] = "NÃO";
           $usr['secretary'] = "NÃO";
           $usr['document'] = 61010;
           $usr['seller'] = "ISA";
           $usr['courses'] = "NÃO";
           
        }
        (new UsersImportNew)->queue(public_path($file));
        
        //(new UsersImportNew)->queue("storage/app/tmp/11-01-2023 12:47:34/User.xlsx");
        //dd($file);
        //Excel::Import(new UsersImportNew, "$file");
        
        //Excel::import(new UsersImportNew,"$file");

        //Excel::import(new UsersImportNew, "$file");
                
        $tmp = TemporaryFile::where('folder', $folder);
        
        $success = "Verdade";
        //Storage::deleteDirectory("tmp/" . $folder);
        $tmp->delete();

        return view('pages.app.user.charge', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb'], compact('success'));
    
}



public function AvatarCorrect()
{
    $users = User::all();
    foreach ($users as $user){
        //dd($user);
        if ($avatar = $this->avatar->where('user_id', $user->id)->first()){
            //dd("$avatar->folder/$avatar->file");
            $user->update([
                'image' => "$avatar->folder/$avatar->file",
            ]);
            echo "$avatar->folder/$avatar->file";

        }
            
    }
    

}

        public function img_product_upload(Request $request)
            {

                $produto = ($_COOKIE['name']);

                    if($request->hasFile('image')){
                        $image = $request->file('image');
                        $file_name = $image->getClientOriginalName();
                        $file = $image->storePubliclyAs('/' . $produto , $file_name, ['visibility'=>'public', 'disk'=>'product']);
                    }

                
                    return [$produto . '/' .$file_name,];
                }

                public function img_product_delete(Request $request)
                {
    
                    $produto = ($_COOKIE['name']);
                    $delete = Storage::deleteDirectory('product/' . $produto);
                     
                        return [$delete];
                    }
        

    }



