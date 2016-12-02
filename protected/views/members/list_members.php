<section class="content-header">
	<h1>
		<?php echo $chapter->chapter; ?>
		<small>members list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link('Membership List', array('members/list')); ?>
		</li>
		<li class="active"><?php echo $chapter->chapter; ?></li>
	</ol>
	<?php 
		foreach(Yii::app()->user->getFlashes() as $key=>$message) {
		  	if($key  === 'success') {
		        echo "<div class='alert alert-success alert-dismissible' role='alert' style='margin-bottom:5px'>
		        <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
		        $message.'</div>';
	        } else {
		        echo "<div class='alert alert-danger alert-dismissible' role='alert' style='margin-bottom:5px'>
		        <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
		        $message.'</div>';
		        }
		}
	?>
</section>

<section class="content-header">
	<div class="well">
		<h4>
			Search Filters
		</h4>
		<form method="get" action="<?php echo Yii::app()->createUrl('members/viewchapter', array('cid'=>$chapter->id)); ?>">
			<input type="hidden" name="cid" value="<?php echo $chapter->id; ?>">
			<div class="row">
				<div class="col-md-3">
					<label>Membership Type</label>
					<select class="form-control" name="filters[age]">
						<option value="">Select Type</option>
						<option value="1" <?php if(isset($_GET['filters']['age'])) { if($_GET['filters']['age'] == 1) { echo "selected"; }} ?>>Associate Members (40+)</option>
						<option value="2" <?php if(isset($_GET['filters']['age'])) { if($_GET['filters']['age'] == 2) { echo "selected"; }} ?>>Regular Members (40-)</option>
					</select>
				</div>

				<div class="col-md-3">
					<label>Name</label>
					<input type="text" class="form-control" name="filters[name]" placeholder="Name" value="<?php if(isset($_GET['filters']['name'])) { echo $_GET['filters']['name']; } ?>">
				</div>

				<div class="col-md-1 col-xs-6">
					<br>
					<input type="submit" name="search" value="Search" class="btn btn-primary btn-flat">
				</div>

				<div class="col-md-1 col-xs-6">
					<br>
					<?php echo CHtml::link('Refresh', array('members/viewchapter', 'cid'=>$chapter->id), array('class'=>'btn btn-success btn-flat')); ?>
				</div>
			</div>
		</form>
	</div>
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-header with-border">
			<?php echo $chapter->chapter; ?>
			<div class="pull-right">
				<strong>TOTAL : <?php echo count($membersDP->rawData);  ?></strong>
			</div>
		</div>
		<div class="box-body">
			<?php  $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$membersDP,
				'itemView'=>'_list_members',
				'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
						<thead>
							<th>Avatar</th>
							<th>Email Address / Username</th>
							<th>Name</th>
							<th>Date of Birth</th>
							<th>Chapter</th>
							<th>Position</th>
						</thead>
						<tbody>
							{items}
						</tbody>
					</table>
					{pager}",
				'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
			));  ?>
		</div>
	</div>

	<div class="row"></div>
</section>