<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_usuario'])){
	$cod_usuario = $_SESSION['cod_usuario'];
}

if (isset($_POST['username'])){
	$username = $_POST['username'];
}

if (isset($_POST['senha'])){
	$senha = $_POST['senha'];
}

if (isset($_POST["enviar"])){

	if (!empty($senha)){
		$senha = md5 ($senha);
		$str_usuario1 = "UPDATE usuario SET username= ?, senha= ? WHERE cod_usuario= ?";
	} else {
		$str_usuario2 = "UPDATE usuario SET username= ? WHERE cod_usuario= ?";
	}
	
	if (!empty($str_usuario1)){
		$rs = $conn -> prepare ($str_usuario1) or die ("Erro na string UPDATE 1.");
		$rs -> bindParam (1, $username);
		$rs -> bindParam (2, $senha);
		$rs -> bindParam (3, $cod_usuario);
	} else {
		$rs = $conn -> prepare ($str_usuario2) or die ("Erro na string UPDATE 1.");
		$rs -> bindParam (1, $username);
		$rs -> bindParam (2, $cod_usuario);
	}
	
	if ($rs -> execute()){
		print "<script>
				alert('Faça login novamente.');
				document.location.href = 'logout.php';
			</script>";	
	 }
	
} else {
	$rs = $conn -> prepare("SELECT * FROM usuario WHERE cod_usuario=".$cod_usuario."") or die ("Erro na String SELECT 1.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
		$nome = $row -> nome;
		$username = $row -> username;
		$senha = $row -> senha;	
	}
}

$conn = NULL;
require "index.php";
?>

<br />
<?php
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\">".$msg."</span>";
} 
?>

<div class="module">
          <h2><span>ALTERAR - USUÁRIO</span></h2>          
          <div class="module-body">
    <form action="" name="form1" method="post">
              <div class="row">
        <div class="col-xs-8">
                  <input type="text" placeholder="Nome" value="<?php print $nome;?>" class="form-control" readonly="readonly" id="nome" name="nome">
                </div>
      	</div>
        <br />
        
        <div class="row">
            <div class="col-xs-4">
                      <input type="text" class="form-control" required id="username" name="username" value="<?php print $username;?>" placeholder="Username">
             </div>
        	<div class="col-xs-4">
                  <input type="password" class="form-control" id="senha" name="senha" placeholder="Redefinir Senha">
            </div>          
     	</div>            
             
              <br />
              <br />
              <br />
              <br />
            <button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
            </button>
            
            <button type="botton" onclick="javascript:history.go(-1)" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar
            </button>
                
       </fieldset>
    </form>
</div>
<div style="clear:both;"></div>
        
       
<!-- End .container_12 --> 

<?php 
$conn_pedido = NULL;
require "rodape.php"; ?>