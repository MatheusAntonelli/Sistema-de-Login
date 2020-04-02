<?php 
	require_once 'CLASSES/usuarios.php';
	$u = new Usuario;

 ?>

<html lang= "pt-br"> 
<head>
<meta charset "utf-8"/>	
<title> Cadastro</title>
<link rel="stylesheet"  href="CSS/estilo.css">
</head>
<body>

	<div id="corpo-form-cad">
	<h1>Cadastrar</h1>
	<form method="POST">
		<input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
		<input type="text" name="telefone" placeholder="telefone" maxlength="30" >
		<input type="email" name="E-mail" placeholder="Usuario" maxlength="34">
		<input type="password" name="senha"placeholder="Senha" maxlength="20">
		<input type="password" name="confsenha" placeholder="Confirmar Senha">
		<input type="submit" value="Cadastrar">
	
	</form>
</div>
<?php 
//verificar se clicou no botao 
if(isset($POST['nome']))
{
	$nome = addslashes($POST['nome']);
	$telefone = addslashes($POST['telefone']);
	$email = addslashes($POST['email']);
	$senha = addslashes($POST['senha']);
	$confirmarsenha = addslashes($POST['confsenha']);
	//verificar se algum campo esta vazio
	if(!empty($nome) && !empty($telefone) && !empty($email) && empty($senha) && !empty($confirmarsenha))
	{
		$u->conectar("login","localhost","root", "");
		if($u->$msgErro =="")//Esta tudo ok
		{
			if($senha == $confirmarsenha)
			{
				if($u->cadastrar($nome,$telefone,$email,$senha))
				{
					echo "Cadastrado com sucesso! Acesse para entrar!";
				}
				else
				{
					echo "Email ja cadastrado!";
				}	
            }
			else
			{
				echo "Senha e Confirmar senha nao correspondem!";
			}			
		}
		else
		{
			echo "Erro: ".$u->$msgErro;
		}		
	}	
}
	

 ?>

</body>
</html>