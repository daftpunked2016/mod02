<?php

/**
 * This is the model class for table "jci_fileupload".
 *
 * The followings are the available columns in table 'jci_fileupload':
 * @property integer $id
 * @property string $original_filename
 * @property string $filename
 * @property string $file_extension
 * @property integer $poster_id
 * @property string $date_uploaded
 */
class Fileupload extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_fileupload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('original_filename, filename, file_extension, poster_id, date_uploaded', 'required'),
			array('poster_id', 'numerical', 'integerOnly'=>true),
			array('original_filename, filename', 'length', 'max'=>255),
			array('file_extension', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, original_filename, filename, file_extension, poster_id, date_uploaded', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'original_filename' => 'Original Filename',
			'filename' => 'Filename',
			'file_extension' => 'File Extension',
			'poster_id' => 'Poster',
			'date_uploaded' => 'Date Uploaded',
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
		$criteria->compare('original_filename',$this->original_filename,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('file_extension',$this->file_extension,true);
		$criteria->compare('poster_id',$this->poster_id);
		$criteria->compare('date_uploaded',$this->date_uploaded,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->original_filename = $this->hashFilename($this->filename);
				$file_variable = explode('.', $this->filename);
				$extension = end($file_variable);
				$this->file_extension = $extension;
				$this->date_uploaded = date('Y-m-d H:i');
			}
			else
			{
				return;//$this->date_uploaded = date('Y-m-d H:i');
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	public function hashFilename($filename)
	{
		//Used to encrypt the password
		//You can either use sha1, sha2 or sha256
		//md5 not that secure anymore
		return sha1($filename);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Fileupload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getProfilePicture($id)
	{	
		$path = 'http://www.jci.org.ph'.Yii::app()->baseUrl.'/user_avatars/';
		$fileupload = Fileupload::model()->findByPk($id);

		return $path.$fileupload->filename;
	}

	public function getFileName($id)
	{
		$fileupload = Fileupload::model()->findByPk($id);

		return $fileupload->filename;
	}
}
