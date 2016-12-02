<?php

/**
 * This is the model class for table "{{sv_res_answers}}".
 *
 * The followings are the available columns in table '{{sv_res_answers}}':
 * @property integer $id
 * @property integer $questionnaire_id
 * @property integer $account_id
 * @property integer $answer
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $status_id
 */
class SurveyResAnswers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sv_res_answers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('questionnaire_id, account_id, answer', 'required'),
			array('questionnaire_id, account_id, date_created, date_updated, status_id', 'numerical', 'integerOnly'=>true),
			array('answer', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, questionnaire_id, account_id, answer, date_created, date_updated, status_id', 'safe', 'on'=>'search'),
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
		   'questionnaire' => array(self::BELONGS_TO, 'SurveyQuestionnaires', 'questionnaire_id'),
		   'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
		   'user' => array(self::BELONGS_TO, 'User', array('id'=>'account_id'),'through'=>'account'),
		   'chapter' => array(self::BELONGS_TO, 'Chapter', array('chapter_id'=>'id'),'through'=>'user'),
	    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'questionnaire_id' => 'Questionnaire',
			'account_id' => 'Account',
			'answer' => 'Answer',
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
		$criteria->compare('questionnaire_id',$this->questionnaire_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('answer',$this->answer);
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

	public static function countAreaRes($grouped_ans_count, $regions)
	{	
		$count = 0;

		foreach($regions as $id=>$reg) {
			if(isset($grouped_ans_count[$id]))
				$count = $grouped_ans_count[$id] + $count;
		}

		return $count;
	}

	public static function getAnsPercentage($count, $total)
	{
		return round(($count/$total)*100, 2);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurveyResAnswers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
