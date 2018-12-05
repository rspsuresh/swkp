<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */
?>
<?php echo Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'project-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'p_name'); ?>
                <?php echo $form->textField($model, 'p_name', array('class' => 'md-input')); ?>
                <?php echo $form->error($model, 'p_name'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'p_client_id'); ?>
                <?php echo $form->dropDownList($model, 'p_client_id', CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '5' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_email'), array('empty' => 'Select Client')); ?>
                <?php echo $form->error($model, 'p_client_id', '', false); ?>
            </div>

        </div>

        <div class="uk-grid">
            <div class="uk-width-medium-1-2 uk-row-first">
                <?php echo $form->labelEx($model, 'p_process'); ?>
                <div>
                    <?php
                    echo $form->checkBoxList($model, 'p_process', array('QI' => 'Prepping', 'QS' => 'DateCoding', 'QE' => 'Editing'), array('class' => 'data-md-icheck'), array(
//                        'labelOptions' => array('style' => 'display:inline'), // add this code
                        'separator' => '  ',
                    ));
                    ?>
                </div>
                <?php echo $form->error($model, 'p_process'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'template_id'); ?>
                <?php echo $form->dropDownList($model, 'template_id',CHtml::listData(Templates::model()->findAll(
                        array("condition" => "parent_id =0 and t_status = 'A'")), 'id',function($data){
                    return $data->t_name."  (".$data->output.")";
                }), array('prompt' => 'Select Template','class'=>'chosen-select changefunction')); ?>
                <?php echo $form->error($model, 'template_id', '', false); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
            </div>
            <div class="uk-width-medium-1-2">
			  <a  id="templateformats" style="color:#1e88e5 !important;"  target="_blank"  onclick="preview($(this))"class="waves-effect waves-light btn">Download</a>
            </div>

        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'file_upload'); ?>
                <?php

                if (!$model->isNewRecord) {
                    $model->p_category = $model->p_category_ids;
                    echo $form->dropDownList($model, 'p_category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_cat_type = 'M'")), 'ct_cat_id', 'ct_cat_name'), array('multiple' => true, 'onchange' => 'categorychange($(this))'));
//                    echo '<div class="errorMessage" id="Project_p_category_em_" style="display: none;">Category cannot be blank.</div>';
                    //echo $form->error($model, 'p_category_ids');
                } else {
                    ?>
                    <?php echo $form->dropDownList($model, 'fileup_category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_cat_type = 'M'")),'ct_cat_id','ct_cat_name'), array('multiple' => true, 'onchange' => 'categorychange($(this))'));?>
                <?php } ?>
                <?php echo $form->fileField($model, 'file_upload',array("onChange" => "uploadImage(this)","accept" => ".csv")); ?>

            </div>
            <div class="uk-width-medium-1-2">

                <?php echo $form->labelEx($model,'filenonmedical');?>
                <?php
                if (!$model->isNewRecord) {
                    $model->non_category = $model->non_cat_ids;
                    echo $form->dropDownList($model, 'non_category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_cat_type = 'N' or ct_cat_name ='Duplicate' or ct_cat_name ='Others'")), 'ct_cat_id', 'ct_cat_name'), array('multiple' => true, 'onchange' => 'categorychange($(this))'));

                }
                else {
                    echo $form->dropDownList($model, 'filenonup_category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_cat_type = 'N'")),'ct_cat_id','ct_cat_name'), array('multiple' => true, 'onchange' => 'categorychange($(this))'));
                }
                echo $form->fileField($model,'filenonmedical',array("accept" => ".csv"));

                if (!$model->isNewRecord) {
                    echo '<div class="errorMessage" id="Project_non_category_em_" style="display: none;">Non Medical Category cannot be blank.</div>';
                }
                ?>

                <?php //echo $form->fileField($model, 'file_upload', array('onchange' => "uploadImage(this)")); ?>
                <?php echo $form->error($model, 'filenonmedical', '', false); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->checkBox($model,'skip_edit',array('class' => 'data-md-icheck','value'=>1,'uncheckValue'=>0,'checked'=>($model->skip_edit == 1)?true:false)); ?> <span>Skip Editing</span>
            </div>
			<div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'p_form_id'); ?>
                <?php echo $form->dropDownList($model, 'p_form_id',CHtml::listData(FormsBuilder::model()->findAll(), 'id','name'), array('prompt' => 'Select Form','class'=>'chosen-select')); ?>
                <?php echo $form->error($model, 'p_form_id', '', false); ?>
            </div>
            <!--<div class="uk-width-medium-1-2">
                <label for="radio_demo_inline_1" class="inline-label">Need</label>
					<?php //echo $form->checkbox($model, 'p_prep', array("value" => "1", "uncheckValue" => "0", "data-switchery" => "")); ?>
                <label for="radio_demo_inline_1" class="inline-label">Skip Prepping</label>
            </div>-->
            <!--            <div class="uk-width-medium-1-2">
<?php // echo $form->labelEx($model, 'p_key_type'); ?>
                <div>
                    <span class="icheck-inline">
<?php // echo $form->radioButton($model, 'p_key_type', array('value' => 'M', 'uncheckValue' => null, 'class' => 'data-md-icheck')); ?>
                        <label for="radio_demo_inline_1" class="inline-label">Medical</label>
                    </span>
                    <span class="icheck-inline">
<?php // echo $form->radioButton($model, 'p_key_type', array('value' => 'N', 'uncheckValue' => null, 'class' => 'data-md-icheck')); ?>
                        <label for="radio_demo_inline_2" class="inline-label">Both</label>
                    </span>
                </div>
<?php // echo $form->error($model, 'p_key_type'); ?>
            </div>-->
        </div>
        <h3 style="padding: 16px 24px;background-color: rgba(0, 0, 0, 0.085);">
            Protocol Details
        </h3>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2 uk-row-first">
                <?php echo $form->labelEx($model, 'p_username'); ?>
                <?php echo $form->textField($model, 'p_username', array("class" => "md-input")); ?>
                <?php echo $form->error($model, 'p_username'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'p_password'); ?>
                <?php echo $form->passwordField($model, 'p_password', array("class" => "md-input")); ?>
                <?php echo $form->error($model, 'p_password'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2 uk-row-first">
                <?php echo $form->labelEx($model, 'p_url'); ?>
                <?php echo $form->textField($model, 'p_url', array("class" => "md-input label-fixed", 'placeholder' => 'http://URL')); ?>
                <?php echo $form->error($model, 'p_url'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'p_port'); ?>
                <?php echo $form->textField($model, 'p_port', array("class" => "md-input", 'maxlength' => 4)); ?>
                <?php echo $form->error($model, 'p_port'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2 uk-row-first">
                <?php echo $form->labelEx($model, 'p_downloadtype'); ?>
                <?php echo $form->dropDownList($model, 'p_downloadtype', array("F" => "FTP", "S" => "SFTP", "A" => "Files anywhere"), array('empty' => 'Select Account Type')); ?>
                <?php echo $form->error($model, 'p_downloadtype'); ?>
            </div>
            <div class="uk-width-medium-1-2 uk-row-first">
                <?php echo $form->labelEx($model, 'date_format'); ?>
                <?php echo $form->dropDownList($model, 'date_format', array('{"m/d/Y":"mm/dd/yyyy"}'=>'mm/dd/yyyy','{"d/m/Y":"dd/mm/yyyy"}'=>'dd/mm/yyyy')
                    , array('empty' => 'Select Format')); ?>
                <?php echo $form->error($model, 'date_format'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'md-btn md-btn-success')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
    <script>
        $(document).ready(function () {
            $("#templateformats").hide();

            $('.chosen-select').chosen();
            $("select[name='Project[p_client_id]").chosen();
            $("select[name='Project[p_op_format]").chosen();
            $("select[name='Project[p_downloadtype]'").chosen();
            $("select[name='Project[date_format]'").chosen();
            $('#Project_fileup_category').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
            $('#Project_filenonup_category').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
            $('#Project_p_category').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
            $('#Project_non_category').chosen({no_results_text: "No result found. Press enter to add ", add_new: "Y"});
            altair_md.init();
            altair_forms.init();
        });
        $(".changefunction").on('change', function() {
            var tmp_id = $(".changefunction option:selected").text().toLowerCase();
            var ext = tmp_id.match(/\((.*)\)/);
            var strx   = tmp_id.split(' ');
            var  txt=(ext[1]=='docx')?'doc':ext[1];
            var href=strx[0]+"."+txt;
            if(tmp_id !='' && tmp_id !='Select template'  )
            {
                $("#templateformats").attr("filename",href).show();
            }
            else {
                $("#templateformats").hide();
            }
        });
        function preview(a)
        {
           var finame=a.attr('filename');
            window.location.href='preview?filename='+finame;
        }
        var imageTypes = ['csv']; //Validate the images to show
        var uploadImage = function (obj) {
            fileUploadChange(obj);
            var val = obj.value;
            var lastInd = val.lastIndexOf('.');
            var ext = val.slice(lastInd + 1, val.length);
            if (imageTypes.indexOf(ext) !== -1) {
                var id = $(obj).data('target');
                var src = obj;
                var target = $(id)[0];
                <?php if (!$model->isNewRecord) { ?>
                $("#Project_p_category_em_").css('display', 'none');
                <?php } ?>
            }
            else {
                obj.value = '';
                <?php if (!$model->isNewRecord) { ?>
                $("#Project_p_category_em_").css('display', '').focus();
                <?php } ?>
            }
        }
        <?php if ($model->isNewRecord) { ?>
        url = '<?php echo Yii::app()->createUrl("project/create"); ?>';
        <?php } else { ?>
        url = '<?php echo Yii::app()->createUrl('project/update?id=' . $model->p_pjt_id); ?>';
        <?php } ?>

        function checkFileupload() {
            var upload = $('#Project_file_upload').val();
            var cat = $("#Project_p_category").val();
            if (upload != "" || cat != null) {
                var uploadArr = upload.split(".");
                if (upload != "" && uploadArr[uploadArr.length - 1] != "csv") {
                    return "wrong format";
                }
                else{
                    return "";
                }
                if(cat != null){
                    return "";
                }
                else{
                    return "";
                }
            }
            else{
                return "Medical Category cannot be blank.";
            }
        }
        function fileUploadChange(event){
            var fileUpload = checkFileupload();
            if(fileUpload != ""){
                $('#Project_file_upload_em_').show().html(fileUpload);
                return;
            }
            else{
                $('#Project_file_upload_em_').hide().html("");
            }
        };
        function saveForm(form, data, hasError) {
            var formdata = new FormData($('#project-form')[0]);
            var medval=newmedvalue();
            var nonmedval=newnonmedvalue();
            formdata.append("medval", medval);
            formdata.append("nonmedval", nonmedval);
            var valid = true ;
            if (!hasError && valid) {
                $.ajax({
                    url: url,
                    data: formdata,
                    type: "POST",
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
                        else if(obj.status == "E")
                        {
                            $("#Project_p_name_em_").text(obj.msg).show();
                        }
                    }
                });
            }
        }


        function newmedvalue()
        {
            var medopt=[];
            <?php if($model->isNewRecord){ ?>
            $("#Project_fileup_category option:selected ").each(function(){
                if($(this).attr('value')==undefined){

                    medopt.push($(this).text());
                }
            });
            <?php } else { ?>
            $("#Project_p_category option:selected ").each(function(){
                if($(this).attr('value')==undefined){

                    medopt.push($(this).text());
                }
            });
            <?php } ?>
            return medopt;
        }
        function newnonmedvalue()
        {
            var medopt=[];
            var nonmedopt=[];
            <?php if($model->isNewRecord){ ?>
            $("#Project_filenonup_category option:selected ").each(function(){
                if($(this).attr('value')==undefined){

                    nonmedopt.push($(this).text());
                }
            });
            <?php } else { ?>
            $("#Project_non_category option:selected ").each(function(){
                if($(this).attr('value')==undefined){

                    nonmedopt.push($(this).text());
                }
            });
            <?php } ?>
            return nonmedopt;
        }
        function categorychange($this) {
            fileUploadChange($this);
            if ($this.val() == null) {
                $("#Project_p_category_em_").css('display', '').focus();
//                $("#Project_non_category_em_").css('display', '').focus();
            } else {
                $("#Project_p_category_em_").css('display', 'none');
//                $("#Project_non_category_em_").css('display', 'none');
            }
        }
        /**
         * Validate
         */
        function validatefields() {
            var fileUpload = checkFileupload();
            if(fileUpload != ""){
                $('#Project_file_upload_em_').show().html(fileUpload);
                return;
            }
            else{
                $('#Project_file_upload_em_').hide().html("");
            }
            var error = true;
            <?php
            if (!$model->isNewRecord) {
            ?>
            var upload = $("#Project_file_upload").val();
            var category = $("#Project_p_category").val();
            if (category == null) {
                if (upload == '') {
                    $("#Project_p_category_em_").css('display', '').focus();
                    error = false;
                } else {
                    $("#Project_p_category_em_").css('display', 'none');
                    error = true;
                }
            }
            <?php } ?>
            return error;
        }
        jQuery(document).ready(function () {
            jQuery('.scrollbar-inner').scrollbar();
        });
    </script>

