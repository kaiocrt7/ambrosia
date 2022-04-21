<?php 
require_once "conexao_pdo.php";	

if (isset($_GET["cod_menu"])){
	$cod_menu = trim($_GET["cod_menu"]);
}

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_menu_principal.php");
	}else { 
		$msg_warning = "Essa operação não pode ser pesquisada.";
		header ("Location: ?msg_warning=".$msg_warning."&cod_menu=".$cod_menu."");
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
			$rs = $conn -> prepare("SELECT * FROM contato") or die ("Erro na string SELECT 2.");
			if ($rs -> execute ()){
				$row = $rs -> fetch(PDO::FETCH_OBJ);
				$cod_contato = $row -> cod_contato;
				
				header ("Location: edit_contato.php?cod_contato=".$cod_contato."");
			} else {
				print "Tabela contato não encontrada.";
			}
	}else { 
		$msg_warning = "Essa operação não pode ser editada.";
		header ("Location: ?msg_warning=".$msg_warning."&cod_menu=".$cod_menu."");
	}	
} 

$str_menu = "SELECT * FROM menu_principal WHERE cod_menu=".$cod_menu."";
$rs = $conn -> prepare($str_menu) or die ("Erro na string SELECT 3.");

if ($rs -> execute()){
	$row = $rs -> fetch(PDO::FETCH_OBJ);

	$descricao = $row -> descricao;
	$status = $row -> status;
	$pagina = $row -> pagina;
}

if (isset($_POST["enviar"])){
	if (isset ($_POST["descricao"])){
		$descricao = trim($_POST["descricao"]);
	}
	if (isset ($_POST["status"])){
		$status = trim($_POST["status"]);
	}
	if (isset ($_POST["pagina"])){
		$pagina = trim($_POST["pagina"]);
	}
		
	if (!empty($descricao) && !empty($status) && !empty($pagina)){
		
		$str_menu = "UPDATE menu_principal SET descricao= ?, status= ?, pagina= ? WHERE cod_menu= ?";
		$rs = $conn -> prepare($str_menu) or die ("Erro na string UPDATE 1.");
		$rs -> bindParam(1, $descricao);
		$rs -> bindParam(2, $status);
		$rs -> bindParam(3, $pagina);
		$rs -> bindParam(4, $cod_menu);
		
		 if ($rs -> execute()) {
			 $msg = "Menu principal alterado com sucesso.";
			 header("Location: list_menu_principal.php?msg=".$msg."");
		 } else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			header ("Location: edit_menu_principal.php?msg_warning=".$msg_warning."&cod_menu=".$cod_menu."");
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
                  	<option value="1" selected="selected">Menu Principal</option>
                  	<option value="1">Menu Principal</option>
                    <option value="2">Quem Somos</option>
                    <option value="3">Contato</option>
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
          <h2><span>EDIÇÃO - MENU PRINCIPAL</span></h2>
          <div class="module-body">
         	
    <form name="form1" method="post" action="">
       <div class="row">             
            <div class="col-xs-8">
                <div class="form-group">
                  <select class="form-control" id="status" name="status">
                  <?php if($status == "Ativo") {?>
                    <option value="Ativo" selected="selected">Ativo</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                  <?php }?>
                  <?php if($status == "Inativo") {?>
                    <option value="Inativo" selected="selected">Inativo</option>
                    <option value="Inativo" selected="selected">Inativo</option>
                    <option value="Ativo">Ativo</option>
                  <?php }?>
                  </select>
                </div>
            </div>
      </div>
            
       <br />  
                 
      <div class="row">
        <div class="col-xs-4">
                  <input type="text" class="form-control" required value="<?php print $descricao;?>" id="descricao" name="descricao">
                </div>
        <div class="col-xs-4">
                  <input type="text" class="form-control" required id="pagina" name="pagina" value="<?php print $pagina;?>">
        </div>
      </div>
      
              <br />          
              <br />
                            
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
                <button type="button" onClick='javascript:location.href="list_menu_principal.php"' class="btn btn-default">
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