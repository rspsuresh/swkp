<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'fp_part_id'); ?>
		<?php echo $form->textField($model,'fp_part_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_file_id'); ?>
		<?php echo $form->textField($model,'fp_file_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_filepath'); ?>
		<?php echo $form->textField($model,'fp_filepath',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_category'); ?>
		<?php echo $form->textField($model,'fp_category',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_cat_id'); ?>
		<?php echo $form->textField($model,'fp_cat_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_page_nums'); ?>
		<?php echo $form->textArea($model,'fp_page_nums',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_status'); ?>
		<?php echo $form->textField($model,'fp_status',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_created_date'); ?>
		<?php echo $form->textField($model,'fp_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_last_modified'); ?>
		<?php echo $form->textField($model,'fp_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fp_flag'); ?>
		<?php echo $form->textField($model,'fp_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->