<?php
/* @var $this ClientDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Client Details',
);

$this->menu=array(
	array('label'=>'Create ClientDetails', 'url'=>array('create')),
	array('label'=>'Manage ClientDetails', 'url'=>array('admin')),
);
?>

<h1>Client Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
