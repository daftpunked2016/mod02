<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>Administrator Dashboard | JCI PH</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-black sidebar-mini">
    <div class="wrapper">

      <?php $this->widget('AdminHeader'); ?>

      <?php $this->widget('AdminLeftside'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
 		<section class="content-header">
          <h1>
            Create Survey
            <small>preview of creation of survey</small>
          </h1>
        </section>


        <script>
		$(function() {
			$(document).on('click', '#remove-option', function(){
			    $(this).parent().parent().parent('div').remove();
			});

			$( "#choice_type" ).change( function() {
				if ($(this).val() == 2) {
				  	$( "#limit-div" ).append( 
				  		'<div class="col-md-12">'+
						    '<div class="form-group">'+
						    	'<input type="number" class="form-control survey quantity" id="choice-limit" name="choice_limit" placeholder="No. of Answers Required"  />'+
						   		'<span class="label label-danger"></span>'+
						    '</div>'+
						'</div>'
				  	).hide().fadeIn();
			    } else {
			    	$( "#limit-div" ).fadeOut( function (){ 
			    		$(this).empty();
			    	});
			    }
			});

			$( "#respondents_loc_type" ).change( function() {
				var loc_inputs = "";
				var area_input = '<div class="col-md-12"><div class="form-group">'+
							    	'<select class="form-control survey" id="area_no" name="area_no">'+
							    		'<option value="">Select Area...</option>'+
							    		'<option value="1">1</option>'+
							    		'<option value="2">2</option>'+
							    		'<option value="3">3</option>'+
							    		'<option value="4">4</option>'+
							    		'<option value="5">5</option>'+
							    	'</select>'+
							    	'<span class="label label-danger"></span>'+
							    '</div></div>';
				var region_input = '<div class="col-md-12"><div class="form-group">'+
								    	'<select class="form-control survey" id="region_id" name="region_id">'+
								    		'<option value="">Select Region...</option>'+
								    	'</select>'+
								    	'<span class="label label-danger"></span>'+
							    	'</div></div>';
				var chapter_input = '<div class="col-md-12"><div class="form-group">'+
								    	'<select class="form-control survey" id="chapter_id" name="chapter_id">'+
								    		'<option value="">Select Chapter...</option>'+
								    	'</select>'+
								    	'<span class="label label-danger"></span>'+
							    	'</div></div>';


				if($(this).val() != 1) {
					$('#loc-div').empty();

					if ($(this).val() == 2) {
					  	loc_inputs += area_input;
				    } else if($(this).val() == 3) {
				    	loc_inputs += area_input + region_input;
				    } else  {
				    	loc_inputs += area_input + region_input + chapter_input;
				    }

				    $('#loc-div').append(loc_inputs).hide().fadeIn();
				} else {
					emptyLocDiv();
				} 
			});
		});

		function emptyLocDiv() {
			$( "#loc-div" ).fadeOut( function (){ 
				$(this).empty();
			});
		}

		function createSurvey() {
			errors = 0;

			$( ".survey" ).each(function( index ) {
				if ($(this).val() === "") {
				  	$(this).next("span").html( "<b>Required!</b>" ).show().delay(3000).fadeOut( 4000 );
			      	errors++;
			    }
			});

			if($("#choice_type").val() == 2) {
				if($("#choice-limit").val() >= $(".choices").length) {
					errors++
					alert("Answer options should be greater than the no. of answer choices required.");
				}
			}

			if (errors>0){
		        return false;   
		    } else {
		    	var form = $("#create-survey-form");

		    	$.ajax({
				   url: location.origin+"/mod02/index.php/admin/survey/createsurvey",
				   method: "POST",
				   data: form.serialize(),
				   success: function(response) {
				   		func_response = jQuery.parseJSON(response);
				   		//results = response;
				   },
				   complete: function() {
			   		if(func_response.type) {
			   			alert(func_response.message);
				   		 window.location.href = location.origin+"/mod02/index.php/admin/survey/index";
			   		} else {
			   			alert(func_response.message);
			   		}	
			   },
			   error: function() {
			   		alert("ERROR in running requested function. Page will now reload.");
			   		location.reload();
			   }
				});
		    }
		}

		function addNewOption(){
		  var newdiv = document.createElement('div');
		  var choices_count = $(".choices").length;
		  newdiv.innerHTML = 
		  	'<div class="input-group"><input type="text" class="form-control choices survey" id="answer-choices[]" name="answer_choices[]" placeholder="Answer Option '+ (choices_count + 1) +'" />'+
		  	'<span class="label label-danger"></span>'+
			'<div class="input-group-btn"><span class="btn btn-danger" id="remove-option" style="cursor:pointer;"><i class="fa fa-remove"></i></span></div></div>'+
			'<br />';
		  document.getElementById("new-options").appendChild(newdiv);
		}
		</script>
		<style>
			.form-control {
				font-size: 16px;
			}

			hr {
				margin-top:5px;
			}
			br {
				margin-bottom:5px;
			}
		</style>
        <!-- Main content -->
      	<section class="content">
			<form method="post" id="create-survey-form">
			<div class="row" style="padding:20px;">
				<div class="col-md-12">
					<div class="panel panel-default">
					  <div class="panel-heading">
					  	<h2>
					  		<span class="glyphicon glyphicon-plus" style="margin-right:15px;"></span>Create New Survey Form
					  	</h2>
					  </div>
					  <div class="panel-body">
					  	<div class="col-md-12" style="margin-bottom:10px;">
							<span class="glyphicon glyphicon-chevron-right" style="margin-right:10px;"></span><i style="font-size:16px;">Form Properties</i>
						</div>

					  	<div class="col-md-12">
						    <div class="form-group">
						    	<input type="text" class="form-control survey" id="title" name="title" placeholder="Survey Title..."  />
						    	<span class="label label-danger"></span>
						    </div>
						</div>

						<div class="col-md-12">
						    <div class="form-group">
						    	<textarea class="form-control survey" id="question" name="question"  rows="3" placeholder="Survey Question..." style="resize: none;" ></textarea>
						    	<span class="label label-danger"></span>
						    </div>
						</div>

						<div class="col-md-12">
						    <div class="form-group">
						    	<select class="form-control survey" id="choice_type" name="choice_type">
						    		<option value="">Select Question Type...</option>
						    		<option value="1">Multiple Choice (1 Answer)</option>
						    		<option value="2">Checkboxes (Multiple Answers)</option>
						    	</select>
						    	<span class="label label-danger"></span>
						    </div>
						</div>

						<div id="limit-div">
							<!-- form input for required no. of answers (for checkboxes) -->
						</div>

						<div class="col-md-12">
							<hr />
						</div>

						<div class="col-md-12" style="margin-bottom:10px;">
							<span class="glyphicon glyphicon-chevron-right" style="margin-right:10px;"></span><i style="font-size:16px;">Answer Options</i>
						</div>

						<div class="col-md-12">
							<div class="well">
							    <div class="form-group">
							    	<input type="text" class="form-control choices survey" id="answer-choices[]" name="answer_choices[]" placeholder="Answer Option 1"  />
							    	<span class="label label-danger"></span>
							    	<br />

							    	<input type="text" class="form-control choices survey" id="answer-choices[]" name="answer_choices[]" placeholder="Answer Option 2"  />
							    	<span class="label label-danger"></span>
							    	<br />

							    	<div id="new-options">
							    	</div>
							    </div>

								<span class="btn btn-primary btn-sm btn-flat" id="addNewOption" onclick="addNewOption(); return false;"><span class="glyphicon glyphicon-plus" style="margin-right:5px;"></span>Click to Add New Option</span>
						   	</div>
						</div>

						<div class="col-md-12">
							<hr />
						</div>

						<div class="col-md-12" style="margin-bottom:10px;">
							<span class="glyphicon glyphicon-chevron-right" style="margin-right:10px;"></span><i style="font-size:16px;">Respondents Settings</i>
							<span class="label label-danger"></span>
						</div>

						<div class="col-md-12">
							<div class="form-group">
						    	<select class="form-control survey" id="respondents_type" name="respondents_type">
						    		<option value="">Select Respondents Type...</option>
						    		<option value="1">* All</option>
						    		<option value="2">JCI SEN</option>
						    		<option value="3">JCI MEM</option>
						    		<option value="4">Presidents</option>
						    		<option value="5">Secretaries</option>
						    		<option value="6">National Board Positions</option>
						    		<option value="7">Local Positions</option>
						    		<option value="8">ND/NC</option>
						    	</select>
						    	<span class="label label-danger"></span>
						    </div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
						    	<select class="form-control survey" id="respondents_loc_type" name="respondents_loc_type">
						    		<option value="">Select Group Type (by Location) ...</option>
						    		<option value="1">* All</option>
						    		<option value="2">By Area</option>
						    		<option value="3">By Region</option>
						    		<option value="4">By Chapter</option>
						    	</select>
						    	<span class="label label-danger"></span>
						    </div>
						</div>

						<div id="loc-div">
							<!-- form inputs for area, region, chapter -->
						</div>

						<div class="col-md-12" style="margin-top:15px;">
							<div class="form-group pull-right">
								<?php echo CHtml::link('Cancel', array('survey/index'), array('class'=>'btn btn-lg btn-danger btn-flat')); ?>
						    	<span class="btn btn-lg btn-success btn-flat" id="createSurvey" onclick="createSurvey(); return false;"> Create Survey </span>
						    </div>
						</div>
					  </div>
					</div>

				</div>

			</div>
			</form>
		</section><!-- /.content -->

      </div><!-- /.content-wrapper -->

      <?php $this->widget('UserFooter'); ?>
	  
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-scripts.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/demo.js" type="text/javascript"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->

 	<script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
  </body>
</html>