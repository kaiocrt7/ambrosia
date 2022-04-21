<?php
require_once "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_POST['tipo_pesquisa'])){
	$tipo_pesquisa = $_POST['tipo_pesquisa'];
}

if (isset($_POST['data_inicio'])){
	$data_inicio = $_POST['data_inicio'];
}

if (isset($_POST['data_fim'])){
	$data_fim = $_POST['data_fim'];
}

if (isset($_POST['empresa'])){
	$cod_cliente = $_POST['empresa'];
}

if (isset($_POST['status'])){
	$status = $_POST['status'];
}
	
if (isset($_POST["pesquisar"]) && $tipo_pesquisa == 1){
	if (!empty($data_inicio) && !empty($data_fim) && empty($status) && empty($cod_cliente)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && !empty($data_inicio) && !empty($data_fim) && empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data,
		 				pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && empty($status) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE pedido.cod_cliente=".$cod_cliente." AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($status) && empty($cod_cliente) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE pedido.status='".$status."' AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($data_inicio) && !empty($data_fim) && !empty($status) && empty($cod_cliente)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND
						pedido.status='".$status."' AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && !empty($status) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE pedido.status = '".$status."' AND pedido.cod_cliente=".$cod_cliente." AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && !empty($data_inicio) && !empty($data_fim) && !empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.status = '".$status."' AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";					
	} else {
		$str_pedido = "SELECT pedido.cod_pedido AS cod_pedido, pedido.data AS data, pedido.status AS status, pedido.valor_total AS valor_total, 
						pedido.status AS status, cliente.empresa AS empresa
						FROM pedido, cliente
						WHERE pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	}
	$rs_pedido = $conn_pedido -> prepare ($str_pedido) or die ("Erro na string SELECT.");
	
} else if (isset($_POST["pesquisar"]) && $tipo_pesquisa == 2){ 

	if (!empty($data_inicio) && !empty($data_fim) && !empty($cod_cliente) && empty($status)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = ".$cod_cliente." AND pedido.cod_cliente = cliente.cod_cliente
							AND (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."')";
			
	} else if (!empty($data_inicio) && !empty($data_fim) && empty($cod_cliente) && empty($status)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente
							AND (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') ORDER BY pedido.data";
							
	} else if (!empty($data_inicio) && !empty($data_fim) && !empty($status) && empty($cod_cliente)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente AND pedido.status = '".$status."'
							AND (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') ORDER BY pedido.data";
							
	} else if (!empty($data_inicio) && !empty($data_fim) && !empty($status) && !empty($cod_cliente)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente 
							AND pedido.status='".$status."' AND pedido.cod_cliente=".$cod_cliente."
							AND (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') ORDER BY pedido.data";
							
	} else if (empty($data_inicio) && empty($data_fim) && !empty($status) && !empty($cod_cliente)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente 
							AND pedido.status='".$status."' AND pedido.cod_cliente=".$cod_cliente." ORDER BY pedido.data";
							
	} else if (empty($data_inicio) && empty($data_fim) && !empty($status) && empty($cod_cliente)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente 
							AND pedido.status='".$status."' ORDER BY pedido.data";
	}  else if (empty($data_inicio) && empty($data_fim) && empty($status) && !empty($cod_cliente)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente 
							AND pedido.cod_cliente=".$cod_cliente." ORDER BY pedido.data";
	} else if (empty($data_inicio) && empty($data_fim) && empty($status) && empty($cod_cliente)){
			$str_pedido = "SELECT pedido.cod_pedido, pedido.status, pedido.valor_total AS valor_total, cliente.empresa, pedido.data AS data
							FROM pedido, cliente
							WHERE pedido.cod_cliente = cliente.cod_cliente 
							ORDER BY pedido.data";
	} 
	
	$rs_pedido = $conn_pedido -> prepare ($str_pedido) or die ("Erro na string SELECT.");
}

$rs_cliente = $conn_pedido -> prepare("SELECT * FROM cliente") or die("Erro na string SELECT 1.");

require "index_adm_pedido.php";
?>
<br />

<div class="module">
<form action="" name="form1" id="form1" method="post" >
      <div class="row">              
        <div class="col-xs-3">
            <div class="form-group">
                <select class="form-control" id="tipo_pesquisa" name="tipo_pesquisa">                
                <option value="1" selected="selected">Pesquisar apenas Pedido</option>
                <option value="1">Pesquisar apenas Pedido</option>
                <option value="2">Pesquisar Itens de Pedidos</option>
                </select>
            </div>
        </div>
               
    <button type="submit" class="btn btn-default" id="prosseguir" name="prosseguir">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Prosseguir
    </button> 
    
    </div>     
</form>

<?php if (isset($_POST['prosseguir']) && !empty($tipo_pesquisa) || isset($_POST['pesquisar'])){?>
<form action="" name="form1" id="form1" method="post" >
	<input type="hidden" value="<?php print $tipo_pesquisa;?>" id="tipo_pesquisa" name="tipo_pesquisa">
      <div class="row">              
        <div class="col-xs-2"><label>Data Inínio</label>
        <input type="date" maxlength="20" id="data_inicio" name="data_inicio" class="form-control" />
        </div>
        
        <div class="col-xs-3"><label>Data Fim</label>
        <input type="date" maxlength="20" id="data_fim" name="data_fim" class="form-control" />
        </div>
      </div>
      <br />
      
      <div class="row"> 
        <div class="col-xs-2">
            <div class="form-group">
                <select class="form-control" id="empresa" name="empresa">                
                <option value="" selected="selected">Todas empresas...</option>
                <?php 
                if($rs_cliente -> execute()){					
					while($row = $rs_cliente -> fetch(PDO::FETCH_OBJ)){?>
					<option value="<?php print $row -> cod_cliente;?>"><?php print $row -> empresa;?></option>
					<?php }
                }?>
                </select>
            </div>
        </div>
        
        <div class="col-xs-3">
            <div class="form-group">
                <select class="form-control" id="status" name="status">                
                <option value="" selected="selected">Entrega Pendente e Entregue</option>
                <option value="">Entrega Pendente e Entregue</option>
                <option value="Entrega Pendente">Entrega Pendente</option>
                <option value="Entregue">Entregue</option>
                </select>
            </div>
        </div>
                       
    </div> 
               
    <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
    </button> 
     
            
</form>

<?php 
}

if (isset($_POST["pesquisar"]) && $tipo_pesquisa == 1){
	if ($rs_pedido -> execute()){
		if ($rs_pedido -> rowCount()){
?>

  <h2><span>RELATÓRIO OBTIDO A PARTIR DA PESQUISA</span></h2>
  <form action="" name="form1" method="post">    
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Pedido</th>
              <th>Empresa</th>
              <th>Data</th>
              <th>Valor da Nota</th>
              <th class="filter-select filter-exact" data-placeholder="Todos">Status</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Pedido</th>
              <th>Empresa</th>
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
							$empresa = $row -> empresa; 
							$data = $row -> data;
							$total = $row -> valor_total;
							$status = $row -> status;
							
							$data = formataData($row -> data); 
							?>
							<tr>
							<td><a href="itens_pedido.php?cod_pedido=<?php print $cod_pedido;?>"><span><span class="glyphicon glyphicon-search" aria-hidden="true" title="Visualizar Pedido"></span></span></a>&nbsp;&nbsp;&nbsp;<?php print $cod_pedido;?></td>
                            <td><?php print $empresa;?></td>
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
	print "<strong>* Os relatórios podem ser gerados a partir de uma determinada empresa ou por data início e data fim incluindo todas as empresas.</strong>";
	
} else if(isset($_POST["pesquisar"]) && $tipo_pesquisa == 2){
	if ($rs_pedido -> execute()){
		if ($rs_pedido -> rowCount()){
?>

  <form action="" name="form1" method="post">
  	<?php while($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)){
			  $cod_pedido = $row -> cod_pedido;
			  
			  $data = formataData($row -> data);
			  
			  print "<hr /><strong>Código do pedido: </strong>".$cod_pedido."<br />";
			  print "<strong>Data de Entrega: </strong>".$data."<br />";
			  print "<strong>Empresa: </strong>".$row -> empresa."<br />"; 
			  print "<strong>Status: </strong>".$row -> status."<br />";
			  print "<strong>Valor da Nota:</strong> R$".$row -> valor_total."<br />";
			  
			  $str_item_pedido = "SELECT item_pedido.preco_unidade, item_pedido.quantidade AS qtde, item_pedido.preco_total, produto.descricao
								FROM pedido, item_pedido, produto
								WHERE pedido.cod_pedido = item_pedido.cod_pedido AND item_pedido.cod_produto = produto.cod_produto
								AND pedido.cod_pedido = ".$cod_pedido."";
			  $rs_item_pedido = $conn_pedido -> prepare ($str_item_pedido) or die ("Erro na String SELECT.");			  			 
	?>    
    
    <h2><span>RELATÓRIO OBTIDO A PARTIR DA PESQUISA</span></h2>
        <table class="tablesorter">
            <thead>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço</th>
              <th>Total</th>
            </tr>
        </thead>
        
        <tfoot>
            <tr>
              <th>Produto</th>
              <th>Quantidade</th>
              <th>Preço</th>
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
					 $rs_item_pedido -> execute();
					 while($row = $rs_item_pedido -> fetch(PDO::FETCH_OBJ)){
							$descricao = $row -> descricao;
							$qtde = $row -> qtde; 
							$total = $row -> preco_total;
							$preco = $row -> preco_unidade;
						
					?>
							<tr>
                            <td><?php print $descricao;?></td>
                            <td><?php print $qtde;?></td>
                            <td>R$ <?php print $preco;?></td>
                            <td>R$ <?php print $total;?></td>
							</tr>							 
					<?php } ?> 
                            
             </tbody>
	</table>

<?php 
	}
} else {
			$msg_attention = "A pesquisa não retornou nenhum resultado.";
			print "<span class=\"notification n-attention\">".$msg_attention."</span>";
		}
	}
	print "<strong>* Os relatórios podem ser gerados a partir de uma determinada empresa ou por data início e data fim incluindo todas as empresas.</strong>";
	
}

function formataData ($data){
	$aux = explode ("-", $data);
	$data = implode("/", array_reverse($aux));
	
	return $data;
}
?>

</div>
<div style="clear:both;"></div>        

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>