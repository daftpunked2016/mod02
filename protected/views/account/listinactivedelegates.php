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
  <div class="row">
    <div class="col-md-7">
      <h3>
       	View Inactive Delegates
      </h3>
    </div>
  </div>
</section>


<div class="container">
  <section class="content" style="margin-top:20px;">
    <div class="well">
      <div class="row" id="searchFilters" style="margin-bottom:20px;">
        <p>
          <h4 style="margin-left:10px;">Search Options</h4>

          <form method="get" name="search" action="<?php echo $this->createUrl('account/listInactiveDelegates'); ?>">
            <div class="col-xs-6 col-lg-3">
              <strong>Age:</strong> 
                  <select class="form-control" id="ageType" name="ageType">
                    <option value="">Select.. </option>
                    <option value="1">Regular (40-) </option>
                    <option value="2">Associate (40+) </option>
                  </select>
            </div>
            
            <div class="col-xs-6 col-lg-3">
              <strong>Gender:</strong>
                  <select class="form-control" id="genderPres" name="genderPres">
                    <option value="">Select.. </option>
                    <option value="1">Male </option>
                    <option value="2">Female </option>
                  </select>
            </div>

            <div class="col-xs-6 col-lg-3">
              <strong>Title:</strong>
               <select class="form-control" id="titlePres" name="titlePres">
                    <option value=""> Select.. </option>
                    <option value="1"> JCI-SEN </option>
                    <option value="2"> JCI-MEM </option>
                </select>
            </div>

            <div class="col-xs-6 col-lg-3">
              <strong>Positions:</strong>
                  <select class="form-control" id="positionPres" name="positionPres">
                    <option value="">Select.. </option>
                    <?php $positions = Position::model()->findAll(); 
                    foreach ($positions as $position): ?>
                      <option value="<?php echo $position->id; ?>"><?php echo $position->position; ?></option>
                    <?php endforeach; ?>
                  </select>
            </div>

            <div class="pull-right" style="margin-top:10px; margin-right:15px;">
              <input type="submit" class="btn btn-success" value="Search" name="search" />
            </div>
          </form> 
        </p>
      </div>
    </div>  



  	<div class="col-md-12 col-lg-12">
  		<div class="box">
          	<div class="box-header">
        			<h3 class="box-title">List Delegates (INACTIVE) </h3>
              </div><!-- /.box-header -->
          	<div class="box-body table-responsive no-padding">
                    <?php  $this->widget('zii.widgets.CListView', array(
  					'dataProvider'=>$inactiveListDelegatesDP,
  					'itemView'=>'_list_inactive_delegates',
  					'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
  							<thead>
  								<th>Avatar</th>
  								<th>Email Address / Username</th>
  								<th>First Name</th>
  								<th>Last Name</th>
  								<th>Chapter</th>
  								<th>Position</th>
  								<th>Action</th>
  							</thead>
  							<tbody>
  								{items}
  							</tbody>
  						</table>
  						{pager}",
  					'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
            'ajaxUrl'=>Yii::app()->createUrl('/module/controller/action'), 
  					));  ?>
         		</div><!-- /.box-body -->
    		</div><!-- /.box -->
  	</div>
  </section>
</div>