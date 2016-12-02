<?php
        $worktype = BusinessSubtype::model()->findByPk($userwork->work_type_id);
        $workcat = BusinessCategory::model()->findByPk($worktype->type);
        $city = Cities::model()->findByPk($userwork->city_id);
        $province = Provinces::model()->findByPk($userwork->province_id);
      ?>
  <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Work Profile
    <small>Preview of Work/Job Information</small>
  </h1>
</section>
    <!-- Main content -->
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="row">
      <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-briefcase"></i> <?php echo $userwork->company_name; ?> <small> <?php echo $userwork->position; ?></small> <!-- company name -->
              </h2>
            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="container">
           
            <div class="row">
              <div class="invoice-col">
                <strong>Work Position</strong><br>
                <?php echo $userwork->position; ?>
              </div><!-- /.col -->
            </div>

            <div class="row" style="margin-top:20px;">
              <div class="invoice-col">
                  <strong>Work Type</strong><br>
                  <?php echo $worktype->subtype." - <i>(".$workcat->category.")</i>"; ?> <br> <!-- business_type_id -->
              </div>
            </div>

            <div class="row" style="margin-top:20px;">
              <div class="invoice-col">
                <strong>Company Address</strong><br>
                <?php echo $userwork->address; ?> <!-- street -->
                <small><i><?php echo $city->name.", ".$province->name; ?></i></small><br> <!-- city ID -->
              </div>
            </div>

            <div class="row" style="margin-top:20px;">
              <div class="invoice-col">
                  <a href="<?php echo Yii::app()->baseUrl;?>/index.php/account/updateWork/<?php echo $userwork->id; ?>" class="btn btn-success"><i class="fa fa-pencil" style="margin-right:10px"></i>Edit Work</a>
              </div>
          </div>   
      </section><!-- /.content -->
    </div>
  </div>
  <div class="col-md-3"></div> 
</div>
    