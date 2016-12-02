<?php
/* @var $this EventAttendeesController */
/* @var $model EventAttendees */

$this->breadcrumbs=array(
	'Event Attendees'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventAttendees', 'url'=>array('index')),
	array('label'=>'Create EventAttendees', 'url'=>array('create')),
	array('label'=>'View EventAttendees', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventAttendees', 'url'=>array('admin')),
);
?>

<h1>Update EventAttendees <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>