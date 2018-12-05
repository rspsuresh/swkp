<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
$stat = $model->ja_status;
switch ($model->ja_status){
    case "IA":
        $processes = array("N" => "New");
        break;
    case "IC":
        $processes = array("N" => "New","IA" => "Init Prepping","IC" => "Complete Prepping/Skip QA");
        break;
    case "SA":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA');
        break;
    case "QC":
        $jobmodel = JobAllocation::model()->findByPk($model->ja_job_id);
		if($jobmodel->ja_status == 'QC' && $jobmodel->ja_partition_id <> 0){
			$processes = array("N" => "New","IA" => "Init Prepping",'RPQ' =>'Reallocate Prepping QA',"SA" => "Init Datecoding",'RSQ' =>'Reallocate Datecoding QA');
		}
		else if($jobmodel->ja_status == 'QC' && $jobmodel->ja_partition_id = 0){
			$processes = array("N" => "New","IA" => "Init Prepping","IC" => "Complete Prepping/Skip QA");
		}
       /* $minId = Yii::app()->db->createCommand("SELECT min(ja_job_id) as minid FROM  job_allocation_ja where ja_flag = 'A' and ja_file_id =".$jobmodel->ja_file_id)->queryScalar();
        $minJobStatus = JobAllocation::model()->findByPk($minId);
        if($minJobStatus->ja_status == "QC"){
            $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' =>'Reallocate Prepping QA',"SA" => "Init Splitting",'RSQ' =>'Reallocate Splitting QA');
        }
        else{
            $processes = array("N" => "New","IA" => "Init Prepping","IC" => "Complete Prepping/Skip QA");
        } */
        
        break;
    case "SC":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding","SQC" => "Complete Datecoding/Skip QA");
        break;
    case "IQ":
        $processes = array("N" => "New","IA" => "Init Prepping");
        break;
    case "SQ":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding");
        break;
    case "IQP":
        $processes = array("N" => "New","IA" => "Init Prepping","IC" => "Complete Prepping/Skip QA");
        break;
    case "SQP":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding","SQC" => "Complete Datecoding/Skip QA");
        break;
    case "EA":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' =>'Reallocate Prepping QA',"SA" => "Init Datecoding",'RSQ' =>'Reallocate Datecoding QA');
        break;
	case "EC":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding",'RSQ' =>'Reallocate Datecoding QA',"IE" => "Init Edit","QEC" => "Complete Editing/Skip QA");
        break;
    case "QEA":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding",'RSQ' =>'Reallocate Datecoding QA',"IE" => "Init Edit","QEC" => "Complete Editing/Skip QA");
        break;
	case "QEC":
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding",'RSQ' =>'Reallocate Datecoding QA',"IE" => "Init Edit","EC" => "Reallocate Editing QA");
        break;	
    default :
        $processes = array("N" => "New","IA" => "Init Prepping",'RPQ' => 'Reallocate Prepping QA',"SA" => "Init Datecoding","SQC" => "Complete Datecoding/Skip QA");
        break;
    
}

$filemodel = FileInfo::model()->findByPk($model->ja_file_id);
	if($filemodel->fi_prep == 1){
		unset($processes["IA"], $processes["IC"], $processes["RPQ"]);
	}
