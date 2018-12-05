<?php
/* @var $this FilePartitionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'File Partitions',
);

$this->menu=array(
	array('label'=>'Create FilePartition', 'url'=>array('create')),
	array('label'=>'Manage FilePartition', 'url'=>array('admin')),
);
?>

<h1>File Partitions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
