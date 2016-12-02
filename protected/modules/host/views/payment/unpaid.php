<section id="flashAlert">
	<?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
		if($key  === 'success')
		{
			echo "<div class='alert alert-success alert-dismissible' role='alert' style='margin-bottom:5px'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
		}
		else
		{
			echo "<div class='alert alert-danger alert-dismissible' role='alert' style='margin-bottom:5px'>
			<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
			$message.'</div>';
		}

	}
	?>
</section>

<section class="content-header">
  <h1>
  	Unpaid Accounts
    <small>preview of registered accounts with no payment</small>
  </h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Event: <strong><?php echo $event->name;?></strong></h3>
              <div class="box-tools">
                <!-- <div class="input-group">
                  <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                  <div class="input-group-btn">
                    <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div> -->
              </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <?php  $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$attendeesDP,
                'itemView'=>'_list_unpaid_attendees',
                'template' => "{sorter}<table id=\"example2\" class=\"table table-bordered table-hover\">
                <thead class='panel-heading'>
                <th>Profile Picture</th>
                <th>Email</th>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Chapter</th>
                <th>Date Registered</th>
                <th class='text-center'>Action</th>
                </thead>
                <tbody>
                {items}
                </tbody>
                </table>
                {pager}",
                'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
                ));  ?>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
	</div>
</section>