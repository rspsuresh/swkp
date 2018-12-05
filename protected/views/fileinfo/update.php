<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */

$this->breadcrumbs=array(
	'File Infos'=>array('index'),
	$model->fi_file_id=>array('view','id'=>$model->fi_file_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FileInfo', 'url'=>array('index')),
	array('label'=>'Create FileInfo', 'url'=>array('create')),
	array('label'=>'View FileInfo', 'url'=>array('view', 'id'=>$model->fi_file_id)),
	array('label'=>'Manage FileInfo', 'url'=>array('admin')),
);
?>

<h1>Update FileInfo <?php echo $model->fi_file_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>