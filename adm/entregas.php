<?php
require_once "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}

if (isset($_POST['data'])){
	$data = $_POST['data'];
}
if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST["continuar"])){
	$arr = filter($operacao);

	$str_pedido = "UPDATE pedido SET status='Entregue' WHERE cod_pedido IN(".implode( ',', $arr ).")";
  var_dump($str_pedido);exit;
	$rs = $conn_pedido -> prepare ($str_pedido) or die ("Erro na string UPDADE 1.");
			
	if ($rs -> execute()){
		$msg = "Pedido entregue."; ?>
		<script language="javascript" type="text/javascript">
		var msg = "<?php echo $msg;?>";
		window.location.href = 'entregas.php?msg='+msg;
		</script>
	   <?php			
	}
	
} else if(isset($_POST["pesquisar"]) || isset($_GET["msg"])){
	if (!empty($data)){		
		$rs_pedido = $conn_pedido -> prepare("SELECT pedido.data AS data, pedido.cod_pedido, data, valor_total, pedido.status AS status, cliente.empresa AS empresa FROM pedido, cliente WHERE pedido.cod_cliente = cliente.cod_cliente AND pedido.data='".$data."' AND pedido.status = 'Entrega Pendente' ORDER BY data DESC") or die ("Errro na string SELECT 2.");		
		$rs_entregue = $conn_pedido -> prepare("SELECT pedido.data AS data, pedido.cod_pedido, data, valor_total, pedido.status AS status, cliente.empresa AS empresa FROM pedido, cliente WHERE pedido.cod_cliente = cliente.cod_cliente AND pedido.data='".$data."' AND pedido.status = 'Entregue' ORDER BY data DESC") or die ("Errro na string SELECT 2.");		
		$rs_contador_entregue = $conn_pedido -> prepare ("SELECT COUNT(cod_pedido) AS contador_entregue FROM pedido WHERE status='Entregue' AND data='".$data."'") or die ("Erro na String SELECT 4");			
		$rs_contador_pedido = $conn_pedido -> prepare 
    ("SELECT COUNT(cod_pedido) AS contador_pedido FROM pedido WHERE status='Entrega Pendente' AND data='".$data."'") or die ("Erro na String SELECT 5");
				
	} else {
		$rs_pedido = $conn_pedido -> prepare("SELECT pedido.cod_pedido, data, valor_total, pedido.status AS status, cliente.empresa AS empresa FROM pedido, cliente WHERE pedido.cod_cliente = cliente.cod_cliente AND pedido.status = 'Entrega Pendente' ORDER BY data DESC") or die ("Errro na string SELECT 3.");			
		$rs_entregue = $conn_pedido -> prepare("SELECT pedido.cod_pedido, data, valor_total, pedido.status AS status, cliente.empresa AS empresa FROM pedido, cliente WHERE pedido.cod_cliente = cliente.cod_cliente AND pedido.status = 'Entregue' ORDER BY data DESC") or die ("Errro na string SELECT 3.");		
		$rs_contador_entregue = $conn_pedido -> prepare ("SELECT COUNT(cod_pedido) AS contador_entregue FROM pedido WHERE status='Entregue'") or die ("Erro na String SELECT 4");			
		$rs_contador_pedido = $conn_pedido -> prepare ("SELECT COUNT(cod_pedido) AS contador_pedido FROM pedido WHERE status='Entrega Pendente'") or die ("Erro na String SELECT 5");
	}			
} 

function filter($dados){
	$arr = Array();
	foreach($dados as $dado){
		$arr[] = (int)$dado;
	}
	return $arr;
}


$conn_pedido = NULL;
require "index_adm_pedido.php";
?>
<br />

<div class="module">
<form action="" name="form1" id="form1" method="post" >
		Data de Entrega 
        <div class="row">  
          <div class="col-xs-2">
            <input type="date" maxlength="20" id="data" name="data" class="form-control" />
          </div> 
          
        <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pedidos
        </button>
        
        </div>
                
