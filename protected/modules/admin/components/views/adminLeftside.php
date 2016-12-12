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
        <p>Administrator Account</p>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">Navigation</li>
      <!-- Optionally, you can add icons to the links -->
      <li><?php echo CHtml::link('<i class="fa fa-home"></i><span>Home</span>',array('default/index')) ?></li>

      <li class="treeview active">
        <a href="#">
          <i class="fa fa-users"></i> <span>Accounts </span> <span class="badge" style="margin-left:5px;"><?php echo Account::model()->userAccount()->count(); ?></span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <!--<li><?php //echo CHtml::link('<i class="fa fa-user-plus"></i><span>Active Accounts</span>',array('account/index')) ?><span class="badge" style="margin-left:5px;"><?php echo Account::model()->isActive()->userAccount()->count(); ?></span></li>
          <li><?php //echo CHtml::link('<i class="fa fa-user-plus"></i><span>Active Senator</span>',array('account/activesen')) ?></li>
          <li><?php //echo CHtml::link('<i class="fa fa-user-times"></i><span>Pending Senator</span>',array('account/inactivesen')) ?></li>
          <li><?php //echo CHtml::link('<i class="fa fa-user-times"></i><span>Inactive Accounts</span>',array('account/inactiveindex')) ?></li>-->

          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/index"><i class="fa fa-user-plus"></i> Active Accounts <span class="badge" style="margin-left:5px;"><?php echo Account::model()->isActive()->userAccount()->count(); ?></span></a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/inactiveindex"><i class="fa fa-user-times"></i> Inactive Accounts <span class="badge" style="margin-left:5px;"><?php echo Account::model()->isInactive()->userAccount()->count(); ?></span></a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/activesen"><i class="fa fa-user-plus"></i> Active Senator <span class="badge" style="margin-left:5px;"><?php echo Account::model()->userAccount()->isActiveSen()->count(); ?></span></a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/inactivesen"><i class="fa fa-user-times"></i> Pending Senator <span class="badge" style="margin-left:5px;"><?php echo Account::model()->userAccount()->isInactiveSen()->count(); ?></span></a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/inactivenatpos"><i class="fa fa-user-times"></i> Pending Nat. Pos. <span class="badge" style="margin-left:5px;"><?php echo Account::model()->userAccount()->isInactivePause()->with(array('position'=>array('condition'=>'category = "National"',)))->count(); ?></span></a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/pendingpresident"><i class="fa fa-user-times"></i> Pending President <span class="badge" style="margin-left:5px;"><?php echo Account::model()->userAccount()->presAccount()->count(); ?></span></a></li>  
        </ul>
      </li>
      <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/userBusiness/index"><i class='fa fa-book'></i> <span>Business Directory</span></a></li>
      <li><?php echo CHtml::link('<i class="fa fa-calendar"></i><span>Events</span>',array('event/index')) ?></li>
      <li><?php echo CHtml::link('<i class="fa fa-bar-chart"></i><span>Survey</span>',array('survey/index')) ?></li>
      <!-- <li><?php //echo CHtml::link('<i class="fa fa-sitemap"></i><span>Transactions</span>',array('default/transaction')) ?></li> --> -->

    </ul><!-- /.sidebar-menu -->
    <div style="position:absolute; bottom:0px; width:100%;">
      <ul class="sidebar-menu">
        <li class="header text-red"><strong>RESET</strong></li>
        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/resetaccounts" class="confirmation"><i class="fa fa-exclamation-triangle"></i> Reset</a></li>
        <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/resetindex"><i class="fa fa-user-times"></i> Reset Accounts <span class="badge" style="margin-left:5px;"><?php echo Account::model()->userAccount()->isReset()->count(); ?></span></a></li>
        <!-- This action is Irrevocable -->
      </ul>
    </div>
  </section>
  <!-- /.sidebar -->
</aside>

<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('You will be redirected to a page to reset all accounts of JCI Phillipines. The proceeding actions are Irrevocable. Do you want to proceed?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>