<?php
  $accounts = Account::model()->userAccount()->isActive()->findAll();
  $names = array();

  foreach($accounts as $account)
  {
    $names[] = User::model()->getCompleteName2($account->id);
  }
  // $getUser = $user->getCompleteName2(); getCompleteName2

?>

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
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/restyles.css" rel="stylesheet" type="text/css" />
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
          <h1>
            Events
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="row">
    				<?php $form=$this->beginWidget('CActiveForm', array(
    					'id'=>'event-form',
              'htmlOptions' => array('enctype' => 'multipart/form-data'),
    					// Please note: When you enable ajax validation, make sure the corresponding
    					// controller action is handling ajax validation correctly.
    					// There is a call to performAjaxValidation() commented in generated controller code.
    					// See class documentation of CActiveForm for details on this.
    					'enableAjaxValidation'=>false,
    				)); ?>

            
            
            <div class="col-md-1"></div>

            <div class="col-md-10">
              <div class="panel panel-info">
                <div class="panel-heading" align="center">
                  <h3>
                    <strong>Update Event Details</strong>
                  </h3>
                  <?php echo $form->errorSummary(array($event, $eventpricing)); ?>
                </div>
                
                <div class="panel-body">

                  <div class="col-md-6">
                    <h4> Event Details </h4>
                    <div class="well">
                      <div class="form-group">
                        <?php echo $form->labelEx($event,'name'); ?>
                        <?php echo $form->textField($event,'name',array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'required'=>'true')); ?>
                        <?php echo $form->error($event,'name'); ?>
                      </div>

                      <div class="form-group">
                        <?php echo $form->labelEx($event,'description'); ?>
                        <?php echo $form->textArea($event, 'description', array('maxlength' => 255, 'rows' => 3, 'class'=>'form-control', 'required'=>'true')); ?>
                        <?php echo $form->error($event,'description'); ?>
                      </div>

                      <div class="form-group">
                        <?php echo $form->labelEx($event,'event_type'); ?>
                        <select name='Event[event_type]' class="form-control" id="event-type" required>
                          <?php $eventtype = EventTypes::model()->findByPk($event->event_type); ?>
                          <option value='<?php echo $eventtype->id; ?>' selected disabled>Select Event Type...</option>

                          <?php $et = EventTypes::model()->findAll('status_id = 1'); 
                                foreach ($et as $et): ?>
                                <option value="<?php echo $et->id; ?>" <?php if($event->event_type == $et->id) echo "selected"; ?> ><?php echo $et->name; ?></option>
                          <?php endforeach; ?>
                        </select>
                        <?php echo $form->error($event,'event_type'); ?>
                      </div>

                      <div class="form-group" id="areacon-areano">
                        <?php echo $form->labelEx($event,'areacon_area_no'); ?>
                        <?php echo $form->textField($event,'areacon_area_no', array('class' => 'form-control')); ?>
                        <?php echo $form->error($event,'areacon_area_no'); ?>
                      </div>

                      <div class="form-group">
                        <?php echo $form->labelEx($event,'date'); ?>
                        <?php
                          $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $event,
                            'attribute' => 'date',
                            'options'=>array(
                              'minDate'=>'0',  // this will disable previous dates from datepicker
                              'showAnim'=>'slideDown',
                              'yearRange'=>'0:+5',
                              'changeMonth' => true,
                              'changeYear' => true,
                              'dateFormat' => 'yy-mm-dd'
                              ),
                            'htmlOptions' => array(
                              'size' => 20,         // textField size
                              'class' => 'form-control',
                              'required'=>'true'

                            ),  
                          ));
                        ?>
                        <?php echo $form->error($event,'date'); ?>
                      </div>

                      <div class="form-group">
                        <?php echo $form->labelEx($event,'time'); ?>
                        <?php echo $form->textField($event,'time',array('size'=>20,'maxlength'=>20, 'class' => 'form-control', 'required'=>'true')); ?> <!-- time picker -->
                        <?php echo $form->error($event,'time'); ?>
                      </div>

                      <div class="form-group">
                        <?php echo $form->labelEx($event,'venue'); ?>
                        <?php echo $form->textField($event,'venue',array('size'=>60,'maxlength'=>128, 'class' => 'form-control', 'required'=>'true')); ?>
                        <?php echo $form->error($event,'venue'); ?>
                      </div>

                      <?php 
                        $chapters = Chapter::model()->findAll(array('select'=>'area_no', 'distinct'=>true));
                        $eventchapter = Chapter::model()->find("id = ".$event->host_chapter_id);
                        $eventregion = AreaRegion::model()->find("id = ".$eventchapter->region_id); 
                        $eventhost = User::model()->find("account_id = ".$event->host_account_id); 
                      ?>

                      <strong style="margin-bottom:5px;">Host Chapter*</strong>
                      <div class="well" style="background-color: #C4C4C4">
                        <div class="form-group">
                          <label for="area_no">Area No.</label>
                          <select id="area_no" class="form-control">
                            <option value="<?php echo $eventregion->area_no; ?>" selected disabled><?php echo $eventregion->area_no; ?></option> 
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="area_no">Region</label>
                          <select id="region" class="form-control">
                            <option value="<?php echo $eventregion->id; ?>" selected disabled><?php echo $eventregion->region; ?></option> 
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="chapter">Chapter</label>
                          <select id="chapter" name="Event[host_chapter_id]" class="form-control">
                            <option value="<?php echo $eventchapter->id; ?>" selected disabled> <?php echo $eventchapter->chapter; ?> </option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="host_account_id">Host*</label>
                        <select id="host_accounts" name="Event[host_account_id]" class="form-control" required>
                          <option value="<?php echo $eventhost->account_id; ?>" selected disabled> <?php echo $eventhost->firstname." ".$eventhost->middlename." ".$eventhost->lastname; ?> </option>
                        </select>
                      </div>

                    </div>
                  </div> <!-- end col-6 --> 

                  <div class="col-md-6">

                   <h4> Pricing </h4>
                    <div class="well">

                      <div class="form-group">
                        <label for="pricing-type">Type of Pricing*</label>
                        <select id="pricing-type" name="EventPricing[pricing_type]" class="form-control" required>
                          <option value="<?php echo $eventpricing->pricing_type; ?>">Select Pricing...</option> 
                          <option value=1 <?php if($eventpricing->pricing_type == 1) echo "selected"; ?> >FREE</option>
                          <option value=2 <?php if($eventpricing->pricing_type == 2) echo "selected"; ?> >Fixed Rate</option>
                          <option value=3 <?php if($eventpricing->pricing_type == 3) echo "selected"; ?> >Packages</option>   
                        </select>
                      </div>

                      <strong>Early Bird</strong>
                        <div class="well" style="background-color: #C4C4C4">
                        
                          <div class="form-group">
                            <?php echo $form->labelEx($eventpricing,'early_bird_price'); ?>
                            <?php echo $form->textField($eventpricing,'early_bird_price',array('size'=>20,'maxlength'=>20, 'class' => 'form-control pricing-info-inputs', 'placeholder'=>'eg. 9999.99', 'required'=>'true', 'disabled'=>'true')); ?> 
                            <?php echo $form->error($eventpricing,'early_bird_price'); ?>
                          </div>

                          <div class="row">

                            <div class="col-md-6">
                              <div class="form-group">
                                <?php echo $form->labelEx($eventpricing,'eb_begin_date'); ?>
                                <?php
                                  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $eventpricing,
                                    'attribute' => 'eb_begin_date',
                                    'options'=>array(
                                      'minDate'=>'0',  // this will disable previous dates from datepicker
                                      'showAnim'=>'slideDown',
                                      'yearRange'=>'0:+5',
                                      'changeMonth' => true,
                                      'changeYear' => true,
                                      'dateFormat' => 'yy-mm-dd'
                                      ),
                                    'htmlOptions' => array(
                                      'size' => 10,         // textField size
                                      'class' => 'form-control eb-dates pricing-info-inputs',
                                      'required'=>'true',
                                      'disabled'=>'true'
                                    ),  
                                  ));
                                ?>
                                <?php echo $form->error($eventpricing,'eb_begin_date'); ?>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <?php echo $form->labelEx($eventpricing,'eb_end_date'); ?>
                                <?php
                                  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $eventpricing,
                                    'attribute' => 'eb_end_date',
                                    'options'=>array(
                                      'minDate'=>'0',  // this will disable previous dates from datepicker
                                      'showAnim'=>'slideDown',
                                      'yearRange'=>'0:+5',
                                      'changeMonth' => true,
                                      'changeYear' => true,
                                      'dateFormat' => 'yy-mm-dd',
                                      ),
                                    'htmlOptions' => array(
                                      'size' => 10,         // textField size
                                      'class' => 'form-control eb-dates pricing-info-inputs',
                                      'required'=>'true',
                                      'disabled'=>'true'
                                    ),  
                                  ));
                                ?>
                                <?php echo $form->error($eventpricing,'eb_end_date'); ?>
                              </div>
                            </div>

                          </div>

                        </div><!-- Early Bird well -->

                      <strong>Regular</strong>
                        <div class="well" style="background-color: #C4C4C4">
                          
                          <div class="form-group">
                            <?php echo $form->labelEx($eventpricing,'regular_price'); ?>
                            <?php echo $form->textField($eventpricing,'regular_price',array('size'=>20,'maxlength'=>20, 'class' => 'form-control pricing-info-inputs' , 'placeholder'=>'eg. 9999.99', 'required'=>'true', 'disabled'=>'true')); ?> 
                            <?php echo $form->error($eventpricing,'regular_price'); ?>
                          </div>

                          <div class="row">

                            <div class="col-md-6">
                              <div class="form-group">
                                <?php echo $form->labelEx($eventpricing,'regular_begin_date'); ?>
                                <?php
                                  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $eventpricing,
                                    'attribute' => 'regular_begin_date',
                                    'options'=>array(
                                      'minDate'=>'0',  // this will disable previous dates from datepicker
                                      'showAnim'=>'slideDown',
                                      'yearRange'=>'0:+5',
                                      'changeMonth' => true,
                                      'changeYear' => true,
                                      'dateFormat' => 'yy-mm-dd'
                                      ),
                                    'htmlOptions' => array(
                                      'size' => 10,         // textField size
                                      'class' => 'form-control reg-dates pricing-info-inputs',
                                      'required'=>'true',
                                      'disabled'=>'true'
                                    ),  
                                  ));
                                ?>
                                <?php echo $form->error($eventpricing,'regular_begin_date'); ?>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <?php echo $form->labelEx($eventpricing,'regular_end_date'); ?>
                                <?php
                                  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $eventpricing,
                                    'attribute' => 'regular_end_date',
                                    'options'=>array(
                                      'minDate'=>'0',  // this will disable previous dates from datepicker
                                      'showAnim'=>'slideDown',
                                      'yearRange'=>'0:+5',
                                      'changeMonth' => true,
                                      'changeYear' => true,
                                      'dateFormat' => 'yy-mm-dd'
                                      ),
                                    'htmlOptions' => array(
                                      'size' => 10,         // textField size
                                      'class' => 'form-control reg-dates pricing-info-inputs',
                                      'required'=>'true',
                                      'disabled'=>'true'
                                    ),  
                                  ));
                                ?>
                                <?php echo $form->error($eventpricing,'regular_end_date'); ?>
                              </div>
                            </div>

                          </div>

                        </div><!-- Regular well -->

                      <strong>Onsite</strong>
                        <div class="well" style="background-color: #C4C4C4">
                          
                          <div class="form-group">
                            <?php echo $form->labelEx($eventpricing,'onsite_price'); ?>
                            <?php echo $form->textField($eventpricing,'onsite_price',array('size'=>20,'maxlength'=>20, 'class' => 'form-control pricing-info-inputs', 'placeholder'=>'eg. 9999.99', 'required'=>'true','disabled'=>'true')); ?> 
                            <?php echo $form->error($eventpricing,'onsite_price'); ?>
                          </div>


                          <div class="row">

                            <div class="col-md-6">
                              <div class="form-group">
                                <?php echo $form->labelEx($eventpricing,'onsite_begin_date'); ?>
                                <?php
                                  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $eventpricing,
                                    'attribute' => 'onsite_begin_date',
                                    'options'=>array(
                                      'minDate'=>'0',  // this will disable previous dates from datepicker
                                      'showAnim'=>'slideDown',
                                      'yearRange'=>'0:+5',
                                      'changeMonth' => true,
                                      'changeYear' => true,
                                      'dateFormat' => 'yy-mm-dd'
                                      ),
                                    'htmlOptions' => array(
                                      'size' => 10,         // textField size
                                      'class' => 'form-control os-dates pricing-info-inputs',
                                      'required'=>'true',
                                      'disabled'=>'true'
                                    ),  
                                  ));
                                ?>
                                <?php echo $form->error($eventpricing,'onsite_begin_date'); ?>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <?php echo $form->labelEx($eventpricing,'onsite_end_date'); ?>
                                <?php
                                  $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $eventpricing,
                                    'attribute' => 'onsite_end_date',
                                    'options'=>array(
                                      'minDate'=>'0',  // this will disable previous dates from datepicker
                                      'showAnim'=>'slideDown',
                                      'yearRange'=>'0:+5',
                                      'changeMonth' => true,
                                      'changeYear' => true,
                                      'dateFormat' => 'yy-mm-dd'
                                      ),
                                    'htmlOptions' => array(
                                      'size' => 10,         // textField size
                                      'class' => 'form-control os-dates pricing-info-inputs',
                                      'required'=>'true',
                                      'disabled'=>'true'
                                    ),  
                                  ));
                                ?>
                                <?php echo $form->error($eventpricing,'onsite_end_date'); ?>
                              </div>
                            </div>

                          </div>

                        </div><!-- Onsite well -->

                      </div><!-- Well -->

                      <!--
                      <div class="form-group buttons">
                        <div class="well">
                          <strong>Other Edit Options</strong> <br />
                          <center>
                            <?php echo CHtml::button('Change Event Poster', array('class' => 'btn btn-success', 'style'=>'margin-right:5px;')); ?>
                            <?php echo CHtml::button('Edit Payment Scheme', array('class' => 'btn btn-danger', 'style'=>'margin-right:5px;')); ?>
                          </center> 
                        </div>
                      </div>
                      -->
                      <div class="form-group buttons">
                        <?php echo CHtml::submitButton($event->isNewRecord ? 'Create Event' : 'Save', array('class' => 'btn btn-primary btn-flat pull-right btn-lg')); ?>
                      </div>

                    </div>  <!-- end col-6 --> 
                  </div>

                </div>
              </div>
            </div>

  					<div class="col-md-1"></div>

  				  <?php $this->endWidget(); ?>
  				</div><!-- form -->
        </section><!-- /.content -->

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