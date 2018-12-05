<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */

$this->breadcrumbs=array(
	'File Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FileInfo', 'url'=>array('index')),
	array('label'=>'Manage FileInfo', 'url'=>array('admin')),
);
?>

<h1>Create FileInfo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>