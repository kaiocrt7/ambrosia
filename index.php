<?php
require_once "adm/conexao_pdo.php";
// Query quem somos
$quem_somos = $conn -> prepare ("SELECT * FROM quem_somos") or die ("Erro na String 1.");
 
// Query contato
$contato = $conn -> prepare ("SELECT * FROM contato") or die ("Erro na String 2.");

// Query menu principal
$menu = $conn -> prepare ("SELECT * FROM menu_principal WHERE status = 'Ativo'") or die ("Erro na String 3.");

// Query Banner principal topo
$banner_topo = $conn -> prepare ("SELECT * FROM banner_topo WHERE cod_banner_topo > 0 AND status='Ativo' ORDER by RAND() LIMIT 4") or die ("Erro na String 4.");

$produtos_processados = $conn -> prepare ("SELECT * FROM img_produtos_processados WHERE situacao='Ativo' ORDER BY nome_produto") or die ("Erro na String 5.");

$produtos_industrializados = $conn -> prepare ("SELECT * FROM img_produtos_industrializados WHERE situacao='Ativo' ORDER BY nome_produto") or die ("Erro na String 6.");

// Query imagem topo
$img_topo = $conn -> prepare ("SELECT * FROM img_topo WHERE cod_img_topo > 0 ORDER by RAND() LIMIT 3") or die ("Erro na String 7.");

?>

