<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Email</title>
</head>

<body>
<h1>Envio de email</h1>

<form action="email.php" method="post">
<fieldset>
	<legend>Dados</legend>
	<label for="nome">Nome:</label>
	<input type="text" name="nome" size="35" placeholder="Insira o seu nome" required="required" />
	<br />

	<label for="email">E-mail:</label>
	<input type="text" name="email" size="35" placeholder="Insira o email do destinatário" required="required" />
	<br />

	<label for="assunto">Assunto:</label>
	<input type="text" name="assunto" size="35" placeholder="Insira o assunto da mensagem" required="required" />
	<br />
    
	<label for="mensagem">Mensagem:</label>
	<textarea name="mensagem" rows="8" cols="40" required="required"></textarea>
	<br />
    
	<input type="submit" name="Enviar" value="Enviar" />
</fieldset>
</form>
</body>
</html>