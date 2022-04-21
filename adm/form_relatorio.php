<?php
require_once "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_POST['tipo_pesquisa'])){
	$tipo_pesquisa = $_POST['tipo_pesquisa'];
}

$rs_cliente = $conn_pedido -> prepare("SELECT * FROM cliente") or die("Erro na string SELECT 1.");

$conn_pedido = NULL;
require "index_adm_pedido.php";
?>
<br />

<div class="module">
<form action="" name="form1" id="form1" method="post" >
      <div class="row">              
        <div class="col-xs-3">
            <div class="form-group">
                <select class="form-control" id="tipo_pesquisa" name="tipo_pesquisa">                
                <option value="1" selected="selected">Pesquisar apenas Pedido</option>
                <option value="1">Pesquisar apenas Pedido</option>
                <option value="2">Pesquisar Itens de Pedidos</option>
                </select>
            </div>
        </div>
               
    <button type="submit" class="btn btn-default" id="prosseguir" name="prosseguir">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Prosseguir
    </button> 
    
    </div>     
</form>

<?php if (isset($_POST['prosseguir']) && !empty($tipo_pesquisa) || isset($_POST['pesquisar'])){?>
<form action="relatorio_pdf.php" target="_blank" name="form1" id="form1" method="post" >
	<input type="hidden" value="<?php print $tipo_pesquisa;?>" id="tipo_pesquisa" name="tipo_pesquisa">
    
      <div class="row">              
        <div class="col-xs-2"><label>Data Inínio</label>
        <input type="date" maxlength="20" id="data_inicio" name="data_inicio" class="form-control" />
        </div>
        
        <div class="col-xs-3"><label>Data Fim</label>
        <input type="date" maxlength="20" id="data_fim" name="data_fim" class="form-control" />
        </div>
      </div>
      <br />
      
      <div class="row"> 
        <div class="col-xs-2">
            <div class="form-group">
                <select class="form-control" id="empresa" name="empresa">                
                <option value="" selected="selected">Todas empresas...</option>
                <?php 
                if($rs_cliente -> execute()){					
                while($row = $rs_cliente -> fetch(PDO::FETCH_OBJ)){?>
                <option value="<?php print $row -> cod_cliente;?>"><?php print $row -> empresa;?></option>
                <?php }
                }?>
                </select>
            </div>
        </div>
        
        <div class="col-xs-3">
            <div class="form-group">
                <select class="form-control" id="status" name="status">                
                <option value="" selected="selected">Entrega Pendente e Entregue</option>
                <option value="">Entrega Pendente e Entregue</option>
                <option value="Entrega Pendente">Entrega Pendente</option>
                <option value="Entregue">Entregue</option>
                </select>
            </div>
        </div>
                       
    </div> 
               
    <button type="submit" class="btn btn-default" id="pesquisar" name="pesquisar">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pesquisar
    </button>    
        
</form>

<?php 
}
?>


</div>
<div style="clear:both;"></div>         
       
<!-- End .container_12 --> 

<?php 
$conn_pedido_pedido = NULL;
require "../adm/rodape.php"; ?>