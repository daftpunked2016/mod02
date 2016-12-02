<?php
/* @var $this UserWorkController */
/* @var $model UserWork */

$this->breadcrumbs=array(
	'User Works'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserWork', 'url'=>array('index')),
	array('label'=>'Create UserWork', 'url'=>array('create')),
	array('label'=>'View UserWork', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserWork', 'url'=>array('admin')),
);
?>

<h1>Update UserWork <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>