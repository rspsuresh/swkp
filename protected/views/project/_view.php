<?php
/* @var $this ProjectController */
/* @var $data Project */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_pjt_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->p_pjt_id), array('view', 'id'=>$data->p_pjt_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_client_id')); ?>:</b>
	<?php echo CHtml::encode($data->p_client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_name')); ?>:</b>
	<?php echo CHtml::encode($data->p_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_op_format')); ?>:</b>
	<?php echo CHtml::encode($data->p_op_format); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_key_type')); ?>:</b>
	<?php echo CHtml::encode($data->p_key_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_category_ids')); ?>:</b>
	<?php echo CHtml::encode($data->p_category_ids); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->p_created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('p_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->p_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('p_flag')); ?>:</b>
	<?php echo CHtml::encode($data->p_flag); ?>
	<br />

	*/ ?>

</div>