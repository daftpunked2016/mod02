<?php
/* @var $this UserWorkController */
/* @var $model UserWork */

$this->breadcrumbs=array(
	'User Works'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserWork', 'url'=>array('index')),
	array('label'=>'Create UserWork', 'url'=>array('create')),
	array('label'=>'Update UserWork', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserWork', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserWork', 'url'=>array('admin')),
);
?>

<h1>View UserWork #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'work_type_id',
		'company_name',
		'position',
		'address',
		'city_id',
		'province_id',
		'account_id',
		'status_id',
	),
)); ?>
