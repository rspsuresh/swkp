<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/pages/forms_advanced.js"></script>
<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
?>

<?php
$hhh = json_decode($pjson, true);
$ecd9Arr = array();
$ecd10Arr = array();
$dxArr = array();
$bodyArr = array();
$proArr = array();
$facArr = array();
if (!empty($hhh)) {
    $ecd9Arr = $hhh["E"];
    $ecd10Arr = $hhh["N"];
    $dxArr = $hhh["DX"];
    $bodyArr = $hhh["B"];
    $proArr = $hhh["P"];
    $facArr = $hhh["F"];
}
if (count($ecd9Arr) > 0) {
    $ecd9Arr = array_combine($ecd9Arr, $ecd9Arr);
}
if (count($ecd10Arr) > 0) {
    $ecd10Arr = array_combine($ecd10Arr, $ecd10Arr);
}
if (count($dxArr) > 0) {
    $dxArr = array_combine($dxArr, $dxArr);
}
if (count($bodyArr) > 0) {
    $bodyArr = array_combine($bodyArr, $bodyArr);
}
if (count($proArr) > 0) {
    $proArr = array_combine($proArr, $proArr);
}
if (count($facArr) > 0) {
    $facArr = array_combine($facArr, $facArr);
}
if (count($dxArr) > 0) {
    $dxArr = array_combine($dxArr, $dxArr);
}
?>

<?php
	$check_skip_edt = Project::model()->findByPk($fileInfo->fi_pjt_id);
	$template_name = $check_skip_edt->template->t_name;
	$dateform_arr = !empty($check_skip_edt->date_format)?array_keys(json_decode($check_skip_edt->date_format,true))[0]:"d/m/Y";
	$dateformat = array('m/d/Y' => 'mm/dd/yyyy', 'd/m/Y' => 'dd/mm/yyyy');
    //$format = $dateformat[$check_skip_edt->date_format];
    $format = $dateformat[$dateform_arr];
?>
<?php echo Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<?php $cat_id = $fileInfo->ProjectMaster->p_category_ids;
      $noncat_id = $fileInfo->ProjectMaster->non_cat_ids;
