<section class="content-header">
  <h1>
    Change Password
    <small>Settings</small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="well">
    <div class="form">

      <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'changepass-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'form-horizontal', 'role'=>'form'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
      )); ?>

        <h4 style="margin-top:0px">Change Password</h4>
        <hr />

        <p class="note">All fields are required.</p>


        <?php foreach(Yii::app()->user->getFlashes() as $key=>$message) {
          if($key  === 'success')
          {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
            $message.'</div>';
          }
          else
          {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
            $message.'</div>';
          }

        }
        ?>

        <?php 
          if($form->errorSummary($account) != null): {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>".
            $form->errorSummary($account).'</div>';
          }
          endif;
        ?>

        <div class="form-group">
          <?php echo $form->labelEx($account,'current Password', array('class'=>'col-lg-4')); ?>
          <div class="col-lg-8">
            <?php echo $form->passwordField($account,'current_password', array('class'=>'form-control', 'placeholder'=>'Current Password')); ?>
          </div>
        </div>

        <div class="form-group">
          <?php echo $form->labelEx($account,'new Password', array('class'=>'col-lg-4')); ?>
          <div class="col-lg-8">
            <?php echo $form->passwordField($account,'new_password', array('class'=>'form-control', 'placeholder'=>'New Password')); ?>
          </div>
        </div>

        <div class="form-group">
          <?php echo $form->labelEx($account,'confirm New Password', array('class'=>'col-lg-4')); ?>
          <div class="col-lg-8">
            <?php echo $form->passwordField($account,'confirm_password', array('class'=>'form-control', 'placeholder'=>'Confirm New Password')); ?>
          </div>
        </div>

        <div class="row buttons">
          <?php echo CHtml::submitButton('Change Password', array('class' => 'submitButton btn btn-primary btn-md')); ?>
        </div>
      <?php $this->endWidget(); ?>
    </div><!-- form -->
  </div>
</section><!-- /.content -->