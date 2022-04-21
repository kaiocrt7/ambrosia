<?php 
require_once "conexao_pdo.php";	

if (isset($_GET["cod_contato"])){
	$cod_contato = trim($_GET["cod_contato"]);
}

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_menu_principal.php");
	}else { 
		$msg_warning = "Essa operação não pode ser pesquisada.";
		header ("Location: ?msg_warning=".$msg_warning."&cod_contato=".$cod_contato."");
	}	
} 

if (isset($_POST['editar']) && !empty($operacao)){ 
		if ($operacao == 2){
			$rs = $conn -> prepare("SELECT * FROM quem_somos") or die ("Erro na string SELECT 1.");
			if ($rs -> execute()){
				$row = $rs -> fetch(PDO::FETCH_OBJ);
				$cod_texto = $row -> cod_texto;
				
				header ("Location: edit_quem_somos.php?cod_texto=".$cod_texto."");
			} else {
				print "Tabela quem somos não encontrada.";
			}
	}else if ($operacao == 3){
			$rs = $conn -> prepare("SELECT * FROM contato") or print ("Erro na string.");
			if ($rs -> execute()){
				$row = $rs -> fetch(PDO::FETCH_OBJ);
				$cod_contato = $row -> cod_contato;
				
				header ("Location: edit_contato.php?cod_contato=".$cod_contato."");
			} else {
				print "Tabela contato não encontrada.";
			}
	}else { 
		$msg_warning = "Essa operação não pode ser editada.";
		header ("Location: ?msg_warning=".$msg_warning."&cod_contato=".$cod_contato."");
	}	
} 

$str_contato = "SELECT * FROM contato WHERE cod_contato=".$cod_contato."";
$rs = $conn -> prepare($str_contato) or die ("Erro na string SELECT 3.");

if ($rs -> execute()){
	$row = $rs -> fetch(PDO::FETCH_OBJ);

	$endereco = $row -> endereco;
	$telefone = $row -> telefone;
	$email = $row -> email;
}

if (isset($_POST["enviar"])){
	if (isset ($_POST["endereco"])){
		$endereco = trim($_POST["endereco"]);
	}
	if (isset ($_POST["telefone"])){
		$telefone = trim($_POST["telefone"]);
	}
	if (isset ($_POST["email"])){
		$email = trim($_POST["email"]);
	}
		
	if (!empty($endereco) && !empty($telefone) && !empty($email)){
		
		$str_contato = "UPDATE contato SET endereco= ?, telefone= ?, email= ? WHERE cod_contato = ?";
		$rs = $conn -> prepare($str_contato) or die("ERRO NA STRING SQL UPDATE 1.");
		$rs -> bindParam(1, $endereco);
		$rs -> bindParam(2, $telefone);
		$rs -> bindParam(3, $email);
		$rs -> bindParam(4, $cod_contato);
		
		 if ($rs -> execute()) {
			 $msg = "Contato alterado com sucesso.";
			 header("Location: config_ferramentas.php?msg=".$msg."");
		 } else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			 header("Location: edit_contato.php?msg_warning=".$msg_warning."&cod_contato=".$cod_contato."");
		 }
		
	} else {
		print "<strong>Existe campos vazios no formulário.</strong>";
	}
}	

require "index.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
                <div class="form-group">
                  <select class="form-control" id="operacao" name="operacao">
                  	<option value="3" selected="selected">Contato</option>
                    <option value="3">Contato</option>
                  	<option value="1">Menu Principal</option>
                    <option value="2">Quem Somos</option>
                  </select>
                </div>
          </div> 
          
        <button type="submit" class="btn btn-success btn-default" id="pesquisar" name="pesquisar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        </button>
    
        <button type="submit" class="btn btn-default" id="editar" name="editar">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar
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
        <div class="col-xs-9">
            <input type="text" class="form-control" required value="<?php print $endereco;?>" id="endereco" name="endereco">
        </div>
      </div>
      
      <br />
      
      <div class="row">
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $email;?>" id="email" name="email">
        </div>
        <div class="col-xs-4">
            <input type="text" class="form-control" onkeypress="mascara(this);" maxlength="14" required value="<?php print $telefone;?>" id="telefone" name="telefone">
        </div>
      </div>
      
              <br />          
              <br />
                            
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
               	<button type="button" onClick='javascript:location.href="config_ferramentas.php"' class="btn btn-default">
        		<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar
     			</button>
              
              </fieldset>
            </form>
</div>
<div style="clear:both;"></div>
<!-- End .container_12 --> 

<?php 
$conn = NULL;
require "rodape.php"; ?>