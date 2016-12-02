<?php
/* @var $this EventController */
/* @var $data Event */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_type')); ?>:</b>
	<?php echo CHtml::encode($data->event_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coverage')); ?>:</b>
	<?php echo CHtml::encode($data->coverage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('host_chapter_id')); ?>:</b>
	<?php echo CHtml::encode($data->host_chapter_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('host_chair_name')); ?>:</b>
	<?php echo CHtml::encode($data->host_chair_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('host_chair_email')); ?>:</b>
	<?php echo CHtml::encode($data->host_chair_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('venue')); ?>:</b>
	<?php echo CHtml::encode($data->venue); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo CHtml::encode($data->status_id); ?>
	<br />

	*/ ?>

</div>