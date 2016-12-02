<!-- Main content -->
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
			      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-newspaper-o" style="margin-right:10px;"></i> Events </h2>
			    </div>


			    <div class="row" style="margin-top:10px;">
			    	<div class="col-md-1"></div>
			    	<div class="col-md-10">	
			    		<div class="box box-primary">
			    			<div class="box-body">
						      <?php  $this->widget('zii.widgets.CListView', array(
						      'dataProvider'=>$eventsDP,
						      'itemView'=>'_list_events',
						      'emptyText' => "No events available for now.",
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

