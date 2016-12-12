<?php 
class ChaptersController extends Controller
{
	public $layout = 'layouts/admin';

	public function actionIndex($category = null, $area_no = null, $region = null)
	{
		$condition = '';
		$params = array();

		if($category != null) {
			$condition .= 'category = :category';
			$params[':category'] = $category;
		}

		if($area_no != null) {
			$condition .= ($condition != '') ? ' AND area_no = :area_no': 'area_no = :area_no';
			$params[':area_no'] = $area_no;
		}

		if($region != null) {
			$condition .= ($condition != '') ? ' AND region_id = :region': 'region_id = :region';
			$params[':region'] = $region; 
		}

		$chapters = Chapter::model()->findAll(array('condition'=>$condition, 'params'=>$params, 'order'=>'area_no ASC, region_id ASC '));
		
		$chaptersDP = new CArrayDataProvider($chapters, array(
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('index', array(
			'chaptersDP' => $chaptersDP,
			'total'=>count($chapters),
		));
	}

	public function actionSave()
	{
		if( isset($_POST) && !(empty($_POST)) ) {
			$response = array('type'=>false);

            $chapter = Chapter::model()->findByPk($_POST['id']);
           	//$chapter->chapter = $_POST['chapter'];
           	$chapter->max_regular = $_POST['max_regular'];
           	$chapter->max_associate = $_POST['max_associate'];
           	$chapter->category = $chapter->getCategory();
           	$chapter->voting_strength = $chapter->getVotingStrength();

           	if($chapter->validate()) {
           		if($chapter->save()) {
           			$response['type'] = true;
           			$response['message'] = "Chapter data changes successfully saved!";
           			$response['category'] = $chapter->category;
           			$response['voting_strength'] = $chapter->voting_strength;
           		} else {
           			$response['message'] = "An error occured while saving changes. Please try again or report to the administrator";
           		}
           	} else {
           		$response['message'] = $this->strErrorMessages($chapter->getErrors());
           	}

           	echo json_encode($response);
        }   

        exit;
	}

	public function strErrorMessages($error_message)
	{
		$str = '';

		foreach($error_message as $message) {
			if(is_array($message)) {
				$str .= $this->strErrorMessages($message);
			} else {
				$str .= $message.'. ';
			}
		}

		return $str;
	}

	public function actionTest($count)
	{
		print_r(Chapter::getCategory($count));
		echo "<br/>";
		print_r(Chapter::getVotingStrength($count));
		exit;
	}
}