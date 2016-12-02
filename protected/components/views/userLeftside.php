<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p><?php echo User::model()->getCompleteName(); ?></p>
        <small>JCI Philippines</small>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" style="margin-top:20px;">
      <li class="header">Navigation</li>
      <!-- Optionally, you can add icons to the links -->
      <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/index"><i class='fa fa-home'></i> <span>Home</span></a></li>
      <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/profile"><i class='fa fa-user'></i> <span>My Profile</span></a></li>

      <?php if ($user->position_id == 9 || $user->position_id == 8 || $user->position_id == 4): ?>
      <!-- <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>List of Members</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><?php //echo CHtml::link('<i class="fa fa-user-plus"></i> Active Accounts', array('members/index', 's'=>1)); ?></li>
          <li><?php //echo CHtml::link('<i class="fa fa-user-plus"></i> Inactive Accounts', array('members/index', 's'=>2)) ?></li>
        </ul>
      </li> -->
      <li>
        <?php echo CHtml::link('<i class="fa fa-list"></i> <span>Membership</span>', array('members/list')); ?>
      </li>
      <?php endif; ?>

      <!-- <li><a href="<?php //echo Yii::app()->request->baseUrl; ?>/index.php/userBusiness/index"><i class='fa fa-group'></i> <span>Business Directory</span></a></li> -->
      <li class="treeview">
        <a href="#"><i class='fa fa-newspaper-o'></i> 
          <span>
            Events
            <?php $count = Event::model()->countNewEvents();
                  if($count != 0): 
            ?>
            <span class="badge" style="background:red; margin-left:5px;">!</span> 
            <?php endif; ?>
          </span>
          <i class="fa fa-angle-left pull-right"></i>   
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event"><i class="fa fa-reorder"></i> View Events <?php if($count != 0): ?><span class="badge" style="background:red; margin-left:5px;"><?php echo $count; ?></span><?php endif; ?> </a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/transactions"><i class="fa fa-tasks"></i> Transactions History </a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/listunpaids"><i class="fa fa-credit-card"></i> Upload Payment </a></li>
        </ul>
      </li>
     <!-- President Tasks -->
      <?php if($user->position_id == 11 || $user->position_id == 13): ?> 
      <li class="treeview">
        <a href="#">
          <i class="fa fa-laptop"></i>
          <span>Manage Members 
            <?php $count = Account::model()->countDel($user->chapter_id, 2);
                  if($count != 0): 
            ?>
            <span class="badge" style="background:red; margin-left:5px;">!</span> 
            <?php endif; ?>
          </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/listInactiveDelegates"><i class="fa fa-user-times"></i> Inactive Accounts <span class="badge" style="background:red; margin-left:5px;"><?php echo Account::model()->countDel($user->chapter_id, 2); ?></span></a></li>
          <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/listActiveDelegates"><i class="fa fa-user-plus"></i> Active Accounts <span class="badge" style="margin-left:5px;"><?php echo Account::model()->countDel($user->chapter_id, 1); ?></span></a></li>
        </ul>
      </li>
      <li>
        <?php //echo CHtml::link('<i class="fa fa-shopping-cart"></i> <span>Business Referrals</span>', array('userBusiness/listreferrals')); ?>
      </li>
      <?php endif; ?>

      <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/survey"><i class='fa fa-bar-chart'></i> <span>Survey</span></a></li>
      <li>
        <a href="http://jci.org.ph/jcipadvantage.com/mod04/index.php/public/listall" target="_blank">
          <i class="fa fa-download"></i>
          <span>JCIP Advantage Merchants</span>
        </a>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>