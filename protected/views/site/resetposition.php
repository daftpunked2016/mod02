<div class="login-box">
  <div class="login-logo">
    <img src = "../../dist/img/navbar_jci.png" width="300px" height="150px" ></img>
  </div><!-- /.login-logo -->
  <div class="login-box-body">

      <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
          if($key  === 'success')
                {
                echo "<div class='alert alert-success alert-dismissible fade-in' role='alert'>
                <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
                $message.'</div>';
                }
              else
                {
                echo "<div class='alert alert-danger alert-dismissible fade-in' role='alert' id='myAlert'>
                <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
                $message.'</div>';
                }
        }
      ?>


    <h4 class="login-box-msg">Account Reset</h4>

    <div class="form">
      <form method="post">

          <div class="row" style="margin-bottom:15px;">
            <div class="form-group">
              <div class="col-sm-4">
                <label for="pos_category">Birthdate *</label>
              </div>
              <div class="col-sm-8">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                  'attribute' => 'birthdate',
                  'options'=>array(
                    'showAnim'=>'slideDown',
                    'yearRange'=>'-60:-18',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'dateFormat' => 'yy-mm-dd'
                    ),
                  'htmlOptions' => array(
                    'name'=>'birthdate',
                    'size' => 20,         // textField size
                    'class' => 'form-control',
                  ),  
                ));
              ?>
              </div>
            </div>
          </div>

          <div class="row" style="margin-bottom:15px;">
            <div class="form-group">
              <div class="col-sm-4">
                <label for="pos_category">Category *</label>
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
                <select id="position_id" name="UserPositions[position_id]" class="form-control" required>
                  <option value =''> -- </option>
                <select>
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
                <select id="rvp_region" name="UserPositions[rvp_reg]" class="form-control" >\
                  <option value=''> Select Region.. </option> 
                  <?php $regions = AreaRegion::model()->findAll(); 
                      foreach($regions as $region)
                        echo "<option value=".$region->id.">".$region->region."</option>";
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

          <div class="row buttons">
            <?php echo CHtml::submitButton('S U B M I T', array('class'=>'btn btn-primary btn-block pull-right', 'name'=>'submit')); ?>
          </div>

      </form>
    </div>

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<script src="<?php echo Yii::app()->request->baseUrl; ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/form-scripts.js"></script>