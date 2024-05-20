<?php 
require_once("../../../conexao.php");
$tabela = 'dias';

$id = $_POST['id'];
$dias = $_POST['dias'];


$pdo->query("INSERT INTO $tabela SET dia = '$dias', funcionario = '$id'");


echo 'Salvo com Sucesso';
 ?>