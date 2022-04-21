<?php
require "conexao_pdo.php";	

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_menu_principal.php");
	}else { 
		$msg_warning = "Essa operação não pode ser pesquisada.";
		header ("Location: ?msg_warning=".$msg_warning."");
	}	
} 

if (isset($_POST['editar']) && !empty($operacao)){ 
		if ($operacao == 2){
			$rs = $conn -> prepare ("SELECT * FROM quem_somos") or die ("Erro na string SELECT.");
			if ($rs -> execute()){
				$row = $rs -> fetch(PDO::FETCH_OBJ);
				$cod_texto = $row -> cod_texto;
				
				header ("Location: edit_quem_somos.php?cod_texto=".$cod_texto."");
			} else {
				print "Tabela quem somos não encontrada.";
			}
	}else if ($operacao == 3){
			$rs = $conn -> prepare ("SELECT * FROM contato") or die ("Erro na string SELECT.");
			  if ($row = $rs -> execute()){
				$row = $rs -> fetch(PDO::FETCH_OBJ);
				$cod_contato = $row -> cod_contato;
				
				header ("Location: edit_contato.php?cod_contato=".$cod_contato."");
			} else {
				print "Tabela quem somos não encontrada.";
			}
	}else { 
		$msg_warning = "Essa operação não pode ser editada.";
		header ("Location: ?msg_warning=".$msg_warning."");
	}	
} 

include "index.php";
?>

<br />
<div class="module">
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
          
        <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        </button>
    
        <button type="submit" class="btn btn-success btn-default" id="editar" name="editar">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar
        </button>
            
     	</div> 
        </form>

<?php
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<strong><span class=\"notification n-success\">".$msg."</span></strong>";
} 
if (isset($_GET['msg_warning'])){
	$msg_warning = $_GET['msg_warning'];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
} 
?>
</div>
<div style="clear:both;"></div>

<!-- End .container_12 --> 

<?php 
$conn = NULL;
require "rodape.php"; ?>




