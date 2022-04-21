<?php 
require_once "conexao_pdo_cliente.php";

if (isset($_GET["cod_cliente"])){
	$cod_cliente = trim($_GET["cod_cliente"]);
} 

if (isset($_POST['cadastrar'])){ 
		header ("Location: cad_cliente.php");
}

if (isset($_POST['listar'])){ 
		header ("Location: list_clientes.php");
}

if (isset($_POST["enviar"])){
	if (isset ($_POST["nome"])){
		$nome = trim($_POST["nome"]);
	}
	if (isset ($_POST["empresa"])){
		$empresa = trim($_POST["empresa"]);
	}
	if (isset ($_POST["cnpj"])){
		$cnpj = trim($_POST["cnpj"]);
	}
	if (isset ($_POST["telefone"])){
		$telefone = trim($_POST["telefone"]);
	}
	if (isset ($_POST["email"])){
		$email = trim($_POST["email"]);
	}
	if (isset ($_POST["localizacao"])){
		$localizacao = trim($_POST["localizacao"]);
	}
	if (isset ($_POST["username"])){
		$username = trim($_POST["username"]);
	}
	if (isset ($_POST["senha"])){
		$senha = trim($_POST["senha"]);
	}
	if (isset ($_POST["status"])){
		$status = trim($_POST["status"]);
	}
		
	if (!empty($nome) && !empty($empresa) && !empty($cnpj) && !empty($telefone) && !empty($email) && !empty($localizacao) && !empty($username)){
		
		if (empty($senha)){			
			$str_cliente = "UPDATE cliente SET nome= ?, empresa= ?, cnpj= ?, telefone= ?, email= ?, localizacao= ?, username= ?, status= ? WHERE cod_cliente = ?";
			$rs = $conn_pedido -> prepare($str_cliente) or die("ERRO NA STRING SQL UPDATE 1.");
			$rs -> bindParam(1, $nome);
			$rs -> bindParam(2, $empresa);
			$rs -> bindParam(3, $cnpj);
			$rs -> bindParam(4, $telefone);
			$rs -> bindParam(5, $email);
			$rs -> bindParam(6, $localizacao);
			$rs -> bindParam(7, $username);
			$rs -> bindParam(8, $status);
			$rs -> bindParam(9, $cod_cliente);
		} else {
			$senha = md5($senha);
			$str_cliente = "UPDATE cliente SET nome= ?, empresa= ?, cnpj= ?, telefone= ?, email= ?, localizacao= ?, username= ?, senha= ?, status= ? WHERE cod_cliente = ?";
			$rs = $conn_pedido -> prepare($str_cliente) or die("ERRO NA STRING SQL UPDATE 1.");
			$rs -> bindParam(1, $nome);
			$rs -> bindParam(2, $empresa);
			$rs -> bindParam(3, $cnpj);
			$rs -> bindParam(4, $telefone);
			$rs -> bindParam(5, $email);
			$rs -> bindParam(6, $localizacao);
			$rs -> bindParam(7, $username);
			$rs -> bindParam(8, $senha);
			$rs -> bindParam(9, $status);
			$rs -> bindParam(10, $cod_cliente);		
		}
		
		 if ($rs -> execute()) {
			 $msg = "Cadastro alterado com sucesso.";
			 header("Location: list_clientes.php?msg=".$msg."");
		 } else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			 header("Location: edit_cliente.php?msg_warning=".$msg_warning."&cod_cliente=".$cod_cliente."");
		 }
		
	} else {
		print "<strong>Existe campos vazios no formulário.</strong>";
	}
} else {
	$str_cliente = "SELECT * FROM cliente WHERE cod_cliente=".$cod_cliente."";
	$rs = $conn_pedido -> prepare($str_cliente) or die ("Erro na string SELECT 3.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
	
		$nome = $row -> nome;
		$empresa = $row -> empresa;
		$cnpj = $row -> cnpj;
		$telefone = $row -> telefone;
		$email = $row -> email;
		$localizacao = $row -> localizacao;
		$username = $row -> username;
		$status = $row -> status;
	}
}

require "index_adm_pedido.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
               <input value="Clientes" class="form-control" readonly="readonly" />
          </div>
        
        <button type="submit" class="btn btn-success btn-default" id="listar" name="listar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        </button>
        
        <button type="submit" class="btn btn-default" id="cadastrar" name="cadastrar">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cadastrar
        </button>
            
     	</div> 
</form>

<?php
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\">".$msg."</span>";
} 
if (isset($_GET['msg_warning'])){
	$msg_warning = $_GET['msg_warning'];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
} 
?>

<div class="module">
          <h2><span>EDIÇÃO - CONTATO</span></h2>
          <div class="module-body">
         	
    <form name="form1" method="post" action=""> 
    
        <div class="row">             
        <div class="col-xs-8">
            <div class="form-group">
              <select class="form-control" id="status" name="status">
              <?php if($status == "Desbloqueado") {?>
                <option value="Desbloqueado" selected="selected">Desbloqueado</option>
                <option value="Desbloqueado">Desbloqueado</option>
                <option value="Bloqueado">Bloqueado</option>
              <?php }?>
              <?php if($status == "Bloqueado") {?>
                <option value="Bloqueado" selected="selected">Bloqueado</option>
                <option value="Bloqueado" selected="selected">Bloqueado</option>
                <option value="Desbloqueado">Desbloqueado</option>
              <?php }?>
              </select>
            </div>
        </div>
        </div>
        <br />
                 
      <div class="row">
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $nome;?>" id="nome" name="nome">
        </div>
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $empresa;?>" id="empresa" name="empresa">
        </div>
      </div>
      <br />
      
      <div class="row">
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $cnpj;?>" id="cnpj" name="cnpj">
        </div>
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $localizacao;?>" id="localizacao" name="localizacao">
        </div>
      </div>
      <br />
      
      <div class="row">
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $telefone;?>" id="telefone" name="telefone">
        </div>
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $email;?>" id="email" name="email">
        </div>
      </div>
      <br />
      
      <div class="row">
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $username;?>" id="username" name="username">
        </div>
        <div class="col-xs-4">
            <input type="password" class="form-control" placeholder="Redefinir Senha" id="senha" name="senha">
        </div>
      </div>
      
              <br />          
              <br />
                            
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
               	<button type="button" onClick='javascript:location.href="list_clientes.php"' class="btn btn-default">
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