<?php
/* @var $this UserDetailsController */
/* @var $data UserDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_refid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ud_refid), array('view', 'id'=>$data->ud_refid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_empid')); ?>:</b>
	<?php echo CHtml::encode($data->ud_empid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_username')); ?>:</b>
	<?php echo CHtml::encode($data->ud_username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_password')); ?>:</b>
	<?php echo CHtml::encode($data->ud_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_name')); ?>:</b>
	<?php echo CHtml::encode($data->ud_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_gender')); ?>:</b>
	<?php echo CHtml::encode($data->ud_gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_dob')); ?>:</b>
	<?php echo CHtml::encode($data->ud_dob); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_marital_status')); ?>:</b>
	<?php echo CHtml::encode($data->ud_marital_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_email')); ?>:</b>
	<?php echo CHtml::encode($data->ud_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_temp_address')); ?>:</b>
	<?php echo CHtml::encode($data->ud_temp_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_permanent_address')); ?>:</b>
	<?php echo CHtml::encode($data->ud_permanent_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_mobile')); ?>:</b>
	<?php echo CHtml::encode($data->ud_mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_picture')); ?>:</b>
	<?php echo CHtml::encode($data->ud_picture); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_emergency_contatct_details')); ?>:</b>
	<?php echo CHtml::encode($data->ud_emergency_contatct_details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_role')); ?>:</b>
	<?php echo CHtml::encode($data->ud_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_cat_id')); ?>:</b>
	<?php echo CHtml::encode($data->ud_cat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_status')); ?>:</b>
	<?php echo CHtml::encode($data->ud_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->ud_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->ud_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ud_flag')); ?>:</b>
	<?php echo CHtml::encode($data->ud_flag); ?>
	<br />

	*/ ?>

</div>