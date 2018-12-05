<?php
/* @var $this UserTypeController */
/* @var $data UserType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ut_refid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ut_refid), array('view', 'id'=>$data->ut_refid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ut_usertype')); ?>:</b>
	<?php echo CHtml::encode($data->ut_usertype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ut_created_date')); ?>:</b>
	<?php echo CHtml::encode($data->ut_created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ut_last_modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->ut_last_modified_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ut_flag')); ?>:</b>
	<?php echo CHtml::encode($data->ut_flag); ?>
	<br />


</div>