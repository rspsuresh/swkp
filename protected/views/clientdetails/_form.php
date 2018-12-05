<?php
/* @var $this ClientDetailsController */
/* @var $model ClientDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'client-details-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_downloadtype'); ?>
		<?php echo $form->textField($model,'cd_downloadtype',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'cd_downloadtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_projectid'); ?>
		<?php echo $form->textField($model,'cd_projectid'); ?>
		<?php echo $form->error($model,'cd_projectid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_url'); ?>
		<?php echo $form->textField($model,'cd_url',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'cd_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_username'); ?>
		<?php echo $form->textField($model,'cd_username',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'cd_username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_password'); ?>
		<?php echo $form->textField($model,'cd_password',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'cd_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_port'); ?>
		<?php echo $form->textField($model,'cd_port'); ?>
		<?php echo $form->error($model,'cd_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_folderpath'); ?>
		<?php echo $form->textField($model,'cd_folderpath',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'cd_folderpath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_created_date'); ?>
		<?php echo $form->textField($model,'cd_created_date'); ?>
		<?php echo $form->error($model,'cd_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_last_modified_date'); ?>
		<?php echo $form->textField($model,'cd_last_modified_date'); ?>
		<?php echo $form->error($model,'cd_last_modified_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cd_flag'); ?>
		<?php echo $form->textField($model,'cd_flag',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'cd_flag'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->