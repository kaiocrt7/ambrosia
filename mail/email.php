<?php	
if (isset ($_POST["name"])){
	$nome = $_POST["name"];
} else {
	$nome = "";
}
if (isset ($_POST["email"])){
	$email	= $_POST["email"];
}
if (isset ($_POST["message"])){
	$menssagem	= $_POST["message"];
}
if (isset ($_POST["situacao"])){
	$situacao	= $_POST["situacao"];
}
if (isset ($_POST["telefone"])){
	$telefone = $_POST["telefone"];
}
if (isset ($_POST["assunto"])){
	$assunto = $_POST["assunto"];
}
	
if (isset($_POST["inscrever"])){
	$assunto = "Solicita Ligação";
	
	$texto  = "<html><body><strong>Assunto:</strong><br >".$assunto."<br/ ><br/ >";
	$texto .= "<strong>Nova Notícia: </strong><br />";
	$texto .= "<p>Um novo cliente deseja receber informações sobre a empresa.</p><br />";
	$texto .= "<strong>Email:</strong><br > ".$email." <br/ ><br/ >";
	$texto .= "<strong>Telefone:</strong><br /> ".$telefone."</body></html>";
} else {
	$texto  = "<html><body><strong>Assunto:</strong><br >".$assunto."<br/ >";
	$texto .= "<strong>Nome:</strong><br > ".$nome." <br/ >";
	$texto .= "<strong>Email:</strong><br /> ".$email." <br/ >";
	$texto .= "<strong>Cliente?</strong><br /> ".$situacao." <br/ ><br/ >";
	$texto .= "<strong>Mensagem:</strong><br /> ".$menssagem." </body></html>";
}
	
require_once("phpmailer/class.phpmailer.php");
	
define('GUSER', 'kaiocrt7@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', 'waldez123456sabotagem');		// <-- Insira aqui a senha do seu GMail

$email = "kaio@geralimoveis.com.br";

function smtpmailer($para, $de, $de_nome, $assunto, $texto) { 
	global $error;
	$mail = new PHPMailer();
	
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Ativar Debug
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $texto;
	$mail->AddAddress($para);
	$mail->IsHTML(true);
	$mail->CharSet = "utf8";


	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		return true;
	}
}

if (smtpmailer($email, GUSER, $nome, $assunto, $texto)){
	if (isset($_POST["inscrever"])){
	print "<script>alert('Email enviado com sucesso!');
			location.href='../index_san.php'</script>";
	} else {
		print "<script>alert('Email enviado com sucesso!');
			location.href='../ambrosia/index_san.php'</script>";	
	}
}

// Chamando a função smtpmailer
if (!empty($error)) echo $error;
?>