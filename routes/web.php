<?php

use App\Http\Controllers\{
    ApiController,
    ApiWhatsapp,
    CademiController,
    CademiListController,
    CertificateController,
    ChatbotAsset,
    ChatbotController,
    ConversionApiFB,
    EcoFlow,
    EcommerceController,
    FilepondController,
    FileUploadController,
    Flow,
    FormController,
    MktController,
    OldAsaasController,
    OuroModerno,
    RdController,
    RedirCademiController,
    TemporaryFileController,
    UserController,
    UserGetAccountable
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Asaas\AsaasConectController;
use App\Http\Controllers\Asaas\AsaasController;
use App\Http\Livewire\CreateTask;
use App\Jobs\Cademi\ProductProgress;
use App\Jobs\Certificates\CertCheck;
use App\Jobs\Certificates\CertEmit;
use App\Jobs\Mkt_resend_not_active;
use App\Jobs\UserMg_FailSend;
use App\Jobs\WhatsappBulkTemplate;
use App\Mail\SendMailUser;
use App\Mail\UserInvoiceSend;
use App\Mail\UserSign;
use App\Models\Cademi;
use App\Models\CademiListCourse;
use App\Models\EcoSeller;
use App\Models\OuroClient;
use App\Models\User;
use App\Models\UserCertificatesCondition;
use App\Models\UserCertificatesEmit;
use App\Models\UserCertificatesModel;
use App\Models\UserMessage;
use App\Models\UserNotification;
use App\Models\WhatsappApi;
use App\Models\WhatsappTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::middleware(['auth', 'can:admin'])->group(function () {




/**
 * ==============================
 *       @Router -  Aberta
 * ==============================
 */
Route::middleware(['auth'])->group(function () {


    Route::get('/test_ouro', function () {
      $url = "https://meuappdecursos.com.br/ws/v2/alunos/token/413851";
        $token = base64_encode(env('OURO_TOKEN') . ":");  
       
        // Substitua 'SEU_TOKEN_AQUI' pelo seu token de autenticação

// Crie uma instância do cliente Guzzle
$client = new Client();

// URL do endpoint que você deseja acessar

try {
    // Faça a solicitação GET com o cabeçalho de autenticação
    $response = $client->request('GET', $url, [
        'headers' => [
            'Authorization' => 'Basic ' . $token,
            // Outros cabeçalhos, se necessário
        ],
    ]);
    

    // Obtenha o corpo da resposta
    $data = $response->getBody()->getContents();

    // Faça algo com os dados da resposta, por exemplo, decodifique-os JSON
    $responseData = json_decode($data);

    dd($data);
    // Agora, $responseData contém os dados da resposta
    // Faça o que você precisa com os dados aqui
} catch (\GuzzleHttp\Exception\RequestException $e) {

dd($e);

    // Lidar com erros de solicitação, se houver algum
    // Por exemplo, você pode verificar $e->getResponse() para obter informações detalhadas sobre o erro.
}



    });

        

    Route::get('/autocomplete', [UserController::class, 'autocomplete'])->name('autocomplete');
    Route::get('/city/{id}', [UserController::class, 'city'])->name('city');
    Route::get('/wp/templates/{id}', [ApiWhatsapp::class, 'wp_templates'])->name('wp-templates');
    Route::get('/product/category/{id}', [EcommerceController::class, 'product_category'])->name('product-category');
    //Route::get('/test', [ChatbotAsset::class, 'queue_send']);
    Route::get('/test_mail', function () {
        $user = Auth::user();
        $cobranca = "https://profissionalizaead.com.br";
        Mail::to('fabio.xina@gmail.com')->send(new UserInvoiceSend($user, $cobranca));
        //Mail::to(Auth::user()->email)->send(new UserSign(Auth::user(), "Profissionaliza EAD - Cadastro Realizado"));
    }); //Mail::to("fabio.xina@gmail.com")->send(new SendMailUser(Auth::user())));

    Route::get('/usergetaccountable', [UserGetAccountable::class, 'get_accountable'])->name('usergetaccountable');






    Route::get('/login/{id}', function ($id) {
        if (Auth::user()->role >= 4) {
            $user = User::find($id);
            if ($user->role != 1) {
                $msg = "Só é permitido logar em um perfil de aluno!!!";
                return back()->withErrors(__($msg));
            } else {
                Auth::login($user);
                $msg = "Logado como $user->name $user->lastname cuidado todas as ações serão registradas no perfil do usuário";
                return Redirect::to('modern-dark-menu/aluno/my')->withErrors(__($msg));
            }
        } else {
            $msg = "Ação não permitida para esse usuário";
            return back()->withErrors(__($msg));;
        }
    })->name('aluno.redir');





    $prefixRouters = [
        'modern-light-menu', 'modern-dark-menu', 'collapsible-menu'
    ];



    foreach ($prefixRouters as $prefixRouter) {
        Route::prefix($prefixRouter)->group(function () {
            /**
             * ==============================
             *       @Router -  Student
             * ==============================
             */
            Route::prefix('/aluno/pay/')->group(function () {
                Route::get('/list/{id}', [OldAsaasController::class, 'list']);
            });

            Route::post('/avatar-upload', [TemporaryFileController::class, 'AvatarUpload']);
            Route::delete('/avatar-delete', [TemporaryFileController::class, 'AvatarDelete'])->name('avatar-delete');
            Route::get('/avatar-correct', [TemporaryFileController::class, 'AvatarCorrect'])->name('avatar-correct');
            Route::post('/form/code/send', [FormController::class, 'code_verify'])->name('form-code');

            Route::prefix('aluno')->group(function () {
                Route::get('/first', [UserController::class, 'first'])->name('aluno.first');
                Route::get('/pw_change', function () {
                    return view('pages.aluno.pw_change', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'Início']);
                })->name('aluno.pw_change');
                Route::post('/pw_change', [UserController::class, 'pw_change'])->name('user.pw_change-save');
                Route::post('/cpf_send', [UserController::class, 'cpf_send'])->name('user.cpf-send');

                Route::get('/second', function () {
                    return view('pages.aluno.second', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'Início', 'file' => 'teste']);
                })->name('aluno.second');
                Route::get('/finish', function () {
                    return view('pages.aluno.finish', ['title' => 'Profissionaliza EAD', 'breadcrumb' => 'Início', 'file' => 'teste']);
                })->name('aluno.finish');
                Route::post('/post', [UserController::class, 'post'])->name('aluno.post');
                Route::get('/my', [UserController::class, 'my'])->name('aluno.my');


                Route::get('/config', [UserController::class, 'username'])->name('config');
                Route::get('/payment/{id}', [AsaasConectController::class, 'Asaas_Create_id'])->name('aluno-payment');
                Route::get('/profile/{id}', [UserController::class, 'profile'])->name('aluno-profile');
                Route::get('/profile/{id}/edit', [UserController::class, 'profile_edit'])->name('aluno-profile-edit');
            });


            Route::prefix('app/eco')->group(function () {
                Route::get('/checkout/{id}/pay/{client}', [EcommerceController::class, 'checkout_client_pay'])->name('eco_checkout_client_pay-blank');
                Route::post('/checkout/{id}/end/{client}', [EcommerceController::class, 'checkout_pay_end_post'])->name('eco_checkout_end-client');
                Route::get('/checkout/{id}/status', [EcommerceController::class, 'checkout_end'])->name('eco_checkout_pay_status-blank');
                Route::get('/checkout_end', function () {
                    return view('pages.app.eco.checkout_end', ['title' => 'Profissionaliza EAD | Checkout ', 'breadcrumb' => 'checkout end']);
                })->name('eco_checkout_end-blank');
            });
        });
    };
});

/**
 * ==============================
 *       @Router -  admin
 * ==============================
 */

Route::middleware(['auth', 'can:edit'])->group(function () {

    Route::get('/autocomplete', [UserController::class, 'autocomplete'])->name('autocomplete');


    /**
     * =======================
     *      LTR ROUTERS
     * =======================
     */

    $prefixRouters = [
        'modern-light-menu', 'modern-dark-menu', 'collapsible-menu'
    ];



    foreach ($prefixRouters as $prefixRouter) {
        Route::prefix($prefixRouter)->group(function () {


            Route::post('/tmp-upload', [TemporaryFileController::class, 'FilepondUpload'])->name('tmp-upload');
            Route::delete('/tmp-delete', [TemporaryFileController::class, 'FilepondDelete'])->name('tmp-delete');
            Route::post('/img_product_upload/{id}', [TemporaryFileController::class, 'img_product_upload'])->name('img_product_upload');
            Route::delete('/img_product_delete{id}', [TemporaryFileController::class, 'img_product_delete'])->name('img_product_delete');



            Route::get('/users/{id}/comments/create', [CommentController::class, 'create'])->name('comments.create');
            Route::get('/users/{user}/comments/{id}', [CommentController::class, 'edit'])->name('comments.edit');
            Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
            Route::post('/users/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
            Route::get('/users/{id}/comments', [CommentController::class, 'index'])->name('comments.index');

            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
            Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::get('/users', [UserController::class, 'usercademi'])->name('users.index');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

            Route::post('/csv', [TemporaryFileController::class, 'openCsv'])->name('openCsv');
            Route::post('/store', [TemporaryFileController::class, 'store'])->name('store');

            Route::get('/users/asaas/index', [AsaasController::class, 'asaascliente'])->name('asaas.index');

            Route::get('/users/{id}/cademi/create', [CademiController::class, 'create'])->name('cademi.create');
            Route::get('/users/{id}/cademi', [CademiController::class, 'store'])->name('cademi.store');
            Route::post('/users/cademi/lote', [CademiController::class, 'lote'])->name('cademi.lote');
            Route::get('/users/cademi/verify', [ApiController::class, 'verify'])->name('cademi.verify');
            Route::get('/users/corr/email', [UserController::class, 'corr_email'])->name('cademi.corr_email');

            Route::get('/users/cademi/course_transf', [ApiController::class, 'course_transf'])->name('cademi.course_transf');

            Route::post('/users/cademi/change_token', [CademiController::class, 'change_token'])->name('user.cademi.change_token');
            Route::post('/user/obs/create/{id}', function ($id, Request $request) {
                //dd($request->all());
                $user = User::find($id);
                $user->observation()->create([
                    'obs' => $request->descricao
                ]);
                return back();
            })->name('user.obs.create');











            Route::get('/sss', function () {
                return view('welcome', ['title' => 'this is ome ', 'breadcrumb' => 'This Breadcrumb']);
            });





            /**
             * ==============================
             *       @Router -  Dashboard
             * ==============================
             */

            Route::prefix('dashboard')->group(function () {
                Route::get('/analytics', function () {
                    return view('pages.dashboard.analytics', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('analytics');
                Route::get('/sales', function () {
                    return view('pages.dashboard.sales', ['title' => 'Sales Admin | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('sales');
                Route::get('/my', function () {
                    return view('pages.dashboard.my', ['title' => 'Sales Admin | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                })->name('my');
            });

            /**
             * ==============================
             *        @Router -  Apps
             * ==============================
             */

            Route::prefix('app')->group(function () {

                Route::middleware(['can:secretary'])->group(function () {
                    Route::prefix('/user')->group(function () {
                        Route::any('/search', [UserController::class, 'search'])->name('user-search');
                        Route::get('/list', [UserController::class, 'list'])->name('user-list');
                        Route::get('/listschool', [UserController::class, 'listschool'])->name('user-listschool');
                        Route::get('/resp', [UserController::class, 'resp'])->name('user-resp');
                        Route::get('/create', [UserController::class, 'create'])->name('user-create');
                        Route::get('/lote', [UserController::class, 'lote'])->name('user-lote');
                        Route::post('/charge', [TemporaryFileController::class, 'charge'])->name('user-charge');
                        Route::post('/csv', [TemporaryFileController::class, 'openCsv2'])->name('user-csv');
                        Route::get('/profile/{id}', [UserController::class, 'profile'])->name('user-profile');
                        Route::get('/profile/{id}/courses', [UserController::class, 'courses_profile'])->name('user-courses');
                        Route::get('/profile/{id}/edit', [UserController::class, 'profile_edit'])->name('user-profile-edit');
                        Route::post('/profile/{id}/active', [UserController::class, 'active'])->name('user-profile-active');
                        Route::post('/profile/{id}/ouro-block', [UserController::class, 'block_ouro'])->name('ouro-block');
                        Route::post('/profile/{id}/cademi-block', [UserController::class, 'block_cademi'])->name('cademi-block');
                        Route::post('/profile/{id}/ouro-desblock', [UserController::class, 'desblock_ouro'])->name('ouro-desblock');
                        Route::post('/profile/{id}/cademi-desblock', [UserController::class, 'desblock_cademi'])->name('cademi-desblock');

                        Route::get('/profile/{id}/pay', [UserController::class, 'profile_edit'])->name('user-profile-edit');

                        Route::post('/profile/{id}/seller_create', [EcommerceController::class, 'create_seller'])->name('user-profile-seller-create');
                        Route::post('/profile/{id}/seller_delete', [EcommerceController::class, 'delete_seller'])->name('user-profile-seller-delete');
                        Route::get('/charge', [TemporaryFileController::class, 'getcharge'])->name('user-get-charge');

                        Route::get('/customer', [AsaasController::class, 'get_customer'])->name('user-get_customer');


                        Route::get('/newids', function () {
                            return view('pages.app.user.newids', ['title' => 'Profissionaliza EAD | Carregar Lista', 'breadcrumb' => 'Carregar Lista']);
                        });
                        Route::post('/newids', [UserController::class, 'newids'])->name('user-newids');
                        Route::post('/reset', [UserController::class, 'reset'])->name('user-reset');
                        Route::get('/reset', function () {
                            return view('pages.app.user.reset', ['title' => 'Profissionaliza EAD | Reset de Senha', 'breadcrumb' => 'Reset de Senha', 'avatar' => "Auth::user()->id"]);
                        })->name('user-reset');

                        Route::get('/ouro/show/{id}', [OuroModerno::class, 'bulk_user_show'])->name('user-ouro-show');
                        Route::get('/ouro/create', [OuroModerno::class, 'bulk_user_create_show'])->name('user-ouro-create-show');
                        Route::post('/ouro/create', [OuroModerno::class, 'bulk_user_create'])->name('user-ouro-create');
                        Route::delete('/ouro/delete/{id}', [OuroModerno::class, 'user_course_delete'])->name('user-ouro-course-delete');

                        Route::post('/ouro/course/liberation/{id}', [OuroModerno::class, 'ouro_create_liberation'])->name('ouro-create-liberation');

                        Route::post('/ouro/send', [OuroModerno::class, 'bulk_user_send'])->name('user-ouro-create');
                        Route::post('/ouro/combo/create', [OuroModerno::class, 'combo_create'])->name('user-ouro-combo-create');

                        Route::get(
                            '/fail_list',
                            function () {
                                //$msg = new UserMg_FailSend;
                                //dispatch($msg);
                                $failed = (UserMessage::where('status', 'not like', 201)->get());

                                return view('pages.aluno.msg_fail_list', compact('failed'));
                            }
                        )->name('msg-fail_list');

                        Route::post(
                            '/msg-del_list/{id}',
                            function ($id) {
                                $msg = UserMessage::find($id);
                                $status = $msg->delete();
                                //dd($status);

                                if ($status == "true") {
                                    $msg = "Msg $msg->id, excluída com sucesso!";
                                    return back()->with('status', $msg);
                                } else {
                                    $msg = "Msg $msg->id, não foi possível excluir!";
                                    return back()->withErrors(__($msg));
                                }
                                //return view('pages.aluno.msg_fail_list', compact('failed'));
                            }
                        )->name('msg-del_list');
                    });

                    Route::prefix('/pay')->group(function () {
                        Route::get(
                            '/create',
                            function () {
                                $sec = Auth::user()->secretary;
                                $sellers = (EcoSeller::where(['secretary' => "$sec", 'type' => '2'])
                                    ->get());
                                return view('pages.app.pay.create')->with('sellers', $sellers);
                            }
                        )->name('pay-create');
                        Route::get('/asaas/{cpf}', [OldAsaasController::class, 'lista_cliente_stoken'])->name('asaas-get-client');
                        Route::post('/create', [OldAsaasController::class, 'cria'])->name('pay-create-post');
                        Route::get('/cliente_existe', [OldAsaasController::class, 'cria_existe'])->name('pay-cliente_existe');
                    });

                    Route::prefix('/cert')->group(function () {
                        Route::get('/test', function () {
                            
                                               
                        
                           
                        
                        });
                        Route::get('/cademi/get_courses', [CademiController::class, 'get_courses_list'])->name('cademi_get_courses');
                        Route::get('/list', function () {
                            $certificates = UserCertificatesModel::all();
                            return view('pages.app.cert.list', compact('certificates'));
                        })->name('cert-list');

                        Route::get('/condition', function () {
                            $courses = CademiListCourse::all();
                            $conditions = UserCertificatesCondition::all();
                            $cademi_certificates = UserCertificatesModel::where('type', "cademi")->get();
                            $ouro_certificates = UserCertificatesModel::where('type', "ouro")->get();
                            return view('pages.app.cert.condition', compact('conditions', 'courses', 'cademi_certificates', 'ouro_certificates'));
                        })->name('cert-condition');
                        Route::post('/condition/create', [CertificateController::class, 'condition_create'])->name('post-condition-create');
                        Route::post('/condition/edit/{id}', [CertificateController::class, 'condition_edit'])->name('post-condition-edit');
                        Route::post('/condition/del/{id}', [CertificateController::class, 'condition_del'])->name('post-condition-del');
                        Route::get('/emit-list', function () {
                            $certificates = UserCertificatesEmit::paginate(20)->fragment('certificates');
                            $cert_models = UserCertificatesModel::all();
                            return view('pages.app.cert.emit-list', compact('certificates', 'cert_models'));
                        })->name('cert-emit-list');
                        Route::post('/create', [CertificateController::class, 'create'])->name('post-cert-create');

                        Route::post(
                            '/cert-del/{id}',
                            function ($id) {
                                $cert = UserCertificatesModel::find($id);
                                $status = $cert->delete();
                                //dd($status);

                                if ($status == "true") {
                                    $msg = "Certificado $cert->name, excluída com sucesso!";
                                    return back()->with('status', $msg);
                                } else {
                                    $msg = "Certificado $cert->name, não foi possível excluir!";
                                    return back()->withErrors(__($msg));
                                }
                                //return view('pages.aluno.msg_fail_list', compact('failed'));
                            }
                        )->name('cert-del');

                        Route::post(
                            '/cert-del-emit/{id}',
                            function ($id) {
                                $cert = UserCertificatesEmit::find($id);
                                $status = $cert->delete();
                                //dd($status);

                                if ($status == "true") {
                                    $msg = "Certificado $cert->code, excluída com sucesso!";
                                    return back()->with('status', $msg);
                                } else {
                                    $msg = "Certificado $cert->code, não foi possível excluir!";
                                    return back()->withErrors(__($msg));
                                }
                                //return view('pages.aluno.msg_fail_list', compact('failed'));
                            }
                        )->name('cert-del-emit');

                        Route::post('/edit/{id}', [CertificateController::class, 'edit'])->name('post-cert-edit');
                        Route::get('/emit/view/{code}', [CertificateController::class, 'view'])->name('cert-view');
                        Route::get('/emit/pdf/{code}', [CertificateController::class, 'pdf'])->name('cert-pdf');
                    });


                    Route::prefix('/mkt')->group(function () {
                        Route::get(
                            '/token',
                            [MktController::class, 'getToken']
                        )->name('mkt-token');




                        Route::get(
                            '/send_not_active/{name}/{phone}/{type}/{msg}/{user_id}',
                            [MktController::class, 'send_not_active']
                        )->name('mkt-send_not_active');
                        Route::post(
                            '/send_profile_msg/{id}',
                            [MktController::class, 'send_profile_msg']
                        )->name('mkt-send_profile_msg');
                        Route::get(
                            '/resend_not_active/{msg_id}',
                            function ($msg_id) {
                                $send = new MktController;
                                $send->resend_not_active($msg_id);

                                return back();
                            }
                        )->name('mkt-send_not_active');
                        //Route::post('/create', [OldAsaasController::class, 'result'])->name('pay-create-post');
                        //Route::get('/cliente_existe', [OldAsaasController::class, 'cliente_existe'])->name('pay-cliente_existe');
                    });

                    Route::prefix('/ouro')->group(function () {
                        Route::get('/list', [OuroModerno::class, 'show_list_alunos'])->name('ouro-list');
                        Route::any('/search', [OuroModerno::class, 'search'])->name('ouro-search');
                        Route::get('/show', [OuroModerno::class, 'show_list_courses'])->name('ouro-show');
                        Route::post('/img/up/{id}', [OuroModerno::class, 'img_up'])->name('ouro-img-up');
                        Route::delete('/img/rm/{id}', [OuroModerno::class, 'img_rm'])->name('ouro-img-rm');
                        Route::post('/combo/edit/{id}', [OuroModerno::class, 'combo_edit'])->name('user-ouro-combo-edit');
                        Route::delete('/combo/delete/{id}', [OuroModerno::class, 'combo_delete'])->name('user-ouro-combo-delete');
                        Route::get('/get/courses', [OuroModerno::class, 'get_courses_list'])->name('user-ouro-get-courses');
                        Route::get('/courses/correct-img', [OuroModerno::class, 'correct_img_course'])->name('user-ouro-courses-correct-img');
                    });

                    Route::prefix('/cademi')->group(function () {
                        Route::get('/list', [CademiListController::class, 'list'])->name('cademi-list');
                        Route::any('/search', [OuroModerno::class, 'search'])->name('cademi-search');
                        Route::get('/show', [OuroModerno::class, 'show_list_courses'])->name('cademi-show');
                        Route::post('/create_name', [CademiListController::class, 'create_name'])->name('cademi-create-name');
                        Route::post('/img/up/{id}', [CademiListController::class, 'img_up'])->name('cademi-img-up');
                        Route::delete('/img/rm/{id}', [CademiListController::class, 'img_rm'])->name('cademi-img-rm');
                        Route::get('/get/courses', [CademiListController::class, 'get_courses_list'])->name('user-cademi-get-courses');
                        Route::get('/courses/correct-img', [OuroModerno::class, 'correct_img_course'])->name('user-cademi-courses-correct-img');
                    });

                    Route::prefix('/group')->group(function () {
                        Route::get('/add', [ChatbotController::class, 'group_add_show'])->name('group-add-show');
                        Route::post('/add', [ChatbotController::class, 'group_add_create'])->name('group-add-create');
                    });
                    Route::prefix('/form')->group(function () {


                        //Route::get('/end/{id}', [FormController::class, 'end_show'])->name('fomr-end-show');
                        //Route::post('/end/{id}', [FormController::class, 'end_post'])->name('fomr-end-post');

                    });
                    Route::prefix('campaign')->group(function () {
                        Route::post('/add', [FormController::class, 'create'])->name('campaign-add');
                        Route::get('/add_course', [FormController::class, 'add_show_course_create'])->name('campaign-add-course');
                        Route::post('/add_course', [FormController::class, 'add_course_create'])->name('campaign-add-course');
                        Route::get('/correct_campaign', [FormController::class, 'correct_campaign'])->name('campaign-correct-campaign');
                        Route::get('/list', [FormController::class, 'list_campaigns'])->name('campaign-list-campaigns');
                        Route::get('/show/{id}', [FormController::class, 'list_leads'])->name('campaign-list-leads');
                        Route::get('/add', [FormController::class, 'add_show'])->name('campaign-add-show');
                        Route::get('/msg/template/create', [ApiWhatsapp::class, 'wp_msg_template_create'])->name('campaign-msg-template-create');
                        Route::post('/msg/template/create', [ApiWhatsapp::class, 'wp_msg_template_post'])->name('campaign-msg-template-post');
                        Route::post('/msg/template/bulk/send', [ApiWhatsapp::class, 'wp_msg_template_post'])->name('campaign-msg-template-post');
                        Route::post('/msg/template/send_test', [ApiWhatsapp::class, 'send_test'])->name('campaign-msg-template-send-test');
                        Route::get('/msg/send/wp/{id}', [ApiWhatsapp::class, 'wp_msg_form_send'])->name('campaign-msg-wp-send');
                        Route::post('/msg/send/wp/{id}', [ApiWhatsapp::class, 'bk_send'])->name('campaign-msg-wp-send');
                        Route::post('/msg/send/pro/{id}', [ApiWhatsapp::class, 'bulk_send'])->name('campaign-msg-bulk-send');
                        Route::get('/test', [OuroModerno::class, 'test']);
                    });
                });


                Route::prefix('/eco')->group(function () {
                    Route::get('/img/correct', [TemporaryFileController::class, 'correct_img_product'])->name('eco-img-correct');
                    Route::post('/add', [EcommerceController::class, 'add'])->name('eco-post-product');
                    Route::delete('/delete/{id}', [EcommerceController::class, 'delete_product'])->name('eco-delete-product');
                    Route::get('/list', [EcommerceController::class, 'show'])->name('eco-list');
                    Route::any('/shop', [EcommerceController::class, 'shop'])->name('eco-shop');
                    Route::get('/add', [EcommerceController::class, 'add_show'])->name('eco-add-show');
                    Route::get('/product/{id}/edit', [EcommerceController::class, 'edit'])->name('eco-edit');
                    Route::post('/product/{id}/edit', [EcommerceController::class, 'edit_save'])->name('eco-edit-save');
                    Route::get('/product/{id}', [EcommerceController::class, 'product_show'])->name('eco-product-show');
                    Route::get('/list_sales', [EcommerceController::class, 'list_sales'])->name('eco-list_sales');
                    Route::any('/list_sales/search', [EcommerceController::class, 'search_sales'])->name('eco-list_sales-search');
                    Route::get('/comment/add/', function () {
                        return view('pages.app.eco.add_comment', ['title' => 'Profissionaliza EAD | Novo Comentário', 'breadcrumb' => '']);
                    })->name('eco-comment_add-show');
                    Route::post('/post_comment/add/{id}', [EcommerceController::class, 'comment_add'])->name('eco-comment_add');
                    Route::delete('/delete_comment/{id}/{comment}', [EcommerceController::class, 'comment_delete'])->name('eco-comment-delete');
                    Route::get('/comment/{id}/{comment}', [EcommerceController::class, 'comment_edit'])->name('eco-comment_edit');
                    Route::post('/comment/{id}/{comment}', [EcommerceController::class, 'comment_save'])->name('eco-comment_save');



                    Route::get('/checkout/{id}', [EcommerceController::class, 'checkout_show'])->name('eco-checkout-show-blank');
                });


                Route::prefix('/flow')->group(function () {
                    Route::get('/add', [Flow::class, 'show_add'])->name('eco-flow-add-show');
                    Route::post('/add', [Flow::class, 'flow_add'])->name('eco-flow-add');
                    Route::get('/config_flow/{id}', [Flow::class, 'flow_config_show'])->name('eco-flow-config-show');
                    Route::get('/show/{id}', [Flow::class, 'flow_show'])->name('eco-flow-config-show');
                    Route::get('/list', [Flow::class, 'list'])->name('eco-flow-list');
                });

                //Coupon
                Route::prefix('/coupon')->group(function () {
                    Route::get('/add', [EcommerceController::class, 'coupon_create_show'])->name('eco-add_coupon-show');
                    Route::post('/add', [EcommerceController::class, 'coupon_create'])->name('eco-add_coupon');
                    Route::get('/list', [EcommerceController::class, 'list'])->name('eco-add-list');
                });




                Route::middleware(['can:api'])->group(function () {
                    Route::get('/calendar', function () {
                        return view('pages.app.calendar', ['title' => 'Javascript Calendar | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('calendar');

                    /*Route::get('/chat', function () {
                return view('pages.app.chat', ['title' => 'Chat Application | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
            })->name('chat');*/
                    Route::get('/chat', [ApiWhatsapp::class, 'chat_show'])->name('chat-show');
                    Route::get('/contacts', function () {
                        return view('pages.app.contacts', ['title' => 'Contact Profile | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('contacts');
                    Route::get('/mailbox', function () {
                        return view('pages.app.mailbox', ['title' => 'Mailbox | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('mailbox');
                    Route::get('/notes', function () {
                        return view('pages.app.notes', ['title' => 'Notes | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('notes');
                    Route::get('/scrumboard', function () {
                        return view('pages.app.scrumboard', ['title' => 'Scrum Task Board | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('scrumboard');
                    Route::get('/todo-list', function () {
                        return view('pages.app.todolist', ['title' => 'Todo List | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('todolist');

                    // Blog

                    Route::prefix('/blog')->group(function () {
                        Route::get('/create', function () {
                            return view('pages.app.blog.create', ['title' => 'Blog Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-create');
                        Route::get('/edit', function () {
                            return view('pages.app.blog.edit', ['title' => 'Blog Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-edit');
                        Route::get('/grid', function () {
                            return view('pages.app.blog.grid', ['title' => 'Blog | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-grid');
                        Route::get('/list', function () {
                            return view('pages.app.blog.list', ['title' => 'Blog List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-list');
                        Route::get('/post', function () {
                            return view('pages.app.blog.post', ['title' => 'Post Content | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-post');
                    });
                    /*
            // Ecommerce
            Route::prefix('/ecommerce')->group(function () {
                Route::get('/add', function () {
                    return view('pages.app.ecommerce.add', ['title' => 'Ecommerce Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-add');
                Route::get('/detail', function () {
                    return view('pages.app.ecommerce.detail', ['title' => 'Ecommerce Product Details | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-detail');
                Route::get('/edit', function () {
                    return view('pages.app.ecommerce.edit', ['title' => 'Ecommerce Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-edit');
                Route::get('/list', function () {
                    return view('pages.app.ecommerce.list', ['title' => 'Ecommerce List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-list');
                Route::get('/shop', function () {
                    return view('pages.app.ecommerce.shop', ['title' => 'Ecommerce Shop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('ecommerce-shop');
            });*/

                    // Invoice

                    Route::prefix('/invoice')->group(function () {
                        Route::get('/add', function () {
                            return view('pages.app.invoice.add', ['title' => 'Invoice Add | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-add');
                        Route::get('/edit', function () {
                            return view('pages.app.invoice.edit', ['title' => 'Invoice Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-edit');
                        Route::get('/list', function () {
                            return view('pages.app.invoice.list', ['title' => 'Invoice List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-list');
                        Route::get('/preview', function () {
                            return view('pages.app.invoice.preview', ['title' => 'Invoice Preview | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-preview');
                    });
                });

                /**
                 * ==============================
                 *    @Router -  Authentication
                 * ==============================
                 */

                Route::prefix('authentication')->group(function () {
                    // Boxed

                    Route::prefix('/boxed')->group(function () {
                        Route::get('/2-step-verification', function () {
                            return view('pages.authentication.boxed.2-step-verification', ['title' => '2 Step Verification Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('2Step');
                        Route::get('/lockscreen', function () {
                            return view('pages.authentication.boxed.lockscreen', ['title' => 'LockScreen Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('lockscreen');
                        Route::get('/password-reset', function () {
                            return view('pages.authentication.boxed.password-reset', ['title' => 'Password Reset Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('password-reset');
                        Route::get('/signin', function () {
                            return view('pages.authentication.boxed.signin', ['title' => 'SignIn Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signin');
                        Route::get('/signup', function () {
                            return view('pages.authentication.boxed.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signup');
                    });


                    // Cover

                    Route::prefix('/cover')->group(function () {
                        Route::get('/2-step-verification', function () {
                            return view('pages.authentication.cover.2-step-verification', ['title' => '2 Step Verification Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('2Step');
                        Route::get('/lockscreen', function () {
                            return view('pages.authentication.cover.lockscreen', ['title' => 'LockScreen Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('lockscreen');
                        Route::get('/password-reset', function () {
                            return view('pages.authentication.cover.password-reset', ['title' => 'Password Reset Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('password-reset');
                        Route::get('/signin', function () {
                            return view('pages.authentication.cover.signin', ['title' => 'SignIn Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signin');
                        Route::get('/signup', function () {
                            return view('pages.authentication.cover.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signup');
                    });
                });

                /**
                 * ==============================
                 *     @Router -  Components
                 * ==============================
                 */

                Route::prefix('component')->group(function () {
                    Route::get('/accordion', function () {
                        return view('pages.component.accordion', ['title' => 'Accordions | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('accordion');
                    Route::get('/bootstrap-carousel', function () {
                        return view('pages.component.bootstrap-carousel', ['title' => 'Bootstrap Carousel | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('bootstrap-carousel');
                    Route::get('/cards', function () {
                        return view('pages.component.cards', ['title' => 'Card | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('cards');
                    Route::get('/drag-drop', function () {
                        return view('pages.component.drag-drop', ['title' => 'Dragula Drag and Drop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('drag-drop');
                    Route::get('/flags', function () {
                        return view('pages.component.flags', ['title' => 'SVG Flag Icons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('flags');
                    Route::get('/fonticons', function () {
                        return view('pages.component.fonticons', ['title' => 'Fonticon Icon | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('fonticons');
                    Route::get('/lightbox', function () {
                        return view('pages.component.lightbox', ['title' => 'Lightbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('lightbox');
                    Route::get('/list-group', function () {
                        return view('pages.component.list-group', ['title' => 'List Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('list-group');
                    Route::get('/media-object', function () {
                        return view('pages.component.media-object', ['title' => 'Media Object | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('media-object');
                    Route::get('/modal', function () {
                        return view('pages.component.modal', ['title' => 'Modals | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('modal');
                    Route::get('/notification', function () {
                        return view('pages.component.notifications', ['title' => 'Snackbar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('notification');
                    Route::get('/pricing-table', function () {
                        return view('pages.component.pricing-table', ['title' => 'Pricing Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('pricing-table');
                    Route::get('/splide', function () {
                        return view('pages.component.splide', ['title' => 'Splide | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('splide');
                    Route::get('/sweetalerts', function () {
                        return view('pages.component.sweetalert', ['title' => 'SweetAlert | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('sweetalerts');
                    Route::get('/tabs', function () {
                        return view('pages.component.tabs', ['title' => 'Tabs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tabs');
                    Route::get('/timeline', function () {
                        return view('pages.component.timeline', ['title' => 'Timeline | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('timeline');
                });

                /**
                 * ==============================
                 *     @Router -  Elements
                 * ==============================
                 */
                Route::prefix('element')->group(function () {
                    Route::get('/alerts', function () {
                        return view('pages.element.alerts', ['title' => 'Alerts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('alerts');
                    Route::get('/avatar', function () {
                        return view('pages.element.avatar', ['title' => ' Avatar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('avatar');
                    Route::get('/badges', function () {
                        return view('pages.element.badges', ['title' => ' Badge | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('badges');
                    Route::get('/breadcrumbs', function () {
                        return view('pages.element.breadcrumbs', ['title' => ' Breadcrumb | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('breadcrumbs');
                    Route::get('/buttons', function () {
                        return view('pages.element.buttons', ['title' => 'Bootstrap Buttons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('buttons');
                    Route::get('/buttons-group', function () {
                        return view('pages.element.buttons-group', ['title' => 'Button Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('buttons-group');
                    Route::get('/color-library', function () {
                        return view('pages.element.color-library', ['title' => 'Color Library | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('color-library');
                    Route::get('/dropdown', function () {
                        return view('pages.element.dropdown', ['title' => ' Dropdown | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('dropdown');
                    Route::get('/infobox', function () {
                        return view('pages.element.infobox', ['title' => ' Infobox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('infobox');
                    Route::get('/loader', function () {
                        return view('pages.element.loader', ['title' => 'Loaders | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('loader');
                    Route::get('/pagination', function () {
                        return view('pages.element.pagination', ['title' => 'Pagination | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('pagination');
                    Route::get('/popovers', function () {
                        return view('pages.element.popovers', ['title' => 'Popovers | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('popovers');
                    Route::get('/progressbar', function () {
                        return view('pages.element.progressbar', ['title' => 'Bootstrap Progress Bar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('progressbar');
                    Route::get('/search', function () {
                        return view('pages.element.search', ['title' => ' Search | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('search');
                    Route::get('/tooltips', function () {
                        return view('pages.element.tooltips', ['title' => 'Tooltips | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tooltips');
                    Route::get('/treeview', function () {
                        return view('pages.element.treeview', ['title' => ' Tree View | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('treeview');
                    Route::get('/typography', function () {
                        return view('pages.element.typography', ['title' => 'Typography | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('typography');
                });

                /**
                 * ==============================
                 *        @Router -  Forms
                 * ==============================
                 */

                Route::prefix('form')->group(function () {
                    Route::get('/autocomplete', function () {
                        return view('pages.form.autocomplete', ['title' => 'AutoComplete | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('autocomplete');
                    Route::get('/basic', function () {
                        return view('pages.form.basic', ['title' => 'Bootstrap Forms | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('basic');
                    Route::get('/checkbox', function () {
                        return view('pages.form.checkbox', ['title' => 'Checkbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('checkbox');
                    Route::get('/clipboard', function () {
                        return view('pages.form.clipboard', ['title' => 'Clipboard | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('clipboard');
                    Route::get('/date-time-picker', function () {
                        return view('pages.form.date-time-picker', ['title' => 'Date and Time Picker | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('date-time-picker');
                    Route::get('/fileupload', function () {
                        return view('pages.form.fileupload', ['title' => 'File Upload | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('fileupload');
                    Route::get('/input-group-basic', function () {
                        return view('pages.form.input-group-basic', ['title' => 'Input Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('input-group-basic');
                    Route::get('/input-mask', function () {
                        return view('pages.form.input-mask', ['title' => 'Input Mask | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('input-mask');
                    Route::get('/layouts', function () {
                        return view('pages.form.layouts', ['title' => 'Form Layouts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('layouts');
                    Route::get('/markdown', function () {
                        return view('pages.form.markdown', ['title' => 'Markdown Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('markdown');
                    Route::get('/maxlength', function () {
                        return view('pages.form.maxlength', ['title' => 'Bootstrap Maxlength | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('maxlength');
                    Route::get('/quill', function () {
                        return view('pages.form.quill', ['title' => 'Quill Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('quill');
                    Route::get('/radio', function () {
                        return view('pages.form.radio', ['title' => 'Radio | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('radio');
                    Route::get('/slider', function () {
                        return view('pages.form.slider', ['title' => 'Range Slider | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('slider');
                    Route::get('/switches', function () {
                        return view('pages.form.switches', ['title' => 'Bootstrap Toggle | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('switches');
                    Route::get('/tagify', function () {
                        return view('pages.form.tagify', ['title' => 'Tagify | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tagify');
                    Route::get('/tom-select', function () {
                        return view('pages.form.tom-select', ['title' => 'Bootstrap Select | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tom-select');
                    Route::get('/touchspin', function () {
                        return view('pages.form.touchspin', ['title' => 'Bootstrap Touchspin | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('touchspin');
                    Route::get('/validation', function () {
                        return view('pages.form.validation', ['title' => 'Bootstrap Form Validation | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('validation');
                    Route::get('/wizard', function () {
                        return view('pages.form.wizard', ['title' => 'Wizards | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('wizard');
                });

                /**
                 * ==============================
                 *       @Router -  Layouts
                 * ==============================
                 */
                Route::prefix('layout')->group(function () {
                    Route::get('/blank', function () {
                        return view('pages.layout.blank', ['title' => 'Blank Page | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blank');
                    Route::get('/collapsible-menu', function () {
                        return view('pages.layout.collapsible-menu', ['title' => 'Collapsible Menu | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('collapsibleMenu');
                    Route::get('/full-width', function () {
                        return view('pages.layout.full-width', ['title' => 'Full Width | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('fullWidth');
                    Route::get('/empty', function () {
                        return view('pages.layout.empty', ['title' => 'Empty | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('empty');
                });

                /**
                 * ==============================
                 *       @Router -  Pages
                 * ==============================
                 */

                Route::prefix('page')->group(function () {
                    Route::get('/contact-us', function () {
                        return view('pages.page.contact-us', ['title' => 'Contact Us | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('contact-us');
                    Route::get('/404', function () {
                        return view('pages.page.e-404', ['title' => 'Error | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('404');
                    Route::get('/faq', function () {
                        return view('pages.page.faq', ['title' => 'FAQs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('faq');
                    Route::get('/knowledge-base', function () {
                        return view('pages.page.knowledge-base', ['title' => 'Knowledge Base | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('knowledge-base');
                    Route::get('/maintenance', function () {
                        return view('pages.page.maintanence', ['title' => 'Maintenence | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('maintenance');
                });

                /**
                 * ==============================
                 *       @Router -  Table
                 * ==============================
                 */
                Route::get('/table', function () {
                    return view('pages.table.basic', ['title' => 'Bootstrap Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('table');


                /**
                 * ======================================
                 *          @Router -  Datatables
                 * ======================================
                 */
                Route::prefix('datatables')->group(function () {
                    Route::get('/basic', function () {
                        return view('pages.table.datatable.basic', ['title' => 'DataTables Basic | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('basic');
                    Route::get('/custom', function () {
                        return view('pages.table.datatable.custom', ['title' => 'Custom DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('custom');
                    Route::get('/miscellaneous', function () {
                        return view('pages.table.datatable.miscellaneous', ['title' => 'Miscellaneous DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('miscellaneous');
                    Route::get('/striped-table', function () {
                        return view('pages.table.datatable.striped-table', ['title' => 'DataTables Striped | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('striped-table');
                });

                /**
                 * ==============================
                 *          @Router -  Users
                 * ==============================
                 */

                Route::prefix('user')->group(function () {
                    Route::get('/settings', function () {
                        return view('pages.user.account-settings', ['title' => 'User Profile | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('settings');
                    Route::get('/profile', function () {
                        return view('pages.user.profile', ['title' => 'Account Settings | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('profile');
                });

                /**
                 * ==============================
                 *        @Router -  Widgets
                 * ==============================
                 */

                Route::get('/widgets', function () {
                    return view('pages.widget.widgets', ['title' => 'Widgets | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('widgets');

                /**
                 * ==============================
                 *      @Router -  charts
                 * ==============================
                 */

                Route::get('/charts', function () {
                    return view('pages.charts', ['title' => 'Apex Chart | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('charts');

                /**
                 * ==============================
                 *       @Router -  Maps
                 * ==============================
                 */
                Route::get('/maps', function () {
                    return view('pages.map', ['title' => 'jVector Maps | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('maps');
            });
        });
    }



    /**
     * =======================
     *      RTL ROUTERS
     * =======================
     */
    Route::prefix('rtl')->group(function () {

        $rtlPrefixRouters = [
            'modern-light-menu', 'modern-dark-menu', 'collapsible-menu'
        ];

        foreach ($rtlPrefixRouters as $rtlPrefixRouter) {
            Route::prefix($rtlPrefixRouter)->group(function () {


                Route::get('/sss', function () {
                    return view('welcome', ['title' => 'this is ome ', 'breadcrumb' => 'This Breadcrumb']);
                });

                /**
                 * ==============================
                 *       @Router -  Dashboard
                 * ==============================
                 */

                Route::prefix('dashboard')->group(function () {
                    Route::get('/analytics', function () {
                        return view('pages-rtl.dashboard.analytics', ['title' => 'CORK Admin - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('analytics');
                    Route::get('/sales', function () {
                        return view('pages-rtl.dashboard.sales', ['title' => 'Sales Admin | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('sales');
                });

                /**
                 * ==============================
                 *        @Router -  Apps
                 * ==============================
                 */

                Route::prefix('app')->group(function () {
                    Route::get('/calendar', function () {
                        return view('pages-rtl.app.calendar', ['title' => 'Javascript Calendar | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('calendar');
                    Route::get('/chat', function () {
                        return view('pages-rtl.app.chat', ['title' => 'Chat Application | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('chat');
                    Route::get('/contacts', function () {
                        return view('pages-rtl.app.contacts', ['title' => 'Contact Profile | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('contacts');
                    Route::get('/mailbox', function () {
                        return view('pages-rtl.app.mailbox', ['title' => 'Mailbox | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('mailbox');
                    Route::get('/notes', function () {
                        return view('pages-rtl.app.notes', ['title' => 'Notes | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('notes');
                    Route::get('/scrumboard', function () {
                        return view('pages-rtl.app.scrumboard', ['title' => 'Scrum Task Board | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('scrumboard');
                    Route::get('/todo-list', function () {
                        return view('pages-rtl.app.todolist', ['title' => 'Todo List | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('todolist');

                    // Blog

                    Route::prefix('/blog')->group(function () {
                        Route::get('/create', function () {
                            return view('pages-rtl.app.blog.create', ['title' => 'Blog Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-create');
                        Route::get('/edit', function () {
                            return view('pages-rtl.app.blog.edit', ['title' => 'Blog Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-edit');
                        Route::get('/grid', function () {
                            return view('pages-rtl.app.blog.grid', ['title' => 'Blog | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-grid');
                        Route::get('/list', function () {
                            return view('pages-rtl.app.blog.list', ['title' => 'Blog List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-list');
                        Route::get('/post', function () {
                            return view('pages-rtl.app.blog.post', ['title' => 'Post Content | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('blog-post');
                    });
                    /*
                // Ecommerce
                Route::prefix('/ecommerce')->group(function () {
                    Route::get('/add', function () {
                        return view('pages-rtl.app.ecommerce.add', ['title' => 'Ecommerce Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-add');
                    Route::get('/detail', function () {
                        return view('pages-rtl.app.ecommerce.detail', ['title' => 'Ecommerce Product Details | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-detail');
                    Route::get('/edit', function () {
                        return view('pages-rtl.app.ecommerce.edit', ['title' => 'Ecommerce Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-edit');
                    Route::get('/list', function () {
                        return view('pages-rtl.app.ecommerce.list', ['title' => 'Ecommerce List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-list');
                    Route::get('/shop', function () {
                        return view('pages-rtl.app.ecommerce.shop', ['title' => 'Ecommerce Shop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-shop');
                });*/

                    // Invoice

                    Route::prefix('/invoice')->group(function () {
                        Route::get('/add', function () {
                            return view('pages-rtl.app.invoice.add', ['title' => 'Invoice Add | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-add');
                        Route::get('/edit', function () {
                            return view('pages-rtl.app.invoice.edit', ['title' => 'Invoice Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-edit');
                        Route::get('/list', function () {
                            return view('pages-rtl.app.invoice.list', ['title' => 'Invoice List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-list');
                        Route::get('/preview', function () {
                            return view('pages-rtl.app.invoice.preview', ['title' => 'Invoice Preview | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('invoice-preview');
                    });
                });

                /**
                 * ==============================
                 *    @Router -  Authentication
                 * ==============================
                 */

                Route::prefix('authentication')->group(function () {
                    // Boxed

                    Route::prefix('/boxed')->group(function () {
                        Route::get('/2-step-verification', function () {
                            return view('pages-rtl.authentication.boxed.2-step-verification', ['title' => '2 Step Verification Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('2Step');
                        Route::get('/lockscreen', function () {
                            return view('pages-rtl.authentication.boxed.lockscreen', ['title' => 'LockScreen Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('lockscreen');
                        Route::get('/password-reset', function () {
                            return view('pages-rtl.authentication.boxed.password-reset', ['title' => 'Password Reset Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('password-reset');
                        Route::get('/signin', function () {
                            return view('pages-rtl.authentication.boxed.signin', ['title' => 'SignIn Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signin');
                        Route::get('/signup', function () {
                            return view('pages-rtl.authentication.boxed.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signup');
                    });


                    // Cover

                    Route::prefix('/cover')->group(function () {
                        Route::get('/2-step-verification', function () {
                            return view('pages-rtl.authentication.cover.2-step-verification', ['title' => '2 Step Verification Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('2Step');
                        Route::get('/lockscreen', function () {
                            return view('pages-rtl.authentication.cover.lockscreen', ['title' => 'LockScreen Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('lockscreen');
                        Route::get('/password-reset', function () {
                            return view('pages-rtl.authentication.cover.password-reset', ['title' => 'Password Reset Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('password-reset');
                        Route::get('/signin', function () {
                            return view('pages-rtl.authentication.cover.signin', ['title' => 'SignIn Boxed | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signin');
                        Route::get('/signup', function () {
                            return view('pages-rtl.authentication.cover.signup', ['title' => 'SignUp Cover | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                        })->name('signup');
                    });
                });

                /**
                 * ==============================
                 *     @Router -  Components
                 * ==============================
                 */

                Route::prefix('component')->group(function () {
                    Route::get('/accordion', function () {
                        return view('pages-rtl.component.accordion', ['title' => 'Accordions | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('accordion');
                    Route::get('/bootstrap-carousel', function () {
                        return view('pages-rtl.component.bootstrap-carousel', ['title' => 'Bootstrap Carousel | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('bootstrap-carousel');
                    Route::get('/cards', function () {
                        return view('pages-rtl.component.cards', ['title' => 'Card | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('cards');
                    Route::get('/drag-drop', function () {
                        return view('pages-rtl.component.drag-drop', ['title' => 'Dragula Drag and Drop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('drag-drop');
                    Route::get('/flags', function () {
                        return view('pages-rtl.component.flags', ['title' => 'SVG Flag Icons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('flags');
                    Route::get('/fonticons', function () {
                        return view('pages-rtl.component.fonticons', ['title' => 'Fonticon Icon | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('fonticons');
                    Route::get('/lightbox', function () {
                        return view('pages-rtl.component.lightbox', ['title' => 'Lightbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('lightbox');
                    Route::get('/list-group', function () {
                        return view('pages-rtl.component.list-group', ['title' => 'List Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('list-group');
                    Route::get('/media-object', function () {
                        return view('pages-rtl.component.media-object', ['title' => 'Media Object | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('media-object');
                    Route::get('/modal', function () {
                        return view('pages-rtl.component.modal', ['title' => 'Modals | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('modal');
                    Route::get('/notification', function () {
                        return view('pages-rtl.component.notifications', ['title' => 'Snackbar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('notification');
                    Route::get('/pricing-table', function () {
                        return view('pages-rtl.component.pricing-table', ['title' => 'Pricing Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('pricing-table');
                    Route::get('/splide', function () {
                        return view('pages-rtl.component.splide', ['title' => 'Splide | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('splide');
                    Route::get('/sweetalerts', function () {
                        return view('pages-rtl.component.sweetalert', ['title' => 'SweetAlert | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('sweetalerts');
                    Route::get('/tabs', function () {
                        return view('pages-rtl.component.tabs', ['title' => 'Tabs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tabs');
                    Route::get('/timeline', function () {
                        return view('pages-rtl.component.timeline', ['title' => 'Timeline | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('timeline');
                });

                /**
                 * ==============================
                 *     @Router -  Elements
                 * ==============================
                 */
                Route::prefix('element')->group(function () {
                    Route::get('/alerts', function () {
                        return view('pages-rtl.element.alerts', ['title' => 'Alerts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('alerts');
                    Route::get('/avatar', function () {
                        return view('pages-rtl.element.avatar', ['title' => ' Avatar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('avatar');
                    Route::get('/badges', function () {
                        return view('pages-rtl.element.badges', ['title' => ' Badge | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('badges');
                    Route::get('/breadcrumbs', function () {
                        return view('pages-rtl.element.breadcrumbs', ['title' => ' Breadcrumb | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('breadcrumbs');
                    Route::get('/buttons', function () {
                        return view('pages-rtl.element.buttons', ['title' => 'Bootstrap Buttons | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('buttons');
                    Route::get('/buttons-group', function () {
                        return view('pages-rtl.element.buttons-group', ['title' => 'Button Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('buttons-group');
                    Route::get('/color-library', function () {
                        return view('pages-rtl.element.color-library', ['title' => 'Color Library | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('color-library');
                    Route::get('/dropdown', function () {
                        return view('pages-rtl.element.dropdown', ['title' => ' Dropdown | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('dropdown');
                    Route::get('/infobox', function () {
                        return view('pages-rtl.element.infobox', ['title' => ' Infobox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('infobox');
                    Route::get('/loader', function () {
                        return view('pages-rtl.element.loader', ['title' => 'Loaders | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('loader');
                    Route::get('/pagination', function () {
                        return view('pages-rtl.element.pagination', ['title' => 'Pagination | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('pagination');
                    Route::get('/popovers', function () {
                        return view('pages-rtl.element.popovers', ['title' => 'Popovers | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('popovers');
                    Route::get('/progressbar', function () {
                        return view('pages-rtl.element.progressbar', ['title' => 'Bootstrap Progress Bar | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('progressbar');
                    Route::get('/search', function () {
                        return view('pages-rtl.element.search', ['title' => ' Search | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('search');
                    Route::get('/tooltips', function () {
                        return view('pages-rtl.element.tooltips', ['title' => 'Tooltips | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tooltips');
                    Route::get('/treeview', function () {
                        return view('pages-rtl.element.treeview', ['title' => ' Tree View | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('treeview');
                    Route::get('/typography', function () {
                        return view('pages-rtl.element.typography', ['title' => 'Typography | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('typography');
                });

                /**
                 * ==============================
                 *        @Router -  Forms
                 * ==============================
                 */

                Route::prefix('form')->group(function () {
                    Route::get('/autocomplete', function () {
                        return view('pages-rtl.form.autocomplete', ['title' => 'AutoComplete | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('autocomplete');
                    Route::get('/basic', function () {
                        return view('pages-rtl.form.basic', ['title' => 'Bootstrap Forms | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('basic');
                    Route::get('/checkbox', function () {
                        return view('pages-rtl.form.checkbox', ['title' => 'Checkbox | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('checkbox');
                    Route::get('/clipboard', function () {
                        return view('pages-rtl.form.clipboard', ['title' => 'Clipboard | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('clipboard');
                    Route::get('/date-time-picker', function () {
                        return view('pages-rtl.form.date-time-picker', ['title' => 'Date and Time Picker | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('date-time-picker');
                    Route::get('/fileupload', function () {
                        return view('pages-rtl.form.fileupload', ['title' => 'File Upload | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('fileupload');
                    Route::get('/input-group-basic', function () {
                        return view('pages-rtl.form.input-group-basic', ['title' => 'Input Group | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('input-group-basic');
                    Route::get('/input-mask', function () {
                        return view('pages-rtl.form.input-mask', ['title' => 'Input Mask | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('input-mask');
                    Route::get('/layouts', function () {
                        return view('pages-rtl.form.layouts', ['title' => 'Form Layouts | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('layouts');
                    Route::get('/markdown', function () {
                        return view('pages-rtl.form.markdown', ['title' => 'Markdown Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('markdown');
                    Route::get('/maxlength', function () {
                        return view('pages-rtl.form.maxlength', ['title' => 'Bootstrap Maxlength | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('maxlength');
                    Route::get('/quill', function () {
                        return view('pages-rtl.form.quill', ['title' => 'Quill Editor | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('quill');
                    Route::get('/radio', function () {
                        return view('pages-rtl.form.radio', ['title' => 'Radio | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('radio');
                    Route::get('/slider', function () {
                        return view('pages-rtl.form.slider', ['title' => 'Range Slider | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('slider');
                    Route::get('/switches', function () {
                        return view('pages-rtl.form.switches', ['title' => 'Bootstrap Toggle | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('switches');
                    Route::get('/tagify', function () {
                        return view('pages-rtl.form.tagify', ['title' => 'Tagify | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tagify');
                    Route::get('/tom-select', function () {
                        return view('pages-rtl.form.tom-select', ['title' => 'Bootstrap Select | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('tom-select');
                    Route::get('/touchspin', function () {
                        return view('pages-rtl.form.touchspin', ['title' => 'Bootstrap Touchspin | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('touchspin');
                    Route::get('/validation', function () {
                        return view('pages-rtl.form.validation', ['title' => 'Bootstrap Form Validation | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('validation');
                    Route::get('/wizard', function () {
                        return view('pages-rtl.form.wizard', ['title' => 'Wizards | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('wizard');
                });

                /**
                 * ==============================
                 *       @Router -  Layouts
                 * ==============================
                 */
                Route::prefix('layout')->group(function () {
                    Route::get('/blank', function () {
                        return view('pages-rtl.layout.blank', ['title' => 'Blank Page | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('blank');
                    Route::get('/collapsible-menu', function () {
                        return view('pages-rtl.layout.collapsible-menu', ['title' => 'Collapsible Menu | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('collapsibleMenu');
                    Route::get('/full-width', function () {
                        return view('pages-rtl.layout.full-width', ['title' => 'Full Width | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('fullWidth');
                    Route::get('/empty', function () {
                        return view('pages-rtl.layout.empty', ['title' => 'Empty | CORK - Multipurpose Bootstrap Dashboard Template', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('empty');
                });

                /**
                 * ==============================
                 *       @Router -  Pages
                 * ==============================
                 */

                Route::prefix('page')->group(function () {
                    Route::get('/contact-us', function () {
                        return view('pages-rtl.page.contact-us', ['title' => 'Contact Us | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('contact-us');
                    Route::get('/404', function () {
                        return view('pages-rtl.page.e-404', ['title' => 'Error | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('404');
                    Route::get('/faq', function () {
                        return view('pages-rtl.page.faq', ['title' => 'FAQs | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('faq');
                    Route::get('/knowledge-base', function () {
                        return view('pages-rtl.page.knowledge-base', ['title' => 'Knowledge Base | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('knowledge-base');
                    Route::get('/maintenance', function () {
                        return view('pages-rtl.page.maintanence', ['title' => 'Maintenence | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('maintenance');
                });

                /**
                 * ==============================
                 *       @Router -  Table
                 * ==============================
                 */
                Route::get('/table', function () {
                    return view('pages-rtl.table.basic', ['title' => 'Bootstrap Tables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('table');


                /**
                 * ======================================
                 *          @Router -  Datatables
                 * ======================================
                 */
                Route::prefix('datatables')->group(function () {
                    Route::get('/basic', function () {
                        return view('pages-rtl.table.datatable.basic', ['title' => 'DataTables Basic | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('basic');
                    Route::get('/custom', function () {
                        return view('pages-rtl.table.datatable.custom', ['title' => 'Custom DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('custom');
                    Route::get('/miscellaneous', function () {
                        return view('pages-rtl.table.datatable.miscellaneous', ['title' => 'Miscellaneous DataTables | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('miscellaneous');
                    Route::get('/striped-table', function () {
                        return view('pages-rtl.table.datatable.striped-table', ['title' => 'DataTables Striped | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('striped-table');
                });

                /**
                 * ==============================
                 *          @Router -  Users
                 * ==============================
                 */

                Route::prefix('user')->group(function () {
                    Route::get('/settings', function () {
                        return view('pages-rtl.user.account-settings', ['title' => 'User Profile | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('settings');
                    Route::get('/profile', function () {
                        return view('pages-rtl.user.profile', ['title' => 'Account Settings | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('profile');
                });

                /**
                 * ==============================
                 *        @Router -  Widgets
                 * ==============================
                 */

                Route::get('/widgets', function () {
                    return view('pages-rtl.widget.widgets', ['title' => 'Widgets | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('widgets');

                /**
                 * ==============================
                 *      @Router -  charts
                 * ==============================
                 */

                Route::get('/charts', function () {
                    return view('pages-rtl.charts', ['title' => 'Apex Chart | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('charts');

                /**
                 * ==============================
                 *       @Router -  Maps
                 * ==============================
                 */
                Route::get('/maps', function () {
                    return view('pages-rtl.map', ['title' => 'jVector Maps | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                })->name('maps');
            });
        }
    });
});

/**
 * =======================
 *      SHOP ROUTERS
 * =======================
 */

Route::middleware(['auth', 'can:admin', 'can:e-commerce'])->group(function () {



    /**
     * =======================
     *      SHOP ROUTERS
     * =======================
     */

    $prefixRouters = [
        'modern-light-menu', 'modern-dark-menu', 'collapsible-menu'
    ];



    foreach ($prefixRouters as $prefixRouter) {
        Route::prefix($prefixRouter)->group(function () {

            Route::prefix('app')->group(function () {

                // Flow



                // Ecommerce
                Route::prefix('/ecommerce')->group(function () {
                    Route::get('/add', function () {
                        return view('pages.app.eco.add', ['title' => 'Ecommerce Create | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-add');
                    Route::get('/detail', function () {
                        return view('pages.app.ecommerce.detail', ['title' => 'Ecommerce Product Details | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-detail');
                    Route::get('/edit', function () {
                        return view('pages.app.ecommerce.edit', ['title' => 'Ecommerce Edit | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-edit');
                    Route::get('/list', function () {
                        return view('pages.app.ecommerce.list', ['title' => 'Ecommerce List | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-list');
                    Route::get('/shop', function () {
                        return view('pages.app.ecommerce.shop', ['title' => 'Ecommerce Shop | CORK - Multipurpose Bootstrap Dashboard Template ', 'breadcrumb' => 'This Breadcrumb']);
                    })->name('ecommerce-shop');
                });
            });
        });
    }
});



$prefixRouters = [
    'modern-light-menu', 'modern-dark-menu', 'collapsible-menu'
];



foreach ($prefixRouters as $prefixRouter) {
    Route::prefix($prefixRouter)->group(function () {


        Route::prefix('/app/eco')->group(function () {
            Route::get('/shop', [EcommerceController::class, 'product_show'])->name('eco-shop');
            Route::get('/product/{id}', [EcommerceController::class, 'product_show'])->name('eco-show');
            Route::get('/checkout/{id}', [EcommerceController::class, 'checkout_show'])->name('eco_checkout_show-blank.');
            Route::post('/checkout/{id}/client', [EcommerceController::class, 'eco_login_create'])->name('eco_login_create');

            Route::get('/shop', [EcommerceController::class, 'shop'])->name('eco-shop');
            Route::get('/cademi/tag', [CademiController::class, 'cademi_tag'])->name('eco-cademi_tag');
            Route::get('/rd/fluxo', [RdController::class, 'rd_fluxos']);
            Route::get('/rd/{id}', [RdController::class, 'rd_create_oportunity']);
        });



        Route::prefix('/app/form')->group(function () {

            Route::get('/end/{id}', [FormController::class, 'end_show'])->name('form-end-show');
            Route::post('/end/{id}', [FormController::class, 'end_post'])->name('form-end-post');
        });
    });
}
Route::get('/fb/ViewContent', [ConversionApiFB::class, 'ViewContent'])->name('fb-ViewContent');
Route::get('/form/{id}', [FormController::class, 'redir'])->name('form-redirect');

Route::get('/politica-de-privacidade', function () {
    return Redirect::to('https://ead.profissionalizaead.com.br/mod/page/view.php?id=18448');;
});

Route::get('/redir', [RedirCademiController::class, 'redir_get'])->name('aluno.redir');
Route::post('/redir', [RedirCademiController::class, 'redir_post'])->name('aluno.redir.post');
Route::get('/modern-dark-menu/redir_login', [RedirCademiController::class, 'redir_get_show'])->name('aluno.redir.login');

Route::get('/test/fila', function () {
    $users = User::where('courses', 'not like', 'NÃO')->get(); // Consulta todos os usuários
    $batches = $users->chunk(1000);
        foreach ($batches as $batch) {
            foreach ($batch as $user) {
                dd($user);
                Storage::disk('local')->append('file6.txt', now() . " A " .  $user->id);
            }
        }
    dd('fim');
});

Route::get('/test/pdf', function () {
    //dd('s');
    $pdf = Pdf::loadView('pdf.lista')
        ->setPaper('a4', 'landscape')
        ->setOptions([
            //'tempDir' => public_path(),
            //'chroot' => public_path('storage'),
            'enable_remote' => true,
            'dpi' => '120'
        ]);
    //return $pdf->download('invoice.pdf');
    return $pdf->stream('pdf.lista');
    return view('pdf.lista');
})->name('resume-show');

Route::get('/resume/pdf', function () {
    $pdf = Pdf::loadView('pdf.resume')
        ->setPaper('a4', 'portrait')
        ->setOptions([
            //'tempDir' => public_path(),
            //'chroot' => public_path('storage'),
            'enable_remote' => true,
            'dpi' => '120'
        ]);
    //return $pdf->download('invoice.pdf');
    //return view('invoice.pdf');
    //return $pdf->stream('pdf.resume');
    return view('pdf.resume');

});

Route::get('/cert/{code}', [CertificateController::class, 'view'])->name('cert-check');
Route::get('/cert/{code}/pdf', [CertificateController::class, 'pdf'])->name('cert-down');

Route::get('/', function () {
    return Redirect::to(env('APP_HOME_URL'));
});



require __DIR__ . '/auth.php';
