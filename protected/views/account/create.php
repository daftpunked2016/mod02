<?php
/* @var $this AccountController */
/* @var $model Account */

	$this->breadcrumbs=array(
		'Accounts'=>array('index'),
		'Create',
	);
?>

<div class="login-logo hidden-xs hidden-sm" style="margin-top:20px; margin-bottom:0px;">
	<img src = "../../dist/img/navbar_jci.png" width="300px" height="150px" ></img>
</div>

<h2 align="center" style="color:#FFF;">Account Registration</h2>

<?php $this->renderPartial('_form', array('account'=>$account, 'user'=>$user)); ?>