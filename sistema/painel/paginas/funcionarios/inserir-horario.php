<?php 
require_once("../../../conexao.php");
$tabela = 'horarios';

$id = $_POST['id'];
$horario = $_POST['horario'];


$pdo->query("INSERT INTO $tabela SET horario = '$horario', funcionario = '$id'");


echo 'Salvo com Sucesso';
 ?>