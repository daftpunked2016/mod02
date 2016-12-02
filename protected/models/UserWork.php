<?php

/**
 * This is the model class for table "jci_user_work".
 *
 * The followings are the available columns in table 'jci_user_work':
 * @property integer $id
 * @property integer $work_type_id
 * @property string $company_name
 * @property string $position
 * @property string $address
 * @property integer $city_id
 * @property integer $province_id
 * @property integer $account_id
 * @property integer $status_id
 */
class UserWork extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_user_work';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_type_id, company_name, position, address, city_id, province_id, account_id', 'required'),
			array('work_type_id, city_id, province_id, account_id, status_id', 'numerical', 'integerOnly'=>true),
			array('company_name, position, address, street', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, work_type_id, company_name, position, address, city_id, province_id, account_id, status_id', 'safe', 'on'=>'search'),
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
			'work_type_id' => 'Work Type',
			'company_name' => 'Company Name',
			'position' => 'Position',
			'address' => 'Address',
			'street' => 'Street',
			'city_id' => 'City',
			'province_id' => 'Province',
			'account_id' => 'Account',
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
		$criteria->compare('work_type_id',$this->work_type_id);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('status_id',$this->status_id);

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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserWork the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
