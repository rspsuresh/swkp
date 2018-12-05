<?php
/* @var $this ClientDetailsController */
/* @var $model ClientDetails */

$this->breadcrumbs=array(
	'Client Details'=>array('index'),
	$model->cd_id=>array('view','id'=>$model->cd_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClientDetails', 'url'=>array('index')),
	array('label'=>'Create ClientDetails', 'url'=>array('create')),
	array('label'=>'View ClientDetails', 'url'=>array('view', 'id'=>$model->cd_id)),
	array('label'=>'Manage ClientDetails', 'url'=>array('admin')),
);
?>

<h1>Update ClientDetails <?php echo $model->cd_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>