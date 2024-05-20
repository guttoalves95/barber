<?php 
require_once("../../../conexao.php");
@session_start();
$usuario = @$_SESSION['id'];

$funcionario = @$_SESSION['id'];
$data = @$_POST['data'];


$diasemana = array("Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sabado");
$diasemana_numero = date('w', strtotime($data));
$dia_procurado = $diasemana[$diasemana_numero];

//percorrer os dias da semana que ele trabalha
$query = $pdo->query("SELECT * FROM dias where funcionario = '$funcionario' and dia = '$dia_procurado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) == 0){
		echo 'Este Funcionário não trabalha neste Dia!';
	exit();
}

?>
<div class="row">

	<?php 
	$query = $pdo->query("SELECT * FROM horarios where funcionario = '$funcionario' ORDER BY horario asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		for($i=0; $i < $total_reg; $i++){
			foreach ($res[$i] as $key => $value){}
				$hora = $res[$i]['horario'];
				$horaF = date("H:i", strtotime($hora));


				//validar horario
$query2 = $pdo->query("SELECT * FROM agendamentos where data = '$data' and hora = '$hora' and funcionario = '$funcionario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$hora_agendada = 'disabled';
	$texto_hora = 'text-danger';

}else{
	$hora_agendada = '';
	$texto_hora = '';
}


				?>

				<div class="col-md-2">
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="hora" value="<?php echo $hora ?>" <?php echo $hora_agendada ?>>
					  <label class="form-check-label <?php echo $texto_hora ?>" for="flexRadioDefault1">
					    <?php echo $horaF ?>
					  </label>
					</div>
				</div> 

				<?php 
				
		}
	}
	?>


</div>