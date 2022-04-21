<?php
include "conexao.php";	

if (isset($_GET["produto"])){
	$tipo_produto = $_GET["produto"];
}
if (isset($_GET["cod_img_produto"])){
	$cod_img_produto = $_GET["cod_img_produto"];
}

if (!empty ($tipo_produto) && is_numeric($tipo_produto)){
	if ($tipo_produto == "1"){
		$tipo_produto = "img_produtos_processados";
	} else {
		$tipo_produto = "img_produtos_industrializados";
	}
	
	$excluir = mysql_query ("SELECT * FROM ".$tipo_produto." WHERE cod_img_produto=".$cod_img_produto."") or print mysql_error();
	$linha = mysql_fetch_object ($excluir);
	
	$str = "DELETE FROM ".$tipo_produto." WHERE cod_img_produto=".$cod_img_produto."";
	$query = mysql_query ($str) or print mysql_error();
	
	if (mysql_affected_rows($conexao) > 0){
		unlink($linha -> img_produto );
		$msg = "<strong>Excluído com sucesso.</strong>";
		header ("Location: list_produtos.php?msg=".$msg."&produto=".$tipo_produto."");
	} else {
		print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
		print "<br /><a href\=list_equipamento.php\">Voltar<\a>";
	}			
	
}
?>