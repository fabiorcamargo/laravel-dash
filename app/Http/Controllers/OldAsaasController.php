<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class OldAsaasController extends Controller
{
    // Busca se o cliente existe no Asaas
public function lista_cliente($cpf, $token){
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/customers?cpfCnpj=$cpf");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      $token
    ));
    
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    
    $dec = json_decode($response);
    return $dec;
    }
    
    
    // Cria o Cliente no Asaas
    public function cria_cliente($id, $nome, $cpf, $telefone, $email, $cep, $descricao, $empresa, $grupo, $token){
    $ch = curl_init();
    
    
    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/customers");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_POST, TRUE);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"name\": \"$nome\",
      \"phone\": \"$telefone\",
      \"email\": \"$email\",
      \"mobilePhone\": \"$telefone\",
      \"observations\": \"$descricao\",
      \"company\": \"$empresa\",
      \"groupName\": \"$grupo\",
    
      \"cpfCnpj\": \"$cpf\",
      \"postalCode\": \"$cep\",
      \"externalReference\": \"$id\",
      \"notificationDisabled\": false,
      \"whatsappEnabledForCustomer\": true,
      
    }");
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      $token
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    
    $dec = json_decode($response);
    
    return $dec;
    
    }
    
    
    
    // Atualiza Notificação no Asaas
    public function notificacao_asaas($customer, $token){

    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/notifications/$customer");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_POST, TRUE);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"enabled\": true,
      \"emailEnabledForProvider\": true,
      \"smsEnabledForProvider\": true,
      \"emailEnabledForCustomer\": true,
      \"smsEnabledForCustomer\": true,
      \"phoneCallEnabledForCustomer\": false,
      \"whatsappEnabledForCustomer\": true
    }");
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      $token
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    //var_dump($response);
    }
    
    
    // Cria a Cobrança no Asaas
    public function cria_cobranca($customer, $curso, $data2, $valor, $parcela, $token){
        
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/payments");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_POST, TRUE);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"customer\": \"$customer\",
      \"billingType\": \"BOLETO\",
      \"dueDate\": \"$data2\",
      \"description\": \"$curso\",
      \"installmentValue\": $valor,
      \"installmentCount\": $parcela,    
      \"discount\": {
        \"value\": 0,
        \"dueDateLimitDays\": 0
      },
      \"fine\": {
        \"value\": 2
      },
      \"interest\": {
        \"value\": 2
      },
      \"postalService\": false
    }");
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      $token
    ));
    
    $response = curl_exec($ch);
    $dec = json_decode($response);
    return $dec;
    }
    
    
    //Lista Cobranças
    
    public function lista_cobranca($customer, $token){
       
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/payments?customer=$customer&order=asc");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      $token
    ));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $dec = json_decode($response);
    
    return $dec;
    }

    public function getpixqr($id, $token){
      $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/payments/$id/pixQrCode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        
        curl_setopt($ch, CURLOPT_POST, TRUE);
                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          $token
        ));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return(json_decode($response));
    }

    public function getPayBook($id, $token){
    

    $url = "https://www.asaas.com//api/v3/installments/$id/paymentBook?sort=dueDate&order=asc"; // URL do arquivo que você deseja baixar
    $publicPath = public_path("storage/paybook/$id"); // Pasta pública onde o arquivo será salvo
    
    // Verifica se a pasta pública existe, caso contrário, cria-a
    if (!file_exists($publicPath)) {
        mkdir($publicPath, 0755, true);
    }
    
    $client = new Client();
    
    // Faz a requisição GET com o token
    $response = $client->request('GET', $url, [
        'headers' => [
            'access_token' => $token,
        ],
    ]);
    
    // Gera o nome do arquivo
    $filename = 'arquivo_' . time() . '.pdf'; // Aqui você pode personalizar o nome do arquivo conforme necessário
    
    // Salva o conteúdo do arquivo na pasta pública
    file_put_contents($publicPath . '/' . $filename, $response->getBody());
    
    // Retorna a URL completa do arquivo salvo
    $fileUrl = asset("storage/paybook/$id/" . $filename);
    
    //dd($fileUrl);
    
    return $fileUrl;
}


    public function result(Request $request){
      //dd($request->cpf);
      $aluno = User::where('id', $request->id)->first();
  
      if(Auth::user()->secretary == "TB"){
        $token = env('ASAAS_TOKEN1');
      }else if(Auth::user()->secretary == "MGA"){
        $token = env('ASAAS_TOKEN2');
      }else{
        $msg = "Token inválido";
        return back()->withErrors(__($msg));
      }
        //dd($_POST["cep"]);
        $pagina = "lista";
        $nomeresp = $_POST["responsavel"];
        $nomealuno = $_POST["aluno"];

        $de = array('(',')',' ','-');
        $para = array('','','','');
        $telefone = str_replace($de, $para, $_POST["telefone"]);
        
        $email =  $_POST["email"];

        $de = array('.','-');
        $para = array('','');
        $cpf = str_replace($de, $para, $_POST["cpf"]);

        //$cpf = $_POST["cpf"];
        //dd($cpf);
        $id = $_POST["id"];
        $username = $_POST["username"];
        $valor = preg_replace('/[^0-9]/', '', $_POST["valor"]);
        $parcela = preg_replace('/[^0-9]/', '', $_POST["parcelas"]);
        $data2 = date('Y-m-d', strtotime($_POST["data"]));
        $nome = $username . " " . $nomeresp . " (" . $nomealuno . ")";
        //$UF = $_POST["uf"];
        //$cidade = $_POST["cidade"];
        $cep = $_POST["cep"];
        $taxa = isset($_POST["taxa"]) ? $_POST["taxa"] : "";
        //$cartaop = isset($_POST["cartaop"]) ? $_POST["cartaop"] : "";
        $cartao = isset($_POST["cartaoi"]) ? $_POST["cartaoi"] : "";
        $link = isset($_POST["link"]) ? $_POST["link"] : "";
        $curso = $_POST["curso"];
        $grupo = $_POST["grupo"];
        $desc = $_POST["descricao"];
        //dd($desc);
        $empresa = $curso . $taxa . $cartao . $link;
        //dd($empresa);

        $taxa = $taxa !== "" ? "TAXA: $request->taxa_valor\\n" : "";
        $cartao = $cartao !== "" ? "CARTÃO: $request->cartaoi_valor\\n" : "";
        $link = $link !== "" ? "LINK: $request->link_valor\\n" : "";
        $boleto = "BOLETO: $request->parcelas $request->valor";

        $pagamento = "$taxa$cartao$link$boleto";
        
        $criado_por = Auth::user()->name;
        $desc = str_ireplace("\r\n", "\\n", $desc);
        //dd($desc);
        $descricao = "DIV: $grupo\\n$curso\\n$pagamento\\nCRIADO POR: $criado_por\\n$desc";
        //dd($descricao);
        //var_dump($curso);

        if ($pagina == "lista"){
            $client = new OldAsaasController;
            $dec = $client->lista_cliente($cpf, $token);
            //dd($dec->data);
        
        if (!empty($dec->data)){
        $customer = ($dec->data[0]->id);
        $status2 ="<b>CLIENTE</b><br>";
        $status2 = $status2 . ($dec->data[0]->name);
        $dec = $client->lista_cobranca($customer, $token);
        //dd($dec);
        if($dec->data == null){
        $status3 = "<b>COBRANÇA</b><br>";
        $status3 = "Sem cobranças cadastradas.";
        }else{
        $status3 = "<b>COBRANÇA</b><br>";
        $status3 = $status3 . $dec->data[0]->dateCreated . " " . $dec->data[0]->description . " " . $dec->data[0]->billingType . " " . $dec->data[0]->status;
        }
        

        $status1 = "Cliente já existe";
        $botao1 = "Criar Cobrança";
        $botao2 = "Não Criar";
        $acao2 = "index.php";
        $acao = "/modern-dark-menu/app/pay/cliente_existe?";
        $acao = $acao . "nomeresp=" . urlencode($nomeresp) . "&";
        $acao = $acao . "nomealuno=" . urlencode($nomealuno) . "&";
        $acao = $acao . "telefone=" . urlencode($telefone) . "&";
        $acao = $acao . "cpf=" . urlencode($cpf) . "&";
        $acao = $acao . "id=" . urlencode($id) . "&";
        $acao = $acao . "valor=" . urlencode($valor) . "&";
        $acao = $acao . "parcela=" . urlencode($parcela) . "&";
        $acao = $acao . "data2=" . urlencode($data2) . "&";
        $acao = $acao . "nome=" . urlencode($nome) . "&";
        //$acao = $acao . "UF=" . urlencode($UF) . "&";
        //$acao = $acao . "cidade=" . urlencode($cidade) . "&";
        $acao = $acao . "cep=" . urlencode($cep) . "&";
        $acao = $acao . "taxa=" . urlencode($taxa) . "&";
        $acao = $acao . "cartao=" . urlencode($cartao) . "&";
        $acao = $acao . "link=" . urlencode($link) . "&";
        $acao = $acao . "curso=" . urlencode($curso) . "&";
        $acao = $acao . "id=" . urlencode($id) . "&";
        $acao = $acao . "username=" . urlencode($username) . "&";
        $acao = $acao . "descricao=" . urlencode($descricao) . "&";

            //dd($acao);
            return view('pages.app.pay.modal2')->with([
                                                        'status1'=>$status1,
                                                        'status2'=>$status2,
                                                        'status3'=>$status3,
                                                        'botao1'=>$botao1,
                                                        'botao2'=>$botao2,
                                                        'acao'=>$acao,
                                                        'acao2'=>$acao2,

                                                    ]);
        


        }else{
            //dd("n");
        //var_dump($descricao);
        //exit();
        $client = new OldAsaasController;
        $dec = $client->cria_cliente($username, $nome, $cpf, $telefone, $email, $cep, $descricao, $empresa, $grupo, $token);
        //dd($dec);
        $customer = $dec->id;
        $client->notificacao_asaas($customer, $token);
        if (!empty ($customer)){
        $status2 = "<b>CLIENTE CRIADO COM SUCESSO</b> <br>" . $nome;
       
        }else{
        $status2 = "Cliente não pode ser criado, favor verificar as informações";
        }	
            
        if (!empty($valor)){
        $dec = $client->cria_cobranca($customer, $curso, $data2, $valor, $parcela, $token);
        //dd($dec);
        $cobranca = $dec->installment;


        if (!empty($cobranca)){
          
        $status3 = "<br><b>COBRANÇA CRIADA COM SUCESSO</b> <br>" . $curso . " em " . $parcela . " parcelas de " . "R$" . $valor;

        $paybook = $client->getPayBook($dec->installment, str_replace("access_token: ","",$token));

        $msg = new MktController;
        $url = "https://profissionalizaead.com.br";
        
        if($cartao !== ""){
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Cartão e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n'.$paybook.'\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }else if($link !== ""){
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Link e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n'.$paybook.'\r\n\r\nCom relação ao Link de Pagamento, caso ainda não tenha recebido, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }else{
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nPara sua comodidade estamos enviando o seu carnê referente ao curso contratado do aluno(a) ASAFE, para acessá-lo basta clicar no link abaixo:👇\r\n\r\n'.$paybook.'\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }
        
        
        $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
       

        }else{
        $status3 = "Cobrança não pode ser criada, favor verificar as informações";
        }
        }else{
        $status3 = "";
        
        $msg = new MktController;
        $url = "https://profissionalizaead.com.br";
        if($link !== ""){
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade Link de Pagamento.\r\n\r\nCaso ainda não tenha recebido o link de pagamento, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }else{
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe está fazendo os últimos ajustes relacionado ao seu curso, as principais etapas são:👇\r\n\r\n- Entrega de Login e Senha;\n- Liberação dos Cursos na Plataforma;\n- Acompanhamento do Aluno;\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }
        $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
        
        }
        $status1 = "<b>CRIAÇÃO DE BOLETOS</b>";
        $acao = "/modern-dark-menu/app/pay/create";
        $botao = "Fechar";
        //dd($dec);
        $aluno->document = $cpf;
        $aluno->save();
        $aluno->observation()->create([
          'obs' => str_ireplace("\\n", "\r\n", $descricao)
        ]);
        $aluno->accountable()->create([
          'name' => $nomeresp,
          'cellphone' => $telefone,
          'document' => $cpf
        ]);

        return view('pages.app.pay.modal1')->with([
            'status1'=>$status1,
            'status2'=>$status2,
            'status3'=>$status3,
            'botao'=>$botao,
            'acao'=>$acao,
        ]);

        }}
    }

    public function cliente_existe(Request $request){
      $aluno = User::where('id', $request->id)->first();
      //dd($aluno);
      if(Auth::user()->secretary == "TB"){
        $token = env('ASAAS_TOKEN1');

      }else if(Auth::user()->secretary == "TB"){
        $token = env('ASAAS_TOKEN3');
        

      }else{

        $msg = "Token inválido";
        return back()->withErrors(__($msg));
      }
        //dd($request->all());
    $nomeresp=$_GET["nomeresp"];
    $nomealuno=$_GET["nomealuno"];
    $telefone=$_GET["telefone"];
    $cpf=$_GET["cpf"];
    $id=$_GET["id"];
    $username = $_GET["username"];
    $valor=$_GET["valor"];
    $parcela=$_GET["parcela"];
    $data2=$_GET["data2"];
    $nome=$_GET["nome"];
    //$UF=$_GET["UF"];
    //$cidade=$_GET["cidade"];
    $cep=$_GET["cep"];
    $taxa=$_GET["taxa"];
    $cartao=$_GET["cartao"];
    $link=$_GET["link"];
    $curso=$_GET["curso"];
    $descricao=$_GET["descricao"];

    $lista = new OldAsaasController;
    $dec = $lista->lista_cliente($cpf, $token);
    $customer = ($dec->data[0]->id);


    if (!empty ($customer)){
    $status2 = "<b>UTILIZADO CLIENTE EXISTENTE</b> <br>" . $nome;
    }else{
    $status2 = "Cliente não pode ser criado, favor verificar as informações";
    }

    if (!empty($valor)){
    $cobranca = new OldAsaasController;
    $dec = $cobranca->cria_cobranca($customer, $curso, $data2, $valor, $parcela, $token);
    //dd($dec);
    $installment = $dec->installment;
    if (!empty($installment)){
      $status3 = "<br><b>COBRANÇA CRIADA COM SUCESSO</b> <br>" . $curso . " em " . $parcela . " parcelas de " . "R$" . $valor;

      $paybook = $cobranca->getPayBook($dec->installment, str_replace("access_token: ","",$token));

      $msg = new MktController;
      $url = "https://profissionalizaead.com.br";
      
      if($cartao !== ""){
        $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Cartão e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n'.$paybook.'\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      }else if($link !== ""){
        $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Link e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n'.$paybook.'\r\n\r\nCom relação ao Link de Pagamento, caso ainda não tenha recebido, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      }else{
        $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nPara sua comodidade estamos enviando o seu carnê referente ao curso contratado do aluno(a) ASAFE, para acessá-lo basta clicar no link abaixo:👇\r\n\r\n'.$paybook.'\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      }
      
      
      $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
     


      }else{
      $status3 = "Cobrança não pode ser criada, favor verificar as informações";
      }
      }else{
      $status3 = "";
      
      $msg = new MktController;
        $url = "https://profissionalizaead.com.br";
        if($link !== ""){
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade Link de Pagamento.\r\n\r\nCaso ainda não tenha recebido o link de pagamento, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }else{
          $msg_text = '😊 Olá '.$nomeresp.', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe está fazendo os últimos ajustes relacionado ao seu curso, as principais etapas são:👇\r\n\r\n- Entrega de Login e Senha;\n- Liberação dos Cursos na Plataforma;\n- Acompanhamento do Aluno;\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }
      $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
      
      }
      $status1 = "<b>CRIAÇÃO DE BOLETOS</b>";
      $acao = "/modern-dark-menu/app/pay/create";
      $botao = "Fechar";
      //dd($dec);
      $aluno->observation()->create([
        'obs' => str_ireplace("\\n", "\r\n", $descricao)
      ]);

      $aluno->document = $cpf;
      $aluno->save();

      $aluno->accountable()->create([
        'name' => $nomeresp,
        'cellphone' => $telefone,
        'document' => $cpf
      ]);
      return view('pages.app.pay.modal1')->with([
          'status1'=>$status1,
          'status2'=>$status2,
          'status3'=>$status3,
          'botao'=>$botao,
          'acao'=>$acao,
      ]);

    }

    public function list($id){
      if(Auth::user()->role >= 4){
        $user = User::find($id);
      }else{
        $user = Auth::user();
      }

      if($user->document == null || $user->document == 99999999999 || $user->document == 00000000000 ){
        $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
        return back()->withErrors(__($msg));
      }
      //dd('1');
      if($user->secretary == "TB" || $user->secretary == "MGA"){
        //dd('1');
      }else{
        
        $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
        return back()->withErrors(__($msg));
      }
        //dd($user->document);
        $client = new OldAsaasController;
        $i = 1;
        $a = 1;
        //dd(env("ASAAS_TOKEN$i"));
        $response = $client->lista_cliente($user->document, env("ASAAS_TOKEN$i"));
          //dd($user->document);
      if(!isset($response->data[0]->id)){
        
      while($a <= 3){
        
        $a++;
        if(!isset($response->data[0]->id)){
          
          $i++;
          //dd($i);
          //dd($a);
          $response = $client->lista_cliente($user->document, env("ASAAS_TOKEN$i"));

        //dd($response->data);
        }
      }
    }
      //dd($response);
      if(!isset($response->data[0]->id)){
      $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
      return back()->withErrors(__($msg));
      }
      //dd('s');
      $customer = $response->data[0]->id;
      //dd($customer);
      $cobrancas = ($client->lista_cobranca($customer, env("ASAAS_TOKEN$i")))->data;
      //dd($cobrancas);

      if(isset($cobrancas[0]->billingType)){
      if($cobrancas[0]->billingType == "CREDIT_CARD"){
        $link = [
          "status" => $cobrancas[0]->status,
          "url" => $cobrancas[0]->invoiceUrl,
          "date" => Carbon::parse($cobrancas[0]->dueDate)->format('d/m/Y')
        ];
        //dd($link['status']);
      
      return view('pages.app.pay.list')->with(['link' => $link, 'title' => 'Lista de Pagamentos']);
        
      }
      if(!isset($cobrancas[0])){
        //dd('s');
        $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
        return back()->withErrors(__($msg));
      }
    }

      return view('pages.app.pay.list')->with(['cobrancas' => $cobrancas, 'title' => 'Lista de Pagamentos', 'i' => $i]);


    }


    public static function getqrcode($id, $i) {
        
        $pix = new OldAsaasController;
        $response = $pix->getpixqr($id, env("ASAAS_TOKEN$i"));     
        return($response);
        }
}
