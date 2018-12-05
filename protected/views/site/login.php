<?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
<link rel="stylesheet" href="<?php echo $path . "assets/js/Anotify/Anotify.css"; ?> " media="all">
<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
?>


<div class="md-card" id="login_card">
    <div class="md-card-content large-padding" id="login_form">
        <div class="login_heading">
            <div class="user_avatar"></div>
        </div>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'action' => Yii::app()->createUrl("site/login"),
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array("class" => "md-input")); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array("class" => "md-input")); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="uk-margin-medium-top">
            <?php echo CHtml::submitButton('Login', array("class" => "md-btn md-btn-primary md-btn-block md-btn-large")); ?>
        </div>
        <div class="uk-margin-top">
            <a href="#" id="login_help_show" class="uk-float-right">Need help?</a>
            <span class="icheck-inline">
                <?php echo $form->checkBox($model, 'rememberMe', array("data-md-icheck" => "")); ?>
                <?php echo $form->label($model, 'rememberMe'); ?>
                <?php echo $form->error($model, 'rememberMe'); ?>
            </span>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
        <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
        <h2 class="heading_b uk-text-success">Can't log in?</h2>
        <p>Here’s the info to get you back in to your account as quickly as possible.</p>
        <p>First, try the easiest thing: if you remember your password but it isn’t working, make sure that Caps Lock is turned off, and that your username is spelled correctly, and then try again.</p>
        <p>If your password still isn’t working, it’s time to
            <a href="#" id="password_reset_show">reset your password</a>.</p>
    </div>
    <div class="md-card-content large-padding" id="login_password_reset" style="display: none">
        <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
        <h2 class="heading_a uk-margin-large-bottom">Reset password</h2>
        <form id="resetPasswordForm">
            <div class="uk-form-row">
                <label for="login_email_reset">Your email address</label>
                <input class="md-input" type="text" id="login_email_reset" name="login_email_reset"/>
            </div>
            <div class="uk-margin-medium-top">
                <button type="submit" class="md-btn md-btn-primary md-btn-block">Reset password</button>
            </div>
        </form>
    </div>
    <div class="md-card-content large-padding" id="register_form" style="display: none">
        <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
        <h2 class="heading_a uk-margin-medium-bottom">Create an account</h2>
        <?php
        $form1 = $this->beginWidget('CActiveForm', array(
            'id' => 'user-details-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'action' => Yii::app()->createUrl("userdetails/clientcreate"),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
            )
        ));
        ?>
        <div>
            <div class="uk-form-row">
                <?php echo $form1->labelEx($userdetail, 'ud_username'); ?>
                <?php echo $form1->textField($userdetail, 'ud_username', array("class" => "md-input")); ?>
                <?php echo $form1->error($userdetail, 'ud_username'); ?>
            </div>
            <div class="uk-form-row">
                <?php echo $form1->labelEx($userdetail, 'newPassword'); ?>
                <?php echo $form1->passwordField($userdetail, 'newPassword', array("class" => "md-input")); ?>
                <?php echo $form1->error($userdetail, 'newPassword',"",false); ?>
            </div>
            <div class="uk-form-row">
                <?php echo $form1->labelEx($userdetail, 'confirmPassword'); ?>
                <?php echo $form1->passwordField($userdetail, 'confirmPassword', array("class" => "md-input")); ?>
                <?php echo $form1->error($userdetail, 'confirmPassword',"",false); ?>
            </div>
            <div class="uk-form-row">
                <?php echo $form1->labelEx($userdetail, 'ud_email'); ?>
                <?php echo $form1->textField($userdetail, 'ud_email', array("class" => "md-input")); ?>
                <?php echo $form1->error($userdetail, 'ud_email'); ?>
            </div>
            <?php echo $form1->hiddenField($userdetail, 'ud_usertype_id', array("value" => "5")); ?>
            <?php echo $form1->hiddenField($userdetail, 'ud_flag', array("value" => "I")); ?>
            <div class="uk-margin-medium-top">
                <?php echo CHtml::submitButton('Create My Account', array('id' => 'submit_signup', 'class' => 'md-btn md-btn-primary md-btn-block md-btn-large')); ?>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<div class="uk-margin-top uk-text-center">
    <a href="#" id="signup_form_show">Create an account</a>
</div>
<div id="Atoast" class="Atoastanimate">
    <div>
        <span id="ATInnerSpan"></span>
        <a href="javascript:void(0)" class="notify-action" id="ATanchor"><i class="uk-icon-close"></i></a>
    </div>
</div>
<script src="<?php echo $path . "assets/js/Anotify/Anotify.js"; ?>"></script>
<script>
    $(document).ready(function () {

        <?php if (!empty($_GET["passchange"])) { ?>

        window.history.pushState("", "", "login");
        UIkit.notify({
            message: 'Your password has been changed.',
            status: 'success',
            timeout: 5000,
            pos: 'top-right'
        });

        <?php }?>

        $("#resetPasswordForm").submit(function (e) {
            e.preventDefault();
            // show preloader
            altair_helpers.content_preloader_show('regular');
            var data = $("#resetPasswordForm").serialize();
            $.ajax({
                type: "POST",
                data: data,
                url: "<?php echo Yii::app()->createUrl('site/forgetpassword') ?>",
                success: function (result) {
                    if (result == "S") {
                        // hide preloader
                        altair_helpers.content_preloader_hide();
                        UIkit.notify({
                            message: 'Check your email for further information',
                            status: 'success',
                            timeout: 5000,
                            pos: 'top-right'
                        });
                        $("#login_email_reset").val("");
                    }
                    else {
                        UIkit.notify({
                            message: 'Invalid Email',
                            status: 'error',
                            timeout: 3000,
                            pos: 'top-right'
                        });
                    }
                }
            });
        });

    });
    function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: ' <?php echo Yii::app()->createUrl("userdetails/clientcreate"); ?> ',
                type: "POST",
                data: $("#user-details-form").serialize(),
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S") {
                        $('.back_to_login')[0].click();
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