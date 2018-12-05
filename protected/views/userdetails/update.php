<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */

$this->breadcrumbs=array(
	'User Details'=>array('index'),
	$model->ud_refid=>array('view','id'=>$model->ud_refid),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserDetails', 'url'=>array('index')),
	array('label'=>'Create UserDetails', 'url'=>array('create')),
	array('label'=>'View UserDetails', 'url'=>array('view', 'id'=>$model->ud_refid)),
	array('label'=>'Manage UserDetails', 'url'=>array('admin')),
);
?>

<h1>Update UserDetails <?php echo $model->ud_refid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>