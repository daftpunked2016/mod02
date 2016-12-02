<?php
/* @var $this HostController */
/* @var $model Host */

$this->breadcrumbs=array(
	'Hosts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Host', 'url'=>array('index')),
	array('label'=>'Create Host', 'url'=>array('create')),
	array('label'=>'View Host', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Host', 'url'=>array('admin')),
);
?>

<h1>Update Host <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>