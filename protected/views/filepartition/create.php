<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */

$this->breadcrumbs=array(
	'File Partitions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FilePartition', 'url'=>array('index')),
	array('label'=>'Manage FilePartition', 'url'=>array('admin')),
);
?>

<h1>Create FilePartition</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>