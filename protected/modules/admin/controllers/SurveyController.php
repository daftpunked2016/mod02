<?php

class SurveyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='layouts/admin';

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
	// public function accessRules()
	// {
	// 	return array(
	// 		array('allow',  // allow all users to perform 'index' and 'view' actions
	// 			'actions'=>array('index','view'),
	// 			'users'=>array('*'),
	// 		),
	// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
	// 			'actions'=>array('createsurvey', 'answersurvey','update'),
	// 			'users'=>array('@'),
	// 		),
	// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
	// 			'actions'=>array('admin','delete'),
	// 			'users'=>array('admin'),
	// 		),
	// 		array('deny',  // deny all users
	// 			'users'=>array('*'),
	// 		),
	// 	);
	// }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$survey = SurveyQuestionnaires::model()->findByPk($id);


		$this->render('view',array(
			'survey' => $survey,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateSurvey()
	{
		if(isset($_POST['title']))
		{
			$response = array();
			$response['type'] = false;
			$questionnaire = new SurveyQuestionnaires;
			$ans_choices = new SurveyAnsChoices;
			$ans_options = array();
			
			$questionnaire->title = $_POST['title'];
			$questionnaire->question = $_POST['question'];
			$questionnaire->respondents_type = $_POST['respondents_type'];
			$questionnaire->respondents_loc_type = $_POST['respondents_loc_type'];
			$ans_choices->choice_type = $_POST['choice_type'];

			switch($_POST['respondents_loc_type']) {
				case 2:
					$questionnaire->respondents_loc = $_POST['area_no'];
					break;
				case 3:
					$questionnaire->respondents_loc = $_POST['region_id'];
					break;
				case 4:
					$questionnaire->respondents_loc = $_POST['chapter_id'];
					break;
				default:
					$questionnaire->respondents_loc = null;
			}

			foreach($_POST['answer_choices'] as $key=>$options) {
				$ans_options[$key + 1] = $options;
			}

			if($_POST['choice_type'] == 2) {
				$ans_choices->choice_limit = $_POST['choice_limit'];
			}

			$ans_choices->answer_choices = json_encode($ans_options);
			$valid = $questionnaire->validate();
			$valid = $ans_choices->validate() && $valid;

			if($valid) {
				$transaction = Yii::app()->db->beginTransaction();
				$save = false;

				try { 
					if($questionnaire->save()) {
						$ans_choices->questionnaire_id = $questionnaire->id;

						if($ans_choices->save()) {
							$save = true;
						} 
					}

					if($save) {
						$transaction->commit();
						$response['type'] = true;
						$response['message'] = 'You have successfully created a new Survey!';
					} else {
						$transaction->rollback();
						$response['message'] = 'Failed in creating a new Survey! Please try again.';
					}

				} catch (Exception $e) {
					$transaction->rollback();
					$response['message'] = 'Transaction failed! Try again later.';
				}
			} else {
				$response['message'] = 'Validation failed! Try again later.';
			}

			echo json_encode($response);
			exit; 
		} 

		$this->render('create',array(
		));
	}

	public function actionAnswerSurvey($q)
	{
		$questionnaire = SurveyQuestionnaires::model()->findByPk($q);
		$ans_choices = $questionnaire->ans_choices;

		if($ans_choices->choice_type == 2) {
			$input_type = "checkbox";
		} else {
			$input_type = "radio";
		}

		$this->render('answer',array(
			'questionnaire'=>$questionnaire,
			'ans_choices'=>$ans_choices,
			'conv_answer_options'=> json_decode($ans_choices->answer_choices, true),
			'input_type'=>$input_type
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$survey = SurveyQuestionnaires::model()->findByPk($id);
		$ans_choices = $survey->ans_choices;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SurveyQuestionnaires']))
		{
			$response = array();
			$response['type'] = false;
			
			$orig_choice_type = $ans_choices->choice_type;

			$survey->attributes = $_POST['SurveyQuestionnaires'];
			$ans_choices->attributes = $_POST['SurveyAnsChoices'];
			
			switch($_POST['SurveyQuestionnaires']['respondents_loc_type']) {
				case 2:
					$survey->respondents_loc = $_POST['SurveyQuestionnaires']['area_no'];
					break;
				case 3:
					$survey->respondents_loc = $_POST['SurveyQuestionnaires']['region_id'];
					break;
				case 4:
					$survey->respondents_loc = $_POST['SurveyQuestionnaires']['chapter_id'];
					break;
				default:
					$survey->respondents_loc = null;
			}
			
			foreach($ans_choices->answer_choices as $key=>$options) {
				$ans_options[$key + 1] = $options;
			}

			$ans_choices->answer_choices = json_encode($ans_options);

			if($ans_choices->choice_type == 2) {
				$ans_choices->choice_limit = $_POST['SurveyAnsChoices']['choice_limit'];
			}else{
				$ans_choices->choice_limit = null;
			}

			$valid = $survey->validate();
			$valid = $ans_choices->validate() && $valid;

			if($valid) {
				$transaction = Yii::app()->db->beginTransaction();
				$save = false;

				try { 
					if($survey->save()) {
						if($ans_choices->save()) {
							$save = true;

							if($orig_choice_type == 2) { //IF CHANGE FROM CHECKBOX TO RB
								if($ans_choices->choice_type == 1) {
									if(SurveyResAnswers::model()->deleteAll('questionnaire_id = :id', array(':id'=>$survey->id))) {
										$save = true;
									} else {
										$save = false;
									}
								}
							}

							
						}
					}

					if($save) {

						/*echo "<pre>";
						print_r($ans_choices->attributes);
						echo "</pre>";
						exit;*/

						$transaction->commit();
						$response['type'] = true;
						Yii::app()->user->setFlash('success', 'Update Survey Complete!');
						$response['message'] = 'You have successfully updated a Survey!';
					} else {
						$transaction->rollback();
						$response['message'] = 'Failed in updating a Survey! Please try again.';
					}

				} catch (Exception $e) {
					$transaction->rollback();
					$response['message'] = $e;
				}
			} else {
				$response['message'] = 'Validation failed! Try again later.';
			}

			echo json_encode($response);
			exit; 
		}

		$this->render('update',array(
			'survey'=>$survey,
			'ans_choices'=>$ans_choices
		));
	}

	public function actionViewResults($id)
	{
		$this->layout = '/layouts/admin-new';
		$compiled_answers = array();
		$res_answers_loc = array();
		$questionnaire = SurveyQuestionnaires::model()->findByPk($id);
		$answer_choices = json_decode($questionnaire->ans_choices->answer_choices);
		//$res_answers = $questionnaire->res_answers_all;
		$res_answers = $res_answers = SurveyResAnswers::model()->findAll(
			'questionnaire_id = :id', array(':id'=>$id)
		);
		$graph_colors = array('#f56954','#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#ffff7f', '#A9A9A9', '#19198c', '#694489',
			'#FCFBE3', '#ffb4d9', '#CDAF95', '#E7C6A5','#8C7853','#802A2A','#AA5303','#00C5CD','#50A6C2');
		$color_count = 0;
		$total_res = 0;

		foreach($res_answers as $ans) {
			$total_res++;
			$decoded_ans = json_decode($ans->answer);
			$compiled_answers = array_merge($decoded_ans, $compiled_answers);
			
			/*foreach($decoded_ans as $ans) {
				print_r($ans->chapter->area_no);exit;
				if(isset($res_answers_loc[$ans][$ans->chapter->area_no])) {
					$res_answers_loc[$ans][$ans->chapter->area_no]++;
				} else {
					$res_answers_loc[$ans][$ans->chapter->area_no] = 1;
				}
			}*/
		}

		//print_r($res_answers_loc);exit;


		$scores = array_count_values($compiled_answers);
		$total_ans = array_sum($scores);

		foreach($answer_choices as $key=>$ans_choice) {
			if(!isset($scores[$key])) {
				$scores[$key] = 0;
			}
		}

		ksort($scores);

		foreach($scores as $key=>$score) {
			$percentage[$key] = round(($score / $total_ans) * 100, 2);
			$pd_chart_data[]= array('value'=>$score, 'color'=>$graph_colors[$color_count], 'highlight'=>'#D3D3D3','label'=>'Option '.$key.'('.$percentage[$key].'%) ');
			$bar_chart_labels[] = 'Option '.$key;
			$bar_chart_values[] = $score;
			$answer_colors[$key] = $graph_colors[$color_count];
			$color_count++;
		}

		$bar_chart_datasets_prop = array(
				'label'=>$questionnaire->title,
				'fillColor'=> 'rgba(151,187,205,0.5)',
	            'strokeColor'=> 'rgba(151,187,205,0.8)',
	            'highlightFill'=> 'rgba(151,187,205,0.75)',
	            'highlightStroke'=> 'rgba(151,187,205,1)',
	            'data' => $bar_chart_values);

		$this->render('view_results',array(
			'questionnaire'=>$questionnaire,
			'bar_chart_datasets'=>json_encode($bar_chart_datasets_prop),
			'bar_chart_labels'=>json_encode($bar_chart_labels),
			'pd_chart_data'=>json_encode($pd_chart_data),
			'answer_choices'=>$answer_choices,
			'answer_colors'=>$answer_colors,
			'scores'=>$scores,
			'total_ans'=>$total_ans,
			'total_res'=>$total_res,
			'percentage'=>$percentage,
		));
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
		$dataProvider=new CActiveDataProvider('SurveyQuestionnaires');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SurveyQuestionnaires('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SurveyQuestionnaires']))
			$model->attributes=$_GET['SurveyQuestionnaires'];

		$this->render('admin',array(
			'model'=>$model,
		));
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

	public function actionActivate($id)
	{
		$survey = SurveyQuestionnaires::model()->findByPk($id);

		if(isset($survey))
		{
			$survey->status_id = 1;

			if($survey->save())
			{
				Yii::app()->user->setFlash('success', 'Activate Survey Complete!');
				$this->redirect(array('survey/index'));
			}else{
				Yii::app()->user->setFlash('error', 'Activate Survey Failed!');
				$this->redirect(array('survey/index'));
			}
		}
	}

	public function actionDisable($id)
	{
		$survey = SurveyQuestionnaires::model()->findByPk($id);

		if(isset($survey))
		{
			$survey->status_id = 2;

			if($survey->save())
			{
				Yii::app()->user->setFlash('success', 'Disable Survey Complete!');
				$this->redirect(array('survey/index'));
			}else{
				Yii::app()->user->setFlash('error', 'Disable Survey Failed!');
				$this->redirect(array('survey/index'));
			}
		}
	}

	public function actionViewRespondents($q, $k)
	{ 
		$search_filter = array();

		if(isset($_GET['area'])) {
			if($_GET['chapter'] != "") {
				$search_filter['chapter'] = array('condition'=>'chapter.id = :cid', 'params'=>array(':cid'=>$_GET['chapter']));
			} else if ($_GET['region'] != "") {
				$search_filter['chapter'] = array('condition'=>'region_id = :rid', 'params'=>array(':rid'=>$_GET['region']));
			} else {
				$search_filter['chapter'] = array('condition'=>'area_no = :area', 'params'=>array(':area'=>$_GET['area']));
			}
		}

		$res_answers = SurveyResAnswers::model()->with($search_filter)->findAll(
			'questionnaire_id = :id AND answer LIKE "%":key"%"', 
			array(':id'=>$q, ':key'=>'"'.$k.'"')
			);
		
		$res_total = count($res_answers);
		$questionnaire = SurveyQuestionnaires::model()->findByPk($q);
		$answer = json_decode($questionnaire->ans_choices->answer_choices);
		$item = $answer->$k;

		$respondentsDP=new CArrayDataProvider($res_answers, array(
			'pagination' => array(
				'pageSize' => 10
			)
		));

		$this->render('view_respondents',array(
			'respondentsDP' => $respondentsDP,
			'questionnaire' => $questionnaire,
			'res_total' => $res_total,
			'item' => $item,
		));

	}

	public function actionSummary($q, $k)
	{
		$regions = AreaRegion::model()->findAll();
		$area_regions = $this->mergeAreaRegions($regions);
		$res_answers = SurveyResAnswers::model()
			->findAll(
				'questionnaire_id = :id AND answer LIKE "%":key"%"', 
				array(':id'=>$q, ':key'=>'"'.$k.'"')
		);
		$grouped_ans_count = $this->countResAnsByRegion($res_answers);
		$res_total = count($res_answers);

		$questionnaire = SurveyQuestionnaires::model()->findByPk($q);
		$answer = json_decode($questionnaire->ans_choices->answer_choices);
		$item = $answer->$k;

		$this->render('view_summary',array(
			'res_total' => $res_total,
			'area_regions' => $area_regions,
			'grouped_ans_count' => $grouped_ans_count,
			'questionnaire' => $questionnaire,
			'item' => $item,
			'k'=>$k
		));
	}

	public function actionFullSummary($q)
	{
		$regions = AreaRegion::model()->findAll();
		$area_regions = $this->mergeAreaRegions($regions);
		$res_answers = SurveyResAnswers::model()
			->findAll(
				'questionnaire_id = :id', 
				array(':id'=>$q)
		);

		$questionnaire = SurveyQuestionnaires::model()->findByPk($q);
		$answer_choices = json_decode($questionnaire->ans_choices->answer_choices);

		$collected_ans = $this->groupResAnsByRegion($res_answers);
		$overall_total = $this->countOverallTotal($collected_ans);

		/*echo "<pre>";
		print_r($answer_choices);exit;*/

		$this->render('view_full_summary',array(
			'res_total' => count($res_answers),
			'area_regions' => $area_regions,
			'collected_ans' => $collected_ans,
			'questionnaire' => $questionnaire,
			'answer_choices' => $answer_choices,
			'overall_total' => $overall_total,
		));
	}

	public function groupResAnsByRegion(array $res_answers)
	{	
		$regions = array();

		foreach($res_answers as $res_ans) {
			$region_id = $res_ans->chapter->region_id;
			$ans_collection = json_decode($res_ans->answer);

			foreach($ans_collection as $ans) {
				if(isset($regions[$region_id][$ans])) {
					$regions[$region_id][$ans]++;
				} else {
					$regions[$region_id][$ans] = 1;
				}
			}
		}

		return $regions;			
	}

	public function mergeAreaRegions(array $regions)
	{
		$area = array();

		foreach($regions as $reg) {
			$area[$reg->area_no][$reg->id] = $reg->region;
		}

		return $area;
	}

	public function countResAnsByRegion(array $res_answers)
	{
		$regions = array();

		foreach($res_answers as $ans) {
			$region_id = $ans->chapter->region_id;

			if(isset($regions[$region_id])) {
				$regions[$region_id]++;
			} else {
				$regions[$region_id] = 1;
			}
		}

		return $regions;

	}

	public function countOverallTotal(array $region_answers)
	{
		$answer_total = array();

		foreach($region_answers as $answers) {
			foreach($answers as $opt_no=>$ans_total) {
				if(!isset($answer_total[$opt_no])) {
					$answer_total[$opt_no] = 0; 
				}

				$answer_total[$opt_no] += $ans_total;
			}
		}

		return $answer_total;

	}

}