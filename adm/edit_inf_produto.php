<?php
require "conexao_pdo.php";

if (isset($_GET['cod_inf_produto'])){
	$cod_inf_produto = $_GET['cod_inf_produto'];
} 

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_img_topo.php");
	}else if ($operacao == 2){
		header ("Location: list_img_inf_produto.php");
	}else if ($operacao == 3){
		header ("Location: list_produtos.php?produto=img_produtos_industrializados");
	} else if($operacao == 4){
		header ("Location: list_produtos.php?produto=img_produtos_processados");
	}else { 
		print "<span class=\"notification n-attention\">A pesquisa não retornou nenhum registro.</span>";
	}	
} elseif (isset($_POST["cadastrar"]) && !empty($operacao)){
	if ($operacao == 2){
		header ("Location: cad_inf_produtos.php");
	}else if ($operacao == 3){
		header ("Location: cad_produtos.php?produto=img_produtos_industrializados");
	} else if($operacao == 4){
		header ("Location: cad_produtos.php?produto=img_produtos_processados");
	}else { 
		$msg_warning = "Não é possível cadastrar imagem desse tipo.";
		header ("Location: config_imagens.php?msg_warning=".$msg_warning."");
	}	
}

// Se o botão enviar for clicado
if (isset ($_POST['enviar'])) {
	$nome_produto = trim($_POST['nome_produto']);
	$inf_produto = trim($_POST['inf_produto']);
	$msg_error = "OK";
	
	if ($_FILES["img"]["tmp_name"] != ""){
		if ($_FILES["img"]["size"] > 1048576){
			$msg_error = "<strong>O tamanho da imagem ultrapassa o limite de 1MG.</strong>";
		} else if (!preg_match("/^image\/(jpeg|png)$/", $_FILES["img"]["type"])){
			$msg_error = "<strong>A imagem a ser enviada deve conter os formatos: .jpg ou .png.</strong>";
		} else {
			$caminho = "../images/img_inf_produto";
			$nome_arquivo = $_FILES["img"]["name"];
			$nome_arquivo = md5(microtime()).$nome_arquivo;
			
			if(move_uploaded_file($_FILES["img"]["tmp_name"], $caminho ."/". $nome_arquivo)){
					$nome_arquivo = $caminho ."/". $nome_arquivo;	
					$str_inf_produto1 = "UPDATE img_inf_produto SET nome_produto= ?, inf_produto=?, img_inf_produto=? WHERE cod_inf_produto= ?";
			}
		}
	} else {
		$str_inf_produto2 = "UPDATE img_inf_produto SET nome_produto= ?, inf_produto= ? WHERE cod_inf_produto= ?";		
	}
	
	if ($msg_error == "OK"){
		if ($str_inf_produto1){
			$rs = $conn -> prepare ($str_inf_produto1) or die ("Erro na preparacao da string.");
			$rs -> bindParam (1, $nome_produto);
			$rs -> bindParam (2, $inf_produto);
			$rs -> bindParam (3, $nome_arquivo);	
			$rs -> bindParam (4, $cod_inf_produto);			
		}else {
			$rs = $conn -> prepare ($str_inf_produto2) or die ("Erro na preparacao da string.");
			$rs -> bindParam (1, $nome_produto);
			$rs -> bindParam (2, $inf_produto);
			$rs -> bindParam (3, $cod_inf_produto);
		}
		
		if ($rs -> execute()){
			$msg = "<strong>Dados alterados com sucesso</strong>.";
			header ("Location: list_img_inf_produto.php?msg=".$msg."");
		} else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			header ("Location: edit_inf_produto.php?msg_warning=".$msg_warning."&cod_inf_produto=".$cod_inf_produto."");
		}
	} else {
		header ("Location: edit_inf_produto.php?msg_error=".$msg_error."&cod_inf_produto=".$cod_inf_produto."");
	}

} else { 
	$rs = $conn -> prepare ("SELECT * FROM img_inf_produto WHERE cod_inf_produto=".$cod_inf_produto."") or die ("Erro na string SELECT.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
		$nome_produto = $row -> nome_produto;
		$inf_produto = $row -> inf_produto;	
		$img_inf_produto = $row -> img_inf_produto;	
	}
}

require "index.php";
?>

<br />
<form action="" name="form1" enctype="multipart/form-data" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
                <div class="form-group">
                  <select class="form-control" id="operacao" name="operacao">
                  	<option value="2" selected>Informações de Produtos</option> 
                    <option value="2">Informações de Produtos</option> 
                    <option value="3">Produtos Industrializados</option>
                    <option value="4">Produtos Processados</option> 
                    <option value="1">Imagem Topo</option>
                  </select>
                </div>
          </div> 
        
        <button type="submit" class="btn btn-success btn-default" id="pesquisar" name="pesquisar">
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
if (isset($_GET["msg_warning"])){
	$msg_warning = $_GET["msg_warning"];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
}
?>

<div class="module">
          <h2><span>ALTERAR - INFORMAÇÕES DE PRODUTOS</span></h2>          
          <div class="module-body">
    <form action="" enctype="multipart/form-data" name="form1" method="post">
    <div class="row">
            <div class="col-xs-4">
              <label>Selecione a imagem:</label>
            </div>
            <input name="img" id="img" type="file" />
        </div>
    <br />
              
        <div class="row">
            <div class="col-xs-8">
              <input type="text" value="<?php print $nome_produto;?>" class="form-control" required id="nome_produto" name="nome_produto">
            </div>
        </div>
        <br /> 
          
        <div class="row">
        <div class="form-group">
          <div class="col-xs-6"><br />
            <textarea class="form-control" rows="7" id="inf_produto" name="inf_produto"><?php print $inf_produto;?></textarea>
          </div>
       	</div>
        <img width="170" height="160" src="<?php print $img_inf_produto;?>"/>
      	</div>        
             
        <br />
        <br />
        <br />
              
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
                <button type="button" onClick='javascript:location.href="config_imagens.php"' class="btn btn-default">
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