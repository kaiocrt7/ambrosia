<?php
require_once "conexao_pdo.php";	

$rs = $conn -> prepare ("SELECT * FROM menu_principal") or die ("Erro na preparação da string SELECT.");

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_menu_principal.php");
	}else { 
		$msg_warning = "Essa operação não pode ser pesquisada.";
		header ("Location: config_ferramentas.php?msg_warning=".$msg_warning."&cod_menu=".$cod_menu."");
	}	
} 

if (isset($_POST['editar']) && !empty($operacao)){ 
		if ($operacao == 2){
			$rs_quem_somos = $conn -> prepare ("SELECT * FROM quem_somos") or die ("Erro na string Select 2.");
			if ($rs_quem_somos -> execute()){
				$row = $rs_quem_somos -> fetch(PDO::FETCH_OBJ);
				$cod_texto = $row -> cod_texto;
				
				header ("Location: edit_quem_somos.php?cod_texto=".$cod_texto."");
			} else {
				print "Tabela quem somos não encontrada.";
			}
	}else if ($operacao == 3){
			$rs_contato = $conn -> prepare ("SELECT * FROM contato") or die ("Erro na string Select 2.");
			if ($rs_contato -> execute()){
				$row = $rs_contato -> fetch(PDO::FETCH_OBJ);
				$cod_contato = $row -> cod_contato;
				
				header ("Location: edit_contato.php?cod_contato=".$cod_contato."");
			} else {
				print "Tabela quem somos não encontrada.";
			}
	}else { 
		$msg_warning = "Essa operação não pode ser editada.";
		header ("Location: ?msg_warning=".$msg_warning."&cod_menu=".$cod_menu."");
	}	
} 

include "index.php";
?>
<br />
<div class="module">
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
                <div class="form-group">
                  <select class="form-control" id="operacao" name="operacao">
                  	<option value="1" selected="selected">Menu Principal</option>
                  	<option value="1">Menu Principal</option>
                    <option value="2">Quem Somos</option>
                    <option value="3">Contato</option>
                  </select>
                </div>
          </div> 
          
        <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        </button>
    
        <button type="submit" class="btn btn-success btn-default" id="editar" name="editar">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar
        </button>
            
     	</div> 
        </form>

<?php
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\">".$msg."</span>";
} 
if (isset($_GET['msg_warning'])){
	$msg_warning = $_GET['msg_warning'];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
} 
?>

<div class="module">
  <h2><span>LISTAGEM - MENU PRINCIPAL</span></h2>
        <?php 
		if ($rs -> execute()){ ?>
			<table class="tablesorter">
                <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Descrição</th>
                      <th>Status</th>
                      <th>Pagina</th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                      <th>Codigo</th>
                      <th>Descrição</th>
                      <th>Status</th>
                      <th>Pagina</th>
                    </tr>
                    <tr>
                      <th colspan="7" class="ts-pager form-horizontal"> <button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
                    <button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
                    <span class="pagedisplay"></span>
                    <button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
                    <button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
                    <select class="pagesize input-mini" title="Select page size">
                          <option selected="selected" value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                        </select>
                    </th>
                    </tr>
                </tfoot>
                
                <tbody>
                    <?php while ($row = $rs -> fetch(PDO::FETCH_OBJ)){?>
                    <tr>
                      <td><a href=edit_menu_principal.php?cod_menu=<?php print $row->cod_menu;?>><?php print $row ->cod_menu;?></a></td>
                      <td><a href=edit_menu_principal.php?cod_menu=<?php print $row->cod_menu;?>><?php print $row ->descricao;?></a></td>
                      <td><a href=edit_menu_principal.php?cod_menu=<?php print $row->cod_menu;?>><?php print $row->status;?></a></td>
                      <td><a href=edit_menu_principal.php?cod_menu=<?php print $row->cod_menu;?>><?php print $row->pagina;?></a></td>
                    <?php } ?>
                </tbody>
			</table>
		<?php
        }else { 
			print "<span class=\"notification n-attention\">A pesquisa não retornou nenhum registro.</span>";
		}	 
?>
</div>

<?php 
$conn = NULL;
require "rodape.php"; ?>

