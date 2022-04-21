<?php
if (isset($_POST['listar'])){ 
		header ("Location: list_banner_topo.php");
}	
if (isset($_POST['cadastrar'])){ 
		header ("Location: cad_banner_topo.php");		
}

include "index.php";

if (isset($_GET["msg"])){ 
	$msg = $_GET['msg']; 
    print "<span class=\"notification n-success\">".$msg."</span>";
}
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

<?php require "rodape.php"; ?>




