<?php
require_once("conexao.php");

//INSERIR UM USUÁRIO ADMINISTRADOR CASO NAO EXISTA
$senha = 'gag';
$senha_crip = md5($senha);

$query = $pdo->query("SELECT * from usuarios where nivel = 'Administrador'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
	$pdo->query("INSERT INTO usuarios SET nome = 'Admin', email = '$email_sistema', cpf = '000.000.000-00', senha = '$senha', senha_crip = '$senha_crip', nivel = 'Administrador', data = curDate(), ativo = 'sim', foto = 'sem-foto.jpg'");
}


$query = $pdo->query("SELECT * from cargos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
	$pdo->query("INSERT INTO cargos SET nome = 'Administrador'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $nome_sistema ?></title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->
	<link rel="stylesheet" href="css/estilo-login.css">
	<link rel="icon" type="image/png" href="img/favicon.png">


	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

</head>

<body>



	<div class="container">
		<div class="row vertical-offset-100">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel form-login">
					<div class="panel-heading" align="center">
						<img src="img/logo.png" width="320px">

					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form" role="form" action="autenticar.php" method="post">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="E-mail ou CPF" name="email" type="text">
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="senha" type="password" value="">
								</div>
								<div class="checkbox">
								</div>
								<input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
							</fieldset>
							<p class="recuperar"><a title="Clique para recupearar a senha" href="" data-toggle="modal" data-target="#exampleModal">Recuperar Senha</a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<h5 title="Meu instagram">versão 0.0.0.1 © 2024 Desenvolvido por <a target="_blank" href="https://www.instagram.com/gutto_alvez95/?igsh=cXJqZmswbjY5djV6">Gustavo ALves Gomes</a>
		</h5>
	</div>
</body>

</html>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width:400px">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
				<button id="btn-fechar-rec" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form-recuperar">
				<div class="modal-body">

					<input placeholder="Digite seu Email" class="form-control" type="email" name="email" id="email-recuperar" required>

					<br>
					<small>
						<div id="mensagem-recuperar" align="center"></div>
					</small>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Recuperar</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script type="text/javascript">
	$("#form-recuperar").submit(function() {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "recuperar-senha.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem-recuperar').text('');
				$('#mensagem-recuperar').removeClass()
				if (mensagem.trim() == "Recuperado com Sucesso") {
					//$('#btn-fechar-rec').click();					
					$('#email-recuperar').val('');
					$('#mensagem-recuperar').addClass('text-success')
					$('#mensagem-recuperar').text('Sua Senha foi enviada para o Email')

				} else {

					$('#mensagem-recuperar').addClass('text-danger')
					$('#mensagem-recuperar').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>