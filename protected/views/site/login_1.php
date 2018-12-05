<style>
    /*    .input-field label {
            left: 0rem !important;
        }*/

    #yw0 {
        vertical-align: -11px;
    }
    input[type=text]:focus, input[type=password]:focus, input[type=email]:focus {
        border-bottom: 1px solid #62D3FD !important;
    }
    .custom_radio span {
        width: 100%;
        border: 1px solid #FDA961;
        display: block;
        border-radius: 4px;
    }
    .custom_radio label {
        width: 49.5% !important;
        display: inline-block !important;
        text-align: center;
        font-weight: bold;
    }
    .switchRadio:nth-child(2) {
        float: right;
    }
    #login_div, #signup_div, #forgot_pswd_div {
        padding: 1px 20px 1px 20px;
    }
    [type="radio"]:checked + label {
        background: #FDA961;
        color: #fff !important;
    }
    [type="radio"]:not(:checked) + label, [type="radio"]:checked + label {
        height: auto;
        padding: 4px 0 !important;
        position: none !important;
    }
    [type="radio"] + label:before, [type="radio"] + label:after {
        margin: 0;
        height: 0;
        width: 0;
        position: inherit;
        content: none;
    }
</style>
<?php
if (isset($_GET['type']) && $_GET['type'] == "signup") {
    $loginstyle = 'class="hide z-depth-1"';
    $signupstyle = 'class="z-depth-1"';
    $forgot_pwd = 'class="hide z-depth-1"';
} else if (isset($_GET['type']) && $_GET['type'] == "forgotpwd") {
    $loginstyle = 'class="hide z-depth-1"';
    $signupstyle = 'class="hide z-depth-1"';
    $forgot_pwd = 'class=" z-depth-1"';
} else {
    $loginstyle = 'class="z-depth-1"';
    $signupstyle = 'class="hide z-depth-1"';
    $forgot_pwd = 'class="hide z-depth-1"';
}
?>
<div class="col s12 m4 offset-m4" style="min-height:360px; margin-top:30px; margin-bottom:30px;">

    <div id="login_div" <?php echo $loginstyle; ?>>
        <h2 class="center">Sign In</h2>
        <div class="form">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'focus' => array($model, 'username'),
                'action' => Yii::app()->createUrl("site/login"),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'afterValidate' => 'js:function(form, data, hasError) {
                       if(!hasError){
                            var date = new Date();
                            var dbTime = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                            $("#userLocalSystemDT").val(dbTime);
                            return true;
                       }
                    }'
                ),
            ));
            ?>
            <div>
                <?php echo $form->labelEx($model, 'username'); ?>
                <?php echo $form->textField($model, 'username', array("placeholder" => "Username")); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>

            <div>
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password', array("placeholder" => "Password")); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>

            <?php if ($model->scenario == 'withCaptcha' && CCaptcha::checkRequirements()): ?>
                <div class="captcha" style="vertical-align:middle"><?php $this->widget('CCaptcha'); ?></div>
                <div>

                    <?php echo $form->labelEx($model, 'verifyCode'); ?>

                    <?php echo $form->textField($model, 'verifyCode'); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php echo CHtml::submitButton('Login', array('class' => 'btn-fullwidth btn waves-effect waves-light orange')); ?>
            </div>
            <input type="hidden" id="userTimeZone" name="userTimeZone" value="">
            <input type="hidden" id="userLocalSystemDT" name="userLocalSystemDT" value="">
            <div class="row">
                <a href="#" id="forgotpassword" class="link left">Forgot password?&nbsp;</a>
                <a href="#" id="signup" class="link right">Create an account</a>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
    <div id="signup_div" <?php echo $signupstyle; ?>>
        <h2 class="center">Sign Up</h2>
        <?php
        $form1 = $this->beginWidget('CActiveForm', array(
            'id' => 'registration_signup_form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'action' => Yii::app()->createUrl("site/login"),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form, data, hasError) { Save_datas(form, data, hasError); }'
            ),
        ));
        ?>
        <div>
            <?php // echo $form1->labelEx($userdetail, 'ud_email_id'); ?>
            <?php // echo $form1->textField($userdetail, 'ud_email_id', array("class" => "text_style form-control", "placeholder" => "Email ID")); ?>
            <?php // echo $form1->error($userdetail, 'ud_email_id'); ?>
        </div>

