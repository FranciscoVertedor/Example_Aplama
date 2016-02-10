<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="es" />
        
	<!-- blueprint CSS framework -->

        <?php
        echo Yii::app()->bootstrap->registerAllCss();
        echo Yii::app()->bootstrap->registerCoreScripts();
        Yii::app()->clientScript->registerCoreScript('jquery'); 

        ?>
         
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', '', '');
		  ga('send', 'pageview');
	</script>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.png" type="image/x-icon" />
</head>

<body>
<div id="header">	

                <?php 
                        $id = Yii::app()->user->getId();
                ?>
                <?php
                 $items = array(
                array(
                'url' => Yii::app()->baseUrl."/images/img-cabecera/1.jpg",
                'src' => Yii::app()->baseUrl."/images/img-cabecera/1.jpg",
                'options' => array('title' => '')
                ),
                array(
                'url' => Yii::app()->baseUrl."/images/img-cabecera/2.jpg",
                'src' => Yii::app()->baseUrl."/images/img-cabecera/2.jpg",
                'options' => array('title' => '')
                ),
                array(
                'url' => Yii::app()->baseUrl."/images/img-cabecera/3.jpg",
                'src' => Yii::app()->baseUrl."/images/img-cabecera/3.jpg",
                'options' => array('title' => '')
                ),
                array(
                'url' => Yii::app()->baseUrl."/images/img-cabecera/4.jpg",
                'src' => Yii::app()->baseUrl."/images/img-cabecera/4.jpg",
                'options' => array('title' => '')
                ),
                array(
                'url' => Yii::app()->baseUrl."/images/img-cabecera/5.jpg",
                'src' => Yii::app()->baseUrl."/images/img-cabecera/5.jpg",
                'options' => array('title' => '')
                ),
                );
                 $this->widget('yiiwheels.widgets.gallery.WhCarousel', array('items' => $items));
                ?>
        <!-- </div>-->
</div><!-- header -->
<div class="container" id="page">

	
	<div id="mainmenu">
		<?php $this->widget('bootstrap.widgets.TbNavbar',array(
                    'collapse'=>true,
                    'brand'=>CHtml::image(Yii::app()->getBaseUrl().'../images/img-cabecera/logo.png'),
                    'items'=>array(
                        array(
                            'class'=>'bootstrap.widgets.TbNav',
                            
                            'items'=>array(
                                array('label'=>'Eventos', 'url'=>array('/eventos/index')),
                                array('label'=>'Artistas', 'url'=>array(''),'items'=>array(
                                            array('label'=>'pintura', 'url'=>array('/artista/especialidad','id'=>'13','esp'=>'Pintura')),
                                            array('label'=>'escultura', 'url'=>array('/artista/especialidad','id'=>'14','esp'=>'Escultura')),
                                            array('label'=>'dibujo', 'url'=>array('/artista/especialidad','id'=>'15','esp'=>'Dibujo')),
                                            array('label'=>'acuarela', 'url'=>array('/artista/especialidad','id'=>'16','esp'=>'Acuarela')),
                                            array('label'=>'grabado', 'url'=>array('/artista/especialidad','id'=>'17','esp'=>'Grabado')),
                                            array('label'=>'fotografía', 'url'=>array('/artista/especialidad','id'=>'18','esp'=>'Fotografía')),
                                            array('label'=>'instalación', 'url'=>array('/artista/especialidad','id'=>'19','esp'=>'Instalacións')),
                                            array('label'=>'digital', 'url'=>array('/artista/especialidad','id'=>'20','esp'=>'Digital')),
                                )),
                                array('label'=>'Enlaces', 'url'=>array('/url/index')),
                                array('label'=>'Nosotros', 'url'=>array('/site/page', 'view'=>'about')),
                                array('label'=>'Contacto', 'url'=>array('/site/contact')), 
                                array('label'=>'Editar Perfil', 'url'=>array('/artista/update','id'=>$id), 'visible'=>!Yii::app()->user->isGuest),
                                array('label'=>'Entrar', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                                array('label'=>'Salir', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                                '<ul class="nav pull-right">
                                    <form action="'.Yii::app()->createUrl('/artista/search').'" class="navbar-search pull-left">
                                        <input name="Artista[apellido]" type="text"  placeholder="Buscar por apellidos" class="search-query span2">
                                    </form>
                                </ul>',
                            ),
                        )),
                    )); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links' =>   $this->breadcrumbs,
                        'homeLink'=>   CHtml::link('Inicio', array('Site/index'))
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>
                        
        <div class="pusher"></div>
        <div class ="foot_mancha">
        </div>
    <div id="footer">
        
                <div class="copyright">
                    Copyright &copy; <?php echo date('Y'); ?> APLAMA
                   Todos los derechos reservados.
                </div>
                <div class="facebookIcon">
                    <a class="linkFacebook"href="https://www.facebook.com/asociacion.deartistasaplama" target="_blank"></a>
                </div>
                <div class="logosFooter">
                    <img class="imgLogosFooterRTVA" />
                    <img class="imgLogosFooterCajamar"  />
                    <img class="imgLogosFooterCorteIngles" />
                    <img class="imgLogosFooterUma"  />
                    <img class="imgLogosFooterUnicaja"  />
                    <img class="imgLogosFooterJAndalucia" />
                    <img class="imgLogosFooterAyunMalaga" />
                    <img class="imgLogosFooterMolina" />
                    <img class="imgLogosFooterCEM"  />
                    <img class="imgLogosFooterSur"  />
                </div>
    </div><!-- footer -->
	

</div><!-- page -->

</body>
    
</html>
<?php
echo Yii::app()->bootstrap->registerCoreScripts();
 Yii::app()->clientScript->registerCoreScript('jquery'); 
?>
<script>
   
    $(function() {
        var nav = $(".navbar-fixed-top");
        var altura = nav.offset().top;
        $(".dropdown").hover(
            function(){ $(this).addClass('open') },
            function(){ $(this).removeClass('open') }
        );   
        $(".dropdown").click(
            function(){ $(this).addClass('open') },
            function(){ $(this).removeClass('open') }
        ); 
        $(window).scroll(function(){
            $(".navbar-fixed-top").css("margin-top","0");
            $(".navbar-fixed-top").css("position","fixed");
                         
        });
    });
</script>
