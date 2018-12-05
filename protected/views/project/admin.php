<?php
/* @var $this ProjectController */
/* @var $model Project */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#Project_p_flag').change(function(){
    var s=($(this).hasClass('inactive_record'))?'R':'A';
    $(this).toggleClass('inactive_record');
      $('#project-grid').yiiGridView('update', {
      data:{status:s}
    });
    return false;
});
");
?>
<h3 class="heading_b uk-margin-bottom">Manage Projects</h3>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-1-4">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <?php if (Yii::app()->session['user_type'] == "A") { ?>
                <div class="uk-width-medium-1-4">
                    <label for="Project_p_flag" class="inline-label">Inactive</label><!--switch_demo_small-->
                    <input type="checkbox" data-switchery data-switchery-size="large" id="Project_p_flag" name="Project[p_flag]" class="inactive_record" checked/>
                    <label for="Project_p_flag" class="inline-label">Active</label>
                </div>
                <div class="uk-width-medium-1-4">
                    <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick='projectCreate()' href="javascript:void(0)">Create</a>
                </div>
            <?php } ?>
            <div class="uk-width-1-1">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'project-grid',
                    'template' => '{items}{summary}{pager}',
                    'dataProvider' => $model->search(),
                    'afterAjaxUpdate' => 'js:function(){$("select[name=\'Project[p_client_id]\']").chosen();$("select[name=\'Project[p_op_format]\']").chosen();$("select[name=\'Project[p_key_type]\']").chosen();$("#Project_p_category_ids").chosen();gridResetOption();}',
                    'filter' => $model,
                    'htmlOptions' => array('style' => 'overflow-x: hidden !important; overflow-y: hidden;overflow:none;'),
                    'columns' => array(
                        //'p_pjt_id',
                        //'p_client_id',
                       /* array(
                            'name' => 'p_client_id',
                            'filter' => CHtml::dropDownList('Project[p_client_id]', $model->p_client_id, CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '5' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name'), array('empty' => 'Select client')),
                            'value' => '$data->UserMaster->ud_name',
                        ),*/
                        //'p_name',
                        //'p_op_format',
                        array(
                            'name' => 'p_name',
                            'htmlOptions' => array('style' => 'width:10%;white-space:pre-line;'),
                            'value' => function ($data) {
                                return $data->p_name;
                            }
                        ),
                        array(
                            'name' => 'template_id',
                            'filter' => CHtml::dropDownlist('Project[template_id]', $model->template_id, CHtml::listData(Templates::model()->findAll(), 'id', 't_name'), array('empty' => 'Select Template')),
                            'htmlOptions' => array('style' => 'width:10%;white-space:pre-line;'),
                            'value' => function ($data) {
                                if(!empty($data->template_id))
                                {
                                    return $data->template->t_name;
                                }
                                else
                                {
                                    return '-';
                                }

                            }
                        ),
                        //'p_key_type',
                       /* array(
                            'name' => 'p_key_type',
                            'filter' => CHtml::dropDownList('Project[p_key_type]', $model->p_key_type, array("M" => "Medical", "N" => "Non-Medical"), array('empty' => 'Select type')),
                            'value' => '($data->p_key_type == "M")?"Medical":"Non Medical"',
                        ),*/
                        array(
                            'name' => 'p_category_ids',
                            'filter' => CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and ct_cat_type='M'", 'order' => 'ct_cat_name')), 'ct_cat_id', 'ct_cat_name'),
                            'htmlOptions' => array('style' => 'width:10%;white-space:pre-line;'),
                            'value' => function ($data) {
                                return Category::getCategory($data->p_category_ids);
                            }
                        ),
                        array(
                            'name' => 'non_cat_ids',
                            'filter' => CHtml::dropDownlist('Project[non_cat_ids]', $model->non_cat_ids, CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and ct_cat_type='N'", 'order' => 'ct_cat_name')), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Non Category')),
                            'htmlOptions' => array('style' => 'width:10%;white-space:pre-line;'),
                            'value' => function ($data) {
                                return Category::getCategory($data->non_cat_ids);
                            }
                        ),
                        //  'p_category_ids',
                        /*
                          'p_created_date',
                          'p_last_modified',
                          'p_flag',
                         */
                        array(
                            "header" => "Actions",
                            "value" => 'Project::ActionButtons($data->p_pjt_id)'
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
<style>
    .ActionButtons {
        display: flex;
    }
    .grid-view table.items {
        display: table !important;

    }
   /* #project-grid
    {
         overflow: none !important;
    }*/
</style>
<script>
    $(document).ready(function () {
        $("select[name='Project[Project_template_id]").chosen();
        $("input[name='act_st']").on('change', function () {
            st = $(this).val();
            if (st == 'A') {
                $(this).val('R');
            }
            else if (st == 'R') {
                $(this).val('A');
            }
            $('#project-grid').yiiGridView('update', {
                data: {act_st: $(this).val()}
            });
        });
    });
    var projectModal = UIkit.modal("#projectModal");
    function projectCreate() {
        $("#projectModal .uk-modal-header h3").html("Project Create");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('project/create') ?>",
            type: "post",
            success: function (result) {
                $("#projectModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function projectView(id) {
        $("#projectModal .uk-modal-header h3").html("Project View");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('project/view') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#projectModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function projectUpdate(id) {
        $("#projectModal .uk-modal-header h3").html("Project Update");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('project/update') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#projectModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function projectRemove(id,action) {
        if(action==1)
        {
           var toast="Are you sure, you want to change the project status to inactive?";
        }
        else {
            var toast="Are you sure, you want to change the project status to active?";
        }
        UIkit.modal.confirm(toast, function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('project/remove') ?>/" + id,
                type: "post",
                success: function (result) {
                    $('#project-grid').yiiGridView('update', {
                        data: {}
                    });
                }
            });
        });
    }
    $('#projectModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#projectModal .uk-modal-header h3").html("");
            $("#projectModal .uk-modal-content").html("");
            $('#project-grid').yiiGridView('update', {
                data: {}
            });
        }
    });
</script>
