<?php

/**
 * This is the model class for table "{{payments}}".
 *
 * The followings are the available columns in table '{{payments}}':
 * @property integer $id
 * @property integer $event_id
 * @property integer $account_id
 * @property integer $event_attendees_id
 * @property string $bank_branch
 * @property string $date
 * @property integer $time
 * @property double $amount
 * @property integer $payment_avatar
 * @property integer $status_id
 */
class Payments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{payments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, account_id, event_attendees_id, bank_branch, date, date_uploaded time, amount', 'required'),
			array('event_id, account_id, event_attendees_id, payment_avatar, status_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('bank_branch', 'length', 'max'=>128),
			array('time', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, account_id, event_attendees_id, bank_branch, date, date_uploaded, time, amount, payment_avatar, status_id', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'account_id' => 'Account',
			'event_attendees_id' => 'Event Attendees',
			'bank_branch' => 'Bank Branch',
			'date' => 'Date',
			'time' => 'Time',
			'amount' => 'Amount',
			'payment_avatar' => 'Payment Avatar',
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
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('event_attendees_id',$this->event_attendees_id);
		$criteria->compare('bank_branch',$this->bank_branch,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_avatar',$this->payment_avatar);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
