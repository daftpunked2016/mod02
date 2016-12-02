<?php
/* @var $this AccountController */
/* @var $account Account */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'password-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($account)); ?>

	<div class="row">
		<?php echo $form->labelEx($account,'current_password'); ?>
		<?php echo $form->passwordField($account,'current_password',array('size'=>20,'maxlength'=>16)); ?>
		<?php echo $form->error($account,'current_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($account,'new_password'); ?>
		<?php echo $form->passwordField($account,'new_password',array('size'=>20,'maxlength'=>16)); ?>
		<?php echo $form->error($account,'new_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($account,'confirm_password'); ?>
		<?php echo $form->passwordField($account,'confirm_password',array('size'=>20,'maxlength'=>16)); ?>
		<?php echo $form->error($account,'confirm_password'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Change Password'); ?>
	</div>

<?php $this->endWidget(); ?>
