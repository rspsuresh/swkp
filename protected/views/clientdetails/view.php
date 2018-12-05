<?php
/* @var $this ClientDetailsController */
/* @var $model ClientDetails */

$this->breadcrumbs=array(
	'Client Details'=>array('index'),
	$model->cd_id,
);

$this->menu=array(
	array('label'=>'List ClientDetails', 'url'=>array('index')),
	array('label'=>'Create ClientDetails', 'url'=>array('create')),
	array('label'=>'Update ClientDetails', 'url'=>array('update', 'id'=>$model->cd_id)),
	array('label'=>'Delete ClientDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cd_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClientDetails', 'url'=>array('admin')),
);
?>

<h1>View ClientDetails #<?php echo $model->cd_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cd_id',
		'cd_downloadtype',
		'cd_projectid',
		'cd_url',
		'cd_username',
		'cd_password',
		'cd_port',
		'cd_folderpath',
		'cd_created_date',
		'cd_last_modified_date',
		'cd_flag',
	),
)); ?>
