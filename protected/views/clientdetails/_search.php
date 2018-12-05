<?php
/* @var $this ClientDetailsController */
/* @var $model ClientDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'cd_id'); ?>
		<?php echo $form->textField($model,'cd_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_downloadtype'); ?>
		<?php echo $form->textField($model,'cd_downloadtype',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_projectid'); ?>
		<?php echo $form->textField($model,'cd_projectid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_url'); ?>
		<?php echo $form->textField($model,'cd_url',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_username'); ?>
		<?php echo $form->textField($model,'cd_username',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_port'); ?>
		<?php echo $form->textField($model,'cd_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_folderpath'); ?>
		<?php echo $form->textField($model,'cd_folderpath',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_created_date'); ?>
		<?php echo $form->textField($model,'cd_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_last_modified_date'); ?>
		<?php echo $form->textField($model,'cd_last_modified_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cd_flag'); ?>
		<?php echo $form->textField($model,'cd_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->