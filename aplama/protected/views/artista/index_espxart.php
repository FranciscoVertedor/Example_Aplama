<?php
/* @var $this EspecialidadxartistaController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - Especialidad Artista '. $esp;
$this->breadcrumbs=array(
        'Artistas',
	$esp,
);
?>
<h1 class="cabeceraTitulosMenu">Artistas </h1>
<div class="linksEspecialidades">
<?php
    
    if($id == "13"){
        echo CHtml::link('Pintura', Yii::app()->createUrl("artista/espxartista/",array('id'=>'13','esp'=>'Pintura')),array('class'=>'activeEspecialidad', 'id'=>'13'));
    }
    if($id == "14"){
        echo CHtml::link('Escultura', CController::createUrl('/artista/espxartista/',array('id'=>'14','esp'=>'Escultura')),array('class'=>'activeEspecialidad', 'id'=>'14'));
    }
    if($id == "15"){
        echo CHtml::link('Dibujo', CController::createUrl('/artista/espxartista/',array('id'=>'15','esp'=>'Dibujo')),array('class'=>'activeEspecialidad', 'id'=>'15'));
    }
    if($id == "16"){
        echo CHtml::link('Acuarela', CController::createUrl('/artista/espxartista/',array('id'=>'16','esp'=>'Acuarela')),array('class'=>'activeEspecialidad', 'id'=>'16'));
    }
    if($id == "17"){
        echo CHtml::link('Grabado', CController::createUrl('/artista/espxartista/',array('id'=>'17','esp'=>'Grabado')),array('class'=>'activeEspecialidad', 'id'=>'17'));
    }
    if($id == "18"){
        echo CHtml::link('Fotografía', CController::createUrl('/artista/espxartista/',array('id'=>'18','esp'=>'Fotografía')),array('class'=>'activeEspecialidad', 'id'=>'18'));
    }
    if($id == "19"){
        echo CHtml::link('Instalación', CController::createUrl('/artista/espxartista/',array('id'=>'19','esp'=>'Instalación')),array('class'=>'activeEspecialidad', 'id'=>'19'));
    }
    if($id == "20"){
        echo CHtml::link('Digital',  CController::createUrl('/artista/espxartista/',array('id'=>'20','esp'=>'Digital')),array('class'=>'activeEspecialidad', 'id'=>'20'));
    }
?>
</div>
<?php 
    $this -> renderPartial ( '_list_espxart' , array (
            'dataProvider' => $dataProvider,
            )); 
?>
<script type="text/javascript">  
                            jQuery(function(){
                                    $(".enlaceEspecialidad").click(function(){
                                        var id = $(this).attr("id");
                                        $("#"+id).addClass("activeEspecialidad");
                                    })
                            });
</script>
