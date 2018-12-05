<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'category-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'action' => Yii::app()->createUrl("category/create"),
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
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ct_cat_name'); ?>
                <?php echo $form->textField($model, 'ct_cat_name', array('size' => 60, 'maxlength' => 250, 'class' => 'md-input ')); ?>
                <?php echo $form->error($model, 'ct_cat_name'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ct_keywords'); ?>
                <?php echo $form->textField($model, 'ct_keywords', array('size' => 60, 'maxlength' => 250, 'class' => 'md-input ')); ?>
                <?php echo $form->error($model, 'ct_keywords'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo $form->labelEx($model, 'ct_cat_type'); ?>
                <?php echo $form->dropDownList($model, 'ct_cat_type', array('N' => 'Non Medical', 'M' => 'Medical'), array('data-md-selectize' => "", 'empty' => 'Select Type')); ?>
                <?php echo $form->error($model, 'ct_cat_type'); ?>
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
       // $("select[name='Category[ct_cat_type]").chosen();
        altair_md.init();
        altair_forms.init();
    });

    <?php if($model->isNewRecord){ ?>
    url = '<?php echo Yii::app()->createUrl("category/create"); ?>';
    <?php } else { ?>
    url = '<?php echo Yii::app()->createUrl('category/update?id=' . $model->ct_cat_id); ?>';
    <?php } ?>
    function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: url,
                type: "POST",
                data: $("#category-form").serialize(),
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