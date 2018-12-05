<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->ct_cat_id=>array('view','id'=>$model->ct_cat_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'View Category', 'url'=>array('view', 'id'=>$model->ct_cat_id)),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model),false,true); ?>