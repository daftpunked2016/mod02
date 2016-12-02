<section class="content-header">
	<h1>
		<?php echo $header_title; ?>
		<small>members list</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<?php echo CHtml::link($header_title, array('members/index', 's'=>$s)); ?>
		</li>
		<li class="active">Members List</li>
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
			<div class="pull-right">
				<?php echo CHtml::link('Refresh', array('members/index', 's'=>$s), array('class'=>'btn-sm btn-success')); ?>
			</div>
		</h4>
		<form method="get" action="<?php echo Yii::app()->createUrl('members/index', array('s'=>$s)); ?>">
			<input type="hidden" name="s" value="<?php echo $s; ?>">
			<div class="row">


				<?php if ($user->position_id == 4): ?>
					<div class="col-md-3">
						<label>Area</label>
						<select class="form-control" name="filters[area_no]">
							<option value="">Select Area</option>
							<?php for($x = 1; $x < 6; $x++): ?>
							<option value="<?php echo $x; ?>" <?php if(isset($_GET['filters']['area_no'])) { if($_GET['filters']['area_no'] == $x) { echo "selected"; }} ?> >AREA <?php echo $x; ?></option>
							<?php endfor; ?>
						</select>
					</div>
				<?php endif ?>

				<?php if ($user->position_id == 4 || $user->position_id == 8): ?>
					<div class="col-md-3">
						<label>Regions</label>
						<select class="form-control" name="filters[region_id]">
							<option value="">Select Region</option>
							<?php foreach ($regions as $reg): ?>
								<option value="<?php echo $reg->id; ?>" <?php if(isset($_GET['filters']['region_id'])) { if($_GET['filters']['region_id'] == $reg->id) { echo "selected"; }} ?> ><?php echo $reg->region; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				<?php endif ?>

				<div class="col-md-3">
					<label>Chapters</label>
					<select class="form-control" name="filters[chapter_id]">
						<option value="">Select Chapter</option>
						<?php foreach ($chapters as $chap): ?>
							<option value="<?php echo $chap->id; ?>" <?php if(isset($_GET['filters']['chapter_id'])) { if($_GET['filters']['chapter_id'] == $chap->id) { echo "selected"; }} ?> ><?php echo $chap->chapter; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-3">
					<label>Name</label>
					<input type="text" class="form-control" name="filters[name]" placeholder="Name" value="<?php if(isset($_GET['filters']['name'])) { echo $_GET['filters']['name']; } ?>">
				</div>

				<div class="col-md-3">
					<label>Membership Type</label>
					<select class="form-control" name="filters[age]">
						<option value="">Select Type</option>
						<option value="1" <?php if(isset($_GET['filters']['age'])) { if($_GET['filters']['age'] == 1) { echo "selected"; }} ?>>Associate Members (40+)</option>
						<option value="2" <?php if(isset($_GET['filters']['age'])) { if($_GET['filters']['age'] == 2) { echo "selected"; }} ?>>Regular Members (40-)</option>
					</select>
				</div>
				
				<!-- <div class="col-md-3">
					<label>Position</label>
					<select class="form-control" name="filters[position_id]">
						<option value="">Select Position</option>
						<?php //foreach ($positions as $pos): ?>
							<option value="<?php //echo $pos->id; ?>" <?php //if(isset($_GET['filters']['position_id'])) { if($_GET['filters']['position_id'] == $pos->id) { echo "selected"; }} ?>><?php //echo $pos->position; ?></option>
						<?php //endforeach; ?>
					</select>
				</div> -->
				
				<div class="col-md-2">
					<br>
					<input type="submit" name="search" value="Search" class="btn btn-primary btn-flat">
				</div>
			</div>
		</form>
	</div>
</section>

<section class="content">
	<div class="box box-solid">
		<div class="box-header with-border">
			Active Member Accounts
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