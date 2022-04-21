<?php
require_once "conexao_pdo_cliente.php";	

$rs = $conn_pedido -> prepare ("SELECT * FROM produto") or die ("Erro na preparação da string SELECT.");


if(isset($_POST['cadastrar'])){
		header ("Location: cad_produto_pedido.php");		
}

include "index_adm_pedido.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
               <input value="Produtos em Estoque" class="form-control" readonly="readonly" />
          </div>
        
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
  <h2><span>LISTAGEM - PRODUTOS</span></h2>
        <?php 
		if ($rs -> execute()){ ?>
			<table class="tablesorter">
                <thead>
                    <tr>
                      <th>Código Produto</th>
                      <th>Descrição</th>
                      <th>Preco</th>
                      <th>Tipo de Venda</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                      <th>Código Produto</th>
                      <th>Descrição</th>
                      <th>Preco</th>
                      <th>Tipo de Venda</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                    <tr>
                      <th colspan="8" class="ts-pager form-horizontal"> <button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
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
                      <td align="center"><a href=edit_produto_pedido.php?cod_produto=<?php print $row->cod_produto;?>><?php print $row->cod_produto;?></a></td>
                      <td><a href=edit_produto_pedido.php?cod_produto=<?php print $row->cod_produto;?>><?php print $row->descricao;?></a></td>
                      <td><a href=edit_produto_pedido.php?cod_produto=<?php print $row->cod_produto;?>><?php print $row->preco;?></a></td>
                      <td><a href=edit_produto_pedido.php?cod_produto=<?php print $row->cod_produto;?>><?php print $row->tipo_venda;?></a></td>
                      <td><a href=edit_produto_pedido.php?cod_produto=<?php print $row->cod_produto;?>><?php print $row->status;?></a></td>
                      <td align="center">       	
                      <?php if($row -> status == "Disponível"){?>
                      <a href="ope_produto_pedido.php?operacao=1&cod_produto=<?php print $row->cod_produto;?>"><img src="../images/menu_adm/pausar.png" title="Ativar"></a>
                      <?php }else {?>
                      <a href="ope_produto_pedido.php?operacao=3&cod_produto=<?php print $row->cod_produto;?>"><img src="../images/menu_adm/ativar.png" title="Desativar"></a>
                      <?php } ?>		
              			<a href="javascript:del_produto_pedido(<?php print $row->cod_produto;?>, 2);" ><img src="../images/menu_adm/apagar.png" title="Apagar"></a>		
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
$conn_pedido = NULL;
require "rodape.php"; ?>

