<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
/* @var $form CActiveForm */

$option = '';
$status = '';

$dropdown = array();
if(Yii::app()->session['user_type'] == "A"){
	$dropdown = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name');
}
else if(Yii::app()->session['user_type'] == "TL"){
	$dropdown = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_teamlead_id= '".Yii::app()->session['user_id']."'&& ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name');
}
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-quit-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'validateOnType' => false,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError);}',
        ),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    

    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php echo $form->dropDownList($model, 'option', $dropdown, array("prompt" => "Select reviewer")); ?>
            <?php //echo $form->hiddenField($model, 'quit_process', array('class' => 'md-input', 'value' => $option)); ?>
            <?php echo $form->error($model, 'option'); ?>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Reallocate' : 'Save', array('class' => 'uk-button uk-button-success uk-float-right')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    $(document).ready(function () {
        //var accordion = UIkit.accordion('.uk-accordion', {collapse: false});
        $("#JobAllocation_option").chosen();
        altair_md.init();
        altair_forms.init();
    });
    function saveForm(form, data, hasError) {
        if (!hasError) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('joballocation/adminrealloc', array('id' => $id)); ?>',
                type: "POST",
                data: $("#job-quit-form").serialize(),
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