<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
?>
<?php echo Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'job-allocation-form',
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
			'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
		)
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="uk-form-row">
		<div class="uk-grid">
			<?php echo $form->hiddenField($model, 'ja_status', array('class' => 'md-input')); ?>
			<div class="uk-width-medium-1-1">
				<div class="md-input-wrapper md-input-filled">
					<?php echo $form->dropDownList($model,'user_id', $dropdown, array('empty' => 'Select User')); ?> 
					<span class="md-input-bar"></span>
					<?php echo $form->error($model,'user_id'); ?>
				</div>
			</div>
		</div>	
		<div class="uk-grid">
			<div class="uk-width-medium-1-1">	
				<?php echo CHtml::submitButton('Allocate',array('class' => 'md-btn md-btn-success')); ?>
			</div>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(document).ready(function(){
	$("select[name='JobAllocation[user_id]'").chosen();

});


function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("joballocation/reallocate",array('id'=>$model->ja_job_id)); ?>',
                type: "POST",
                data: $("#job-allocation-form").serialize(),
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                    }  
                }
            });
        }
} 
</script>