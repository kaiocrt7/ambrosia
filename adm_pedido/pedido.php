<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}

if (isset($_POST['data'])){
	$data = $_POST['data'];
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
	
} else if(isset($_POST["pesquisar"])){
	if (!empty($data)){		
		$rs_pedido = $conn_pedido -> prepare("SELECT * FROM pedido WHERE cod_cliente=".$cod_cliente." AND data='".$data."'") or die ("Errro na string SELECT 2.");		
	} else {
		$rs_pedido = $conn_pedido -> prepare("SELECT * FROM pedido WHERE cod_cliente=".$cod_cliente."") or die ("Errro na string SELECT 3.");	
	}		
} 

require "index.php";
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

if (isset($_POST["pesquisar"])){
	if($rs_pedido -> execute()){
		if ($rs_pedido -> rowCount()){
?>

  <h2><span>PEDIDOS</span></h2>    
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Data</th>
              <th>Situação</th>
              <th>Valor da Nota</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Data</th>
              <th>Situação</th>
              <th>Valor da Nota</th>
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
							$cod_pedido = $row -> cod_pedido;
							$data = $row -> data; 
							$status = $row -> status;
							$valor = $row -> valor_total;
							$aux = explode ("-", $data);
							$data = implode("/", array_reverse($aux)); 
							?>
							<tr>
							<td><a href="list_pedido.php?data=<?php print $data;?>&amp;cod_pedido=<?php print $cod_pedido;?>"><span><span class="glyphicon glyphicon-search" aria-hidden="true" title="Visualizar Pedido"></span></span></a>&nbsp;&nbsp;&nbsp;<?php print $data;?></td>
							<td><?php print $status;?></td>
                            <td>R$ <?php print $valor;?></td>
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
}?>
</div>
<div style="clear:both;"></div>        
       
<!-- End .container_12 --> 

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>