<?php

/**
 * This is the model class for table "{{sv_questionnaires}}".
 *
 * The followings are the available columns in table '{{sv_questionnaires}}':
 * @property integer $id
 * @property string $question
 * @property integer $respondents_type
 * @property integer $respondents_loc_type
 * @property integer $respondents_loc
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $status_id
 */
class SurveyQuestionnaires extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_INACTIVE = 2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sv_questionnaires}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, question, respondents_type, respondents_loc_type', 'required'),
			array('respondents_type, respondents_loc_type, respondents_loc, date_created, date_updated, status_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('question', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, question, respondents_type, respondents_loc_type, respondents_loc, date_created, date_updated, status_id', 'safe', 'on'=>'search'),
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
			'ans_choices' => array(self::HAS_ONE, 'SurveyAnsChoices', 'questionnaire_id'),
			'res_answers' => array(self::HAS_MANY, 'SurveyResAnswers', 'questionnaire_id', 'condition'=>'res_answers.account_id = '.Yii::app()->user->id.' AND res_answers.status_id = 1'),
			'res_answers_all' => array(self::HAS_MANY, 'SurveyResAnswers', 'questionnaire_id', 'condition'=>'res_answers_all.status_id = 1'),
		);
	}

	public function scopes()
	{
		return array(
			'isActive' => array(
				'condition' => 't.status_id = '.self::STATUS_ACTIVE,
			),
			
			'isInactive' => array(
				'condition' => 't.status_id = '.self::STATUS_INACTIVE,
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'question' => 'Question',
			'respondents_type' => 'Respondents Type',
			'respondents_loc_type' => 'Respondents Loc Type',
			'respondents_loc' => 'Respondents Loc',
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
		$criteria->compare('question',$this->question,true);
		$criteria->compare('respondents_type',$this->respondents_type);
		$criteria->compare('respondents_loc_type',$this->respondents_loc_type);
		$criteria->compare('respondents_loc',$this->respondents_loc);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_updated',$this->date_updated);
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
				$this->date_created = time();
				$this->date_updated = time();
				$this->status_id = 1;
			}
			else
			{
				$this->date_updated = time();
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getResType($type)
	{
		switch($type) {
			case 1:
				$res = "<b><i>* ALL</i></b>";
				break;	
			case 2:
				$res = "JCI Senators";
				break;
			case 3:
				$res = "JCI Members";
				break;
			case 4:
				$res = "JCI LO Presidents";
				break;
			case 5:
				$res = "JCI LO Secretaries";
				break;
			case 6:
				$res = "National Board Positions";
				break;
			case 7:
				$res = "Local Positions";
				break;
			case 8:
				$res = "National Director / National Chairman";
				break;
		}

		return $res;
	}

	public function getResTotal($res_type, $loc_type, $loc_no)
	{
		$rel_condition['account'] = array('condition'=>'status_id = 1 AND account_type_id = 2', 'select'=>false);
		$dir_condition = "";

		switch($res_type) {
			case 2:
				$dir_condition.="title = 1 ";
				break;
			case 3:
				$dir_condition.="title = 2 ";
				break;
			case 4:
				$dir_condition.="position_id = 11 ";
				break;
			case 5:
				$dir_condition.="position_id = 13 ";
				break;
			case 6:
				$rel_condition['position'] = array('condition'=>'category = :cat', 'select'=>false, 'params'=>array(':cat'=> 'National'));
				break;
			case 7:
				$rel_condition['position'] = array('condition'=>'category = :cat', 'select'=>false, 'params'=>array(':cat'=>'Local'));
				break;
			case 8:
				$dir_condition.="position_id = 7 OR position_id = 10";
				break;
		}

		switch($loc_type) {
			case 2:
				$rel_condition['chapter'] = array('condition'=>'area_no ='.$loc_no, 'select'=>false);
				break;
			case 3:
				$rel_condition['chapter'] = array('condition'=>'region_id ='.$loc_no, 'select'=>false);
				break;
			case 4:
				$rel_condition['chapter'] = array('condition'=>'chapter_id ='.$loc_no, 'select'=>false);
				break;
		}

		$count = User::model()->with($rel_condition)->count($dir_condition);

		return $count;
	}

	public function getLocation($loc_type, $loc_no)
	{
		switch($loc_type) {
			case 1:
				$loc = "<b><i>* ALL</i></b>";
				break;	
			case 2: // area
				$loc = "AREA ".$loc_no;
				break;
			case 3: // region
				$region = AreaRegion::model()->findByPk($loc_no);
				$loc = $region->region;
				break;
			case 4: //chapter
				$chapter = Chapter::model()->findByPk($loc_no);
				$loc = "JCI ".$chapter->chapter;
				break;
		}

		return $loc;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurveyQuestionnaires the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
