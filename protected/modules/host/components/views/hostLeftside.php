<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/admin-icon.png" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>Host Account</p>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">Navigation</li>
      <!-- Optionally, you can add icons to the links -->
      <li><?php echo CHtml::link('<i class="fa fa-home"></i><span>Home</span>',array('event/index')) ?></li>

     <!-- payments --> 
      <li class="treeview active">
        <a href="#">
          <i class="fa fa-credit-card"></i> <span>Payments </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <!-- <?php //echo CHtml::link('<i class="fa fa-check"></i><span>Paid</span>',array('payment/paid')) ?> -->
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/host/payment/paid"><i class="fa fa-check"></i>Paid <span class="badge" style="margin-left:5px;"><?php echo EventAttendees::model()->paidAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span></a>
          </li>
          <li>
            <!-- <?php //echo CHtml::link('<i class="fa fa-exclamation"></i><span>Unpaid</span>',array('payment/unpaid')) ?> -->
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/host/payment/unpaid"><i class="fa fa-exclamation"></i>Unpaid <span class="badge" style="margin-left:5px;"><?php echo EventAttendees::model()->unpaidAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span></a>
          </li>
          <li>
            <!-- <?php //echo CHtml::link('<i class="fa fa-question-circle"></i><span>Pending</span>',array('payment/pending')) ?> -->
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/host/payment/pending"><i class="fa fa-question-circle"></i>Pending <span class="badge" style="margin-left:5px;"><?php echo EventAttendees::model()->pendingAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span></a>
          </li>
          <li>
            <!-- <?php //echo CHtml::link('<i class="fa fa-close"></i><span>Rejected</span>',array('payment/reject')) ?> -->
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/host/payment/reject"><i class="fa fa-close"></i>Rejected <span class="badge" style="margin-left:5px;"><?php echo EventAttendees::model()->rejectAttendee()->count(array('condition' => 'event_id ='.$event->id)); ?></span></a>
          </li>
        </ul>
      </li>

      <li><?php echo CHtml::link('<i class="fa fa-briefcase"></i><span>Sales Report</span>',array('sales/index')) ?></li>
      <!-- Sales reports -->
      <!-- <li class="treeview active">
        <a href="#">
          <i class="fa fa-briefcase"></i> <span>Sales Reports </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><?php //echo CHtml::link('<i class="fa fa-calendar"></i><span>Date</span>',array('default/index')) ?></li>
          <li><?php //echo CHtml::link('<i class="fa fa-flag"></i><span>Chapter</span>',array('default/index')) ?></li>
          <li><?php //echo CHtml::link('<i class="fa fa-globe"></i><span>Area</span>',array('default/index')) ?></li>
        </ul>
      </li> -->

    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>