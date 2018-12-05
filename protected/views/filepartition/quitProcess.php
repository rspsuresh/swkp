<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
?>
<?php echo Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-quit-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'action' => Yii::app()->createUrl("filepartition/quitpop"),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validaeOnChange' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveUserForm(form, data, hasError); }',
        )
    )); ?>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo $form->labelEx($model, 'ja_option', array("style" => "padding-right: 20px;")); ?>
                <?php
                echo $form->radioButtonList($model, 'ja_option', array('B' => 'Backward',
                    'R' => 'Reallocate',
                ), array(
                    'labelOptions' => array('style' => 'display:inline'), // add this code
                    'separator' => '  ', 'class' => 'data-md-icheck'
                ));
                ?>
                <?php echo $form->error($model, 'ja_option'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'ja_description'); ?>
                <?php echo $form->textArea($model, 'ja_description', array('class' => 'md-input')); ?>
                <?php echo $form->error($model, 'ja_description'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton('Quit', array('class' => 'uk-button uk-button-success')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function saveUserForm(form, data, hasError) {
        if (!hasError) {
            var formdata = new FormData($('#job-quit-form')[0]);
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/quitpop') ?>',
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
        }
    }
</script>
