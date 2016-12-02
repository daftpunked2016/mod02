<?php

/**
 * This is the model class for table "{{event_pricing}}".
 *
 * The followings are the available columns in table '{{event_pricing}}':
 * @property integer $id
 * @property integer $event_id
 * @property double $early_bird_price
 * @property string $eb_begin_date
 * @property string $eb_end_date
 * @property double $regular_price
 * @property string $regular_begin_date
 * @property string $regular_end_date
 * @property double $onsite_price
 * @property string $onsite_begin_date
 * @property string $onsite_end_date
 * @property integer $status_id
 */
class EventPricing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{event_pricing}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, pricing_type, early_bird_price, regular_price, onsite_price, status_id', 'required'),
			array('pricing_type, event_id, status_id', 'numerical', 'integerOnly'=>true),
			array('pricing_type, early_bird_price, regular_price, onsite_price', 'numerical'),
			array('eb_begin_date, eb_end_date, regular_begin_date, regular_end_date, onsite_begin_date, onsite_end_date', 'date',  'format' => 'yyyy-MM-dd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pricing_type, event_id, early_bird_price, eb_begin_date, eb_end_date, regular_price, regular_begin_date, regular_end_date, onsite_price, onsite_begin_date, onsite_end_date, status_id', 'safe', 'on'=>'search'),
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
			'pricing_type' => 'Pricing',
			'early_bird_price' => 'Price',
			'eb_begin_date' => 'From *',
			'eb_end_date' => 'To *',
			'regular_price' => 'Price',
			'regular_begin_date' => 'From *',
			'regular_end_date' => 'To *',
			'onsite_price' => 'Price',
			'onsite_begin_date' => 'From *',
			'onsite_end_date' => 'To *',
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
		$criteria->compare('pricing_type',$this->pricing_type);
		$criteria->compare('early_bird_price',$this->early_bird_price);
		$criteria->compare('eb_begin_date',$this->eb_begin_date,true);
		$criteria->compare('eb_end_date',$this->eb_end_date,true);
		$criteria->compare('regular_price',$this->regular_price);
		$criteria->compare('regular_begin_date',$this->regular_begin_date,true);
		$criteria->compare('regular_end_date',$this->regular_end_date,true);
		$criteria->compare('onsite_price',$this->onsite_price);
		$criteria->compare('onsite_begin_date',$this->onsite_begin_date,true);
		$criteria->compare('onsite_end_date',$this->onsite_end_date,true);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventPricing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
