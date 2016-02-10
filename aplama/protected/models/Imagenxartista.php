<?php

/**
 * This is the model class for table "imagenxartista".
 *
 * The followings are the available columns in table 'imagenxartista':
 * @property integer $id
 * @property integer $idartista
 * @property string $imagen
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Artista $idartista0
 */
class Imagenxartista extends CActiveRecord
{
        public $file;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'imagenxartista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('id, idartista, imagen, descripcion', 'safe', 'on'=>'search'),
			array('idartista', 'numerical', 'integerOnly'=>true),
			array('imagen', 'length', 'max'=>255),
			array('descripcion', 'safe'),
                        array('file', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true), // this will allow empty field when page is update (remember here i create scenario update)
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
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
			'idartista0' => array(self::BELONGS_TO, 'Artista', 'idartista'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idartista' => 'Idartista',
			'imagen' => 'Imagen',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('idartista',$this->idartista);
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Imagenxartista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function afterSave( ) {
            $this->addImages( );
            parent::afterSave( );
        }

        public function addImages( ) {
            $id = Yii::app()->session['idartista'];
            if( Yii::app( )->user->hasState( 'images' ) ) {
                $thumbnailsPath = realpath( Yii::app( )->getBasePath( )."/../images/uploads/tmp/thumbs/" )."/";
                $userImages = Yii::app( )->user->getState( 'images' );
                //Resolve the final path for our images
                $path = Yii::app( )->getBasePath( )."/../images/uploads/artistas/{$id}/galeria/";
                //Create the folder and give permissions if it doesnt exists
                if( !is_dir( $path ) ) {
                    mkdir( $path,0777,true);
                }

                //Now lets create the corresponding models and move the files
                foreach( $userImages as $image ) {

                    if( is_file( $image["path"] ) ) {
                        if( rename( $image["path"], $path.$image["filename"] ) ) {
                            chmod( $path.$image["filename"], 0777 );
                            $img = new Imagenxartista( );
                            $img->idartista = $id;
                            $img->imagen = $image["filename"];
                            $img->descripcion = $image["description"];
                            
                            //Store the thumbnail.
                            $rutaImagen = Yii::app( )->getBasePath( )."/../images/uploads/artistas/{$id}/galeria/".$image["filename"] ;
                            $rutaThumbnail = Yii::app( )->getBasePath( )."/../images/uploads/artistas/{$id}/galeria/thumbs/200x200/" ;
                            $rutaThumbnailImagen = Yii::app( )->getBasePath( )."/../images/uploads/artistas/{$id}/galeria/thumbs/200x200/".$image["filename"] ;
                            if( !is_dir( $rutaThumbnail )) {
                                 mkdir( $rutaThumbnail,0777,true );
                            }
                            chmod($rutaImagen,0777);
                            chmod( $rutaThumbnail, 0777 );
                            $image = new EasyImage($rutaImagen);
                            $image->resize(150,150);
                            $image->save($rutaThumbnailImagen);
                            unlink($thumbnailsPath.$img->imagen);
                            if(!($img->save()))
                            {
                                //Its always good to log something
                                Yii::log( "No puede salvar la imagen:\n".CVarDumper::dumpAsString( 
                                    $img->getErrors( ) ), CLogger::LEVEL_ERROR );
                                //this exception will rollback the transaction
                                throw new Exception( 'No se guardó la imagen');
                            }
                        }
                    } else {
                        //You can also throw an execption here to rollback the transaction
                        Yii::log( $image["path"]." no es un archivo.", CLogger::LEVEL_WARNING );
                    }
                }
                //Clear the user's session
                Yii::app( )->user->setState( 'images', null );
            }
        }
}
