<?php
/* @var $this TemplatesController */
/* @var $data Templates */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('op_id')); ?>:</b>
	<?php echo CHtml::encode($data->op_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_id')); ?>:</b>
	<?php echo CHtml::encode($data->t_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('t_status')); ?>:</b>
	<?php echo CHtml::encode($data->t_status); ?>
	<br />


</div>