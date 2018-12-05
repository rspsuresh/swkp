<?php
/* @var $this EnquiryController */
/* @var $data Enquiry */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('eq_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->eq_id), array('view', 'id'=>$data->eq_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eq_description')); ?>:</b>
	<?php echo CHtml::encode($data->eq_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eq_mail')); ?>:</b>
	<?php echo CHtml::encode($data->eq_mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eq_created_dt')); ?>:</b>
	<?php echo CHtml::encode($data->eq_created_dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eq_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->eq_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eq_flag')); ?>:</b>
	<?php echo CHtml::encode($data->eq_flag); ?>
	<br />


</div>