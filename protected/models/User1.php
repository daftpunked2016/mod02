<?php

/**
 * This is the model class for table "jci_user".
 *
 * The followings are the available columns in table 'jci_user':
 * @property integer $id
 * @property integer $account_id
 * @property integer $title
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $contactno
 * @property integer $gender
 * @property integer $chapter_id
 * @property integer $position_id
 * @property string $user_avatar
 *
 * The followings are the available model relations:
 * @property Account $account
 */
class User extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_INACTIVE = 2;
	CONST STATUS_INACTIVE_PAUSE = 3;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jci_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, firstname, lastname, middlename, chapter_id, position_id, contactno, gender, birthdate', 'required'),
			array('account_id, title, gender, chapter_id, position_id', 'numerical', 'integerOnly'=>true),
			array('firstname, middlename, lastname, contactno, address', 'length', 'max'=>160),
			array('sen_no', 'length', 'max'=>50),
			array('user_avatar', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).', 'on' => 'upload'),
    		array('user_avatar', 'file', 'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'Size should be less than 5MB!', 'on' =>'updateUser'),
			array('user_avatar', 'required', 'on' => 'createNewUser', 'message' => 'You must select a picture/image for your user profile!'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, title, sen_no, firstname, middlename, lastname, gender, address, birthdate, chapter_id, position_id, user_avatar, contactno', 'safe', 'on'=>'search'),
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
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => 'Account',
			'title' => 'Title',
			'sen_no' => 'Senator No.*',
			'firstname' => 'First Name',
			'middlename' => 'Middle Name',
			'lastname' => 'Last Name',
			'contactno' => 'Contact No.',
			'gender' => 'Gender',
			'chapter_id' => 'Chapter',
			'address' => 'Address',
			'birthdate' => 'Date of Birth',
			'position_id' => 'Position',
			'user_avatar' => 'Profile Picture',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('title',$this->title);
		$criteria->compare('sen_no',$this->sen_no);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('middlename',$this->middlename,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('contactno',$this->contactno,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('address',$this->address);
		$criteria->compare('birthdate',$this->birthdate);
		$criteria->compare('chapter_id',$this->chapter_id);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('user_avatar',$this->user_avatar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCompleteName($length = 0)
	{
		$name = '';
		$id = Yii::app()->user->id;
		
		$user = User::model()->find(array('condition'=>'account_id = '.$id));
		if(!empty($this->middlename))
			$name = ucfirst($user->firstname).' '.ucfirst($user->middlename).' '.ucfirst($user->lastname);
		else	
			$name = ucfirst($user->firstname).' '.ucfirst($user->lastname);
		 
		$count = strlen($name);

		if ($length <> 0)
		{
			if($count > $length)
				$name = substr($name,0,$length).'...';
		}
		
		return $name; 
	}

	public function getCompleteName2($id, $length = 0)
	{
		$name = '';
		
		$user = User::model()->find(array('condition'=>'account_id = '.$id));
		if(!empty($this->middlename))
			$name = ucfirst($user->firstname).' '.ucfirst($user->middlename).' '.ucfirst($user->lastname);
		else	
			$name = ucfirst($user->firstname).' '.ucfirst($user->lastname);
		 
		$count = strlen($name);

		if ($length <> 0)
		{
			if($count > $length)
				$name = substr($name,0,$length).'...';
		}
		
		return $name; 
	}

	public function getAdminCompleteName($length = 0)
	{
		$name = '';
		$id = Yii::app()->admin->id;
		
		$user = User::model()->find(array('condition'=>'account_id = '.$id));
		if(!empty($this->middlename))
			$name = ucfirst($user->firstname).' '.ucfirst($user->middlename).' '.ucfirst($user->lastname);
		else	
			$name = ucfirst($user->firstname).' '.ucfirst($user->lastname);
		 
		$count = strlen($name);

		if ($length <> 0)
		{
			if($count > $length)
				$name = substr($name,0,$length).'...';
		}
		
		return $name; 
	}

	public function getHostCompleteName($length = 0)
	{
		$name = '';
		$id = Yii::app()->host->id;

		$host = Host::model()->find(array('condition' => 'id ='.$id));
		
		$user = User::model()->find(array('condition'=>'account_id = '.$host->account_id));
		if(!empty($this->middlename))
			$name = ucfirst($user->firstname).' '.ucfirst($user->middlename).' '.ucfirst($user->lastname);
		else	
			$name = ucfirst($user->firstname).' '.ucfirst($user->lastname);
		 
		$count = strlen($name);

		if ($length <> 0)
		{
			if($count > $length)
				$name = substr($name,0,$length).'...';
		}
		
		return $name; 
	}

	public function getPosition()
	{
		$id = Yii::app()->user->id;

		$user = User::model()->find(array('condition'=>'account_id = '.$id));	
		$position = Position::model()->findByPk($user->position_id);
		return $position->position;
	}

	public function getChapter()
	{
		$id = Yii::app()->user->id;

		$user = User::model()->find(array('condition'=>'account_id = '.$id));	
		$chapter = Chapter::model()->findByPk($user->chapter_id);
		return $chapter->chapter;
	}

	public function getChapter2($id)
	{
		$user = User::model()->find(array('condition'=>'account_id = '.$id));	
		$chapter = Chapter::model()->findByPk($user->chapter_id);
		return $chapter->chapter;
	}

	public function scopes()
	{
		return array(
			'isActive' => array(
				'join' => 'INNER JOIN jci_account AS account ON account.id = t.account_id',
				'condition' => 'account.status_id = 1',
			),
			
			'isInactive' => array(
				'join' => 'INNER JOIN jci_account AS account ON account.id = t.account_id',
				'condition' => 'account.status_id = 2',
			),

			'isReset' => array(
				'join' => 'INNER JOIN jci_account AS account ON account.id = t.account_id',
				'condition' => 'account.status_id = 4',
			),

			'userAccount' => array(
				'join' => 'INNER JOIN jci_account AS a ON a.id = t.account_id',
				'condition' => 'a.account_type_id = 2',
			),

			//areas
			'isArea1' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 1',
			),

			'isArea2' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 2',
			),

			'isArea3' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3',
			),

			'isArea4' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 4',
			),

			'isArea5' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 5',
			),

			//area1
			'isArea1Region1' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 1 AND region_id = 1',
			),

			'isArea1Region2' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 1 AND region_id = 2',
			),

			'isArea1Region3' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 1 AND region_id = 3',
			),

			'isArea1Region4' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 1 AND region_id = 4',
			),

			//area2
			'isArea2Region5' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 2 AND region_id = 5',
			),

			'isArea2Region6' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 2 AND region_id = 6',
			),

			'isArea2Region7' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 2 AND region_id = 7',
			),

			'isArea2Region8' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 2 AND region_id = 8',
			),

			//area3
			'isArea3Region9' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3 AND region_id = 9',
			),

			'isArea3Region10' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3 AND region_id = 10',
			),

			'isArea3Region11' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3 AND region_id = 11',
			),

			'isArea3Region12' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3 AND region_id = 12',
			),

			'isArea3Region13' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3 AND region_id = 13',
			),

			'isArea3Region14' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 3 AND region_id = 14',
			),

			//area4
			'isArea4Region15' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 4 AND region_id = 15',
			),

			'isArea4Region16' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 4 AND region_id = 16',
			),

			'isArea4Region17' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 4 AND region_id = 17',
			),

			//area5
			'isArea5Region18' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 5 AND region_id = 18',
			),

			'isArea5Region19' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 5 AND region_id = 19',
			),

			'isArea5Region20' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 5 AND region_id = 20',
			),

			'isArea5Region21' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 5 AND region_id = 21',
			),

			'isArea5Region22' => array(
				'join' => 'INNER JOIN jci_chapter AS chapter ON chapter.id = t.chapter_id',
				'condition' => 'area_no = 5 AND region_id = 22',
			),
		);
	}
}
