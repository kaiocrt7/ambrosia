<?php
require_once "conexao_pdo.php";

if (isset($_GET['cod_banner_topo'])){
	$cod_banner_topo = $_GET['cod_banner_topo'];
} 

if (isset($_POST['listar'])){ 
		header ("Location: list_banner_topo.php");
}	
if (isset($_POST['cadastrar'])){ 
		header ("Location: cad_banner_topo.php");		
}

// Se o botão enviar for clicado
if (isset ($_POST['enviar'])) {
	$titulo = trim($_POST['titulo']);
	$sub_titulo = trim($_POST['sub_titulo']);
	$status = trim($_POST['status']);
	$tema = trim($_POST['tema']);
	$msg_error = "OK";
	
	if ($_FILES["banner"]["tmp_name"] != ""){
		if ($_FILES["banner"]["size"] > 1048576){
			$msg_error = "<strong>O tamanho da imagem ultrapassa o limite de 1MG.</strong>";
		} else if (!preg_match("/^image\/(jpeg|png)$/", $_FILES["banner"]["type"])){
			$msg_error = "<strong>A imagem a ser enviada deve conter os formatos: .jpg ou .png.</strong>";
		} else {
			$caminho = "../images/banner_topo";
			$nome_arquivo = $_FILES["banner"]["name"];
			$nome_arquivo = md5(microtime()).$nome_arquivo;
			
			if(move_uploaded_file($_FILES["banner"]["tmp_name"], $caminho ."/". $nome_arquivo)){
					$nome_arquivo = $caminho ."/". $nome_arquivo;	
					$str_banner1 = "UPDATE banner_topo SET titulo= ?, sub_titulo= ?, status= ?, img_banner_topo= ?, tema= ? WHERE cod_banner_topo= ?";
			}
		}
	} else {
		$str_banner2 = "UPDATE banner_topo SET titulo= ?, sub_titulo= ?, status= ?, tema= ? WHERE cod_banner_topo= ?";		
	}
	
	if ($msg_error == "OK"){
		if(!empty($str_banner1)){
			$rs = $conn -> prepare($str_banner1) or die("Erro na string UPDATE 1.");
			$rs -> bindParam(1, $titulo);
			$rs -> bindParam(2, $sub_titulo);
			$rs -> bindParam(3, $status);
			$rs -> bindParam(4, $nome_arquivo);
			$rs -> bindParam(5, $tema);
			$rs -> bindParam(6, $cod_banner_topo);			
		}else {
			$rs = $conn -> prepare($str_banner2) or die("Erro na string UPDATE 1.");
			$rs -> bindParam(1, $titulo);
			$rs -> bindParam(2, $sub_titulo);
			$rs -> bindParam(3, $status);
			$rs -> bindParam(4, $tema);
			$rs -> bindParam(5, $cod_banner_topo);	
		}
		
		if ($rs -> execute()){
			$msg = "Banner alterado com <strong>sucesso</strong>.";
			header ("Location: list_banner_topo.php?msg=".$msg."");
		} else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			header ("Location: edit_banner_topo.php?msg_warning=".$msg_warning."&cod_banner_topo=".$cod_banner_topo."");
		}
	} else {
		header ("Location: edit_banner_topo.php?msg_error=".$msg_error."&cod_banner_topo=".$cod_banner_topo."");
	}

} else { 
	$str_banner_topo = "SELECT * FROM banner_topo WHERE cod_banner_topo=".$cod_banner_topo."";
	$rs = $conn -> prepare($str_banner_topo) or die ("Erro na string SELECT 1.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
		$titulo = $row -> titulo;
		$sub_titulo = $row -> sub_titulo;
		$tema = $row -> tema;	
		$status = $row -> status;	
		$img_banner_topo = $row->img_banner_topo;	
	}
}

require "index.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
               <input value="Banner Topo" class="form-control" readonly="readonly" />
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
if (isset($_GET["msg_error"])){
	$msg_error = $_GET["msg_error"];
	print "<span class=\"notification n-error\">".$msg_error."</span>";
} 
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
          <h2><span>ALTERAR BANNER TOPO</span></h2>          
          <div class="module-body">
    <form action="" enctype="multipart/form-data" name="form1" method="post">
    <input name="banner" required="required" id="banner" type="file" />
    <br />
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
            <div class="col-xs-8">
              <input type="text" value="<?php print $titulo;?>" class="form-control" id="titulo" name="titulo">
            </div>
        </div>
          <br /> 
          
        <div class="row">
            <div class="col-xs-8">
              <input type="text" class="form-control"  id="sub_titulo" value="<?php print $sub_titulo;?>" name="sub_titulo" >
            </div>
        </div>  
        
        <br />
        <div class="row">
            <div class="col-xs-8">
              <input type="text" class="form-control" id="tema" value="<?php print $tema;?>" name="tema" >
            </div>
        </div>        
             
        <br />
        
        <img width="900" height="400" src="<?php print $img_banner_topo;?>"/>
        <br />
        <br />
        <br />
              
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
                <button type="button" onClick='javascript:location.href="config_banner.php"' class="btn btn-default">
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