<?php
/* @var $this ArtistaController */
/* @var $model Artista */
$this->pageTitle=Yii::app()->name . ' - Perfil '. $model[0]['nombre']." ".$model[0]['apellido'];
$this->breadcrumbs=array(
	$model[0]['nombre']." ".$model[0]['apellido'],
         //$model->nombre." ". $model->apellido,
);
//var_dump($model[0]['imagenxartistas']);exit;
/*$this->menu=array(
	array('label'=>'List Artista', 'url'=>array('index')),
	array('label'=>'Create Artista', 'url'=>array('create')),
	array('label'=>'Update Artista', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Artista', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Artista', 'url'=>array('admin')),
);*/
?>

<div class="containerArtista">
<?php 
    $rutaAntiguaPerfil  =  "uploads/imagenesartistas/" . $model[0]['imagen'];
    $rutaNuevaPerfil    =  "images/uploads/artistas/".$model[0]['id']."/perfil/". $model[0]['imagen'];
    $rutaNoPerfil =  "images/uploads/artistas/no_perfil.png";
    //echo "<div class='txtcls' id='anvent'> </div>";
    if((file_exists($rutaAntiguaPerfil))&&($rutaAntiguaPerfil != "uploads/imagenesartistas/")){
        echo "<div class='imgPerfilArtista'>".CHtml::image(Yii::app()->baseUrl."/".$rutaAntiguaPerfil,'alt',array('width'=>'160','height'=>'auto'))."</div>";
    }else if(file_exists($rutaNuevaPerfil)){
        echo "<div class='imgPerfilArtista'>".CHtml::image(Yii::app()->baseUrl."/".$rutaNuevaPerfil,'alt',array('width'=>'160','height'=>'auto',htmlOptions=>array('class'=>'imgPerfilArtista')))."</div>";
        //echo CHtml::image(Yii::app()->baseUrl."/".$rutaNueva,'alt',array('width'=>'100','height'=>'100')); 
    }else{
        echo "<div class='imgPerfilArtista'>".CHtml::image(Yii::app()->baseUrl."/".$rutaNoPerfil,'alt',array('width'=>'160','height'=>'auto',htmlOptions=>array('class'=>'imgPerfilArtista')))."</div>";
    }
    ?>
    <fieldset class="fieldsetArtista">
        
    <?php
    echo "<div class='infoArtista'>";
    if(!empty($model[0]['nombre'])){
        echo "<div class='headDetalleArtista'>Nombre:</div><div class='bodyDetalleArtista'>".$model[0]['nombre']."</div>";
    }else{
        echo "<div class='headDetalleArtista'>Nombre:</div><div class='bodyDetalleArtista'>-</div>";
    }
    if(!empty($model[0]['apellido'])){
        echo "<div class='headDetalleArtista'>Apellido:</div><div class='bodyDetalleArtista'>".$model[0]['apellido']."</div>";
    }else{
        
        echo "<div class='headDetalleArtista'>Apellido:</div><div class='bodyDetalleArtista'>-</div>";
    }
    if(!empty($model[0]['residencia'])){
        echo "<div class='headDetalleArtista'>Residencia:</div><div class='bodyDetalleArtista'>".$model[0]['residencia']."</div>";
    }else{
        
        echo "<div class='headDetalleArtista'>Residencia:</div><div class='bodyDetalleArtista'>-</div>";
    }
    if(!empty($model[0]['email'])){
        echo "<div class='headDetalleArtista'>Email:</div><div class='bodyDetalleArtista'>".$model[0]['email']."</div>";
    }else{
        echo "<div class='headDetalleArtista'>Email:</div><div class='bodyDetalleArtista'>-</div>";
    }
    if(!empty($model[0]['telefono'])){
        echo "<div class='headDetalleArtista'>Teléfono:</div><div class='bodyDetalleArtista'>".$model[0]['telefono']."</div>";
    }else{
        echo "<div class='headDetalleArtista'>Teléfono:</div><div class='bodyDetalleArtista'>-</div>";
    }
    if(!empty($model[0]['web'])){
        echo "<div class='headDetalleArtista'>Web:</div><div class='bodyDetalleArtista'>";
        echo CHtml::link($model[0]['web'],"http://".$model[0]['web'],array('target'=>'_blank'));
        echo "</div>";
    } else{
        echo "<div class='headDetalleArtista'>Web:</div><div class='bodyDetalleArtista'>-</div>";
    }
    echo "</div>";
    echo "<div class='cartas'>
            ";
            foreach($model[0]['imagenxartistas'] as $imagen){
                $rutaAntiguaImagen =  "uploads/imagenesartistas/".$imagen['imagen'];
                $rutaNuevaImagen =    "images/uploads/artistas/".$model[0]['id']."/galeria/". $imagen['imagen'] ; 
                if(file_exists($rutaAntiguaImagen)){
                    echo "<a href='".Yii::app()->baseUrl."/".$rutaAntiguaImagen."' class='carta' data-lightbox='imagenesArtista' >".CHtml::image(Yii::app()->baseUrl."/".$rutaAntiguaImagen,'alt',array('class'=>'carta'),array('width'=>'200','height'=>'auto'))."</a>";
                }else if(file_exists($rutaNuevaImagen)){
                    echo "<a href='".Yii::app()->baseUrl."/".$rutaNuevaImagen."' class='carta' data-lightbox='imagenesArtista' >".CHtml::image(Yii::app()->baseUrl."/".$rutaNuevaImagen,'alt',array('class'=>'carta'),array('width'=>'200','height'=>'auto'))."</a>";
                }
            }
    echo "</div>";
    ?>
    </fieldset>
<?php
    if(!empty($model[0]['presentacion'])){
        echo "<div class='headInfoArtista'>Presentación</div><div class='bodyInfoArtista'>".$model[0]['presentacion']."</div>";
    }
    if(!empty($model[0]['curriculum'])){
        echo "<div class='headInfoArtista'>Curriculum</div><div class='bodyInfoArtista'>".$model[0]['curriculum']."</div>";
    }
 ?>
    </div>
    <script>
        $(document).ready(function($){
            
           $( window ).resize(function() {
               var ventana_ancho = $(window).width();
                $( "#anvent" ).html( "<div>" + ventana_ancho + "</div>" );
           });
        });
    </script>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/lightbox/lightbox.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/lightbox/lightbox.min.js',CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/pilaImagesGaleria/custom.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/pilaImagesGaleria/pila.css'); ?>
<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'apellido',
		'fecha_nacimiento',
		'especialidad',
		'residencia',
		'presentacion',
		'activo',
		'curriculum',
		'email',
		'web',
		'imagen',
		//'password',
		'usuario',
		'usuario_url',
		'telefono',
	),
)); */?>
