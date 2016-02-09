<?php

class ArtistaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','search','especialidad','espxartista'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin',),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            //$modelEspecxartista = Artista::model()->with('especialidadxartistas')->findAll('idartista=:id',array(':id'=>$id));
                $model = Artista::model()->with('imagenxartistas')->findall('idartista=:id',array(':id'=>$id));
                if(empty($model)){
                    $model = Artista::model()->findall('id=:id',array(':id'=>$id));
                }

                $this->render('view',array(
			//'model'=>$this->loadModel($id),
                        'model'=>$model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Artista;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Artista']))
		{
			$model->attributes=$_POST['Artista'];
                        $rnd = rand(0,9999);  // generate random number between 0-9999
                        $uploadedFile=CUploadedFile::getInstance($model,'image');
                        $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
                        $model->image = $fileName;
                        $model->imagen = $fileName;
                        $model->password=md5($model->password);
			if($model->save()){
                                $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/imagenesartistas/'.$fileName);
				$this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
		$modelArtista=$this->loadModel($id);
                $modelEspecxartista = Artista::model()->with('especialidadxartistas')->findAll('idartista=:id',array(':id'=>$id));
                $modelEspecxartista2 = Especialidadxartista::model()->findAll('idartista=:id',array(':id'=>$id));//para salvar los datos
                $modelEspecialidades = Especialidad::model()->findAll();   
                $modelImagenes = Imagenxartista::model()->findAll('idartista=:id',array(':id'=>$id));
                $countImages = count($modelImagenes);
                $password = $modelArtista->password;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);   
                if($id == Yii::app()->user->getId()){
                Yii::app()->session['idartista'] = $id;
                $rutaAntigua =  "uploads\imagenesartistas\small\\".$modelArtista->imagen;
                $rutaNueva =    "images\uploads\artistas\\".$modelArtista->id."\perfil\\". $modelArtista->imagen;
                    if((isset($_POST['Artista'])) || (isset($_POST['Especialidad']))){  
                            $modelArtista->attributes=$_POST['Artista'];
                            $uploadedFile=CUploadedFile::getInstance($modelArtista,'image');
                            if(!empty($uploadedFile)){
                                if (file_exists($rutaAntigua)){
                                    unlink(Yii::app()->basePath.'\..\\'.$rutaAntigua);
                                }else if (file_exists($rutaNueva)){
                                    unlink(Yii::app()->basePath.'\..\\'.$rutaNueva);
                                }
                                $modelArtista->imagen = $uploadedFile->name;
                            }
                            //var_dump($_POST["curriculum"]);
                            //Hacer que el password no se elimine con el guardado
                            if($password == $modelArtista->password){
                                $modelArtista->password = $password;
                            }
                            else{
                                $modelArtista->password=md5($modelArtista->password);
                            }
                            if($modelArtista->fecha_nacimiento==''){
                                $modelArtista->fecha_nacimiento=NULL;
                            }

                            $modelArtista->fecha_artista = $_POST['modelArtista'];
                            $modelArtista->presentacion = $_POST['presentacion'];
                            $modelArtista->curriculum = $_POST['curriculum'];
 
                            if($modelArtista->save()){
                                if(!empty($uploadedFile)){
                                    $uploadedFile->saveAs(Yii::app()->basePath.'/../images/uploads/artistas/'.$modelArtista->id.'/perfil/'.$modelArtista->imagen);
                                    //Yii::app()->baseUrl ."/images/uploads/artistas/".$modelArtista->id."/perfil/". $modelArtista->imagen ;
                                }
                                if(!empty($modelEspecxartista2)){
                                   $qD = "DELETE FROM `especialidadxartista`
                                            WHERE idartista={$id}";
                                   $cmdD = Yii::app()->db->createCommand($qD);
                                   $cmdD->execute();
                                }
                                
                                foreach( $_POST['nombre'] as $esp){
                                    if(intval($esp) !== 0){
                                        $intVal = intval($esp);
                                        $qI = "INSERT INTO `especialidadxartista` (idartista, idespecialidad)
                                        VALUES ({$modelArtista->id}, :idespecialidad);";
                                        $cmdI = Yii::app()->db->createCommand($qI);
                                        $cmdI->bindParam(':idespecialidad', $intVal , PDO::PARAM_INT);
                                        $cmdI->execute();
                                    }
                                }
                                //$this->redirect(array('view','id'=>$modelArtista->id));
                            }
                    }
                    $modelEspecxartista2 = Especialidadxartista::model()->findAll('idartista=:id',array(':id'=>$id));//para salvar los datos
                    $this->render('update',array(
                                'modelArtista'=>$modelArtista,
                                'modelEspecxartista'=>$modelEspecxartista,
                                'modelEspecxartista2'=>$modelEspecxartista2,
                                'modelEspecialidades'=>$modelEspecialidades,
                                'countImages'=>$countImages,
                        )); 
                }
                else
                {
                    throw new CHttpException(401,'No estas autorizado a acceder a este perfil.');
                }
            }
        
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                
		$dataProvider=new CActiveDataProvider('Artista');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
        public function actionSearch()
	{
		$model=new Artista('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Artista']))
			$model->attributes=$_GET['Artista'];

		$this->render('busqueda',array(
			'model'=>$model,
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Artista('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Artista']))
			$model->attributes=$_GET['Artista'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Artista the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Artista::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Artista $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='artista-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionEspecialidad($id,$esp)
        {
            $dataProvider = new CActiveDataProvider('Artista',array(
                                                                    'criteria'=>array(
                                                                        'join'=>'INNER JOIN especialidadxartista e ON e.idartista = t.id',
                                                                        'order'=>'t.apellido ASC',
                                                                        'condition'=>'e.idespecialidad='.$id. ' AND t.activo=1',
                                                                    )
                                                                    ));
             /*$resp = array('dataProvider'=>$dataProvider);
            echo CJavaScript::jsonEncode($resp);
            Yii::app()->end();*/
		$this->render('index_espxart',array(
			'dataProvider'=>$dataProvider,
                        'esp'=>$esp,
                        'id'=>$id,
		));
            //$model = Especialidadxartista::model()->with('idartista0')->findAll('idespecialidad=:id',array(':id'=>$id));

            /*$this->renderPartial('/Especialidadxartista/_form_especialidadxartista',array(
			'model'=>$model,
		));*/
        }
        public function actionEspxartista($id,$esp)
        {
            $model = Especialidadxartista::model()->with('idartista0')->together()->findAll('idespecialidad=:id',array(':id'=>$id));
            $dataProvider = new CActiveDataProvider('Artista',array(
                                                                    'criteria'=>array(
                                                                        'join'=>'INNER JOIN especialidadxartista e ON e.idartista = t.id',
                                                                        'order'=>'t.apellido ASC',
                                                                        'condition'=>'e.idespecialidad='.$id. ' AND t.activo=1',
                                                                    )
                                                                    ));
            $this -> render ( 'index_espxart' , array (
            'dataProvider' => $dataProvider,
            'esp'=>$esp,
            'id'=>$id,
                )); 
            //Yii::app()->end();
            /*$resp = array('dataProvider'=>$dataProvider,'id'=>'13');
            echo CJavaScript::jsonEncode($resp);
            Yii::app()->end();*/
        }
}
