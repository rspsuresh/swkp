<?php
/* @var $this ClientDetailsController */
/* @var $data ClientDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cd_id), array('view', 'id'=>$data->cd_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_downloadtype')); ?>:</b>
	<?php echo CHtml::encode($data->cd_downloadtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_projectid')); ?>:</b>
	<?php echo CHtml::encode($data->cd_projectid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_url')); ?>:</b>
	<?php echo CHtml::encode($data->cd_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_username')); ?>:</b>
	<?php echo CHtml::encode($data->cd_username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_password')); ?>:</b>
	<?php echo CHtml::encode($data->cd_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_port')); ?>:</b>
	<?php echo CHtml::encode($data->cd_port); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_folderpath')); ?>:</b>
	<?php echo CHtml::encode($data->cd_folderpath); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->cd_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_last_modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->cd_last_modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cd_flag')); ?>:</b>
	<?php echo CHtml::encode($data->cd_flag); ?>
	<br />

	*/ ?>

</div>