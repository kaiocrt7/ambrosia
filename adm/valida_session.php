<?php
session_start();

if (isset($_SESSION["cod_usuario"])){
	$cod_usuario = $_SESSION["cod_usuario"];
}
if (isset($_SESSION["username"])){
	$username = $_SESSION["username"];
}
if (isset($_SESSION["senha"])){
	$senha = $_SESSION["senha"];
}
if (isset($_SESSION["autentica"])){
	$autentica = $_SESSION["autentica"];
}

if (empty($cod_usuario) && empty($username) && empty($senha)){
		session_destroy();
		header ("Location: login.php?error=error");	
} else {
	$autenticado = $cod_usuario.$username.$senha;
	if ($autentica != md5($autenticado)){
		session_destroy();
		header ("Location: login.php?error=error");
	}
}	
?>