<?php

/**
 * This is the model class for table "{{sales}}".
 *
 * The followings are the available columns in table '{{sales}}':
 * @property integer $id
 * @property integer $event_attendees_id
 * @property integer $payment_id
 * @property integer $event_id
 * @property string $date_created
 * @property double $total_amount
 */
class Sales extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sales}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_attendees_id, payment_id, event_id, date_created, total_amount', 'required'),
			array('event_attendees_id, payment_id, event_id', 'numerical', 'integerOnly'=>true),
			array('total_amount', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_attendees_id, payment_id, event_id, date_created, total_amount', 'safe', 'on'=>'search'),
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
			'event_attendees_id' => 'Event Attendee',
			'payment_id' => 'Payment',
			'event_id' => 'Event',
			'date_created' => 'Date Created',
			'total_amount' => 'Total Amount',
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
		$criteria->compare('event_attendees_id',$this->event_attendees_id);
		$criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('total_amount',$this->total_amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
