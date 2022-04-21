<?php
require_once "conexao_pdo.php";
include "valida_session.php";

if (isset($_GET['operacao'])){
	$operacao = $_GET['operacao'];
}
if (isset($_GET['cod_banner_topo'])){
	$cod_banner_topo = $_GET['cod_banner_topo'];
}
	
if (!empty($operacao) && !empty($cod_banner_topo) && is_numeric($cod_banner_topo)){
	if ($operacao == 1){
		$rs = $conn -> prepare("UPDATE banner_topo SET status='Inativo' WHERE cod_banner_topo=".$cod_banner_topo."") or die ("Erro na preparação da string");
		
		if ($rs -> execute()){
			$msg = "<strong>Desativado com sucesso.</strong>";
			header ("Location: list_banner_topo.php?msg=".$msg."");
		} else {
			print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
			print "<br /><a href\=list_banner_topo.php\">Voltar<\a>";
		}	
	}
	
	if ($operacao == 2){
			$str_select = "SELECT * FROM banner_topo WHERE cod_banner_topo=".$cod_banner_topo."";
			$rs_select = $conn -> prepare ($str_select) or die ("Erro na String SELECT 1.");
			
			if($rs_select -> execute()){
				$row = $rs_select -> fetch(PDO::FETCH_OBJ);
				$imagem = $row -> img_banner_topo;
			} else {
				print ("Erro ao selecionar a imagem para exclusao.");
			}
			
			$rs = $conn -> prepare ("DELETE FROM banner_topo WHERE cod_banner_topo=".$cod_banner_topo."") or die ("Erro na preparação da String DELETE");
			
			if ($rs -> execute()){
				unlink($imagem);
				$msg = "<strong>Excluído com sucesso.</strong>";
				header ("Location: list_banner_topo.php?msg=".$msg."");
			} else {
				print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
				print "<br /><a href\=list_banner_topo.php\">Voltar<\a>";
			}			
	}
	
	if ($operacao == 3){
			$rs = $conn -> prepare ("UPDATE banner_topo SET status='Ativo' WHERE cod_banner_topo=".$cod_banner_topo."") or die ("Erro na string UPDATE");
			
			if ($rs -> execute()){
				$msg = "<strong>Ativado com sucesso.</strong>";
				header ("Location: list_banner_topo.php?msg=".$msg."");
			} else {
				print "<strong>Algo inesperado aconteceu, contate: Kaio Alves (62)8114-2862.</strong>";
				print "<br /><a href\=list_banner_topo.php\">Voltar<\a>";
			}			
	}
}
	
$conn = NULL;
?>