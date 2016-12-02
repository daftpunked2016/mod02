<?php
/* @var $this BillingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Billings',
);

$this->menu=array(
	array('label'=>'Create Billing', 'url'=>array('create')),
	array('label'=>'Manage Billing', 'url'=>array('admin')),
);
?>

<h1>Billings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
