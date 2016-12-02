<?php
/* @var $this HostController */
/* @var $model Host */

$this->breadcrumbs=array(
	'Hosts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Host', 'url'=>array('index')),
	array('label'=>'Create Host', 'url'=>array('create')),
	array('label'=>'Update Host', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Host', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Host', 'url'=>array('admin')),
);
?>

<h1>View Host #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'account_id',
		'username',
		'password',
		'salt',
		'account_type_id',
		'date_created',
		'date_updated',
		'status_id',
	),
)); ?>
