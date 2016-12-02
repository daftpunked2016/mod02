<?php
/* @var $this AccountController */
/* @var $account Account */
/* @var $form CActiveForm */
?>

<div class="form" align="center">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note" style="color:#FFF;">Fields with <span class="required" style="color:#FFF;">*</span> are required.</p>

	<div class="container">
		<div class="row" style="color:#FFF;">
			<?php echo $form->errorSummary(array($account, $user)); ?>
		</div>

		<div class="row" id="show-errors">
			<div class="alert alert-danger alert-dismissible" role="alert" id="alert-messages">
			</div>
		</div>
	</div>

	<div class="col-md-6">

		<div>
			<!-- Account information -->
			<div class="panel panel-info">
				<div class="panel-heading">Log-in Credentials</div>
				<div class="panel-body">
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
								<?php echo $form->labelEx($account,'password'); ?>
							</div>
							<div class="col-sm-8">
								<?php echo $form->passwordField($account,'password',array('size'=>20,'maxlength'=>16, 'class'=>'form-control')); ?>
								<?php echo $form->error($account,'password'); ?>
							</div>
						</div>
					</div>


					<div class="row" style="margin-bottom:15px;">
						<div class="form-group">
							<div class="col-sm-4">
								<?php echo $form->labelEx($account,'confirm_password'); ?>
							</div>

							<div class="col-sm-8">
								<?php echo $form->passwordField($account,'confirm_password',array('size'=>20,'maxlength'=>16, 'class'=>'form-control')); ?>
								<?php echo $form->error($account,'confirm_password'); ?>
							</div>
						</div>
					</div>
						
						<div class="row">
							<p><font size=2><i><font color="red">Note</font>: minimum of 8 characters, maximum of 16 characters </i></font></p>
						</div>

				</div>
			</div>
		</div>

		<div>
			<!-- JCI information -->
			<div class="panel panel-info">
				<div class="panel-heading">JCI Information (Current) </div>
				<div class="panel-body">

					<div class="row" style="margin-bottom:15px;">
						<div class="form-group">
							<?php $regions = AreaRegion::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); ?>
							<div class="col-sm-4">
								<label for="area_no">Area No. *</label>
							</div>

							<div class="col-sm-8">
								<select id="area_no" name="area_no" class="form-control" required>
									<option value =''>Select Area No.</option>
									<?php 
										foreach($regions as $region)
											echo "<option value=".$region->area_no.">".$region->area_no."</option>";
									?>
								<select>
							</div>
						</div>
					</div>

					<div class="row" style="margin-bottom:15px;">	
						<div class="form-group">
							<div class="col-sm-4">
								<label for="region">Region *</label>
							</div>
							<div class="col-sm-8">
								<select id="region" name="region" class="form-control" required>
									<option value=""> -- <option>
								<select>
							</div>
						</div>
					</div>

					<div class="row" style="margin-bottom:15px;">
						<div class="form-group">
							<div class="col-sm-4">
								<label for="chapter">Chapter *</label>
							</div>
							<div class="col-sm-8">
								<select id="chapter" name="User[chapter_id]" class="form-control" required>
									<option value=""> -- <option>
								<select>
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
													'class'=>'form-control',
													'id'=>'user-title',
												));
											?>
								<?php echo $form->error($user,'title'); ?>
							</div>
						</div>
					</div>


					<div class="row" style="margin-bottom:15px;" id="user-senno">
						<div class="form-group">
							<div class="col-sm-4">
								<?php echo $form->labelEx($user,'sen_no'); ?>
							</div>
							<div class="col-sm-8">
								<?php echo $form->textField($user,'sen_no',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
								<?php echo $form->error($user,'sen_no'); ?>
							</div>
						</div>
					</div>


					<div class="row" style="margin-bottom:15px;">
			            <div class="form-group">
			              <div class="col-sm-4">
			                <label for="pos_category">Position Category *</label>
			              </div>
			              <div class="col-sm-8">
			                <select id="pos_category" name="pos_category" class="form-control" required>
			                  <option value =''> -- </option>
			                  <option value ='Local'> Local </option>
			                  <option value ='National'> National </option>
			                <select>
			              </div>
			            </div>
			         </div>


					<div class="row" style="margin-bottom:15px;">
						<div class="form-group">
							<div class="col-sm-4">
								<label for="position_id">Position *</label>
							</div>
							<div class="col-sm-8">
								<select id="position_id" name="User[position_id]" class="form-control" required>
									<option value =''> -- </option>
								<select>
							</div>
						</div>
					</div>



					<div class="row" style="margin-bottom:15px;" id="ncProject">
				        <div class="form-group">
				          <div class="col-sm-4">
				            <label for="nc_project">Project *</label>
				          </div>
				          <div class="col-sm-8">
				            <input type="text" id="reg-nc-project" name="reg-nc_project" class="form-control" value="" />
				          </div>
				        </div>
				    </div>

			      	<div class="row" style="margin-bottom:15px;" id="avpArea">
				        <div class="form-group">
				          <div class="col-sm-4">
				            <label for="avp_area">Area (assigned as AVP)*</label>
				          </div>
				          <div class="col-sm-8">
				          	<input type="text" id="reg-avp_area" name="reg-avp_area" class="form-control" value="" disabled/>
				          </div>
				        </div>
			      	</div>

				    <div class="row" style="margin-bottom:15px;" id="rvpRegion">
				        <div class="form-group">
				          <div class="col-sm-4">
				            <label for="rvp_region">Region (assigned as RVP)*</label>
				          </div>
				          <div class="col-sm-8">
							<input type="text" id="reg-rvp_reg2" name="reg-rvp_reg2" class="form-control" disabled/>
				          	<input type="hidden" id="reg-rvp_reg" name="reg-rvp_reg" class="form-control" value="" />
				          </div>
				        </div>
				    </div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<!-- Personal information -->
		<div class="panel panel-info">
			<div class="panel-heading">Personal Information</div>
			<div class="panel-body">

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
							<?php echo $form->labelEx($user,'gender'); ?>
						</div>
						<div class="col-sm-8">
							<?php echo $form->dropDownList($user,'gender',array(
												1 =>'Male',
												2 =>'Female',
											),
											array(
												'prompt' => 'Select Gender..',
												'class'=>'form-control'
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

				<!-- Profile picture -->
				<div class="row" style="margin-bottom:15px;">
					<div class="form-group">
						<div class="col-sm-4">
							<?php echo $form->labelEx($user,'Profile Picture *'); ?>
						</div>
						<div class="col-sm-8">
							<?php echo $form->fileField($user,'user_avatar', array('id'=>'user_avatar', 'class'=>'btn btn-default')); ?>
							<?php echo $form->error($user,'user_avatar'); ?>
						</div>
					</div>
				</div>

				<div class="row buttons">
					<div class="pull-right">
						<img src="<?php echo Yii::app()->baseUrl; ?>/images/load.gif" style="display:none;" id="reg-loader" />
						<?php echo CHtml::button($account->isNewRecord ? 'Register' : 'Save', array('class'=>'btn btn-lg btn-primary', 'style'=>'margin-right:20px;', 'id'=>'btn-reg', 'onclick'=>'submitSignup();')); ?>
					</div>
				</div>

			</div>
		</div>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	function submitSignup()
	{
		$('#btn-reg').attr('disabled', true);
		$('#reg-loader').fadeIn();
		var imgVal = $('#user_avatar').val(); 
        if(imgVal=='') 
        { 
            alert("You must upload a Profile Picture"); 
        }

        var form = new FormData($("#account-form")[0]);

		$.ajax({
        	url: 'http://www.jci.org.ph/mod02/index.php/account/register',
        	dataType: 'json',
        	type:'post',
        	data: form,
		    processData: false,
		    contentType: false,
        	success: function(result)
        	{
    			if(result == 1)
    			{
    				alert("Registration Successfully Completed!");
    				var successurl = "http://www.jci.org.ph/mod02/index.php/site/login";
    				$(location).attr('href',successurl);
    			}
    			else
    			{
    				$('#btn-reg').attr('disabled', false);
    				$('#reg-loader').fadeOut();
    				var error = $.map(result, function(data) { return data; });
    				var errormsg ="";

        			$.each(error, function(index, value){
        				errormsg += value +"<br />";
        			});

        			alert("Please correct the error/s.")
        			$("#alert-messages").html(errormsg)
        			$("#show-errors").fadeIn(1000);
        		}
        	},
    	    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                $('#btn-reg').attr('disabled', false);
                $('#reg-loader').fadeOut();
            }      
        });
	}
</script>