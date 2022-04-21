<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login - Clientes</title>
<link rel="stylesheet" type="text/css" href="../css/login.css"/>
</head>  
<body id="login-bg"> 	

<div id="login-holder">
<?php
if (isset($_GET["error"]) && $_GET["error"] == "error"){
	$error = $_GET["error"];
	print "<script>alert('Cliente não logado.');</script>";
}
?>
<div id="logo-login">	
<h2 align="center">Clientes</h2><br />
</div>	
<div class="clear"></div>

  <div id="loginbox">
	<!--  start login-inner -->
	<div id="login-inner">
    
    <form name="form1" method="post" action="../adm_pedidos/valida_login.php">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Username</th>
			<td><input type="text" class="login-inp" required="required" id="username" name="username" /></td>
		</tr>
		<tr>
			<th>Senha</th>
			<td><input type="password" id="senha" required="required" name="senha" class="login-inp" /></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" id="entrar" name="entrar" value="Entrar" class="submit-login"  /></td>
		</tr>
		</table>
        </form>
        <a href="../adm/login.php" target="_blank">Administrador</a>
	</div>

</body>
</html>