<!--        <div class="row" style="margin-bottom: 10px;">
            <div class="col s6">
                <?php // $this->widget('CCaptcha', array("id" => "CaptchaID", "clickableImage" => true, "showRefreshButton" => false, "imageOptions" => array("style" => "padding-top:10px", "data-position" => "right", "data-delay" => "50", "data-tooltip" => "Click to refresh", "class" => "tooltipped"))); ?>
            </div>
            <div class="col s6">
                <?php // echo $form1->labelEx($userdetail, 'verifyCode', array('for' => 'LoginForm_verifyCode')); ?>
                <?php // echo $form1->textField($userdetail, 'verifyCode', array('class' => 'text_style  form-control')); ?>
            </div>
            <?php // echo $form1->error($userdetail, 'verifyCode', array('class' => 'errorMessage')); ?>
        </div>

        <div class="custom_radio row">
            <?php
//            $userdetail->ud_type = 'S';
//            if (isset($_GET['reg_type'])) {
//                if ($_GET['reg_type'] == 'tutor')
//                    $userdetail->ud_type = 'T';
//            }
//            echo $form1->radioButtonList($userdetail, 'ud_type', array('T' => 'Tutor', 'S' => 'Student'), array(
//                'labelOptions' => array('class' => 'switchRadio waves-effect waves-light'), // add this code
//                'separator' => '  ',
//            ));
            ?>
        </div>-->
        <div class="row">
            <?php echo CHtml::submitButton('Create My Account', array('id' => 'submit_signup', 'class' => 'btn btn-fullwidth orange waves-effect waves-light')); ?>
        </div>
        <div class="row center">
            Already have a Perigon Edu account? <a href="#" id="login_page" class="link">Login here</a>
        </div>

        <?php $this->endWidget(); ?>
    </div>
    <div id="forgot_pswd_div" <?php echo $forgot_pwd; ?>>
        <h2 class="center">Reset Password</h2>
        <form id="forgot_pswd">
            <div style="margin-bottom: 12px;">
                <label for="emailid">Email ID *</label>
                <input type="email" id="emailid" name="emailid" placeholder="Email ID">
                <span class="email_error" style="display:none;color:#ef5350;"></span>
            </div>
            <div class="row">
                <?php echo CHtml::submitButton('Reset password', array('id' => 'submit_pswd', 'class' => 'btn btn-fullwidth orange waves-effect waves-light')); ?>
            </div>
            <div class="row center">
                <a href="#" id="login" class="link">Login</a>
            </div>
        </form>
    </div>
</div>
<?php
// click refresh button on page load
Yii::app()->clientScript->registerScript('refresh-captcha',
    '$("#CaptchaID").trigger("click");');
