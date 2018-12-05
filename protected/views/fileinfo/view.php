<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */

$this->breadcrumbs=array(
	'File Infos'=>array('index'),
	$model->fi_file_id,
);

$this->menu=array(
	array('label'=>'List FileInfo', 'url'=>array('index')),
	array('label'=>'Create FileInfo', 'url'=>array('create')),
	array('label'=>'Update FileInfo', 'url'=>array('update', 'id'=>$model->fi_file_id)),
	array('label'=>'Delete FileInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->fi_file_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FileInfo', 'url'=>array('admin')),
);
?>

<h1>View FileInfo #<?php echo $model->fi_file_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'fi_file_id',
		'fi_pjt_id',
		'fi_file_name',
		'fi_file_ori_location',
		'fi_file_completed_location',
		'fi_file_uploaded_date',
		'fi_file_completed_time',
		'fi_status',
		'fi_created_date',
		'fi_last_modified',
		'fi_flag',
	),
)); ?>
