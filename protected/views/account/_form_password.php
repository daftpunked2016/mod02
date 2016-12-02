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


	<div class="container">
      <div class="row" style="color:#FFF;">
        <?php echo $form->errorSummary($account); ?>
      </div>
    </div>

    <div class="col-md-3"></div>
  	<div class="col-md-6">
  		<div class="well">
			<div class="row" style="margin-bottom:15px;">
	            <div class="form-group">
	              <div class="col-sm-4">
	               <?php echo $form->labelEx($account,'current_password'); ?>
	              </div>
	              <div class="col-sm-8">
	                <?php echo $form->passwordField($account,'current_password',array('size'=>20,'class'=>'form-control', 'maxlength'=>16, 'required'=>'true')); ?>
	                <?php echo $form->error($account,'current_password'); ?>
	              </div>
	            </div>
          	</div>

			<div class="row" style="margin-bottom:15px;">
	            <div class="form-group">
	              <div class="col-sm-4">
	               <?php echo $form->labelEx($account,'new_password'); ?>
	              </div>
	              <div class="col-sm-8">
	                <?php echo $form->passwordField($account,'new_password',array('size'=>20,'class'=>'form-control', 'maxlength'=>16, 'required'=>'true')); ?>
	                <?php echo $form->error($account,'new_password'); ?>
	              </div>
	            </div>
          	</div>

			<div class="row" style="margin-bottom:15px;">
	            <div class="form-group">
	              <div class="col-sm-4">
	               <?php echo $form->labelEx($account,'confirm_password'); ?>
	              </div>
	              <div class="col-sm-8">
	                <?php echo $form->passwordField($account,'confirm_password',array('size'=>20,'class'=>'form-control', 'maxlength'=>16, 'required'=>'true')); ?>
	                <?php echo $form->error($account,'confirm_password'); ?>
	              </div>
	            </div>
          	</div>


	      <div class="row buttons">
	        <?php echo CHtml::submitButton('Change Password', array('class'=>'btn btn-lg btn-primary pull-right', 'style'=>'margin-right:20px;')); ?>
	      </div>
		</div>	
	</div>
	<div class="col-md-3"></div>

<?php $this->endWidget(); ?>
</div>
