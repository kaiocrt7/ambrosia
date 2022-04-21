<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}

if (isset($_POST['username'])){
	$username = $_POST['username'];
}

if (isset($_POST['senha'])){
	$senha = $_POST['senha'];
}

if (isset($_POST["enviar"])){
	if ($_POST['senha']){
		$senha = $_POST['senha'];
	}
	$nome = $_POST['nome'];
	$username = $_POST['username'];
	$cnpj = $_POST['cnpj'];
	$empresa = $_POST['empresa'];
	$localizacao = $_POST['localizacao'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];

	if (!empty($senha)){
		$senha = md5 ($senha);
		$str_usuario1 = "UPDATE cliente SET username= ?, senha= ?, nome= ?, empresa= ?, email= ?, telefone= ?, cnpj= ?, localizacao= ? WHERE cod_cliente= ?";
	} else {
		$str_usuario2 = "UPDATE cliente SET username= ?, nome= ?, empresa= ?, email= ?, telefone= ?, cnpj= ?, localizacao= ? WHERE cod_cliente= ?";
	}
	
	if (!empty($str_usuario1)){
		$rs = $conn_pedido -> prepare ($str_usuario1) or die ("Erro na string UPDATE 1.");
		$rs -> bindParam (1, $username);
		$rs -> bindParam (2, $senha);
		$rs -> bindParam (3, $nome);
		$rs -> bindParam (4, $empresa);
		$rs -> bindParam (5, $email);
		$rs -> bindParam (6, $telefone);
		$rs -> bindParam (7, $cnpj);
		$rs -> bindParam (8, $localizacao);
		$rs -> bindParam (9, $cod_cliente);
	} else {
		$rs = $conn_pedido -> prepare ($str_usuario2) or die ("Erro na string UPDATE 2.");
		$rs -> bindParam (1, $username);
		$rs -> bindParam (2, $nome);
		$rs -> bindParam (3, $empresa);
		$rs -> bindParam (4, $email);
		$rs -> bindParam (5, $telefone);
		$rs -> bindParam (6, $cnpj);
		$rs -> bindParam (7, $localizacao);
		$rs -> bindParam (8, $cod_cliente);
	}
	
	if ($rs -> execute()){
		print "<script>
				alert('Faça login novamente.');
				document.location.href = 'logout.php';
			</script>";	
	 }
	
} else {
	$rs = $conn_pedido -> prepare("SELECT * FROM cliente WHERE cod_cliente=".$cod_cliente."") or die ("Erro na String SELECT 1.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
		$empresa = $row -> empresa;
		$username = $row -> username;
		$email = $row -> email;	
		$telefone = $row -> telefone;
		$cnpj = $row -> cnpj;
		$localizacao = $row -> localizacao;
		$nome = $row -> nome;
	}
}

$conn_pedido = NULL;
require "index.php";
?>

<br />

<div class="module">
<h2><span>ALTERAR - PERFIL</span></h2>
<div class="module-body">
  <form action="" name="form1" method="post">
    <div class="row">
      <div class="col-xs-4">
        <input type="text" class="form-control" placeholder="Nome" value="<?php print $nome;?>" id="nome" name="nome">
      </div>
      <div class="col-xs-4">
        <input type="text" class="form-control" placeholder="Empresa" value="<?php print $empresa;?>" id="empresa" name="empresa">
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-xs-4">
        <input type="text" class="form-control" value="<?php print $cnpj;?>" maxlength="18" placeholder="CNPJ" id="cnpj" name="cnpj">
      </div>
      <div class="col-xs-4">
        <input type="text" class="form-control" placeholder="Localização" value="<?php print $localizacao;?>" id="localizacao" name="localizacao">
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-xs-4">
        <input type="text" maxlength="14" class="form-control" required value="<?php print $telefone;?>" id="telefone" name="telefone" placeholder="Telefone" onkeypress="mascara(this)">
      </div>
      <div class="col-xs-4">
        <input type="text" class="form-control" placeholder="Email" value="<?php print $email;?>" id="email" name="email">
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-xs-4">
        <input type="text" class="form-control" placeholder="Username" value="<?php print $username;?>" id="username" name="username">
      </div>
      <div class="col-xs-4">
        <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha">
      </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar </button>
    <button type="botton" onclick="javascript:history.go(-1)" class="btn btn-default"> <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar </button>
    </fieldset>
  </form>
</div>

<div style="clear:both;"></div>

<!-- End .container_12 -->

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>
