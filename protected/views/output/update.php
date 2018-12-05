<?php
/* @var $this OutputController */
/* @var $model Output */

$this->breadcrumbs=array(
	'Outputs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Output', 'url'=>array('index')),
	array('label'=>'Create Output', 'url'=>array('create')),
	array('label'=>'View Output', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Output', 'url'=>array('admin')),
);
?>

<h1>Update Output <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>