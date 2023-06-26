<?php

namespace App\Http\Controllers;

use App\Jobs\Mkt_send_not_active;
use App\Models\User;
use App\Models\UserAccountable;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class OldAsaasController extends Controller
{

  public function lista_cliente_stoken($cpf)
  {
      if (Auth::user()->secretary == "TB") {
            $token = env('ASAAS_TOKEN1');
      } else if (Auth::user()->secretary == "MGA") {
            $token = env('ASAAS_TOKEN2');
      } else {
            $msg = "Token inválido";
            return back()->withErrors(__($msg));
      }

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


    
//dd($dec);

    $body = new stdClass;
    $body->name = "<p>Nome: ". $dec->data[0]->name ."</p>";
    if(isset($dec->data[0]->id)){
    $cobranca = new OldAsaasController;
    $cobranca = $cobranca->lista_cobranca($dec->data[0]->id, $token);

    
    foreach($cobranca->data as $cobra){
      //dd($cobranca);
    }
    
    }

    $body = 
    $dec->data[0]->name."<br><br>Informações:<br>".$dec->data[0]->company."<br>".$dec->data[0]->observations;
    return (str_replace("\n", "<br>", $body));
  }



  // Busca se o cliente existe no Asaas
  public function lista_cliente($cpf, $token)
  {
    str_contains($token, "access_token")? $token : $token = "access_token : $token";
    //dd($token);
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
  public function cria_cliente($id, $nome, $cpf, $telefone, $email, $cep, $descricao, $empresa, $grupo, $token)
  {
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
  public function notificacao_asaas($customer, $token)
  {


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
  public function cria_cobranca($customer, $curso, $data2, $valor, $parcela, $taxavalor, $token)
  {

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




    if ($taxavalor !== ""){
      //dd($dec->id);
      $value = $dec->value + $taxavalor;
      $id = $dec->id;

      $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/payments/$id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_POSTFIELDS, "{
      \"value\": $value
                        }");

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/json",
      $token
    ));

    $response = curl_exec($ch);
    $dec = json_decode($response);

    //dd($dec);

    }






    return $dec;
  }

  public function lista_link($customer, $token)
  {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/payments?billingType=CREDIT_CARD&customer=$customer&order=asc");
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


  //Lista Cobranças

  public function lista_cobranca($customer, $token)
  {

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

  public function getpixqr($id, $token)
  {
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

    return (json_decode($response));
  }

  public function getPayBook($id, $token)
  {


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

  public function trata_dados($request)
  {
    //dd($request->all());
    $send = new stdClass;
    $send->resp_exist = $request->resp_exist;
    $send->nomeresp = $request->responsavel;
    $send->nomealuno = array_unique(array_filter($request->aluno));
    $de = array('(', ')', ' ', '-');
    $para = array('', '', '', '');
    $send->telefone = str_replace($de, $para, $request->telefone);
    $send->email =  $request->email;
    $de = array('.', '-');
    $para = array('', '');
    $send->cpf = str_replace($de, $para, $request->cpf);
    $send->id = array_unique(array_filter($request->id));
    $send->username = array_unique(array_filter($request->username));
    $de = array(',');
    $para = array('.');
    $send->valor = str_replace($de, $para, $request->valor);
    $send->parcela = preg_replace('/[^0-9]/', '', $request->parcelas);
    $send->data2 = date('Y-m-d', strtotime($request->data));
    $send->cep = $request->cep;
    $send->taxa = isset($request->taxa) ? $request->taxa : "";
    $send->cartao = isset($request->cartaoi) ? $request->cartaoi : "";
    $send->link = isset($request->link) ? $request->link : "";
    $send->curso = $request->curso;
    $send->grupo = $request->grupo;
    $send->desc = $request->descricao;
    $send->empresa = $send->curso . $send->taxa . $send->cartao . $send->link;
    $send->taxa = $send->taxa !== "" ? "TAXA: $request->taxa_valor\\n" : "";
    $send->cartao = $send->cartao !== "" ? "CARTÃO: $request->cartaoi_valor\\n" : "";
    $send->link = $send->link !== "" ? "LINK: $request->link_valor\\n" : "";
    $send->boleto = "BOLETO: $request->parcelas $request->valor\\n";
    $send->taxavalor = $request->gerartaxa !== "" ? str_replace($de, $para, $request->gerartaxa) : "";
    
    $send->msgtaxa = $request->msgtaxa;
    
    $send->gerartaxa = $request->gerartaxa !== null ? "TAXA GERADA (Junto 1ª Parcela: R$ $request->gerartaxa\\n" : "";

    if($send->msgtaxa !== null){
      //dd($send->msgtaxa );
      //dd('s');
    $send->pagamento = is_null($send->msgtaxa) ? '' : "Gerado taxa $request->parcelas R$$request->valor para " .  Carbon::parse($send->data2)->format('d/m/Y');
    }else{

      //dd('n');
    $send->pagamento = is_null($send->taxa) ? '' : $send->taxa;
    $send->pagamento .= is_null($send->cartao) ? '' : $send->cartao;
    $send->pagamento .= is_null($send->link) ? '' : $send->link;
    $send->pagamento .= is_null($send->boleto) ? '' : $send->boleto;
    $send->pagamento .= is_null($send->gerartaxa) ? '' : $send->gerartaxa;
    }
    
    $send->criado_por = Auth::user()->name;
    $send->desc = str_ireplace("\r\n", "\\n", $send->desc);
    $send->contratos = (count($send->username) > 1 ? implode("/", (array)$send->username) : implode("", (array)$send->username));
    $send->names = (count($send->nomealuno) > 1 ? implode(", ", $send->nomealuno) : implode("",$send->nomealuno));
    $send->nome = "$send->contratos $send->nomeresp ($send->names)";
    if($send->msgtaxa !== ""){
    $send->descricao = "DIV: $send->grupo\\n$send->curso\\n$send->pagamento\\nCONTRATOS: $send->contratos \\nCRIADO POR: $send->criado_por\\n$send->desc";  
    }
    $send->descricao = "DIV: $send->grupo\\n$send->curso\\n$send->pagamento\\nCONTRATOS: $send->contratos \\nCRIADO POR: $send->criado_por\\n$send->desc";

    //dd(count($send->username) > 1 ? implode("|", (array)$send->username) : $send->username);

    //dd($send);
    return $send;
  }

  public function show_client_exist($send, $aluno)
  {
    $send->responsavel = $aluno->accountable()->first();
    $send->cpf == $send->responsavel->document ? $send->status2 = "Esse aluno já possuí um Responsável Financeiro com o mesmo CPF." : $send->status2 = "Esse aluno já possuí um Responsável Financeiro com CPF diferente do inserido.";
    $send->body = "
              <p>$send->status2</p>
              <h5>Dados Existentes</h5>
              <p>Nome:" . $send->responsavel->name . "<br>
              Telefone:" . $send->responsavel->cellphone . "<br>
              CPF:" . $send->responsavel->document . "</p>
              <h5>Novos Dados</h5>
              <p>Nome: $send->nomeresp<br>
              Telefone: $send->telefone<br>
              CPF: $send->cpf</p>
              ";
    $send->footer =
      "<p>O que você deseja fazer?</p> 
              <a href='/collapsible-menu/app/pay/cliente_existe?send=" . urlencode(json_encode($send)) . "' class='btn btn-primary col-12' role='button' aria-disabled='true'>Criar cobrança no Responsável Existente</a>
              <a href='/collapsible-menu/app/pay/create' class='btn btn-primary col-12 mt-2' role='button' aria-disabled='true'>Atualizar o Responsável e gerar cobranças</a>
              <a href='ação2' class='btn btn-secondary col-12 mt-2' role='button' aria-disabled='true'>Sair</a>";

    return $send;
  }

  public function show_end($send){
          $send->body =
              "CRIADO COM SUCESSO!\n\r$send->nomeresp, $send->curso em $send->parcela parcelas de R$ $send->valor";
              return $send->body;
  }

  public function cria_cobranca1($send, $customer, $token){
          
          $sendmsg = new MktController;
          //Pesquisa se cliente existe no Asaas
          if ($send->valor !== "") {
            $dec = $this->cria_cobranca($customer, $send->curso, $send->data2, $send->valor, $send->parcela, $send->taxavalor, $token);
            $send->paybook = $this->getPayBook($dec->installment, str_replace("access_token: ","",$token));
            //$dec = new stdClass;
            //$dec->id = "1";
            //$send->paybook = "Teste";
            if($send->msgtaxa == null){
            //Cria e envia msg inicial
            $msg_text = '*PROFISSIONALIZA CURSOS*\r\n\r\n😊 Olá *' . $send->nomeresp . '* estamos felizes por você fazer parte de uma das maiores Plataformas Profissionalizantes do Brasil.\r\n\r\nNossa equipe está realizando os últimos ajustes referente aos cursos de ' . implode(", ", $send->nomealuno) . '.\r\n\r\nNa sequência vou te mandar algumas informações peço que salve o nosso contato e sempre que precisar de algo esse é o nosso canal Oficial de Suporte.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, aguarde as próximas informações!_*';
            //dd($sendmsg->send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id));
            $job = new Mkt_send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id);
                                                          dispatch($job)->delay(now()->addMinutes(1));
                                                          //dd(dispatch($job));
            }

            //Testa tipo de cobrança e envia msg relacionada
            if($send->msgtaxa !== null){
                $msg_text ='\r\n'. $send->nomeresp . ', referente a ao pagamento da taxa, para ficar mais fácil estou te enviando separado, para efetuar o pagamento da taxa basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
                //dd($sendmsg->send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id));
                $job = new Mkt_send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id);
                                                              dispatch($job)->delay(now()->addMinutes(2));
                                                              //dd(dispatch($job));
                
                return $send;
            }

            if ($send->cartao !== "") {
                $msg_text = '\r\n'. $send->nomeresp . ', nossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Cartão e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
            } else if ($send->link !== "") {
                $link = $this->lista_link($dec->id, $token);
                if(isset($link->data[0]->invoiceUrl)){
                $link = $link->data[0]->invoiceUrl;
                }else{
                  $link = "";
                }

                $msg_text ='\r\n'. $send->nomeresp . ', nossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Link e Boleto, para sua comodidade estou enviando o seu link caso ainda não tenha efetuado pagamento e o seu carnê para pagamento basta clicar nos links abaixo:👇\r\n\r\n Link: ' . $link . '\r\n\r\n Boleto: ' . $send->paybook . '\r\n\r\nQualquer dificuldade, podemos tratar aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
            } else {
                $msg_text ='\r\n'. $send->nomeresp . ', para sua comodidade estamos enviando o seu carnê referente ao curso contratado, para acessá-lo basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
            }
                //dd($sendmsg->send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id));
                $job = new Mkt_send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id);
                                                              dispatch($job)->delay(now()->addMinutes(2));
                                                              //dd(dispatch($job));
                
                
                return $send;
      }else{

        $msg_text = '*PROFISSIONALIZA CURSOS*\r\n\r\n😊 Olá *' . $send->nomeresp . '* estamos felizes por você fazer parte de uma das maiores Plataformas Profissionalizantes do Brasil.\r\n\r\nNossa equipe está realizando os últimos ajustes referente aos cursos de ' . implode(", ", $send->nomealuno) . '.\r\n\r\nNa sequência vou te mandar algumas informações peço que salve o nosso contato e sempre que precisar de algo esse é o nosso canal Oficial de Suporte.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, aguarde as próximas informações!_*';

                //dd($sendmsg->send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id));
                $job = new Mkt_send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id);
                                                              dispatch($job)->delay(now()->addMinutes(1));
                                                              //dd(dispatch($job));

      //Testa se a cobrança é link
      if ($send->link !== "") {
        $send->paybook = "link";        
                $link = $this->lista_link($customer, $token);
                isset($link->data[0]->invoiceUrl) ? $link = $link->data[0]->invoiceUrl : $link = "Solicite seu link na Central de Atendimento.";
                //$link = $link->data[0]->invoiceUrl;
                $msg_text = '\r\n'. $send->nomeresp . ', nossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade Link de Pagamento, para sua comodidade estou enviando o seu link caso ainda não tenha efetuado pagamento, basta clicar no link abaixo:👇\r\n\r\nLink: ' . $link . '\r\n\r\nQualquer dificuldade, podemos tratar aqui mesmo nesse contato.\r\n\r\nCaso o link não esteja habilitado basta salvar nosso contato.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      } else {
        $send->paybook = "Cartão";
                $msg_text = '\r\n'. $send->nomeresp . ', nossa equipe está fazendo os últimos ajustes relacionado ao seu curso, as principais etapas são:👇\r\n\r\n- Entrega de Login e Senha;\n- Liberação dos Cursos na Plataforma;\n- Acompanhamento do Aluno;\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      }
                //dd($sendmsg->send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id));
                $job = new Mkt_send_not_active($send->nome, $send->telefone, "text", $msg_text, $send->id);
                dispatch($job)->delay(now()->addMinutes(1));
                //dispatch($job);

                //dd('s');
                return $send;

    }
  }


  public function cria(Request $request)
  {
    //Normaliza os dados
    $client = new OldAsaasController;
    $send = $client->trata_dados($request);
    //dd($send->resp_exist);
    //dd($send);
    //dd($send->id[1]);

    //dd($send);
   
    if($send->resp_exist == "2"){
        $this->cria_existe((object)$send);
        return redirect('/collapsible-menu/app/pay/create')->with([
          'status' => $send->body
        ]);
    }else if($send->resp_exist == "3"){
        $this->cria_existe((object)$send);
        return redirect('/collapsible-menu/app/pay/create')->with([
          'status' => $send->body
        ]);
    }
    //Seleciona qual token usar
    if (Auth::user()->secretary == "TB") {
          $token = env('ASAAS_TOKEN1');
          $send->secretary = "TB";
    } else if (Auth::user()->secretary == "MGA") {
          $token = env('ASAAS_TOKEN2');
          $send->secretary = "MGA";
    } else {
          $msg = "Token inválido";
          return back()->withErrors(__($msg));
    }

    //Cria cliente e cobranças
          $dec = $this->cria_cliente(implode(",",$send->username), $send->nome, $send->cpf, $send->telefone, $send->email, $send->cep, $send->descricao, $send->empresa, $send->grupo, $token);
          $customer = $dec->id;
          $send = $client->cria_cobranca1($send, $customer, $token);
          //dd($send);
          $send->responsavel = UserAccountable::create([
            'user_id' => $send->id[1],
            'name' => $send->nomeresp,
            'cellphone' => $send->telefone,
            'document' => $send->cpf,
            'secretary' => $send->secretary,
            'active' => 1,
            'body' => '{
              "payload": "' . $send->paybook . '",
              "customer": "' . $customer . '"
            }'
          ]);

          foreach($send->id as $id){
            $user = User::find($id);
            $user->document = $send->cpf;
            $user->user_accountable_id = $send->responsavel->id;
            $user->save();
            $user->observation()->create([
              'obs' => str_ireplace("\\n", "\r\n", $send->descricao)
            ]);
          }

          
          
          $send->body = $client->show_end($send);
            //dd($send->body);
          return back()->with([
            'status' => $send->body
          ]);

  }

  public function cria_existe($send)
  {
    //Captura os dados
    $client = new OldAsaasController;

    $aluno = User::where('id', $send->id[1])->first();
    $send->responsavel = $aluno->accountable()->first();
    //dd($send);
    //Escolhe o token da secretaria
    if ($send->responsavel['secretary'] == "TB") {
      $token = env('ASAAS_TOKEN1');
      $send->secretary = "TB";
    } else if ($send->responsavel['secretary'] == "MGA") {
      $token = env('ASAAS_TOKEN2');
      $send->secretary = "MGA";
    } else {
      $msg = "Token inválido";
      return back()->withErrors(__($msg));
    }

    if($send->resp_exist !== "3"){
        //Localiza o cliente no Asaas
        $dec = $this->lista_cliente($send->cpf, $token);
    }

    

    //Avalia se cliente existe
    if(isset($dec->data[0]->id)){

      $send = $client->cria_cobranca1($send, $dec->data[0]->id, $token);
      //dd($send);
          foreach($send->id as $id){
            $user = User::find($id);
            $user->document = $send->cpf;
            $user->user_accountable_id = $send->responsavel->id;
            $user->observation()->create([
              'obs' => str_ireplace("\\n", "\r\n", $send->descricao)
            ]);
          }

          $send->body = $client->show_end($send);
          return $send;
    }else{
          $dec = $this->cria_cliente(implode(",",$send->username), $send->nome, $send->cpf, $send->telefone, $send->email, $send->cep, $send->descricao, $send->empresa, $send->grupo, $token);
          $customer = $dec->id;
          $send = $client->cria_cobranca1($send, $customer, $token);
          //dd($send);
          $send->responsavel = UserAccountable::create([
            'user_id' => $send->id[1],
            'name' => $send->nomeresp,
            'cellphone' => $send->telefone,
            'document' => $send->cpf,
            'secretary' => $send->secretary,
            'active' => 1,
            'body' => '{
              "payload": "' . $send->paybook . '",
              "customer": "' . $customer . '"
            }'
          ]);

          foreach($send->id as $id){
            $user = User::find($id);
            $user->document = $send->cpf;
            $user->user_accountable_id = $send->responsavel->id;
            $user->save();
            $user->observation()->create([
              'obs' => str_ireplace("\\n", "\r\n", $send->descricao)
            ]);
          }

          $send->body = $client->show_end($send);

          return back()->with([
            'status' => $send->body
          ]);
    }
  }

  /*public function result(Request $request)
  {
    //dd($request->all());
    $request->username = array_unique($request->username);

    $de = array(',');
    $para = array('.');
    $valor = str_replace($de, $para, $request->valor);
    dd($valor);

    foreach ($request->username as $username) {
      //dd($username);
    }

    $aluno = User::where('id', $request->id)->first();

    if (Auth::user()->secretary == "TB") {
      $token = env('ASAAS_TOKEN1');
    } else if (Auth::user()->secretary == "MGA") {
      $token = env('ASAAS_TOKEN2');
    } else {
      $msg = "Token inválido";
      return back()->withErrors(__($msg));
    }
    //dd($_POST["cep"]);
    $pagina = "lista";
    $nomeresp = $_POST["responsavel"];
    $nomealuno = $_POST["aluno"];

    $de = array('(', ')', ' ', '-');
    $para = array('', '', '', '');
    $telefone = str_replace($de, $para, $_POST["telefone"]);

    $email =  $_POST["email"];

    $de = array('.', '-');
    $para = array('', '');
    $cpf = str_replace($de, $para, $_POST["cpf"]);

    //$cpf = $_POST["cpf"];
    //dd($cpf);
    $id = array_unique($request->id);
    $username = array_unique($request->username);
    $valor = preg_replace('/[^0-9]/', '', $_POST["valor"]);
    $parcela = preg_replace('/[^0-9]/', '', $_POST["parcelas"]);
    $data2 = date('Y-m-d', strtotime($_POST["data"]));

    if (count($username));
    foreach ($request->username as $usernamea) {
      $username = $usernamea;
    }
    dd($username);

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

    if ($pagina == "lista") {
      $client = new OldAsaasController;
      $dec = $client->lista_cliente($cpf, $token);
      //dd($dec->data);

      if (!empty($dec->data)) {
        $customer = ($dec->data[0]->id);
        $status2 = "<b>CLIENTE</b><br>";
        $status2 = $status2 . ($dec->data[0]->name);
        $dec = $client->lista_cobranca($customer, $token);
        //dd($dec);
        if ($dec->data == null) {
          $status3 = "<b>COBRANÇA</b><br>";
          $status3 = "Sem cobranças cadastradas.";
        } else {
          $status3 = "<b>COBRANÇA</b><br>";
          $status3 = $status3 . $dec->data[0]->dateCreated . " " . $dec->data[0]->description . " " . $dec->data[0]->billingType . " " . $dec->data[0]->status;
        }


        $status1 = "Cliente já existe";
        $botao1 = "Criar Cobrança";
        $botao2 = "Não Criar";
        $acao2 = "index.php";
        $acao = "/collapsible-menu/app/pay/cliente_existe?";
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
          'status1' => $status1,
          'status2' => $status2,
          'status3' => $status3,
          'botao1' => $botao1,
          'botao2' => $botao2,
          'acao' => $acao,
          'acao2' => $acao2,

        ]);
      } else {
        //dd("n");
        //var_dump($descricao);
        //exit();
        $client = new OldAsaasController;
        $dec = $client->cria_cliente($username, $nome, $cpf, $telefone, $email, $cep, $descricao, $empresa, $grupo, $token);
        //dd($dec);
        $customer = $dec->id;
        $client->notificacao_asaas($customer, $token);
        if (!empty($customer)) {
          $status2 = "<b>CLIENTE CRIADO COM SUCESSO</b> <br>" . $nome;
        } else {
          $status2 = "Cliente não pode ser criado, favor verificar as informações";
        }

        if (!empty($valor)) {
          $dec = $client->cria_cobranca($customer, $curso, $data2, $valor, $parcela, $token);
          //dd($dec);
          $cobranca = $dec->installment;


          if (!empty($cobranca)) {

            $status3 = "<br><b>COBRANÇA CRIADA COM SUCESSO</b> <br>" . $curso . " em " . $parcela . " parcelas de " . "R$" . $valor;

            $send->paybook = $client->getPayBook($dec->installment, str_replace("access_token: ", "", $token));

            $msg = new MktController;
            $url = "https://profissionalizaead.com.br";

            if ($cartao !== "") {
              $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Cartão e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
            } else if ($link !== "") {
              $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Link e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nCom relação ao Link de Pagamento, caso ainda não tenha recebido, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
            } else {
              $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nPara sua comodidade estamos enviando o seu carnê referente ao curso contratado do aluno(a) ' . $nomealuno . ', para acessá-lo basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
            }


            $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
          } else {
            $status3 = "Cobrança não pode ser criada, favor verificar as informações";
          }
        } else {
          $status3 = "";

          $msg = new MktController;
          $url = "https://profissionalizaead.com.br";
          if ($link !== "") {
            $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade Link de Pagamento.\r\n\r\nCaso ainda não tenha recebido o link de pagamento, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
          } else {
            $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe está fazendo os últimos ajustes relacionado ao seu curso, as principais etapas são:👇\r\n\r\n- Entrega de Login e Senha;\n- Liberação dos Cursos na Plataforma;\n- Acompanhamento do Aluno;\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
          }
          $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
        }
        $status1 = "<b>CRIAÇÃO DE BOLETOS</b>";
        $acao = "/collapsible-menu/app/pay/create";
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
          'status1' => $status1,
          'status2' => $status2,
          'status3' => $status3,
          'botao' => $botao,
          'acao' => $acao,
        ]);
      }
    }
  }--}}

  /*public function cliente_existe(Request $request)
  {
    $aluno = User::where('id', $request->id)->first();
    if (Auth::user()->secretary == "TB") {
      $token = env('ASAAS_TOKEN1');
    } else if (Auth::user()->secretary == "MGA") {
      $token = env('ASAAS_TOKEN2');
    } else {
      $msg = "Token inválido";
      return back()->withErrors(__($msg));
    }
    dd($request->all());
    $lista = new OldAsaasController;
    $dec = $lista->lista_cliente($request->cpf, $token);
    dd($dec);
    $customer = ($dec->data[0]->id);


    if (!empty($customer)) {
      $status2 = "<b>UTILIZADO CLIENTE EXISTENTE</b> <br>" . $nome;
    } else {
      $status2 = "Cliente não pode ser criado, favor verificar as informações";
    }

    if (!empty($valor)) {
      $cobranca = new OldAsaasController;
      $dec = $cobranca->cria_cobranca($customer, $curso, $data2, $valor, $parcela, $token);
      //dd($dec);
      $installment = $dec->installment;
      if (!empty($installment)) {
        $status3 = "<br><b>COBRANÇA CRIADA COM SUCESSO</b> <br>" . $curso . " em " . $parcela . " parcelas de " . "R$" . $valor;

        $send->paybook = $cobranca->getPayBook($dec->installment, str_replace("access_token: ", "", $token));

        $msg = new MktController;
        $url = "https://profissionalizaead.com.br";

        if ($cartao !== "") {
          $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Cartão e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        } else if ($link !== "") {
          $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade parcial Link e Boleto, para sua comodidade estou enviando o seu carnê para pagamento basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nCom relação ao Link de Pagamento, caso ainda não tenha recebido, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        } else {
          $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nPara sua comodidade estamos enviando o seu carnê referente ao curso contratado do aluno(a) ' . $nomealuno . ', para acessá-lo basta clicar no link abaixo:👇\r\n\r\n' . $send->paybook . '\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
        }


        $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
      } else {
        $status3 = "Cobrança não pode ser criada, favor verificar as informações";
      }
    } else {
      $status3 = "";

      $msg = new MktController;
      $url = "https://profissionalizaead.com.br";
      if ($link !== "") {
        $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe do financeiro fez o lançamento dos seus dados, o seu pagamento foi na modalidade Link de Pagamento.\r\n\r\nCaso ainda não tenha recebido o link de pagamento, solicite aqui mesmo nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\r\n\r\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      } else {
        $msg_text = '😊 Olá ' . $nomeresp . ', aqui é da *PROFISSIONALIZA CURSOS*\r\n\r\nNossa equipe está fazendo os últimos ajustes relacionado ao seu curso, as principais etapas são:👇\r\n\r\n- Entrega de Login e Senha;\n- Liberação dos Cursos na Plataforma;\n- Acompanhamento do Aluno;\r\n\r\nCaso esteja com alguma dificuldade, por favor informe aqui nesse contato.\r\n\r\nEsse número é o nosso canal oficial de Suporte salve nos seus contatos e fale conosco sempre que precisar.\n*_Agora só responda essa mensagem se precisar de ajuda, bons estudos!_*';
      }
      $msg->send_not_active($nome, $telefone, "text", $msg_text, $aluno->id);
    }
    $status1 = "<b>CRIAÇÃO DE BOLETOS</b>";
    $acao = "/collapsible-menu/app/pay/create";
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
      'status1' => $status1,
      'status2' => $status2,
      'status3' => $status3,
      'botao' => $botao,
      'acao' => $acao,
    ]);
  }*/

  public function list($id)
  {
    if (Auth::user()->role >= 4) {
      $user = User::find($id);
    } else {
      $user = Auth::user();
    }

    if ($user->document == null || $user->document == 99999999999 || $user->document == 00000000000) {
      $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
      return back()->withErrors(__($msg));
    }
    //dd('1');
    if ($user->secretary == "TB" || $user->secretary == "MGA") {
      //dd('1');
    } else {

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
    if (!isset($response->data[0]->id)) {

      while ($a <= 3) {

        $a++;
        if (!isset($response->data[0]->id)) {

          $i++;
          //dd($i);
          //dd($a);
          $response = $client->lista_cliente($user->document, env("ASAAS_TOKEN$i"));

          //dd($response->data);
        }
      }
    }
    //dd($response);
    if (!isset($response->data[0]->id)) {
      $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
      return back()->withErrors(__($msg));
    }
    //dd('s');
    $customer = $response->data[0]->id;
    //dd($customer);
    $cobrancas = ($client->lista_cobranca($customer, env("ASAAS_TOKEN$i")))->data;
    //dd($cobrancas);

    if (isset($cobrancas[0]->billingType)) {
      if ($cobrancas[0]->billingType == "CREDIT_CARD") {
        $link = [
          "status" => $cobrancas[0]->status,
          "url" => $cobrancas[0]->invoiceUrl,
          "date" => Carbon::parse($cobrancas[0]->dueDate)->format('d/m/Y')
        ];
        //dd($link['status']);

        return view('pages.app.pay.list')->with(['link' => $link, 'title' => 'Lista de Pagamentos']);
      }
      if (!isset($cobrancas[0])) {
        //dd('s');
        $msg = "Não foi possível localizar sua fatura, por favor contate o suporte!";
        return back()->withErrors(__($msg));
      }
    }

    return view('pages.app.pay.list')->with(['cobrancas' => $cobrancas, 'title' => 'Lista de Pagamentos', 'i' => $i]);
  }


  public static function getqrcode($id, $i)
  {

    $pix = new OldAsaasController;
    $response = $pix->getpixqr($id, env("ASAAS_TOKEN$i"));
    return ($response);
  }

  public function resend_mkt($cellphone, $msg, $user_id, $msg_id){

    $job = new Mkt_send_not_active('', $cellphone, "text", $msg, $user_id, $msg_id);
                dispatch($job)->delay(now()->addMinutes(5));

  }
}
