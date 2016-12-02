<section class="content-header">
  <h1>
    Update Business
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


  <div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
      'id'=>'business-form',
      // Please note: When you enable ajax validation, make sure the corresponding
      // controller action is handling ajax validation correctly.
      // There is a call to performAjaxValidation() commented in generated controller code.
      // See class documentation of CActiveForm for details on this.
      'enableAjaxValidation'=>true,
    )); ?>

    <div class="container">
      <div class="row" style="color:#FFF;">
        <?php echo $form->errorSummary($userbusiness); ?>
      </div>
    </div>

  <div class="row">  
    <div class="col-md-3"></div>
    <div class="col-md-6">

      <div class="well">
            
          <div class="form-group">
              <label>Category* </label>
              <select class="form-control" id="business-category" name="business-category">
                <?php 
                $subtype = BusinessSubtype::model()->findByPk($userbusiness->business_type_id);
                $category = BusinessCategory::model()->findByPk($subtype->type); 
                ?>

                <option value="<?php echo $category->id; ?>" selected disabled> <?php echo $category->category; ?> </option>

                <?php $categories = BusinessCategory::model()->findAll(); 
                  foreach($categories as $category)
                    echo "<option value='".$category->id."'>".$category->category."</option>";
                ?>
              </select>
          </div>

          <div class="form-group">    
              <label>SubType* </label>
              <?php  ?>
              <select class="form-control" id="business-subtype" name="UserBusiness[business_type_id]">
                <option value="<?php echo $subtype->id; ?>" selected> <?php echo $subtype->subtype; ?> </option>
              </select>
          </div>

          <div class="form-group">
              <?php echo $form->labelEx($userbusiness,'business_name'); ?>
              <?php echo $form->textField($userbusiness,'business_name',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
              <?php echo $form->error($userbusiness,'business_name'); ?>
         </div>

          <div class="form-group">
              <?php echo $form->labelEx($userbusiness,'description'); ?>
              <?php echo $form->textArea($userbusiness,'description',array('size'=>40,'rows'=>3, 'class'=>'form-control', 'style'=>'resize:none;')); ?>
              <?php echo $form->error($userbusiness,'description'); ?>
         </div>

          <div class="form-group">
              <?php echo $form->labelEx($userbusiness,'address'); ?>
              <?php echo $form->textField($userbusiness,'address',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
              <?php echo $form->error($userbusiness,'address'); ?>
         </div>

          <div class="form-group">
              <label>Province* </label>
              <select class="form-control" id="business-province" name="UserBusiness[province]">
                <option value=""> Select Province... </option>
                <?php $provinces = Provinces::model()->findAll(); 
                  foreach($provinces as $province)
                    echo "<option value='".$province->id."'>".$province->name."</option>";
                ?>
              </select>
          </div>

          <div class="form-group">    
              <label>City* </label>
              <select class="form-control" id="business-city" name="UserBusiness[City]">
                <option value=""> -- </option>
              </select>
          </div>

          <div class="form-group">
              <?php echo $form->labelEx($userbusiness,'street'); ?>
              <?php echo $form->textField($userbusiness,'street',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
              <?php echo $form->error($userbusiness,'street'); ?>
          </div>

          <div class="form-group">
              <?php echo $form->labelEx($userbusiness,'contact_no'); ?>
              <?php echo $form->textField($userbusiness,'contact_no',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
              <?php echo $form->error($userbusiness,'contact_no'); ?>
          </div>

          <div class="form-group">
              <?php echo $form->labelEx($userbusiness,'operating_hours'); ?>
              <?php echo $form->textField($userbusiness,'operating_hours',array('size'=>40,'maxlength'=>40, 'class'=>'form-control')); ?>
              <?php echo $form->error($userbusiness,'operating_hours'); ?>
          </div>
        
        </div>
          

        <div class="row buttons">
          <?php echo CHtml::submitButton($userbusiness->isNewRecord ? 'Add Business' : 'Save', array('class'=>'btn btn-lg btn-primary pull-right', 'style'=>'margin-right:20px;')); ?>
        </div>

      </div>
    </div>
    <div class="col-md-3"></div>
  </div>


  <?php $this->endWidget(); ?>

    
</section><!-- /.content -->