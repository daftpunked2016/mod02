<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'event_type'); ?>
		<?php echo $form->textField($model,'event_type'); ?>
		<?php echo $form->error($model,'event_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coverage'); ?>
		<?php echo $form->textField($model,'coverage'); ?>
		<?php echo $form->error($model,'coverage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'host_chapter_id'); ?>
		<?php echo $form->textField($model,'host_chapter_id'); ?>
		<?php echo $form->error($model,'host_chapter_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'host_chair_name'); ?>
		<?php echo $form->textField($model,'host_chair_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'host_chair_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'host_chair_email'); ?>
		<?php echo $form->textField($model,'host_chair_email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'host_chair_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'venue'); ?>
		<?php echo $form->textField($model,'venue',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'venue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->textField($model,'status_id'); ?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->