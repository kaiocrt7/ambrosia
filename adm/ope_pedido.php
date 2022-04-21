<?php 
require_once "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_POST["cod_cliente"])){
	$cod_cliente = $_POST["cod_cliente"];
} else {
	$cod_cliente = $_GET["cod_cliente"];
}

if (isset($_POST["data"])){
	$data = $_POST["data"];
} else {
	$data = $_GET["data"];
}

if (isset($_GET["cod_carrinho"])){
	$cod_carrinho = $_GET["cod_carrinho"];
}

if (isset($_GET["operacao"])){
	$operacao = $_GET["operacao"];
} else{
	$operacao = "";
}

if (!empty($data)){
	if ($operacao == "finalizar"){
		$aux = explode ("/", $data);
		$data = implode("-", array_reverse($aux));
		
		$str_carrinho = "SELECT * FROM carrinho WHERE data='".$data."' AND cod_cliente=".$cod_cliente."";
		$rs_carrinho = $conn_pedido -> prepare($str_carrinho) or die ("Erro na STRING SELECT.");
		
		$valor_total = 0;
		if ($rs_carrinho -> execute()){
			while ($row = $rs_carrinho -> fetch(PDO::FETCH_OBJ)){
				$preco_total = $row -> preco_total;
				$valor_total = $valor_total + $preco_total;			
			}
			$str_pedido= "INSERT INTO pedido (cod_cliente, data, valor_total, status) VALUES(".$cod_cliente.", '".$data."', '".$valor_total."', 'Entrega Pendente')";
			
			$rs_pedido = $conn_pedido -> prepare ($str_pedido) or die ("Erro na String INSERT 1.");
			$rs_pedido -> execute();
		}

		$str_pedido = "SELECT * FROM pedido WHERE data='".$data."'";
		$rs_pedido = $conn_pedido -> prepare ($str_pedido) or die ("Erro na string SELECT 2.");
		$rs_pedido -> execute();
		$row = $rs_pedido -> fetch(PDO::FETCH_OBJ);
		$cod_pedido = $row -> cod_pedido;
		
		if ($rs_carrinho -> execute()){
			while ($row = $rs_carrinho -> fetch(PDO::FETCH_OBJ)){
				$cod_produto = $row -> cod_produto;
				$preco_unidade = $row -> preco_unidade;
				$quantidade = $row -> quantidade;
				$preco_total = $row -> preco_total;	
				
				$str_item_pedido= "INSERT INTO item_pedido (cod_pedido, cod_produto, preco_unidade, quantidade, preco_total) VALUES(".$cod_pedido.", ".$cod_produto.", '".$preco_unidade."', ".$quantidade.", '".$preco_total."')";
				$rs_item_pedido = $conn_pedido -> prepare ($str_item_pedido) or die ("Erro na String INSERT 3.");
				$rs_item_pedido -> execute();
			}
						
			if($rs_item_pedido -> rowCount()){	
				$str_carrinho = "DELETE FROM carrinho WHERE data='".$data."' AND cod_cliente=".$cod_cliente."";
				$rs_carrinho = $conn_pedido -> prepare ($str_carrinho) or die ("Erro na string DELETE.");
				$rs_carrinho -> execute();	
								
				$aux = explode ("-", $data);
				$data = implode("/", array_reverse($aux));
		
				$msg = "<strong>O pedido foi finalizado com sucesso.<br />Código Pedido: ".$cod_pedido."<br />Data Entrega: ".$data."</strong>";
				header ("Location: simular_pedido.php?msg=".$msg."&cod_cliente=".$cod_cliente."");
			}
		}
	
	} else if (!empty($cod_carrinho) && !empty($data) && ($operacao == "delete")){
		$rs_carrinho = $conn_pedido -> prepare("DELETE FROM carrinho WHERE cod_carrinho=".$cod_carrinho."") or die ("Erro na string DELETE 1.");
		
		if($rs_carrinho -> execute()){
			header ("Location: cad_pedido.php?data=".$data."&cod_cliente=".$cod_cliente."");
		} else {
			print "Erro na inclusão.";
		}
		
	} else if(!empty($data) && empty($operacao)){
		$aux = explode ("/", $data);
		$data = implode("-", array_reverse($aux));
								
		if (isset($_POST["qtde"])){
			$qtde = $_POST["qtde"];
		}
		
		if (isset($_POST["produto"])){
			$cod_produto = $_POST["produto"];
		}
		
		if ($qtde == 0){
			$msg_attention = "<strong>Campo quantidade não pode ser igual a 0 ou conter caractere alfabetico.</strong>";	
			header ("Location: cad_pedido.php?data=".$data."&msg_attention=".$msg_attention."&cod_cliente=".$cod_cliente."");
		}
		
		if (empty($cod_produto)){
			$msg_attention = "<strong>Selecione o produto a ser adicionado no carrinho.</strong>";	
			header ("Location: cad_pedido.php?data=".$data."&msg_attention=".$msg_attention."&cod_cliente=".$cod_cliente."");
		}
		
		$rs_produto = $conn_pedido -> prepare("SELECT * FROM produto WHERE status='Disponível' AND cod_produto=".$cod_produto." ORDER BY descricao") or die ("Erro na String SELECT 5.");

		if ($rs_produto -> execute()){
			$row = $rs_produto -> fetch(PDO::FETCH_OBJ);
			$preco_unidade = $row -> preco;
			$preco_total = $preco_unidade * $qtde;
		}
		
		
		$rs_carrinho = $conn_pedido -> prepare("SELECT * FROM carrinho WHERE cod_produto=".$cod_produto." AND data='".$data."' AND cod_cliente=".$cod_cliente."") or die ("Erro na String SELECT 6.");
		$rs_carrinho -> execute();
		
		if ($rs_carrinho -> rowCount() > 0){
			$row = $rs_carrinho -> fetch(PDO::FETCH_OBJ);
			$cod_carrinho = $row -> cod_carrinho;
			
			if ($qtde == 0){
				$msg_attention = "<strong>O valor da quantidade não pode ser igual a 0 ou conter caracteres alfabeticos.</strong>";
				header ("Location ?cad_pedido.php?data=".$data."?msg_attention=".$msg_attention."&cod_cliente=".$cod_cliente."");
			} else {
				$str_carrinho = "UPDATE carrinho SET quantidade=".$qtde.", preco_total='".$preco_total."' WHERE cod_carrinho=".$cod_carrinho."";	
				$rs_carrinho = $conn_pedido -> prepare($str_carrinho) or die ("Erro na String UPDATE 1.");
			}
			
			if($rs_carrinho -> execute()){
				header ("Location: cad_pedido.php?data=".$data."&cod_cliente=".$cod_cliente."");
			} else {
				print "Erro na inclusão.";
			}		
			
		} else {
			if ($qtde == 0){
				$msg_attention = "<strong>O valor da quantidade não pode ser igual a 0 ou conter caracteres alfabeticos.</strong>";
				header ("Location ?cad_pedido.php?data=".$data."?msg_attention=".$msg_attention."&cod_cliente=".$cod_cliente."");
			} else {
				$str_carrinho = "INSERT INTO carrinho (cod_produto, preco_unidade, preco_total, quantidade, data, cod_cliente) VALUES (".$cod_produto.", '".$preco_unidade."', '".$preco_total."', ".$qtde.", '".$data."', ".$cod_cliente.")";
				$rs_carrinho = $conn_pedido -> prepare ($str_carrinho) or die ("Erro na string INSERT 1.");
				
				if($rs_carrinho -> execute()){
					header ("Location: cad_pedido.php?data=".$data."&cod_cliente=".$cod_cliente."");
				} else {
					print "Erro na inclusão.";
				}
			}
		}
	}
}

$conn_pedido = NULL;
?>