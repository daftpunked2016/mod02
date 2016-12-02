<?php
/* @var $this AccountController */
/* @var $account Account */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<div class="container">
      <div class="row" style="color:#FFF;">
        <?php echo $form->errorSummary(array($account,$user)); ?>
      </div>
    </div>

    <div class="row">
	    <div class="col-md-3"></div>
	  	<div class="col-md-6">
	  		<div class="well">

				<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			            <?php echo $form->labelEx($account,'username'); ?>
			          </div>
			          <div class="col-sm-8">
			            <?php echo $form->textField($account,'username',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
			            <?php echo $form->error($account,'username'); ?>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			            <?php echo $form->labelEx($user,'title'); ?>
			          </div>
			          <div class="col-sm-8">
			           	<?php echo $form->dropDownList($user,'title',array(
										1 =>'JCI SEN',
										2 =>'JCI MEM',
									),
									array(
										'prompt' => 'Select Title..',
										'class' =>'form-control',
									));
								?>
					<?php echo $form->error($user,'title'); ?>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			           	<?php echo $form->labelEx($user,'firstname'); ?>
			          </div>
			          <div class="col-sm-8">
						<?php echo $form->textField($user,'firstname',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
						<?php echo $form->error($user,'firstname'); ?>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			           	<?php echo $form->labelEx($user,'lastname'); ?>
			          </div>
			          <div class="col-sm-8">
						<?php echo $form->textField($user,'lastname',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
						<?php echo $form->error($user,'lastname'); ?>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			           	<?php echo $form->labelEx($user,'middlename'); ?>
			          </div>
			          <div class="col-sm-8">
						<?php echo $form->textField($user,'middlename',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
						<?php echo $form->error($user,'middlename'); ?>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
					<div class="form-group">
						<div class="col-sm-4">
							<?php echo $form->labelEx($user,'birthdate'); ?>
						</div>
						<div class="col-sm-8">
							<?php
								$this->widget('zii.widgets.jui.CJuiDatePicker', array(
									'model' => $user,
									'attribute' => 'birthdate',
									'options'=>array(
										'showAnim'=>'slideDown',
										'yearRange'=>'-60:-18',
										'changeMonth' => true,
										'changeYear' => true,
										'dateFormat' => 'yy-mm-dd'
										),
									'htmlOptions' => array(
										'size' => 20,         // textField size
										'class' => 'form-control',

									),	
								));
							?>
							<?php echo $form->error($user,'birthdate'); ?>
						</div>
					</div>
				</div>

				<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			           	<?php echo $form->labelEx($user,'gender'); ?>
			          </div>
			          <div class="col-sm-8">
							<?php echo $form->dropDownList($user,'gender',array(
												1 =>'Male',
												2 =>'Female',
											),
											array(
												'prompt' => 'Select Gender..',
												'class' => 'form-control',
											));
										?>
							<?php echo $form->error($user,'gender'); ?>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			           	<?php echo $form->labelEx($user,'contactno'); ?>
			          </div>
			          <div class="col-sm-8">
						<?php echo $form->textField($user,'contactno',array('size'=>20,'maxlength'=>20, 'class'=>'form-control')); ?>
						<?php echo $form->error($user,'contactno'); ?>
			          </div>
			        </div>
		      	</div>

		   		<div class="row" style="margin-bottom:15px;">
					<div class="form-group">
						<div class="col-sm-4">
							<?php echo $form->labelEx($user,'address'); ?>
						</div>
						<div class="col-sm-8">
							<?php echo $form->textField($user,'address',array('size'=>50,'maxlength'=>128, 'class'=>'form-control')); ?>
							<?php echo $form->error($user,'address'); ?>
						</div>
					</div>
				</div>


		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			          	<?php 
			          		$chapters = Chapter::model()->findAll(array('select'=>'area_no', 'distinct'=>true));
			          		$userchapter = Chapter::model()->find("id = ".$user->chapter_id);
			          		$userregion = AreaRegion::model()->find("id = ".$userchapter->region_id);	  
			          	?>
			           	<label for="area_no">Area No.</label>
			          </div>
			          <div class="col-sm-8">
							<select id="area_no" name="area_no" class="form-control">
								<option value="<?php echo $userchapter->area_no; ?>" selected disabled> <?php echo $userchapter->area_no; ?> </option>
								<?php 
									foreach($chapters as $chapter)
										echo "<option value=".$chapter->area_no.">".$chapter->area_no."</option>";
								?>
							<select>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			          	<label for="region">Region</label>
			          </div>
			          <div class="col-sm-8">
							<select id="region" name="region" class="form-control">
								<option value="<?php echo $userregion->id; ?>" selected disabled> <?php echo $userregion->region; ?> </option>
							<select>
			          </div>
			        </div>
		      	</div>

		      	<div class="row" style="margin-bottom:15px;">
			        <div class="form-group">
			          <div class="col-sm-4">
			          	<label for="region">Chapter</label>
			          </div>
			          <div class="col-sm-8">
						<select id="chapter" name="User[chapter_id]" class="form-control">
							<option value="<?php echo $userchapter->id; ?>" selected disabled> <?php echo $userchapter->chapter; ?> </option>
						<select>
			          </div>
			        </div>
		      	</div>

		      <div class="row buttons">
		        <?php echo CHtml::submitButton('Save Profile', array('class'=>'btn btn-lg btn-primary pull-right', 'style'=>'margin-right:20px;')); ?>
		      </div>
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->