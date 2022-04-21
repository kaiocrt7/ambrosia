<?php
require_once "conexao_pdo_cliente.php";
include "valida_session.php";

if (isset($_GET['operacao'])){
	$operacao = $_GET['operacao'];
}
if (isset($_GET['cod_cliente'])){
	$cod_cliente = $_GET['cod_cliente'];
}
	
if (!empty($operacao) && !empty($cod_cliente) && is_numeric($cod_cliente)){
	if ($operacao == 1){
		$rs = $conn_pedido -> prepare("UPDATE cliente SET status='Bloqueado' WHERE cod_cliente=".$cod_cliente."") or die ("Erro na preparação da string");
		
		if ($rs -> execute()){
			$msg = "<strong>Cliente bloqueado com sucesso.</strong>";
			header ("Location: list_clientes.php?msg=".$msg."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_cliente.php\">Voltar<\a>";
		}	
	}
	
	if ($operacao == 2){
			$rs = $conn_pedido -> prepare ("DELETE FROM cliente WHERE cod_cliente=".$cod_cliente."") or die ("Erro na preparação da String DELETE");
			
			if ($rs -> execute()){
				unlink($imagem);
				$msg = "<strong>Cliente excluido com sucesso.</strong>";
				header ("Location: list_clientes.php?msg=".$msg."");
			} else {
				print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
				print "<br /><a href\=list_cliente.php\">Voltar<\a>";
			}			
	}
	
	if ($operacao == 3){
		$str_cliente = "UPDATE cliente SET status='Desbloqueado' WHERE cod_cliente=".$cod_cliente."";
		$rs = $conn_pedido -> prepare ($str_cliente) or die ("Erro na string Update 2.");
		
		if ($rs -> execute()){
			$msg = "<strong>Cliente desbloqueado com sucesso.</strong>";
			header ("Location: list_clientes.php?msg=".$msg."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_cliente.php\">Voltar<\a>";
		}			
	}
}
	
$conn_pedido = NULL;
?>