<?php 
require_once("cabecalho.php");
$data_atual = date('Y-m-d');
?>
<style type="text/css">
	.sub_page .hero_area {
		min-height: auto;
	}
</style>

</div>

<div class="footer_section" style="background: #5a8e94; ">
	<div class="container" >
		<div class="footer_content " >
			<form id="form-agenda" method="post" style="margin-top: -25px !important">
			<div class="footer_form footer-col">
				<div class="form-group">
					<input onkeyup="buscarNome()" class="form-control" type="text" name="telefone" id="telefone" placeholder="Seu Telefone DDD + número" required />
				</div>

				<div class="form-group">
					<input onclick="buscarNome()" class="form-control" type="text" name="nome" id="nome" placeholder="Seu Nome" required />
				</div>

				<div class="form-group">
					<input onchange="mudarFuncionario()" class="form-control" type="date" name="data" id="data" value="<?php echo $data_atual ?>" required />
				</div>


				<div class="form-group">			
					<select class="form-control sel2" id="funcionario" name="funcionario" style="width:100%;" onchange="mudarFuncionario()" required> 
						<option value=""><?php echo $texto_agendamento ?></option>
						<?php 
						$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY id desc");
						$res = $query->fetchAll(PDO::FETCH_ASSOC);
						$total_reg = @count($res);
						if($total_reg > 0){
							for($i=0; $i < $total_reg; $i++){
								foreach ($res[$i] as $key => $value){}
									echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
							}
						}
						?>


					</select>   
				</div> 	


				<div class="form-group"> 								
					<div id="listar-horarios">
						
					</div>
				</div>	


				<div class="form-group"> 							
					<select onchange="mudarServico()" class="form-control sel2" id="servico" name="servico" style="width:100%;" required> 
						<option value="">Selecione um Serviço</option>

						<?php 
						$query = $pdo->query("SELECT * FROM servicos ORDER BY nome asc");
						$res = $query->fetchAll(PDO::FETCH_ASSOC);
						$total_reg = @count($res);									
						if($total_reg > 0){
							for($i=0; $i < $total_reg; $i++){
								foreach ($res[$i] as $key => $value){}
									$valor = $res[$i]['valor'];
								$valorF = number_format($valor, 2, ',', '.');

								echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].' - R$ '.$valorF.'</option>';
							}
						}
						?>


					</select>    
				</div>		

								
					<div class="form-group"> 						
						<input maxlength="100" type="text" class="form-control" name="obs" id="obs" placeholder="Observações caso exista alguma.">
					</div>	

					  <button onclick="salvar()" class="botao-verde" type="submit" style="width:100%;">
                 <span id='botao_salvar'>Confirmar Agendamento</span>
                   
                </button>

                  <button class="botao-azul" id='botao_editar' type="submit" style="width:100%;">              
                   Editar Agendamento
                </button>


                  <button type="button" id='botao_excluir' style="width:100%;" data-toggle="modal" data-target="#modalExcluir">               
                   Excluir Agendamento
                </button>

                <br><br>
               <small> <div id="mensagem" align="center"></div></small>			

               <input type="text" id="data_oculta" style="display: none">	
                <input type="hidden" id="id" name="id">	
                 <input type="hidden" id="hora_rec" nome="hora_rec">	
                  <input type="hidden" id="nome_func" nome="nome_func">	
                  <input type="hidden" id="data_rec" nome="data_rec">	
                    <input type="hidden" id="nome_serv" nome="nome_serv">			
				

			</div>



		</form>




<div id="listar-cartoes" style="margin-top: -30px">

</div>


		</div>


	</div>


</div>




<?php require_once("rodape.php") ?>






  <!-- Modal Depoimentos -->
  <div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Excluir Agendamento
                   </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px" id="btn-fechar-excluir">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <form id="form-excluir">
      <div class="modal-body">

      	<span id="msg-excluir"></span>
                   
            <input type="hidden" name="id" id="id_excluir">


          <br>
          <small><div id="mensagem-excluir" align="center"></div></small>
        </div>

        <div class="modal-footer">      
          <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
      </form>

      </div>
    </div>
  </div>






