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

<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<section class="content-header">
  <h1>
   	Change Password
  </h1>
</section>

<section class="content">
	<?php $this->renderPartial('_form_password', array('account'=>$account)); ?>
</section>