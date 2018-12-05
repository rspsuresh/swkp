<?php
/* @var $this TemplatesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Templates',
);

$this->menu=array(
	array('label'=>'Create Templates', 'url'=>array('create')),
	array('label'=>'Manage Templates', 'url'=>array('admin')),
);
?>

<h1>Templates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
