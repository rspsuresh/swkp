<?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
<link rel="stylesheet" href="<?php echo $path . "assets/js/Anotify/Anotify.css"; ?> " media="all">
<style>
    .error > .errorMessage, .errorMessage, label > span.required{
        color: #fb4646;
    }
    #notify_alert{
        width:350px;
        height:40px;
        background-color: #7cb342;
        opacity: 1;
        border-radius:5px;
        position:fixed;
        padding:10px;
        color:#fff;
        font-size: 15px;
        top:150px;
        right:20px;
        display:none;
    }
    .btn-primary{
        width:100%;
    }
    .centrebtn{
        text-align: center;
    }
    .nopadding{
        padding:0;
    }
</style>
<!--login -->
<div class="wrapper" style="padding-top: 120px">
    <section  class="doublediagonal" id="Lgsection">
        <div class="container" style="width:50%;">
            <div class="section-heading scrollpoint sp-effect3">
                <h2>Kpws Ipin</h2>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                    'validateOnType' => false,
                    'afterValidate' => 'js:function(form, data, hasError) { pinchecking(form, data, hasError);}',
                ),
            ));
            ?>
            <div class="row">
                <div class="col-md-8 col-sm-8 col-md-offset-2 scrollpoint sp-effect1">
                    <!--<form role="form">-->
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'ipin'); ?>
                        <?php echo $form->passwordField($model, 'ipin', array("class" => "form-control",'maxlength'=>4)); ?>
                        <?php echo $form->error($model, 'ipin'); ?>
                    </div>
                    <input type="hidden" name="LoginForm[username]" value='<?php echo Yii::app()->request->cookies['username']->value; ?>'>
                    <input type="hidden" name="LoginForm[password]" value='<?php echo Yii::app()->request->cookies['password']->value; ?>'>
                    <div class="form-group">
                        <?php echo CHtml::submitButton('Login', array("class" => "btn btn-primary btn-lg")); ?>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 nopadding">
                            <p class="text-left"><?php echo CHtml::link('Forget Password?', '#FP', array("class" => "pass", "id" => "FP")); ?></p>
                        </div>
                        <div class="col-md-6 nopadding">
                            <p class="text-right">
                                <?php echo CHtml::link('Create an account', Yii::app()->createUrl('userdetails/signup'), array("class" => "", "id" => "")); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php $this->endWidget(); ?>
</section>
<script>
    $(document).ready(function () {
        appMaster.preLoader();

        $(document).keydown(function(event){
            if(event.keyCode==123){
                return false;
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode==73){
                return false;  //Prevent from ctrl+shift+i
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode==67){
                return false;  //Prevent from ctrl+shift+C
            }
            else if(event.ctrlKey && event.keyCode==80){
                return false;  //Prevent from ctrl+p
            }
        });

        //Disable right click script
        var message="Sorry, right-click has been disabled";
        function clickIE() {if (document.all) {(message);return false;}}
        function clickNS(e) {if
        (document.layers||(document.getElementById&&!document.all)) {
            if (e.which==2||e.which==3) {(message);return false;}}}
        if (document.layers)
        {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
        else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
        document.oncontextmenu=new Function("return false")
        function disableCtrlKeyCombination(e)
        {
            var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j' , 'w');
            var key;
            var isCtrl;
            if(window.event)
            {
                key = window.event.keyCode;     //IE
                if(window.event.ctrlKey)
                    isCtrl = true;
                else
                    isCtrl = false;
            }
            else
            {
                key = e.which;     //firefox
                if(e.ctrlKey)
                    isCtrl = true;
                else
                    isCtrl = false;
            }
            //if ctrl is pressed check if other key is in forbidenKeys array
            if(isCtrl)
            {
                for(i=0; i<forbiddenKeys.length; i++)
                {
                    //case-insensitive comparation
                    if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
                    {
                        alert('Key combination CTRL + '+String.fromCharCode(key) +' has been disabled.');
                        return false;
                    }
                }
            }
            return true;
        }
        //disable ctrl+u
        document.onkeydown = function(e) {
            if (e.ctrlKey &&
                (e.keyCode === 67 ||
                e.keyCode === 86 ||
                e.keyCode === 85 ||
                e.keyCode === 117)) {
                return false;
            } else {
                return true;
            }
        };
    });

    $('#login_email_reset').keyup(function () {
        $(".login_email_reset_error").html('');
    });
    $("#resetPasswordForm").submit(function (e) {
        e.preventDefault();
        if ($("#login_email_reset").val() != "") {
            $('#RP').attr('disabled', 'disabled');
            var data = $("#resetPasswordForm").serialize();
            $.ajax({
                type: "POST",
                data: data,
                url: "<?php echo Yii::app()->createUrl('site/forgetpassword'); ?>",
                success: function (result) {
                    if (result == "S") {
                        window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
                        AUIkit.init(document.getElementById('Atoast'), "Your password is reset. Login to continue.", 'success', '5000');
                        $("#login_email_reset").val("");
                        $("#LG").trigger('click')
                    }
                    else {
                        window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
                        AUIkit.init(document.getElementById('Atoast'), "Something is wrong. Try again later.", 'error', '5000');
                    }
                    $('#RP').removeAttr('disabled', 'disabled');
                }
            });
        } else {
            $(".login_email_reset_error").html("Email ID cannot be blank.");
            $(".login_email_reset_error").show();
        }
    });
    $('.pass').click(function () {
        if ($(this).attr('id') == "FP") {
            $('#Lgsection').addClass('hide');
            $('#Fpsection').removeClass('hide');
        }
        else if ($(this).attr('id') == "LG") {
            $('#Lgsection').removeClass('hide');
            $('#Fpsection').addClass('hide');
        }
        console.log($(this).attr('id'));
    });

    var url = '<?php echo Yii::app()->createUrl('site/sitepin') ?>';
    function pinchecking(form, data, hasError) {
        if (!hasError && pinvalidate()) {
            var categories = Array();
            var formData = new FormData($('#login-form')[0]);

            $.ajax({
                url: url,
                type: "post",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.req_status == "L") {

                        if (obj.ud_flag == "A") {
                            if (obj.user_type == "A" || obj.user_type == "TL" || obj.user_type == "M" || obj.user_type == "AM") {
                                window.location = '<?php echo Yii::app()->createUrl('userdetails/admin'); ?>';
                            } else if (obj.user_type == "R" || obj.user_type == "QC") {
                                window.location = '<?php echo Yii::app()->createUrl('fileinfo/indexalloc'); ?>';
                            } else if (obj.user_type == "C") {
                                window.location = '<?php echo Yii::app()->createUrl('fileinfo/admin'); ?>';
                            }
                        } else {
                            window.location = '<?php echo Yii::app()->createUrl('userdetails/userregupdate'); ?>';
                        }

                    }
                    else if(obj.req_status == "NL")
                    {
                        $('#LoginForm_ipin_em_').show().html('Pin is Incorrect');
                    }
                }
            });
        }
    }
    function pinvalidate() {
        var error = true;
        var pinval = $('#LoginForm_ipin').val();
        if(pinval =='')
        {
            $(this).next().addClass('error_cls');
            error = false;
            $('#LoginForm_ipin_em_').show().html('Pin is Required');

        }
        return error;
    }
</script>
</body>

</html>
