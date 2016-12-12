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

<!-- Main content -->
<section class="content">

  <div class="row" style="background-color: #0397d7;" id="userProfHeader">
    <div class="col-md-3">
      <?php
          $account = Account::model()->findByPk(Yii::app()->user->id);
          $fileupload = Fileupload::model()->findByPk($account->user->user_avatar);
          $user_avatar = $fileupload->filename;
        ?>
      <img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" style="height:235px; width:235px;display:block;margin-left:auto;margin-right:auto; margin-top:20px; border: 28px #FFF;" />
      <button data-toggle="modal" data-target="#avatarModal" class="btn btn-default btn-sm hidden-sm hidden-xs" style="display:block; margin-top:15px; margin-bottom:10px; margin-left:auto; margin-right:auto;"><i class="fa fa-camera" style="margin-right:10px"></i>Change Profile Picture</button>
    </div>
    <div class="col-md-9">
        <?php $title = "";
        if ($user->title == 1)
              $title = "JCI SEN";
            else
              $title = "JCI MEM";
        ?>

      <div class="row" id="profUser" style="color:#FFF">
        <div class="row" id="profName">
          <h1 class="hidden-sm hidden-xs" style="margin-left:20px; margin-top:30px;"><?php echo $title." ".User::model()->getCompleteName(); ?> </h1>
          <h4 class="hidden-lg hidden-md" style="margin-bottom: 0px;"><center><?php echo $title." ".User::model()->getCompleteName(); ?></center></h4>
        </div>
        <div class="row" id="profChapter">
          <h3 class="hidden-sm hidden-xs" style="margin-left:20px; margin-top:0px;"><em><?php $chapter = Chapter::model()->findByPk($user->chapter_id); echo $chapter->chapter; ?></em></h3>
          <div class="hidden-lg hidden-md">
            <p style="margin-top:0px;">
                <center>
                  <em>
                    JCI <?php $chapter = Chapter::model()->findByPk($user->chapter_id); echo $chapter->chapter; ?> | 
                    <?php $position = Position::model()->findByPk($user->position_id); echo $position->position; ?>
                  </em>
                </center>
            </p>
          </div>
        </div>
        <div class="row" id="profPosition">
          <h4 class="hidden-sm hidden-xs" style="margin-left:20px; margin-top:0px;"><em><?php $position = Position::model()->findByPk($user->position_id); echo $position->position; ?></em></h4>
        </div>
      </div>

      <div class="row hidden-lg hidden-md" style="margin-bottom:10px">
        <center>
          <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/update/<?php echo $account->id; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" style="margin-right:5px"></i>Edit Profile</a>
          <button data-toggle="modal" data-target="#avatarModal" class="btn btn-danger btn-sm"><i class="fa fa-camera" style="margin-right:5px"></i>Change Profile Picture</button>
        </center>
      </div>
      <div class="row hidden-xs hidden-sm" style="margin-top:30px;margin-right:10px;">
        
        <div class="col-md-4">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $positioncount = UserPositions::model()->count('account_id ='.$account->id); ?></h3>
              <p> <strong>POSITION </strong>
                Number of positions that have been assigned to.
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-tag"></i>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $businesscount = UserBusiness::model()->count('account_id ='.$account->id); ?></h3>
              <p> <strong>BUSINESS </strong>
                Number of business owned or being managed.
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-map-marker"></i>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $workcount = UserWork::model()->count('account_id ='.$account->id); ?></h3>
              <p> <strong>WORK </strong>
                Number of work available in employment history.
              </p>
            </div>
            <div class="icon">
              <i class="fa fa-briefcase"></i>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="row" id="userProfDetails">

    <div class="row">
      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-user" style="margin-right:10px;"></i> Account Profile</h2>
      <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/update/<?php echo $account->id; ?>" class="btn btn-primary btn-md pull-right hidden-sm hidden-xs" id="btnEdit" style="margin-top: 20px; margin-right:40px;"><i class="fa fa-pencil" style="margin-right:10px;"></i>Edit Profile</a>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="box">
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <th>Username / Email Address</th>
                <td><a href="#"><?php echo $account->username;?></a></td>
              </tr>

              <tr>
                <th>First Name</th>
                <td><?php echo $user->firstname;?></td>
              </tr>
              
              <tr>
                <th>Last Name</th>
                <td><?php echo $user->lastname;?></td>
              </tr>

              <tr>
                <th>Middle Name</th>
                <td><?php echo $user->middlename;?></td>
              </tr>

              <tr>
                <th>Gender</th>
                <td>
                  <?php 
                  if($user->gender == 1) 
                      echo "Male"; 
                    else 
                      echo "Female";?>
                </td> 
              </tr>

              <tr>
                <th>Contact No.</th>
                <td><?php echo $user->contactno;?></td>
              </tr>

              <tr>
                <th>Address</th>
                <td><?php echo $user->address;?></td>
              </tr>

              <tr>
                <th>Date of Birth</th>
                <td><?php $date = strtotime($user->birthdate); echo date('M d,Y', $date);?></td>
              </tr>

            </table>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>

  <hr />

  <div class="row" id="userPosition" style="margin-top:20px;">
    <div class="row">
      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-tag" style="margin-right:10px;"></i> Positions </h2>
      <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/addPosition" class="btn btn-success btn-sm pull-right visible-sm visible-xs" id="btnEdit" style="margin-top: 20px; margin-right:20px;"><i class="fa fa-plus" style="margin-right:10px;"></i>Add New</a>
      <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/addPosition" class="btn btn-success btn-md pull-right hidden-sm hidden-xs" id="btnEdit" style="margin-top: 20px; margin-right:40px;"><i class="fa fa-plus" style="margin-right:10px;"></i>Add New Previous Position</a>
    </div>
    <div class="row" style="margin-top:20px;">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="box">
            <div class="box-body table-responsive no-padding">
              <?php  $this->widget('zii.widgets.CListView', array(
              'dataProvider'=>$positionsDP,
              'itemView'=>'_list_positions',
              'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
                  <thead>
                    <th>Position</th>
                    <th>Chapter</th>
                    <th>Term Year</th>
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
      <div class="col-md-1"></div>
    </div>
  </div>

  <hr />

  <div class="row" id="userBusinessWork" style="margin-top:20px; padding-bottom:40px;">
    <div class="row">
      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-briefcase" style="margin-right:10px;"></i> Career </h2>
      <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/addBusinessWork" class="btn btn-success btn-sm pull-right visible-sm visible-xs" style="margin-top:20px; margin-right:20px;"><i class="fa fa-plus" style="margin-right:10px;"></i>Add New</a>
      <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/addBusinessWork" class="btn btn-success btn-md pull-right hidden-sm hidden-xs" style="margin-top: 20px; margin-right:40px;"><i class="fa fa-plus" style="margin-right:10px;"></i>Add New Business/Work</a>
    </div>
    <?php $business = UserBusiness::model()->findAll('account_id = '.$account->id); 
          $work = UserWork::model()->findAll('account_id = '.$account->id); ?>

    <?php if($business != null): ?>
    <div class="row" style="margin-top:20px; margin-left:30px; margin-right:30px;">
      <center><h3>BUSINESS</h3></center>
      <?php foreach($business as $business): ?>
        <?php
                $fileupload = Fileupload::model()->findByPk($business->business_avatar);
                $business_avatar = $fileupload->filename;
                $businesstype = BusinessSubtype::model()->findByPk($business->business_type_id);
                $businesscat = BusinessCategory::model()->findByPk($businesstype->type);
                $city = Cities::model()->findByPk($business->city_id);
                $province = Provinces::model()->findByPk($business->province_id);
              ?>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading"><h4><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewbusiness/<?php echo $business->id; ?>"><?php echo $business->business_name; ?></a><small style="margin-left:10px"><?php echo $businesscat->category; ?></small></h4></div>
              <div class="panel-body">
                <div class="col-md-3">
                  <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewbusiness/<?php echo $business->id; ?>">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/business_avatars/<?php echo $business_avatar; ?>" class="img-circle" alt="Business Image" style="height:100px; width:100px; display:block;margin-left:auto;margin-right:auto;" />
                  </a>
                </div>
                <div class="col-md-9">
                  <table class="table table-hover">
                    <tr>
                      <th>Subtype</th>
                      <td><?php echo $businesstype->subtype; ?></td>
                    </tr>
                    <tr>
                      <th>Province</th>
                      <td><?php echo $province->name; ?></td>
                    </tr>
                    <tr>
                      <th>City</th>
                      <td><?php echo $city->name; ?></td>
                    </tr>
                  </table>
                </div>
                <div class="pull-right">
                  <?php 
                    echo CHtml::link('<button class="btn btn-danger"><span class="glyphicon glyphicon-remove" style="margin-right:5px;"></span>Delete </button>', array('account/deletebusiness', 'id' => $data->id), array('confirm' => "Are you sure you want to delete this business?", 'title' => 'Delete Business'));
                  ?>
                </div>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>


    <?php if($work != null): ?>
    <div class="row" style="margin-top:20px; margin-left:30px; margin-right:30px;">
      <center><h3>WORK</h3></center>
      <?php foreach($work as $work): ?>
        <?php
                $worktype = BusinessSubtype::model()->findByPk($work->work_type_id);
                $workcat = BusinessCategory::model()->findByPk($worktype->type);
                $city = Cities::model()->findByPk($work->city_id);
                $province = Provinces::model()->findByPk($work->province_id);
              ?>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4>
                  <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/account/viewwork/<?php echo $work->id; ?>"><?php echo $work->company_name; ?>
                  </a>
                  <small style="margin-left:10px"><?php echo $workcat->category; ?></small>
                </h4>
              </div>
              <div class="panel-body">
                <div class="col-md-12">
                  <table class="table table-hover">
                    <tr>
                      <th>Type of Work</th>
                      <td><?php echo $worktype->subtype; ?></td>
                    </tr>
                    <tr>
                      <th>Work Position</th>
                      <td><?php echo $work->position; ?></td>
                    </tr>
                    <tr>
                      <th>Province</th>
                      <td><?php echo $province->name; ?></td>
                    </tr>
                    <tr>
                      <th>City</th>
                      <td><?php echo $city->name; ?></td>
                    </tr>
                  </table>
                </div>
                <div class="pull-right">
                  <?php 
                    echo CHtml::link('<button class="btn btn-danger"><span class="glyphicon glyphicon-remove" style="margin-right:5px;"></span>Delete </button>', array('account/deletework', 'id' => $work->id), array('confirm' => "Are you sure you want to delete this work?", 'title' => 'Delete Work'));
                  ?>
                </div>
              </div>
            </div>
          </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <hr />

  <div class="row" id="projectsHandled" style="margin-top:20px;">
    <div class="row">
      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-book" style="margin-right:10px;"></i> Projects Handled </h2>
    </div>
    <div class="row" style="margin-top:20px;">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="box">
            <div class="box-body table-responsive no-padding">
              <?php  $this->widget('zii.widgets.CListView', array(
              'dataProvider'=>$projectsDP,
              'itemView'=>'_list_projects',
              'template' => "{sorter}<table id=\"example2\"class=\"table table-bordered table-hover\" >
                  <thead>
                    <th>Date</th>
                    <th>Project Title</th>
                    <th>Position</th>
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
      <div class="col-md-1"></div>
    </div>
  </div>

</section><!-- /.content -->

<!-- POSITION'S VIEW MODAL -->
<?php foreach ($positions as $position): ?> 
<div class="modal fade" id="positionModal<?php echo $position->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">View Position Details</h4>
          </div> 
          <div class="modal-body"> 
            <div class="row">
              <div class = "col-md-2"></div>
              <div class = "col-md-8">
                <?php $pos = Position::model()->findByPk($position->position_id); 
                      $pos_chapter = Chapter::model()->findByPk($position->chapter_id);
                      $pos_region = AreaRegion::model()->findByPk($chapter->region_id);
                ?>
                <h4>
                  <?php if($position->position_id == 10): ?>
                    <B>Project:</B>  <?php echo $position->nc_project; ?> <br>
                  <?php endif; ?>
                  <B>Position Name:</B> <?php echo $pos->position; ?> <br>
                  <?php if($position->position_id == 9): ?>
                    <B>Region Assigned:</B> <?php $rvp_reg= AreaRegion::model()->findByPk($position->rvp_reg); echo $rvp_reg->region; ?> <br>
                  <?php endif; ?>
                  <?php if($position->position_id == 8): ?>
                    <B>Area Assigned:</B>  <?php echo $position->avp_area; ?> <br>
                  <?php endif; ?>
                  <B>Region:</B> <?php echo $pos_region->region; ?> <br>
                  <B>Chapter:</B> JCI <?php echo $pos_chapter->chapter; ?> <br>
                  <B>Term Year:</B> <?php echo $position->term_year; ?> <br>
                </h4>
              </div>
              <div class = "col-md-2"></div>
            </div>
         </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </form>
          </div>
        </div>
        </div>
</div>
<?php endforeach; ?> 





  <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-picture" style="margin-right:10px;"></span>Change Profile Picture</h4>
      </div>
      <div class="modal-body">
        <div class = "well">
          <div class ="row">
            <div class='col-lg-4 col-md-4'>
              <center><img style="border:2px solid black;  height:150px; width:150px;" src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" id="avatarRead" /></center>
            </div>
          <div class="visible-sm" >
            <br /> <br />
          </div>
          <div class='col-lg-8 col-md-8'>
            <form role="form" name="useravatar" id="useravatar" method="POST" enctype = "multipart/form-data" action="<?php echo Yii::app()->baseUrl; ?>/index.php/account/changeposter">
               <div class="form-group">
                <label for="avatar" class="col-lg-2">Select Picture: </label>
                <div class="col-lg-10">
                  <input type="file" id="avatar" name="avatar">
                </div>
              </div>
            
          </div>
        </div>
      </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit" value="Change Avatar" id="submit">Save Changes</button> 
        </form>
      </div>
    </div>
    </div>
  </div> 