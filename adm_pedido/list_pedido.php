<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}
if (isset($_GET['cod_pedido'])){
	$cod_pedido = $_GET['cod_pedido'];
}
if (isset($_GET['data'])){
	$data = $_GET['data'];
}

if(!empty($cod_pedido)){
		$str_item_pedido = "SELECT pedido.cod_pedido as pedido, descricao, preco, valor_total, quantidade, preco_total, data FROM produto, pedido, item_pedido, cliente WHERE pedido.cod_cliente = cliente.cod_cliente AND item_pedido.cod_pedido = pedido.cod_pedido AND item_pedido.cod_produto = produto.cod_produto AND pedido.cod_pedido=".$cod_pedido."";
		$rs_item_pedido = $conn_pedido -> prepare($str_item_pedido) or die ("Errro na string SELECT 2.");	
} 

require "index.php";
?>
<br />

<div class="module">
<form action="pedido.php" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-2">
            <input type="date" maxlength="20" id="data" name="data" class="form-control" />
          </div> 
          
         <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pedidos
        </button>
        
        <button type="submit" class="btn btn-success btn-default" id="continuar" name="continuar">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Continuar
        </button>
        </div>
                
</form>
<?php 
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\">".$msg."</span>";
} else if (isset($_GET['msg_attention'])){
	$msg_attention = $_GET['msg_attention'];
	print "<span class=\"notification n-attention\">".$msg_attention."</span>";
}	
if($rs_item_pedido -> execute()){
	$row = $rs_item_pedido -> fetch(PDO::FETCH_OBJ);
	print "<strong>Código do Pedido: ".$row -> pedido."</strong><br />";
	print "<strong>Data de Entrega: ".$data."</strong><br />";
	print "<strong>Valor da Nota: R$ ".$row -> valor_total."</strong><br />";
}
?>
	
  <h2><span>INFORMAÇÕES DO PEDIDO</span></h2>       
                    
                <table class="tablesorter">
                    <thead>
                    <tr>
                      <th>Produto</th>
                      <th>Preço</th>
                      <th>Quantidade</th>
                      <th>Valor Total dos Produtos</th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                      <th>Produto</th>
                      <th>Preço</th>
                      <th>Quantidade</th>
                      <th>Valor Total dos Produtos</th>
                    </tr>
                    <tr>
                      <th colspan="8" class="ts-pager form-horizontal"> <button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
                    <span class="pagedisplay"></span>
                    <button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
                    <button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
                    <select class="pagesize input-mini" title="Select page size">
                          <option selected="selected" value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                        </select>
                    </th>
                    </tr>
                </tfoot>
                <tbody>
                    	<tr>
                 <?php 
				 if($rs_item_pedido -> execute()){
					 while($row = $rs_item_pedido -> fetch(PDO::FETCH_OBJ)){
								$produto = $row -> descricao; 
								$preco = $row -> preco;
								$quantidade = $row -> quantidade;
								$preco_total = $row -> preco_total;
								$aux = explode ("-", $data);
								$data = implode("/", array_reverse($aux)); 
								?>
								<tr>
                                <td><?php print $produto;?></td>
                                <td>R$ <?php print $preco;?></td>
                                <td><?php print $quantidade;?></td>
                                <td>R$ <?php print $preco_total;?></td>
                                </tr>
							 
					<?php 
					 }
				 }?>      
             </tbody>
	</table>
</div>
<div style="clear:both;"></div>        
       
<!-- End .container_12 --> 

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>