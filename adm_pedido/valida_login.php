<?php
session_start();
require_once "conexao_pdo.php";

if (isset ($_POST["username"])){
	$username = trim($_POST["username"]);
}
if (isset($_POST["senha"])){
	$senha = trim($_POST["senha"]);
}
	
if (!empty($username) && !empty($senha)){
	
	$senha = md5($senha);
	$str_cliente = "SELECT * FROM cliente WHERE username='".$username."' AND senha='".$senha."'";
	$rs = $conn_pedido -> prepare ($str_cliente) or die ("ERRO NA STRING SQL.");
	
	if ($rs -> execute()){
		$row = $rs -> fetch(PDO::FETCH_OBJ);
		
		if (!empty($row -> cod_cliente)){
			
			if ($row -> status == "Desbloqueado"){
				$_SESSION ["cod_cliente"] = $row -> cod_cliente;
				$_SESSION ["empresa"] = $row -> empresa;
				$_SESSION ["username"] = $row -> username;
				$_SESSION ["senha"] = $row -> senha;
				
				$autentica = $row -> empresa.$row -> cod_cliente.$row -> username.$row -> senha;
				$_SESSION["autentica"] = md5 ($autentica);
				
				// Limpa a tabela carrinho, caso a data já se passou.
				$data_atual = date("Y-m-d");
				$rs_carrinho = $conn_pedido -> prepare("SELECT * FROM carrinho WHERE data < '".$data_atual."'") or die ("Errro na string SELECT 2.");
				
				if ($rs_carrinho -> execute()){
					if($rs_carrinho -> rowCount()){
						while ($row = $rs_carrinho -> fetch(PDO::FETCH_OBJ)){
							$cod_carrinho = $row -> cod_carrinho;
							 
							$str_delete = "DELETE FROM carrinho WHERE cod_carrinho=".$cod_carrinho."";
							$rs_delete = $conn_pedido -> prepare($str_delete) or die ("Errro na string DELETE 1.");
							$rs_delete -> execute();
						}
					}
				}
					
				header ("Location: index.php");
			} else {
				print "<script>
						alert('Esse cliente esta bloqueado. Por favor, entre em contato com (62)3516-5717.');
						document.location.href = 'login.php';
					</script>";
			} 
		} else {
			print "<script>
						alert('Cliente nao existe.');
						document.location.href = 'login.php';
					</script>";
		}

	}
}

	
$conn_pedido = NULL;
?>