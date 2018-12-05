<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */

$this->breadcrumbs=array(
	'Job Allocations'=>array('index'),
	$model->ja_job_id,
);

$this->menu=array(
	array('label'=>'List JobAllocation', 'url'=>array('index')),
	array('label'=>'Create JobAllocation', 'url'=>array('create')),
	array('label'=>'Update JobAllocation', 'url'=>array('update', 'id'=>$model->ja_job_id)),
	array('label'=>'Delete JobAllocation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ja_job_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JobAllocation', 'url'=>array('admin')),
);
?>

<h1>View JobAllocation #<?php echo $model->ja_job_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ja_job_id',
		'ja_partition_id',
		'ja_qc_id',
		'ja_qc_allocated_time',
		'ja_allocated_by',
		'ja_qc_allocated_by',
		'ja_qc_accepted_time',
		'ja_qc_completed_time',
		'ja_qc_notes',
		'ja_reviewer_id',
		'ja_reviewer_allocated_time',
		'ja_reviewer_accepted_time',
		'ja_reviewer_completed_time',
		'ja_reviewer_notes',
		'ja_tl_id',
		'ja_tl_accepted_time',
		'ja_tl_completed_time',
		'ja_tl_notes',
		'ja_status',
		'ja_created_date',
		'ja_last_modified',
		'ja_flag',
	),
)); ?>
