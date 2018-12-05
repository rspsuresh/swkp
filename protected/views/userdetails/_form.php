<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
?>
<style>
    .individual_subject {
        display: inline-block;
        margin-bottom: 10px;
    }
    .error_cls {
        border: 1px solid red !important;
    }
</style>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-details-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            'afterValidate' => 'js:function(form, data, hasError) { saveUserForm(form, data, hasError);}',
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class="uk-form-row">
        <div class="uk-accordion" data-uk-accordion>
            <h3 class="uk-accordion-title">General Information</h3>
            <div class="uk-accordion-content">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_name'); ?>
                        <?php echo $form->textField($model, 'ud_name', array('size' => 60, 'maxlength' => 250, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_name', '', false); ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_empid'); ?>
                        <?php echo $form->textField($model, 'ud_empid', array('size' => 60, 'maxlength' => 150, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_empid', '', false); ?>
                    </div>
                </div>


                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_username'); ?>
                        <?php echo $form->textField($model, 'ud_username', array('size' => 60, 'maxlength' => 200, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_username'); ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_usertype_id'); ?>
                        <?php echo $form->dropDownList($model, 'ud_usertype_id', CHtml::listData(UserType::model()->findAll(array("condition" => "ut_flag = 'A' and  ut_refid!=5 ", 'order' => 'ut_name')), 'ut_refid', 'ut_name'), array('empty' => 'Select Usertype', 'onchange' => 'selectTeamlead($(this))')); ?>
                        <?php echo $form->error($model, 'ud_usertype_id', '', false); ?>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-medium-1-1" style="display: none" id="teamlead">
                        <?php echo $form->labelEx($model, 'ud_teamlead_id'); ?>
                        <?php echo $form->dropDownList($model, 'ud_teamlead_id', CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_flag = 'A' and ud_usertype_id=2")), 'ud_refid', 'ud_username'), array('empty' => 'Select Usertype')); ?>
                        <?php echo $form->error($model, 'ud_teamlead_id'); ?>
                    </div>
                </div>
                <div class="uk-grid">
                    <?php if (!$model->isNewRecord) { ?>
                        <div class="uk-width-medium-1-2">
						    <?php echo CHtml::label(Yii::t('demo', 'Edit Password: '), 'Edit Password');?>
                            <?php echo CHtml::checkBox('editpass',false,array("onchange" => "editpwdChange($(this))")); ?>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <?php echo $form->labelEx($model, 'ud_password'); ?>
                            <?php echo $form->passwordField($model, 'ud_password', array('size' => 60, 'maxlength' => 200, 'class' => 'md-input', 'readonly' => true)); ?>
                            <?php echo $form->error($model, 'ud_password', '', false); ?>
                        </div>
                    <?php } else { ?>
                        <div class="uk-width-medium-1-1">
                            <?php echo $form->labelEx($model, 'ud_password'); ?>
                            <?php echo $form->passwordField($model, 'ud_password', array('size' => 60, 'maxlength' => 200, 'class' => 'md-input', 'readonly' => false)); ?>
                            <?php echo $form->error($model, 'ud_password', '', false); ?>
                        </div>
                    <?php } ?>
                </div>
                <?php if(!$model->isNewRecord){ ?>
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-2">
                            <?php echo $form->labelEx($model, 'ud_ipin'); ?>
                            <?php echo $form->textField($model, 'ud_ipin', array('size' => 30, 'maxlength' =>4, 'class' => 'md-input')); ?>
                            <?php echo $form->error($model, 'ud_ipin'); ?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <h3 class="uk-accordion-title" >Projects</h3>
            <div class="uk-accordion-content">
                <div class="multiple_project uk-grid">
                    <?php
                    $totalproject = Project::model()->findAll();
                    $projectList = CHtml::dropDownList("project[]", '', CHtml::listData(Project::model()->findAll(array("condition" => "p_flag = 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project', 'class' => 'selected_project chosen-select', "onchange" => "usertypeChange($(this))"));
                    $categoryList = CHtml::dropDownList("category[]", '', array(0 => ''), array('multiple' => true, 'data-placeholder' => 'Select Category', 'class' => 'selected_category chosen-select'));
                    $projectList = preg_replace("/\r|\n/", "", $projectList);
                    $categoryList = preg_replace("/\r|\n/", "", $categoryList);
                    if (!empty($model->ud_cat_id)) {
                        $projectCategory = json_decode($model->ud_cat_id, true);
                        $toEnd = count($projectCategory);

                        $projectIds = array_keys($projectCategory);
                        foreach ($projectCategory as $index => $data) {
                            $projectModel = Project::model()->findByPk($index);
                            $projectIdString = implode(",", $projectIds);
                            if (empty($projectIdString)) {
                                $projectIdString = 0;
                            }
                            if ($projectModel) {
                                // $projectListArray = CHtml::listData(Project::model()->findAll(array("condition" => "p_pjt_id in ($projectIdString)", "order" => "p_name")), 'p_pjt_id', 'p_name');
                                $projectListArray = CHtml::listData(Project::model()->findAll(array("order" => "p_name")), 'p_pjt_id', 'p_name');
                                $categoryListArray = CHtml::listData(Category::model()->findAll(array('condition' => 'ct_cat_id in(' . $projectModel->p_category_ids . ')', "order" => "ct_cat_name")), "ct_cat_id", "ct_cat_name");
                            }
                            if (($key = array_search($index, $projectIds)) !== false) {
                                unset($projectIds[$key]);
                            }
                            ?>
                            <div class="uk-width-medium-1-2 individual_project">
                                <?php echo CHtml::dropDownList("project[]", $index, $projectListArray, array('empty' => 'Select Project', 'class' => 'selected_project chosen-select', "onchange" => "usertypeChange($(this))")) ?>
                                <?php
                                if($model->ud_usertype_id == 4){ // category only for reviewer
                                    echo CHtml::dropDownList("category[]", explode(",", $data), $categoryListArray, array('multiple' => true, 'data-placeholder' => 'Select Category', 'class' => 'selected_category chosen-select'));
                                }?>
                                <?php
                                /* if (0 === --$toEnd) { */
                                echo '<a href="javascript:void(0);" class="add_new_subject uadd"  onclick="add_project($(this))"> Add </a>';
                                /* } else { */
                                /*  if($toEnd > 1) { */
                                echo '<a href="javascript:void(0);" class="add_new_subject remove_subject uremove"  onclick="add_project($(this))"> Remove </a>';
                                /*  } */
                                /* } */
                                ?>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="uk-width-medium-1-2 individual_project">
                            <?php echo $projectList ?>
                            <?php echo $categoryList ?>
                            <a href="javascript:void(0);" class="add_new_usertype uadd" onclick="add_project($(this))"> Add </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <h3 class="uk-accordion-title">Personal Details</h3>
            <!--<div data-wrapper="true" style="height: 0px; position: relative; overflow: hidden;" aria-expanded="false">-->
            <div class="uk-accordion-content">
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
                        <?php echo $form->error($model, 'ud_gender', '', false); ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label for="radio_demo_inline_1" class="inline-label">Single</label>
                        <?php echo $form->checkbox($model, 'ud_marital_status', array("value" => "M", "uncheckValue" => "UM", "data-switchery" => "")); ?>
                        <label for="radio_demo_inline_1" class="inline-label">Married</label>
                    </div>
                </div>


                <!--</div>-->
                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_dob'); ?>
                        <?php echo $form->textField($model, 'ud_dob', array('class' => 'md-input', "data-uk-datepicker" => "{format:'DD-MM-YYYY'}")); ?>
                        <?php echo $form->error($model, 'ud_dob', '', false); ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_mobile'); ?>
                        <?php echo $form->textField($model, 'ud_mobile', array('size' => 10, 'maxlength' => 10, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_mobile', '', false); ?>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_email'); ?>
                        <?php echo $form->textField($model, 'ud_email', array('size' => 60, 'maxlength' => 150, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_email'); ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_emergency_contatct_details'); ?>
                        <?php echo $form->textField($model, 'ud_emergency_contatct_details', array('size' => 10, 'maxlength' => 10, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_emergency_contatct_details', '', false); ?>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_temp_address'); ?>
                        <?php echo $form->textArea($model, 'ud_temp_address', array('rows' => 6, 'cols' => 50, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_temp_address', '', false); ?>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <?php echo $form->labelEx($model, 'ud_permanent_address'); ?>
                        <?php echo $form->textArea($model, 'ud_permanent_address', array('rows' => 6, 'cols' => 50, 'class' => 'md-input')); ?>
                        <?php echo $form->error($model, 'ud_permanent_address', '', false); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php /*  <div class="uk-grid">
          <div class="uk-width-medium-1-2">
          <?php echo $form->labelEx($model, 'ud_picture'); ?>
          <?php echo $form->fileField($model, 'ud_picture', array('class' => 'md-input')); ?>
          <?php echo $form->error($model, 'ud_picture'); ?>
          </div>
          </div> */ ?>
        <?php echo CHtml::hiddenField('cancel_scenario', '1', array('id' => 'cancel_scenario')); ?>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'uk-button uk-button-success')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    var previousCategory = "";
    var oldpwd = "";
    $(document).ready(function () {
        $(".individual_project:last").find('a.remove_usertype, a.add_new_usertype').remove();
        var tproject = '<?php echo count($totalproject); ?>';
        //$("#no_of_projects").text(tproject);
        var length = $(".individual_project").length;
        if (length == 1) {
            $(".uremove").hide();
        }
        <?php if (empty($model->ud_cat_id)) { ?>
        $(".individual_project:last").append('<a href="javascript:void(0);" class="add_new_usertype uadd" onclick="add_project($(this))"> Add </a><a href="javascript:void(0);" class="add_new_usertype remove_usertype uremove" onclick="add_project($(this))"> Remove </a>');
        <?php } ?>
        if ($('.multiple_project .individual_project').length == 1) {
            $(".individual_project:last").find('a.remove_usertype').remove();
        }
        $(".individual_project").children("#project").chosen();
        $(".individual_project").children("#category").chosen();
        $("#user-details-form #UserDetails_ud_usertype_id").chosen();
        altair_md.init();
        altair_forms.init();

        var accordion = UIkit.accordion('.uk-accordion', {collapse: false});
        //Teamlead
        var usertypeValue = $('#user-details-form #UserDetails_ud_usertype_id').val();
        //$("#No_of_projects").text("No of Projects:"+tproject);
        if (usertypeValue == 3 || usertypeValue == 4) {
            $("#UserDetails_ud_teamlead_id").chosen();
            $('#teamlead').show();
            if (usertypeValue == 4) { // category only for reviewer
                $('#category_chosen').show();
            }
            else {
                $('#category_chosen').hide();
            }
        } else {
            $('#teamlead').hide();
            $('#category_chosen').hide();
        }
        oldpwd = $('#UserDetails_ud_password').val();
    });
    <?php if ($model->isNewRecord) { ?>
    url = '<?php echo Yii::app()->createUrl('userdetails/create') ?>';
    <?php } else { ?>
    url = '<?php echo Yii::app()->createUrl('userdetails/update', array('id' => $_GET['id'])) ?>';
    <?php } ?>
    function saveUserForm(form, data, hasError) {
        if (!hasError && validatefields()) {

            var categories = Array();
            var formData = new FormData($('#user-details-form')[0]);


            if ($('#user-details-form #UserDetails_ud_usertype_id').val() == 4) { // category only for reviewer
                $(".individual_project").each(function () {
                    categories.push($(this).find('select.selected_category').val());
                });
                formData.append("categories", JSON.stringify(categories));
            }
            $.ajax({
                url: url,
                type: "post",
                data: formData,
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
    //    $('#UserDetails_ud_usertype_id').on('change', function () {
    //        var val = $('#UserDetails_ud_usertype_id').val();
    //        if (val != '2') {
    //            $('#UserDetails_category_em_').show();
    //        } else {
    //            $('#UserDetails_category_em_').hide();
    //        }
    //    });
    //    function getcategory(valid) {
    //        if (valid.value != '') {
    //            $('#UserDetails_category_em_').hide();
    //        } else {
    //            $('#UserDetails_category_em_').show();
    //        }
    //    }
    //    function check() {
    //        var val = $('#UserDetails_ud_usertype_id').val();
    //        if (val != '2') {
    //            if ($('#UserDetails_category').val() != '') {
    //                $('#UserDetails_category_em_').show();
    //                return true;
    //            } else {
    //                $('#UserDetails_category_em_').show();
    //                return false;
    //            }
    //        } else {
    //            return true;
    //        }
    //    }

    function usertypeChange($this) {

        var curCategory = $this.val();
        $('.individual_project #project').each(function () {

            var asd = $(this).find('option[value="' + previousCategory + '"]').val();

            if (asd != previousCategory && previousCategory != "") {
                $(this).append($('<option>', {
                    value: previousCategory,
                    text: previousCatOption
                }));
            }

            if ($(this).val() != curCategory) {
                previousCategory[0] = curCategory;
                previousCategory[1] = $(this).find('option[value="' + curCategory + '"]').text();
                $(this).find('option[value="' + curCategory + '"]').remove();
            }
            $(this).trigger("chosen:updated");
        });

        var value = $this.val();
        if (value != "" && $('#user-details-form #UserDetails_ud_usertype_id').val() == 4) { // category only for reviewer
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('project/getcategories') ?>",
                type: "post",
                data: {projectId: value},
                success: function (data) {
                    $($this).next().next().html(data);
                    $($this).next().next().find("option[value='']").remove();
                    $($this).next().next().trigger("chosen:updated");
                }
            });
        }
    }

    function add_project(current_project) {

        if (current_project.hasClass("remove_subject")) {
            var value = $(current_project).closest('.individual_project').children("#project").val();
            var selectedOption = $(current_project).closest('.individual_project').children("#project").find(":selected").text();
            $(".individual_project:last").children("#project").trigger("chosen:updated");
            $(current_project).closest('.individual_project').remove();
            //$(".individual_project:last").find('a.remove_usertype, a.add_new_usertype').remove();
            //$(".individual_project:last").append('<a href="javascript:void(0);" class="add_new_usertype" onclick="add_project($(this))"> Add </a><a href="javascript:void(0);" class="add_new_usertype remove_usertype" onclick="add_project($(this))"> Remove </a>');
            if ($('.multiple_project .individual_project').length == 1) {
                $(".individual_project:last").find('a.remove_usertype').remove();
            }
            var numItems = $('.individual_project').length;
            if (numItems == 1) {
                $(".uremove").hide();
                $(".uadd").show();
            }
            if (value != "") {
                $(".individual_project #project").each(function () {
                    $(this).append($('<option>', {
                        value: value,
                        text: selectedOption
                    }));
                    $(this).trigger('chosen:updated');
                });
            }
            return false;
        }
        var geterror = false;
        geterror = validatefields();

        if (geterror) {
            var pgcount =<?php echo count($totalproject); ?>;
            var numItems = $('.individual_project').length;
            if (numItems < pgcount) {
                var append_content = '<div class="uk-width-medium-1-2 individual_project">\n\
<?php echo $projectList; ?>';
                if ($('#user-details-form #UserDetails_ud_usertype_id').val() == 4)     { // category only for reviewer
                    append_content += '<?php echo $categoryList; ?></div>';
                }
                else {
                    append_content += '</div>';
                }

                $(append_content).appendTo($(".multiple_project"));

                $(".individual_project:last").append('<a href="javascript:void(0);" class="add_new_usertype uadd" onclick="add_project($(this))"> Add </a>' +
                    '<a href="javascript:void(0);" class="add_new_subject remove_subject uremove" onclick="add_project($(this))"> Remove </a>');

                var numItenms = $('.individual_project').length;
                if (numItenms > 1) {
                    $(".uremove").show();
                    $(".uadd").show();
                }
                $(".individual_project #project").each(function () {
                    var value = $(this).val();
                    if (value != "") {
                        $(".individual_project:last").children("#project").find('option[value="' + value + '"]').remove();
                    }
                    $(this).trigger('chosen:updated');
                });
                $(".individual_project:last").children("#project").chosen();
                $(".individual_project:last").children("#category").chosen();
                if (current_project.parent().find('a.remove_usertype').length == 1) {
                    //current_project.remove();
                }
                /*else {
                 alert("Only"+pgcount+" Projects is available");
                 }*/
                //current_project.addClass("remove_usertype");
            }
            if (numItems > 1) {
                $(".uremove").show();
                $(".uadd").show();
            }

        }
    }
    $(document).on('focus', '.individual_project .selected_project', function () {
        previousCategory = $(this).next().next().val();
        previousCatOption = $(this).next().next().find('option[value="' + previousCategory + '"]').text();
    });

    function categoryChange($this) {
        var curCategory = $this.val();
        $('select.initialized.selected_category').each(function () {
//            var asd = $(this).find('option[value="' + previousCategory + '"]').val();
//            if (asd != previousCategory && previousCategory != "") {
//                $(this).append($('<option>', {
//                    value: previousCategory,
//                    text: previousCatOption
//                }));
//            }
//console.log(curCategory);
//console.log($(this).val());
            if ($(this).val() != curCategory) {
                console.log("test");
                previousCategory[0] = curCategory;
                previousCategory[1] = $(this).find('option[value="' + curCategory + '"]').text();
                $(this).find('option[value="' + curCategory + '"]').remove();
            }
        });
        $("select").material_select();
        if ($this.val() != "") {
            $.ajax({
                type: "POST",
                data: {category: curCategory},
                url: "<?php echo Yii::app()->createUrl('userdetails/dep_subject1'); ?>",
                success: function (data) {
                    $($this).closest('.individual_subject').find("select.initialized.selected_subject").html(data);
                    $("select").material_select();
                }
            })
        }
    }

    function displayUpdate() {

    }

    function validatefields() {
        var error = true;
        var usertypeValue = $('#user-details-form #UserDetails_ud_usertype_id').val();
        $('select.selected_project').each(function () {
            if ($(this).val() == "") {
                $(this).next().addClass('error_cls');
                $(this).focus();
                error = false;
            } else {
                $(this).next().removeClass('error_cls');
            }
        });
        if (usertypeValue != 3 && usertypeValue != 2 ) {
            $('select.selected_category').each(function () {
                if ($(this).val() == "" || $(this).val() == null) {
                    $(this).next().addClass('error_cls');
                    $(this).focus();
                    error = false;
                } else {
                    $(this).next().removeClass('error_cls');
                }
            });
        }

        //Teamlead

        if (usertypeValue == 3 || usertypeValue == 4) {
            if ($('#UserDetails_ud_teamlead_id').val() == '') {
                error = false;
                $('#UserDetails_ud_teamlead_id_em_').show().html('Team Lead is Required');
            } else {
                $('#UserDetails_ud_teamlead_id_em_').html('').hide();
            }
        }
        return error;
    }

    //Select team Lead
    function selectTeamlead($this) {
        var typeValue = $this.val();
        if (typeValue == 4) { // category only for reviewer
            $('#category_chosen').show();
            $("#UserDetails_ud_teamlead_id").chosen();
            $('#teamlead').show();
        }
        else if (typeValue == 3) {
            $("#UserDetails_ud_teamlead_id").chosen();
            $('#teamlead').show();
            $('#category_chosen').hide();
        } else {
            $('#teamlead').hide();
            $('#category_chosen').hide();
        }

    }

    function editpwdChange($this) {
		//console.log($this.attr('id'));
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