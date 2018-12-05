<?php
/* @var $this FormsBuilderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Forms Builders',
);

$this->menu=array(
	array('label'=>'Create FormsBuilder', 'url'=>array('create')),
	array('label'=>'Manage FormsBuilder', 'url'=>array('admin')),
);
?>

<h1>Forms Builders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
