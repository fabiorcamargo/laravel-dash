<?php
include_once ("form.php");
include_once ("functions.php");

$pagina = $_GET["pagina"];


$nomeresp = $_POST["responsavel"];
$nomealuno = $_POST["aluno"];
$telefone = $_POST["telefone"];
$cpf = $_POST["cpf"];
$id = $_POST["id"];
$valor = preg_replace('/[^0-9]/', '', $_POST["valor"]);
$parcela = preg_replace('/[^0-9]/', '', $_POST["parcelas"]);
$data2 = date('Y-m-d', strtotime($_POST["data"]));
$nome = $id . " " . $nomeresp . " (" . $nomealuno . ")";
$UF = $_POST["uf"];
$cidade = $_POST["cidade"];
$cep = $_POST["cep"];
$taxa = $_POST["taxa"];
$cartaop = $_POST["cartaop"];
$cartaoi = $_POST["cartaoi"];
$curso = $_POST["curso"];
$grupo = $_POST["grupo"];
$descricao = $curso . $taxa . $cartaop . $cartaoi;

//var_dump($curso);

if ($pagina == "lista"){
$dec = lista_cliente($cpf);

if (!empty($dec->data)){
$customer = ($dec->data[0]->id);
$status2 ="<b>CLIENTE</b><br>";
$status2 = $status2 . ($dec->data[0]->name);
$dec = lista_cobranca($customer);
$status3 = "<b>COBRANÇA</b><br>";
$status3 = $status3 . $dec->data[0]->dateCreated . " " . $dec->data[0]->description . " " . $dec->data[0]->billingType . " " . $dec->data[0]->status;

$status1 = "Cliente já existe";
$botao1 = "Criar Cobrança";
$botao2 = "Não Criar";
$acao2 = "index.php";
$acao = "'cliente_existe.php?";
$acao = $acao . "nomeresp=" . urlencode($nomeresp) . "&";
$acao = $acao . "nomealuno=" . urlencode($nomealuno) . "&";
$acao = $acao . "telefone=" . urlencode($telefone) . "&";
$acao = $acao . "cpf=" . urlencode($cpf) . "&";
$acao = $acao . "id=" . urlencode($id) . "&";
$acao = $acao . "valor=" . urlencode($valor) . "&";
$acao = $acao . "parcela=" . urlencode($parcela) . "&";
$acao = $acao . "data2=" . urlencode($data2) . "&";
$acao = $acao . "nome=" . urlencode($nome) . "&";
$acao = $acao . "UF=" . urlencode($UF) . "&";
$acao = $acao . "cidade=" . urlencode($cidade) . "&";
$acao = $acao . "cep=" . urlencode($cep) . "&";
$acao = $acao . "taxa=" . urlencode($taxa) . "&";
$acao = $acao . "cartaop=" . urlencode($cartaop) . "&";
$acao = $acao . "cartaoi=" . urlencode($cartaoi) . "&";
$acao = $acao . "curso=" . urlencode($curso) . "&";
$acao = $acao . "descricao=" . urlencode($descricao) . "'";


include ("modal2.html");


}else{
//var_dump($descricao);
//exit();
$dec = cria_cliente($id, $nome, $cpf, $telefone, $cep, $descricao, $grupo);
$customer = ($dec->id);
notificacao_asaas($customer);
if (!empty ($customer)){
  $status2 = "<b>CLIENTE CRIADO COM SUCESSO</b> <br>" . $nome;
}else{
  $status2 = "Cliente não pode ser criado, favor verificar as informações";
}	
	
if (!empty($valor)){
$dec = cria_cobranca($customer, $curso, $data2, $valor, $parcela);
$cobranca = $dec->installment;
if (!empty($cobranca)){
$status3 = "<br><b>COBRANÇA CRIADA COM SUCESSO</b> <br>" . $descricao . " em " . $parcela . " parcelas de " . "R$" . $valor;
}else{
$status3 = "Cobrança não pode ser criada, favor verificar as informações";
}
}else{
$status3 = "";
}
$status1 = "<b>CRIAÇÃO DE BOLETOS</b>";
$acao = "index.php";
$botao = "Fechar";
include ("modal1.html");

}}