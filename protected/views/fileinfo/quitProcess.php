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
        'action' => Yii::app()->createUrl("fileinfo/quitfile"),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validaeOnChange' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveQuitForm(form, data, hasError); }',
        )
    )); ?>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo $form->labelEx($model, 'option', array("style" => "padding-right: 20px;")); ?>
                <?php
                echo $form->radioButtonList($model, 'option', array('B' => 'Backward',
                    'R' => 'Reallocate',
                ), array(
                    'labelOptions' => array('style' => 'display:inline'), // add this code
                    'separator' => '  ', 'class' => 'data-md-icheck'
                ));
                ?>
                <?php echo $form->error($model, 'option'); ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('class' => 'md-input')); ?>
                <?php echo $form->error($model, 'description'); ?>
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
    $(document).ready(function () {
        altair_md.init();
        altair_forms.init();
    });
    function saveQuitForm(form, data, hasError) {
        if (!hasError) {
            var formdata = new FormData($('#job-quit-form')[0]);
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => $_GET['status'], 'jobId' => $_GET['jobId'])); ?>',
                type: "post",
                data: $("#job-quit-form").serialize(),
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        if(obj.typ == 'IQ'){
							window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/indexalloc'); ?>?showMsg=' + obj.msg;
                        } else {
							window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
						}
                    }
                }
            });
        }
    }
</script>