<?php
/* @var $this EventAttendeesController */
/* @var $model EventAttendees */

$this->breadcrumbs=array(
	'Event Attendees'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EventAttendees', 'url'=>array('index')),
	array('label'=>'Create EventAttendees', 'url'=>array('create')),
	array('label'=>'Update EventAttendees', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventAttendees', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventAttendees', 'url'=>array('admin')),
);
?>

<h1>View EventAttendees #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'account_id',
		'event_id',
		'payment_status',
		'account_attendee_type',
	),
)); ?>