?>
<script>
    $(document).ready(function () {
        <?php if (!empty($_GET["flag"])) : ?>
        window.history.pushState("", "", "login");
        <?php endif; ?>
        <?php if (!empty($_GET["status"])) { ?>
        window.history.pushState("", "", "login");
        <?php
        Yii::app()->user->logout();
        switch ($_GET["status"]) {
            case "WFP":
                echo "ShowMsg('You have already activated your account. Please wait for administrator to activate your account.','S',7000);";
                break;
            case "A":
                echo "ShowMsg('You have already activated your account. Login to continue.','S',5000);";
                break;
            case "E":
                echo "ShowMsg('This link already expired. Contact the site administrator.','E',5000);";
                break;
            case "REG":
                echo "ShowMsg('Your details has been saved successfully. Please wait for administrator to activate your account.','S',7000);";
                break;
            case "SREG":
                echo "ShowMsg('Your details has been saved successfully. Login to continue.','S',7000);";
                break;
        }
        }
        ?>
        $("#userTimeZone").val(createOffset());
        $('#emailid').keyup(function () {
            $(".email_error").html('');
        });
        $('#forgot_pswd').on('submit', function (e) {
            e.preventDefault();
            if ($("#emailid").val() != "") {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("site/forgotpassword"); ?>",
                    type: 'POST',
                    data: $("#forgot_pswd").serialize(),
                    success: function (result) {
                        var res = $.parseJSON(result);
                        if (res.status == "S") {
                            ShowMsg("Reset password link has been sent to your mail.", "S", 2000);
                            $('#forgot_pswd')[0].reset();
                            $(".email_error").html('');
                        } else {
                            $(".email_error").html(res.msg);
                            $(".email_error").show();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                        //show_flash_msg('Mail is not send successfully!', 'E');
                        return false;
                    }
                });
            } else {
                $(".email_error").html("Email Id cannot be blank.");
                $(".email_error").show();
            }
        });


        $('.link').on('click', function () {
            var id = $(this).attr('id');
            if (id == "login" || id == "login_header" || id == "login_page") {
                $('#login-form')[0].reset();
                $('#signup_div').addClass('hide');
                $('#forgot_pswd_div').removeClass('animated zoomIn');
                $('#forgot_pswd_div').addClass('animated zoomOut hide');
                $('#login_div').removeClass('hide');
                $('#forgot_pswd_div').removeClass('animated zoomOut');
                $('#login_div').addClass('animated zoomIn');
            } else if (id == "forgotpassword" || id == "forgotpassword_head") {
//                $("#forgot_pswd")[0].reset();
                $(".email_error").hide();
                $('#signup_div').addClass('hide');
                $('#login_div').removeClass('animated zoomOut');
                $('#login_div').removeClass('animated zoomIn');
                $('#login_div').addClass('animated zoomOut hide');
                $('#forgot_pswd_div').removeClass('hide zoomOut');
                $('#login_div').removeClass('animated zoomOut');
                $('#forgot_pswd_div').addClass('animated zoomIn');
            } else if (id == "signup" || id == "signuplink") {
                $('#registration_signup_form')[0].reset();
                $('#login_div').removeClass('animated zoomOut');
                $('#login_div').removeClass('animated zoomIn');
                $('#login_div').addClass('animated zoomOut hide');
                $('#forgot_pswd_div').addClass('animated zoomOut hide');
                $('#signup_div').removeClass('hide');
                $('#login_div').removeClass('animated zoomOut');
                $('#signup_div').addClass('animated zoomIn');
            }
        });

        <?php if (Yii::app()->user->getState('attempts-login') > 3) { ?>
        $("#yw0_button")[0].click();
        <?php } ?>

        return false;
    });
    function pad(value) {
        return value < 10 ? '0' + value : value;
    }
    function createOffset(date) {
        date = new Date();
        var sign = (date.getTimezoneOffset() > 0) ? "-" : "+";
        var offset = Math.abs(date.getTimezoneOffset());
        var hours = pad(Math.floor(offset / 60));
        var minutes = pad(offset % 60);
        return sign + " " + hours + " hour " + sign + minutes + " minutes";
    }
    function Save_datas(form, data, hasError) {

        if (hasError == false) {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl("site/websiteregister"); ?>",
                type: "POST",
                data: $("#registration_signup_form").serialize(),
                success: function (res) {
                    if (res == "S") {
                        $("#UserDetails_ud_email_id").val('');
                        $("#login_page").trigger("click");
                        $("#CaptchaID").trigger("click");
                        ShowMsg("Successfully Registered. Please check your registered mail", "S", 5000);
                    } else {
                        ShowMsg("Not Registered.", "E", 5000);
                    }
                }
            });
        }
    }
</script>