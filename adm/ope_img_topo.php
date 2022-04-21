<?php
require_once "conexao_pdo.php";
include "valida_session.php";

if (isset($_GET['operacao'])){
	$operacao = $_GET['operacao'];
}
if (isset($_GET['cod_img_topo'])){
	$cod_img_topo = $_GET['cod_img_topo'];
}
	
if (!empty($operacao) && !empty($cod_img_topo) && is_numeric($cod_img_topo)){
	if ($operacao == 1){
		$rs = $conn -> prepare ("UPDATE img_topo SET status='Inativo' WHERE cod_img_topo=".$cod_img_topo."") or die ("Erro na string SELECT.");
		
		if ($rs -> execute()){
			$msg = "<strong>Desativado com sucesso.</strong>";
			header ("Location: list_img_topo.php?msg=".$msg."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_img_topo.php\">Voltar<\a>";
		}	
	}
	
	if ($operacao == 2){
			$rs_select = $conn -> prepare ("SELECT * FROM img_topo WHERE cod_img_topo=".$cod_img_topo."") or die("Erro na string SELECT.");
			
			if($rs_select -> execute()){
				$row = $rs_select -> fetch(PDO::FETCH_OBJ);
				$imagem = $row -> img_topo;
			} else {
				print ("Erro ao selecionar a imagem para exclusao.");
			}
			
			$rs = $conn -> prepare ("DELETE FROM img_topo WHERE cod_img_topo=".$cod_img_topo."") or die ("Erro na string DELETE");
			
			if ($rs -> execute()){
				unlink($imagem);
				$msg = "<strong>Excluído com sucesso.</strong>";
				header ("Location: list_img_topo.php?msg=".$msg."");
			} else {
				print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
				print "<br /><a href\=list_img_topo.php\">Voltar<\a>";
			}			
	}
	
	if ($operacao == 3){
			$rs = $conn -> prepare ("UPDATE img_topo SET status='Ativo' WHERE cod_img_topo=".$cod_img_topo."") or die ("Erro na string SELECT");
			
			if ($rs -> execute()){
				$msg = "<strong>Ativado com sucesso.</strong>";
				header ("Location: list_img_topo.php?msg=".$msg."");
			} else {
				print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
				print "<br /><a href\=list_img_topo.php\">Voltar<\a>";
			}			
	}
}
	
$conn = NULL;
?>