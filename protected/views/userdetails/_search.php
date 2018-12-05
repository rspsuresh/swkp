<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ud_refid'); ?>
		<?php echo $form->textField($model,'ud_refid',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_empid'); ?>
		<?php echo $form->textField($model,'ud_empid',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_username'); ?>
		<?php echo $form->textField($model,'ud_username',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_name'); ?>
		<?php echo $form->textField($model,'ud_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_gender'); ?>
		<?php echo $form->textField($model,'ud_gender',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_dob'); ?>
		<?php echo $form->textField($model,'ud_dob'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_marital_status'); ?>
		<?php echo $form->textField($model,'ud_marital_status',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_email'); ?>
		<?php echo $form->textField($model,'ud_email',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_temp_address'); ?>
		<?php echo $form->textArea($model,'ud_temp_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_permanent_address'); ?>
		<?php echo $form->textArea($model,'ud_permanent_address',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_mobile'); ?>
		<?php echo $form->textField($model,'ud_mobile',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_picture'); ?>
		<?php echo $form->textField($model,'ud_picture',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_emergency_contatct_details'); ?>
		<?php echo $form->textArea($model,'ud_emergency_contatct_details',array('rows'=>6, 'cols'=>50)); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'ud_cat_id'); ?>
		<?php echo $form->textField($model,'ud_cat_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_status'); ?>
		<?php echo $form->textField($model,'ud_status',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_created_date'); ?>
		<?php echo $form->textField($model,'ud_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_last_modified'); ?>
		<?php echo $form->textField($model,'ud_last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ud_flag'); ?>
		<?php echo $form->textField($model,'ud_flag',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->