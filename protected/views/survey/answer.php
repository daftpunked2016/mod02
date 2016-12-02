<script>
function submitSurveyAnswer(id, limit) {
	errors = 0;
	checked = 0;
	var answer = [];

	$( ".answers" ).each(function( index ) {
		if ($(this).is(':checked')) {
		  	checked++;
		  	answer.push($(this).val());
	    }
	});


	if(checked == 0) {
		errors++;
		alert("You must select an answer first!");
	}

	if(limit != null) {
		if(limit < checked) {
			errors++;
			alert("You must only select "+ limit +" answers.");
		}
	}


	if (errors>0){
        return false;   
    } else {
    	answer_json = JSON.stringify(answer);
    	
    	$.ajax({
		   url: location.origin+"/mod02/index.php/survey/submitanswer",
		   method: "POST",
		   data: { id: id, answer : answer_json },
		   success: function(response) {
		   		func_response = jQuery.parseJSON(response);
		   		//results = response;
		   },
		   complete: function() {
	   		if(func_response.type) {
	   			alert(func_response.message);
		   		window.location.href = location.origin+"/mod02/index.php/survey/list";
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
</script>
<style>
	.answer-choices {
		font-size:17px;
	}

	.answer-choices label {
		margin-bottom: 5px;
	}

	.answer-choices span {
		margin-left: 7px;
	}

	hr {
		margin: -1px;
	}

	.answer-choices:hover {
    	font-size:18px;
	}

</style>

<section class="content">
	<form method="post" id="answer-survey-form">
	<div class="row" style="padding:20px;">

		<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
		if($key  === 'success')
			{
			echo "<div class='alert alert-success alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		else
			{
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
			}
		}
		?>

		<div class="col-md-1"></div>

		<div class="col-md-10">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			  	<h3>
			  		<span class="fa fa-check-square-o" style="margin-right:15px;"></span><?php echo $questionnaire->title; ?>
			  	</h3>
			  </div>
			  <div class="panel-body">
			  	<div class="col-md-12" style="margin-bottom:10px; font-size:17px;">
					<span class="fa fa-question-circle" style="margin-right:10px;"></span><i>Question</i>
				</div>

				<div class="col-md-12" style="margin-bottom:15px;">
					<span style="margin-left:30px; font-size:16px;"><?php echo $questionnaire->question; ?></span>
				</div>

				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<?php 
								if($questionnaire->ans_choices->choice_type == 2)
									echo "<small><i style='margin-top:20px;'>Please select ".$questionnaire->ans_choices->choice_limit." items.</i></small>";
						?>
						<div class="well" style="padding:0px 20px; margin-top:10px;">
							<?php
								if($res_answer) {
									$answers = json_decode($res_answer->answer);
								} else {
									$answers = null;
								}

								foreach($conv_answer_options as $key=>$ans) {
									echo "<div class='".$input_type." answer-choices'>";
									if($ans_choices->choice_type == 2) {
										echo "<label>
											    <input type='".$input_type."' value='".$key."' name='survey_answer".$key."' class='answers' "; 
										
										if($answers) {
											if(in_array($key, $answers))
												echo "checked";
										}

										if($res_answer) {
											echo " disabled";
										}

										echo "><span>".$ans."</span>
											  </label>";
									}
									else {
										echo "<label>
											    <input type='".$input_type."' value='".$key."' name='survey_answer' class='answers' ";

										if($answers) {
											if(in_array($key, $answers))
												echo "checked";
										}

										if($res_answer) {
											echo " disabled";
										}

										echo "><span>".$ans."</span>
											  </label>";
									}

									echo "</div> <hr />";
								}
							?>
						</div>
					</div>
					<div class="col-md-1"></div>
				</div>

				<div class="col-md-12" style="margin-top:10px;">
					<div class="form-group pull-right">
						<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/survey/list" class="btn btn-danger" id="cancel" style="margin-right:10px;">
							<?php if($res_answer == null) echo "Cancel"; else echo "Back"; ?>
						</a>
				    	
				    	<?php if($res_answer == null): ?>
					    	<span class="btn btn-success" id="createSurvey" 
					    	onclick="submitSurveyAnswer(<?php echo $id; if($ans_choices->choice_limit) echo ", ".$ans_choices->choice_limit; ?>); return false;"> 
					    	Submit Answer
					    	</span>
					    <?php endif; ?>
				    </div>
				</div>
			  </div>
			</div>

		</div>

		<div class="col-md-1"></div>

	</div>
	</form>
</section><!-- /.content -->