<?php


$banco = 'barber';
$usuario = 'root';
$senha = '';
$servidor = 'localhost';

$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/barber/";
}


date_default_timezone_set('America/Sao_Paulo');

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Não conectado ao Banco de Dados! <br><br>' .$e;
}

//VARIAVEIS DO SISTEMA
$nome_sistema = 'G.ALVES sistemas';
$email_sistema = 'admin';
$whatsapp_sistema = '(48)99830-6387';

$query = $pdo->query("SELECT * from config ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg == 0){
	$pdo->query("INSERT INTO config SET nome = '$nome_sistema', email = '$email_sistema', telefone_whatsapp = '$whatsapp_sistema', logo = 'logo.png', icone = 'favicon.ico', logo_rel = 'logo_rel.jpg', tipo_rel = 'pdf', tipo_comissao = 'Porcentagem', texto_rodape = 'Edite este texto nas configurações do painel administrador', img_banner_index = 'hero-bg.jpg', quantidade_cartoes = 10, texto_agendamento = 'Selecionar Prestador de Serviço', msg_agendamento = 'Sim'");
}else{
	$nome_sistema = $res[0]['nome'];
	$email_sistema = $res[0]['email'];
	$whatsapp_sistema = $res[0]['telefone_whatsapp'];
	$tipo_rel = $res[0]['tipo_rel'];
	$telefone_fixo_sistema = $res[0]['telefone_fixo'];
	$endereco_sistema = $res[0]['endereco'];
	$logo_rel = $res[0]['logo_rel'];
	$logo_sistema = $res[0]['logo'];
	$icone_sistema = $res[0]['icone'];
	$instagram_sistema = $res[0]['instagram'];
	$tipo_comissao = $res[0]['tipo_comissao'];
	$texto_rodape = $res[0]['texto_rodape'];
	$img_banner_index = $res[0]['img_banner_index'];
	$icone_site = $res[0]['icone_site'];
	$texto_sobre = $res[0]['texto_sobre'];
	$imagem_sobre = $res[0]['imagem_sobre'];
	$mapa = $res[0]['mapa'];
	$quantidade_cartoes = $res[0]['quantidade_cartoes'];
	$texto_fidelidade = $res[0]['texto_fidelidade'];
	$texto_agendamento = $res[0]['texto_agendamento'];
	$msg_agendamento = $res[0]['msg_agendamento'];
	
	

	$tel_whatsapp = '55'.preg_replace('/[ ()-]+/' , '' , $whatsapp_sistema);
	
	
}



 ?>