<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'p_pjt_id'); ?>
		<?php echo $form->textField($model,'p_pjt_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_client_id'); ?>
		<?php echo $form->textField($model,'p_client_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_name'); ?>
		<?php echo $form->textField($model,'p_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_op_format'); ?>
		<?php echo $form->textField($model,'p_op_format',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_key_type'); ?>
		<?php echo $form->textField($model,'p_key_type',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_category_ids'); ?>
		<?php echo $form->textArea($model,'p_category_ids',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_created_date'); ?>
		<?php echo $form->textField($model,'p_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_last_modified'); ?>
		<?php echo $form->textField($model,'p_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'p_flag'); ?>
		<?php echo $form->textField($model,'p_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->