<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style type="text/css">
	.select2-selection__rendered {
		line-height: 45px !important;
		font-size:16px !important;
		color:#000 !important;

	}

	.select2-selection {
		height: 45px !important;
		font-size:16px !important;
		color:#000 !important;

	}
</style>  



<script type="text/javascript">
	$(document).ready(function() {
		document.getElementById("botao_editar").style.display = "none";
		document.getElementById("botao_excluir").style.display = "none";
		$('.sel2').select2({
			
		});
	});
</script>


<script type="text/javascript">
	
	function mudarFuncionario(){
		var funcionario = $('#funcionario').val();
		var data = $('#data').val();
		console.log(data)
		var hora = $('#hora_rec').val();
		listarHorarios(funcionario, data, hora);
		listarFuncionario();	

	}
</script>



<script type="text/javascript">
	function listarHorarios(funcionario, data, hora){	

		
		$.ajax({
			url: "ajax/listar-horarios.php",
			method: 'POST',
			data: {funcionario, data, hora},
			dataType: "text",

			success:function(result){
				$("#listar-horarios").html(result);
			}
		});
	}
</script>



<script type="text/javascript">
	
	function buscarNome(){
		var tel = $('#telefone').val();	
		listarCartoes(tel);	
		
		$.ajax({
			url: "ajax/listar-nome.php",
			method: 'POST',
			data: {tel},
			dataType: "text",

			success:function(result){
				var split = result.split("*");
				console.log(split[3])

				if(split[2] == "" || split[2] == undefined){

				}else{
					$("#funcionario").val(parseInt(split[2])).change();
				}


				if(split[5] == "" || split[5] == undefined){
					document.getElementById("botao_editar").style.display = "none";
					document.getElementById("botao_excluir").style.display = "none";
				}else{
					$("#servico").val(parseInt(split[5])).change();
					document.getElementById("botao_editar").style.display = "block";
					document.getElementById("botao_excluir").style.display = "block";
					$("#botao_salvar").text('Novo Agendamento');
				}

				$("#nome").val(split[0]);
				$("#data_oculta").val(split[1]);
				$("#data").val($("#data_oculta").val());
				$("#id").val(split[3]);
				$("#hora_rec").val(split[4]);
				$("#obs").val(split[6]);
				$("#id_excluir").val(split[3]);
				$("#nome_func").val(split[8]);
				$("#data_rec").val(split[7]);
				$("#nome_serv").val(split[9]);

				$("#msg-excluir").text('Deseja Realmente excluir esse agendamento feito para o dia ' + split[7] + ' às ' + split[4]);


				mudarFuncionario()
				


			}
		});	




	}
</script>



<script type="text/javascript">
	
	function salvar(){
		$('#id').val('');
			}
</script>




