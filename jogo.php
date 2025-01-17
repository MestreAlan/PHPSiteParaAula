<!DOCTYPE html>
<!-- saved from url=(0070)file:///C:/Users/alanr/Desktop/Nova%20pasta/kiddos/kiddos/courses.html -->
<?php 
	session_start();
?>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Desafio GamEdu</title>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script src="blockly_compressed.js"></script>
		<script src="blocks_compressed.js"></script>
		<script src="msg/js/pt-br.js"></script>
		<!--Injector do phaser-->
        <script src="js/phaser.min.js"></script>        
        <script src="js/phaser-arcade-physics.min.js"></script>        
		<!--Fim do Injector do phaser-->
		<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script>
			
			
            /* FIM DO CODIGO QUE PEGA OS DADOS DA URL */
			<?php 
				$aula = isset($_GET['aula']) ? $_GET['aula'] : 8;
				if(isset($_SESSION['aula']))
				{
					$aula = $aula==8 ? $_SESSION['aula'] : $aula;
				}
				$_SESSION['aula'] = $aula;
			?>
			var aula = <?php echo $_SESSION['aula']; ?>;
			<?php 
				if(!isset($_SESSION['conhecimentoProgramacao']))
				{
					$_SESSION['conhecimentoProgramacao'] = "Nunca programei";					
				}
			?>
			var conhecimentoProgramacao =  "<?php echo $_SESSION['conhecimentoProgramacao']; ?>";
			<?php 
				if(!isset($_SESSION['jaJogouJogosCodedotOrg']))
				{
					$_SESSION['jaJogouJogosCodedotOrg'] = ".org:Não";
				}
			?>
			var jaJogouJogosCodedotOrg =  "<?php echo $_SESSION['jaJogouJogosCodedotOrg']; ?>";
			<?php 
				if(!isset($_SESSION['nivelEducacional']))
				{
					$_SESSION['nivelEducacional'] = "Nehuma das opções";
				}
			?>
			var nivelEducacional =  "<?php echo $_SESSION['nivelEducacional']; ?>";
			<?php 
				if(!isset($_SESSION['login']))
				{
					$_SESSION['login'] = 'naoIdentificado';
				}
			?>
			var login =  "<?php echo $_SESSION['login']; ?>";
			<?php 
				if(!isset($_SESSION['tarefasFeitas']))
				{
					$_SESSION['tarefasFeitas'] = json_encode([[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]);
				}
			?>
			var tarefasFeitas = <?php echo $_SESSION['tarefasFeitas']; ?>;
			<?php 
				if(!isset($_SESSION['tarefa']))
				{
					$_SESSION['tarefa'] = json_encode([0,1,0]);
				}
			?>
			var tarefa = <?php echo $_SESSION['tarefa']; ?>;
			
			var controleQuestaoDif = tarefa[0]; //controla qual o tipo de questão atual
			
			<?php 
				if(!isset($_SESSION['perfil']))
				{
					$_SESSION['perfil'] = json_encode([0,0]);
				}
			?>
			var perfil = <?php echo $_SESSION['perfil']; ?>;
			
			<?php 
				if(!isset($_SESSION['contadorQuestao']))
				{
					$_SESSION['contadorQuestao'] = 0;
				}
			?>
			var contadorQuestao = <?php echo $_SESSION['contadorQuestao']; ?>;
			
			var completo = 0;//variável apra identificar se completou tudo
			var desvio = 0; //variável para controlar o desvio de função caso erre dentro do perfil ?,1
			var registro = [[],[],[],[],[],[],[],[],[]];
			var posiRef = 0;
			var respostaTexto = 0;
			var questoes = [];
			var contadorQuestao = 0;
			var limitadorContadorQuestoes = 6;
			var dificuldade = 3;
			function inicializadorQuestoes(){		
				$.ajax({ 
					url: 'js/questoes.json', 
					dataType: 'json',  
					async: false, 
					success: function(data){ 
						question_catalog = data;
						
						for(var i=0;i<question_catalog.questoes.length;i++){
							questoes.push(question_catalog.questoes[i]);
						}
						
					} 
				});
			}

			function closePHP(){
				
				login='nãoIdentificado';
				salvarSession();
				location.href='index.php';	
				
			}
			
			function salvarSession(){
				
				$.ajax({
					method: "POST",
					url: "salvarSssion.php",
					data: { tarefa: tarefa, conhecimentoProgramacao: conhecimentoProgramacao, tarefasFeitas: tarefasFeitas, jaJogouJogosCodedotOrg: jaJogouJogosCodedotOrg, nivelEducacional: nivelEducacional, login: login, perfil: perfil, contadorQuestao: contadorQuestao, aula: aula }
				});	
				
			}
			
			//Pegar evento F5
			document.onkeydown = fkey;
			document.onkeypress = fkey
			document.onkeyup = fkey;

			function fkey(e){
					e = e || window.event;	
					if (e.keyCode == 116) {
						closePHP();
					}
			 }
			 //Fim pegar evento
			
		</script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<style type="text/css">
			h1 {
			    font-weight: normal;
			    font-size: 130%;
			}

			.level_number {
			    border: solid 1px #ddd;
			    border-radius: 20px;
			    padding: 6px 12px;
			    color: #888;
			}			
			.level_incorrect { 
			    background-color: yellow;
			    color: #000;
			}
			.level_correct { 
			    background-color: lightgreen;
			    color: #000;
			}
			.level_actual { 
			    background-color: #ddd;
			    color: #000;
			}
			.card{
				width: 500px;
				border-radius: 20px;
				LINE-HEIGHT:2px;
			}

		</style>

	</head>
	<script src="js/controladorLog.js"></script>
  
	<body data-aos-easing="slide" data-aos-duration="800" data-aos-delay="0">
	
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco_navbar ftco-navbar-light" id="ftco-navbar">
			<div class="container d-flex align-items-center">
				
			  </button>
			  <!-- <p class="button-custom order-lg-last mb-0"><a href="appointment.html" class="btn btn-secondary py-2 px-3">Make An Appointment</a></p> -->
			  <div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ml-auto">
					<li id="identificadorUser" class="nav-item active"><a href="#head-edu" onclick="funcaoLog('Clicou no nome');" class="nav-link">Matrícula: <?php echo $_SESSION['login']; ?> </a></li>
					<li class="nav-item active"><a href="#head-edu2" onclick="funcaoLog('Clicou em Sair'); closePHP();" class="nav-link">CLIQUE AQUI PARA DESLOGAR SUA MATRÍCULA</a></li>
				</ul>
			  </div>
			</div>
		  </nav>
		<!-- END nav -->
		
		<div id="feedback">
			
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 box-blocky">
					<div class="row">
						<div id="quadro3">
							<ul></ul>
						</div>
					</div>
				</div>
				<div class="col-md-4 box-phaser">
					<div class="row">
						<div id="quadro4">
							<ul></ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<h1><a id="title">Aprenda a codificar com este jogo:</a> &nbsp;  
			<a class="level_number level_actual" id="leve1" href="javascript:atualizarMissao(1); controleQuestaoDif=tarefa[0]; dificuldade=3; funcaoLog('Selecionou o botão 1');">1</a> 
			<a class="level_number " id="leve2" href="javascript:atualizarMissao(2); controleQuestaoDif=tarefa[0]; dificuldade=4; funcaoLog('Selecionou o botão 2');">2</a> 
			<a class="level_number " id="leve3" href="javascript:atualizarMissao(3); controleQuestaoDif=tarefa[0]; dificuldade=5; funcaoLog('Selecionou o botão 3');">3</a> 
			<a class="level_number " id="leve4" href="javascript:atualizarMissao(4); controleQuestaoDif=parseInt(tarefa[0])+1; dificuldade=6; funcaoLog('Selecionou o botão 4');">4</a>
			<a class="level_number " id="leve5" href="javascript:atualizarMissao(5); controleQuestaoDif=parseInt(tarefa[0])+1; dificuldade=7; funcaoLog('Selecionou o botão 5');">5</a>
			<a class="level_number " id="leve6" href="javascript:atualizarMissao(6); controleQuestaoDif=parseInt(tarefa[0])+1; dificuldade=8; funcaoLog('Selecionou o botão 6');">6</a>
		</h1>
		<hr>
		<h5>					Rode com o código que leva o jogador da posição inicial para a final:
		</h5>
		<table>
			<tr>
				<td>
					<div>
						<center>
							<div id="quadro1">
								<ul></ul>
							</div>
							<div id="quadro20">
								<ul></ul>
							</div>
							<BR><BR>
							<button type="button" onclick="funcaoLog('Executou o código na tarefa '+parseInt(parseInt(contadorQuestao)+parseInt(1))); buttonStart();" class="btn btn-success">Rodar código selecionado</button>
						</center>
					</div>
				</td>
				<td>
					<div>
						&nbsp;
					</div>
				</td>
				<td>
					<div>
						<div id="accordion">
							<div class="card">
								<div class="card-header" id="heading1">
								</div>
								
								<div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="heading2">
								</div>

								<div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="heading3">
								</div>

								<div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="heading4">
								</div>
								
								<div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
								</div>
							</div>
						
						</div>
					</div>
				</td>
				<td>
					<div>
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
						&nbsp;
					</div>
				</td>
				<td>
					<div>
						<center>
							<div id="quadro2">
								<ul></ul>
							</div>
							<BR><BR>
							<div id="quadro5">
								
							</div>
						</center>
					</div>
				</td>
			</tr>
		</table>

		<script>
			if(perfil[0]==1){
				document.getElementById("quadro5").innerHTML = ""+
				"<div class='container'>"+
					"<button type='button' onclick='salvarSession(); funcaoLog(\"Apertou o botão exemplo\"); window.open(\"jogoDuvida.php\", \"duvidaExemplo\", \"height=1000px,width=1500px\");' class='btn btn-success'>Gerar um exemplo</button>"+
				"</div>";
			}
			$(document).ready(function(){
				$(".show-modal").click(function(){
					$("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
				});
			});
			
			$(document).ready(function(){
				$(".show-modal2").click(function(){
					$("#myModal2").modal({
						backdrop: 'static',
						keyboard: false
					});
				});
			});
			
			function verificacaoComplete(){
				var temp1 = 0;
				for(var i=0; i<tarefasFeitas[tarefa[2]].length ; i++){
					if(tarefasFeitas[tarefa[2]][i]==0){
						temp1 = 1;
						i = tarefasFeitas[tarefa[2]].length;
					}
				}
				if(temp1==0&&completo==0){
					$('#myModal2').modal('show');
					funcaoLog("Completou todas as tarefas");
					completo = 1;
					document.getElementById("modalText2").innerHTML = "<h4 class='modal-title'>Você completou todas as tarefas, se quiser ir para outra tarefa clique sobre 'CLIQUE AQUI PARA ESCOLHER OUTRO JOGO' para escolher outra fase ou continue nesta atividade.</h4>";
					
				}
			}
			
		</script>

		<!-- Modal HTML -->
		<div id="myModal" class="modal fade" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" id="modalText">
						<h4 class="modal-title">Confirmation</h4>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick='refactory();' data-dismiss="modal">Continuar</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Modal HTML -->
		<div id="myModal2" class="modal fade" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" id="modalText2">
						<h4 class="modal-title">Confirmation</h4>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick='refactory();' data-dismiss="modal">Continuar</button>
					</div>
				</div>
			</div>
		</div>

	  <script src="js/jquery.min.js"></script>
	  <script src="js/jquery-migrate-3.0.1.min.js"></script>
	  <script src="js/popper.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>
	  <script src="js/jquery.easing.1.3.js"></script>
	  <script src="js/jquery.waypoints.min.js"></script>
	  <script src="js/jquery.stellar.min.js"></script>
	  <script src="js/owl.carousel.min.js"></script>
	  <script src="js/jquery.magnific-popup.min.js"></script>
	  <script src="js/aos.js"></script>
	  <script src="js/jquery.animateNumber.min.js"></script>
	  <script src="js/scrollax.min.js"></script>
	  <script src="js/main.js"></script>
	  <script>
			function abrirPagina(titulo_conteudo,local){
				$.get(titulo_conteudo).success(function(res){
					$(local).html(res);
					$(document).ready(function(){
						funcaoLog('Entrou_pagina do jogo');
					});
				});
			}
			inicializadorQuestoes();
			abrirPagina('phaser.html',"#quadro1");
			abrirPagina('blockly.html',"#quadro20");
			
			for(var i=0;i<tarefasFeitas[tarefa[2]].length;i++){
				var j=i+1;
				if(tarefasFeitas[tarefa[2]][i]==1){
					$("#leve"+j).addClass("level_correct");
				}else if(tarefasFeitas[tarefa[2]][i]==2){
					$("#leve"+j).addClass("level_incorrect");
				}
				if(i==0){
					$("#leve"+j).addClass("level_actual");
				}
			}
			
		</script>
	</body>
</html>








