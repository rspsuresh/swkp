<?php
/* @var $this FormsBuilderController */
/* @var $model FormsBuilder */
/* @var $form CActiveForm */
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.js', CClientScript::POS_HEAD);
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.css', 'screen');
?>
<h3 class="heading_b uk-margin-bottom">Form Create</h3>
<div class="page_content_inner">
	<div class="md-card">
		<div class="md-card-content">
			<div class="form">

					<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'forms-builder-form',               
						'enableAjaxValidation' => false,
					));
					?>

						<div class="uk-grid">
							<div class="uk-width-medium-1-1">
								<div class="uk-form-row">
								<?php echo $form->labelEx($model, 'name'); ?>
								<?php echo $form->textField($model, 'name', array("class" => "md-input")); ?>
								<?php echo $form->error($model, 'name'); ?>
								</div>
							</div>
						</div>
						<div class="uk-grid">
							<div class="uk-width-medium-1-1">
								<div class="uk-form-row">
								<?php echo $form->labelEx($model, 'value'); ?>
								<?php echo $form->textArea($model, 'value',array("class" => "md-input")); ?>
								<?php echo $form->error($model, 'value'); ?>
								</div>
							</div>
						</div>	
						<div class="uk-grid">
							<div class="uk-width-medium-1-1">
								<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'formbut md-btn md-btn-success')); ?>
							</div>
						</div>
					<?php /*<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr><td colspan="2"><span class="note">Fields with <span class="required">*</span> are required.</span></td></tr>
						<tr><td colspan="2"><?php echo $form->errorSummary($model); ?></td></tr>
						<tr>

							<td width="30%"><?php echo $form->labelEx($model, 'name'); ?></td>
							<td><?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 250)); 
									  echo $form->error($model, 'name'); ?></td>
						</tr>
						<tr>
							<td><?php echo $form->labelEx($model, 'value'); ?></td>
							<td><?php echo $form->textArea($model, 'value',array('rows' => 6, 'cols' => 33)); 
									  echo $form->error($model, 'value'); ?></td>
						</tr>
						<tr>
							<td></td>
							<td><?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'formbut')); ?></td>
						</tr>

				</table> */ ?>
				<?php $this->endWidget(); ?>

			</div>
		</div>
	</div>	
</div>
	
<div id="projectModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-large" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#projectModal'}" style="display: none;"></button>
<style>
.fancybox-outer{padding:0 !important}
</style>
<script  type="text/javascript">
$(document).ready(function (e) {
	$("#FormsBuilder_value").on("focusin",function(){		
		$.ajax({
					type: "POST",
					url: "<?php echo Yii::app()->request->baseUrl . '/formbuilder/formsBuilder/builder'; ?>",
					data: "json="+$(this).val(),                       
					success: function (data) 
					{
						$("#projectModal .uk-modal-content").html(data);
						$("#triggerModal").trigger("click");
				
						/*$.fancybox(data,
						{
							"width": 745,
							"height": 700,
							"autoSize": false,
							"transitionIn": "elastic",
							"transitionOut": "elastic",
							"speedIn": 600,
							"speedOut": 200,
							"overlayShow": false,
							"hideOnContentClick": false,
							"afterClose": function () 
							{								
						       $("#FormsBuilder_value").val($("#formJson").val());
							}
						});*/
					}
			  });
	});
	
	$('#projectModal').on({
		'hide.uk.modal': function(){
			$("#FormsBuilder_value").val($("#formJson").val());
			if($("#formJson").val() !== ""){
				$("#FormsBuilder_value").closest('.md-input-wrapper').addClass('md-input-filled');
			}
		}
	});
});
</script>
