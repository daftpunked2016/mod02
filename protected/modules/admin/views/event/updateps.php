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
        

        <!-- Content Header (Page header) -->
 		    <section class="content-header">
          <div class="row visible-sm visible-xs" style="margin-left: 5px; margin-right: 5px; margin-top:0px;">
              <h3>Edit Payment Schemes 
                <button data-toggle="modal" data-target="#addPS"  class="btn btn-primary btn-md pull-right"> <span class="glyphicon glyphicon-plus" style="margin-right:10px"></span> Add New </button>
              </h3>
          </div>

          <div class="row hidden-sm hidden-xs">
            <div class="col-md-6">
              <h2 style="margin-top:0px;">Edit Payment Schemes</h2>
            </div>
            <div class="col-md-6">
             <button data-toggle="modal" data-target="#addPS"  class="btn btn-primary btn-md pull-right" style="margin-right:20px"> <span class="glyphicon glyphicon-plus" style="margin-right:10px"></span> Add New </button>
            </div>
          </div>
        </section>

        <!-- Main content -->

        <section class="content">

            <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="box">
                      <div class="box-body table-responsive no-padding">
                      <?php  $this->widget('zii.widgets.CListView', array(
                      'dataProvider'=>$listEventsPSDP,
                      'itemView'=>'_list_events_ps',
                      'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
                          <thead>
                            <th>Bank Details</th>
                            <th>Bank Account No.</th>
                            <th>Actions</th>
                          </thead>
                          <tbody>
                            {items}
                          </tbody>
                        </table>
                        {pager}",
                      'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
                      )); ?>
                      </div><!-- /.box-body -->
                  </div><!-- /.box -->
              </div>
              <div class="col-md-2"></div>
            </div>

          </section><!-- /.content -->

          <div class="modal fade" id="addPS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Payment Scheme</h4>
                </div>
                <div class="modal-body">
                    <div class ="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-8">
                        <form role="form" method="POST" action="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/addnewps?event_id=<?php echo $event->id; ?>">
                        <div class="form-group">
                          <select class="form-control" name="event_ps" required>
                            <option value=''>Select New Payment Scheme..</option>
                            <?php 
                              $ps = PaymentScheme::model()->findAll('status_id = 1'); 

                              foreach($ps as $ps1) 
                              {
                                $check = 0;

                                foreach($event_ps as $event_ps1) 
                                {
                                  if($event_ps1->payment_scheme_id == $ps1->id)
                                    $check++;
                                }

                                if($check==0)
                                  echo "<option value='".$ps1->id."'>".$ps1->bank_details." -- ".$ps1->bank_account_no."</option>";
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>
                </div>  
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" value="Payment Scheme" id="submit">Add</button> 
                  </form>
                </div>
              </div>
            </div>
          </div>



          <?php foreach($event_ps as $event_ps2): ?>
          <div class="modal fade" id="updatePS<?php echo $event_ps2->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Payment Scheme</h4>
                </div>
                <div class="modal-body">
                    <div class ="row">
                      <div class="col-md-2"></div>
                      <div class="col-md-8">
                        <form role="form" method="POST" action="<?php echo Yii::app()->baseUrl; ?>/index.php/admin/event/updateps?event_id=<?php echo $event->id; ?>&id=<?php echo $event_ps2->id; ?>">
                        <div class="form-group">
                          <select class="form-control" name="event_ps" required>
                            <option value=''>Select Payment Scheme..</option>
                            <?php 
                              $ps = PaymentScheme::model()->findAll('status_id = 1'); 

                              foreach($ps as $ps1) 
                              {
                                $check = 0;

                                foreach($event_ps as $event_ps1) 
                                {
                                  if($event_ps1->payment_scheme_id == $ps1->id)
                                    $check++;
                                }

                                if($check==0)
                                  echo "<option value='".$ps1->id."'>".$ps1->bank_details." -- ".$ps1->bank_account_no."</option>";
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>
                </div>  
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" value="Payment Scheme" id="submit">Update</button> 
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?> 

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