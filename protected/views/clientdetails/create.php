<?php
/* @var $this ClientDetailsController */
/* @var $model ClientDetails */

$this->breadcrumbs=array(
	'Client Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClientDetails', 'url'=>array('index')),
	array('label'=>'Manage ClientDetails', 'url'=>array('admin')),
);
?>

<h1>Create ClientDetails</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>