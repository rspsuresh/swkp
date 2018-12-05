<?php
    $tmpid=$model->ProjectMaster->template_id;

    $processes=CHtml::listData(Templates::model()->findAll(array('condition' => "(parent_id=$tmpid and t_status='A') or id=$tmpid")),'id',function($data)
    {
        return $data->t_name." (".$data->output.")";
    });
    ?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'template-change-form',
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
        <div class="uk-width-medium-1-2">
            <div class="md-input-wrapper md-input-filled">
                <?php echo $form->dropDownList($model, 'fi_template_id', $processes, array("prompt" => "Select template", "data-md-selectize" => true, 'data-md-selectize-bottom' => true)); ?>
                <?php echo $form->error($model, 'fi_template_id'); ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2" style="padding-top:20px;">
            <span><a id="previewtemplate" onclick="preview($(this))">Download</a></span>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-medium-1-1">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'uk-button uk-button-success uk-float-right')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<script>
    $(document).ready(function () {
        altair_md.init();
        altair_forms.init();
        $("#previewtemplate").hide();
    });
   function saveForm(form, data, hasError) {
        if (!hasError) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/templatechange/' . $model->fi_file_id); ?>',
                type: "POST",
                data: $("#template-change-form").serialize(),
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
    $("#FileInfo_fi_template_id ").change(function(){
        var tmp_id=$("#FileInfo_fi_template_id option:selected").text().toLowerCase();
        var ext = tmp_id.match(/\((.*)\)/);
        var strx   = tmp_id.split(' ');
        var  txt=(ext[1]=='docx')?'doc':ext[1];
        var href=strx[0]+"."+txt;
        if(tmp_id !='' && tmp_id !='Select template'  )
        {
            $("#previewtemplate").attr("filename",href).show();
        }
        else {
            $("#previewtemplate").hide();
        }
    });
    function preview(a)
    {
        var finame=a.attr('filename');
        window.location.href='<?php echo Yii::app()->createUrl('project/preview?filename=')?>'+finame;
    }
</script>