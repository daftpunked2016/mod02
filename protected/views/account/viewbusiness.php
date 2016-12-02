<?php
        $fileupload = Fileupload::model()->findByPk($userbusiness->business_avatar);
        $business_avatar = $fileupload->filename;
        $businesstype = BusinessSubtype::model()->findByPk($userbusiness->business_type_id);
        $businesscat = BusinessCategory::model()->findByPk($businesstype->type);
        $city = Cities::model()->findByPk($userbusiness->city_id);
        $province = Provinces::model()->findByPk($userbusiness->province_id);
      ?>
  <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Business Profile
    <small>Preview of Business Information</small>
  </h1>
</section>
    <!-- Main content -->
<div class="row">
  <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-building"></i> <?php echo $userbusiness->business_name; ?> <!-- business name -->
          </h2>
        </div><!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
          <!-- business avatar-->
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/business_avatars/<?php echo $business_avatar; ?>" class="img-circle" alt="User Image" style="height:215px; width:215px; display:block;margin-left:auto;margin-right:auto; margin-bottom:20px;"/>
          <a href="#" data-toggle="modal" data-target="#businessModal" class="btn btn-primary visible-sm visible-xs" style="margin-right:auto; margin-left: auto; margin-bottom:5px;"><i class="fa fa-camera" style="margin-right:10px"></i>Change Business Logo</a>
          <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/updateBusiness/<?php echo $userbusiness->id; ?>" class="btn btn-success visible-sm visible-xs" style="margin-right:auto; margin-left: auto; margin-bottom:15px;"><i class="fa fa-pencil" style="margin-right:10px"></i>Edit Business</a>
        </div><!-- /.col -->

        <div class="col-md-8 invoice-col">
          
          <div class="row">
            <div class="col-md-6 invoice-col">
                <strong>Business Type</strong><br>
                <?php echo $businesstype->subtype." - <i>(".$businesscat->category.")</i>"; ?> <br> <!-- business_type_id -->
            </div>
            <div class="col-md-6 invoice-col">
                <strong>Operation Hours</strong><br>
                <?php echo $userbusiness->operating_hours; ?>
            </div><!-- /.col -->
          </div>

          <div class="row" style="margin-top:30px;">
            <div class="col-md-6 invoice-col">
              <strong>Address</strong><br>
              <?php echo $userbusiness->address; ?><br> <!-- street -->
              <?php echo $city->name.", ".$province->name; ?><br> <!-- city ID -->
            </div>
            
            <div class="col-md-6 invoice-col">
                <strong>Contact Info:</strong><br>
                <?php echo $userbusiness->contact_no; ?>
            </div><!-- /.col -->
          </div>

          <div class="row" style="margin-top:20px;">
            <div class="pull-right hidden-sm hidden-xs">
              <button data-toggle="modal" data-target="#businessModal" class="btn btn-default btn-md" style="margin-right:5px"><i class="fa fa-camera" style="margin-right:10px"></i>Change Business Logo</button>
              <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/updateBusiness/<?php echo $userbusiness->id; ?>" class="btn btn-success btn-md" style="margin-right:10px"><i class="fa fa-pencil" style="margin-right:10px"></i>Edit Business</a>
            </div>
          </div>

        </div>
      </div>   
      
      <div class="row">
        <div class="col-sm-12 invoice-col">
       	<br>
        	<strong>Business Description</strong>
        	<p><?php echo $userbusiness->description; ?></p>
        </div><!-- /.col -->
      </div>
      

  </section><!-- /.content -->
</div>


  <div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-picture" style="margin-right:10px;"></span>Change Business Logo</h4>
      </div>
      <div class="modal-body">
        <div class = "well">
          <div class ="row">
            <div class='col-lg-4 col-md-4'>
              <center><img style="border:2px solid black;  height:150px; width:150px;" src="<?php echo Yii::app()->request->baseUrl; ?>/business_avatars/<?php echo $business_avatar; ?>" id="avatarRead" /> </center>
            </div>
          <div class="visible-sm" >
            <br /> <br />
          </div>
          <div class='col-lg-8 col-md-8'>
            <form role="form" name="useravatar" id="useravatar" method="POST" enctype = "multipart/form-data" action="<?php echo Yii::app()->baseUrl; ?>/index.php/account/changeBusinessLogo/<?php  echo $userbusiness->id; ?>">
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
        <button class="btn btn-success" type="submit" value="Change Logo" id="submit">Save Changes</button> 
        </form>
      </div>
    </div>
    </div>
  </div> 
    