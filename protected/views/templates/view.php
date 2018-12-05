<?php
/* @var $this TemplatesController */
/* @var $model Templates */

$this->breadcrumbs=array(
	'Templates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Templates', 'url'=>array('index')),
	array('label'=>'Create Templates', 'url'=>array('create')),
	array('label'=>'Update Templates', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Templates', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Templates', 'url'=>array('admin')),
);
?>

<h1>View Templates #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'op_id',
		't_id',
		't_status',
	),
)); ?>
