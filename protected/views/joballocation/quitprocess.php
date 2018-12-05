<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */

$option = '';
$description = '';
$status = '';
$emptyData = array();
$dropdown = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id = 4")), 'ud_refid', 'ud_username');
$jobAllocation = JobAllocation::model()->findByPk($id);
if ($jobAllocation) {
    $reason = isset($jobAllocation->ja_reason) ? json_decode($jobAllocation->ja_reason) : '';
    $status = $jobAllocation->ja_status;
    if ($reason) {
        $option = $reason->option;
        $description = $reason->description;
    }
}
switch ($status) {
    case "IA":
        $processes = array("N" => "New");
        break;
    case "IC":
        $processes = array("N" => "New", "IA" => "Init Prepping", "IC" => "Complete Prepping/Skip QA");
        break;
    case "SA":
        $processes = array("N" => "New", "IA" => "Init Prepping", 'RPQ' => 'Reallocate Prepping QA');
        break;
    case "QC":
        $jobmodel = JobAllocation::model()->findByPk($model->ja_job_id);
        $minId = Yii::app()->db->createCommand("SELECT min(ja_job_id) as minid FROM  job_allocation_ja where ja_flag = 'A' and ja_file_id =" . $jobmodel->ja_file_id)->queryScalar();
        $minJobStatus = JobAllocation::model()->findByPk($minId);
        if ($minJobStatus->ja_status == "QC") {
            $processes = array("N" => "New", "IA" => "Init Prepping", 'RPQ' => 'Reallocate Prepping QA', "SA" => "Init Splitting", 'RSQ' => 'Reallocate Splitting QA');
        } else {
            $processes = array("N" => "New", "IA" => "Init Prepping", "IC" => "Complete Prepping/Skip QA");
        }

        break;
    case "SC":
        $processes = array("N" => "New", "IA" => "Init Prepping", 'RPQ' => 'Reallocate Prepping QA', "SA" => "Init Split", "SQC" => "Complete Splitting/Skip QA");
        break;
    case "IQ":
        $processes = array("N" => "New", "IA" => "Init Prepping");
        break;
    case "SQ":
        $processes = array("N" => "New", "IA" => "Init Prepping", 'RPQ' => 'Reallocate Prepping QA', "SA" => "Init Split");
        break;
    case "SQP":
        $processes = array("N" => "New", "IA" => "Init Prepping", 'RPQ' => 'Reallocate Prepping QA', "SA" => "Init Split", "SQC" => "Complete Splitting/Skip QA");
        break;
    default :
        $processes = array("N" => "New", "IA" => "Init Prepping", 'RPQ' => 'Reallocate Prepping QA', "SA" => "Init Split", "SQC" => "Complete Splitting/Skip QA");
        break;

}

/**
 * options1
 */
$option1 = "<option value=''>Select Reallocate</option>";
if ($dropdown) {
    foreach ($dropdown as $index => $value) {
        $option1 .= "<option value='$index'>$value</option>";
    }
}
/**
 * options2
 */
$option2 = "<option value=''>Select Backward</option>";
if ($processes) {
    foreach ($processes as $index => $value) {
        $option2 .= "<option value='$index'>$value</option>";
    }
}
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-quit-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError);}',
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <div class="uk-accordion" data-uk-accordion>
                <h3 class="uk-accordion-title uk-accordion-title-success"><?php echo $option=="B"?'Backward':'Reallocate' ?></h3>
                <div class="uk-accordion-content">
                    <p><?php echo $description; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php
            echo $form->radioButtonList($model, 'quit_process', array('B' => 'Backward',
                'R' => 'Reallocate',
            ), array(
                'labelOptions' => array('style' => 'display:inline'), // add this code
                'separator' => '  ', 'class' => 'data-md-icheck',
            ));
            ?>
            <?php echo $form->error($model, 'quit_process'); ?>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php echo $form->dropDownList($model, 'option', $emptyData, array("prompt" => "Select Option")); ?>
            <?php //echo $form->hiddenField($model, 'quit_process', array('class' => 'md-input', 'value' => $option)); ?>
            <?php echo $form->error($model, 'option'); ?>
        </div>
    </div>
	<div class="uk-grid checkboxes" style="display:none;">
        <div class="uk-width-medium-1-1">
            <div class="md-input-wrapper md-input-filled">
                <?php echo CHtml::checkBox('withdata',true,array('value' => '1', 'uncheckValue'=>'0')); ?>&nbsp;<span>With Data</span>
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'uk-button uk-button-success uk-float-right')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    var backward = "<?php echo $option2;?>";
    var reallocate = "<?php echo $option1;?>";
    $(document).ready(function () {
        var accordion = UIkit.accordion('.uk-accordion', {collapse: false});
        $("#JobAllocation_option").chosen();
        altair_md.init();
        altair_forms.init();
		
		$('#JobAllocation_option').on('change', function(){
			process = $(this).val();
			if(process === 'IA' || process === 'SA'){
				$('.checkboxes').show('200');
			}
			else{
				$('.checkboxes').hide('200');
			}
		});
    });
    function saveForm(form, data, hasError) {
        if (!hasError) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('joballocation/quitprocess', array('id' => $id)); ?>',
                type: "POST",
                data: $("#job-quit-form").serialize(),
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
    /**
     * Radio Option Changes
     */
    $('input[name="JobAllocation[quit_process]"]').on('ifChecked', function (event) {
        var val = $(this).val();
        if (val == 'R') {
            $('#JobAllocation_option').html(reallocate);
        } else {
            $('#JobAllocation_option').html(backward);

        }
        $("#JobAllocation_option").trigger('chosen:updated');
    });
</script>