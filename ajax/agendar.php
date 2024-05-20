<?php 
require_once("../sistema/conexao.php");

$telefone = $_POST['telefone'];
$nome = $_POST['nome'];
$funcionario = $_POST['funcionario'];
$hora = @$_POST['hora'];
$servico = $_POST['servico'];
$obs = $_POST['obs'];
$data = $_POST['data'];
$id = @$_POST['id'];

if($hora == ""){
	echo 'Escolha um Horário para Agendar!';
}

//validar horario
$query = $pdo->query("SELECT * FROM agendamentos where data = '$data' and hora = '$hora' and funcionario = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Este horário não está disponível!';
	exit();
}

//Cadastrar o cliente caso não tenha cadastro
$query = $pdo->query("SELECT * FROM clientes where telefone LIKE '$telefone' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) == 0){
	$query = $pdo->prepare("INSERT INTO clientes SET nome = :nome, telefone = :telefone, data_cad = curDate(), cartoes = '0', alertado = 'Não'");

	$query->bindValue(":nome", "$nome");
	$query->bindValue(":telefone", "$telefone");	
	$query->execute();
	$id_cliente = $pdo->lastInsertId();

}else{
	$id_cliente = $res[0]['id'];
}


if($id == ""){
	//marcar o agendamento
	$query = $pdo->prepare("INSERT INTO agendamentos SET funcionario = '$funcionario', cliente = '$id_cliente', hora = '$hora', data = '$data', usuario = '0', status = 'Agendado', obs = :obs, data_lanc = curDate(), servico = '$servico'");

	echo 'Agendado com Sucesso';
	
}else{
	//edito o agendamento
	$query = $pdo->prepare("UPDATE agendamentos SET funcionario = '$funcionario', hora = '$hora', data = '$data', usuario = '0', status = 'Agendado', obs = :obs, data_lanc = curDate(), servico = '$servico' where id = '$id'");

	echo 'Editado com Sucesso';
}

$query->bindValue(":obs", "$obs");
$query->execute();



?>