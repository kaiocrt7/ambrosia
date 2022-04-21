<?php
require_once "conexao_pdo_cliente.php";
require_once "valida_session.php";

if (isset($_SESSION['cod_cliente'])){
	$cod_cliente = $_SESSION['cod_cliente'];
}

if (isset($_POST['data'])){
	$data = $_POST['data'];
}
if (isset($_POST['cliente'])){
	$cod_cliente = $_POST['cliente'];
}

$str_cliente = "SELECT * FROM cliente WHERE status='Desbloqueado'";
$cliente = $conn_pedido -> prepare($str_cliente) or die ("Errro na string SELECT.");	

if (isset($_POST["continuar"])){
	if (!empty($data) && !empty($cod_cliente)){	
				
		$rs_pedido = $conn_pedido -> prepare("SELECT * FROM pedido WHERE cod_cliente=".$cod_cliente."") or die ("Errro na string SELECT.");	
		 
		if ($rs_pedido -> execute()){
			while ($row = $rs_pedido -> fetch(PDO::FETCH_OBJ)){
				$status = $row -> status;
				$data_pedido = $row -> data;
				
				if(strtotime($data) <= strtotime(date("Y-m-d"))){
					$msg_attention = "<strong>Data inválida.</strong>";
					header ("Location: ?msg_attention=".$msg_attention."");	
					$fail = true;
				} else if ($status == "Pendente"){
					$cod_pedido = $row -> cod_pedido;
					$msg_attention = "<strong>Existe um pedido pendente.</strong>";
					header ("Location: ?msg_attention=".$msg_attention."");
					$fail = true;	
				} else if($data_pedido == $data){
					$cod_pedido = $row -> cod_pedido;
					$msg_attention = "<strong>Essa data já possui um pedido finalizado.</strong>";
					header ("Location: ?msg_attention=".$msg_attention."");
					$fail = true;			
				} 
			}
			
			if (!$fail){
				header("Location: cad_pedido.php?data=".$data."&cod_cliente=".$cod_cliente."");
			}
		}
	} else {
		$msg_attention = "<strong>Por favor informe a data para a entrega do pedido e a empresa.</a></strong>";
		header("Location: ?msg_attention=".$msg_attention."");
	}
	
} else if(isset($_POST["pesquisar"])){
	if (!empty($data)){		
		$rs_pedido = $conn_pedido -> prepare("SELECT * FROM pedido WHERE cod_cliente=".$cod_cliente." AND data='".$data."'") or die ("Errro na string SELECT 2.");		
	} else {
		$rs_pedido = $conn_pedido -> prepare("SELECT * FROM pedido WHERE cod_cliente=".$cod_cliente."") or die ("Errro na string SELECT 3.");	
	}		
} 

$conn_pedido = NULL;
require "index_adm_pedido.php";
?>
<br />

<div class="module">
<form action="" name="form1" id="form1" method="post" >             
                
		Data de Entrega 
        <div class="row">  
          <div class="col-xs-2">
            <input type="date" maxlength="20" id="data" name="data" class="form-control" />
          </div> 
          
        <div class="col-xs-2">
            <div class="form-group">
              <select class="form-control" id="cliente" name="cliente">
              <option value="" selected="selected">Cliente</option>
              <?php $cliente -> execute();
			  		while ($row = $cliente -> fetch(PDO::FETCH_OBJ)){?>
                		<option value="<?php print $row->cod_cliente;?>"><?php print $row->empresa;?></option>
              <?php }?>
              </select>
            </div>
        </div>
          
              
        <button type="submit" class="btn btn-success btn-default" id="continuar" name="continuar">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Continuar
        </button>
        </div>
                
</form>
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
require "../adm/rodape.php"; ?>