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


    <h4 class="login-box-msg">Member Login</h4>
    
    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'login-form',
    	'enableClientValidation'=>true,
    	'clientOptions'=>array(
    		'validateOnSubmit'=>true,
       ),
       )); ?>
       <div class="form-group has-feedback">
         <?php echo $form->textField($model,'username', array('class'=>'form-control', 'type'=>'email', 'placeholder'=>'Email')); ?><span class="glyphicon glyphicon-user form-control-feedback"></span>
         <?php echo $form->error($model,'username'); ?>
       </div>

       <div class="form-group has-feedback">
         <?php echo $form->passwordField($model,'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?><span class="glyphicon glyphicon-lock form-control-feedback"></span>
         <small class="pull-right" style="margin-top:5px;">
          <a href="<?php echo Yii::app()->baseUrl; ?>/index.php/site/forgotpassword"> 
            Forgot Password?
          </a> 
        </small>
      </div>

      <div class="row text-center">
        <div class="checkbox icheck">
         <small>
          <?php echo $form->checkbox($model,'rememberMe'); ?>
          <?php echo $form->label($model,'rememberMe'); ?>
          <?php echo $form->error($model,'rememberMe'); ?>
        </small>
      </div>
    </div>

    <div class="form-group">
      <?php echo CHtml::submitButton('Sign in', array('class'=>'btn btn-primary btn-block btn-flat pull-right')); ?>
    </div>

    <?php $this->endWidget(); ?>

    <div class="row">
      <p  style="margin-top:40px; margin-bottom:0px; text-align:center;">
        Not a member yet? <?php echo CHtml::link('REGISTER NOW', array('account/register')); ?>
      </p>
    </div>
  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

<script>
function showAlert(){
  $("#myAlert").addClass("in")
}
</script>