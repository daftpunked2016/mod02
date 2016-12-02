<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_mini_jci.png" alt="JCI LOGO" height="42" width="35"><img></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/img/navbar_jci.png" alt="JCI LOGO" height="45" width="102"><img></span>
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

        <li class="dropdown notifications-menu">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-newspaper-o"></i>
            <?php $count = Event::model()->countNewEvents();
                  if($count != 0): 
            ?>
            <span class="label label-warning" style="background:red; margin-left:5px;"><?php echo $count; ?></span> 
            <?php endif; ?>
          </a>
          
          <ul class="dropdown-menu">
            <li class="header"><strong>New Event/s</strong></li>
            <li>

              <ul class="menu">
                <li>
                  <?php if($count != 0): ?>
                  <?php 
                    $event_list = Event::model()->findAll('status_id = 1');
                    
                    foreach($event_list as $e)
                    {
                      $event = Event::model()->find('id = '.$e->id.' AND status_id = 1');
                      $event_attendee = EventAttendees::model()->find('account_id = '.Yii::app()->user->id.' AND event_id = '.$e->id);
 
                      if($event_attendee == null)
                      {
                        $fileupload = Fileupload::model()->findByPk($event->event_avatar);
                        $event_avatar = $fileupload->filename;
                        echo "<a href='".Yii::app()->request->baseUrl."/index.php/event/view?event_id=".$event->id."'><img src='".Yii::app()->request->baseUrl."/event_avatars/".$event_avatar."' class='img-circle' style='width:25px; height:25px; margin-right: 10px;'></i>".$event->name."</a>";
                      }
                    }
                    
                  ?>
                  <?php endif; ?>

                </li>
              </ul>
              

            </li>
            
            <li class="footer"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/event/">View all</a></li>
          </ul>


        </li> 
      
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <?php
              $user_avatar="";
              $account = Account::model()->findByPk(Yii::app()->user->id);
              $fileupload = Fileupload::model()->findByPk($account->user->user_avatar);
              $user_avatar = $fileupload->filename;
            ?>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="user-image" alt="User Image"/>
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><?php echo User::model()->getCompleteName(); ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" />
              <p>
               <?php echo User::model()->getCompleteName(); ?> 
                <small><?php echo User::model()->getPosition(); ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/changePassword" class="btn btn-default btn-flat">Change Password</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/site/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
  
      </ul>
    </div>
  </nav>
</header>