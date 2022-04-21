<?php
require "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_GET['cod_pedido'])){
	$cod_pedido = $_GET['cod_pedido'];
}

if (isset($_POST["continuar"])){
	if (!empty($data)){	
				
		$rs_pedido = $conn_pedido -> prepare("SELECT * FROM pedido WHERE cod_cliente=".$cod_cliente."") or die ("Errro na string SELECT.");	
		 
		if ($rs_pedido -> execute()){
			while ($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)){
				$status = $row -> status;
				$data_pedido = $row -> data;
				
				if(strtotime($data) <= strtotime(date("Y-m-d"))){
					$msg_attention = "<strong>Data inválida.</strong>";
					header ("Location: ?msg_attention=".$msg_attention."");	
					$fail = true;
				} else if ($status == "Pendente"){
					$cod_pedido = $row -> cod_pedido;
					$msg_attention = "<strong>Existe um pedido pendente.</strong>";
					header ("Location: ?msg_attention=".$msg_attention."");
					$fail = true;	
				} else if($data_pedido == $data){
					$cod_pedido = $row -> cod_pedido;
					$msg_attention = "<strong>Essa data já possui um pedido finalizado.</strong>";
					header ("Location: ?msg_attention=".$msg_attention."");
					$fail = true;			
				} 
			}
			
			if (!$fail){
				header("Location: cad_pedido.php?data=".$data."");
			}
		}
	} else {
		$msg_attention = "<strong>Por favor informe a data para a entrega do pedido.</a></strong>";
		header("Location: ?msg_attention=".$msg_attention."");
	}
	
} else {		
		$rs_pedido = $conn_pedido -> prepare("SELECT pedido.data AS data, pedido.valor_total AS valor_total, cliente.empresa AS empresa, item_pedido.preco_unidade AS preco_unidade, quantidade, preco_total, produto.descricao FROM produto, item_pedido, cliente, pedido WHERE pedido.cod_cliente = cliente.cod_cliente AND item_pedido.cod_produto = produto.cod_produto AND pedido.cod_pedido=".$cod_pedido." AND item_pedido.cod_pedido = pedido.cod_pedido") or die ("Errro na string SELECT 2.");
} 


$conn_pedido = NULL;
require "index_adm_pedido.php";
?>
<br />

<div class="module">
<form action="entregas.php" name="form1" id="form1" method="post" >
		Data de Entrega 
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

if($rs_pedido -> execute()){
	if ($rs_pedido -> rowCount()){
		$row = $rs_pedido -> fetch(PDO::FETCH_OBJ);
		$data = $row -> data;
		$empresa = $row -> empresa;
		$aux = explode ("-", $data);
		$data = implode("/", array_reverse($aux));
		
		print "<strong>Código do Pedido: ".$cod_pedido."<br />";
		print "<strong>Empresa: ".$empresa."</strong><br />";
		print "Data da Entrega: ".$data."<br />";
		print "Valor da Nota: R$ ".$row -> valor_total."</strong>";
?>

  <h2><span>PEDIDOS</span></h2>    
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preco Unitário</th>
              <th>Preco dos Produtos</th>              
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preco Unitário</th>
              <th>Total</th> 
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
					 while($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)){
							$preco_unidade = $row -> preco_unidade;
							$quantidade = $row -> quantidade; 
							$preco_total = $row -> preco_total;
							$descricao = $row -> descricao; 
							?>
							<td><?php print $descricao;?></td>
                            <td><?php print $quantidade;?></td>
                            <td>R$ <?php print $preco_unidade;?></td>
                            <td>R$ <?php print $preco_total;?></td>                            
							</tr>
							 
					<?php 
					 }?>     
             </tbody>
	</table>
<?php 
		} else {
			print "<span class=\"notification n-attention\">Nenhum pedido encontrado.</span>";	
		}
}
?>
</div>
<div style="clear:both;"></div>        
       
<!-- End .container_12 --> 

<?php 
$conn_pedido_pedido = NULL;
require "../adm/rodape.php"; ?>