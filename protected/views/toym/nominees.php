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


<?php 
switch($status) {
	case 1:
		$status_str = "APPROVED";
		break;
	case 2:
		$status_str = "Pending to NC/Admin";
		break;
	case 3:
		$status_str = "Pending to AC";
		break;
	default:
		$status_str = "*ALL";
}
?>
<h1>Nominations <em class="text-muted">(<?= $status_str; ?>)</em></h1>
</section>
<section class="content">
	<div class="well" style="padding: 10px;">
		<div class="row">
			<form method="GET">
				<div class="col-md-6">
					<div class="form-group">
						<label for="credentials">Search</label>
						<input type="text" class="form-control" name="credentials" placeholder="Nominee Name / Nominee E-mail / Nominator Name" value="<?= (isset($_GET['credentials'])) ? $_GET['credentials'] : null; ?>" />
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="status">Status</label>
						<select class="form-control" name="status">
							<option value="">*ALL</option>
							<option value="1" <?= (isset($_GET['status']) && $_GET['status'] == 1) ? 'selected' : null; ?> >Approved</option>
							<option value="2"  <?= (isset($_GET['status']) && $_GET['status'] == 2) ? 'selected' : null; ?>>Pending</option>
							<option value="3"  <?= (isset($_GET['status']) && $_GET['status'] == 3) ? 'selected' : null; ?>>Pending to AC</option>
						</select>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<button class="btn btn-info pull-right"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="box">
	            <div class="box-header with-border">
	              <h3 class="box-title">Nominees List</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
				<?php  $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$nomineesDP,
					'itemView'=>'_view_nominees',
					'viewData' => array("status" => $status),
					'template' => "{sorter}<table id=\"example1\" class=\"table table-bordered table-hover\">
					<thead class='panel-heading'>
						<th>Title</th>
						<th>Name</th>
						<th>E-mail</th>
						<th>Category</th>
						<th>Nominator</th>
						<th>Date Nominated</th>
						<th>Status</th>
						<th>Action</th>
					</thead>
					<tbody>
						{items}
					</tbody>
					</table>
					{pager}",
					'emptyText' => "<tr><td colspan=\"7\">No available entries</td></tr>",
				));  ?>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" tabindex="-1" role="dialog" id="viewDetailsModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-search"></i> View Nomination Details</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
	$(document).on('click', '.btn-view-details', function() {
		$('.btn-actions').prop('disabled', true);
		var $btn = $(this).button('loading');

		$.ajax({
	         url: 'http://jci.org.ph/2017TOYMmod/site/viewdetails',
	         method: "POST",
	         data: {'id': $(this).data('id')},
	         success: function(response) {
	            	details_html = response;
	         },
	         complete: function() {
	         	$('.btn-actions').prop('disabled', false);
	         	$btn.button('reset');
	            
	         	$('#viewDetailsModal').find('.modal-body').html(details_html);
	         	$('#viewDetailsModal').modal('show');
	         },
	         error: function() {
	              alert("ERROR in running requested function. Page will now reload.");
	              location.reload();
	         }
	    });
	});
});
</script>