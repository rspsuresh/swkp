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
                <h2>LOGIN</h2>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'action' => Yii::app()->createUrl("site/login"),
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
            ));
            ?>
            <div class="row">
                <!--<div class="col-md-12">-->
                <!--<div class="row">-->
                <div class="col-md-8 col-sm-8 col-md-offset-2 scrollpoint sp-effect1">
                    <!--<form role="form">-->
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'username'); ?>
                        <?php echo $form->textField($model, 'username', array("class" => "form-control")); ?>
                        <?php echo $form->error($model, 'username'); ?>
                        <!--<input type="text" class="form-control" placeholder="Your name">-->
                    </div>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'password'); ?>
                        <?php echo $form->passwordField($model, 'password', array("class" => "form-control")); ?>
                        <?php echo $form->error($model, 'password'); ?>
                        <!--<input type="email" class="form-control" placeholder="Your email">-->
                    </div>
                    <!--<button type="submit" class="">Submit</button>-->
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
                    <!--</form>-->
                </div>
            </div>
        </div>
</div>
<?php $this->endWidget(); ?>
</div>
</section>
<!--login End -->
<!--Request chenge password-->
<section id='Fpsection' class="hide">
    <div class="container" style="width:50%;">
        <div class="section-heading scrollpoint sp-effect3">
            <h2>Reset Password</h2>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'resetPasswordForm',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="row">
            <!--                        <div class="col-md-12">
                                        <div class="row">-->
            <div class="col-md-8 col-sm-8 col-md-offset-2 scrollpoint sp-effect1">
                <!--<form role="form">-->
                <div class="form-group">
                    <label for="login_email_reset" class="required">Email ID <span class="required">*</span></label>
                    <input type="email" id="login_email_reset" name="login_email_reset" class="form-control"/>
                    <span class="login_email_reset_error" style="display:none;color:#fb4646;"></span>
                </div>
                <div class="form-group">
                    <?php echo CHtml::submitButton('Reset password', array("class" => "btn btn-primary btn-lg pass", "id" => "RP")); ?>
                </div>
                <div class="form-group centrebtn">
                    <div class="col-md-12">
                        <?php echo CHtml::link('Login account?', '#LG', array("class" => "pass", "id" => "LG")); ?>
                    </div>

                </div> 
            </div>
            <!--                            </div>
                                    </div>-->
        </div>
        <?php $this->endWidget(); ?>
    </div>
</section>
<!--Request chenge password end -->
<!--Reset password-->
<section id="Rpsection" class="hide">
    <div class="container">
        <div class="section-heading scrollpoint sp-effect3">
            <h2>Reset Password</h2>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'forget-password',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8 col-sm-8 scrollpoint sp-effect1">
                        <!--<form role="form">-->
                        <div class="form-group">
                            <?php echo $form->labelEx($userdetail, 'newPassword'); ?>
                            <?php echo $form->passwordField($userdetail, 'newPassword', array("class" => "form-control")); ?>
                            <?php echo $form->error($userdetail, 'newPassword'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo $form->labelEx($userdetail, 'confirmPassword'); ?>
                            <?php echo $form->passwordField($userdetail, 'confirmPassword', array("class" => "form-control")); ?>
                            <?php echo $form->error($userdetail, 'confirmPassword'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::submitButton('Change Password', array("class" => "btn btn-primary btn-lg pass", "id" => "CP")); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</section>
<!--Reset password-->

</div>
<div id="notify_alert">
    test
</div>

<script>
    $(document).ready(function () {
        appMaster.preLoader();

        <?php if (!empty($_GET["msg"])) : ?>
        window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
        AUIkit.init(document.getElementById('Atoast'), "Check your Registered mail to activate your account", 'success', '5000');
        <?php endif; ?>

        <?php if (!empty($_GET["ajaxtimeout"])) : ?>
        window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
        AUIkit.init(document.getElementById('Atoast'), "Your Session has been expired.", 'success', '5000');
        <?php endif; ?>

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
</script>
</body>

</html>
