<?php
if (isset($_POST['pesquisa'])){
	$pesquisa = $_POST['pesquisa'];
}

if (isset($_POST['pesquisar']) && !empty($pesquisa)){ 
	if ($pesquisa == 1){ 
		header ("Location: list_menu_principal.php");
	}else if ($pesquisa == 2){
		header ("Location: list_quem_somos.php");
	}else if ($pesquisa == 3){
		header ("Location: list_contato.php");
	}else { 
		print "<span class=\"notification n-attention\">A pesquisa não retornou nenhum registro.</span>";
	}	
} 

include "index.php";
?>

<br />
<form action="" name="form1" id="form1" method="post" >
        <div class="row">   
          <div class="col-xs-3">
                <div class="form-group">
                  <select class="form-control" id="pesquisa" name="pesquisa">
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
            
     	</div> 
</form>

<?php require "rodape.php"; ?>
</div>



