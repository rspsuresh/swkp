<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */
?>

<h1>Manage File Partitions</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-1-1">
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-active uk-width-1-3 tab_select" id="F"><a href="#">File List</a></li>
                    <li class="uk-width-1-3 tab_select" id="A"><a href="#">Allocation List</a></li>
                    <li class="uk-width-1-3 tab_select" id="C"><a href="#">Quality Control</a></li>
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="trn_from">
                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'file-partition-grid',
                                'template' => '{items}{summary}{pager}',
                                'afterAjaxUpdate' => 'js:function(){$("select[name=\'FilePartition[project]\']").chosen();}',
                                'dataProvider' => $model->editorsearch(),
                                'filter' => $model,
                                'columns' => array(
                                    // 'fp_part_id',
                                    array(
                                        'name' => 'project',
                                         'value' => '$data->FileInfo->ProjectMaster->p_name',
                                        'filter' => CHtml::dropDownList('FilePartition[project]', $model->project, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project')),
                                    ),
                                    array(
                                        'name' => 'filename',
                                        'value' => '$data->FileInfo->fi_file_name',
                                    ),
                                    /*array(
                                        'header' => 'Allocate',
                                        'value' => '$data->FileInfo->fi_file_name',
                                    ),*/
                                    array(
                                        'name' => 'fp_cat_id',
                                        'value' => '$data->Category->ct_cat_name',
                                    ),
                                ),
                            )); ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="F">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("select[name='FilePartition[project]']").chosen();
        $('.tab_select').click(function () {
            var id = $(this).attr('id');
            // Set id
            if (id == 'F') {
                $('#grid_tab').val('F');
            } else if (id == 'A') {
                $('#grid_tab').val('A');
            } else {
                $('#grid_tab').val('C');
            }
            $('.uk-tab-grid li').each(function () {
                $(this).removeClass('uk-active');
            });
            $(this).addClass('uk-active');
            $('#file-partition-grid').yiiGridView('update', {
                data: {status: $('#grid_tab').val()},
                complete: function (jqXHR, status) {

                }
            });
            return false;
        });
    });


    $('#fileinfoModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#fileinfoModal .uk-modal-header h3").html("");
            $("#fileinfoModal .uk-modal-content").html("");
            $('#file-info-grid').yiiGridView('update', {
                data: {}
            });
        }
    });
</script>
