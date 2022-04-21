<?php
require_once "conexao_pdo.php";	

if (isset($_GET["produto"])){
	$tipo_produto = $_GET["produto"];
}
if (isset($_GET["cod_img_produto"])){
	$cod_img_produto = $_GET["cod_img_produto"];
}
if (isset($_GET["operacao"])){
	$operacao = $_GET["operacao"];
}

if (!empty ($operacao) && !empty ($tipo_produto)){
	
	if ($operacao == 1){
		$str_select = "SELECT * FROM ".$tipo_produto." WHERE cod_img_produto=".$cod_img_produto."";
		$rs_select = $conn -> prepare($str_select) or die("Erro na string SELECT.");
		
		if($rs_select -> execute()){
			$row = $rs_select -> fetch(PDO::FETCH_OBJ);
			$imagem = $row -> img_produto;
		} else {
			print ("Erro ao selecionar a imagem para exclusao.");
		}
		
		$str_delete = "DELETE FROM ".$tipo_produto." WHERE cod_img_produto=".$cod_img_produto."";
		$rs = $conn -> prepare($str_delete) or die("Erro na string DELETE.");
		
		if ($rs -> execute()){
			unlink($imagem);
			$msg = "<strong>Excluído com sucesso.</strong>";
			header ("Location: list_produtos.php?msg=".$msg."&produto=".$tipo_produto."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_equipamento.php\">Voltar<\a>";
		}
	} 
	
	if($operacao == 2){
		$rs = $conn -> prepare ("UPDATE ".$tipo_produto." SET situacao='Ativo' WHERE cod_img_produto=".$cod_img_produto."") or die ("Erro na string SELECT");
		
		if ($rs -> execute()){
			$msg = "<strong>Ativado com sucesso.</strong>";
			header ("Location: list_produtos.php?msg=".$msg."&produto=".$tipo_produto."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_img_topo.php\">Voltar<\a>";
		}
	}
	
	if($operacao == 3){
		$rs = $conn -> prepare ("UPDATE ".$tipo_produto." SET situacao='Inativo' WHERE cod_img_produto=".$cod_img_produto."") or die ("Erro na string SELECT");
		
		if ($rs -> execute()){
			$msg = "<strong>Desativado com sucesso.</strong>";
			header ("Location: list_produtos.php?msg=".$msg."&produto=".$tipo_produto."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_img_topo.php\">Voltar<\a>";
		}
	}
	
}

$conn = NULL;
?>