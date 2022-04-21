<?php
session_start();

if (isset($_SESSION["cod_cliente"])){
	$cod_cliente = $_SESSION["cod_cliente"];
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
if (isset($_SESSION["empresa"])){
	$empresa = $_SESSION["empresa"];
}

if (empty($cod_cliente) && empty($username) && empty($senha)){
		session_destroy();
		header ("Location: login.php?error=error");	
} else {
	$autenticado = $empresa.$cod_cliente.$username.$senha;
	if ($autentica != md5($autenticado)){
		session_destroy();
		header ("Location: login.php?error=error");
	}
}	
?>