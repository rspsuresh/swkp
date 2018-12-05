<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'fi_file_id'); ?>
		<?php echo $form->textField($model,'fi_file_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_pjt_id'); ?>
		<?php echo $form->textField($model,'fi_pjt_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_file_name'); ?>
		<?php echo $form->textField($model,'fi_file_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_file_ori_location'); ?>
		<?php echo $form->textField($model,'fi_file_ori_location',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_file_completed_location'); ?>
		<?php echo $form->textField($model,'fi_file_completed_location',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_file_uploaded_date'); ?>
		<?php echo $form->textField($model,'fi_file_uploaded_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_file_completed_time'); ?>
		<?php echo $form->textField($model,'fi_file_completed_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_status'); ?>
		<?php echo $form->textField($model,'fi_status',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_created_date'); ?>
		<?php echo $form->textField($model,'fi_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_last_modified'); ?>
		<?php echo $form->textField($model,'fi_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fi_flag'); ?>
		<?php echo $form->textField($model,'fi_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->