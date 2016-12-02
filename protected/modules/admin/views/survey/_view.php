<tr>
	<td><?php echo CHtml::encode($data->title); ?></td>
	<td><?php echo CHtml::encode($data->question); ?></td>
	<td><?php echo SurveyQuestionnaires::model()->getResType($data->respondents_type); ?></td>
	<td>
		<?php 
			if($data->respondents_loc_type == 1){
				echo "All";
			}elseif ($data->respondents_loc_type == 2){
				echo "Area - ".$data->respondents_loc;
			}elseif ($data->respondents_loc_type == 3){
				echo "Region - ".AreaRegion::model()->getName($data->respondents_loc);
			}elseif ($data->respondents_loc_type == 4){
				echo "Chapter - ".Chapter::model()->getName($data->respondents_loc);
			}
		?>
	</td>
	<td>
		<?php
			if($data->status_id == 1)
			{
				echo "<span class='label label-success'>Active</span>";
			}else{
				echo "<span class='label label-danger'>Disabled</span>";
			}
		?>
	</td>
	<td>
		<div class="dropdown">
			<button class="btn btn-default btn-flat dropdown-toggle" type="button" data-toggle="dropdown">
				<span class="fa fa-cog"></span>
				<span class="caret"></span>
			</button>
	    	<ul class="dropdown-menu dropdown-menu-right">
	    		<li>
			    	<?php echo CHtml::link('<span class="fa fa-search"></span> View',array('survey/viewresults', 'id'=>$data->id), array('title'=>'Edit Survey')); ?>
			    </li>
			    <li>
			    	<?php echo CHtml::link('<span class="fa fa-edit"></span> Edit',array('survey/update', 'id'=>$data->id), array('title'=>'Edit Survey')); ?>
			    </li>
			    <li class="divider"></li>
			    <li>
			    	<?php
			    		if($data->status_id == 1){
			    			echo CHtml::link('<span class="fa fa-times"></span>Disable',array('survey/disable', 'id'=>$data->id), array('title'=>'Disable Survey', 'confirm'=>'Are you sure you want to Disable this Survey?'));
			    		}else{
			    			echo CHtml::link('<span class="fa fa-check"></span>Activate',array('survey/activate', 'id'=>$data->id), array('title'=>'Activate Survey', 'confirm'=>'Are you sure you want to Activate this Survey?'));
			    		}
			    	?>
			    </li>
		    </ul>
		</div>
	</td>
</tr>