<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-details-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            'afterValidate' => 'js:function(form, data, hasError) { saveUserForm(form, data, hasError);}',
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo $form->labelEx($model, 'ud_name'); ?>
                <?php echo $form->textField($model, 'ud_name', array('size' => 60, 'maxlength' => 250, 'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_name'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-2-2">
                <?php echo $form->hiddenField($model, 'ud_usertype_id', array('value' => 5)); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo $form->labelEx($model, 'ud_username'); ?>
                <?php echo $form->textField($model, 'ud_username', array('size' => 60, 'maxlength' => 200, 'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_username'); ?>
            </div>
        </div>
		<div class="uk-grid">
			<?php if (!$model->isNewRecord) { ?>
				<div class="uk-width-medium-1-6">
					<?php echo CHtml::checkBox('editpass',false,array("onchange" => "editpwdChange($(this))")); ?>
				</div>
				<div class="uk-width-medium-5-6">
					<?php echo $form->labelEx($model, 'ud_password'); ?>
					<?php echo $form->passwordField($model, 'ud_password', array('size' => 60, 'maxlength' => 200, 'class' => 'md-input', 'readonly' => true)); ?>
					<?php echo $form->error($model, 'ud_password'); ?>
				</div>
			<?php } else { ?>
				<div class="uk-width-medium-1-1">
					<?php echo $form->labelEx($model, 'ud_password'); ?>
					<?php echo $form->passwordField($model, 'ud_password', array('size' => 60, 'maxlength' => 200, 'class' => 'md-input', 'readonly' => false)); ?>
					<?php echo $form->error($model, 'ud_password'); ?>
				</div>
			<?php } ?>	
		</div>	
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_gender', array("style" => "padding-right: 20px;")); ?>
                <?php
                echo $form->radioButtonList($model, 'ud_gender', array('M' => 'Male',
                    'F' => 'Female',
                ), array(
                    'labelOptions' => array('style' => 'display:inline'), // add this code
                    'separator' => '  ', 'class' => 'data-md-icheck'
                ));
                ?>
                <?php echo $form->error($model, 'ud_gender'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <label for="radio_demo_inline_1" class="inline-label">Single</label>
                <?php echo $form->checkbox($model, 'ud_marital_status', array("value" => "M", "uncheckValue" => "UM", "data-switchery" => "")); ?>
                <label for="radio_demo_inline_1" class="inline-label">Married</label>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_dob'); ?>
                <?php echo $form->textField($model, 'ud_dob', array('class' => 'md-input', "data-uk-datepicker" => "{format:'DD-MM-YYYY'}")); ?>
                <?php echo $form->error($model, 'ud_dob'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_mobile'); ?>
                <?php echo $form->textField($model, 'ud_mobile', array('size' => 10, 'maxlength' => 10, 'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_mobile'); ?>
            </div>
        </div>
        <?php
        if(!$model->isNewRecord){ ?>
            <div class="uk-grid">
                <div class="uk-width-medium-1-2">
                    <?php echo $form->labelEx($model, 'ud_ipin'); ?>
                    <?php echo $form->textField($model, 'ud_ipin', array('size' => 30, 'maxlength' =>4, 'class' => 'md-input')); ?>
                    <?php echo $form->error($model, 'ud_ipin'); ?>
                </div>
            </div>
       <?php }?>

        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_email'); ?>
                <?php echo $form->textField($model, 'ud_email', array('size' => 60, 'maxlength' => 150, 'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_email'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_emergency_contatct_details'); ?>
                <?php echo $form->textField($model, 'ud_emergency_contatct_details', array('size' => 10, 'maxlength' => 10,'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_emergency_contatct_details'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_temp_address'); ?>
                <?php echo $form->textArea($model, 'ud_temp_address', array('rows' => 6, 'cols' => 50, 'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_temp_address'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_permanent_address'); ?>
                <?php echo $form->textArea($model, 'ud_permanent_address', array('rows' => 6, 'cols' => 50, 'class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_permanent_address'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'uk-button uk-button-success')); ?>
            </div>
        </div>
        <?php /*  <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ud_picture'); ?>
                <?php echo $form->fileField($model, 'ud_picture', array('class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ud_picture'); ?>
                </div>
            </div>*/ ?><?php /*
        <div class="uk-margin-top">
            <h3 class="full_width_in_card heading_c">
                FTP details
            </h3>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-2 uk-row-first">
                    <?php echo $form->labelEx($client, 'cd_downloadtype'); ?>
                    <?php echo $form->dropDownList($client, 'cd_downloadtype', array("F" => "FTP", "S" => "SFTP", "A" => "Files anywhere"), array('empty' => 'Select Account Type')); ?>
                    <?php echo $form->error($client, 'cd_downloadtype'); ?>
                </div>
                <div class="uk-width-medium-1-2 uk-row-first">
                    <?php echo $form->labelEx($client, 'cd_projectid'); ?>
                    <?php // echo $form->dropDownList($model->ClientDetails,'cd_projectid', CHtml::listData(Project::model()->findAll(array("condition"=>"p_client_id = ".Yii::app()->session['user_id'])), 'p_pjt_id', 'p_name'), array('class' => 'data-md-selectize', 'empty' => 'Select project'));
                    ?>
                    <?php echo $form->dropDownList($client, 'cd_projectid', array("1" => "KPO", "2" => "Project1", "3" => "Project2"), array('empty' => 'Select Project')); ?>
                    <?php echo $form->error($client, 'cd_projectid'); ?>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-1-2 uk-row-first">
                    <?php echo $form->labelEx($client, 'cd_url'); ?>
                    <?php echo $form->textField($client, 'cd_url', array("class" => "md-input")); ?>
                    <?php echo $form->error($client, 'cd_url'); ?>
                </div>
                <div class="uk-width-medium-1-2">
                    <?php echo $form->labelEx($client, 'cd_port'); ?>
                    <?php echo $form->textField($client, 'cd_port', array("class" => "md-input")); ?>
                    <?php echo $form->error($client, 'cd_port'); ?>
                </div>
            </div>
        </div>
    </div>*/ ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
	var oldpwd = "";
    $(document).ready(function () {
        $("select[name='UserDetails[ud_usertype_id]'").chosen();
        $("select[name='UserDetails[ud_cat_id]'").chosen();
        //$("select[name='ClientDetails[cd_downloadtype]'").chosen();
        //$("select[name='ClientDetails[cd_projectid]'").chosen();
        altair_md.init();
        altair_forms.init();
		oldpwd = $('#UserDetails_ud_password').val();
    });
    <?php if($model->isNewRecord){ ?>
    url = '<?php echo Yii::app()->createUrl('userdetails/createclient') ?>';
    <?php } else { ?>
    url = '<?php echo Yii::app()->createUrl('userdetails/update', array('id' => $_GET['id'])) ?>';
    <?php } ?>
    function saveUserForm(form, data, hasError) {
        if (!hasError) {
                var formdata = new FormData($('#user-details-form')[0]);
                $.ajax({
                    url: url,
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
                                timeout: 10000,
                                pos: 'top-right'
                            });
                        }
                    }
                });
        } else {
            $(".error").find('input[type=text],input[type=radio],input[type=checkbox],input[type=file],textarea,select').filter(':visible:first').focus();
        }
    }
    /**
     *
     * @param Focus ERROr
     * @param data
     * @param hasError
     */
    function focus_error(form, data, hasError) {
        if(hasError) {
            $(".error").find('input[type=text],input[type=radio],input[type=checkbox],input[type=file],textarea,select').filter(':visible:first').focus();
        }else{
            $(form).unbind().submit();
        }
    }
	
	function editpwdChange($this) {
		if($this.is(':checked')){
			$('#UserDetails_ud_password').attr("readonly", false);
			$('#UserDetails_ud_password').val("");	
		}else{
			$('#UserDetails_ud_password').focus(); 
			$('#UserDetails_ud_password').val(oldpwd); 
			$('#UserDetails_ud_password').attr("readonly", true); 
		}
	}
</script>