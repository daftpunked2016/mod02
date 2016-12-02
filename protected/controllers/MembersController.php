<?php

class MembersController extends Controller
{
	public $layout='//layouts/userPanel';


	public function actionIndex($s)
	{
		$user = User::model()->find(array('condition'=>'account_id = :id', 'params'=>array(':id'=>Yii::app()->user->id)));

		// REDIRECT IF USER NOT RVP && AVP
		if ($user->position_id != 8 && $user->position_id != 9 && $user->position_id != 4) {
			$this->redirect(array('account/index'));
		}

		// $positions = Position::model()->findAll();

		if ($user->position_id == 8) {
			// AVP
			$regions = AreaRegion::model()->findAll(array('condition'=>'t.area_no = :ano', 'params'=>array(':ano'=>$user->chapter->area_no)));
		} else if ($user->position_id == 9) {
			// RVP
			$regions = AreaRegion::model()->findAll(array('condition'=>'t.id = :rid', 'params'=>array(':rid'=>$user->chapter->region_id)));
		} else {
			// NT
			$regions = AreaRegion::model()->findAll();
		}

		// FILTERS
		$search_terms = "";
		if (isset($_GET['filters'])) {
			// redirect if no filters
			if ($_GET['filters']['name'] == "" && empty($_GET['filters']['age']) && empty($_GET['filters']['chapter_id']) && empty($_GET['filters']['position_id']) && empty($_GET['filters']['area_no']) && empty($_GET['filters']['region_id'])) {
				Yii::app()->user->setFlash('error', '<b>Error!</b> Please select one search filters and try again.');
				$this->redirect(array('members/index', 's'=>$s));
			}

			if (!empty($_GET['filters']['area_no'])) {
				$search_terms .= ' AND c.area_no = '.$_GET['filters']['area_no'];
			}

			if (!empty($_GET['filters']['region_id'])) {
				$search_terms .= ' AND c.region_id = '.$_GET['filters']['region_id'];
			}

			if (!empty($_GET['filters']['chapter_id'])) {
				$search_terms .= ' AND t.chapter_id = '.$_GET['filters']['chapter_id'];
			}

			if (!empty($_GET['filters']['name'])) {
				$search_terms .= ' AND CONCAT(t.firstname," ",t.lastname) LIKE "%'.$_GET['filters']['name'].'%"';
			}

			if (!empty($_GET['filters']['age'])) {
				if ($_GET['filters']['age'] == 1) {
					$search_terms .= " AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) > 40"; // ASSOC MEMBERS
				} else {
					$search_terms .= " AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) <= 40"; // REGULAR MEMBERS
				}
			}

			// if (!empty($_GET['filters']['position_id'])) {
			// 	$search_terms .= ' AND t.position_id = '.$_GET['filters']['position_id'];
			// }
		}

		if ($user->position_id == 8) {
			// AVP
			$chapters = Chapter::model()->findAll(array('condition'=>'area_no = :ano','order'=>'chapter ASC', 'params'=>array(':ano'=>$user->chapter->area_no)));

			$condition = array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.area_no = :ano '.$search_terms, 'params'=>array(':ano'=>$user->chapter->area_no));
			if ($s == 1) {
				$members = User::model()->userAccount()->isActive()->findAll($condition);
			} else {
				$members = User::model()->userAccount()->isInactive()->findAll($condition);
			}
		} else if($user->position_id == 9) {
			// RVP
			$chapters = Chapter::model()->findAll(array('condition'=>'region_id = :rno','order'=>'chapter ASC', 'params'=>array(':rno'=>$user->chapter->region_id)));

			$condition = array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'c.region_id = :rno '.$search_terms, 'params'=>array(':rno'=>$user->chapter->region_id));
			if ($s == 1) {
				$members = User::model()->userAccount()->isActive()->findAll($condition);
			} else {
				$members = User::model()->userAccount()->isInactive()->findAll($condition);
			}
		} else {
			// NT
			$chapters = Chapter::model()->findAll();

			$condition = array('join'=>'INNER JOIN jci_chapter c ON t.chapter_id = c.id', 'condition'=>'1 '.$search_terms);
			if ($s == 1) {
				$members = User::model()->userAccount()->isActive()->findAll($condition);
			} else {
				$members = User::model()->userAccount()->isInactive()->findAll($condition);
			}
		}

