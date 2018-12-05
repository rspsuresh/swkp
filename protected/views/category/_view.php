<?php
/* @var $this CategoryController */
/* @var $data Category */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_cat_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ct_cat_id), array('view', 'id'=>$data->ct_cat_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_cat_name')); ?>:</b>
	<?php echo CHtml::encode($data->ct_cat_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_keywords')); ?>:</b>
	<?php echo CHtml::encode($data->ct_keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_cat_type')); ?>:</b>
	<?php echo CHtml::encode($data->ct_cat_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->ct_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->ct_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ct_flag')); ?>:</b>
	<?php echo CHtml::encode($data->ct_flag); ?>
	<br />


</div>