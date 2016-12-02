<?php
/* @var $this UserBusinessController */
/* @var $model UserBusiness */

$this->breadcrumbs=array(
	'User Businesses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserBusiness', 'url'=>array('index')),
	array('label'=>'Manage UserBusiness', 'url'=>array('admin')),
);
?>

<h1>Create UserBusiness</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>