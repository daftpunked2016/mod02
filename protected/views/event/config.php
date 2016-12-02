<section class="content-header">
  <h1>
    Event Registration
  </h1>
</section>

    <!-- Main content -->
<section class="content">
  <div class="row">
    
    <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
              echo "<div class='alert alert-danger alert-dismissible fade-in' role='alert' id='myAlert'>
              <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
              $message.'</div>';
              }
    ?>
  </div>


  <div class="row">
    <div class="form">

      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'position-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>true,
      )); ?>

    <div class="col-md-3"></div>
    <div class="col-md-6">

        <div class="well">

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="eventname">Event Name</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="eventname" value="<?php echo ucwords(strtolower($event->name)); ?>" disabled/>
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="eventtype">Event Type</label>
                </div>
                <div class="col-sm-8">
                  <?php $event_type = EventTypes::model()->findByPk($event->event_type); ?>
                  <input type="text" class="form-control" id="eventtype" value="<?php echo ucwords(strtolower($event_type->name)); ?>" disabled/>
                </div>
              </div>
            </div>

            <?php if($event->event_type == 2): ?>
              <div class="row" style="margin-bottom:15px;">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="areano">Area No.</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="areano" value="<?php echo $event->areacon_area_no; ?>" disabled/>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="host">Host Chapter</label>
                </div>
                <div class="col-sm-8">
                  <?php $chapter = Chapter::model()->findByPk($event->host_chapter_id); ?>
                  <input type="text" class="form-control" id="host" value="<?php echo $chapter->chapter; ?>" disabled/>
                </div>
              </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="pricingtype">Pricing Type</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="pricingtype" 
                  value="<?php
                  if($eventpricing->pricing_type == 1)
                    echo "FREE";
                  else if($eventpricing->pricing_type == 2)
                    echo "Fixed Rate";
                  else if($eventpricing->pricing_type == 3)
                    echo "Packages";
                  ?>" 
                  disabled />
                </div>
              </div>
            </div>

            <?php if($package_type != 0): ?>

              <div class="row" style="margin-bottom:15px;">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="packagetype">Package</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="packagetype" 
                    value="<?php
                    if($package_type == 1)
                      echo "Early Bird";
                    else if($package_type == 2)
                      echo "Regular";
                    else if($package_type == 3)
                      echo "Onsite";
                    ?>" 
                    disabled />
                  </div>
                </div>
              </div>

            <?php endif;?>

            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <label for="packagetype">Price</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="packagetype" 
                  value="<?php
                  if($package_type == 0 || $package_type == 2)
                    echo "Php. ".$eventpricing->regular_price;
                  else if($package_type == 1)
                    echo "Php. ".$eventpricing->early_bird_price;
                  else if($package_type == 3)
                    echo "Php. ".$eventpricing->onsite_price;
                  ?>" 
                  disabled />
                </div>
              </div>
            </div>
            
            <?php if($event_ps != null): ?>
              <div class="row" style="margin-bottom:15px;">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="bank_branch">Payment Schemes</label>
                  </div>
                  <div class="col-sm-8">
                    <?php foreach($event_ps as $ps): 
                          $paymentscheme  = PaymentScheme::model()->findByPk($ps->payment_scheme_id); ?>
                      <?php echo "<B>".$paymentscheme->bank_details."</B>  -  ".$paymentscheme->bank_account_no."<br />"; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>

        </div>
          

        <div class="row buttons" style="margin-bottom:20px;">
          <?php echo CHtml::submitButton('Submit Registration', array('class'=>'btn btn-lg btn-primary pull-right', 'style'=>'margin-right:20px;', 'name'=>'register')); ?>
          <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/event" class= "btn btn-lg btn-danger pull-right" style="margin-right:10px;" type="button">Cancel</a>
        </div>

      </div>
    </div>
  </div>
  <div class="col-md-3"></div>


  <?php $this->endWidget(); ?>

    
</section><!-- /.content -->