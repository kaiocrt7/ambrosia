<?php
require_once "conexao_pdo.php";	

$rs = $conn -> prepare ("SELECT * FROM banner_topo") or die ("Erro na preparação da string SELECT.");


if(isset($_POST['cadastrar'])){
		header ("Location: cad_banner_topo.php");		
}

if(isset($_POST['listar'])){
		header ("Location: list_banner_topo.php");		
}

include "index.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
               <input value="Banner Topo" class="form-control" readonly="readonly" />
          </div> 
        
        <button type="submit" class="btn btn-default" id="listar" name="listar">
        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
        </button>
        
        
        <button type="submit" class="btn btn-success btn-default" id="cadastrar" name="cadastrar">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cadastrar
        </button>
            
     	</div> 
</form>

<?php
if (isset($_GET["msg_error"])){
	$msg_error = $_GET["msg_error"];
	print "<span class=\"notification n-success\">".$msg."</span>";
} else 
if (isset($_GET["msg"])){
	$msg = $_GET["msg"];
	print "<span class=\"notification n-success\">".$msg."</span>";
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
                      <th>Sub-Título</th>
                      <th>Tema</th>
                      <th>Status</th>
                      <th>Banner</th>
                      <th></th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                      <th>Codigo</th>
                      <th>Título</th>
                      <th>Sub-Título</th>
                      <th>Tema</th>
                      <th>Status</th>
                      <th>Banner</th>
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
								$img_banner_topo = $row -> img_banner_topo;?>
                    <tr>
                      <td align="center"><a href=edit_banner_topo.php?cod_banner_topo=<?php print $row->cod_banner_topo;?>><?php print $row->cod_banner_topo;?></a></td>
                      <td><a href=edit_banner_topo.php?cod_banner_topo=<?php print $row->cod_banner_topo;?>><?php print $row->titulo;?></a></td>
                      <td><a href=edit_banner_topo.php?cod_banner_topo=<?php print $row->cod_banner_topo;?>><?php print $row->sub_titulo;?></a></td>
                      <td><?php if($row->tema != "NULL"){?><a href=edit_banner_topo.php?cod_banner_topo=<?php print $row->cod_banner_topo;?>><?php print $row->tema;?></a><?php }?></td>
                      
                      <td align="center"><a href=edit_banner_topo.php?cod_banner_topo=<?php print $row->cod_banner_topo;?>><?php print $row->status;?></a></td>
                      <td align="center"><a href=edit_banner_topo.php?cod_banner_topo=<?php print $row->cod_banner_topo;?>><img width="100px" height="50px" src="<?php print $img_banner_topo;?>"/></a></td>
                      <td align="center">&nbsp;
                      <?php if($row -> status == "Inativo"){?>
                      <a href="ope_banner_topo.php?operacao=3&cod_banner_topo=<?php print $row->cod_banner_topo;?>"><img src="../images/menu_adm/ativar.png" title="Ativar"></a>&nbsp;
                      <?php }else {?>
                      <a href="ope_banner_topo.php?operacao=1&cod_banner_topo=<?php print $row->cod_banner_topo;?>"><img src="../images/menu_adm/pausar.png" title="Desativar"></a>
                      <?php }?>
                      <a href="javascript:del_banner_topo(<?php print $row->cod_banner_topo;?>);" ><img src="../images/menu_adm/apagar.png" title="Apagar"></a>
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

