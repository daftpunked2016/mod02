<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title>Administrator Dashboard | JCI PH</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-black sidebar-mini">
    <div class="wrapper">

      <?php $this->widget('AdminHeader'); ?>

      <?php $this->widget('AdminLeftside'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
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
			      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-tag" style="margin-right:10px;"></i> Business Directory </h2>
			    </div>


			    <div class="row" style="margin-top:10px;">
			    	<div class="col-md-1"></div>
			    	<div class="col-md-10">
			    		
			    		<div class="well">
			    			<div class="row" id="searchFilters" style="margin-bottom:20px;">
								<p>
									<h4 style="margin-left:10px;">Search Options</h4>

									<form method="GET" name="search" action="<?php echo $this->createUrl('userBusiness/index'); ?>">
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


      </div><!-- /.content-wrapper -->

      <?php $this->widget('UserFooter'); ?>
	  
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-scripts.js"></script>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo Yii::app()->request->baseUrl; ?>/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/demo.js" type="text/javascript"></script>
    

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->

 	<script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
  </body>
</html>

