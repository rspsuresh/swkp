<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
?>

<h1>Manage File Infos</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <ul id="UserStatusTab" class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-active uk-width-1-2 tab_select" id="I" onclick="tabChange(this)"><a href="#">Indexing</a></li>
                    <li class="uk-width-1-2 tab_select" id="S" onclick="tabChange(this)"><a href="#">Splitting</a></li>
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="indexForm">
                            <?php
                            $_GET['tabname'] = "index";
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'file-info-grid1',
                                'dataProvider' => $model->search(),
                                'afterAjaxUpdate' => 'js:function(){$("select[name=\'FileInfo[fi_pjt_id]\']").chosen();}',
                                'filter' => $model,
                                'columns' => array(
                                    array(
                                        'name' => 'fi_pjt_id',
                                        'value' => '$data->ProjectMaster->p_name',
                                        'filter' => CHtml::dropDownList('FileInfo[fi_pjt_id]', $model->fi_pjt_id, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project')),
                                    ),
                                    'fi_file_name',
                                    'fi_file_ori_location',
                                    'fi_file_completed_location',
                                    array(
                                        "header" => "Actions",
                                        "value" => 'FileInfo::ActionButtons($data->fi_file_id,$data->fi_status,"index")',
                                    ),
                                ),
                            ));
                            ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="P">
                        </form>
                    </li>
                    <li>
                        <form id="splitForm">
                            <?php
                            $_GET['tabname'] = "split";
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'file-info-grid2',
                                'dataProvider' => $model->search(),
                                'afterAjaxUpdate' => 'js:function(){$("select[name=\'FileInfo[fi_pjt_id]\']").chosen();}',
                                'filter' => $model,
                                'columns' => array(
                                    array(
                                        'name' => 'fi_pjt_id',
                                        'value' => '$data->ProjectMaster->p_name',
                                        'filter' => CHtml::dropDownList('FileInfo[fi_pjt_id]', $model->fi_pjt_id, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project')),
                                    ),
                                    'fi_file_name',
                                    'fi_file_ori_location',
                                    'fi_file_completed_location',
                                    array(
                                        "header" => "Actions",
                                        "value" => 'FileInfo::ActionButtons($data->fi_file_id,$data->fi_status,"split",$data->FilePartition->fp_part_id)',
                                    ),
                                    array(
                                        "header" => "medical",
                                        "value" => '$data->FilePartition->fp_page_nums',
                                    ),
                                ),
                            ));
                            ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="P">
                        </form>
                    </li>
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
    
    function tabChange($this){
            console.log($this.id);
    }
    
    $(document).ready(function () {
        $("select[name='FileInfo[fi_pjt_id]']").chosen();
        
       

//        $('.tab_select').click(function () {
//            var id = $(this).attr('id');
//            // Set id
//            if (id == "P") {
//                $('#grid_tab').val('P');
//            } else if (id == "C") {
//                $('#grid_tab').val('C');
//            } else if (id == "I") {
//                $('#grid_tab').val('I');
//            }
//
//
//            $('.uk-tab-grid li').each(function () {
//                $(this).removeClass('uk-active');
//            });
//            $(this).addClass('uk-active');
//            $('#file-info-grid').yiiGridView('update', {
//                data: {fi_st: $(this).attr('id')},
//                complete: function (jqXHR, status) {
//
//                }
//            });
//            return false;
//        });
    });

//    var fileinfoModal = UIkit.modal("#fileinfoModal");
//    function Indexview(id) {
//        $("#fileinfoModal .uk-modal-header h3").html("Allocate to indexing");
//        $.ajax({
//            url: "<?php // echo Yii::app()->createUrl('fileinfo/Indexinglist')  ?>/" + id,
//            type: "post",
//            success: function (result) {
//                $("#fileinfoModal .uk-modal-content").html(result);
//                $("#triggerModal").trigger("click");
//            }
//        });
//    }

//    $('#fileinfoModal').on({
//        'show.uk.modal': function () {
//        },
//        'hide.uk.modal': function () {
//            $("#fileinfoModal .uk-modal-header h3").html("");
//            $("#fileinfoModal .uk-modal-content").html("");
//            $('#file-info-grid').yiiGridView('update', {
//                data: {}
//            });
//        }
//    });
</script>	