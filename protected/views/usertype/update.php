<?php
/* @var $this UserTypeController */
/* @var $model UserType */

$this->breadcrumbs=array(
	'User Types'=>array('index'),
	$model->ut_refid=>array('view','id'=>$model->ut_refid),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserType', 'url'=>array('index')),
	array('label'=>'Create UserType', 'url'=>array('create')),
	array('label'=>'View UserType', 'url'=>array('view', 'id'=>$model->ut_refid)),
	array('label'=>'Manage UserType', 'url'=>array('admin')),
);
?>

<h1>Update UserType <?php echo $model->ut_refid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>