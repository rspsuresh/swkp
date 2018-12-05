<?php
/* @var $this FilePartitionController */
/* @var $data FilePartition */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_part_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fp_part_id), array('view', 'id'=>$data->fp_part_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_file_id')); ?>:</b>
	<?php echo CHtml::encode($data->fp_file_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_filepath')); ?>:</b>
	<?php echo CHtml::encode($data->fp_filepath); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_category')); ?>:</b>
	<?php echo CHtml::encode($data->fp_category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_cat_id')); ?>:</b>
	<?php echo CHtml::encode($data->fp_cat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_page_nums')); ?>:</b>
	<?php echo CHtml::encode($data->fp_page_nums); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_status')); ?>:</b>
	<?php echo CHtml::encode($data->fp_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->fp_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->fp_last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fp_flag')); ?>:</b>
	<?php echo CHtml::encode($data->fp_flag); ?>
	<br />

	*/ ?>

</div>