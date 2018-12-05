<?php
/* @var $this OutputController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Outputs',
);

$this->menu=array(
	array('label'=>'Create Output', 'url'=>array('create')),
	array('label'=>'Manage Output', 'url'=>array('admin')),
);
?>

<h1>Outputs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
