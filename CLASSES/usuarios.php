<?php 

class Usuario 
{

private $pdo;
public $msgErro = ""; //tudo ok

	public function conectar($nome, $host, $usuario, $senha)
	{
		global $pdo;
		try
		 {
			$pdo = new pdo("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
		 } 
			catch (PDOException $e) {
			$msgErro = $e->Getmessage();	
		}	  
	}

	public function cadastrar($nome, $telefone, $email, $senha)
	{
		global $pdo;
		//Verificar se ja existe o email cadastrado
		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email =:e");
		$sql->bindValue(":e",$email);
		$sql->execute();
		if($sql->rowcount() > 0)
		{
			return false; // Ja esta cadastrada
		}
		else
		{
		//Caso nao, Cadastarar

			$sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
			$sql->bindValue(":n",$nome);
			$sql->bindValue(":t",$telefone);
			$sql->bindValue(":e",$email);
			$sql->bindValue(":s",md5($senha));
			$sql->execute();
			return true;
		}

	}


	public function logar($email, $senha)

	{

		global $pdo;
		//Verificar se usuario e senha estao cadastrados,

   		$sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
    	$sql->bindValue(":e",$email);
    	$sql->bindValue(":s",md5($senha));
    	$sql->execute();
    	if ($sql->rowcount() > 0)
    	{
			//se sim entrar no sistema
    		$dado = $sql->fetch();
    		session_start();
    		$_SESSION['id_usuario'] = $dado['id_usuario'];
    		return true; //Logado com sucesso
    	}
    	else
    	{
    		return false; //Nao foi possivel localizar os dados
    	}
	}
}
 ?>