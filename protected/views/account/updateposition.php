<div class="row">
  
  <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
            echo "<div class='alert alert-danger alert-dismissible fade-in' role='alert' id='myAlert'>
            <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
            $message.'</div>';
            }
  ?>
</div>



<section class="content-header">
  <h1>
    Update Position
  </h1>
</section>

    <!-- Main content -->
<section class="content">

  <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
      'id'=>'position-form',
      // Please note: When you enable ajax validation, make sure the corresponding
      // controller action is handling ajax validation correctly.
      // There is a call to performAjaxValidation() commented in generated controller code.
      // See class documentation of CActiveForm for details on this.
      'enableAjaxValidation'=>true,
    )); ?>

    <div class="container">
      <div class="row" style="color:#FFF;">
        <?php echo $form->errorSummary($userposition); ?>
      </div>
    </div>

  <div class="col-md-3"></div>
  <div class="col-md-6">

      <div class="well">

          <div class="row" style="margin-bottom:15px;">
            <div class="form-group">
              <?php $positions = Position::model()->findAll(); ?>
              <div class="col-sm-4">
                <label for="position_id">Position *</label>
              </div>
              <div class="col-sm-8">
                <select id="position_id" name="UserPositions[position_id]" class="form-control" required>
                  <option value =''> -- </option>
                  <?php 
                    foreach($positions as $position)
                      echo "<option value=".$position->id.">".$position->position."</option>";
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;" id="ncProject">
            <div class="form-group">
              <div class="col-sm-4">
                <label for="nc_project">Project *</label>
              </div>
              <div class="col-sm-8">
                <input type="text" id="nc-project" name="UserPositions[nc_project]" class="form-control" value=""/>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;" id="avpArea">
            <div class="form-group">
              <div class="col-sm-4">
                <label for="avp_area">Area (assigned as AVP)*</label>
              </div>
              <div class="col-sm-8">
                <select id="avp_area" name="UserPositions[avp_area]" class="form-control" >
                  <option value=''> Select Area No. </option>
                  <option value='1'>1</option>
                  <option value='2'>2</option>
                  <option value='3'>3</option>
                  <option value='4'>4</option>
                  <option value='4'>5</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;" id="rvpRegion">
            <div class="form-group">
              <div class="col-sm-4">
                <label for="rvp_region">Region (assigned as RVP)*</label>
              </div>
              <div class="col-sm-8">
                <select id="rvp_region" name="UserPositions[rvp_reg]" class="form-control" >
                  <?php $regions = AreaRegion::model()->findAll(); 
                      foreach($regions as $region)
                        echo "<option value=''> Select Region.. </option> <option value=".$region->id.">".$region->region."</option>";
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;">
            <div class="form-group">
              <?php $regions = AreaRegion::model()->findAll(array('select'=>'area_no', 'distinct'=>true)); ?>
              <div class="col-sm-4">
                <label for="area_no">Area No. *</label>
              </div>

              <div class="col-sm-8">
                <select id="area_no" name="area_no" class="form-control" required>
                  <option value =''>Select Area No.</option>
                  <?php 
                    foreach($regions as $region)
                      echo "<option value=".$region->area_no.">".$region->area_no."</option>";
                  ?>
                <select>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;"> 
            <div class="form-group">
              <div class="col-sm-4">
                <label for="region">Region *</label>
              </div>
              <div class="col-sm-8">
                <select id="region" name="region" class="form-control" required>
                  <option value=""> -- <option>
                <select>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;">
            <div class="form-group">
              <div class="col-sm-4">
                <label for="region">Chapter *</label>
              </div>
              <div class="col-sm-8" >
                <select id="chapter" name="UserPositions[chapter_id]" class="form-control" required>
                  <option value=""> -- <option>
                <select>
              </div>
            </div>
          </div>


          <?php if($userposition->status_id != 1): ?>
            <div class="row" style="margin-bottom:15px;">
              <div class="form-group">
                <div class="col-sm-4">
                  <?php echo $form->labelEx($userposition,'term_year'); ?>
                </div>
                <div class="col-sm-8">
                  <select name="UserPositions[term_year]" class="form-control required">
                      <option value=''>Select Term Year.. </option>
                      <?php
                        $prev_year = date('Y', strtotime('-1 year', strtotime(date('Y-m-d')))); 
                        
                        for($x=$prev_year; $x>=1950; $x--)
                        {
                          if($x == $userposition->term_year)
                             echo "<option value='".$x."' selected>".$x." </option>";
                          else
                            echo "<option value='".$x."'>".$x." </option>";
                        }
                      ?>
                  </select>

                  <?php echo $form->error($userposition,'term_year'); ?>
                </div>
              </div>
            </div>
          <?php endif; ?>

    
      </div>
        

      <div class="row buttons">
        <?php echo CHtml::submitButton($userposition->isNewRecord ? 'Add Position' : 'Save', array('class'=>'btn btn-lg btn-primary pull-right', 'style'=>'margin-right:20px;')); ?>
      </div>

    </div>
  </div>
  <div class="col-md-3"></div>


  <?php $this->endWidget(); ?>

    
</section><!-- /.content -->