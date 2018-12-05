<?php
/* @var $this UserTypeController */
/* @var $model UserType */

$this->breadcrumbs=array(
	'User Types'=>array('index'),
	$model->ut_refid,
);

$this->menu=array(
	array('label'=>'List UserType', 'url'=>array('index')),
	array('label'=>'Create UserType', 'url'=>array('create')),
	array('label'=>'Update UserType', 'url'=>array('update', 'id'=>$model->ut_refid)),
	array('label'=>'Delete UserType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ut_refid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserType', 'url'=>array('admin')),
);
?>

<h1>View UserType #<?php echo $model->ut_refid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ut_refid',
		'ut_usertype',
		'ut_created_date',
		'ut_last_modified_date',
		'ut_flag',
	),
)); ?>
