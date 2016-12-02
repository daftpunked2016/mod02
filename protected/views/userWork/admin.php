<?php
/* @var $this UserWorkController */
/* @var $model UserWork */

$this->breadcrumbs=array(
	'User Works'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserWork', 'url'=>array('index')),
	array('label'=>'Create UserWork', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-work-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Works</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-work-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'work_type_id',
		'company_name',
		'position',
		'address',
		'city_id',
		/*
		'province_id',
		'account_id',
		'status_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
