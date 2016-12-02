<?php
/* @var $this SurveyController */
/* @var $model SurveyQuestionnaires */

$this->breadcrumbs=array(
	'Survey Questionnaires'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SurveyQuestionnaires', 'url'=>array('index')),
	array('label'=>'Create SurveyQuestionnaires', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#survey-questionnaires-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Survey Questionnaires</h1>

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
	'id'=>'survey-questionnaires-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'question',
		'respondents_type',
		'respondents_loc_type',
		'respondents_loc',
		'date_created',
		/*
		'date_updated',
		'status_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
