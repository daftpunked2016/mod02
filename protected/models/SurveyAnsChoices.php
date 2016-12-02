<?php

/**
 * This is the model class for table "{{sv_ans_choices}}".
 *
 * The followings are the available columns in table '{{sv_ans_choices}}':
 * @property integer $id
 * @property integer $questionnaire_id
 * @property string $answer_choices
 * @property integer $choice_type
 * @property integer $choice_limit
 * @property integer $status_id
 */
class SurveyAnsChoices extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_INACTIVE = 2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sv_ans_choices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('answer_choices, choice_type', 'required'),
			array('questionnaire_id, choice_type, choice_limit, status_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, questionnaire_id, answer_choices, choice_type, choice_limit, status_id', 'safe', 'on'=>'search'),
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
			'questionnaire_id' => 'Questionnaire',
			'answer_choices' => 'Answer Choices',
			'choice_type' => 'Choice Type',
			'choice_limit' => 'Choice Limit',
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
		$criteria->compare('questionnaire_id',$this->questionnaire_id);
		$criteria->compare('answer_choices',$this->answer_choices,true);
		$criteria->compare('choice_type',$this->choice_type);
		$criteria->compare('choice_limit',$this->choice_limit);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurveyAnsChoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
