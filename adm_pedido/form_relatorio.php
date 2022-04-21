<?php
require_once "conexao_pdo.php";
require_once "valida_session.php";

$rs_cliente = $conn_pedido -> prepare("SELECT * FROM cliente") or die("Erro na string SELECT 1.");

$conn_pedido = NULL;
require "index.php";
?>

<br />
<div class="module">
  <form action="relatorio_pdf.php" target="_blank" name="form1" id="form1" method="post" >
    <div class="row">
      <div class="col-xs-4">
        <div class="form-group">
          <select class="form-control" id="status" name="status">
            <option value="" selected="selected">Entrega Pendente e Entregue</option>
            <option value="">Entrega Pendente e Entregue</option>
            <option value="Entregue">Entregue</option>
            <option value="Entrega Pendente">Entrega Pendente</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-2">
        <label>Data Início</label>
        <input type="date" maxlength="20" id="data_inicio" name="data_inicio" class="form-control" />
      </div>
      <div class="col-xs-2">
        <label>Data Fim</label>
        <input type="date" maxlength="20" id="data_fim" name="data_fim" class="form-control" />
      </div>
    </div>
    <br />
    <button type="submit" class="btn btn-success" id="gerar" name="gerar"> <span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> Gerar Relatório </button>
  </form>
  <strong>* Os relatórios podem ser gerados a partir de uma determinada empresa ou por data início e data fim incluindo todas as empresas.</strong>
  
<?php 
if (isset($_GET['msg'])){
	$msg = $_GET['msg'];
	print "<span class=\"notification n-success\">".$msg."</span>";
} else if (isset($_GET['msg_attention'])){
	$msg_attention = $_GET['msg_attention'];
	print "<span class=\"notification n-attention\">".$msg_attention."</span>";
}
?>

</div>
<div style="clear:both;"></div>

<!-- End .container_12 -->

<?php 
$conn_pedido = NULL;
require "../adm/rodape.php"; ?>
