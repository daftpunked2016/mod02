<?php

/**
 * This is the model class for table "{{toym_nominee}}".
 *
 * The followings are the available columns in table '{{toym_nominee}}':
 * @property integer $id
 * @property integer $nominator_id
 * @property string $email
 * @property string $password
 * @property string $temp_password
 * @property integer $salt
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $title
 * @property string $name_on_trophy
 * @property string $phonetic_pronunciation
 * @property string $profession
 * @property string $position
 * @property integer $toym_category_id
 * @property integer $toym_subcategory_id
 * @property string $date_created
 * @property string $date_updated
 * @property integer $status
 */
class ToymNominee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{toym_nominee}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nominator_id, email, password, salt, firstname, lastname, title, name_on_trophy, phonetic_pronunciation, profession, position, toym_category_id, toym_subcategory_id, status', 'required'),
			array('nominator_id, salt, toym_category_id, toym_subcategory_id, status', 'numerical', 'integerOnly'=>true),
			array('email, firstname, middlename, lastname', 'length', 'max'=>40),
			array('password', 'length', 'max'=>128),
			array('temp_password', 'length', 'max'=>30),
			array('title', 'length', 'max'=>10),
			array('name_on_trophy, phonetic_pronunciation', 'length', 'max'=>100),
			array('profession, position', 'length', 'max'=>155),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nominator_id, email, password, temp_password, salt, firstname, middlename, lastname, title, name_on_trophy, phonetic_pronunciation, profession, position, toym_category_id, toym_subcategory_id, date_created, date_updated, status', 'safe', 'on'=>'search'),
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
			'nominator' => array(self::BELONGS_TO, 'ToymNominator', 'nominator_id'),
			'category' => array(self::BELONGS_TO, 'ToymCategory', 'toym_category_id'),
			'subcategory' => array(self::BELONGS_TO, 'ToymSubcategory', 'toym_subcategory_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nominator_id' => 'Nominator',
			'email' => 'Email',
			'password' => 'Password',
			'temp_password' => 'Temp Password',
			'salt' => 'Salt',
			'firstname' => 'Firstname',
			'middlename' => 'Middlename',
			'lastname' => 'Lastname',
			'title' => 'Title',
			'name_on_trophy' => 'Name On Trophy',
			'phonetic_pronunciation' => 'Phonetic Pronunciation',
			'profession' => 'Profession',
			'position' => 'Position',
			'toym_category_id' => 'Toym Category',
			'toym_subcategory_id' => 'Toym Subcategory',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'status' => 'Status',
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
		$criteria->compare('nominator_id',$this->nominator_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('temp_password',$this->temp_password,true);
		$criteria->compare('salt',$this->salt);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('name_on_trophy',$this->name_on_trophy,true);
		$criteria->compare('phonetic_pronunciation',$this->phonetic_pronunciation,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('toym_category_id',$this->toym_category_id);
		$criteria->compare('toym_subcategory_id',$this->toym_subcategory_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getFullName()
	{
		return $this->firstname.' '.$this->lastname;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ToymNominee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