?>
	<?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'page-move-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'afterValidate' => 'js:function(form, data, hasError) { saveMedMoveForm(form, data, hasError); }',
            ),
      
	  ));
    ?>
	<?php if(empty($legArray)){ ?>
		<div class="uk-grid" data-uk-grid-margin="">
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'patient_name'); ?>
				<?php
				echo $form->textField($model, 'patient_name', array('class' => "md-input label-fixed",
				'onfocus' => 'elementFocus()'));
				?>
				<?php echo $form->error($model, 'patient_name'); ?>
			</div>
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'dob'); ?>
				<?php
					echo $form->textField($model, 'dob', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
					'onfocus' => 'elementFocus()'));
				?>
				<?php echo $form->error($model, 'dob'); ?>
			</div>
		</div>	
		<div class="uk-grid" data-uk-grid-margin="">
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'gender'); ?>
				<?php
					echo $form->radioButtonList($model, 'gender', array('M' => 'Male',
						'F' => 'Female',
					), array(
						'labelOptions' => array('style' => 'display:inline'), // add this code
						'separator' => '  ',
						'data-md-icheck' => "",
						'onfocus' => 'elementFocus()'
					));
				?>
				<?php echo $form->error($model, 'gender'); ?>
			</div>
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'doi'); ?>
				<?php
					echo $form->textField($model, 'doi', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
					'onfocus' => 'elementFocus()'));
				?>
				<?php echo $form->error($model, 'doi'); ?>
			</div>
		</div>
	<?php } ?>
	<div class="uk-grid" data-uk-grid-margin="">
		<div class="uk-width-medium-1-1 ">
			<?php //echo $form->labelEx($model, 'pages'); ?>
            <?php	echo $form->textField($model, 'pages', array('class' => "md-input label-fixed DateCoding_pages", 'readonly' => true, 'onfocus' => 'elementFocus()','value' => $pages)); ?>
            <?php //echo CHtml::hiddenField('skips', '', array('id'=> 'skips', 'class' => "md-input label-fixed", 'readonly' => true));   ?>
            <?php echo $form->hiddenField($model, 'file', array('value' => $fileInfo->fi_file_id)); ?>
			<?php echo $form->hiddenField($model, 'project', array('class' => "md-input", 'value' => $fileInfo->fi_pjt_id)); ?>
            <?php //echo $form->error($model, 'pages');   ?>
		</div>
	</div>
	<div class="uk-grid" data-uk-grid-margin="">
        <div class="uk-width-medium-1-3 ">	
			<?php echo $form->labelEx($model, 'dos'); ?>
            <?php echo $form->textField($model, 'dos', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false, 'onfocus' => 'elementFocus()')); ?>
            <?php echo $form->error($model, 'dos'); ?>
		</div>
		<div class="uk-width-medium-1-3 ">	
            <?php echo $form->textField($model, 'todos', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false, 'onfocus' => 'elementFocus()')); ?>
            <?php echo $form->error($model, 'todos'); ?>
		</div>
		<div class="uk-width-medium-1-3 ">	
			<label>Undated</label> 
            <?php
				echo $form->checkBox($model, 'undated', array('class' => "undated"));
            ?>
		</div>
	</div>	
	<div class="uk-grid" data-uk-grid-margin="">
		<div class="uk-width-medium-1-1 ">
			<?php echo $form->labelEx($model, 'provider_name'); ?>
			<?php
				//echo $form->textArea($model, 'provider_name', array('class' => "md-input label-fixed", 'onfocus' => 'elementFocus()'));
				echo $form->dropDownList($model, 'provider_name', $proArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_provider_name'));
			?>
            <?php echo $form->hiddenField($model, 'record_row', array('class' => "md-input")); ?>
            <?php echo $form->error($model, 'provider_name'); ?>
		</div>
	</div>		
	<div class="uk-grid" data-uk-grid-margin="">
		<div class="uk-width-medium-1-1 ">				
			<?php echo $form->labelEx($model, 'category'); ?>
            <?php
				echo $form->dropDownList($model, 'category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and (ct_cat_id IN($cat_id) or ct_cat_name ='Duplicate' or ct_cat_name ='Others')")), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category', 'onfocus' => 'elementFocus()','class' => "DateCoding_category"));
            ?>
            <?php echo $form->error($model, 'category'); ?>
			<?php echo $form->hiddenField($model, 'type', array('class' => "md-input", 'value' => "M")); ?>					
		</div>
	</div>
	<div class="uk-grid" data-uk-grid-margin="">
		<?php
			$mediumclass = $check_skip_edt->skip_edit != 1 ? 'uk-width-medium-1-2' : 'uk-width-medium-2-2';
        ?>
		<div class="<?php echo $mediumclass; ?>">
			<?php echo $form->labelEx($model, 'facility'); ?>
            <?php
				//echo $form->textField($model, 'facility', array('class' => "md-input label-fixed", 'onfocus' => 'elementFocus()'));
				echo $form->dropDownList($model, 'facility', $facArr, array('onfocus' => 'elementFocus()', 'empty' => 'Select Facility', 'class' => 'DateCoding_facility'));
			?>
            <?php echo $form->error($model, 'facility'); ?>
		</div>
		<?php if ($check_skip_edt->skip_edit != 1) { ?>	
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'title'); ?>
				<?php
					echo $form->textField($model, 'title', array('class' => "md-input label-fixed",'onfocus' => 'elementFocus()'));
				?>
				<?php echo $form->error($model, 'title'); ?>
			</div>
		<?php } ?>
	</div>
	<?php if($check_skip_edt->skip_edit == 1){ ?>
		<div class="uk-grid" data-uk-grid-margin="">
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'body_parts'); ?>
				<?php
					//echo $form->textArea($model, 'body_parts', array('class' => "md-input label-fixed",
					//'onfocus' => 'elementFocus()'));
					echo $form->dropDownList($model, 'body_parts', $bodyArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_body_parts'));
				?>
				<?php echo $form->error($model, 'body_parts'); ?>
			</div>
			<div class="uk-width-medium-1-2 ">
				<?php echo $form->labelEx($model, 'ecd_9_diagnoses'); ?>
				<?php
				//	echo $form->textArea($model, 'ecd_9_diagnoses', array('class' => "md-input label-fixed",
				//'onfocus' => 'elementFocus()'));
				echo $form->dropDownList($model, 'ecd_9_diagnoses', $ecd9Arr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_ecd_9_diagnoses'));
				?>
				<?php echo $form->error($model, 'ecd_9_diagnoses'); ?>
			</div>
		</div>	
		<div class="uk-grid" data-uk-grid-margin="">	
				<div class="uk-width-medium-1-2 ">
					<?php echo $form->labelEx($model, 'ecd_10_diagnoses'); ?>
					<?php
					//	echo $form->textArea($model, 'ecd_10_diagnoses', array('class' => "md-input label-fixed",
					//'onfocus' => 'elementFocus()'));
					echo $form->dropDownList($model, 'ecd_10_diagnoses', $ecd10Arr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_ecd_10_diagnoses'));
					?>
					<?php echo $form->error($model, 'ecd_10_diagnoses'); ?>
				</div>	
				<div class="uk-width-medium-1-2 ">	
					<?php echo $form->labelEx($model, 'dx_terms'); ?>
						<?php
							//echo $form->textArea($model, 'dx_terms', array('class' => "md-input label-fixed",
							//	'onfocus' => 'elementFocus()','data-name' => 'dx_terms'));
							echo $form->dropDownList($model, 'dx_terms', $dxArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_dx_terms'));
                        ?>
                    <?php echo $form->error($model, 'dx_terms'); ?>
				</div>
		</div>
		<?php if($template_name == "BACTESPDF"){ ?>
			<div class="uk-grid" data-uk-grid-margin="">
				<div class="uk-width-medium-1-2 ">
					<?php echo $form->labelEx($model, 'ms_terms'); ?>
					<?php
						echo $form->textField($model, 'ms_terms', array('class' => "md-input label-fixed", 'onfocus' => 'elementFocus()', 'data-name' => 'ms_terms'));
					?>
					<?php echo $form->error($model, 'ms_terms'); ?>
				</div>
				<div class="uk-width-medium-1-2 ">
					<?php echo $form->labelEx($model, 'ms_value'); ?>
					<?php
						echo $form->textField($model, 'ms_value', array('class' => "md-input label-fixed", 'onfocus' => 'elementFocus()', 'data-name' => 'ms_value'));
					?>
					<?php echo $form->error($model, 'ms_value'); ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<?php if(isset($legArray) && !empty($legArray)){ ?>
				<?php echo $form->hiddenField($model, 'patient_name', array('class' => "md-input", 'value' => $legArray[0])); ?>
				<?php echo $form->hiddenField($model, 'gender', array('class' => "md-input", 'value' => $legArray[1])); ?>
				<?php echo $form->hiddenField($model, 'doi', array('class' => "md-input", 'value' => $legArray[2])); ?>
				<?php echo $form->hiddenField($model, 'dob', array('class' => "md-input", 'value' => $legArray[3])); ?>
	<?php } ?>
	<div class="uk-grid" data-uk-grid-margin="">
		<div class="uk-width-medium-1-1 ">				
			<?php echo CHtml::submitButton('Create', array('class' => "md-btn md-btn-success splitbtn createbtn")); ?>
		</div>
	</div>	
	<?php $this->endWidget(); ?>
	

<script>
	$(function () {
        $("#page-move-form select[name='DateCoding[category]'").chosen();
        $('#page-move-form #DateCoding_provider_name').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
        $('#page-move-form #DateCoding_facility').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
		$('#page-move-form #DateCoding_body_parts').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
		$('#page-move-form #DateCoding_ecd_9_diagnoses').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
		$('#page-move-form #DateCoding_ecd_10_diagnoses').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
		$('#page-move-form #DateCoding_dx_terms').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
		$('.undated').on('click',function(){
            //var hideDiv = $(this).parent().prev();
            var hideDiv = $(this).parent().prevAll(':lt(2)');
           if($(this).prop('checked')){
                $('#page-move-form #DateCoding_dos').val("");
				$('#page-move-form #DateCoding_todos').val("");
               hideDiv.hide('1000');
           }
           else{
               hideDiv.show('1000');
           }
		});
    });
    function saveMedMoveForm(form, data, hasError) {
		if($('#page-move-form #DateCoding_dos').val() == "" && !($('.undated').prop('checked'))){
            $('#page-move-form #DateCoding_dos').parent().next('.errorMessage').html("Either Dos/Undated is required!").show();
            return false;
        }
        if (!hasError) {
            var formdata = new FormData($('#page-move-form')[0]);
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/movemedical', array('file_id' => $_REQUEST['file_id'], 'pages' => $pages)) ?>',
                type: "post",
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 2000,
                            pos: 'top-right'
                        });
						clearTimeout(timer);
                        myFuncCalls = 0;
                        autoSave('D');
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        }
    }
    $(function () {
        altair_md.init();
        altair_forms.init();
    })
</script>
