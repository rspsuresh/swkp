<?php
/* @var $this UserTypeController */
/* @var $model UserType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ut_refid'); ?>
		<?php echo $form->textField($model,'ut_refid',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ut_usertype'); ?>
		<?php echo $form->textField($model,'ut_usertype',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ut_created_date'); ?>
		<?php echo $form->textField($model,'ut_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ut_last_modified_date'); ?>
		<?php echo $form->textField($model,'ut_last_modified_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ut_flag'); ?>
		<?php echo $form->textField($model,'ut_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->