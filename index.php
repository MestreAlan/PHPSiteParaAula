<!DOCTYPE html>
<?php 
	session_start();
	//session_destroy();
	//session_start();
?>
<html lang="pt">
    <head>	
        <meta charset="UTF-8">
        <title>Intro</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="js/controladorLog.js"></script>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			body { 
			  background: lightblue ; 
			}

			html {
				font-family: Lato, 'Helvetica Neue', Arial, Helvetica, sans-serif;
				font-size: 14px;
			}

			h5 {
				font-size: 1.28571429em;
				font-weight: 700;
				line-height: 1.2857em;
				margin: 0;
			}

			.card {
				font-size: 1em;
				overflow: hidden;
				padding: 0;
				border: none;
				border-radius: .28571429rem;
				box-shadow: 0 1px 3px 0 #d4d4d5, 0 0 0 1px #d4d4d5;
			}

			.card-block {
				font-size: 1em;
				position: relative;
				margin: 0;
				padding: 1em;
				border: none;
				border-top: 1px solid rgba(34, 36, 38, .1);
				box-shadow: none;
			}

			.card-img-top {
				display: block;
				width: 100%;
				height: auto;
			}

			.card-title {
				font-size: 1.28571429em;
				font-weight: 700;
				line-height: 1.2857em;
			}

			.card-text {
				clear: both;
				margin-top: .5em;
				color: rgba(0, 0, 0, .68);
			}

			.card-footer {
				font-size: 1em;
				position: static;
				top: 0;
				left: 0;
				max-width: 100%;
				padding: .75em 1em;
				color: rgba(0, 0, 0, .4);
				border-top: 1px solid rgba(0, 0, 0, .05) !important;
				background: #fff;
			}

			.card-inverse .btn {
				border: 1px solid rgba(0, 0, 0, .05);
			}

			.profile {
				position: absolute;
				top: -12px;
				display: inline-block;
				overflow: hidden;
				box-sizing: border-box;
				width: 25px;
				height: 25px;
				margin: 0;
				border: 1px solid #fff;
				border-radius: 50%;
			}

			.profile-avatar {
				display: block;
				width: 100%;
				height: 100%;
				border-radius: 50%;
			}

			.profile-inline {
				position: relative;
				top: 0;
				display: inline-block;
			}

			.profile-inline ~ .card-title {
				display: inline-block;
				margin-left: 4px;
				vertical-align: top;
			}

			.text-bold {
				font-weight: 700;
			}

			.meta {
				font-size: 1em;
				color: rgba(0, 0, 0, .4);
			}

			.meta a {
				text-decoration: none;
				color: rgba(0, 0, 0, .4);
			}

			.meta a:hover {
				color: rgba(0, 0, 0, .87);
			}
		</style>

	</head>
	<body>
		<script>
			var dados;
			function salvarEstado(){
				$.ajax({
					url: 'acompanhamento.json', 
					dataType: 'json',  
					async: false, 
					success: function(data){ 
						dados = data;
					}
				});
			}
						
			function trocarPlayer(){
				location.href='controllerMudarPlayer.php';
			}
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
					$_SESSION['login'] = 'nãoIdentificado';
				}
			?>
			login =  "<?php echo $_SESSION['login']; ?>";
			
			<?php 
				if(!isset($_SESSION['tarefasFeitas']))
				{
					$_SESSION['tarefasFeitas'] = json_encode([[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]);
				}
			?>
			
			var tarefasFeitas = <?php echo $_SESSION['tarefasFeitas']; ?>;
			
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
			
			var tarefa = [0,1,0];// Variável apenas para controle de log
						
			var trava = [1,1,1,1];
			function abrirTarefa(a,b,c){
				if(trava[c]==1){
					//location.href='jogo.php?tarefa='+[a,b,c];
					
					
					$.ajax({
						method: "POST",
						url: "salvarSssion.php",
						data: { tarefa: [a,b,c], conhecimentoProgramacao: conhecimentoProgramacao, tarefasFeitas: tarefasFeitas, jaJogouJogosCodedotOrg: jaJogouJogosCodedotOrg, nivelEducacional: nivelEducacional, login: login, perfil: perfil, contadorQuestao: contadorQuestao, aula: aula }
					})
						.done(function( msg ) {
						location.href='jogo.php';
					});
					
				}
			}
			
		</script>
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<div id="identificadorUser">
			</div>
		</nav>
		<div class="jumbotron">
			<div class="container">
				<h1 class="display-3">Acesso</h1>
			</div>
		</div>
		
		<script>
			$(document).ready(function(){
				$(".show-modal").click(function(){
					$("#myModal").modal({
						backdrop: 'none',
						keyboard: false
					});
				});
			});
		</script>

		<!-- Modal HTML -->
		<div id="myModal" class="modal fade" data-backdrop="static">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Dados para acesso:</h4>
					</div>
					<div class="modal-body" id="modalText">
						<h4 class="modal-title">Confirmation</h4>
					</div>
					<div class="modal-footer">
						<span align="justify">Ao clicar em continuar você concorda que os dados de navegação possam ser utilizados de maneira anônima em pesquisa acadêmica visando melhorar a efetividade da ferramenta!</span>
					</div>
					<div class="modal-footer">	
						<button id="btnSubmit" type="button" class="btn btn-default" data-dismiss="modal">Continuar</button>
					</div>
				</div>
			</div>
		</div>
		
		<script>
			var clicou=1;
			if(aula==0||aula==2||aula==4||aula==6){
				$('#myModal').modal('show');
				document.getElementById("modalText").innerHTML = 
				'<div class="container">'+
					'<div class="col-md-12">'+
						'<h3>Digite o número de sua matrícula:</h3>'+
						'<form>'+
							'<input type="text" name="matricula" value=""/>'+
							'<input type="hidden" name="aula" value="<?php echo $aula ?>" />'+
						'</form>'+
					'</div>'+
				'</div>';	
			}else{
				$('#myModal').modal('show');
				document.getElementById("modalText").innerHTML = 
				'<div class="container">'+
					'<div class="col-md-12">'+
						'<h3>Aula não identificada. Por favor, acesse através do link original novamente</h3>'+
						'<form>'+
							'<input type="hidden" type="text" name="matricula" value="nãoIdentificado"/>'+
							'<input type="hidden" name="aula" value=8 />'+
						'</form>'+
					'</div>'+
				'</div>';	
			}
			
			document.getElementById("btnSubmit").onclick = function() {
				if(clicou==1){
					clicou=0;
					salvarEstado();
						
					var radios1 = document.getElementsByName("matricula");
					login = radios1[0].value;
					
					radios1 = document.getElementsByName("aula");
					aula = radios1[0].value;
					
					if(login!="nãoIdentificado"&&aula!=8){				
						var avaliadorTemp = 0;

						while(avaliadorTemp==0){
							var acao;
							perfil = [];
							perfil.push( Math.floor(Math.random() * 2) );//Worked example Verdade com 1
							perfil.push( Math.floor(Math.random() * 2) );//Manter questão Verdade com 1
							
							var procurarIgual = 0;
							
							for (var i = 0; i < dados.length; i++) {
								if(dados[i].perfil1==perfil[0]&&dados[i].perfil2==perfil[1]){
									i = dados.length;
									procurarIgual = 1;
								}
							}					
							if(dados.length>=4&&procurarIgual==0){
								acao=0;//Limpar e inserir
								avaliadorTemp=1;
							}else if(dados.length>=4&&procurarIgual==1){
								acao=1;//Limpar
							}else if(dados.length<4&&procurarIgual==0){
								acao=2;//Inserir
								avaliadorTemp=1;
							}
							if(!(dados.length<4&&procurarIgual==1)){
								$.ajax({
									method: "POST",
									url: "controllerExperimento.php",
									data: { perfil1: perfil[0], perfil2: perfil[1], acao: acao }	
								});
							}
							salvarEstado();
						}	
						funcaoLog("Login aceito");
						
						$.ajax({
							method: "POST",
							url: "salvarSssion.php",
							data: { tarefa: [0,0,0], conhecimentoProgramacao: conhecimentoProgramacao, tarefasFeitas: tarefasFeitas, jaJogouJogosCodedotOrg: jaJogouJogosCodedotOrg, nivelEducacional: nivelEducacional, login: login, perfil: perfil, contadorQuestao: contadorQuestao, aula: aula }
						});
						if(aula==0){
							tarefa[0]=0; 
							funcaoLog('Selecionou fase 1');  
							clicou=1;
							abrirTarefa(0,1,0);
						}else if(aula==2){
							tarefa[0]=2; 
							funcaoLog('Selecionou fase 2');  
							clicou=1;
							abrirTarefa(2,1,1);
						}else if(aula==4){
							tarefa[0]=4; 
							funcaoLog('Selecionou fase 3');  
							clicou=1;
							abrirTarefa(4,1,2);
						}else if(aula==6){
							tarefa[0]=6; 
							funcaoLog('Selecionou fase 4');  
							clicou=1;
							abrirTarefa(6,1,3);
						}else{
							location.href='index.php';
						}
					}else{
						location.href='index.php';
					}
				}
			};
			
		</script>
	</body>
</html>