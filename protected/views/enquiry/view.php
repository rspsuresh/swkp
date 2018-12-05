<?php
/* @var $this EnquiryController */
/* @var $model Enquiry */

$this->breadcrumbs=array(
	'Enquiries'=>array('index'),
	$model->eq_id,
);

$this->menu=array(
	array('label'=>'List Enquiry', 'url'=>array('index')),
	array('label'=>'Create Enquiry', 'url'=>array('create')),
	array('label'=>'Update Enquiry', 'url'=>array('update', 'id'=>$model->eq_id)),
	array('label'=>'Delete Enquiry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->eq_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Enquiry', 'url'=>array('admin')),
);
?>

<h1>View Enquiry #<?php echo $model->eq_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'eq_id',
		'eq_description',
		'eq_mail',
		'eq_created_dt',
		'eq_last_modified',
		'eq_flag',
	),
)); ?>
