<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-feedback-form',
        //'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
        )
    ));
    ?>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php
                echo $form->labelEx($model, 'ja_qc_feedback');
                echo $form->textArea($model, 'ja_qc_feedback', array('class' => 'md-input'));
                echo $form->error($model, 'ja_qc_feedback');
                ?>
            </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::htmlButton('Submit', array(
                    'class' => 'uk-button uk-button-success',
                    'onClick' => 'sconfirm()'));
                ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    $(function () {
        altair_md.init();
        altair_forms.init();
    });
    url = '<?php echo Yii::app()->createUrl("joballocation/feedback", array('id' => $_REQUEST['id'], 'status' => $_REQUEST['status']))?>';
    function saveForm(form, data, hasError) {
        if (!hasError) {
            $.ajax({
                url: url,
                type: "POST",
                data: $("#job-feedback-form").serialize(),
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        $('#quitModal .uk-close')[0].click();
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

    function sconfirm() {
        /*var textVal = $("#JobAllocation_ja_reviewer_feedback").val();
         if (textVal != '') {
         $("#JobAllocation_ja_reviewer_feedback_em_").html('');
         $("#JobAllocation_ja_reviewer_feedback_em_").hide();
         $('#job-feedback-form').submit();
         } else {
         $("#JobAllocation_ja_reviewer_feedback_em_").html('Add Feed Back');
         $("#JobAllocation_ja_reviewer_feedback_em_").show();
         }*/
        $('#job-feedback-form').submit();
    }
    function nconfirm() {
        $('#job-feedback-form').submit();
    }

</script>