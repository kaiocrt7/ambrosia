<?php
session_start();
require "conexao_pdo.php";

if (isset ($_POST["username"])){
	$username = trim($_POST["username"]);
}
if (isset($_POST["senha"])){
	$senha = trim($_POST["senha"]);
}
	
if (!empty($username) && !empty($senha)){
	
	$senha = md5($senha);
	
	$str_usuario = "SELECT * FROM usuario WHERE username='".$username."' AND senha='".$senha."'";
	
	$rs = $conn -> prepare ($str_usuario) or die ("ERRO NA STRING SQL.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
		
		if (!empty($row -> cod_usuario)){
			$_SESSION ["cod_usuario"] = $row -> cod_usuario;
			$_SESSION ["username"] = $row -> username;
			$_SESSION ["senha"] = $row -> senha;
			
			$autentica = $row -> cod_usuario.$row -> username.$row -> senha;
			$_SESSION["autentica"] = md5 ($autentica);
				
			header("Location: index.php");
		} else {
			print "<script>
					alert('Usuario nao existe.');
					document.location.href = 'login.php';
				</script>";	
		}
	}
}
	
$conn = NULL;
?>
