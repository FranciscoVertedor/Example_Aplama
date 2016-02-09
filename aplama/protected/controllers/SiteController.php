<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'

		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";
				if(mail(Yii::app()->params['adminEmail'],$subject,
                                        "\tNombre:    ".$model->name."\n==========================================\n\n ".
                                        "\tTeléfono:  ".$model->phone."\n".
                                        "\tEmail:     ".$model->email."\n".
                                        "\tMensaje:   ".$model->body,$headers)){
                                    Yii::app()->user->setFlash('contact','Gracias por contactarnos. Le responderemos tan pronto sea posible');
                                }else{
                                    Yii::app()->user->setFlash('Error','No se pudo mandar el mensaje');
                                }
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin($mensaje='')
	{
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
                            $id = Yii::app()->user->getId();
                            $this->redirect(array('/artista/update','id'=>$id));
				//$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
                if($mensaje == 'reset'){
                    $mensaje = "Un email ha sido enviado con sus datos de acceso.";
                    $this->render('login',array('model'=>$model,'mensaje'=>$mensaje));
                }else{
                    $this->render('login',array('model'=>$model));
                }
		
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
        
        public function getToken($token)
        {
            $model=Artista::model()->findByAttributes(array('token'=>$token));
            if($model===null)
                throw new CHttpException(404,'La página solicitada no existe.');
            return $model;
        }
 
 
        public function actionVertoken($token)
        {
            //var_dump($token);exit;
            $direccion =  Yii::app()->getBaseUrl(true);
            $model=$this->getToken($token);
            $getEmail = $model->email;
            $getUsuario = $model->usuario;
            $namaPengirim="APLAMA";
            $emailadmin="info@aplama.com";
            $subjek="Datos de acceso a APLAMA";
            if(isset($_POST['Ganti']))
            {
                if($model->token==$_POST['Ganti']['tokenhid']){
                    $model->password=md5($_POST['Ganti']['password']);
                    $model->token="null";
                    $model->save(true,array('password','token'));
                    $setpesan="
                        Hola ". $model->nombre ." <br> Estos son sus datos de acceso: <br><br> Usuario: ". $model->usuario ." <br>Contraseña cambiada recientemente. <br><br> 
                        Acceda al siguiente link para acceder al sitio <br><br>
                        <a href= '". $direccion.Yii::app()->createUrl("site/login"). "'>Click aqui para acceder al sitio</a>";
                    if($model->existEmail($getEmail))
                    {
                        $name='=?UTF-8?B?'.base64_encode($namaPengirim).'?=';
                        $subject='=?UTF-8?B?'.base64_encode($subjek).'?=';
                        $headers="From: $name <{$emailadmin}>\r\n".
                            "Reply-To: {$emailadmin}\r\n".
                            "MIME-Version: 1.0\r\n".
                            "Content-type: text/html; charset=UTF-8";
                        
                        mail($getEmail,$subject,$setpesan,$headers);
                    }
                    $this->redirect(Yii::app()->createUrl('/site/login/',array('mensaje'=>'reset')));
                    $this->refresh();
                }
            }
            $this->render('verifikasi',array(
                'model'=>$model,
            ));
        }
 
 
        public function actionForgot()
        {
                $direccion =  Yii::app()->getBaseUrl(true);

                if(isset($_POST['Lupa']))
                {
                    $getEmail=$_POST['Lupa']['email'];
                    $getModel= Artista::model()->findByAttributes(array('email'=>$getEmail));
                    $getToken=rand(0, 99999);
                    $getTime=date("H:i:s");
                    $getModel->token=md5($getToken.$getTime);
                    $namaPengirim="APLAMA";
                    $emailadmin="info@aplama.com";
                    $subjek="Restablecer contraseña APLAMA";
                    $token = $getModel->token;
                    $link = $direccion.Yii::app()->createUrl("site/vertoken",array('token'=>$getModel->token));
                    $setpesan="Acceda al siguiente link para restablecer su contraseña<br/>
                        <a href= '".$direccion.Yii::app()->createUrl("site/vertoken",array('token'=>$getModel->token))."'>Click aqui para restaurar su contraseña</a>";
                    $type = get_class($getModel);
                    if($type == "Artista"){
                        if($getModel->existEmail($getEmail))
                        {
                            $name='=?UTF-8?B?'.base64_encode($namaPengirim).'?=';
                            $subject='=?UTF-8?B?'.base64_encode($subjek).'?=';
                            $headers="From: $name <{$emailadmin}>\r\n".
                                "Reply-To: {$emailadmin}\r\n".
                                "MIME-Version: 1.0\r\n".
                                "Content-type: text/html; charset=UTF-8";
                            $getModel->token = $token;
                            if($getModel->save(true, array('token'))){
                                mail($getEmail,$subject,$setpesan,$headers);
                                $mensaje = 'Un link para cambiar su contraseña ha sido enviado a su email';
                            }else{
                                $mensaje = 'Ha habido un error al intentar cambiar la contraseña';
                            }
                            $this->render('forgot',array('mensaje'=>$mensaje));
                        }
                        else{
                           $mensaje = "El usuario no se ha validado"; 
                        }
                    }else{
                        $mensaje = "El email introducido no existe";
                    }
                }
            $this->render('forgot',array('mensaje'=>$mensaje));
        }
}
