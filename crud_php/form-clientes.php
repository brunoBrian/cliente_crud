<?php
	require('/Cliente.php');

	$cliente = new Cliente();

	$nome = isset($_POST['nome'])?$_POST['nome']:'';
	$email = isset($_POST['email'])?$_POST['email']:'';
	$telefone = isset($_POST['telefone'])?$_POST['telefone']:'';


	#-----------------------------Inserir elementos---------------------------#
	if(isset($_POST['confirmar'])){

		if(!isset($_SESSION))//verifica se tem alguma sessao aberta. se nao tiver, começa uma sessao
			session_start();

		foreach ($_POST as $chave => $valor) {
			$_SESSION[$chave] = $valor;
		}
 					 #--------Validaçoes dos campos -------------------------#

		if(strlen($_SESSION['nome']) == 0)
			$erro[] = "Preencha o campo nome ";

		if(substr_count($_SESSION['email'], '@')!= 1 || substr_count($_SESSION['email'], '.') < 1 || substr_count($_SESSION['email'], '.') > 2)
			$erro[] = "Preencha o campo email corretamente (ex:<small>nome@gmail.com</small>) ";
		
		if(strlen($_SESSION['telefone']) > 11 || strlen($_SESSION['telefone']) < 8)
			$erro[] = "Preencha o campo telefone corretamente (ex:<small>00000-0000</small>)";

		if(count($erro) == 0){
			$save = $cliente->inserir($_SESSION['nome'], $_SESSION['email'], $_SESSION['telefone']);
		    if($save){
		   	    header('Location: clientes.php');
			}
		} 
		if(count($erro) > 0){
			echo "<div class='erro'>";
			foreach($erro as $valor) {
				echo "$valor <br>";
			}
			echo "</div>";
		}


		/*if(!empty($nome) && !empty($email) && !empty($telefone)){
	    	$save = $cliente->inserir($nome, $email, $telefone);
		    if($save){
			        header('Location: clientes.php');
			}
		}*/
	}

	#-----------------------------Alterar elementos---------------------------#
?>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clientes</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">


		<?php
			
			$msg = '';

			if(isset($_POST['salvar'])){
				$id = intval($_GET["id"]);
				$nome = addslashes(trim($_POST["nome"]));
				$email = addslashes(trim($_POST["email"]));
				$telefone = addslashes(trim($_POST["telefone"]));
		
				$alterar = $cliente->inserir($id,$nome,$email,$telefone);
				if($alterar){
					header('Location: clientes.php');
				}else
					echo "Deu";
			}

			if(isset($_GET['msg']))
			    $msg = $_GET['msg'];

			if($msg == 'alterar'){
				//verifica se existem os dados para a atualizaçao
					if(isset($_GET['id']))
					{
						 $id = $_GET['id'];
						 extract($cliente->getID($id)); 
					}
						
		?>
				<form action="form-clientes.php" method="POST" style="text-align:center" >
				<legend style="text-align:center">Alterar Cliente</legend>
			        <input value="<?php echo $id; ?>" type="hidden" class="form-control" id="id" name="id">
			        Nome: <input type="text" value="<?php echo $nome; ?>"  name="nome" >
			        Email: <input type="text" value="<?php echo $email; ?>"  name="email" >
			        Telefone: <input type="text" value="<?php echo $telefone; ?>"  name="telefone">
			        <input type="submit" name="salvar">    
		    </form><br><br><br>
		<?php
			}else{
		?>
			<form action="form-clientes.php" method="POST" style="text-align:center" >
				<legend style="text-align:center">Novo Cliente</legend>
			        <input value="" type="hidden" class="form-control" id="id" name="id">
			        Nome: <input type="text" value="<?php echo $nome; ?>"  name="nome" >
			        Email: <input type="text" value="<?php echo $email; ?>"  name="email" >
			        Telefone: <input type="text" value="<?php echo $telefone; ?>"  name="telefone">
			        <input type="submit" name="confirmar">    
		    </form><br><br><br>
		<?php
			}
		?>
		
		    <a href="index.php" class="btn btn-primary" >Inicio</a>
		</div>
	</body>
</html>