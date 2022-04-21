<?php
require_once "conexao_pdo_cliente.php";
include "valida_session.php";

if (isset($_GET['operacao'])){
	$operacao = $_GET['operacao'];
}
if (isset($_GET['cod_produto'])){
	$cod_produto = $_GET['cod_produto'];
}
	
if (!empty($operacao) && !empty($cod_produto) && is_numeric($cod_produto)){
	if ($operacao == 1){
		$rs = $conn_pedido -> prepare("UPDATE produto SET status='Indisponível' WHERE cod_produto=".$cod_produto."") or die ("Erro na preparação da string");
		
		if ($rs -> execute()){
			$msg = "<strong>Produto retirado de estoque.</strong>";
			header ("Location: list_produto_pedido.php?msg=".$msg."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_produto_pedido.php\">Voltar<\a>";
		}	
	}
	
	if ($operacao == 2){
			$rs = $conn_pedido -> prepare ("DELETE FROM produto WHERE cod_produto=".$cod_produto."") or die ("Erro na preparação da String DELETE");
			
			if ($rs -> execute()){
				unlink($imagem);
				$msg = "<strong>Produto excluido com sucesso.</strong>";
				header ("Location: list_produto_pedido.php?msg=".$msg."");
			} else {
				print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
				print "<br /><a href\=list_produto_pedido.php\">Voltar<\a>";
			}			
	}
	
	if ($operacao == 3){
		$str_produto = "UPDATE produto SET status='Disponível' WHERE cod_produto=".$cod_produto."";
		$rs = $conn_pedido -> prepare ($str_produto) or die ("Erro na string Update 2.");
		
		if ($rs -> execute()){
			$msg = "<strong>Produto colocado em estoque.</strong>";
			header ("Location: list_produto_pedido.php?msg=".$msg."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_produto_pedido.php\">Voltar<\a>";
		}			
	}
}
	
$conn_pedido = NULL;
?>