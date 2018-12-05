<?php
/* @var $this FileInfoController */
/* @var $data FileInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_file_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fi_file_id), array('view', 'id'=>$data->fi_file_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_pjt_id')); ?>:</b>
	<?php echo CHtml::encode($data->fi_pjt_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_file_name')); ?>:</b>
	<?php echo CHtml::encode($data->fi_file_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_file_ori_location')); ?>:</b>
	<?php echo CHtml::encode($data->fi_file_ori_location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_file_completed_location')); ?>:</b>
	<?php echo CHtml::encode($data->fi_file_completed_location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_file_uploaded_date')); ?>:</b>
	<?php echo CHtml::encode($data->fi_file_uploaded_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_file_completed_time')); ?>:</b>
	<?php echo CHtml::encode($data->fi_file_completed_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_status')); ?>:</b>
	<?php echo CHtml::encode($data->fi_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->fi_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->fi_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fi_flag')); ?>:</b>
	<?php echo CHtml::encode($data->fi_flag); ?>
	<br />

	*/ ?>

</div>