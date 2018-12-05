<!--<script src="--><?php //echo Yii::app()->theme->baseUrl;     ?><!--/altair_file/assets/js/pages/page_user_edit.min.js"></script>-->
<div class="md-card">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'profile-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'stateful' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        //'action' => Yii::app()->createUrl('userdetails/update?id=' . $model->ud_refid),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
        ),
    ));
    ?>
    <div class="uk-sticky-placeholder" style="height: 130px; margin: 0px;">
        <div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }" style="margin: 0px;">
            <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail">
                    <!-- <img src="assets/img/avatars/user.png" alt="user avatar" class="">-->
                    <img id="aImgShow" class="carImage" src="<?php echo Yii::app()->baseUrl ?>/images/sample.png" />
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                <div class="user_avatar_controls">
                    <span class="btn-file">
                        <span class="fileinput-new"><i class="material-icons"></i></span>
                        <span class="fileinput-exists"><i class="material-icons"></i></span>
                        <input type="file" name="UserDetails[ud_picture]" id="UserDetails_ud_picture" onchange="uploadImage(this)" data-target="#aImgShow">
                    </span>
                    <a href="#" class="btn-file fileinput-exists" data-dismiss="fileinput"><i class="material-icons"></i></a>
                </div>
            </div>
            <div class="user_heading_content">
                <h2 class="heading_b">
                    <span class="uk-text-truncate" id="user_edit_uname">Profile</span><span class="sub-heading" id="user_edit_position"></span>
                </h2>
            </div>
            <?php /* <div class="md-fab-wrapper">
              <button type="submit" id="user_edit_save" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Save" class="md-fab md-fab-accent md-fab-wave waves-effect waves-button">
              <i class="material-icons md-color-white"></i></button>
              <!--<div class="md-fab md-fab-toolbar md-fab-small md-fab-accent">
              <i class="material-icons"></i>
              <div class="md-fab-toolbar-actions">
              <button type="submit" id="user_edit_save" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Save"><i class="material-icons md-color-white"></i></button>
              <button type="submit" id="user_edit_print" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Print"><i class="material-icons md-color-white"></i></button>
              <button type="submit" id="user_edit_delete" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Delete"><i class="material-icons md-color-white"></i></button>
              </div>
              </div>-->
              </div> */ ?>
        </div>
    </div>
    <div class="user_content">
        <div class="uk-margin-top">
            <h3 class="full_width_in_card heading_c">
                General Info
            </h3>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-2 uk-row-first">
                    <?php echo $form->labelEx($model, 'ud_name'); ?>
                    <?php echo $form->textField($model, 'ud_name', array("class" => "md-input")); ?>
                    <?php echo $form->error($model, 'ud_name'); ?>
                </div>
                <div class="uk-width-medium-1-2">
                    <?php echo $form->labelEx($model, 'ud_email'); ?>
                    <?php echo $form->textField($model, 'ud_email', array("class" => "md-input")); ?>
                    <?php echo $form->error($model, 'ud_email'); ?>
                </div>
                <?php /* <div class="uk-width-medium-1-2">
                  <?php echo $form->labelEx($model, 'ud_empid'); ?>
                  <?php echo $form->textField($model, 'ud_empid', array("class" => "md-input")); ?>
                  <?php echo $form->error($model, 'ud_empid'); ?>
                  </div> */ ?>
            </div>
            <div class="uk-grid">
                <!--                <div class="uk-width-medium-1-2 uk-row-first">
                <?php // echo $form->labelEx($model, 'ud_dob'); ?>
                <?php // echo $form->textField($model, 'ud_dob', array("class" => "md-input", "readonly" => true));  ?>
                <?php // echo $form->error($model, 'ud_dob');  ?>
                
                                </div>-->

                <div class="uk-width-medium-1-2">
                    <?php echo $form->labelEx($model, 'ud_mobile'); ?>
                    <?php echo $form->textField($model, 'ud_mobile', array("class" => "md-input", 'maxlength' => 10)); ?>
                    <?php echo $form->error($model, 'ud_mobile'); ?>
                </div>
                <div class="uk-width-medium-1-2">
                    <?php echo $form->labelEx($model, 'ud_emergency_contatct_details'); ?>
                    <?php echo $form->textField($model, 'ud_emergency_contatct_details', array("class" => "md-input")); ?>
                    <?php echo $form->error($model, 'ud_emergency_contatct_details'); ?>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-medium-1-4">
                    <?php /*
                      <?php // echo $form->labelEx($model, 'ud_gender', array("style" => "padding-right: 20px;")); ?>
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
                      <div class="uk-width-medium-1-4">
                      <label for="radio_demo_inline_1" class="inline-label">Single</label>
                      <?php echo $form->checkbox($model, 'ud_marital_status', array("value" => "M", "uncheckValue" => "UM", "data-switchery" => "")); ?>

                      <label for="radio_demo_inline_1" class="inline-label">Married</label>
                      </div> */ ?>
                    <!--<div class="uk-width-medium-1-2">-->
                </div> 
            </div>
            <!--            <div class="uk-grid">
                            <div class="uk-width-1-1">
            <?php // echo $form->labelEx($model, 'ud_temp_address'); ?>
            <?php // echo $form->textArea($model, 'ud_temp_address', array("class" => "md-input"));  ?>
            <?php // echo $form->error($model, 'ud_temp_address');  ?>
            
                            </div>
                        </div>-->
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <?php echo $form->labelEx($model, 'ud_username'); ?>
                    <?php echo $form->textField($model, 'ud_username', array("class" => "md-input")); ?>
                    <?php echo $form->error($model, 'ud_username'); ?>
                </div>
            </div>
            <div class="uk-grid">
			<?php if(!empty($model->newPassword)){ ?>
				<div class="uk-width-1-5">
					<?php echo CHtml::checkBox('editpass',false,array("onchange" => "editpwdChange($(this))")); ?>
				</div>
				<div class="uk-width-2-5">
                            <!--<input type="text" class="form-control" placeholder="Your name">-->
                    <?php echo $form->labelEx($model, 'newPassword'); ?>
                    <?php echo $form->passwordField($model, 'newPassword', array("class" => "md-input", 'readonly' => true)); ?>
                    <?php echo $form->error($model, 'newPassword', "", false); ?>
                </div>
				<div class="uk-width-2-5">
                        <!--<input type="email" class="form-control" placeholder="Your email">-->
                    <?php echo $form->labelEx($model, 'confirmPassword'); ?>
                    <?php echo $form->passwordField($model, 'confirmPassword', array("class" => "md-input", 'readonly' => true)); ?>
                    <?php echo $form->error($model, 'confirmPassword', "", false); ?>
                </div>
			<?php } else { ?>
                <input type="hidden" name="md5password" value="1">
				<div class="uk-width-1-2">
                            <!--<input type="text" class="form-control" placeholder="Your name">-->
                    <?php echo $form->labelEx($model, 'newPassword'); ?>
                    <?php echo $form->passwordField($model, 'newPassword', array("class" => "md-input", 'readonly' => false)); ?>
                    <?php echo $form->error($model, 'newPassword', "", false); ?>
                </div>
				<div class="uk-width-1-2">
                        <!--<input type="email" class="form-control" placeholder="Your email">-->
                    <?php echo $form->labelEx($model, 'confirmPassword'); ?>
                    <?php echo $form->passwordField($model, 'confirmPassword', array("class" => "md-input", 'readonly' => false)); ?>
                    <?php echo $form->error($model, 'confirmPassword', "", false); ?>
                </div>
			<?php } ?>
                        <!--<input type="email" class="form-control" placeholder="Your email">-->
            </div>
			<div class="uk-grid">
				<div class="uk-width-1-1">
                    <?php echo $form->labelEx($model, 'ud_ipin'); ?>
                    <?php echo $form->textField($model, 'ud_ipin', array("class" => "md-input",'maxlength'=>4)); ?>
                    <?php echo $form->error($model, 'ud_ipin'); ?>
                </div>
			</div>	
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <?php echo $form->labelEx($model, 'ud_permanent_address'); ?>
                    <?php echo $form->textArea($model, 'ud_permanent_address', array("class" => "md-input")); ?>
                    <?php echo $form->error($model, 'ud_permanent_address'); ?>
                    <?php echo $form->hiddenField($model, 'ud_flag', array("value" => "A")); ?>
                </div>
            </div>


            <div class="uk-grid">
                <div class="uk-width-medium-1-2 uk-row-first">
                    <button type="submit" id="user_edit_save" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Save" class="md-btn md-btn-success md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light">Save</button>
                </div>
            </div>
        </div><?php /*
                      <div class="uk-margin-top">
                      <h3 class="full_width_in_card heading_c">
                      FTP details
                      </h3>
                      <div class="uk-grid" data-uk-grid-margin="">
                      <div class="uk-width-medium-1-2 uk-row-first">
                      <?php echo $form->labelEx($model->ClientDetails, 'cd_downloadtype'); ?>
                      <?php echo $form->dropDownList($model->ClientDetails, 'cd_downloadtype', array("F" => "FTP", "S" => "SFTP", "A" => "Files anywhere"), array('empty' => 'Select Account Type')); ?>
                      <?php echo $form->error($model->ClientDetails, 'cd_downloadtype'); ?>
                      </div>
                      <div class="uk-width-medium-1-2 uk-row-first">
                      <?php echo $form->labelEx($model->ClientDetails, 'cd_projectid'); ?>
                      <?php // echo $form->dropDownList($model->ClientDetails,'cd_projectid', CHtml::listData(Project::model()->findAll(array("condition"=>"p_client_id = ".Yii::app()->session['user_id'])), 'p_pjt_id', 'p_name'), array('class' => 'data-md-selectize', 'empty' => 'Select project')); ?>
                      <?php echo $form->dropDownList($model->ClientDetails, 'cd_projectid', array("1" => "KPO", "2" => "Project1", "3" => "Project2"), array('empty' => 'Select Project')); ?>
                      <?php echo $form->error($model->ClientDetails, 'cd_projectid'); ?>
                      </div>
                      </div>
                      <div class="uk-grid">
                      <div class="uk-width-medium-1-2 uk-row-first">
                      <?php echo $form->labelEx($model->ClientDetails, 'cd_url'); ?>
                      <?php echo $form->textField($model->ClientDetails, 'cd_url', array("class" => "md-input")); ?>
                      <?php echo $form->error($model->ClientDetails, 'cd_url'); ?>
                      </div>
                      <div class="uk-width-medium-1-2">
                      <?php echo $form->labelEx($model->ClientDetails, 'cd_port'); ?>
                      <?php echo $form->textField($model->ClientDetails, 'cd_port', array("class" => "md-input")); ?>
                      <?php echo $form->error($model->ClientDetails, 'cd_port'); ?>
                      </div>
                      </div>
                      </div> */ ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
	var oldpwd = "";
    $(document).ready(function () {
        UIkit.datepicker($('#UserDetails_ud_dob'), {format: 'MM/DD/YYYY', minDate: false, });
        // $("select[name='ClientDetails[cd_downloadtype]'").chosen();
        //$("select[name='ClientDetails[cd_projectid]'").chosen();
		oldpwd = $('#UserDetails_newPassword').val();
    });

    function saveForm(form, data, hasError) {
        console.log(data);
        if (hasError == false) {
            var formdata = new FormData($('#profile-form')[0]);
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('userdetails/profileupdate?id=' . $model->ud_refid); ?>",
                type: "POST",
                data: formdata, //$("#profile-form").serialize(),
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    var obj = JSON.parse(result);
                    var pid = $('#ClientDetails_cd_projectid').val();
                    if (obj.status == "S") {
                        setTimeout(function () {
                            window.location.href = "<?php echo Yii::app()->createUrl('site/login'); ?>";
                        }, 3000);
                    }
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: "success",
                        timeout: 10000,
                        pos: 'top-right'
                    });
                }
            });
        }
    }

    var imageTypes = ['jpeg', 'jpg', 'png']; //Validate the images to show
    function showImage(src, target) {
        var fr = new FileReader();
        fr.onload = function (e) {
            target.src = this.result;
        };
        fr.readAsDataURL(src.files[0]);

    }
    var uploadImage = function (obj) {
        var val = obj.value;
        var lastInd = val.lastIndexOf('.');
        var ext = val.slice(lastInd + 1, val.length);
        if (imageTypes.indexOf(ext) !== -1) {
            var id = $(obj).data('target');
            var src = obj;
            var target = $(id)[0];
            showImage(src, target);
        }
        else {
            $('#UserDetails_ud_picture').val('');
            $('#aImgShow').attr('src', '');
            //$('#aImgShow').src='';
        }
    }
	
	function editpwdChange($this) {
		if($this.is(':checked')){
			$('#UserDetails_confirmPassword').attr("readonly", false);
			$('#UserDetails_newPassword').attr("readonly", false);
			$('#UserDetails_confirmPassword').val("");	
			$('#UserDetails_newPassword').val("");	
		}else{
			$('#UserDetails_newPassword').focus(); 
			$('#UserDetails_newPassword').val(oldpwd); 
			$('#UserDetails_confirmPassword').val(oldpwd); 
			$('#UserDetails_newPassword').attr("readonly", true); 
			$('#UserDetails_confirmPassword').attr("readonly", true); 
		}
	}

</script>