<?php
require_once "conexao_pdo.php";
include "valida_session.php";

if (isset($_GET['cod_inf_produto'])){
	$cod_inf_produto = $_GET['cod_inf_produto'];
}
	
if (!empty($cod_inf_produto) && is_numeric($cod_inf_produto)){
	
	$str_select = "SELECT * FROM img_inf_produto WHERE cod_inf_produto=".$cod_inf_produto."";
	$rs_select = $conn -> prepare ($str_select) or die ("Erro na String SELECT 1.");
	
	if($rs_select -> execute()){
		$row = $rs_select -> fetch(PDO::FETCH_OBJ);
		$imagem = $row -> img_inf_produto;
	} else {
		print ("Erro ao selecionar a imagem para exclusao.");
	}
	
	$rs = $conn -> prepare ("DELETE FROM img_inf_produto WHERE cod_inf_produto=".$cod_inf_produto."") or die ("Erro na preparação da String DELETE");
	
	if ($rs -> execute()){
		unlink($imagem);
		$msg = "<strong>Excluído com sucesso.</strong>";
		header ("Location: list_img_inf_produto.php?msg=".$msg."");
	} else {
		print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
		print "<br /><a href\=list_img_inf_produto.php\">Voltar<\a>";
	}						
}

	
$conn = NULL;
?>