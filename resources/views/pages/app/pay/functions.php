<?php
include_once ("token.php");

// Busca se o cliente existe no Asaas
function lista_cliente($cpf){
global $token;
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
function cria_cliente($id, $nome, $cpf, $telefone, $cep, $descricao, $grupo, $token){
$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, "https://www.asaas.com/api/v3/customers");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"name\": \"$nome\",
  \"phone\": \"$telefone\",
  \"mobilePhone\": \"$telefone\",
  \"observations\": \"$descricao\",
  \"company\": \"$descricao\",
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
function notificacao_asaas($customer){
global $token;

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
function cria_cobranca($customer, $curso, $data2, $valor, $parcela){
global $token;
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

function lista_cobranca($customer){
global $token;
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

?>