</form>
<?php 
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\"><strong>".$msg."</strong></span>";
} else if (isset($_GET['msg_attention'])){
	$msg_attention = $_GET['msg_attention'];
	print "<span class=\"notification n-attention\">".$msg_attention."</span>";
}

if (isset($_POST["pesquisar"]) || isset($_GET["msg"])){
	
	if($rs_contador_pedido -> execute()){
		$row = $rs_contador_pedido -> fetch(PDO::FETCH_OBJ);
		$total = $row -> contador_pedido;
		
		if ($total > 0){
?>

  <h2><span>PEDIDOS COM ENTREGA PENDENTE - TOTAL: <?php print $total;?></span></h2>
  <form action="" name="form1" method="post">    
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Data</th>
              <th>Valor da Nota</th>
              <th>Empresa</th>
              <th>Status</th>
              <th>Entregue</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Data</th>
              <th>Valor da Nota</th>
              <th>Empresa</th>
              <th>Status</th>
              <th>Selecionar</th>
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
				 if ($rs_pedido -> execute()){
					 while($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)){
							$cod_pedido = $row -> cod_pedido;
							$data = $row -> data; 
							$valor = $row -> valor_total;
							$status = $row -> status;
							$empresa = $row -> empresa;
							$aux = explode ("-", $data);
							$data = implode("/", array_reverse($aux)); 
							?>
							<tr>
							<td><a href="itens_pedido.php?cod_pedido=<?php print $cod_pedido;?>"><span><span class="glyphicon glyphicon-search" aria-hidden="true" title="Visualizar Pedido"></span></span></a>&nbsp;&nbsp;&nbsp;<?php print $data;?></td>
                            <td>R$ <?php print $valor;?></td>
                            <td><?php print $empresa;?></td>
                            <td><?php print $status;?></td>
                            <td align="center"><input type="checkbox" name="operacao[]" value="<?php print $cod_pedido;?>" /></td>
							</tr>
							 
					<?php 
					 }
				 }?> 
                            
             </tbody>
	</table>
        <button type="submit" class="btn btn-success btn-default" id="continuar" name="continuar">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Marcar como Entregue
        </button>
    </form>
    <?php } else {
			print "<span class=\"notification n-attention\">A pesquisa não retornou nenhum registro para pedidos pendentes.</span>";
		}
	}?> 
    
<?php if($rs_contador_entregue -> execute()){
		$row = $rs_contador_entregue -> fetch(PDO::FETCH_OBJ);
		$total = $row -> contador_entregue;
		if ($total > 0){
		?>
      <h2><span>PEDIDOS QUE JÁ FORAM ENTREGUES - TOTAL: <?php print $total;?></span></h2> 
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Data</th>
              <th>Valor da Nota</th>
              <th>Empresa</th>
              <th>Status</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Data</th>
              <th>Valor da Nota</th>
              <th>Empresa</th>
              <th>Status</th>
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
				 if ($rs_entregue -> execute()){
					 while($row = $rs_entregue -> fetch(PDO::FETCH_OBJ)){
							$cod_pedido = $row -> cod_pedido;
							$data = $row -> data; 
							$valor = $row -> valor_total;
							$status = $row -> status;
							$empresa = $row -> empresa;
							$aux = explode ("-", $data);
							$data = implode("/", array_reverse($aux)); 
							?>
							<tr>
							<td><a href="itens_pedido.php?cod_pedido=<?php print $cod_pedido;?>"><span><span class="glyphicon glyphicon-search" aria-hidden="true" title="Visualizar Pedido"></span></span></a>&nbsp;&nbsp;&nbsp;<?php print $data;?></td>
                            <td>R$ <?php print $valor;?></td>                            
                            <td><?php print $empresa;?></td>
                            <td><?php print $status;?></td>
							</tr>
							 
					<?php 
					 }
				}?> 
                            
             </tbody>
	</table>
<?php 
		} else {
			print "<span class=\"notification n-attention\">A pesquisa não retornou nenhum registro para pedidos entregues.</span>";
		}
	}
}?>
</div>
<div style="clear:both;"></div>        
       
<!-- End .container_12 --> 

<?php 
$conn_pedido_pedido = NULL;
require "../adm/rodape.php"; ?>