<!DOCTYPE html>
<!--[if IE 7 ]> <html class="ie ie7"> <![endif]-->
<!--[if IE 8 ]> <html class="ie ie8"> <![endif]-->
<!--[if IE 9 ]> <html class="ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="" lang="en"> <!--<![endif]-->
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
    
    
    <title>San Diego</title>
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
					<li><a href="<?php print $row -> pagina;?>"><?php print $row -> descricao;?></a></li>
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

    <!-- HOME MEDIA -->
    <section id="home-media" class="home-media section">
        <div class="home-fullscreen tb">
            <ul class="home-slider" data-background="awe-parallax">
            <?php 
			if($banner_topo -> execute()){
				while ($row = $banner_topo -> fetch(PDO::FETCH_OBJ)){
					$img_banner_topo = str_replace("../", "", $row -> img_banner_topo);
					?>
					<li>
						<div class="image-wrap">
						  <img src="<?php print $img_banner_topo;?>" alt="">
						</div>
						<div class="slider-content text-center">
							<div class="home-content">
							<?php if (!empty ($row -> tema)){?>
								<div class="ribbon ribbon-1">
									<h2 class="sm"><?php print $row -> tema;?></h2>
								</div>
							<?php }?>
								<h1 class="sbig text-uppercase"><?php print $row -> titulo;?></h1>
								<div class="awe-hr">
									<i class="icon awe_certificate"></i>
								</div>
								<p class="xmd"><?php print $row -> sub_titulo;?></p>
							</div>
						</div>
				  </li>
            <?php }
			}?>    
            </ul>
        </div>
    </section>
    <!-- END / HOME MEDIA -->
    
    <!-- GOOD FOOD -->
    <section id="quem_somos" class="good-food section pd">
        <div class="container">
            <div class="good-food-heading text-center">
                <div class="good-food-title style-1 wow fadeInUp" data-wow-delay=".2s">
                    <i class="icon awe_quote_left"></i>
                    <?php
                    if($quem_somos -> execute()){
						$row = $quem_somos -> fetch(PDO::FETCH_OBJ); ?>
                    <h2 class="lg text-uppercase"><?php print $row -> titulo;?></h2>
                    <i class="icon awe_quote_right"></i>
                </div>
                <p class=" wow fadeInUp" data-wow-delay=".4s"><?php print $row -> descricao;?></p>
            </div>
            		<?php 
					}?>
            
            <div class="good-food-body wow fadeInUp" data-wow-delay=".6s">
                <div class="row">
                    <!-- GOOD ITEM -->
                <?php 
				if ($img_topo -> execute()){
					while ($row = $img_topo -> fetch(PDO::FETCH_OBJ)){
							$img = str_replace("../", "", $row -> img_topo);
							$cod_img_topo = $row -> cod_img_topo;
					?>
						<div class="col-md-4">
							<div class="good-item text-center">
								 <div class="item-image-head">
									 <img width="258px" height="188px" src="<?php print $img;?>" alt="">
								 </div>
	
								 <div class="item-title">
									 <h4 class="text-uppercase"><?php print $row -> titulo;?></h4>
								 </div>
								 <div class="item-body">
									 <p><?php print $row -> texto;?></p>
								 </div>
								 <div>
									 <a href="img_produtos.php?cod_img_topo=<?php print $cod_img_topo;?>" class="awe-btn awe-btn-2 awe-btn-default text-uppercase">Saiba Mais</a>
								 </div>
							</div>
						</div>
                    <?php }

					}?>
                    <!-- END / GOOD ITEM -->
                </div>
            </div>
        </div>
        <div class="divider divider-2"></div>
    </section>
    <!-- END / GOOD FOOD -->
    
    <!-- OUR STORY -->
    <section id="produtos" class="our-story section">

        <div class="section-heading text-center">
            <!-- BACKGROUND -->
            <div class="awe-parallax bg-2"></div>
            <!-- END / BACKGROUND -->

            <!-- OVERLAY -->
            <div class="awe-overlay"></div>
            <!-- END / OVERLAY -->
            <div class="awe-title awe-title-1 wow fadeInUp" data-wow-delay=".3s">
                <h3 class="lg text-uppercase">Produtos</h3>
            </div>
        </div>

        <div class="section-content wow fadeInUp" data-wow-delay=".5s">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-lg-offset-5">
                        <div class="story-pager">
                        <?php 
						$img_inf_produto = $conn -> prepare ("SELECT * FROM img_inf_produto ORDER BY nome_produto") or die ("Erro na String 8.");
						$i = 0;
						if($img_inf_produto -> execute()){
							while($row = $img_inf_produto -> fetch(PDO::FETCH_OBJ)){?>
								<div class="item">
									<a data-slide-index="<?php print $i++;?>" href="#"><?php print $row -> nome_produto;?></a>
									<hr class="line">
								</div>
                        <?php }
						}?>                            
                        </div>
                    </div>
                </div>

                    <div class="story-slider-wrap">
                        <ul class="story-slider">
                        <?php 
						$img_inf_produto = $conn -> prepare ("SELECT * FROM img_inf_produto ORDER BY nome_produto") or die ("Erro na string SELECT 9.");
						if ($img_inf_produto -> execute ()){
							while($row = $img_inf_produto -> fetch(PDO::FETCH_OBJ)){
								$imagem = str_replace("../", "", $row -> img_inf_produto);
						?>
                            <li>
                                <div class="row">
                                    <div class="col-xs-4 col-sm-3 col-md-4">
                                        <div class="image-wrap">
                                            <img height="192px" width="192px" src="<?php print $imagem;?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-md-offset-1 col-lg-6">
                                        <div class="story-content">
                                            <h4 class="lg"><?php print $row -> nome_produto;?></h4>
                                            <p><?php print $row -> inf_produto;?></p>
                                        </div>                                        
                                    </div>
                                </div>
                            </li>
                        <?php }
						}?>
                        </ul>
                    </div>

            </div>
        </div>
        <div class="divider divider-2"></div>
    </section>
    <!-- END / OUR STORY -->

    <!-- THE MENU -->
    <section id="nossos_produtos" class="the-menu section">
        <div class="section-head text-center">
            <!-- BACKGROUND -->
            
            <!-- END / BACKGROUND -->

            <!-- OVERLAY -->
            <div class="awe-overlay"></div>
            <!-- END / OVERLAY -->
            <div class="awe-title awe-title-1 wow fadeInUp" data-wow-delay=".3s">
                <h3 class="lg text-uppercase">Nossos Produtos</h3>
            </div>
        </div><br />

        <div class="tabs-menu tabs-page">
            <div class="container">
                <ul class="nav-tabs text-center" role="tablist">
                    <li class="active"><a href="#processados" role="tab" data-toggle="tab">Processados</a></li>
                    <li><a href="#industrializados" role="tab" data-toggle="tab">Industrializados</a></li>
                </ul>
            </div>
        </div>

        <div class="section-content wow fadeInUp" data-wow-delay=".5s">
            <div class="container">
                <div class="tab-menu-content tab-content">
                    <!-- BREAKFAST -->
                    <div class="tab-pane fade in active" id="processados">
                        <div class="row">
                            <!-- THE MENU ITEM -->                         
                        <?php 
						if ($produtos_processados -> execute()){
							while ($row = $produtos_processados -> fetch(PDO::FETCH_OBJ)){
									$img_produtos_processados = str_replace("../", "", $row -> img_produto);?>
                                <div class="col-lg-6">
                                    <div class="the-menu-item">
                                        <div class="image-wrap">
                                            <img width="70px" height="70px" src="<?php print $img_produtos_processados;?>" alt="">
                                        </div>
                                        <div class="the-menu-body">
                                            <h4 class="xsm"><?php print $row -> nome_produto;?></h4>
                                            <p><?php print $row -> desc_produto;?></p>
                                        </div>
                                        <div class="prices">
                                            <span class="price xsm"><?php if (is_numeric($row -> preco_produto)) print "R$ ".$row -> preco_produto;?></span>
                                        </div>
                                    <?php if ($row -> status == "Destaque"){?>
                                        <div class="highlight">Destaque</div>
                                    <?php }?> 
                                </div>
                            </div>
                        <?php }
						}?> 
                            <!-- END / THE MENU ITEM -->
                        </div>                        
                    </div>
                    <!-- END / BREAKFAST -->

                    <!-- LUNCH -->
                    <div class="tab-pane fade" id="industrializados">
                        <div class="row">

                            <!-- THE MENU ITEM -->
                        <?php 
						if ($produtos_industrializados -> execute()){
							while($row = $produtos_industrializados -> fetch(PDO::FETCH_OBJ)){
									$img_produtos_industrializados = str_replace("../", "", $row -> img_produto);?>
								<div class="col-lg-6">
									<div class="the-menu-item">
										<div class="image-wrap">
											<img src="<?php print $img_produtos_industrializados;?>" width="70px" height="70px" alt="">
										</div>
										<div class="the-menu-body">
											<h4 class="xsm"><?php print $row -> nome_produto;?></h4>
											<p><?php print $row -> desc_produto;?></p>
										</div>
										<div class="prices">
											<span class="price xsm"><?php print "R$ ".$row -> preco_produto;?></span>
										</div>
										<?php if ($row -> status == "Destaque"){?>
												<div class="highlight">Destaque</div>
										<?php }?> 
									</div>
								</div>
                        <?php }
						}?>
                            <!-- END / THE MENU ITEM -->
                        </div>
                    </div>
                    <!-- END / LUNCH -->
                </div>
            </div>
        </div>
    </section>
    <!-- END / THE MENU -->    

    <!-- THE STAFF -->
    <section id="the-staff" class="the-staff section">
            <div class="container">     
                <!-- WE ARE HIRING -->
                <div class="we-are-hiring wow fadeInUp" data-wow-delay=".3s">
                    <div class="awe-color"></div>
                    <div class="tb">
                        <div class="hiring-title tb-cell">
                            <h4 class="sm text-uppercase">AREA DE CLIENTES</h4>
                        </div>

                        <div class="hiring-body tb-cell">
                            <p>Faça o acesso ao sistema e realize seus pedidos.</p>
                        </div>

                        <div class="hiring-link tb-cell">
                            <a href="adm_pedido/login.php" target="_blank" class="awe-btn awe-btn-1 awe-btn-default text-uppercase">ENTRAR</a>
                        </div>
                    </div>
                </div>
                <!-- END / WE ARE HIRING -->
            </div> 
    </section>
    <!-- END / THE STAFF -->

    <!-- CONTACT US -->
    <section id="contato" class="contact section">

        <div class="contact-first">

            <!-- OVERLAY -->
            <div class="awe-overlay overlay-default"></div>
            <!-- END / OVERLAY -->
            
            <div class="section-content wow fadeInUp" data-wow-delay=".3s">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="contact-body text-center">
                                <h3 class="lg text-uppercase">CONTATO</h3>
                                <hr class="_hr">
                                <address class="address-wrap">
                                <?php if($contato -> execute()){
										$row = $contato -> fetch(PDO::FETCH_OBJ);?>
                                        <span class="address"><?php print $row -> endereco;?></span>
                                        <span class="address"><?php print $row -> email;?></span>
                                        <span class="phone"><?php print $row -> telefone;?></span>
                                <?php }?>
                                </address>
                            </div>

                            <div class="see-map text-center">
                                <a href="#" data-see-contact="Procurar Localização" data-see-map="Procurar Localização" class="awe-btn awe-btn-5 awe-btn-default text-uppercase"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MAP -->
            <div id="map" data-map-zoom="14" data-map-latlng="-16.5056, -49.4202" data-snazzy-map-theme="grayscale" data-map-marker="images/marker.png" data-map-marker-size="200*60"></div>
            <!-- END / MAP -->
        </div>

        <div class="contact-second tb">
            <!-- FORMULARIO CONTATO -->
            <div class="tb-cell">
                <div class="contact-form contact-form-1">
                    <div class="inner wow fadeInUp" data-wow-delay=".3s">
                        <form id="send-message-form" action="mail/email.php" method="post">
                        	<div class="form-group form-item">
                                <select name="situacao" id="situacao">
                                	<option value="" selected>Você é cliente?</option>
                                	<option value="Sim">Sim</option>
                                    <option value="Não">Não</option>
                                </select>
                            </div>
                            <div class="form-group form-item">
                                <select name="assunto" id="assunto">
                                	<option value="Contato" selected>Contato</option>
                                    <option value="Reclamação">Reclamação</option>
                                    <option value="Agradecimento">Agradecimento</option>
                                </select>
                            </div>
                            <div class="form-item form-textarea">
                                <textarea placeholder="Menssagem..." name="message" id="message"></textarea>
                            </div>
                            <div class="form-item form-type-name">
                                <input type="text" placeholder="Nome" name="name" id="name">
                            </div>
                            <div class="form-item form-type-email">
                                <input type="text" placeholder="E-mail" name="email" id="email">
                            </div>
                            <div class="clearfix"></div>
                            
                            
                            <div class="form-actions text-center">
                                <input type="submit" value="Enviar Email" class="contact-submit awe-btn awe-btn-6 awe-btn-default text-uppercase">
                            </div>
                            
                            <div id="contact-content"></div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- FIM / FORMULARIO CONTATO -->
        
            <!-- NEWS LETTER -->
            <div class="tb-cell">
                <div class="news-letter text-center">
                    <div class="inner wow fadeInUp" data-wow-delay=".6s">
                        <div class="letter-heading">
                            <h4 class="sm text-uppercase">CLIENTE - SOLICITE JÁ SEU ACESSO</h4>
                            <p>Envie-nos um e-mail, em breve entraremos em contato para realizar seu cadastro em nosso sistema.</p>
                        </div>
                        <form id="send-message-form form-type-name" action="mail/email.php" method="post">
                            <div class="form-item">
                                <input type="text" placeholder="E-mail" id="email" name="email">
                            </div>
                            <div class="form-item form-type-email">
                                <input type="text" onKeyPress="mascara(this);" maxlength="14" placeholder="Telefone" id="telefone" name="telefone">
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Solicitar" id="inscrever" name="inscrever" class="awe-btn awe-btn-2 awe-btn-default text-uppercase">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END / NEWS LETTER -->
        </div>

    </section>

    <!-- END / CONTACT US -->


    <!-- FOOTER -->
    <footer id="footer" class="footer">
        <div class="divider divider-1 divider-color"></div>
        <div class="awe-color"></div>
        <div class="container">
            <div class="copyright text-center">
                ©2015 Hortaliça San Diego
            </div>
        </div>
    </footer>
    <!-- END / FOOTER -->
    

</div>
<!-- END / PAGE WRAP -->
<?php $conn = NULL;?>

<!-- LOAD JQUERY -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<!-- GOOGLE MAP -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/lib/bootstrap.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.easing.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.owl.carousel.min.js"></script>
<script type="text/javascript" src="js/lib/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="js/lib/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="js/lib/retina.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.form.min.js"></script>
<script type="text/javascript" src="js/lib/jquery.validate.min.js"></script>


<!-- ANIMATION -->
<script type="text/javascript" src="js/lib/jquery.wow.min.js"></script>
<script type="text/javascript">

    /*==============================
        Is mobile
    ==============================*/
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    }

    if (isMobile.any()) {
    } else {
        new WOW().init();
    }
</script>

<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>