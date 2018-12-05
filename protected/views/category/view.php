<?php
/* @var $this CategoryController */
/* @var $model Category */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/detailview/styles.css">
<div class="" id="table">
	<table class="detail-view" id="yw0">
        <tbody>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'ct_cat_name',
				'ct_keywords',
				//'ct_cat_type',
				array(
				'name' => 'ct_cat_type',
				'value' => ($model->ct_cat_type == "M")?"Medical":"Non Medical",
				),
			),
		)); ?>
		</tbody>
	</table>
</div>	
