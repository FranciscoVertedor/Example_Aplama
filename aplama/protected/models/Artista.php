<?php

/**
 * This is the model class for table "artista".
 *
 * The followings are the available columns in table 'artista':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $fecha_nacimiento
 * @property string $fecha_artista
 * @property string $especialidad
 * @property string $residencia
 * @property string $presentacion
 * @property integer $activo
 * @property string $curriculum
 * @property string $email
 * @property string $web
 * @property string $imagen
 * @property string $password
 * @property string $usuario
 * @property string $usuario_url
 * @property string $telefono
 * @property string $token
 *
 * The followings are the available model relations:
 * @property Especialidadxartista[] $especialidadxartistas
 * @property Imagenxartista[] $imagenxartistas
 */
class Artista extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $image;
	public function tableName()
	{
		return 'artista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, email, curriculum, token,usuario', 'required'),
			array('activo', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido, especialidad, residencia, email, web, imagen, password, usuario, usuario_url', 'length', 'max'=>255),
                        array('fecha_nacimiento, fecha_artista', 'length', 'max'=>15),
			array('telefono', 'length', 'max'=>100),
                        array('image', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true, 'on'=>'update'), // this will allow empty field when page is update (remember here i create scenario update)
                        array('token', 'length', 'max'=>150),
                        
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nombre, apellido, fecha_nacimiento, fecha_artista, especialidad, residencia, presentacion, activo, curriculum, email, web, imagen, password, usuario, usuario_url, telefono', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'especialidadxartistas' => array(self::HAS_MANY, 'Especialidadxartista', 'idartista'),
			'imagenxartistas' => array(self::HAS_MANY, 'Imagenxartista', 'idartista'),
		);
	}
        public function existEmail($email){
            return $email == Artista::model()->exists('email=:email',array('email'=>$email));
        }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'fecha_artista' => 'Fecha Artista',
			'especialidad' => 'Especialidad',
			'residencia' => 'Residencia',
			'presentacion' => 'Presentacion',
			'activo' => 'Activo',
			'curriculum' => 'Curriculum',
			'email' => 'Email',
			'web' => 'Web',
			'imagen' => 'Imagen',
			'password' => 'Password',
			'usuario' => 'Usuario',
			'usuario_url' => 'Usuario Url',
			'telefono' => 'Telefono',
                        'token' => 'Token',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('fecha_artista',$this->fecha_artista,true);
		$criteria->compare('especialidad',$this->especialidad,true);
		$criteria->compare('residencia',$this->residencia,true);
		$criteria->compare('presentacion',$this->presentacion,true);
		$criteria->compare('activo',$this->activo);
		$criteria->compare('curriculum',$this->curriculum,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('web',$this->web,true);
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('usuario_url',$this->usuario_url,true);
		$criteria->compare('telefono',$this->telefono,true);
                $criteria->compare('token',$this->token,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Artista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function validatePassword($password)
        {
            return $this->hashPassword($password) === $this->password;
        }
        public function hashPassword($password)
        {
            return md5($password);
        }
}
