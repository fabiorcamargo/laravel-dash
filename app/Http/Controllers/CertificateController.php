<?php

namespace App\Http\Controllers;

use App\Models\UserCertificatesCondition;
use App\Models\UserCertificatesEmit;
use App\Models\UserCertificatesModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use stdClass;

class CertificateController extends Controller
{


    public function create(Request $request){
        //dd($request->all());

        UserCertificatesModel::create([
            'type' => $request->type,
            'name' => $request->name,
            'hours' => $request->hours,
            'content' => $request->conteudo,
            'body' => json_encode(['condition'=>'x'])
        ]);
        return back()->with('status', "Certificado $request->name criado com sucesso");

    }
    public function edit($id, Request $request){
        //dd($request->all());
        $certificate = UserCertificatesModel::find($id);
        //dd($certificate);
        $certificate->update([
            'type' => $request->type,
            'name' => $request->name,
            'hours' => $request->hours,
            'content' => $request->conteudo,
            'body' => json_encode(['condition'=>'x'])
        ]);

        return back()->with('status', "Certificado $request->name atualizado com sucesso");

    }
    public function delete($id){


    }

    public function pdf($code){
        
        $cert = (UserCertificatesEmit::where('code', $code)->first());

            $pdf = Pdf::loadView('pdf.cert-view', compact('cert'))
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'defaultFont' => "Roboto",
                    'tempDir' => public_path(),
                    'chroot' => public_path('storage'),
                    'enable_remote' => true,
                    'isRemoteEnabled' => true,
                    'dpi' => '120'
                ]);
                return $pdf->download("$cert->code.pdf");
                
                //return $pdf->stream('pdf.cert-view');
                //return view('pdf.certificate2', compact('cert'));

    }
    public function view($code){
        
        $cert = (UserCertificatesEmit::where('code', $code)->first());

            $pdf = Pdf::loadView('pdf.cert-view', compact('cert'))
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'defaultFont' => "Roboto",
                    'tempDir' => public_path(),
                    'chroot' => public_path('storage'),
                    'enable_remote' => true,
                    'isRemoteEnabled' => true,
                    'dpi' => '120'
                ]);
                //return $pdf->download('invoice.pdf');
                
                //return $pdf->stream('pdf.cert-view');
                return view('pdf.certificate2', compact('cert'));

    }

    public function condition_create(Request $request){
        //dd($request->all());
        $percent = str_replace("%", "", $request->percent);
        //dd($percent);
        $body = (json_decode($request->course_list));
        $json = json_encode($body);

        //dd($json);
        UserCertificatesCondition::create([
            'user_certificates_models_id' => $request->model,
            'name' => $request->name,
            'type' => $request->type,
            'percent' => $percent,
            'body' => $json
        ]);

        return back()->with('status', "Condição $request->name criada com sucesso");
    }
    
    public function condition_del($id){

        $condition = UserCertificatesCondition::find($id);
        $condition->delete();

        return back()->with('status', "Condição $condition->name excluída com sucesso");
    }
}
