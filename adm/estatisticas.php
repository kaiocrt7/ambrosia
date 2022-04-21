<?php
require_once "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}


$str_produtos = "SELECT SUM(item_pedido.quantidade) AS qtde, produto.descricao 
				FROM item_pedido, produto WHERE item_pedido.cod_produto = produto.cod_produto
				GROUP BY (item_pedido.cod_produto)";
$rs_produtos = $conn_pedido -> prepare ($str_produtos) or die ("Erro na String SELECT 1.");	

$str_clientes = "SELECT SUM(pedido.valor_total) AS valor_total, cliente.empresa
				FROM pedido, cliente WHERE pedido.cod_cliente = cliente.cod_cliente
				GROUP BY (pedido.cod_cliente)";	
$rs_clientes = $conn_pedido -> prepare ($str_clientes) or die ("Erro na string SELECT 2.");	



$conn_pedido = NULL;
require "index_adm_pedido.php";
?>
<br />

<div class="module">

    
<?php 
if($rs_produtos -> execute()){
	print "<strong>Produtos mais Vendidos:</strong><br /><ul>";
	while($row = $rs_produtos -> fetch(PDO::FETCH_OBJ)){
		$total = $row -> qtde;
		$descricao = $row -> descricao;
		
		print "<li>".$descricao.": ".$total."</li>";
	}
	print "</ul><br /><br />";
} else {
	print "<span class=\"notification n-attention\">Nenhuma informação disponível.</span>";	
}

if($rs_clientes -> execute()){
	print "<strong>Clientes que mais Compraram:</strong><br /><ul>";
	while($row = $rs_clientes -> fetch(PDO::FETCH_OBJ)){
		$empresa = $row -> empresa;
		$valor_total = round($row -> valor_total, 2);
		
		print "<li>".$empresa.": R$ ".$valor_total."</li>";
	}
	print "</ul><br /><br />";
} else {
	print "<span class=\"notification n-attention\">Nenhuma informação disponível.</span>";	
}
		
?>
</div>
<div style="clear:both;"></div>        
       
<!-- End .container_12 --> 

<?php 
$conn_pedido_pedido = NULL;
require "../adm/rodape.php"; ?>