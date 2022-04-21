<?php
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

include "index.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
                <div class="form-group">
                  <select class="form-control" id="operacao" name="operacao">
                  	<option value="3" selected="selected">Produtos Industrializados</option>
                    <option value="3">Produtos Industrializados</option>
                    <option value="4">Produtos Processados</option>
                  	<option value="1">Imagem Topo</option>
                    <option value="2">Informações de Produtos</option>
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
if (isset($_GET["msg_warning"])){
	$msg_warning = $_GET["msg_warning"];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
}
require "rodape.php"; ?>




