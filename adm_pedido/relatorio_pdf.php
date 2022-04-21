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
	
	if (!empty($data_inicio) && !empty($data_fim) && empty($status) && empty($cod_cliente)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente." AND (pedido.data <= '".$data_fim."' 
						AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && !empty($data_inicio) && !empty($data_fim) && empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data,
		 				pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente." AND (pedido.data <= '".$data_fim."' 
						AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && empty($status) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente."
						AND pedido.cod_cliente=".$cod_cliente." AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($status) && empty($cod_cliente) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente." 
						AND pedido.status='".$status."' AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($data_inicio) && !empty($data_fim) && !empty($status) && empty($cod_cliente)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente." 
						AND (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND
						pedido.status='".$status."' AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && !empty($status) && empty($data_fim) && empty($data_inicio)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente." 
						AND pedido.status = '".$status."' AND pedido.cod_cliente=".$cod_cliente." 
						AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	} else if (!empty($cod_cliente) && !empty($data_inicio) && !empty($data_fim) && !empty($status)){
		$str_pedido = "SELECT pedido.status AS status, pedido.cod_pedido AS cod_pedido, pedido.data AS data, 
						pedido.valor_total AS valor_total, cliente.empresa as empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente."  
						AND (pedido.data <= '".$data_fim."' AND pedido.data >= '".$data_inicio."') AND pedido.cod_cliente = cliente.cod_cliente 
						AND pedido.status = '".$status."' AND pedido.cod_cliente=".$cod_cliente." ORDER BY cod_pedido DESC";					
	} else {
		$str_pedido = "SELECT pedido.cod_pedido AS cod_pedido, pedido.data AS data, pedido.status AS status, pedido.valor_total AS valor_total, 
						pedido.status AS status, cliente.empresa AS empresa
						FROM pedido, cliente
						WHERE cliente.cod_cliente = ".$cod_cliente." AND pedido.cod_cliente = cliente.cod_cliente ORDER BY cod_pedido DESC";
	}
$rs_pedido = $conn_pedido -> prepare ($str_pedido) or die ("Erro na STRING SELECT 1.");
	
if ($rs_pedido -> execute() && $rs_pedido -> rowCount()) {
	$row = $rs_pedido -> fetch(PDO::FETCH_OBJ);
	$empresa = $row -> empresa;
	
	$html = '
	<style>
	table tbody tr:nth-child(odd) {
		background-color: #DCDCDC;
	}
	</style>
	<p><strong>Empresa:</strong> ';
	$html .= $empresa. "</p>";
	
	$html .= '
	<table cellspacing="0" width="100%" border="1">
			<thead>
			  <tr bgcolor="#696969">
				<td>Pedido</td>
				<td>Data</td>
				<td>Total</td>
				<td>Status</td>
			  </tr>
			</thead>
		<tbody>';
		
		$rs_pedido -> execute();
		while ($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)) {
			$data = $row -> data;
			$aux = explode ("-", $data);
			$data = implode("/", array_reverse($aux));
			
			$html .= '<tr>';
			$html .= '<td align="center">'.$row -> cod_pedido.'</td>';
			$html .= '<td>'.$data.'</td>';			
			$html .= '<td>R$ '.$row -> valor_total.'</td>';
			$html .= '<td>'.$row -> status.'</td>';
			$html .= '</tr>'; 
		}		
		$html .= '</tbody>		
		</table>';
			
define ('mpdf_FONTPATH', '../mpdf60/font');
require ('../mpdf60/mpdf.php');

$mpdf = new mPDF();
$mpdf -> AddPage();
$mpdf -> SetFont('Times', 'B', 12);
if(!empty($status)){
	$mpdf->WriteHTML("<h2>Relatório de Pedidos ".$status."</h2>");
} else {
	$mpdf->WriteHTML("<h2>Relatório de Pedidos</h2>");
}
$mpdf->WriteHTML($html);
$mpdf->SetFooter('{DATE j-m-Y}|Página {PAGENO} de {nb}|');
$mpdf -> Output();
			
} else { 
	print "<strong>A pesquisa não retornou nenhum registro.</strong><br /><a href=\"javascript:window.close()\">Fechar</a>";
}

$conn_pedido = NULL;


?>

