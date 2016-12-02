<?php

/**
 * This is the model class for table "jci_user_business".
 *
 * The followings are the available columns in table 'jci_user_business':
 * @property integer $id
 * @property integer $business_type_id
 * @property string $description
 * @property string $address
 * @property string $street
 * @property integer $city_id
 * @property integer $province_id
 * @property string $operating_hours
 * @property integer $account_id
 * @property integer $business_avatar
 * @property integer $status_id
 */
class UserBusiness extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_user_business';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('business_cat_id, business_type_id, business_name, description, address, city_id, province_id, operating_hours, account_id, status_id', 'required'),
			array('business_cat_id, business_type_id, city_id, province_id, account_id, business_avatar, status_id', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>500),
			array('business_name, address, contact_no, operating_hours', 'length', 'max'=>128),
			array('street', 'length', 'max'=>50),
			//array('business_avatar', 'file', 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'Size should be less than 5MB!', 'on' =>'createNewBusiness'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, business_cat_id, business_type_id, description, address, street, city_id, province_id, operating_hours, account_id, business_avatar, status_id', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'user' => array(self::BELONGS_TO, 'User', array('id'=>'account_id'),'through'=>'account'),
		);
	}

	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'business_type_id' => 'Business Type',
			'business_name' => 'Name',
			'description' => 'Description',
			'address' => 'Address',
			'street' => 'Street',
			'city_id' => 'City',
			'province_id' => 'Province',
			'contact_no' => 'Contact No.',
			'operating_hours' => 'Operating Hours',
			'account_id' => 'Account',
			'business_avatar' => 'Business Avatar',
			'status_id' => 'Status',
		);
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->status_id = 1;
			}
			return true;
		}
		else
		{
			return false;
		}
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
		$criteria->compare('business_type_id',$this->business_type_id);
		$criteria->compare('business_name',$this->business_name);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('contact_no',$this->contact_no);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('operating_hours',$this->operating_hours,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('business_avatar',$this->business_avatar);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserBusiness the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
