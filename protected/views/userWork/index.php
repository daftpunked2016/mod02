<?php
/* @var $this UserWorkController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Works',
);

$this->menu=array(
	array('label'=>'Create UserWork', 'url'=>array('create')),
	array('label'=>'Manage UserWork', 'url'=>array('admin')),
);
?>

<h1>User Works</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
