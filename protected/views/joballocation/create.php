<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */

$this->breadcrumbs=array(
	'Job Allocations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JobAllocation', 'url'=>array('index')),
	array('label'=>'Manage JobAllocation', 'url'=>array('admin')),
);
?>

<h1>Create JobAllocation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>