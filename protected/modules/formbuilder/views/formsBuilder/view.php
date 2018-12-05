<?php
/* @var $this FormsBuilderController */
/* @var $model FormsBuilder */

$this->breadcrumbs=array(
	'Forms Builders'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List FormsBuilder', 'url'=>array('index')),
	array('label'=>'Create FormsBuilder', 'url'=>array('create')),
	array('label'=>'Update FormsBuilder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FormsBuilder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormsBuilder', 'url'=>array('admin')),
);
?>

<h1>View FormsBuilder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'value',
		'flag',
		'created_date',
		'last_modified',
	),
)); ?>
