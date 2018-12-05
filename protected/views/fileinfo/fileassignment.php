<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
/* @var $form CActiveForm */
$rev_dropdwn = array();
if(Yii::app()->session['user_type'] == "A"){
	$rev_dropdwn = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name');
}
else if(Yii::app()->session['user_type'] == "TL"){
	$rev_dropdwn = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_teamlead_id= '".Yii::app()->session['user_id']."'&& ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name');
}
?>
<?php Yii::app()->clientScript->scriptMap['jquery.js'] = false; ?>
<ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#assign_tab'}">
	<li class="uk-width-1-2 uk-active" ><a href="#">With Prepping</a></li>
    <li class="uk-width-1-2" ><a href="#">Skip Prepping</a></li>
</ul>
<ul id="assign_tab" class="uk-switcher uk-margin">
<li>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'joballocation-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
        )
    )); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'indexer_id'); ?>
                <?php echo $form->dropDownList($model, 'indexer_id',
                    $rev_dropdwn,
                    array('class' => 'md-input', 'empty' => 'Select Reviewer')); ?>
                <?php echo $form->error($model, 'indexer_id'); ?>
            </div>
            <div class="uk-width-medium-1-2">
                <?php echo $form->labelEx($model, 'splitter_id'); ?>
                <?php echo $form->dropDownList($model, 'splitter_id',
                    $rev_dropdwn,
                    array('class' => 'md-input', 'empty' => 'Select Reviewer')); ?>
                <?php echo $form->error($model, 'splitter_id'); ?>
            </div>
        </div>
		<div class="uk-grid">
            <div class="uk-width-medium-1-3">
				<?php echo CHtml::checkBox('prepSkip', false, array('id'=>'prepSkip')); ?><span>Skip Prepping QC</span>
			</div>
			<div class="uk-width-medium-1-3">
				<?php echo CHtml::checkBox('splitSkip', false, array('id'=>'splitSkip')); ?><span>Skip DateCoding QC</span>
			</div>
			<div class="uk-width-medium-1-3">
				<?php echo CHtml::checkBox('editorSkip', false, array('id'=>'editorSkip')); ?><span>Skip Editor QC</span>
			</div>
			<?php echo CHtml::hiddenField('fi_prep' , '0', array('id' => 'fi_prep')); ?>
		</div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton('Assign', array('class' => 'md-btn md-btn-success')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</li>
<li>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'non-joballocation-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
        )
    )); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="uk-form-row">
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo $form->labelEx($model, 'splitter_id'); ?>
                <?php echo $form->dropDownList($model, 'splitter_id',
                    $rev_dropdwn,
                    array('class' => 'md-input', 'empty' => 'Select Reviewer')); ?>
                <?php echo $form->error($model, 'splitter_id'); ?>
            </div>
        </div>
		<div class="uk-grid">
			<div class="uk-width-medium-1-2">
				<?php echo CHtml::checkBox('splitSkip', false, array('id'=>'splitSkip')); ?><span>Skip DateCoding QC</span>
			</div>
			<div class="uk-width-medium-1-2">
				<?php echo CHtml::checkBox('editorSkip', false, array('id'=>'editorSkip')); ?><span>Skip Editor QC</span>
			</div>
			<?php echo CHtml::hiddenField('fi_prep' , '1', array('id' => 'fi_prep')); ?>
		</div>
        <div class="uk-grid">
            <div class="uk-width-medium-1-1">
                <?php echo CHtml::submitButton('Assign', array('class' => 'md-btn md-btn-success')); ?>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
</li>
</ul>
<script>
    $(document).ready(function () {
        $("#JobAllocation_indexer_id").chosen();
        $("#joballocation-form #JobAllocation_splitter_id").chosen();
        $("#non-joballocation-form #JobAllocation_splitter_id").chosen();
    });

    url = '<?php echo Yii::app()->createUrl("fileinfo/fileassignment?id=".urlencode($_GET['id'])); ?>';
    function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: url,
                type: "POST",
                data: $("#"+form.attr('id')).serialize(),
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
						$("#fileAssignment").css('visibility','hidden');
                    }
                }
            });
        }
    }
</script>

