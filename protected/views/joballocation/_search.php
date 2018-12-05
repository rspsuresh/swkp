<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ja_job_id'); ?>
		<?php echo $form->textField($model,'ja_job_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_partition_id'); ?>
		<?php echo $form->textField($model,'ja_partition_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_qc_id'); ?>
		<?php echo $form->textField($model,'ja_qc_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_qc_allocated_time'); ?>
		<?php echo $form->textField($model,'ja_qc_allocated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_allocated_by'); ?>
		<?php echo $form->textField($model,'ja_allocated_by',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_qc_allocated_by'); ?>
		<?php echo $form->textField($model,'ja_qc_allocated_by',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_qc_accepted_time'); ?>
		<?php echo $form->textField($model,'ja_qc_accepted_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_qc_completed_time'); ?>
		<?php echo $form->textField($model,'ja_qc_completed_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_qc_notes'); ?>
		<?php echo $form->textArea($model,'ja_qc_notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_reviewer_id'); ?>
		<?php echo $form->textField($model,'ja_reviewer_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_reviewer_allocated_time'); ?>
		<?php echo $form->textField($model,'ja_reviewer_allocated_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_reviewer_accepted_time'); ?>
		<?php echo $form->textField($model,'ja_reviewer_accepted_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_reviewer_completed_time'); ?>
		<?php echo $form->textField($model,'ja_reviewer_completed_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_reviewer_notes'); ?>
		<?php echo $form->textArea($model,'ja_reviewer_notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_tl_id'); ?>
		<?php echo $form->textField($model,'ja_tl_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_tl_accepted_time'); ?>
		<?php echo $form->textField($model,'ja_tl_accepted_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_tl_completed_time'); ?>
		<?php echo $form->textField($model,'ja_tl_completed_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_tl_notes'); ?>
		<?php echo $form->textArea($model,'ja_tl_notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_status'); ?>
		<?php echo $form->textField($model,'ja_status',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_created_date'); ?>
		<?php echo $form->textField($model,'ja_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_last_modified'); ?>
		<?php echo $form->textField($model,'ja_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ja_flag'); ?>
		<?php echo $form->textField($model,'ja_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->