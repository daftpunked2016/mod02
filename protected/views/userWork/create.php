<?php
/* @var $this UserWorkController */
/* @var $model UserWork */

$this->breadcrumbs=array(
	'User Works'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserWork', 'url'=>array('index')),
	array('label'=>'Manage UserWork', 'url'=>array('admin')),
);
?>

<h1>Create UserWork</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>