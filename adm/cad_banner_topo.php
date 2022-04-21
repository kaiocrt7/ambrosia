<?php
require_once "conexao_pdo.php";

if (isset($_POST['listar'])){ 
		header ("Location: list_banner_topo.php");
}	
if (isset($_POST['cadastrar'])){ 
		header ("Location: cad_banner_topo.php");		
}

// Se o botão enviar for clicado
if (isset ($_POST['enviar'])) {
	$titulo = trim($_POST['titulo']);
	$sub_titulo = trim($_POST['sub_titulo']);
	$tema = trim($_POST['tema']);
	$msg_error = "OK";
	
	if ($_FILES["img"]["tmp_name"] != ""){
		if ($_FILES["img"]["size"] > 1048576){
			$msg_error = "<strong>O tamanho da imagem ultrapassa o limite de 1MG.</strong>";
		} else if (!preg_match("/^image\/(jpeg|png)$/", $_FILES["img"]["type"])){
			$msg_error = "<strong>A imagem a ser enviada deve conter os formatos: .jpg ou .png.</strong>";
		} else {
			$caminho = "../images/banner_topo";
			$nome_arquivo = $_FILES["img"]["name"];
			$nome_arquivo = md5(microtime()).$nome_arquivo;
			
			if(move_uploaded_file($_FILES["img"]["tmp_name"], $caminho ."/". $nome_arquivo)){
				$nome_arquivo = $caminho ."/". $nome_arquivo;	
				$str_banner = "INSERT INTO banner_topo (titulo, sub_titulo, img_banner_topo, tema) VALUES (?, ?, ?, ?)";			
			}
		}
	} 
		
	if ($msg_error == "OK"){
		$rs = $conn -> prepare ($str_banner) or die ("Erro ao preparar a string.");
		$rs -> bindParam (1, $titulo);
		$rs -> bindParam (2, $sub_titulo);
		$rs -> bindParam (3, $nome_arquivo);
		$rs -> bindParam (4, $tema);
		
		if ($rs -> execute()){
			$msg = "<strong>Banner cadastrado com sucesso</strong>.";
			header ("Location: ?msg=".$msg."");
		} else {
			$msg_warning = "<strong>As informações não pode ser cadastrada.</strong>";
			header ("Location: ?msg_warning=".$msg_warning."");
		}
	} else {
		header ("Location: ?msg_error=".$msg_error."");
	}	
} 

require "index.php";

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
	print "<span class=\"notification n-error\">".$msg_error."</span>";
} 
if (isset($_GET["msg"])){
	$msg = $_GET["msg"];
	print "<span class=\"notification n-success\">".$msg."</span>";
}
if (isset($_GET["msg_warning"])){
	$msg_warning = $_GET["msg_warning"];
	print "<span class=\"notification n-attention\">".$msg_warning."</span>";
}
?>

<div class="module">  
           <h2><span>CADASTRAR - BANNER TOPO</span></h2>                    
          <div class="module-body">
    <form action="" enctype="multipart/form-data" name="form1" method="post">
    <div class="row">
    	<div class="col-xs-4">
        	<label>Selecione uma imagem:</label>
        </div>             
        <div class="col-xs-4">
        	<input name="img" required="required" id="img" type="file" />
        </div>
    </div>
    <br />
        <div class="row">             
        	<div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Título do Banner" id="titulo" name="titulo">
            </div>
            
            <div class="col-xs-4">
              <input type="text" class="form-control" placeholder="Tema" id="tema" name="tema">
            </div>
        </div>    
        <br />
        
        <div class="row">
            <div class="col-xs-8">
              <input type="text" class="form-control" placeholder="Sub-Título do Banner" id="sub_titulo" name="sub_titulo">
            </div>
      	</div>     
             
        <br />        
        <br />
        <br />
        <br />
              
              	<button type="submit" class="btn btn-success btn-default" id="enviar" name="enviar">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Confirmar
                </button>
                
                <button type="button" onClick='javascript:location.href="config_banner.php"' class="btn btn-default">
        		<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar
     			</button>
                
              </fieldset>
            </form>
            
</div>
<div style="clear:both;"></div>
           
<!-- End .container_12 --> 
<?php 
$conn = NULL;
require "rodape.php"; ?>
