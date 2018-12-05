<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */

$this->breadcrumbs=array(
	'File Partitions'=>array('index'),
	$model->fp_part_id,
);

$this->menu=array(
	array('label'=>'List FilePartition', 'url'=>array('index')),
	array('label'=>'Create FilePartition', 'url'=>array('create')),
	array('label'=>'Update FilePartition', 'url'=>array('update', 'id'=>$model->fp_part_id)),
	array('label'=>'Delete FilePartition', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->fp_part_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FilePartition', 'url'=>array('admin')),
);
?>

<h1>View FilePartition #<?php echo $model->fp_part_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'fp_part_id',
		'fp_file_id',
		'fp_filepath',
		'fp_category',
		'fp_cat_id',
		'fp_page_nums',
		'fp_status',
		'fp_created_date',
		'fp_last_modified',
		'fp_flag',
	),
)); ?>
