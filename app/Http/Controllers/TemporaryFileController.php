<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class TemporaryFileController extends Controller
{

    public function __construct(TemporaryFile $file)
    {
        $this->file = $file;
    }
    

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/storage/app/tmp/');

        $this->artisan('migrate');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    public function store(Request $request)
    {
       
       $data = $this->file->where('folder', $request->image)->first();


        
        $file = "/tmp/" . $data->folder . "/" . $data->file;
        TemporaryFileController::openCsv($file);
        
        return redirect()->route('user-lote');  

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

    public function FilepondDelete(Request $request)
    {
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        if ($tmp_file) {
            Storage::deleteDirectory('tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            return response();
        }
        return '';
    }

    public function openCsv($file){
        
        {
            Excel::import(new UsersImport, "$file");
            
            return redirect('/')->with('success', 'All good!');
        }
    
    }
}