<script>

	$("#form-agenda").submit(function () {
		event.preventDefault();


		var formData = new FormData(this);

		$.ajax({
			url: "ajax/agendar.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (mensagem.trim() == "Agendado com Sucesso") {                    
					$('#mensagem').text(mensagem)
					buscarNome()

					var nome = $('#nome').val();
					var data = $('#data').val();
					var hora = document.querySelector('input[name="hora"]:checked').value;
					var obs = $('#obs').val();
					var nome_func = $('#nome_func').val();
					var nome_serv = $('#nome_serv').val();

					var dataF = data.split("-");
					var dia = dataF[2];
					var mes = dataF[1];
					var ano = dataF[0];
					var dataFormatada = dia + '/' + mes + '/' + ano;

					var horaF = hora.split(':');
					var horaH = horaF[0];
					var horaM = horaF[1];
					var horaFormatada = horaH + ':' + horaM;

					var msg_agendamento = "<?=$msg_agendamento?>";

					if(msg_agendamento == 'Sim'){

				let a= document.createElement('a');
			          a.target= '_blank';
			          a.href= 'http://api.whatsapp.com/send?1=pt_BR&phone=<?=$tel_whatsapp?>&text= _Novo Agendamento_ %0A Funcionário: *' + nome_func + '* %0A Serviço: *' + nome_serv + '* %0A Data: *' + dataFormatada + '* %0A Hora: *' + horaFormatada + '* %0A Cliente: *' + nome + '*  %0A %0A ' + obs;
			          a.click();
			          return;		

			      }


				}


				else if (mensagem.trim() == "Editado com Sucesso") {                    
					$('#mensagem').text(mensagem)
					//buscarNome()

					var nome = $('#nome').val();
					var data = $('#data').val();
					var hora = document.querySelector('input[name="hora"]:checked').value;
					var obs = $('#obs').val();
					var nome_func = $('#nome_func').val();
					var nome_serv = $('#nome_serv').val();

					var dataF = data.split("-");
					var dia = dataF[2];
					var mes = dataF[1];
					var ano = dataF[0];
					var dataFormatada = dia + '/' + mes + '/' + ano;

					var horaF = hora.split(':');
					var horaH = horaF[0];
					var horaM = horaF[1];
					var horaFormatada = horaH + ':' + horaM;

					var msg_agendamento = "<?=$msg_agendamento?>";

					if(msg_agendamento == 'Sim'){

				let a= document.createElement('a');
			          a.target= '_blank';
			          a.href= 'http://api.whatsapp.com/send?1=pt_BR&phone=<?=$tel_whatsapp?>&text= *Atenção:* _Agendamento Editado_ %0A Funcionário: *' + nome_func + '* %0A Serviço: *' + nome_serv + '* %0A Data: *' + dataFormatada + '* %0A Hora: *' + horaFormatada + '* %0A Cliente: *' + nome + '*  %0A %0A ' + obs + '';
			          a.click();
			          return;		

			      }


				}


				 else {
					//$('#mensagem').addClass('text-danger')
					$('#mensagem').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});

</script>




<script>

	$("#form-excluir").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "ajax/excluir.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem-excluir').text('');
				$('#mensagem-excluir').removeClass()
				if (mensagem.trim() == "Cancelado com Sucesso") {    
				    $('#btn-fechar-excluir').click();     	          
					$('#mensagem').text(mensagem)
					buscarNome()	


					var nome = $('#nome').val();
					var data = $('#data').val();
					var hora = document.querySelector('input[name="hora"]:checked').value;
					var obs = $('#obs').val();
					var nome_func = $('#nome_func').val();
					var nome_serv = $('#nome_serv').val();

					var dataF = data.split("-");
					var dia = dataF[2];
					var mes = dataF[1];
					var ano = dataF[0];
					var dataFormatada = dia + '/' + mes + '/' + ano;

					var horaF = hora.split(':');
					var horaH = horaF[0];
					var horaM = horaF[1];
					var horaFormatada = horaH + ':' + horaM;


					var msg_agendamento = "<?=$msg_agendamento?>";

					if(msg_agendamento == 'Sim'){

				let a= document.createElement('a');
			          a.target= '_blank';
			          a.href= 'http://api.whatsapp.com/send?1=pt_BR&phone=<?=$tel_whatsapp?>&text= *Atenção:* _Agendamento Cancelado_ %0A Funcionário: *' + nome_func + '* %0A Serviço: *' + nome_serv + '* %0A Data: *' + dataFormatada + '* %0A Hora: *' + horaFormatada + '* %0A Cliente: *' + nome + '*';
			          a.click();
			          return;		

			      }

				} else {
					//$('#mensagem').addClass('text-danger')
					$('#mensagem-excluir').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});

</script>


<script type="text/javascript">
	
	function listarCartoes(tel){

			$.ajax({
			url: "ajax/listar-cartoes.php",
			method: 'POST',
			data: {tel},
			dataType: "text",

			success:function(result){
				$("#listar-cartoes").html(result);
			}
		});
		
			}
</script>





<script type="text/javascript">
	function listarFuncionario(){	
		var func = $("#funcionario").val();
		
		$.ajax({
			url: "ajax/listar-funcionario.php",
			method: 'POST',
			data: {func},
			dataType: "text",

			success:function(result){
				$("#nome_func").val(result);
			}
		});
	}
</script>


<script type="text/javascript">
	function mudarServico(){	
		var serv = $("#servico").val();
		
		$.ajax({
			url: "ajax/listar-servico.php",
			method: 'POST',
			data: {serv},
			dataType: "text",

			success:function(result){
				$("#nome_serv").val(result);
			}
		});
	}
</script>