		$membersDP = new CArrayDataProvider($members, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		if ($s == 1) {
			$header_title = "Active Accounts";
		} else {
			$header_title = "Inactive Accounts";
		}

		$this->render('index', array(
			'user' => $user,
			's' => $s,
			'header_title' => $header_title,
			'regions' => $regions,
			'chapters' => $chapters,
			// 'positions' => $positions,
			'membersDP'=>$membersDP,
		));
	}

	public function actionList()
	{
		$user = User::model()->find(array('condition'=>'account_id = :account_id', 'params'=>array(':account_id'=>Yii::app()->user->id)));

		// REDIRECT IF USER NOT RVP && AVP
		if ($user->position_id != 8 && $user->position_id != 9 && $user->position_id != 4) {
			$this->redirect(array('account/index'));
		}

		switch ($user->position_id) {
			case 4: //NT
				$areas = AreaRegion::model()->findAll(array('select'=>'DISTINCT(area_no)'));
				$areasDP = new CArrayDataProvider($areas, array(
					'pagination' => array(
						'pageSize' => 10
					),
				));

				$this->render('list_nt', array(
					'areasDP' => $areasDP,
				));
				break;
			case 8: //AVP
				$regions = AreaRegion::model()->findAll(array('condition'=>'area_no = :area_no', 'params'=>array(':area_no'=>$user->chapter->area_no)));
				$regionsDP = new CArrayDataProvider($regions, array(
					'pagination' => array(
						'pageSize' => 10
					),
				));

				$this->render('list_avp', array(
					'user'=>$user,
					'regionsDP'=>$regionsDP
				));
				break;
			case 9: //RVP
				$chapters = Chapter::model()->findAll(array('condition'=>'region_id = :region_id', 'params'=>array(':region_id'=>$user->chapter->region_id)));

				$chaptersDP = new CArrayDataProvider($chapters, array(
					'pagination' => array(
						'pageSize' => 10
					),
				));

				$this->render('list_rvp', array(
					'chaptersDP'=>$chaptersDP
				));
				break;
		}
	}

	public function actionViewArea($ano)
	{
		$regions = AreaRegion::model()->findAll(array('condition'=>'area_no = :area_no', 'params'=>array(':area_no'=>$ano)));
		$regionsDP = new CArrayDataProvider($regions, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		$this->render('list_regions', array(
			'area_no' => $ano,
			'regionsDP' => $regionsDP,
		));
	}

	public function actionViewRegion($rid)
	{
		$region = AreaRegion::model()->findByPk($rid);
		$chapters = Chapter::model()->findAll(array('condition'=>'region_id = :rid', 'params'=>array(':rid'=>$rid)));
		$chaptersDP = new CArrayDataProvider($chapters, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		$this->render('list_chapters', array(
			'chaptersDP'=>$chaptersDP,
			'region'=>$region
		));
	}

	public function actionViewChapter($cid)
	{	
		$chapter = Chapter::model()->findByPk($cid);

		// FILTERS
		$search_terms = "";
		if (isset($_GET['filters'])) {
			// redirect if no filters
			if ($_GET['filters']['name'] == "" && empty($_GET['filters']['age'])) {
				Yii::app()->user->setFlash('error', '<b>Error!</b> Please select one search filters and try again.');
				$this->redirect(array('members/viewchapter', 'cid'=>$cid));
			}

			if (!empty($_GET['filters']['age'])) {
				if ($_GET['filters']['age'] == 1) {
					$search_terms .= " AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) > 40"; // ASSOC MEMBERS
				} else {
					$search_terms .= " AND TIMESTAMPDIFF(YEAR, t.birthdate, CURDATE()) < 41"; // REGULAR MEMBERS
				}
			}

			if (!empty($_GET['filters']['name'])) {
				$search_terms .= ' AND CONCAT(t.firstname," ",t.lastname) LIKE "%'.$_GET['filters']['name'].'%"';
			}
		}

		$condition = array('condition'=>'chapter_id = :cid '.$search_terms, 'params'=>array(':cid'=>$cid));
		$members = User::model()->isActive()->userAccount()->findAll($condition);

		$membersDP = new CArrayDataProvider($members, array(
			'pagination' => array(
				'pageSize' => 10
			),
		));

		$this->render('list_members', array(
			'chapter'=>$chapter,
			'membersDP'=>$membersDP
		));
	}
}