<?php
require_once "conexao_pdo_cliente.php";

if (isset($_POST['listar'])){ 
		header ("Location: list_clientes.php");
}


if (isset ($_POST['enviar'])) {
	$nome = trim($_POST['nome']);
	$empresa = trim($_POST['empresa']);
	$cnpj = trim($_POST['cnpj']);
	$telefone = trim($_POST['telefone']);
	$email = trim($_POST['email']);
	$username = trim($_POST['username']);
	$senha = md5(trim($_POST['senha']));
	$localizacao = trim($_POST['localizacao']);
	
	$total = 0;
	$rs_verifica = $conn_pedido -> prepare ("SELECT * FROM cliente WHERE nome='".$nome."' OR empresa='".$empresa."'") or die ("Erro na String SELECT 1.");
	$rs_verifica -> execute();
	$total = $rs_verifica -> rowCount();
	
	if ($total > 0){
		$msg_warning = "<strong>Este gerente ou esta empresa já existe na base de dados.</strong>";
		header ("Location: ?msg_warning=".$msg_warning."");
	}else {
				
		$str_cliente = "INSERT INTO cliente (nome, empresa, cnpj, telefone, email, username, senha, localizacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";		
			
		$rs = $conn_pedido -> prepare ($str_cliente) or die ("Erro ao preparar a string.");
		$rs -> bindParam (1, $nome);
		$rs -> bindParam (2, $empresa);
		$rs -> bindParam (3, $cnpj);
		$rs -> bindParam (4, $telefone);
		$rs -> bindParam (5, $email);
		$rs -> bindParam (6, $username);
		$rs -> bindParam (7, $senha);
		$rs -> bindParam (8, $localizacao);
			
			if ($rs -> execute()){
				$msg = "<strong>Cliente cadastrado com sucesso</strong>.";
				header ("Location: ?msg=".$msg."");
			} else {
				$msg_warning = "<strong>As informações não pode ser cadastrada.</strong>";
				header ("Location: ?msg_warning=".$msg_warning."");
			}
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
        
        <button type="submit" class="btn btn-default" id="listar" name="listar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        </button>
            
     	</div> 
</form>

<?php
if (isset($_GET["msg"])){
	$msg = $_GET["msg"];
	print "<span class=\"notification n-success\">".$msg."</span>";
}
if (isset($_GET["msg_warning"])){
	$msg_warning = $_GET["msg_warning"];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
}
?>

<div class="module">  
           <h2><span>CADASTRAR - CLIENTES</span></h2>                    
          <div class="module-body">
    <form action="" name="form1" method="post">
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Gerente" id="nome" name="nome">
            </div>
          <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Empresa" id="empresa" name="empresa">
            </div>
        </div>    
        <br />
        
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" onKeyPress="MascaraCNPJ(cnpj);" maxlength="18" placeholder="CNPJ" id="cnpj" name="cnpj">
            </div>
          <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Localização" id="localizacao" name="localizacao">
            </div>
        </div>   
        <br />  
        
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" maxlength="14" class="form-control" required id="telefone" name="telefone" placeholder="Telefone" onkeypress="mascara(this)">
            </div>
          <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Email" id="email" name="email">
            </div>
        </div> 
        <br />
        
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Username" id="username" name="username">
            </div>
          <div class="col-xs-4">
              <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha">
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
