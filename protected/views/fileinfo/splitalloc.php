<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
?>

<h1>Manage Splitting</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-active uk-width-1-2 tab_select" id="P"><a href="#">File List</a></li>
                    <li class="uk-width-1-2 tab_select" id="A"><a href="#">Allocation List</a></li>
                    <!--<li class="uk-width-1-3 tab_select" id="C"><a href="#">Completed list</a></li>-->
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="trn_from">
                            <?php } ?>
                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'file-info-grid',
                                'dataProvider' => $model->search(),
                                'afterAjaxUpdate' => 'js:function(){$("select[name=\'FileInfo[fi_pjt_id]\']").chosen();}',
                                'filter' => $model,
                                'columns' => array(
                                    //  'fi_file_id',
                                    //  'fi_pjt_id',
                                    array(
                                        'name' => 'fi_pjt_id',
                                        'value' => '$data->ProjectMaster->p_name',
                                        'filter' => CHtml::dropDownList('FileInfo[fi_pjt_id]', $model->fi_pjt_id, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project')),
                                    ),
                                    'fi_file_name',
                                    'fi_file_ori_location',
                                    'fi_file_completed_location',
                                    // 'fi_file_uploaded_date',
                                    /*
                                    'fi_file_completed_time',
                                    'fi_status',
                                    'fi_created_date',
                                    'fi_last_modified',
                                    'fi_flag',
                                    */
                                    array(
                                        "header" => "Splitter",
                                        //'visible' => '(!empty(FileInfo::GetName($data->JobAllocation->ja_splitter_id,$data->JobAllocation->ja_status)))?true:false',
                                        "value" => 'FileInfo::GetName($data->JobAllocation->ja_splitter_id,$data->JobAllocation->ja_status)',
                                    ),
                                    array(
                                        "header" => "Actions",
                                        "value" => 'FileInfo::ActionButton($data->fi_file_id,Yii::app()->session["user_type"],$data->JobAllocation->ja_job_id,$data->JobAllocation->ja_status,(isset($data->FilePartition->fp_part_id))?$data->FilePartition->fp_part_id:"")',
                                    ),
                                ),
                            )); ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="IC">
                            <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                        </form>
                    </li>
                </ul>
            <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="fileinfoModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#fileinfoModal'}" style="display: none;"></button>
<style>
    .ActionButtons {
        display: flex;
    }
    .grid-view table.items {
        white-space: nowrap;
    }
</style>

<script>
    $(document).ready(function () {
        <?php if (!empty($_GET["showMsg"])) : ?>
        window.history.pushState("", "", "indexalloc");
        UIkit.notify({
            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> <?php echo $_GET['showMsg'] ?>",
            status: "success",
            timeout: 10000,
            pos: 'top-right'
        });
        <?php endif; ?>
        $("select[name='FileInfo[fi_pjt_id]']").chosen();

        $('.tab_select').click(function () {
            var id = $(this).attr('id');
            // Set id
            if (id == 'P') {
                $('#grid_tab').val('IC');
            }
            else if (id == "A") {
                $('#grid_tab').val('SA');
            }

            $('.uk-tab-grid li').each(function () {
                $(this).removeClass('uk-active');
            });

            $(this).addClass('uk-active');
            $('#file-info-grid').yiiGridView('update', {
                data: {fi_st: $('#grid_tab').val()},
                complete: function (jqXHR, status) {

                }
            });
            return false;
        });
    });


    var fileinfoModal = UIkit.modal("#fileinfoModal");

    function SplitAllocate(id) {
        $("#fileinfoModal .uk-modal-header h3").html("Allocate to splitting");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('Joballocation/update') ?>/" + id,
            type: "post",
            data: {status: 'SA'},
            success: function (result) {
                $("#fileinfoModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }


    function SplitReallocate(id) {
        $("#fileinfoModal .uk-modal-header h3").html("Allocate to splitting");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('Joballocation/update') ?>/" + id,
            type: "post",
            data: {status: 'RSA'},
            success: function (result) {
                $("#fileinfoModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }

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