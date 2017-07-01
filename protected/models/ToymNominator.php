<?php

/**
 * This is the model class for table "{{toym_nominator}}".
 *
 * The followings are the available columns in table '{{toym_nominator}}':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $salt
 * @property integer $account_id
 * @property integer $is_jci_member
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $home_address
 * @property string $home_telephone
 * @property string $mobile_no
 * @property string $business_address
 * @property integer $endorsing_chapter
 * @property string $date_created
 * @property string $date_updated
 * @property integer $status_id
 */
class ToymNominator extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{toym_nominator}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, salt, lastname, middlename, home_address, home_telephone, mobile_no, business_address, endorsing_chapter, status_id', 'required'),
			array('salt, account_id, is_jci_member, endorsing_chapter, status_id', 'numerical', 'integerOnly'=>true),
			array('email, firstname, lastname, middlename', 'length', 'max'=>40),
			array('password', 'length', 'max'=>128),
			array('home_address, business_address', 'length', 'max'=>155),
			array('home_telephone, mobile_no', 'length', 'max'=>15),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, salt, account_id, is_jci_member, firstname, lastname, middlename, home_address, home_telephone, mobile_no, business_address, endorsing_chapter, date_created, date_updated, status_id', 'safe', 'on'=>'search'),
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
			'chapter' => array(self::BELONGS_TO, 'Chapter', 'endorsing_chapter'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'salt' => 'Salt',
			'account_id' => 'Account',
			'is_jci_member' => 'Is Jci Member',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'middlename' => 'Middlename',
			'home_address' => 'Home Address',
			'home_telephone' => 'Home Telephone',
			'mobile_no' => 'Mobile No',
			'business_address' => 'Business Address',
			'endorsing_chapter' => 'Endorsing Chapter',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'status_id' => 'Status',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('is_jci_member',$this->is_jci_member);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('home_address',$this->home_address,true);
		$criteria->compare('home_telephone',$this->home_telephone,true);
		$criteria->compare('mobile_no',$this->mobile_no,true);
		$criteria->compare('business_address',$this->business_address,true);
		$criteria->compare('endorsing_chapter',$this->endorsing_chapter);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('status_id',$this->status_id);

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
	 * @return ToymNominator the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
