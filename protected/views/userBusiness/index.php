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

<!-- Main content -->
<div class="container">
	<section class="content">
		<div class="row" id="userBusinesses" style="margin-top:20px;">
		    <div class="row">
		      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-tag" style="margin-right:10px;"></i> Business Directory </h2>
		    </div>


		    <div class="row" style="margin-top:10px;">
		    	<div class="col-md-1"></div>
		    	<div class="col-md-10">
		    		
		    		<div class="well">
		    			<div class="row" id="searchFilters" style="margin-bottom:20px;">
							<p>
								<h4 style="margin-left:10px;">Search Options</h4>

								<form method="post" name="search">
									<div class="col-xs-6 col-lg-3">
										Name: <input type="text" name="businessName" class="form-control" />
									</div>
									
									<div class="col-xs-6 col-lg-3">
										Business Category:
										<select name="businessCat" id="business-category" class="form-control">
											<option value="">Please Select..</option>
											<?php $categories = BusinessCategory::model()->findAll(); 
							                    foreach($categories as $category)
							                      echo "<option value='".$category->id."'>".$category->category."</option>";
							                  ?>
										</select>
									</div>

									<div class="col-xs-6 col-lg-3">
										Business Subtype:
										<select name="businessSubtype" id="business-subtype" class="form-control">
											<option value="">Please Select..</option>
										</select>
									</div>

									<div class="col-xs-6 col-lg-3">
										Province:
										<select name="businessProvince" class="form-control">
											<option value="">Please Select..</option>
											<?php $provinces = Provinces::model()->findAll(); 
							                    foreach($provinces as $province)
							                      echo "<option value='".$province->id."'>".$province->name."</option>";
							                  ?>
										</select>
									</div>

									<div class="pull-right" style="margin-top:10px; margin-right:15px;">
										<input type="submit" class="btn btn-success" value="Search" />
									</div>
								</form> 
							</p>
						</div>
					</div>	


		    		<div class="box box-primary">
		    			<div class="box-body">
					      <?php  $this->widget('zii.widgets.CListView', array(
					      'dataProvider'=>$userBusinessesDP,
					      'itemView'=>'_list_user_businesses',
					      'emptyText' => "<h2>Sorry, we couldn't find the business you were looking for.</h2>",
					      ));  
					      ?>
					     </div>
				    </div>
			    </div>
			    <div class="col-md-1"></div>
		    </div>
		</div>

	</section><!-- /.content -->
</div>
