<?php 
require_once "conexao_pdo_cliente.php";

if (isset($_GET["cod_produto"])){
	$cod_produto = trim($_GET["cod_produto"]);
} 

if (isset($_POST['cadastrar'])){ 
		header ("Location: cad_produto_pedido.php");
}

if (isset($_POST['listar'])){ 
		header ("Location: list_produto_pedido.php");
}

if (isset($_POST["enviar"])){
	if (isset ($_POST["descricao"])){
		$descricao = trim($_POST["descricao"]);
	}
	if (isset ($_POST["preco"])){
		$preco = trim($_POST["preco"]);
	}
	if (isset ($_POST["status"])){
		$status = trim($_POST["status"]);
	}
	if (isset ($_POST["tipo_venda"])){
		$tipo_venda = trim($_POST["tipo_venda"]);
	}
	
		
	if (!empty($descricao) && !empty($preco) && !empty($status) && !empty($tipo_venda)){

			$str_produto = "UPDATE produto SET descricao= ?, preco= ?, status= ?, tipo_venda= ? WHERE cod_produto= ?";
			$rs = $conn_pedido -> prepare($str_produto) or die("ERRO NA STRING SQL UPDATE 1.");
			$rs -> bindParam(1, $descricao);
			$rs -> bindParam(2, $preco);
			$rs -> bindParam(3, $status);
			$rs -> bindParam(4, $tipo_venda);
			$rs -> bindParam(5, $cod_produto);		
		
		 if ($rs -> execute()) {
			 $msg = "Produto alterado com sucesso.";
			 header("Location: list_produto_pedido.php?msg=".$msg."");
		 } else {
			$msg_warning = "<strong>Nenhuma informação pôde ser alterada.</strong>";
			 header("Location: edit_produto_pedido.php?msg_warning=".$msg_warning."&cod_produto=".$cod_produto."");
		 }
		
	} else {
		print "<strong>Existe campos vazios no formulário.</strong>";
	}
} else {
	$str_produto = "SELECT * FROM produto WHERE cod_produto=".$cod_produto."";
	$rs = $conn_pedido -> prepare($str_produto) or die ("Erro na string SELECT 3.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
	
		$descricao = $row -> descricao;
		$preco = $row -> preco;
		$status = $row -> status;
		$tipo_venda = $row -> tipo_venda;
	}
}

require "index_adm_pedido.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
               <input value="Produtos em Estoque" class="form-control" readonly="readonly" />
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
          <h2><span>EDIÇÃO - PRODUTO</span></h2>
          <div class="module-body">
         	
    <form name="form1" method="post" action=""> 
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" value="<?php print $descricao;?>" id="descricao" name="descricao">
            </div>
          <div class="col-xs-4">
              <input type="text" class="form-control" value="<?php print $preco;?>" placeholder="Preço" id="preco" name="preco">
          </div>
        </div>    
        <br />
        
        <div class="row">             
        	<div class="col-xs-4">
                <div class="form-group">
                  <select class="form-control" id="tipo_venda" name="tipo_venda">
                  <?php if ($tipo_venda == "KG"){?>
                  	<option value="KG" selected="selected">Venda: KG</option>
                    <option value="KG">Venda: KG</option>
                  	<option value="Unidade">Venda: Unidade</option>
                  <?php } else {?>
                  	<option value="Unidade" selected="selected">Venda: Unidade</option>
                    <option value="Unidade">Venda: Unidade</option>
                  	<option value="KG">Venda: KG</option>
                  <?php }?>
                  </select>
                </div>
           </div>
          <div class="col-xs-4">
          <div class="form-group">
                  <select class="form-control" id="status" name="status">
                  <?php if ($status == "Disponível"){?>
                  	<option value="Disponível" selected="selected">Disponível</option>
                    <option value="Disponível">Disponível</option>
                  	<option value="Indisponível">Indisponível</option>
                    <option value="Em Breve">Em Breve</option>
                  <?php } else if ($status == "Indisponível"){?>
                  	<option value="Indisponível" selected>Indisponível</option>
                    <option value="Indisponível">Indisponível</option>
                  	<option value="Disponível">Disponível</option>
                    <option value="Em Breve">Em Breve</option>
                  <?php } else {?>
                  	<option value="Em Breve" selected>Em Breve</option>
                    <option value="Em Breve">Em Breve</option>
                    <option value="Indisponível">Indisponível</option>
                  	<option value="Disponível">Disponível</option>
                  <?php }?>
                  </select>
                </div>
          </div>
        </div>          
             
        <br />        
        <br />
        <br />
        <br />
                            
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
               	<button type="button" onClick='javascript:location.href="list_produto_pedido.php"' class="btn btn-default">
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