//$processes = array(
//    
//    "IA" => "Init Prepping",
//    "IC" => "Complete Prepping/Skip QA",
//    "SA" => "Init Splitting",
////    "IQ" => "Prepping Quitted",
////    "SQ" => "Splitting Quitted",
//    "SC" => "Complete Splitting/Skip QA",
////    "IQP" => "Prepping QC Progress",
////    "SQP" => "Splitting QC Progress",
////    "PQC" => "Prepping Completed",
////    "SQC" => "Split Completed",
//);
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-process-change-form',
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
    $model->ja_status = "";
    ?>

    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <div class="md-input-wrapper md-input-filled">
                <?php echo $form->dropDownList($model, 'ja_status', $processes, array("prompt" => "Select Process", "data-md-selectize" => true, 'data-md-selectize-bottom' => true)); ?>
                <?php echo $form->error($model, 'ja_status'); ?>
            </div>
        </div>
    </div>
	<div class="uk-grid checkboxes" style="display:none;">
        <div class="uk-width-medium-1-3">
            <div class="md-input-wrapper md-input-filled">
                <?php echo CHtml::checkBox('withdata',true,array('value' => '1', 'uncheckValue'=>'0')); ?>&nbsp;<span>With Data</span>
            </div>
        </div>
		<div class="uk-width-medium-1-3">
            <div class="md-input-wrapper md-input-filled rellocpan">
                <?php echo $form->checkBox($model,'revchk',array('value'=>1,'uncheckValue'=>0,'checked'=>false)); ?>&nbsp;<span>Reallocate</span>
            </div>
        </div>
		<div class="uk-width-medium-1-3">
		</div>
    </div>
	<div class="uk-grid revdrop" style="display:none;">
        <div class="uk-width-medium-1-1">
            <div class="md-input-wrapper md-input-filled">
			<?php echo $form->dropDownList($model, 'review', 
					CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name'),
					array('class' => 'md-input', 'empty' => 'Select Reviewer')); ?>
			<?php echo $form->error($model, 'review'); ?> 
            </div>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'uk-button uk-button-success uk-float-right')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<script>
    $(document).ready(function () {
        altair_md.init();
        altair_forms.init();
		jastatus = '<?php echo $stat; ?>';
		$("#JobAllocation_review").chosen();
		
		$('#JobAllocation_revchk').on('change', function(){
			if ($(this).is(':checked')) {
				$('.revdrop').show('200');
			}
			else{
				$('.revdrop').hide('200');
				$("#JobAllocation_review").val('').trigger("chosen:updated");
			}
		});
		
		$('#JobAllocation_ja_status').on('change', function(){
			process = $(this).val();
			if(process === 'IA' || process === 'SA' || process === 'IE'){
				$('.checkboxes').show('200');
				if(process === 'IE'){
					$('.rellocpan').css('display','none');
					$('.revdrop').hide('200');
					$('#JobAllocation_revchk').attr('checked', false); 
					$("#JobAllocation_review").val('').trigger("chosen:updated");
				}
				else{
					$('.rellocpan').css('display','block');
				}
			}
			else{
				$('.rellocpan').css('display','block');
				$('.checkboxes').hide('200');
				$('#JobAllocation_revchk').attr('checked', false); 
				$('.revdrop').hide('200');
				$("#JobAllocation_review").val('').trigger("chosen:updated");
			}
		});
    });
	
	function autoSaveIndex(mode){
		prepfileid = '<?php echo $model->ja_file_id; ?>';
			$.ajax({
				url: '<?php echo Yii::app()->createUrl('fileinfo/autosaveindex') ?>',
				type: "post",
				data: {prepfileid:prepfileid, mode:mode},
				success: function (result) {
				}
			});		
	}
	
	function autoSaveSplit(mode){
		prepfileid = '<?php echo $model->ja_file_id; ?>';
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('filepartition/deleterestore') ?>?delt_fileid=" + prepfileid,
                type: "post",
                data: {},
                success: function (result) {
				}
			});
	}
	
    function saveForm(form, data, hasError) {
		if($('#JobAllocation_revchk').is(':checked') && $("#JobAllocation_review").val() === ""){
			$('#JobAllocation_review_em_').html("Reviewer Should not be empty").show();
			return;
		}
        if (!hasError) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('joballocation/processswap/' . $model->ja_job_id); ?>',
                type: "POST",
                data: $("#job-process-change-form").serialize(),
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
						if(jastatus == 'IA'){
							autoSaveIndex('D');
						}
						else if(jastatus == 'SA' || jastatus == 'SQP' || jastatus == 'QC'){
							autoSaveSplit('D');
						}
                    }
                }
            });
        }
    }
</script>