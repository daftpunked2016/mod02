<?php
/* @var $this AccountController */
/* @var $model Account */

	$this->breadcrumbs=array(
		'Accounts'=>array('index'),
		'Create',
	);
?>

<h1 align="center">Account Registration</h1>

<?php $this->renderPartial('_form', array('account'=>$account, 'user'=>$user)); ?>