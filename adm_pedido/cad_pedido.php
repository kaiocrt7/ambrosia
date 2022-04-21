<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

if (isset($_GET["data"])){
	$data = $_GET["data"];
}
if (isset($_SESSION["cod_cliente"])){
	$cod_cliente = $_SESSION["cod_cliente"];
}

if (!empty($data) && !empty($cod_cliente)){
		
	$valor_total = 0;
	$rs_produto = $conn_pedido -> prepare("SELECT * FROM carrinho WHERE cod_cliente=".$cod_cliente." AND data='".$data."'") or die ("Erro na String SELECT.");
	
	if ($rs_produto -> execute()){
		if ($rs_produto -> rowCount()){
			while($row = $rs_produto -> fetch(PDO::FETCH_OBJ)){
				$preco_total = $row -> preco_total;
				$valor_total = $valor_total + $preco_total;
			}
		}
	}
	
	$rs_produto = $conn_pedido -> prepare("SELECT * FROM produto WHERE status='Disponível' ORDER BY descricao") or die ("Erro na String SELECT 1.");
	
	$str_carrinho = "SELECT descricao, preco_unidade, preco_total, quantidade, data, cod_carrinho FROM carrinho, produto WHERE cod_cliente=".$cod_cliente." AND carrinho.cod_produto = produto.cod_produto AND data='".$data."' ORDER BY descricao";
	$rs_carrinho = $conn_pedido -> prepare($str_carrinho) or die ("Erro na String SELECT 2");
	
	$aux = explode ("-", $data);
	$data = implode("/", array_reverse($aux));
}
include "index.php";
?>

<br />
<div class="module">
  <div class="row">
  <div class="col-xs-2">
    <input type="text" maxlength="20" readonly value="<?php print $data;?>" id="data" name="data" class="form-control" />
  </div>
  <?php if ($rs_produto -> execute()){ ?>
  <form action="ope_pedido.php" name="form1" id="form1" method="post" >
    <div class="col-xs-2">
      <div class="form-group">
        <select class="form-control" id="produto" name="produto">
          <option value="" selected="selected">Selecione o produto.</option>
          <?php while($row = $rs_produto -> fetch(PDO::FETCH_OBJ)){ ?>
          <option value="<?php print $produto = $row -> cod_produto;?>"><?php print $produto = $row -> descricao;?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="col-xs-2">
      <input type="text" maxlength="2" title="Para alterar algum resultado, especifique o produto que já foi adicionado." required="required" class="form-control" placeholder="Quantidade" id="qtde" name="qtde">
      <input type="hidden" value="<?php print $data;?>" id="data" name="data">
    </div>
    <button type="submit" class="btn btn-success btn-default" id="adicionar" name="adicionar"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Adicionar </button>
    <button type="button" onClick='javascript:location.href="pedido.php"' class="btn btn-default"> <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar </button>
    <br />
    </div>
    <?php 
		if (isset($_GET['msg'])){
			$msg = $_GET['msg'];
			print "<span class=\"notification n-success\">".$msg."</span>";
		} 
		if (isset($_GET['msg_attention'])){
			$msg_attention = $_GET['msg_attention'];
			print "<span class=\"notification n-attention\">".$msg_attention."</span>";
		} 
		 if($rs_carrinho -> execute()){
			 if($rs_carrinho -> rowCount()){?>
    <?php print "<strong>Valor total do pedido: R$ ".$valor_total."</strong>"?>
    <h2><span>PRODUTOS NO CARRINHO - <?php print $data;?></span></h2>
    <table class="tablesorter">
      <thead>
        <tr>
          <th>Data</th>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Preço Unitário</th>
          <th>Preço Total</th>
          <th>Remover Item</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Data</th>
          <th>Produto</th>
          <th>Quantidade</th>
          <th>Preço Unitário</th>
          <th>Preço Total</th>
          <th>Remover Item</th>
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
        <tr>
        
          <?php 
          $msg_attention= "<strong>Para alterar a quantidade de algum produto, especifique qual o produto em seguida informe a quantidade.</strong>";
		 while($row = $rs_carrinho -> fetch(PDO::FETCH_OBJ)){
				$cod_carrinho = $row -> cod_carrinho;	
				$data = $row -> data;
				$descricao = $row -> descricao;
				$quantidade = $row -> quantidade;
				$preco_unidade = $row -> preco_unidade;	
				$preco_total = $row -> preco_total;                                 
          ?>
          
        <tr>
          <td><a href="../adm_pedidos/?msg_attention=<?php print $msg_attention;?>&amp;data=<?php print $data;?>"><?php print $data;?></a></td>
          <td><a href="../adm_pedidos/?msg_attention=<?php print $msg_attention;?>&amp;data=<?php print $data;?>"><?php print $descricao;?></a></td>
          <td><a href="../adm_pedidos/?msg_attention=<?php print $msg_attention;?>&amp;data=<?php print $data;?>"><?php print $quantidade;?></a></td>
          <td><a href="../adm_pedidos/?msg_attention=<?php print $msg_attention;?>&amp;data=<?php print $data;?>"><?php print $preco_unidade;?></a></td>
          <td><a href="../adm_pedidos/?msg_attention=<?php print $msg_attention;?>&amp;data=<?php print $data;?>"><?php print $preco_total;?></a></td>
          <td align="center"><a href="ope_pedido.php?cod_carrinho=<?php print $cod_carrinho;?>&amp;operacao=delete&amp;data=<?php print $data;?>"><img title="Remover" src="../images/menu_adm/apagar.png"></a></td>
        </tr>
        
        <?php
        } ?>
        
      </tbody>
    </table>
    
    <button type="button" onClick='javascript:location.href="ope_pedido.php?operacao=finalizar&data=<?php print $data?>"' class="btn btn-success btn-default" id="finalizar" name="finalizar"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Finalizar </button>
    <?php }
		 }
		 ?>
         
    <h2><span>PRODUTOS DISPONÍVEIS PARA COMPRA</span></h2>
    <table class="tablesorter">
      <thead>
        <tr>
          <th>Produto</th>
          <th>Preço</th>
          <th>Tipo de Venda</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Produto</th>
          <th>Preço</th>
          <th>Tipo de Venda</th>
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
        <tr>
        
          <?php 
		 if($rs_produto -> execute()){
			 while($row = $rs_produto -> fetch(PDO::FETCH_OBJ)){
						$descricao = $row -> descricao;
						$preco = $row -> preco;	
						$tipo_venda = $row -> tipo_venda; ?>
        <tr>
          <td><?php print $descricao;?></td>
          <td><?php print $preco;?></td>
          <td><?php print $tipo_venda;?></td>
        </tr>
        <?php 
			 }
		 }?>
         
      </tbody>
    </table>
    </fieldset>
  </form>
  <?php }?>
  
</div>
<div style="clear:both;"></div>

<!-- End .container_12 -->

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>
