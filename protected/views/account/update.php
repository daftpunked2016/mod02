<?php
/* @var $this AccountController */
/* @var $model Account */


$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'View Account', 'url'=>array('view', 'id'=>$account->id)),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<section class="content-header">
  <h1>
    Update Account
  </h1>
</section>

<section class="content">
	<?php $this->renderPartial('_form_update', array('account'=>$account, 'user'=>$user)); ?>
</section>