<?php
/* @var $this AccountController */
/* @var $account Account */
/* @var $form CActiveForm */
?>

<div class="form col-lg-12" align="center">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($account, $user)); ?>

	<div class="col-lg-6">

		<div>
			<!-- Account information -->
			<div class="panel panel-info">
				<div class="panel-heading">Account Information</div>
				<div class="panel-body">
					<div class="row">
						<?php echo $form->labelEx($account,'username'); ?>
						<?php echo $form->textField($account,'username',array('size'=>40,'maxlength'=>40)); ?>
						<?php echo $form->error($account,'username'); ?>
					</div>


					<div class="col-lg-12">
						<div class="col-lg-2"></div>
						<div class="col-lg-4">
							<div class="row">
								<?php echo $form->labelEx($account,'password'); ?>
								<?php echo $form->passwordField($account,'password',array('size'=>16,'maxlength'=>16)); ?>
								<?php echo $form->error($account,'password'); ?>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="row">
								<?php echo $form->labelEx($account,'confirm_password'); ?>
								<?php echo $form->passwordField($account,'confirm_password',array('size'=>16,'maxlength'=>16)); ?>
								<?php echo $form->error($account,'confirm_password'); ?>
							</div>
						</div>
						<div class="col-lg-2"></div>
						<div class="col-lg-12"
							<p><font size=2><i><font color="red">Note</font>: minimum of 8 characters, maximum of 16 characters </i></font></p>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div>
			<!-- JCI information -->
			<div class="panel panel-info">
				<div class="panel-heading">JCI Information</div>
				<div class="panel-body">
					<div class="row">
						<?php $chapters = Chapter::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); ?>
						<label for="area_no">Area No.</label>
						<select id="area_no" name="area_no">
							<option value =''>Select Area No.</option>
							<?php 
								foreach($chapters as $chapter)
									echo "<option value=".$chapter->area_no.">".$chapter->area_no."</option>";
							?>
						<select>
					</div>

					<div class="row">
						<label for="region">Region</label>
						<select id="region" name="region">
							<option> -- <option>
						<select>
					</div>

					<div class="row">
						<label for="region">Chapter</label>
						<select id="chapter" name="User[chapter_id]">
							<option> -- <option>
						<select>
					</div>

					<div class="row">
						<?php $positions = Position::model()->findAll(); ?>
						<label for="position_id">Position</label>
						<select id="position_id" name="User[position_id]">
							<option value =''> -- </option>
							<?php 
								foreach($positions as $position)
									echo "<option value=".$position->id.">".$position->position."</option>";
							?>
						<select>
					</div>

					<div class="row">
						<label for="term_year">Term Year</label>
						<input type="number" id="term_year" name="term_year" required />
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		<!-- Personal information -->
		<div class="panel panel-info">
			<div class="panel-heading">Personal Information</div>
			<div class="panel-body">
				<div class="row">
					<?php echo $form->labelEx($user,'title'); ?>
					<?php echo $form->dropDownList($user,'title',array(
										1 =>'JCI SEN',
										2 =>'JCI MEM',
									),
									array(
										'prompt' => 'Select Title..',
									));
								?>
					<?php echo $form->error($user,'title'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($user,'firstname'); ?>
					<?php echo $form->textField($user,'firstname',array('size'=>40,'maxlength'=>40)); ?>
					<?php echo $form->error($user,'firstname'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($user,'middlename'); ?>
					<?php echo $form->textField($user,'middlename',array('size'=>40,'maxlength'=>40)); ?>
					<?php echo $form->error($user,'middlename'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($user,'lastname'); ?>
					<?php echo $form->textField($user,'lastname',array('size'=>40,'maxlength'=>40)); ?>
					<?php echo $form->error($user,'lastname'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($user,'contactno'); ?>
					<?php echo $form->textField($user,'contactno',array('size'=>20,'maxlength'=>20)); ?>
					<?php echo $form->error($user,'contactno'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($user,'gender'); ?>
					<?php echo $form->dropDownList($user,'gender',array(
										1 =>'Male',
										2 =>'Female',
									),
									array(
										'prompt' => 'Select Gender..',
									));
								?>
					<?php echo $form->error($user,'gender'); ?>
				</div>

				<!-- Profile picture -->
				<div class="row">
					<?php echo $form->labelEx($user,'Profile Picture'); ?>
					<?php echo $form->fileField($user,'user_avatar', array('id'=>'user_avatar', 'class'=>' btn btn-default btn-file')); ?>
					<?php echo $form->error($user,'user_avatar'); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row buttons col-lg-6">
		<?php echo CHtml::submitButton($account->isNewRecord ? 'Register' : 'Save', array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
$(document).ready(function(){
    $("#area_no").change(function(){
        $.post("http://localhost/JCI-PH/index.php/account/listRegions?area_no="+$(this).val(), function(data) {
        		$("select#region").html("<option>Select Region.. </option>" + data);
        		$("select#chapter").html("<option> -- </option>");
        });
    });

     $("#region").change(function(){
        $.post("http://localhost/JCI-PH/index.php/account/listChapters?region="+$(this).val(), function(data) {
        		$("select#chapter").html("<option>Select Chapter.. </option>" + data);
        });
    });

    $('#account-form').submit(function() 
    { 
        var imgVal = $('#user_avatar').val(); 
        if(imgVal=='') 
        { 
            alert("You must upload a Profile Picture"); 

        } 
       // return false; 

    }); 
});
</script>