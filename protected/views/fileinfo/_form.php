<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-info-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_pjt_id'); ?>
		<?php echo $form->textField($model,'fi_pjt_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'fi_pjt_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_file_name'); ?>
		<?php echo $form->textField($model,'fi_file_name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'fi_file_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_file_ori_location'); ?>
		<?php echo $form->textField($model,'fi_file_ori_location',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'fi_file_ori_location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_file_completed_location'); ?>
		<?php echo $form->textField($model,'fi_file_completed_location',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'fi_file_completed_location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_file_uploaded_date'); ?>
		<?php echo $form->textField($model,'fi_file_uploaded_date'); ?>
		<?php echo $form->error($model,'fi_file_uploaded_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_file_completed_time'); ?>
		<?php echo $form->textField($model,'fi_file_completed_time'); ?>
		<?php echo $form->error($model,'fi_file_completed_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_status'); ?>
		<?php echo $form->textField($model,'fi_status',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'fi_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_created_date'); ?>
		<?php echo $form->textField($model,'fi_created_date'); ?>
		<?php echo $form->error($model,'fi_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_last_modified'); ?>
		<?php echo $form->textField($model,'fi_last_modified'); ?>
		<?php echo $form->error($model,'fi_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fi_flag'); ?>
		<?php echo $form->textField($model,'fi_flag',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'fi_flag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->