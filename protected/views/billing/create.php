<?php
/* @var $this BillingController */
/* @var $model Billing */

$this->breadcrumbs=array(
	'Billings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Billing', 'url'=>array('index')),
	array('label'=>'Manage Billing', 'url'=>array('admin')),
);
?>

<h1>Create Billing</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>