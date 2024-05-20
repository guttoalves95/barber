<?php 
require_once("../sistema/conexao.php");

$id = @$_POST['id'];

$pdo->query("DELETE FROM agendamentos where id = '$id'");

echo 'Cancelado com Sucesso';

?>