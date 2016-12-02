<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/default/index" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
     <span class="logo-mini"><img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_mini_jci.png" alt="JCI LOGO" height="42" width="35"><img></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_jci.png" alt="JCI LOGO" height="45" width="126"><img></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">  
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/admin-icon.png" class="user-image" alt="User Image"/>
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><?php echo $user->getAdminCompleteName(); ?> <strong>(Admin)</strong></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/admin-icon.png" alt="User Image" />
              <p>
                <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/admin/account/profile/id/<?php echo $user->account_id; ?>">
                  Administrator Account
                </a>
                <small>JCI Philippines Headquarters</small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <?php echo CHtml::link('Change Password', array('account/changepassword'),array('class'=>'btn btn-default btn-flat')); ?>
              </div>
              <div class="pull-right">
                <?php echo CHtml::link('Sign Out', array('default/logout'),array('class'=>'btn btn-default btn-flat')); ?>
              </div>
            </li>
          </ul>
        </li>
  
      </ul>
    </div>
  </nav>
</header>