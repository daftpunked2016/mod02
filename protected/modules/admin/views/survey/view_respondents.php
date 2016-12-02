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
 		    <section class="content-header">
          <h1>
            List of Respondents
            <small>Item Name: <strong><?php echo $item; ?></strong></small>
            <div class="pull-right">
              <small><a href="#" id="search_filters"><i class="fa fa-search" style="margin-right:5px;"></i>Search Filters</a></small>
            </div>
          </h1>

          <div class="well"  id="search-well" style="margin:10px 20px 0px; display:none;">
            <form method="GET">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <select class="form-control" name="area" id="area_no" required>
                      <option value="">Select Area..</option>
                      <option value="1">Area 1</option>
                      <option value="2">Area 2</option>
                      <option value="3">Area 3</option>
                      <option value="4">Area 4</option>
                      <option value="5">Area 5</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <select class="form-control" name="region" id="region">
                      <option value="">Select Region..</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <select class="form-control" name="chapter" id="chapter">
                      <option value="">Select Chapter..</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <input type="submit" class="btn btn-primary pull-right" value="Search">
              </div>
            </form>
          </div>
        </section>

        <!-- Main content -->
      	<section class="content">
          <div class="row">
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
            	<div class="box" style="margin-top:10px;">
            		<div class="box-header">
            			<div class="pull-left visible-md visible-lg">
                      <?php echo CHtml::link('<span class="fa fa-chevron-left"></span>', array('survey/viewresults', 'id'=>$questionnaire->id), array('class'=>'btn btn-default btn-flat', 'title'=>'Back')); ?>
                      <strong>Item Name:</strong> <i><?php echo $item; ?></i>
            			</div>
                  <div class="pull-right">
                    <h4 style="margin-bottom:0px;">
                      <strong>Total Respondents:</strong> <?php echo $res_total; ?>
                    </h4>
                  </div>
            		</div>
            		<div class="box-body">
                  <div class="table-responsive">
              			<?php  $this->widget('zii.widgets.CListView', array(
            					'dataProvider'=>$respondentsDP,
            					'itemView'=>'_respondents',
            					'template' => "{sorter}<table id=\"example\" class=\"table table-bordered table-hover\">
            							<thead class='panel-heading'>
            								<th>Picture</th>
                            <th>Username / Email Address</th>
                            <th>First Name</th>
                            <th>Last Name</th>
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
            		<div class="box-footer">Item: <strong><?php echo $item; ?></strong></div>
            	</div>
		      </div>
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->

      <?php $this->widget('UserFooter'); ?>
	  
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

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
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-scripts.js" type="text/javascript"></script>
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

        $('#search_filters').on("click",function(e){
          e.preventDefault();
          $("#search-well").slideToggle();
        });

      });
    </script>


  </body>
</html>