<?php

class SurveyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/userPanel';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('answersurvey', 'submitanswer', 'deleteanswer','list','test'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionAnswerSurvey($q)
	{	
		$questionnaire = SurveyQuestionnaires::model()->findByPk($q);
		
		if($this->validateSurveyResType(null, $questionnaire)) { 
			$ans_choices = $questionnaire->ans_choices;
			$res_answer = SurveyResAnswers::model()->find('account_id = :aid AND questionnaire_id = :qid', 
					array(':aid'=>Yii::app()->user->id, ':qid'=>$q));

			if($res_answer == null) {
				$res_answer = null;
			}

			if($ans_choices->choice_type == 2) {
				$input_type = "checkbox";
			} else {
				$input_type = "radio";
			}	

			$this->render('answer',array(
				'questionnaire'=>$questionnaire,
				'ans_choices'=>$ans_choices,
				'res_answer'=>$res_answer,
				'conv_answer_options'=> json_decode($ans_choices->answer_choices, true),
				'input_type'=>$input_type,
				'id'=>$q,
			));
		} else {
			Yii::app()->user->setFlash('error', 'ERROR! Invalid Survey Respondent Type.');
			$this->redirect(array('survey/list'));
		}
	}

	public function actionSubmitAnswer() 
	{
		$response = array();
		$response['type'] = false;

		if(isset($_POST['id'])) {
			$res_answer = SurveyResAnswers::model()->find('account_id = :aid AND questionnaire_id = :qid', 
				array(':aid'=>Yii::app()->user->id, ':qid'=>$_POST['id']));
			if($res_answer == null)
				$res_answer = new SurveyResAnswers;

			$res_answer->questionnaire_id = $_POST['id'];
			$res_answer->account_id = Yii::app()->user->id;
			$res_answer->answer = $_POST['answer'];
			$valid = $res_answer->validate();

			if($valid) {
				$transaction = Yii::app()->db->beginTransaction();
				$save = false;

				try { 
					if($res_answer->save()) {
						$save = true;
					}

					if($save) {
						$transaction->commit();
						$response['type'] = true;
						$response['message'] = 'You have successfully submitted your answer for the survey! Thank you for your cooperation.';
						Yii::app()->user->setFlash('success', 'You have successfully submitted your answer for the survey.');
					} else {
						$transaction->rollback();
						$response['message'] = 'Failed in submitting your answer! Please try again.';
					}

				} catch (Exception $e) {
					$transaction->rollback();
					$response['message'] = 'Transaction failed! Try again later.';
				}
			} else {
				$response['message'] = 'Validation failed! Try again later.';
			}
		} else {
			$response['message'] = 'Failed to read input! Try again later.';
		}

		echo json_encode($response);
		exit;
	}

	public function actionDeleteAnswer() 
	{
		$response = array();
		$response['type'] = false;

		if(isset($_POST['id'])) {
			$res_answer = SurveyResAnswers::model()->find('id = :id AND account_id = :account_id', array(':id'=>$_POST['id'], ':account_id'=>Yii::app()->user->id));
			$transaction = Yii::app()->db->beginTransaction();

			try { 
				if($res_answer->delete()) {
					$transaction->commit();
					$response['type'] = true;
					$response['message'] = 'You have successfully deleted your answer for the survey!';
					Yii::app()->user->setFlash('success', 'You have successfully deleted your answer for the survey.');
				} else {
					$transaction->rollback();
					$response['message'] = 'Failed in deleting your answer! Please try again.';
				}

			} catch (Exception $e) {
				$transaction->rollback();
				$response['message'] = 'Transaction failed! Try again later.';
			}

		} else {
			$response['message'] = 'Failed to read input! Try again later.';
		}

		echo json_encode($response);
		exit;
	}

	public function actionList()
	{
		$user = User::model()->find('account_id = :id', array(':id'=>Yii::app()->user->id));
		$questionnaires = SurveyQuestionnaires::model()->findAll(array('condition'=>'status_id = 1', 'order'=>'date_created DESC'));

		foreach($questionnaires as $key=>$q) {
			if(!$this->validateSurveyResType($user, $q)) {
				unset($questionnaires[$key]);
			}
		}

		if(isset($_GET['s'])) {
			$status = $_GET['s'];
			
			if($status != null || $status != "") {
				foreach($questionnaires as $key=>$q) {
					if($status == 1) {
						if($q->res_answers == null)
							unset($questionnaires[$key]);
					} elseif($status == 2) {
						if($q->res_answers != null)
							unset($questionnaires[$key]);
					}
				}
			} 
		}

		$questionnaires = array_values($questionnaires);

		$questionnairesDP =new CArrayDataProvider($questionnaires, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('list',array(
			'questionnaires'=>$questionnaires,
			'questionnairesDP'=>$questionnairesDP,
			'user'=>$user
		));
	}

	public function validateSurveyResType(User $user = null, SurveyQuestionnaires $questionnaires)
	{
		if($user == null)
			$user = User::model()->find('account_id = :id', array(':id'=>Yii::app()->user->id));

		$pos_validate = false;
		$loc_validate = false;

		switch($questionnaires->respondents_type) {
			case 1: //ALL
				$pos_validate = true; 
				break;
			case 2: //JCI_SEN
				if($user->title == 1)
					$pos_validate = true;
				break;
			case 3: //JCI MEM
				if($user->title == 2)
					$pos_validate = true;
				break;
			case 4: //JCI CHAPTER PRES
				if($user->position_id == 11)
					$pos_validate = true;
				break;
			case 5:
				if($user->position_id == 13)
					$pos_validate = true;
				break;
			case 6:
				if($user->position->category == "National")
					$pos_validate = true;
				break;
			case 7:
				if($user->position->category == "Local")
					$pos_validate = true;
				break;
			case 8:
				if($user->position_id == 7 || $user->position_id == 10)
					$pos_validate = true;
				break;
		}

		switch($questionnaires->respondents_loc_type) {
			case 1: //ALL
				$loc_validate = true; 
				break;
			case 2: //AREA
				if($user->chapter->area_no == $questionnaires->respondents_loc)
					$loc_validate = true;
				break;
			case 3: //REGION
				if($user->chapter->region_id == $questionnaires->respondents_loc)
					$loc_validate = true;
				break;
			case 4: //CHAPTER
				if($user->chapter->id == $questionnaires->respondents_loc)
					$loc_validate = true;
				break;
		}

		return $validate = $pos_validate && $loc_validate;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('survey/list'));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SurveyQuestionnaires the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SurveyQuestionnaires::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SurveyQuestionnaires $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='survey-questionnaires-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
