<?php
/* @var $this JobAllocationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Job Allocations',
);

$this->menu=array(
	array('label'=>'Create JobAllocation', 'url'=>array('create')),
	array('label'=>'Manage JobAllocation', 'url'=>array('admin')),
);
?>

<h1>Job Allocations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
