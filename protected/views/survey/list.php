<script>
$(function() {
	$('#status').change(function() {
		$("#status-select").submit();
	});

	$('td.survey-item').on("click", function() {
	     window.location.href =  $(this).data('href');
	});
});

function deleteAnswer(id)
{
	if(confirm('Are you sure you want to delete your for this selected survey?')) {
		$.ajax({
		   url: location.origin+"/mod02/index.php/survey/deleteanswer",
		   method: "POST",
		   data: { id: id },
		   success: function(response) {
		   		func_response = jQuery.parseJSON(response);
		   		//results = response;
		   },
		   complete: function() {
	   		if(func_response.type) {
	   			alert(func_response.message);
		   		location.reload();
	   		} else {
	   			alert(func_response.message);
	   		}	
		   },
		   error: function() {
		   		alert("ERROR in running requested function. Page will now reload.");
		   		location.reload();
		   }
		});
	} else {
		return false;
	}
}
</script>

<style>
th {
	background: #222d32;
	color: #FFF;
	text-align:center;
}
</style>


<section class="content-header">
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

	<h1>
		<span class="fa fa-book"></span> Survey Questionnaires List
	</h1>
</section>

<section class="content">
	<div class="box" style="margin-top:10px;">
		<div class="box-header">
			<div class="pull-left">
				<h4>Survey List</h4>
			</div>
			<div class="pull-right">
				<form id="status-select" method="GET">
					<select id="status" name="s" class="form-control">
						<option value="">Select Status..</option>
						<option value=""> * All</option>
						<option value="1">Answered</option>
						<option value="2">Unanswered</option>
					</select>
				</form>
			</div>
		</div>
		<!-- <div class="box-body table-responsive no-padding"> -->
		<div class="box-body table-responsive">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$questionnairesDP,
				'itemView'=>'_list_survey',
				'viewData'=>array('user'=>$user),
				'template' => "{sorter}<table id=\"surveyTable\" class=\"table table-hover table-bordered\">
				<thead class='panel-heading'>
					<th width='30%'>Survey Title</th>
					<th width='20%'>Addressed to</th>
					<th width='20%'>Location</th>
					<th width='15%'>Date Created</th>
					<th width='15%'>Actions</th>
				</thead>
				<tbody>
					{items}
				</tbody>
				</table>
				<br/>
				{pager}",
				'emptyText' => "<tr><td colspan=\"5\">No available entries</td></tr>",
			));  ?>
		</div>
	</div>
	<div class="row"></div>
</section>