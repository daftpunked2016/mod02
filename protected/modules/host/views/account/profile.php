<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Account Preview
    <small>Preview of account profile</small>
  </h1>
</section>

<?php

$host = Host::model()->findByPk($model->id);

$user = User::model()->find(array('condition'=>'account_id='.$host->account_id));
$fileupload = Fileupload::model()->findByPk($user->user_avatar);
$user_avatar = $fileupload->filename;

?>

<section class="content">

  <div class="row" id="userProfDetails">

    <div class="row">
      <h2 style="margin-left:40px;" class="pull-left"> <i class="fa fa-user" style="margin-right:10px;"></i> Account Profile</h2>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/user_avatars/<?php echo $user_avatar; ?>" class="img-circle" alt="User Image" style="height:235px; width:235px;display:block;margin-left:auto;margin-right:auto; margin-top:20px; border: 28px #FFF;" />
      </div>

      <div class="col-md-8">
        <div class="box">
          <div class="box-body table-responsive no-padding">
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
            <table class="table table-hover">
              <tr>
                <th>Username / Email Address</th>
                <td>
                  <?php echo $host->username;?>
                  <!-- <a href="#" data-toggle="modal" data-target="#emailModal">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </a> -->
                </td>
              </tr>

              <tr>
                <th>Name</th>
                <td><?php echo $user->getHostCompleteName($host->account_id);?></td>
              </tr>

              <tr>
                <th>Title</th>
                <td>
                  <?php $title = "";
                  if ($account->user->title == 1)
                    $title = "JCI SEN";
                  else
                    $title = "JCI MEM";

                  echo $title;
                  ?>
                  <?php
                  // $title1 ="";
                  // $link = "";

                  // if ($user->title == 1)
                  //   $title1 = "<span class='btn btn-success btn-flat'>Change to Mem</span>";
                  // else if ($account->user->title == 2)
                  //   $title1 = "<span class='btn btn-success btn-flat'>Change to Sen</span>";

                  // if ($user->title == 1)
                  //   $link = "/admin/account/changetomem";
                  // else if ($account->user->title == 2)
                  //   $link = "/admin/account/changetosen";

                  // echo CHtml::link($title1, array($link, 'id' => $account->id), array('class' => 'btn pull-right', 'confirm' => "Are you sure you want to edit this account title?", 'title' => 'Delete'));
                  ?>
                </td>
              </tr>

              <tr>
                <th>Senator Number</th>
                <td><?php echo $user->sen_no ?>
                  <!-- <a href="#" data-toggle="modal" data-target="#myModal">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </a> -->
                </td>
              </tr>

              <tr>
                <th>Gender</th>
                <td>
                  <?php $gender = "";
                  if ($account->user->gender == 1)
                    $gender = "Male";
                  else
                    $gender = "Female";

                  echo $gender;
                  ?>
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

              <tr>
                <th>Area</th>
                <td>
                  <?php
                  $chapter = Chapter::model()->find(array('condition' => 'id ='.$user->chapter_id));
                  echo $chapter->area_no;
                  ?>
                </td>
              </tr>

              <tr>
                <th>Region</th>
                <td>
                  <?php
                  $region = AreaRegion::model()->find(array('condition' => 'id ='.$chapter->region_id));
                  echo $region->region;
                  ?>
                </td>
              </tr>

              <tr>
                <th>Chapter</th>
                <td>
                  <?php
                  $chapter = Chapter::model()->find(array('condition' => 'id ='.$user->chapter_id));
                  echo $chapter->chapter;
                  ?>
                </td>
              </tr>

              <tr>
                <th>Level & Position</th>
                <td>
                  <?php
                  $position = Position::model()->find(array('condition' => 'id ='.$user->position_id));

                  echo $position->category." / ".$position->position;
                  ?>
                  <!-- <a href="#" data-toggle="modal" data-target="#positionModal">
                    <span class="glyphicon glyphicon-pencil"></span>
                  </a> -->
                </td>
              </tr>

            </table>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel" align="center"><strong>Change Senator Number</strong></h4>
        </div>
        <div class="modal-body">
          <div class="form">
            <form method="post">
              <label>Senator Number:</label>
              <input type="text" name="sen_no" class="form-control" value="<?php echo $user->sen_no; ?>" />
            </div>
            <div class="modal-footer">
              <input type="submit" value="Save" class="btn btn-primary btn-flat"/>
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- email Modal -->
  <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="emailModalLabel" align="center"><strong>Change Username / Email Address</strong></h4>
        </div>
        <div class="modal-body">
          <div class="form">
            <form method="post">
              <label>Enter New Username / Email Address:</label>
              <input type="email" name="username" class="form-control" value="<?php echo $account->username; ?>" placeholder="Email" />
            </div>
            <div class="modal-footer">
              <input type="submit" value="Save" class="btn btn-primary btn-flat"/>
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- position Modal -->
  <div class="modal fade" id="positionModal" tabindex="-1" role="dialog" aria-labelledby="positionModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="positionModalLabel" align="center"><strong>ChangeLevel & Position</strong></h4>
        </div>
        <div class="modal-body">
          <div class="form">
            <form method="post">
              <div class="row" style="margin-bottom:15px;">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="pos_category">Position Category *</label>
                  </div>
                  <div class="col-sm-8">
                    <select id="pos_category" name="pos_category" class="form-control" required>
                      <option value =''> -- </option>
                      <option value ='Local'> Local </option>
                      <option value ='National'> National </option>
                      <select>
                      </div>
                    </div>
                  </div>

                  <div class="row" style="margin-bottom:15px;">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <label for="position_id">Position *</label>
                      </div>
                      <div class="col-sm-8">
                        <select id="position_id" name="position_id" class="form-control" required>
                          <option value =''> -- </option>
                          <select>
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <input type="submit" value="Save" class="btn btn-primary btn-flat"/>
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>