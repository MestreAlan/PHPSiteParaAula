<?phpsession_start();?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Flat Login</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="css/css.css">
	<script src="js/jquery-3.4.1.js"></script>
</head>
<body>
    <div class="container">
		<div class="flat-form">
			<img src="images/princi.png"  width="390" height="250">
		<div>
        <div class="flat-form">
            <ul class="tabs">
                <li>
                    <a href="#login" class="active">Login</a>
                </li>
                <li>
                    <a href="#register">Registrar</a>
                </li>
            </ul>
            <div id="login" class="form-action show">
				<h1>Login</h1>
                <p>
                    O sistem não faz diferenciação de letras maiúsculas e minúsculas!
                </p>
                <form method="post" action="controllerLogin.php" id="formlogin" name="formlogin">
                    <ul>
                        <li>
                            <input type="text" placeholder="Usuário" id="login" name="login"/>
                        </li>
                        <li>
                            <input type="password" placeholder="Senha" id="senha" name="senha"/>
                        </li>
                        <li>
                            <input type="submit" value="Entrar" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#login.form-action-->
            <div id="register" class="form-action hide">
                
                <form method="post" action="controllerCadastro.php" id="formCadastro" name="formCadastro">
                    <ul>
                        <li>
                            <input type="text" placeholder="Usuário" id="cadastroNome" name="cadastroNome" minlength="4" required maxlength="12" required />
                        </li>
                        <li>
                            <input type="password" placeholder="Senha" id="cadastroSenha" name="cadastroSenha" minlength="4" required />
                        </li>
						<li>
                            <input type="text" placeholder="Curso" id="cadastroCurso" name="cadastroCurso" minlength="2" required maxlength="20" required />
                        </li>
						<li>
                            <input type="email" minlength="7" required maxlength="30" required placeholder="Email" id="cadastroEmail" name="cadastroEmail" />
                        </li>
                        <li>
                            <input type="submit" value="Cadastrar" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</body>

<script>
(function( $ ) {
  // constants
  var SHOW_CLASS = 'show',
      HIDE_CLASS = 'hide',
      ACTIVE_CLASS = 'active';
  
  $( '.tabs' ).on( 'click', 'li a', function(e){
    e.preventDefault();
    var $tab = $( this ),
         href = $tab.attr( 'href' );
  
     $( '.active' ).removeClass( ACTIVE_CLASS );
     $tab.addClass( ACTIVE_CLASS );
  
     $( '.show' )
        .removeClass( SHOW_CLASS )
        .addClass( HIDE_CLASS )
        .hide();
    
      $(href)
        .removeClass( HIDE_CLASS )
        .addClass( SHOW_CLASS )
        .hide()
        .fadeIn( 550 );
  });
})( jQuery );
</script>

</html>