<?php 
require_once "valida_session.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Administrativo | San Diego</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" src="../css/theme-bootstrap.min.css">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>        
    <link rel="stylesheet" type="text/css" href="../css/reset.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/grid.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/styles.css" media="screen" />
    <script src="../docs/js/jquery-1.4.4.min.js"></script>
   
	<link rel="stylesheet" href="../docs/css/jq.css">
	<link rel="stylesheet" href="../docs/css/bootstrap.min.css">
	<link rel="stylesheet" href="../docs/css/prettify.css"> 
	<script src="../docs/js/prettify.js"></script>
	<script src="../docs/js/docs.js"></script>

	<link rel="stylesheet" href="../css/theme.bootstrap.css">
	<script src="../js/jquery.tablesorter.js"></script>
	<script src="../js/jquery.tablesorter.widgets.js"></script>

	<link rel="stylesheet" href="../addons/pager/jquery.tablesorter.pager.css">
	<script src="../addons/pager/jquery.tablesorter.pager.js"></script>

	<script id="js">$(function() {
	$.tablesorter.themes.bootstrap = {
		table      : 'table table-bordered',
		caption    : 'caption',
		header     : 'bootstrap-header', 
		footerRow  : '',
		footerCells: '',
		icons      : '', 
		sortNone   : 'bootstrap-icon-unsorted',
		sortAsc    : 'icon-chevron-up glyphicon glyphicon-chevron-up',     
		sortDesc   : 'icon-chevron-down glyphicon glyphicon-chevron-down', 
		active     : '', 
		hover      : '', 
		filterRow  : '', 
		even       : '', 
		odd        : '' 
	};

	
	$("table").tablesorter({
		theme : "bootstrap",
		widthFixed: true,
		headerTemplate : '{content} {icon}',
		widgets : [ "uitheme", "filter", "zebra" ],
		widgetOptions : {
			zebra : ["even", "odd"],
			filter_reset : ".reset"
		}
	})
	.tablesorterPager({
		container: $(".ts-pager"),
		cssGoto  : ".pagenum",
		removeRows: false,
		output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'
	});

	});</script>

	<script>
	$(function(){

		$('button.filter').click(function(){
			var col = $(this).data('column'),
				txt = $(this).data('filter');
			$('table').find('.tablesorter-filter').val('').eq(col).val(txt);
			$('table').trigger('search', false);
			return false;
		});

		
		$('button.zebra').click(function(){
			var t = $(this).hasClass('btn-success');
			$('table')
				.toggleClass('table-striped')[0]
				.config.widgets = (t) ? ["uitheme", "filter"] : ["uitheme", "filter", "zebra"];
			$(this)
				.toggleClass('btn-danger btn-success')
				.find('i')
				.toggleClass('icon-ok icon-remove glyphicon-ok glyphicon-remove').end()
				.find('span')
				.text(t ? 'disabled' : 'enabled');
			$('table').trigger('refreshWidgets', [false]);
			return false;
		});
	});
	</script>
    
    <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
	function del_img_topo(cod_img_topo){
		if(confirm('Deseja excluir este item?')){
			document.location.href = 'ope_img_topo.php?operacao=2&cod_img_topo='+cod_img_topo;
			}
	}
	
	function del_banner_topo(cod_banner_topo){
		if(confirm('Deseja excluir este item?')){
			document.location.href = 'ope_banner_topo.php?operacao=2&cod_banner_topo='+cod_banner_topo;
			}
	}
	
	function del_img_produto(cod_img_produto, tipo_produto, operacao){ 
			if(confirm('Deseja excluir este item?')){
				document.location.href = 'ope_produtos.php?cod_img_produto='+cod_img_produto+'&produto='+tipo_produto+'&operacao='+operacao;
			} 
	}
	
	function del_inf_produto(cod_inf_produto){  
		if(confirm('Deseja excluir este item?')){
			document.location.href = 'ope_inf_produto.php?cod_inf_produto='+cod_inf_produto;
			} 
	}
	
	function del_cliente(cod_cliente, operacao){  
		if(confirm('Deseja excluir este cliente?')){
			document.location.href = 'ope_clientes.php?cod_cliente='+cod_cliente+'&operacao='+operacao;
			} 
	}
	</SCRIPT>

            
    <script type="text/javascript">		
	function mascara(telefone){ 
	   if(telefone.value.length == 0)
		 telefone.value = '(' + telefone.value; 
		 
	   if(telefone.value.length == 3)
		  telefone.value = telefone.value + ') '; 
	 
	 if(telefone.value.length == 9)
		 telefone.value = telefone.value + '-';		  
	}
	</script>
        
</head>
<body>
    <!-- Header -->
    <div id="header">
        <!-- Header. Status part -->
        <div id="header-status">
            <div class="container_12">
                <div class="grid_8">
                &nbsp;
                </div>
                <div class="grid_4">
                    <a href="logout.php" id="logout">
                    Sair
                    </a>
                </div>
            </div>
            <div style="clear:both;"></div>
        </div> <!-- End #header-status -->
    
    <div class="container_12">

        <!-- Dashboard icons -->
        <div class="grid_7">
            <a href="index.php" class="dashboard-module">
                <img src="../images/menu_adm/home.png" width="64" height="64" alt="edit" />
                <span>Home</span>
            </a>
            
            <a href="config_banner.php" class="dashboard-module">
                <img src="../images/menu_adm/galeria.png" width="64" height="64" alt="edit" />
                <span>Configurar Banners</span>
            </a>
            
            <a href="config_imagens.php" class="dashboard-module">
                <img src="../images/menu_adm/img_miniaturas.png" width="64" height="64" alt="edit" />
                <span>Configurar Imagens</span>
            </a>
            
            <a href="config_ferramentas.php" class="dashboard-module">
                <img src="../images/menu_adm/ferramentas.png" width="64" height="64" alt="edit" />
                <span>Ferramentas</span>
            </a>
                  
            <a href="edit_perfil.php" class="dashboard-module"> <img src="../images/menu_adm/perfil.gif" width="64" height="64" alt="edit" /> 
            <span>Meu Perfil</span> 
            </a> 
            
            <a href="index_adm_pedido.php" class="dashboard-module">
                <img src="../images/menu_adm/painel.png" width="64" height="64" alt="edit" />
                <span>Controle de Negócios</span>
            </a>       
           
            
        </div> 
                    
        <div style="clear:both;"></div> 
