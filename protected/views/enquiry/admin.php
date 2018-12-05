<?php
/* @var $this CategoryController */
/* @var $model Category */
?>

<h3 class="heading_b uk-margin-bottom">Manage Enquiry</h3>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-1-4">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <div class="uk-width-1-1">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'enquiry-grid',
                    'template' => '{items}{summary}{pager}',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        'eq_name',
                        'eq_mail',
                        'eq_created_dt',
                        array(
                            "header" => "Actions",
                            "value" => 'Enquiry::ActionButtons($data->eq_id)',
							'type' => 'raw',
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div id="categoryModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#categoryModal'}" style="display: none;"></button>
<script>
    function enquiryCreate() {
        $("#categoryModal .uk-modal-header h3").html("Enquiry Create");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('enquiry/create') ?>",
            type: "post",
            success: function (result) {
                $("#categoryModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function enquiryView(id) {
        $("#categoryModal .uk-modal-header h3").html("Enquiry View");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('enquiry/view') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#categoryModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function enquiryUpdate(id) {
        $("#categoryModal .uk-modal-header h3").html("Enquiry Update");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('enquiry/update') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#categoryModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
</script>