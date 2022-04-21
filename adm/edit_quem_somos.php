<?php 
require_once "conexao_pdo.php";	

if (isset($_GET["cod_texto"])){
	$cod_texto = trim($_GET["cod_texto"]);
}

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_menu_principal.php");
	}else { 
		$msg_warning = "Essa operação não pode ser pesquisada.";
		header ("Location: ?msg_warning=".$msg_warning."&cod_texto=".$cod_texto."");
	}	
} 

if (isset($_POST['editar']) && !empty($operacao)){ 
	if ($operacao == 2){
		$rs = $conn -> prepare ("SELECT * FROM quem_somos") or die ("Erro na string SELECT 1.");
		if ($rs -> execute()){
			$row = $rs -> fetch(PDO::FETCH_OBJ);
			$cod_texto = $row -> cod_texto;
			
			header ("Location: edit_quem_somos.php?cod_texto=".$cod_texto."");
		} else {
			print "Tabela 'quem somos' não encontrada.";
		}
	} else if ($operacao == 3){
		$rs = $conn -> prepare ("SELECT * FROM contato") or die ("Erro na string SELECT 2.");
		if ($rs -> execute()){
			$row = $rs -> fetch(PDO::FETCH_OBJ);
			$cod_contato = $row -> cod_contato;
			
			header ("Location: edit_contato.php?cod_contato=".$cod_contato."");
		} else {
			print "Tabela 'contato' não encontrada.";
		}
	} else { 
	$msg_warning = "Essa operação não pode ser editada.";
	header ("Location: ?msg_warning=".$msg_warning."&cod_texto=".$cod_texto."");
	}	
} 

$str_quem_somos = "SELECT * FROM quem_somos WHERE cod_texto=".$cod_texto."";
$rs = $conn -> prepare ($str_quem_somos) or die ("Erro na string SELECT 3.");

if ($rs -> execute()){
	$row = $rs -> fetch(PDO::FETCH_OBJ);

	$descricao = $row -> descricao;
	$titulo = $row -> titulo;
}

if (isset($_POST["enviar"])){
	if (isset ($_POST["descricao"])){
		$descricao = trim($_POST["descricao"]);
	}
	if (isset ($_POST["titulo"])){
		$titulo = trim($_POST["titulo"]);
	}
		
	if (!empty($descricao) && !empty($titulo)){
		
		$str_quem_somos = "UPDATE quem_somos SET descricao='".$descricao."', titulo='".$titulo."' WHERE cod_texto=".$cod_texto."";
		$rs = $conn -> prepare($str_quem_somos) or print("ERRO NA STRING SQL.");
		$rs -> bindParam(1, $descricao);
		$rs -> bindParam(2, $titulo);
		$rs -> bindParam(3, $cod_texto);
		
		 if ($rs -> execute()) {
			 $msg = "Quem Somos alterado com sucesso.";
			 header("Location: config_ferramentas.php?msg=".$msg."");
		 } else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			header("Location: edit_quem_somos.php?msg_warning=".$msg_warning."&cod_texto=".$cod_texto."");
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
                    <option value="2"selected="selected">Quem Somos</option>
                    <option value="2">Quem Somos</option>
                  	<option value="1">Menu Principal</option>
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
          <h2><span>EDIÇÃO - QUEM SOMOS</span></h2>
          <div class="module-body">
         	
    <form name="form1" method="post" action=""> 
                 
      <div class="row">
        <div class="col-xs-4">
            <input type="text" class="form-control" required value="<?php print $titulo;?>" id="titulo" name="titulo">
        </div>
      </div>
      <br />
      
      <div class="row">
        <div class="form-group">
          <div class="col-xs-8">
            <textarea class="form-control" rows="5" id="descricao" name="descricao"><?php print $descricao;?></textarea>
          </div>
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