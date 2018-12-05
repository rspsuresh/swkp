<?php
/* @var $this FormsBuilderController */
/* @var $model FormsBuilder */
?>

<h3 class="heading_b uk-margin-bottom">Manage Forms</h3>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-1-8">
            </div>
                <div class="uk-width-medium-1-4">
                    <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" href="<?php echo Yii::app()->createUrl('formbuilder/formsBuilder/create'); ?>">Create</a>
                </div>
            <div class="uk-width-1-1">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'forms-builder-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                   // 'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/newgrid.css'),
                   // 'cssFile' => Yii::app()->baseUrl . '/css/newgrid.css',
                    'htmlOptions' => array('class' => 'grid-view clear'),
                   'columns'=>array(
//		'id',
		'name',
		'value',
           
		 array('header' => 'Actions',
                            'class' => 'CButtonColumn',
                            'deleteConfirmation' => "Do you want to delete this form?",
                            'buttons' => array(
                            ),
                            'template'=>'&nbsp{update}&nbsp{delete}',
                        ),
	),

                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div id="projectModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#projectModal'}" style="display: none;"></button>

<script>
    $(document).ready(function () {
	
	});
	
		function formCreate() {
			$("#projectModal .uk-modal-header h3").html("Form Create");
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('formbuilder/formsBuilder/create') ?>",
				type: "post",
				success: function (result) {
					$("#projectModal .uk-modal-content").html(result);
					$("#triggerModal").trigger("click");
				}
			});
		}
</script>	

