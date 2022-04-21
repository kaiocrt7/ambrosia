<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}

if (isset($_POST['data_inicio'])){
	$data_inicio = $_POST['data_inicio'];
}

if (isset($_POST['data_fim'])){
	$data_fim = $_POST['data_fim'];
}

if (isset($_POST['status'])){
	$status = $_POST['status'];
}
	
if (isset($_POST["pesquisar"])){
	if (!empty($data_inicio) && !empty($data_fim) && empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = ".$cod_cliente." 
						AND pedido.cod_cliente = cliente.cod_cliente 
						ORDER BY cod_pedido DESC";
	} else if (!empty($status) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total
						FROM pedido, cliente
						WHERE pedido.status='".$status."' AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";
	} else if (!empty($data_inicio) && !empty($data_fim) && !empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND
						pedido.status='".$status."' AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";
	} else if (!empty($data_inicio) && !empty($data_fim) && !empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.status = '".$status."' AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";					
	} else {
		$str_pedido = "SELECT pedido.cod_pedido AS cod_pedido, pedido.data AS data, pedido.status AS status, pedido.valor_total AS valor_total, 
						pedido.status AS status
						FROM pedido, cliente
						WHERE pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.cod_cliente=".$cod_cliente." AND pedido.cod_cliente = cliente.cod_cliente
						ORDER BY cod_pedido DESC";
	}
	
	$rs_pedido = $conn_pedido -> prepare ($str_pedido) or die ("Erro na string SELECT.");
}

$rs_cliente = $conn_pedido -> prepare("SELECT * FROM cliente") or die("Erro na string SELECT 1.");

require "index.php";
?>
<br />

<div class="module">
<form action="" name="form1" id="form1" method="post" >
	<div class="row">
    	<div class="col-xs-4">
            <div class="form-group">
                <select class="form-control" id="status" name="status">                
                <option value="" selected="selected">Entrega Pendente e Entregue</option>
                <option value="">Entrega Pendente e Entregue</option>
                <option value="Entregue">Entregue</option>
                <option value="Entrega Pendente">Entrega Pendente</option>
                </select>
            </div>
        </div>
    </div>

      <div class="row"> 
                   
        <div class="col-xs-2"><label>Data Inínio</label>
        <input type="date" maxlength="20" id="data_inicio" name="data_inicio" class="form-control" />
        </div>
        
        <div class="col-xs-2"><label>Data Fim</label>
        <input type="date" maxlength="20" id="data_fim" name="data_fim" class="form-control" />
        </div>      
      
      </div>  
      <br />         
               
    <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
    </button>   
              
                
</form>

<?php 

if (isset($_POST["pesquisar"])){
	if ($rs_pedido -> execute()){
		if ($rs_pedido -> rowCount()){
?>

  <h2><span>RELATÓRIO OBTIDO A PARTIR DA PESQUISA</span></h2>
  <form action="" name="form1" method="post">    
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Pedido</th>
              <th>Data</th>
              <th>Valor da Nota</th>
              <th class="filter-select filter-exact" data-placeholder="Todos">Status</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Pedido</th>
              <th>Data</th>
              <th>Valor da Nota</th>
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
					 while($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)){
							$cod_pedido = $row -> cod_pedido; 
							$data = $row -> data;
							$total = $row -> valor_total;
							$status = $row -> status;
							
							$aux = explode ("-", $data);
							$data = implode("/", array_reverse($aux)); 
							?>
							<tr>
							<td><a href="../adm_pedidos/itens_pedido.php?cod_pedido=<?php print $cod_pedido;?>"><span><span class="glyphicon glyphicon-search" aria-hidden="true" title="Visualizar Pedido"></span></span></a>&nbsp;&nbsp;&nbsp;<?php print $cod_pedido;?></td>
                            <td><?php print $data;?></td>
                            <td>R$ <?php print $total;?></td>
                            <td><?php print $status;?></td>
							</tr>
							 
					<?php } ?> 
                            
             </tbody>
	</table>

<?php } else {
			$msg_attention = "A pesquisa não retornou nenhum resultado.";
			print "<span class=\"notification n-attention\">".$msg_attention."</span>";
		}
	}
}
?>

<strong>* Os relatórios podem ser gerados a partir de uma determinada empresa ou por data início e data fim incluindo todas as empresas.</strong>
</div>
<div style="clear:both;"></div>        

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>