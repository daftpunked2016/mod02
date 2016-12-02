<script>

</script>
<style>

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

		<div class="col-md-12">
			<div class="panel panel-default">
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

				<div class="col-md-12">
					<div class="well">
						<?php 
							foreach($conv_answer_options as $key=>$ans) {
								echo "<div class='".$input_type."'>";
								if($ans_choices->choice_type == 2)
									echo "<label>
										    <input type='".$input_type."' value='".$key."' name='survey_answer".$key."' class='answers'>
										 	".$ans."
										  </label>";
								else 
									echo "<label>
										    <input type='".$input_type."' value='".$key."' name='survey_answer' class='answers'>
										 	".$ans."
										  </label>";
								echo "</div>";
							}
						?>
					</div>
				</div>

				<div class="col-md-12" style="margin-top:15px;">
					<div class="form-group pull-right">
						<button class="btn btn-lg btn-danger" id="cancel" style="margin-right:10px;"> Cancel </button>
				    	<span class="btn btn-lg btn-success" id="createSurvey" onclick="createSurvey(); return false;"> Submit Answer</span>
				    </div>
				</div>
			  </div>
			</div>

		</div>

	</div>
	</form>
</section><!-- /.content -->