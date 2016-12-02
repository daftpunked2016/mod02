<?php
/* @var $this HostController */
/* @var $model Host */

$this->breadcrumbs=array(
	'Hosts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Host', 'url'=>array('index')),
	array('label'=>'Manage Host', 'url'=>array('admin')),
);
?>

<h1>Create Host</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>