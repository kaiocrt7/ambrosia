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

if ($tipo_pesquisa == 1){
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

}else if (!empty($data_inicio) && !empty($data_fim) && !empty($cod_cliente) && empty($status)){
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


if ($tipo_pesquisa == 1){
	if ($rs_pedido -> execute()) {
		$html = '
		<style>
		table tbody tr:nth-child(odd) {
			background-color: #DCDCDC;
		}
		</style>
			<table cellspacing="0" width="100%" border="1">
				<thead>
				  <tr bgcolor="#696969">
					<td>Pedido</td>
					<td>Empresa</td>
					<td>Data</td>
					<td>Total</td>
					<td>Status</td>
				  </tr>
				</thead>
			<tbody>';
			
			while ($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)) {
				$data = formataData($row -> data);
				
				$html .= '<tr>';
				$html .= '<td align="center">'.$row -> cod_pedido.'</td>';
				$html .= '<td>'.$row -> empresa.'</td>';
				$html .= '<td>'.$data.'</td>';			
				$html .= '<td>R$ '.$row -> valor_total.'</td>';
				$html .= '<td>'.$row -> status.'</td>';
				$html .= '</tr>'; 
			}		
			$html .= '</tbody>		
			</table>';
	}
				
} else if ($tipo_pesquisa == 2){
	if ($rs_pedido -> execute()) {
		$html = '
		<style>
		table tbody tr:nth-child(odd) {
			background-color: #DCDCDC;
		}
		</style>';
				
		while ($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)) {
			$cod_pedido = $row -> cod_pedido;
			$data = formataData($row -> data);
			
			$html .= '<hr /><strong>Código do Pedido: '.$cod_pedido.'<br />';
			$html .= 'Data de Entrega: '.$data.'<br />';
			$html .= 'Empresa: '.$row -> empresa.'<br />';			
			$html .= 'Status: '.$row -> status.'<br />';
			$html .= 'Valor da Nota: R$'.$row -> valor_total.'<br /></strong>';
										
			$html .= 
			'<table cellspacing="0" width="100%" border="1">
				<thead>
				  <tr bgcolor="#696969">
					<th>Produto</th>
					<th>Quantidade</th>
					<th>Preço</th>
					<th>Total</th>
				  </tr>
				</thead>
			<tbody>';
			
			$str_item_pedido = "SELECT item_pedido.preco_unidade, item_pedido.quantidade AS qtde, item_pedido.preco_total, produto.descricao
							FROM pedido, item_pedido, produto
							WHERE pedido.cod_pedido = item_pedido.cod_pedido AND item_pedido.cod_produto = produto.cod_produto
							AND pedido.cod_pedido = ".$cod_pedido."";
			$rs_item_pedido = $conn_pedido -> prepare ($str_item_pedido) or die ("Erro na String SELECT.");
			
			$rs_item_pedido -> execute();
			while ($row = $rs_item_pedido -> fetch(PDO::FETCH_OBJ)) {
				$descricao = $row -> descricao;
				$qtde = $row -> qtde; 
				$total = $row -> preco_total;
				$preco = $row -> preco_unidade;
				
				$html .= '<tr>';
				$html .= '<td>'.$descricao.'</td>';
				$html .= '<td>'.$qtde.'</td>';
				$html .= '<td>R$ '.$preco.'</td>';			
				$html .= '<td>R$ '.$total.'</td>';
				$html .= '</tr>'; 
			}		
			$html .= '</tbody>		
			</table>';			
		}		
	}
}

function formataData ($data){
	$aux = explode ("-", $data);
	$data = implode("/", array_reverse($aux));
	
	return $data;
}
			
define ('mpdf_FONTPATH', '../mpdf60/font');
require ('../mpdf60/mpdf.php');
$data_inicio = formataData($data_inicio);
$data_fim = formataData($data_fim);

$mpdf = new mPDF();
$mpdf -> AddPage();
$mpdf -> SetFont('Times', 'B', 12);
if (!empty($data_fim) && !empty($data_inicio)){
	$mpdf->WriteHTML("<h2>Relatório de Pedidos - ".$data_inicio." até ".$data_fim."</h2>");
} else {
	$mpdf->WriteHTML("<h2>Relatório de Pedidos");
}
$mpdf->WriteHTML($html);
$mpdf->SetFooter('{DATE j-m-Y}|Página {PAGENO} de {nb}|');
$mpdf -> Output();

$conn_pedido = NULL;
?>
