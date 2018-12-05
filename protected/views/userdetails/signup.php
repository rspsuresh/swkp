
<style>
    .error > .errorMessage, .errorMessage, label > span.required {
        color: #fb4646;
    }
    .btn-primary {
        width: 100%;
    }
    .centrebtn {
        text-align: center;
    }
    .flashmessage{
        border:1px solid black;
        margin-top:120px !important;
        float:right;width:30%;
        border-radius: 3px;
    }
    .flashmessage{

        border-color: rgba(0,0,0,.1);
        color: #fff;
        padding: 10px;
    }
    .successmsg
    {
        background-color: #23b7e5;
    }
    .fail
    {
        background-color: #f05050;
    }
</style>
<div class="flashmessage" id="statusdiv" style="display:none;"></div>
<div class="wrapper" style="padding-top: 120px">
    <section id="support" class="doublediagonal">
        <div class="container" style="width:50%;">
            <div class="section-heading scrollpoint sp-effect3">
                <h2>SIGN UP</h2>
            </div>
            <?php
            $form1 = $this->beginWidget('CActiveForm', array(
                'id' => 'user-details-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                    'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
                )
            ));
            ?>
            <div>
                <div class="row">
                    <!--                    <div class="col-md-12">
                                            <div class="row">-->
                    <div class="col-md-8 col-sm-8 col-sm-offset-2 scrollpoint sp-effect1">
                        <!--<form role="form">-->

                        <div class="form-group">
                            <?php echo $form1->labelEx($model, 'ud_email'); ?>
                            <?php echo $form1->textField($model, 'ud_email', array("class" => "form-control")); ?>
                            <?php echo $form1->error($model, 'ud_email'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::submitButton('Create My Account', array('id' => 'submit_signup', 'class' => 'btn btn-primary btn-lg')); ?>
                        </div>
                        <div class="form-group centrebtn">
                            <div class="col-md-12">
                                <?php echo CHtml::link('Already have an account?', Yii::app()->createUrl('site/login'), array("class" => "", "id" => "")); ?>
                            </div>
                        </div>
                        <!--</form>-->
                    </div>
                    <!--                        </div>
                                        </div>-->
                </div>
                <?php // echo $form1->hiddenField($model, 'ud_usertype_id', array("value" => "5")); ?>
                <?php echo $form1->hiddenField($model, 'ud_flag', array("value" => "I")); ?>
                <div class="uk-margin-medium-top">

                </div>

                <?php $this->endWidget(); ?>
            </div>
    </section>

</div>
<script>
    $(document).ready(function () {
        appMaster.preLoader();
    });
    function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: ' <?php echo Yii::app()->createUrl("userdetails/signup"); ?> ',
                type: "POST",
                data: $("#user-details-form").serialize(),
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S") {
                        window.location.href = '<?php echo Yii::app()->createUrl('site/login?msg=signup'); ?>';
                    }
                    else
                    {
                        window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
                        AUIkit.init(document.getElementById('Atoast'), "Something went wrong.try later!", 'error', '5000');
                    }
                }
            });
        }
    }
</script>
</body>

</html>
