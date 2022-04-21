<?php
require_once "conexao_pdo.php";	

$rs = $conn -> prepare ("SELECT * FROM img_topo") or die ("Erro na preparação da string SQL.");

if (isset($_POST['operacao'])){
	$operacao = $_POST['operacao'];
}

if (isset($_POST['pesquisar']) && !empty($operacao)){ 
	if ($operacao == 1){ 
		header ("Location: list_img_topo.php");
	}else if ($operacao == 2){
		header ("Location: list_img_inf_produto.php");
	}else if ($operacao == 3){
		header ("Location: list_produtos.php?produto=img_produtos_industrializados");
	} else if($operacao == 4){
		header ("Location: list_produtos.php?produto=img_produtos_processados");
	}else { 
		print "<span class=\"notification n-attention\">A pesquisa não retornou nenhum registro.</span>";
	}	
} elseif (isset($_POST["cadastrar"]) && !empty($operacao)){
	if ($operacao == 1){
		header ("Location: cad_img_topo.php");
	}else if ($operacao == 2){
		header ("Location: cad_inf_produtos.php");
	}else if ($operacao == 3){
		header ("Location: cad_produtos.php?produto=img_produtos_industrializados");
	} else if($operacao == 4){
		header ("Location: cad_produtos.php?produto=img_produtos_processados");
	}else { 
		$msg_warning = "Não é possível cadastrar imagem desse tipo.";
		header ("Location: config_imagens.php?msg_warning=".$msg_warning."");
	}	
}

include "index.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
                <div class="form-group">
                  <select class="form-control" id="operacao" name="operacao">
                  <option value="1" selected="selected">Imagem Topo</option>
                  <option value="1">Imagem Topo</option>
                    <option value="4">Produtos Processados</option>
                    <option value="3">Produtos Industrializados</option>
                  	<option value="2">Imagem de Produtos</option>
                  </select>
                </div>
          </div> 
        
        	<button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
            </button>
           
            <button type="submit" class="btn btn-success btn-default" id="cadastrar" name="cadastrar">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cadastrar
            </button>
            
     	</div> 
</form>

<?php
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\">".$msg."</span>";
} else 
if (isset($_GET["msg_warning"])){ 
	$msg_warning = $_GET["msg_warning"];
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
                      <th>Título</th>
                      <th>Descrição</th>
                      <th>Status</th>
                      <th>Imagem</th>
                      <th></th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                      <th>Codigo</th>
                      <th>Título</th>
                      <th>Descrição</th>
                      <th>Status</th>
                      <th>Imagem</th>
                      <th></th>
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
                    <?php while ($row = $rs -> fetch(PDO::FETCH_OBJ)){
						$img_topo = $row -> img_topo;?>
                    <tr>
                      <td align="center"><br /><a href=edit_img_topo.php?cod_img_topo=<?php print $row->cod_img_topo;?>><?php print $row->cod_img_topo;?></a></td>
                      <td><br /><a href=edit_img_topo.php?cod_img_topo=<?php print $row->cod_img_topo;?>><?php print $row->titulo;?></a></td>
                      <td><br /><a href=edit_img_topo.php?cod_img_topo=<?php print $row->cod_img_topo;?>><?php print $row->texto;?></a></td>
                      <td align="center"><br /><a href=edit_img_topo.php?cod_img_topo=<?php print $row->cod_img_topo;?>><?php print $row->status;?></a></td>
                      <td align="center"><br /><a href=edit_img_topo.php?cod_img_topo=<?php print $row->cod_img_topo;?>><img width="90px" height="70px" src="<?php print $img_topo;?>"/></a></td>
                      <td align="center"><br />
                      <?php if($row -> status == "Inativo"){?>
                      <a href="ope_img_topo.php?operacao=3&cod_img_topo=<?php print $row->cod_img_topo;?>"><img src="../images/menu_adm/ativar.png" title="Ativar"></a>
                      <?php }else {?>
                      <a href="ope_img_topo.php?operacao=1&cod_img_topo=<?php print $row->cod_img_topo;?>"><img src="../images/menu_adm/pausar.png" title="Desativar"></a>
                      <?php }?>
                      <a href="javascript:del_img_topo(<?php print $row->cod_img_topo;?>);" ><img src="../images/menu_adm/apagar.png" title="Apagar"></a>
                      </td>
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

