<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */

$this->breadcrumbs=array(
	'File Partitions'=>array('index'),
	$model->fp_part_id=>array('view','id'=>$model->fp_part_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FilePartition', 'url'=>array('index')),
	array('label'=>'Create FilePartition', 'url'=>array('create')),
	array('label'=>'View FilePartition', 'url'=>array('view', 'id'=>$model->fp_part_id)),
	array('label'=>'Manage FilePartition', 'url'=>array('admin')),
);
?>

<h1>Update FilePartition <?php echo $model->fp_part_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>