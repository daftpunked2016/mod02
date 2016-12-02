<?php
/* @var $this EventAttendeesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Event Attendees',
);

$this->menu=array(
	array('label'=>'Create EventAttendees', 'url'=>array('create')),
	array('label'=>'Manage EventAttendees', 'url'=>array('admin')),
);
?>

<h1>Event Attendees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
