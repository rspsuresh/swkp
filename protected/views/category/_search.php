<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ct_cat_id'); ?>
		<?php echo $form->textField($model,'ct_cat_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ct_cat_name'); ?>
		<?php echo $form->textField($model,'ct_cat_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ct_keywords'); ?>
		<?php echo $form->textArea($model,'ct_keywords',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ct_cat_type'); ?>
		<?php echo $form->textField($model,'ct_cat_type',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ct_created_date'); ?>
		<?php echo $form->textField($model,'ct_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ct_last_modified'); ?>
		<?php echo $form->textField($model,'ct_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ct_flag'); ?>
		<?php echo $form->textField($model,'ct_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->