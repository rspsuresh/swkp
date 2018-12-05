<?php
/* @var $this OutputController */
/* @var $model Output */

$this->breadcrumbs=array(
	'Outputs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Output', 'url'=>array('index')),
	array('label'=>'Manage Output', 'url'=>array('admin')),
);
?>

<h1>Create Output</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>