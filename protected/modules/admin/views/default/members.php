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
            <!-- ADMINISTRATOR
            <small>Authorized Personnel Only!</small> -->
            <?php echo CHtml::link('AREA '.$chapter->area_no, array('/admin/default/index'))?> - <small><?php echo CHtml::link($region->region, array('/admin/default/listchapters', 'id' => $region->id, 'anum' => $region->area_no))?> - <?php echo $chapter->chapter; ?></small>
          </h1>
          <br>
          <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
              echo "<div class='flash-".$key." alert alert-danger'>".$message.'</div>';
            }
          ?>
        </section>

        <!-- Main content -->
        <section class="content">
      <div class="row">
      </div>

      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="box">
            <div class="box-header">
             <div class="pull-left">
              <h3>
                ACTIVE ACCOUNTS OF <?php echo $chapter->chapter ?>
              </h3>                    
             </div>
              <div class="pull-right">
                <h3 class="box-title pull-right">Total: <?php echo User::model()->getChapterTotalUsers($chapter->id); ?></h3>
              </div>
              </div><!-- /.box-header -->
              <div class="box-body no-padding">
                  <!-- <?php //$this->widget('Area1'); ?> -->
                <?php  $this->widget('zii.widgets.CListView', array(
                  'dataProvider'=>$activeMemDP,
                  'itemView'=>'_view_accounts',
                  'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
                      <thead>
                        <th>Avatar</th>
                        <th>Email Address / Username</th>
                        <th>Name</th>
                        <th>Chapter</th>
                        <th>Position</th>
                        <th>MEMBER ID</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        {items}
                      </tbody>
                    </table>
                    {pager}",
                  'emptyText' => "<tr><td colspan=\"6\">No available entries</td></tr>",
                  ));  ?>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <?php
                  if(count($activeMemDP->rawData) > 0)
                  {
                    echo CHtml::link('Download to CSV (Master List)', array('default/listmembers', 'id'=>$chapter->id, 'exports'=>'A'), array('class'=>'btn-sm btn-default', 'id'=>'exports-a'));
                    echo CHtml::link('Download to CSV (Printed)', array('default/listmembers', 'id'=>$chapter->id, 'exports'=>'P'), array('class'=>'btn-sm btn-primary', 'id'=>'exports-p', 'style'=>'margin-left: 5px;'));
                    echo CHtml::link('Download to CSV (Not Printed)', array('default/listmembers', 'id'=>$chapter->id, 'exports'=>'N'), array('class'=>'btn-sm btn-info', 'id'=>'exports-n', 'style'=>'margin-left: 5px;'));
                    echo CHtml::link('Download Printed Profile Pictures ('.$printed_count.')', array('default/listmembers', 'id'=>$chapter->id, 'printed-pics'=>'P'), array('class'=>'btn-sm btn-warning', 'id'=>'printed-pictures', 'style'=>'margin-left: 5px;'));
                    echo CHtml::link('Download Not Printed Profile Pictures ('.$not_printed_count.')', array('default/listmembers', 'id'=>$chapter->id, 'printed-pics'=>'N'), array('class'=>'btn-sm btn-danger', 'id'=>'not-printed-pictures', 'style'=>'margin-left: 5px;'));
                  }
                ?>
              </div>
            </div><!-- /.box -->
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="box">
            <div class="box-header">
              <h3>INACTIVE ACCOUNTS OF <?php echo $chapter->chapter ?></h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <!-- <?php //$this->widget('Area1'); ?> -->
              <?php  $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$inactiveMemDP,
                'itemView'=>'_view_accounts_inactive',
                'template' => "{sorter}<table id=\"example1\"class=\"table table-bordered table-hover\" >
                    <thead>
                      <th>Avatar</th>
                      <th>Email Address / Username</th>
                      <th>Name</th>
                      <th>Chapter</th>
                      <th>Position</th>
                      <th>MEMBER ID</th>
                      <th>Action</th>
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

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>