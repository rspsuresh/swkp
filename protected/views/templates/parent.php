<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php if($model->isNewRecord){
        $url = Yii::app()->createUrl("templates/create");
     } else {

        $url = Yii::app()->createUrl('templates/update?id=' . $model->id);
} ?>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'templates-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        //'action' => $url,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
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
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'output'); ?>
                <?php echo $form->dropDownList($model, 'output',array('XLS' => 'XLS', 'XML' => 'XML', 'PDF' => 'PDF', 'DOCX' => 'DOCX'), array('empty' => 'Select Output')); ?>
                <?php echo $form->error($model, 'output'); ?>
            </div>
            <div class="uk-width-medium-1-2">
               <label for="Templates_t_name" class="required">Parent Template Name <span class="required">*</span></label>
                <?php echo $form->textField($model, 't_name', array('size' => 60, 'maxlength' => 250, 'class' => 'md-input ')); ?>
                <?php echo $form->error($model, 't_name'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <!--<div class="uk-width-medium-4-6">
            </div>-->
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'md-btn md-btn-success')); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
<script>
    $(document).ready(function () {
        altair_md.init();
        altair_forms.init();
        $("select[name='Templates[output]']").chosen();
    });
        <?php if ($model->isNewRecord) { ?>
    url = '<?php echo Yii::app()->createUrl('templates/parentcreate') ?>';
    <?php } else { ?>
    url = '<?php echo Yii::app()->createUrl('templates/parentupdate', array('id' => $_GET['id'])) ?>';
    <?php } ?>
    function saveForm (form, data, hasError) {
        if (!hasError) {

            var formData = new FormData($('#templates-form')[0]);
            $.ajax({
                url: url,
                type: "post",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S") {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                    }
                    else if(obj.status == "U")
                    {
                        $("#Templates_t_name_em_").text('This Name is already exists').show();
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