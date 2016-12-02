<?php

/**
 * This is the model class for table "jci_area_region".
 *
 * The followings are the available columns in table 'jci_area_region':
 * @property integer $id
 * @property integer $area_no
 * @property string $region
 */
class AreaRegion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_area_region';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('area_no, region', 'required'),
			array('area_no', 'numerical', 'integerOnly'=>true),
			array('region', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, area_no, region', 'safe', 'on'=>'search'),
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
			'area_no' => 'Area No',
			'region' => 'Region',
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
		$criteria->compare('area_no',$this->area_no);
		$criteria->compare('region',$this->region,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AreaRegion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes()
	{
		return array(
			'isArea1' => array(
				'condition' => 'area_no = 1',
			),

			'isArea2' => array(
				'condition' => 'area_no = 2',
			),

			'isArea3' => array(
				'condition' => 'area_no = 3',
			),

			'isArea4' => array(
				'condition' => 'area_no = 4',
			),

			'isArea5' => array(
				'condition' => 'area_no = 5',
			),
		);
	}

	public function getName($id)
	{
		$region = AreaRegion::model()->findByPk($id);

		return $region->region;
	}

	public function getArea($id)
	{
		$region = AreaRegion::model()->findByPk($id);

		return $region->area_no;
	}
}
