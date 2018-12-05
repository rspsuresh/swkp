<?php
/* @var $this SiteController */
/* @var $model UserDetails */
/* @var $form CActiveForm */
?>


<div class="md-card" id="login_card">
    <div class="md-card-content large-padding" id="login_form">
        <div class="login_heading">
            <div class="user_avatar"></div>
        </div>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'forget-password',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        )); ?>
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'newPassword'); ?>
            <?php echo $form->passwordField($model, 'newPassword', array("class" => "md-input")); ?>
            <?php echo $form->error($model, 'newPassword'); ?>
        </div>
        <div class="uk-form-row">
            <?php echo $form->labelEx($model, 'confirmPassword'); ?>
            <?php echo $form->passwordField($model, 'confirmPassword', array("class" => "md-input")); ?>
            <?php echo $form->error($model, 'confirmPassword'); ?>
        </div>
        <div class="uk-margin-medium-top">
            <?php echo CHtml::submitButton('Change Password', array("class" => "md-btn md-btn-primary md-btn-block md-btn-large")); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
