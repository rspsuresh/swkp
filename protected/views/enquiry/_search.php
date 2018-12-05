<?php
/* @var $this EnquiryController */
/* @var $model Enquiry */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'eq_id'); ?>
		<?php echo $form->textField($model,'eq_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eq_description'); ?>
		<?php echo $form->textField($model,'eq_description',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eq_mail'); ?>
		<?php echo $form->textField($model,'eq_mail',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eq_created_dt'); ?>
		<?php echo $form->textField($model,'eq_created_dt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eq_last_modified'); ?>
		<?php echo $form->textField($model,'eq_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'eq_flag'); ?>
		<?php echo $form->textField($model,'eq_flag',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->