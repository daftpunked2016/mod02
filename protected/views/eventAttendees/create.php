<?php
/* @var $this EventAttendeesController */
/* @var $model EventAttendees */

$this->breadcrumbs=array(
	'Event Attendees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventAttendees', 'url'=>array('index')),
	array('label'=>'Manage EventAttendees', 'url'=>array('admin')),
);
?>

<h1>Create EventAttendees</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>