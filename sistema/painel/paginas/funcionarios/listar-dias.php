<?php 
require_once("../../../conexao.php");
$tabela = 'dias';

$id_func = $_POST['func'];

$query = $pdo->query("SELECT * FROM $tabela where funcionario = '$id_func' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

echo <<<HTML
	<small><small>
	<table class="table table-hover">
	<thead> 
	<tr> 
	<th>Dia</th>		
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
	$id = $res[$i]['id'];
	$dia = $res[$i]['dia'];
	
echo <<<HTML
<tr class="">
<td class="">{$dia}</td>
<td>


		<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirDias('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>



		</td>
</tr>
HTML;

}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-dias-excluir"></div></small>
</table>
</small></small>
HTML;


}else{
	echo '<small>Não possui nenhum Dia Cadastrado!</small>';
}

?>


<script type="text/javascript">
	function excluirDias(id){
    $.ajax({
        url: 'paginas/' + pag + "/excluir-dias.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Excluído com Sucesso") {   
            	var func = $("#id_dias").val();             
                listarDias(func);                
            } else {
                $('#mensagem-dias-excluir').addClass('text-danger')
                $('#mensagem-dias-excluir').text(mensagem)
            }

        },      

    });
}
</script>