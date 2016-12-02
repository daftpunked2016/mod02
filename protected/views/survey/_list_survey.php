<tr class="<?php if($data->res_answers == null) echo "danger"; ?>" >
	<td class="survey-item" data-href="<?php echo Yii::app()->baseUrl; ?>/index.php/survey/answersurvey?q=<?php echo $data->id; ?>">
		<?php
		 echo "<a href='".Yii::app()->baseUrl."/index.php/survey/answersurvey?q=". $data->id."'>".$data->title."</a>"; 

		 if($data->res_answers == null)
		 	echo "<span class='badge bg-red' style='margin-left:5px;' data-toggle='tooltip' data-original-title='Survey not answered yet.'>!</span>";
		?>
	</td>
	<td><?php echo SurveyQuestionnaires::model()->getResType($data->respondents_type); ?></td>
	<td><?php echo SurveyQuestionnaires::model()->getLocation($data->respondents_loc_type, $data->respondents_loc); ?></td>
	<td><?php echo date('M. d, Y H:i', $data->date_created); ?></td>
	<td style="text-align:center;">
		<?php if($data->res_answers == null): ?>
			<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/survey/answersurvey?q=<?php echo $data->id; ?>" data-toggle='tooltip' data-original-title='Answer Survey'><span class="fa fa-edit" style="margin-right:5px;"></span></a>
		<?php else: ?>
			<a href="<?php echo Yii::app()->baseUrl; ?>/index.php/survey/answersurvey?q=<?php echo $data->id; ?>" data-toggle='tooltip' data-original-title='View Survey'><span class="fa fa-search" style="margin-right:5px;"></span></a>
		<?php endif; ?>
		<!-- <a href="#" onclick="deleteAnswer(<?php //echo $data->res_answers[0]->id ?>)" data-toggle='tooltip' data-original-title='Delete Answer'><span class="fa fa-trash" style="margin-right:5px;"></span></a> -->
	</td>
</tr>

