<?php
/* @var $this CategoryController */
/* @var $model Category */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#Category_ct_flag').change(function(){
    var s=($(this).hasClass('inactive_record'))?'I':'A';
    $(this).toggleClass('inactive_record');
      $('#category-grid').yiiGridView('update', {
      data:{status:s}
    });
    return false;
});
");
?>

<h3 class="heading_b uk-margin-bottom">Manage Categories</h3>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-1-4">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <div class="uk-width-medium-1-4">
                <label for="Category_ct_flag" class="inline-label">Inactive</label><!--switch_demo_small-->
                <input type="checkbox" data-switchery data-switchery-size="large" id="Category_ct_flag" name="Category[ct_flag]" class="inactive_record" checked/>
                <label for="Category_ct_flag" class="inline-label">Active</label>
            </div>
            <div class="uk-width-medium-1-4">
                <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick='categoryCreate()' href="javascript:void(0)">Create</a>
            </div>
            <div class="uk-width-1-1">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'category-grid',
                    'template' => '{items}{summary}{pager}',
                    'dataProvider' => $model->search(),
                    'afterAjaxUpdate' => 'js:function(){$("select[name=\'Category[ct_cat_id]\']").chosen();$("select[name=\'Category[ct_cat_type]\']").chosen();gridResetOption();}',
                    'filter' => $model,
                    'columns' => array(
                        //    'ct_cat_id',
                        // 'ct_cat_name',
                        array(
                            'name' => 'ct_cat_name',
                            'filter' => CHtml::dropDownList('Category[ct_cat_id]', $model->ct_cat_id, CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag= 'A'", 'order' => 'ct_cat_name')), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Name')),
                        ),
                        array(
                            'name' => 'ct_keywords',
                        ),
                        array(
                            'name' => 'ct_cat_type',
                            'filter' => CHtml::dropDownList('Category[ct_cat_type]', $model->ct_cat_type, array("M" => "Medical", "N" => "Non-Medical"), array('empty' => 'Select type')),
                            'value' => '($data->ct_cat_type == "M")?"Medical":"Non Medical"',
                        ),
                        // 'ct_keywords',
                        //'ct_cat_type',
                        // 'ct_created_date',
                        //'ct_last_modified',
                        /* 'ct_flag',
                         */
                        array(
                            "header" => "Actions",
                            "value" => 'Category::ActionButtons($data->ct_cat_id)',
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
<style>
    .ActionButtons {
        display: flex;
    }
    .grid-view table.items {
        display: table !important;
        white-space: nowrap;
    }
</style>

<script>
    $(document).ready(function () {
        $("select[name='Category[ct_cat_id]']").chosen();
        $("select[name='Category[ct_cat_type]").chosen();

        $("input[name='act_st']").on('change', function () {
            st = $(this).val();
            if (st == 'A') {
                $(this).val('R');
            }
            else if (st == 'R') {
                $(this).val('A');
            }
            $('#category-grid').yiiGridView('update', {
                data: {act_st: $(this).val()}
            });
        });
    });
    var categoryModal = UIkit.modal("#categoryModal");
    function categoryCreate() {
        $("#categoryModal .uk-modal-header h3").html("Category Create");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('category/create') ?>",
            type: "post",
            success: function (result) {
                $("#categoryModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function categoryView(id) {
        $("#categoryModal .uk-modal-header h3").html("Category View");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('category/view') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#categoryModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function categoryUpdate(id) {
        $("#categoryModal .uk-modal-header h3").html("Category Update");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('category/update') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#categoryModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function categoryRemove(id) {
        UIkit.modal.confirm("Are you sure?", function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('category/remove') ?>/" + id,
                type: "post",
                success: function (result) {
                    $('#category-grid').yiiGridView('update', {
                        data: {}
                    });
                }
            });
        });
    }
    $('#categoryModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#categoryModal .uk-modal-header h3").html("");
            $("#categoryModal .uk-modal-content").html("");
            $('#category-grid').yiiGridView('update', {
                data: {}
            });
        }
    });
</script>