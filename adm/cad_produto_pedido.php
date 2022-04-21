<?php
require_once "conexao_pdo_cliente.php";

if (isset($_POST['listar'])){ 
		header ("Location: list_produto_pedido.php");
}


if (isset ($_POST['enviar'])) {
	$descricao = trim($_POST['descricao']);
	$tipo_venda = trim($_POST['tipo_venda']);
	$preco = trim($_POST['preco']);
	$status = trim($_POST['status']);
	$tipo_venda = trim($_POST['tipo_venda']);
	
	$total = 0;
	$rs_verifica = $conn_pedido -> prepare ("SELECT * FROM produto WHERE descricao='".$descricao."'") or die ("Erro na String SELECT 1.");
	$rs_verifica -> execute();
	$total = $rs_verifica -> rowCount();
	
	if ($total > 0){
		$msg_warning = "<strong>Este produto já existe na base de dados.</strong>";
		header ("Location: ?msg_warning=".$msg_warning."");
	}else {
				
		$str_produto = "INSERT INTO produto (descricao, tipo_venda, preco, status) VALUES (?, ?, ?, ?)";		
			
		$rs = $conn_pedido -> prepare ($str_produto) or die ("Erro ao preparar a string.");
		$rs -> bindParam (1, $descricao);
		$rs -> bindParam (2, $tipo_venda);
		$rs -> bindParam (3, $preco);
		$rs -> bindParam (4, $status);
			
			if ($rs -> execute()){
				$msg = "<strong>Produto cadastrado para venda com sucesso.</strong>";
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
               <input value="Produtos em Estoque" class="form-control" readonly="readonly" />
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
           <h2><span>CADASTRAR - PRODUTOS</span></h2>                    
          <div class="module-body">
    <form action="" name="form1" method="post">
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Descrição do Produto" id="descricao" name="descricao">
            </div>
          <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Preço" id="preco" name="preco">
          </div>
        </div>    
        <br />
        
        <div class="row">             
        	<div class="col-xs-4">
                <div class="form-group">
                  <select class="form-control" id="tipo_venda" name="tipo_venda">
                  	<option value="KG" selected="selected">Venda: KG</option>
                    <option value="KG">Venda: KG</option>
                  	<option value="Unidade">Venda: Unidade</option>
                  </select>
                </div>
           </div>
          <div class="col-xs-4">
          <div class="form-group">
                  <select class="form-control" id="status" name="status">
                  	<option value="Disponível" selected="selected">Disponível</option>
                    <option value="Disponível">Disponível</option>
                  	<option value="Indisponível">Indisponível</option>
                    <option value="Em Breve">Em Breve</option>
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
