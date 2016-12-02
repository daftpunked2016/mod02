<?php
/* @var $this UserBusinessController */
/* @var $model UserBusiness */

$this->breadcrumbs=array(
	'User Businesses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserBusiness', 'url'=>array('index')),
	array('label'=>'Create UserBusiness', 'url'=>array('create')),
	array('label'=>'View UserBusiness', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserBusiness', 'url'=>array('admin')),
);
?>

<h1>Update UserBusiness <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>