<?php
/* @var $this UserBusinessController */
/* @var $model UserBusiness */

$this->breadcrumbs=array(
	'User Businesses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserBusiness', 'url'=>array('index')),
	array('label'=>'Create UserBusiness', 'url'=>array('create')),
	array('label'=>'Update UserBusiness', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserBusiness', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserBusiness', 'url'=>array('admin')),
);
?>

<h1>View UserBusiness #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'business_type_id',
		'description',
		'address',
		'street',
		'city_id',
		'province_id',
		'operating_hours',
		'account_id',
		'business_avatar',
		'status_id',
	),
)); ?>
