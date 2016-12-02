<!-- ALERT IF ACCOUNT IS DISABLED BY THE HQ -->
<!--
<section class="user-status">
 <div class="alert alert-danger">
  <h4><i class="icon fa fa-ban"></i> ACCOUNT INACTIVE!</h4>
  Danger alert preview. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.
  </div>
</section>
 --> 
    <!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row" style="margin-left:10px; margin-bottom:10px;">
    <div class="visible-md visible-lg">
      <h1>
       Hi <?php echo $user->firstname; ?>!
        <small>Welcome to your JCI Philippines Dashboard</small>
      </h1>
    </div>
    <div class="visible-sm visible-xs">
      <h3>
       Hi <?php echo $user->firstname; ?>!
        <small>Welcome to your JCI Philippines Dashboard</small>
      </h3>
    </div>
  </div>
</section>

    <!-- Main content -->
<section class="content">
   <!-- Carousel -->
  <div class="row">
     <div class="col-md-7 col-lg-7">
      <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Latest Events</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
          <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
          <div class="item active">
          <img src="<?php echo Yii::app()->baseUrl; ?>/images/1.jpeg" alt="First slide">
          <div class="carousel-caption">
            <a href="#">View Details..</a>
          </div>
          </div>
          <div class="item">
          <img src="<?php echo Yii::app()->baseUrl; ?>/images/2.jpeg" alt="Second slide">
          <div class="carousel-caption">
           <a href="#">View Details..</a>
          </div>
          </div>
          <div class="item">
          <img src="<?php echo Yii::app()->baseUrl; ?>/images/3.jpeg" alt="Third slide">
          <div class="carousel-caption">
            <a href="#">View Details..</a>
          </div>
          </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
          <span class="fa fa-angle-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
          <span class="fa fa-angle-right"></span>
        </a>
        </div>
      </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-5 col-lg-5">
      <div class="info-box bg-aqua">
        <span class="info-box-icon"><i class="fa fa-user"></i></span>
        <div class="info-box-content">
          <span class="info-box-text"><?php $chapter=Chapter::model()->findByPk($user->chapter_id); echo $chapter->chapter; ?></span>
          <span class="info-box-number">
            <?php 
            //$members_count = User::model()->userAccount()->count('chapter_id = '.$user->chapter_id); echo $members_count; 
            echo User::model()->isActive()->userAccount()->count(array('condition'=>'chapter_id = :cid', 'params'=>array(':cid'=>$user->chapter_id)));
            ?>
          </span>
          <span class="progress-description">
            Members registered in your chapter
          </span>
        </div><!-- /.info-box-content -->
       </div><!-- /.info-box -->
       <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Events</span>
          <span class="info-box-number"><?php $events_count = Event::model()->count('status_id = 1'); echo $events_count; ?></span>
          <span class="progress-description">
            Latest & Upcoming Events
          </span>
        </div><!-- /.info-box-content -->
       </div><!-- /.info-box -->
       <div class="info-box bg-yellow">
        <span class="info-box-icon"><i class="fa fa-group"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Businesses</span>
          <span class="info-box-number"><?php $business_count = UserBusiness::model()->count('status_id =1'); echo $business_count; ?></span>
          <span class="progress-description">
            Registered Businesses in Directory
          </span>
        </div><!-- /.info-box-content -->
       </div><!-- /.info-box --> 
    </div>
  </div>
</section><!-- /.content -->