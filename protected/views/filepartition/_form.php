<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-partition-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_file_id'); ?>
		<?php echo $form->textField($model,'fp_file_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'fp_file_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_filepath'); ?>
		<?php echo $form->textField($model,'fp_filepath',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'fp_filepath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_category'); ?>
		<?php echo $form->textField($model,'fp_category',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'fp_category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_cat_id'); ?>
		<?php echo $form->textField($model,'fp_cat_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'fp_cat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_page_nums'); ?>
		<?php echo $form->textArea($model,'fp_page_nums',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'fp_page_nums'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_status'); ?>
		<?php echo $form->textField($model,'fp_status',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'fp_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_created_date'); ?>
		<?php echo $form->textField($model,'fp_created_date'); ?>
		<?php echo $form->error($model,'fp_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_last_modified'); ?>
		<?php echo $form->textField($model,'fp_last_modified'); ?>
		<?php echo $form->error($model,'fp_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fp_flag'); ?>
		<?php echo $form->textField($model,'fp_flag',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'fp_flag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->