<?php
/* @var $this EnquiryController */
/* @var $model Enquiry */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'enquiry-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'eq_description'); ?>
		<?php echo $form->textField($model,'eq_description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'eq_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eq_mail'); ?>
		<?php echo $form->textField($model,'eq_mail',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'eq_mail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eq_created_dt'); ?>
		<?php echo $form->textField($model,'eq_created_dt'); ?>
		<?php echo $form->error($model,'eq_created_dt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eq_last_modified'); ?>
		<?php echo $form->textField($model,'eq_last_modified'); ?>
		<?php echo $form->error($model,'eq_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'eq_flag'); ?>
		<?php echo $form->textField($model,'eq_flag',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'eq_flag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->