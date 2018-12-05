<?php
/* @var $this JobAllocationController */
/* @var $data JobAllocation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_job_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ja_job_id), array('view', 'id'=>$data->ja_job_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_partition_id')); ?>:</b>
	<?php echo CHtml::encode($data->ja_partition_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_qc_id')); ?>:</b>
	<?php echo CHtml::encode($data->ja_qc_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_qc_allocated_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_qc_allocated_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_allocated_by')); ?>:</b>
	<?php echo CHtml::encode($data->ja_allocated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_qc_allocated_by')); ?>:</b>
	<?php echo CHtml::encode($data->ja_qc_allocated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_qc_accepted_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_qc_accepted_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_qc_completed_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_qc_completed_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_qc_notes')); ?>:</b>
	<?php echo CHtml::encode($data->ja_qc_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_reviewer_id')); ?>:</b>
	<?php echo CHtml::encode($data->ja_reviewer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_reviewer_allocated_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_reviewer_allocated_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_reviewer_accepted_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_reviewer_accepted_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_reviewer_completed_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_reviewer_completed_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_reviewer_notes')); ?>:</b>
	<?php echo CHtml::encode($data->ja_reviewer_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_tl_id')); ?>:</b>
	<?php echo CHtml::encode($data->ja_tl_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_tl_accepted_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_tl_accepted_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_tl_completed_time')); ?>:</b>
	<?php echo CHtml::encode($data->ja_tl_completed_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_tl_notes')); ?>:</b>
	<?php echo CHtml::encode($data->ja_tl_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_status')); ?>:</b>
	<?php echo CHtml::encode($data->ja_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->ja_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->ja_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ja_flag')); ?>:</b>
	<?php echo CHtml::encode($data->ja_flag); ?>
	<br />

	*/ ?>

</div>