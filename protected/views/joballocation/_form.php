<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
?>
<?php echo Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'job-allocation-form',
	'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'action' => Yii::app()->createUrl("joballocation/create"),
    'clientOptions' => array(
		'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
    )
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<div class="uk-form-row">
	<?php echo $form->hiddenField($model,'ja_file_id',array('class'=>'md-input','value'=>$fl_model->fi_file_id)); ?>
	<?php echo $form->hiddenField($model,'ja_status',array('class'=>'md-input','value'=>$_POST['status'])); ?>
	<?php echo CHtml::hiddenField('mode',$_POST['mode'],array('class'=>'md-input')); ?>
	<?php echo $form->hiddenField($model,'ja_partition_id',array('class'=>'md-input','value'=>(isset($pt_model->fp_part_id))?$pt_model->fp_part_id:"")); ?>
		<div class="uk-grid">
			<div class="uk-width-medium-1-1">
				<div class="md-input-wrapper md-input-filled">
						<label>File Name</label>
						<?php echo CHtml::textField('filename',$fl_model->fi_file_name,array('class'=>'md-input', 'disabled'=>true)); ?>
					<span class="md-input-bar"></span>
				</div>
			</div>
		</div>	
		
		<div class="uk-grid">
			<div class="uk-width-medium-1-1">
				<div class="md-input-wrapper md-input-filled">
					<?php echo CHtml::dropDownList('alloc_to', '', array('' => 'Select Type','3' => 'Quality Control', '4' => 'Reviewer')); ?>
					<span class="md-input-bar"></span>
				</div>
			</div>
		</div>	
		
		<div class="uk-grid">
			<div class="uk-width-medium-1-1">
				<div class="md-input-wrapper md-input-filled">
					<?php echo $form->dropDownList($model,'user_id', array(), array('empty' => 'Select User')); ?> 
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
	$("select[name='alloc_to'").chosen();
	$("select[name='JobAllocation[user_id]'").chosen();
	
	$("select[name='alloc_to'").on('change', function(){
		ustyp = $(this).val();
		$.ajax({
                url: '<?php echo Yii::app()->createUrl("fileinfo/dependency"); ?>',
                type: "POST",
                data: { ustyp : ustyp },
                success: function (result) {
					$("select[name='JobAllocation[user_id]'").html(result);
					$("select[name='JobAllocation[user_id]'").trigger("chosen:updated");
				}
		});
	});
});

<?php if($model->isNewRecord){ ?>
   url = '<?php echo Yii::app()->createUrl("joballocation/create"); ?>';
<?php } else { ?>
   url = '<?php echo Yii::app()->createUrl('joballocation/update?id=' . $model->ja_job_id); ?>';
<?php } ?>
function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: url,
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