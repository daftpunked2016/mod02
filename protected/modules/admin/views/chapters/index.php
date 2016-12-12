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
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />

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
            Membership Account Settings
            <small>Chapter's Membership Details Viewing and Updating</small>
          </h1>
        </section>


        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="well">
                <div class="row">
                  <form method="GET" action="<?php echo Yii::app()->createUrl('admin/chapters/index'); ?>">
                    <div class="col-md-4">
                      <label>Category</label>
                      <select id="category" name="category" class="form-control">
                        <option value =''>Select Category..</option>
                        <option value ='1'>1</option>
                        <option value ='2'>2</option>
                        <option value ='3'>3</option>
                      <select>
                    </div>

                    <div class="col-md-4">
                      <label>Area</label>
                      <select id="area_no" name="area_no" class="form-control">
                        <option value =''>Select Area No.</option>
                        <option value ='1'>Area 1</option>
                        <option value ='2'>Area 2</option>
                        <option value ='3'>Area 3</option>
                        <option value ='4'>Area 4</option>
                        <option value ='5'>Area 5</option>
                      <select>
                    </div>

                   <div class="col-md-4">
                      <label>Region</label>
                      <select id="region" name="region" class="form-control">
                        <option value =''>Select Region..</option>
                        <option value =''>Select Area No. first</option>
                      <select>
                    </div>

                    <div class="col-md-12">
                      <input type="submit" class="btn btn-default pull-right" value="Search" style="margin-top:10px;" />
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

    			<div class="row">
    				<div class="col-md-12 col-lg-12">
    					<div class="box">
	            	<div class="box-header">
	          			<h3 class="box-title"><span class="pull-left">Chapter List</span></h3>
                  <h4 class="pull-right">Total: <strong><?php echo $total; ?></strong></h4>
	                </div><!-- /.box-header -->
                	<div class="box-body no-padding">
	                  <?php  $this->widget('zii.widgets.CListView', array(
        							'dataProvider'=>$chaptersDP,
        							'itemView'=>'_view_chapters',
        							'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
        									<thead>
        										<th>Chapter</th>
        										<th>Area No.</th>
        										<th>Region</th>
                            <th>Category</th>
                            <th>Voting Strength</th>
                            <th>MAX Regular</th>
                            <th>MAX Associate</th>
                            <th>Actions</th>
        									</thead>
        									<tbody>
        										{items}
        									</tbody>
        								</table>
        								{pager}{summary}",
        							'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
        							));
                    ?>
             		</div><!-- /.box-body -->
          		</div><!-- /.box -->
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
    <!-- AdminLTE App -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.min.js" type="text/javascript"></script>

    <!-- CUSTOM JS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-scripts.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chapters.js" type="text/javascript"></script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>