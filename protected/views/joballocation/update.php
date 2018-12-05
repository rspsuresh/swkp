<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */

$this->breadcrumbs=array(
	'Job Allocations'=>array('index'),
	$model->ja_job_id=>array('view','id'=>$model->ja_job_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JobAllocation', 'url'=>array('index')),
	array('label'=>'Create JobAllocation', 'url'=>array('create')),
	array('label'=>'View JobAllocation', 'url'=>array('view', 'id'=>$model->ja_job_id)),
	array('label'=>'Manage JobAllocation', 'url'=>array('admin')),
);
?>

<h1>Update JobAllocation <?php echo $model->ja_job_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>