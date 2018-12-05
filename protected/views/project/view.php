<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/detailview/styles.css">
<div class="" id="table">
	<table class="detail-view" id="yw0">
        <tbody>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'p_client_id',
				array(
					'name' => 'p_client_id',
					'value' => isset($model->UserMaster->ud_name)?$model->UserMaster->ud_name:'',
				),
				'p_name',
				'p_op_format',
				array(
				'name' => 'p_key_type',
				'value' => ($model->p_key_type == "M")?"Medical":" Medical and Non Medical",
				),
				//'p_key_type',
				array(
					'name' => 'p_category_ids',
					'value' => Category::getCategory($model->p_category_ids),
				),
                array(
                    'name' => 'non_cat_ids',
                    'value' => Category::getCategory($model->non_cat_ids),
                ),
				//'p_category_ids',
			),
		)); ?>
		</tbody>
	</table>
</div>	

