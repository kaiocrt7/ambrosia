<?php
require_once "adm/conexao_pdo.php";

if(isset($_GET["cod_img_topo"])){
	$cod_img_topo = $_GET["cod_img_topo"];
}

// Query menu principal
$menu = $conn -> prepare ("SELECT * FROM menu_principal WHERE status = 'Ativo'") or die("Erro na string SELCT 1.");

// Query imagem topo
$img_topo = $conn -> prepare ("SELECT * FROM img_topo WHERE cod_img_topo=".$cod_img_topo."") or die("Erro na string SELCT 2.");

$busca = $conn -> prepare ("SELECT * FROM img_topo WHERE cod_img_topo <> ".$cod_img_topo." ORDER by RAND() LIMIT 1") or die("Erro na string SELCT 3.");
	
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="shortcut icon" href="images/menu_adm/logo_aba.png" type="image/x-icon" />
    
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

    <!-- CSS LIBRARY -->
    <link rel="stylesheet" type="text/css" href="css/lib/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/lib/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/lib/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="css/lib/font-awesome.min.css">

    <!-- ANIMATION -->
    <link rel="stylesheet" type="text/css" href="css/lib/animate.css">

    <!-- AWE FONT -->
    <link rel="stylesheet" type="text/css" href="css/awe-fonts.css">

    <!-- PAGE STYLE -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    
    
    <title>San Diego | Produtos</title>
</head>
<body id="page-top" class="home onepage" data-spy="scroll">

<!-- PRELOADER -->
<div class="preloader">
    <div class="inner">
        <div class="item item1"></div>
        <div class="item item2"></div>
        <div class="item item3"></div>
    </div>
</div>
<!-- END / PRELOADER -->

<!-- PAGE WRAP -->
<div id="page-wrap">

    <!-- HEADER -->
    <header id="header" class="header header-2">
        <div class="container">
            <!-- LOGO -->
            <div class="logo"><a href="#page-top"><img src="images/menu_adm/sandiego.png" alt=""></a></div>
            <!-- END / LOGO -->

            <!-- OPEN MENU MOBILE -->
            <div class="open-menu-mobile">
                <span>Toggle menu mobile</span>
            </div>
            <!-- END / OPEN MENU MOBILE -->

            <!-- NAVIGATION -->
            <nav class="navigation text-right" data-menu-type="1200">
                <!-- MENU -->
                <ul class="nav text-uppercase">
                <?php 
				if ($menu -> execute()){
					while ($row = $menu -> fetch(PDO::FETCH_OBJ)){ ?>
					<li><a href="index.php<?php print $row -> pagina;?>"><?php print $row -> descricao;?></a></li>
                <?php }
				}?>
                </ul>
                <!-- END / MENU -->
                
                <!-- REDE SOCIAL -->
                <div class="head-social">
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-pinterest"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                </div>
                <!-- END / REDE SOCIAL -->
            </nav>
            <!-- END / NAVIGATION -->
        </div>

    </header>
    <!-- END / HEADER -->

    <!-- SUB BANNER -->
    <section class="sub-banner text-center section">
        <div class="awe-title awe-title-3">
            <h3 class="lg text-uppercase">Produtos</h3>
        </div>
    </section>
    <!-- END / SUB BANNER -->

    <!-- ABOUT STORY -->    
    <section id="about-story" class="about-story section">
        <div class="divider divider-2"></div>
        <div class="container">
            <div class="block-first">
                <div class="row">
                    <div class="col-md-4">
                        <div class="image-wrap">
							<?php
							if ($img_topo -> execute()){ 	
								$row = $img_topo -> fetch(PDO::FETCH_OBJ);
								$foto = str_replace("../", "", $row -> img_topo);
								$titulo = $row -> titulo;
								$texto_pagina = $row -> texto_pagina;
								$titulo_pagina = $row -> titulo_pagina;
							} 
                            ?>
                            <img src="<?php print $foto;?>" alt="">
                        </div>
                    </div>
		
                    <div class="col-md-7 col-md-offset-1">                    
                        <h4 class="lg text-uppercase"><?php print $titulo_pagina?></h4>
                        <p><?php print $texto_pagina;?></p>
                    </div>
                </div>
            </div>
<hr />
            <div class="block-last">
                <div class="row">
                    <div class="col-md-4 col-md-push-8">
                        <div class="row">
                           <div class="col-xs-6">
                                <div class="image-wrap">
                                <?php 
								if($busca -> execute()){
									$row = $busca -> fetch(PDO::FETCH_OBJ);									
									$cod_img_topo = $row -> cod_img_topo;
									$foto = str_replace("../", "", $row -> img_topo);
									$titulo_pagina = $row -> titulo_pagina;
									$texto_pagina = $row -> texto;
								}
								?>
                                    <a href="img_produtos.php?cod_img_topo=<?php print $cod_img_topo;?>"> <img src="<?php print $foto;?>" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 col-md-pull-4">                    	
                        <strong><?php print $titulo_pagina;?></strong>
                        <p><?php print $texto_pagina;?></p>
                        <a href="img_produtos.php?cod_img_topo=<?php print $cod_img_topo;?>" class="awe-btn awe-btn-2 awe-btn-default text-uppercase">Saiba Mais</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ABOUT STORY -->

    </div>
    </section>
    <!-- END / THE STAFF -->


    <!-- FOOTER -->
    <footer id="footer" class="footer">
        <div class="divider divider-1 divider-color"></div>
        <div class="awe-color"></div>
        <div class="container">
            <div class="copyright text-center">
                © 2015 Hortaliça San Diego
            </div>
        </div>
    </footer>
    <!-- END / FOOTER -->
    

</div>
<!-- END / PAGE WRAP -->
<?php $conn = NULL;?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/lib/perfect-scrollbar.min.js"></script>

<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>