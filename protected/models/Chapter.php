<?php

/**
 * This is the model class for table "jci_chapter".
 *
 * The followings are the available columns in table 'jci_chapter':
 * @property integer $id
 * @property integer $area_region_id
 * @property string $chapter
 */
class Chapter extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_chapter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chapter, max_regular, max_associate', 'required'),
			array('region_id, max_regular, max_associate', 'numerical', 'integerOnly'=>true),
			array('chapter', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, area_no, region_id, chapter', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'chapter_id'),
			'region' => array(self::BELONGS_TO, 'AreaRegion', 'region_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'area_no' => 'Area',
			'region_id' => 'Region',
			'chapter' => 'Chapter',
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
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('chapter',$this->chapter,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chapter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getName($id)
	{
		$chapter = Chapter::model()->findByPk($id);

		return $chapter->chapter;
	}

	public function getArea($id)
	{
		$chapter = Chapter::model()->findByPk($id);

		return $chapter->area_no;
	}

	public function getRegion($id)
	{
		$chapter = Chapter::model()->findByPk($id);
		return $chapter->region_id;
	}

	// $scope = [1]AVP | [2]RVP | [3] NT
	// $type = [1]Regular Members | [2]Associate Members | [3] All
	public function getMembershipCount($scope, $scope_id, $type)
	{
		$count = 0;
		
		switch ($scope) {
			case 1:
				// AVP
				switch ($type) {
					case 1:
						$count = User::model()->userAccount()->isActive()->count(array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.region_id = :region_id AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) <= 40', 'params'=>array(':region_id'=>$scope_id)));
						break;
					case 2:
						$count = User::model()->userAccount()->isActive()->count(array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.region_id = :region_id AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) > 40', 'params'=>array(':region_id'=>$scope_id)));
						break;
					case 3:
						$count = User::model()->userAccount()->isActive()->count(array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.region_id = :region_id', 'params'=>array(':region_id'=>$scope_id)));
						break;
				}
				break;
			case 2:
				// RVP
				switch ($type) {
					case 1:
						$count = User::model()->userAccount()->isActive()->count(array('condition'=>'t.chapter_id = :chapter_id AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) <= 40', 'params'=>array(':chapter_id'=>$scope_id)));
						break;
					case 2:
						$count = User::model()->userAccount()->isActive()->count(array('condition'=>'t.chapter_id = :chapter_id AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) > 40', 'params'=>array(':chapter_id'=>$scope_id)));
						break;
					case 3:
						$count = User::model()->userAccount()->isActive()->count(array('condition'=>'t.chapter_id = :chapter_id', 'params'=>array(':chapter_id'=>$scope_id)));
						break;
				}

				break;
			case 3:
				// NT
				switch ($type) {
					case 1:
						$count = User::model()->userAccount()->isActive()->count(array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.area_no = :area_no AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) <= 40', 'params'=>array(':area_no'=>$scope_id)));
						break;
					case 2:
						$count = User::model()->userAccount()->isActive()->count(array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.area_no = :area_no AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) > 40', 'params'=>array(':area_no'=>$scope_id)));
						break;
					case 3:
						$count = User::model()->userAccount()->isActive()->count(array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.area_no = :area_no', 'params'=>array(':area_no'=>$scope_id)));
						break;
				}
				break;
		}

		return $count;
	}

	public function getCategory($total_members = null)
	{
		if($total_members == null) {
			$total_members = $this->computeAllowedMembers();
		} 

		if($total_members >= 25 && $total_members <= 45) {
			return 3;
		} else if($total_members >= 46 && $total_members <= 75) {
			return 2;
		} else if($total_members >= 76) {
			return 1;
		} else {
			return null;
		}
	}

	public function getVotingStrength($total_members = null)
	{
		if($total_members == null) {
			$total_members = $this->computeAllowedMembers();
		} 

		if($total_members >= 25 && $total_members <= 34) {
			return 3;
		} else if($total_members >= 35 && $total_members <= 44) {
			return 4;
		} else if($total_members >= 45 && $total_members <= 59) {
			return 5;
		} else if($total_members >= 60 && $total_members <= 74) {
			return 6;
		} else if($total_members >= 74 && $total_members <= 100) {
			return 7;
		} else if($total_members >= 100) {
			$min = 101;
			$max = $min + 23;
			$vs = 8;
			
			while($total_members > $max) {
				$max += 23; $vs++;
			}

			return $vs;
		} else {
			return null;
		}
	}

	public function computeAllowedMembers()
	{
		return $this->max_regular + $this->max_associate;
	}

	public static function checkIfLimitMaxed($membership_type, $chapter_id)
	{
		$chapter = self::model()->findByPk($chapter_id);
		$current_members_type_total = User::totalMembersByAge($membership_type, $chapter_id);

		if($membership_type == User::REGULAR_MEM) {
			$max_total = $chapter->max_regular;
		} else {
			$max_total = $chapter->max_associate;
		}
		
		return $max_total > $current_members_type_total;
	}

	public static function getMaxMembers($membership_type, $chapter_id)
	{
		$chapter = self::model()->findByPk($chapter_id);

		if($membership_type == User::REGULAR_MEM) {
			return $chapter->max_regular;
		} else {
			return $chapter->max_associate;
		}
	}
}
