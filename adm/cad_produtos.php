<?php
require_once "conexao_pdo.php";

if (isset($_GET["produto"])){
	$tipo_produto = $_GET["produto"];
} else {
	print "<strong>Você esta tentando realizar uma tarefa não definida no sistema.</strong>";
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
	if ($operacao == 1){
		header ("Location: cad_img_topo.php");
	}else if ($operacao == 2){
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
	$desc_produto = trim($_POST['desc_produto']);
	$preco_produto = trim($_POST['preco_produto']);
	$status = trim($_POST['status']);
	$msg_error = "OK";
	
	if ($_FILES["img"]["tmp_name"] != ""){
		if ($_FILES["img"]["size"] > 1048576){
			$msg_error = "<strong>O tamanho da imagem ultrapassa o limite de 1MG.</strong>";
		} else if (!preg_match("/^image\/(jpeg|png)$/", $_FILES["img"]["type"])){
			$msg_error = "<strong>A imagem a ser enviada deve conter os formatos: .jpg ou .png.</strong>";
		} else {
			$caminho = "../images/".$tipo_produto;
			$nome_arquivo = $_FILES["img"]["name"];
			$nome_arquivo = md5(microtime()).$nome_arquivo;
			
			if(move_uploaded_file($_FILES["img"]["tmp_name"], $caminho ."/". $nome_arquivo)){
				$nome_arquivo = $caminho ."/". $nome_arquivo;	
				$str_produtos = "INSERT INTO ".$tipo_produto." (nome_produto, desc_produto, preco_produto, status, img_produto) VALUES ('".$nome_produto."', '".$desc_produto."', '".$preco_produto."', '".$status."', '".$nome_arquivo."')";

			}
		}
	} 
		
	if ($msg_error == "OK"){
		$rs = $conn -> prepare ($str_produtos) or die ("Erro na preparação da string.");
		$rs -> bindParam (1, $nome_produto);
		$rs -> bindParam (2, $desc_produto);
		$rs -> bindParam (3, $preco_produto);
		$rs -> bindParam (4, $status);
		$rs -> bindParam (5, $nome_arquivo);
		
		if ($rs -> execute()){
			$msg = "<strong>Informação cadastrada com sucesso</strong>.";
			header ("Location: cad_produtos.php?msg=".$msg."&produto=".$tipo_produto."");
		} else {
			$msg_warning = "<strong>As informações não pode ser cadastrada.</strong>";
			header ("Location: cad_produtos.php?msg_warning=".$msg_warning."&produto=".$tipo_produto."");
		}
	} else {
		header ("Location: cad_produtos.php?msg_error=".$msg_error."&produto=".$tipo_produto."");
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
                  <?php if ($tipo_produto == "img_produtos_industrializados"){?>
                  	<option value="3" selected="selected">Produtos Industrializados</option>
                    <option value="3">Produtos Industrializados</option>
                    <option value="4">Produtos Processados</option>
                  	<option value="1">Imagem Topo</option>
                    <option value="2">Informações de Produtos</option>
                  <?php } else {?>
                  <option value="4" selected="selected">Produtos Processados</option>
                    <option value="4">Produtos Processados</option>
                    <option value="3">Produtos Industrializados</option>
                  	<option value="1">Imagem Topo</option>
                    <option value="2">Informações de Produtos</option>
                  <?php }?>
                  </select>
                </div>
          </div> 
        
        	<button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
            </button>
            
            
            <button type="submit" class="btn btn-success btn-default" id="cadastrar" name="cadastrar">
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
if (isset($_GET["msg"])){
	$msg = $_GET["msg"];
	print "<span class=\"notification n-success\">".$msg."</span>";
}
?>

<div class="module">
		<?php if ($tipo_produto == "img_produtos_industrializados"){?>
          <h2><span>CADASTRAR - PRODUTOS INDUSTRIALIZADOS</span></h2> 
        <?php } else {?>      
           <h2><span>CADASTRAR - PRODUTOS PROCESSADOS</span></h2> 
         <?php }?>
          <div class="module-body">
    <form action="" enctype="multipart/form-data" name="form1" method="post">
    <div class="row">
    	<div class="col-xs-4">
        	<label>Selecione uma imagem:</label>
        </div>             
        <div class="col-xs-4">
        	<input name="img" id="img" type="file" />
        </div>
    </div>
    <br />
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Nome do Produto" id="nome_produto" name="nome_produto">
            </div>
            
            <div class="col-xs-4">
            <div class="form-group">
              <select class="form-control" id="status" name="status">
                <option value="Normal" selected="selected">Normal</option>
                <option value="Normal">Normal</option>
                <option value="Destaque">Destaque</option>
              </select>
            </div>
        </div>
        </div>
          <br /> 
          
        <div class="row">
            <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Descricão do Produto" id="desc_produto" name="desc_produto" >
            </div>
            <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Preço do Produto" id="preco_produto" name="preco_produto" >
            </div>
        </div>         
             
        <br />
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
