<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
?>
<?php
if(Yii::app()->session['user_type'] == "C") {
    $prjt_model = Project::model()->findAll(array('condition' => " p_client_id = " . Yii::app()->session['user_id'] . " and p_flag= 'A'"));
}
else
{
    $prjt_model= Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name'), 'p_pjt_id', 'p_name',array('prompt'=>'select project'));
}

?>
<h3 class="heading_b uk-margin-bottom">Manage File Infos</h3>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-3-4">
            </div>
            <div class="uk-width-1-4">
                <span class="icheck-inline">
                    <?php echo CHtml::radioButton('file_status', true, array('value' => 'I', 'uncheckValue' => null, 'data-md-icheck' => '')); ?>
                    <label for="radio_demo_inline_1" class="inline-label">Index</label>
                </span>
                <span class="icheck-inline">
                    <?php echo CHtml::radioButton('file_status', false, array('value' => 'S', 'uncheckValue' => null, 'data-md-icheck' => '')); ?>
                    <label for="radio_demo_inline_2" class="inline-label">Split</label>
                </span>
                                <!--<span class="icheck-inline">
                <?php //echo CHtml::radioButton('file_status', false, array('value'=>'R', 'uncheckValue'=>null, 'data-md-icheck' => '')); ?>
                    <label for="radio_demo_inline_3" class="inline-label">Review</label>
                </span>
                                <span class="icheck-inline">
                <?php //echo CHtml::radioButton('file_status', false, array('value'=>'Q', 'uncheckValue'=>null, 'data-md-icheck' => '')); ?>
                    <label for="radio_demo_inline_3" class="inline-label">Quality control</label>
                </span>-->
            </div>
        </div>	
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-active uk-width-1-2 tab_select" id="P"><a href="#">File List</a></li>
                    <li class="uk-width-1-2 tab_select" id="A"><a href="#">Allocation List</a></li>
                    <!--<li class="uk-width-1-3 tab_select" id="C"><a href="#">Completed list</a></li>-->
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="trn_from">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
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
                                        'filter' => CHtml::dropDownList('FileInfo[fi_pjt_id]', $model->fi_pjt_id, CHtml::listData($prjt_model)),
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
                                        "header" => "Actions",
                                        "value" => '(isset($data->FilePartition->fp_category) && $data->FilePartition->fp_category ="M")?FileInfo::ActionButtons($data->JobAllocation->ja_job_id,$data->JobAllocation->ja_status):FileInfo::ActionButtons($data->fi_file_id,$data->fi_status)',
                                    ),
                                ),
                            ));
                            ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="P">
                        </form>
                    </li>	
                </ul>		
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
        $("select[name='FileInfo[fi_pjt_id]']").chosen();

        $("input[type='radio'][name='file_status']").on('ifChecked', function (event) {
            radio = $("input[name='file_status']:checked").val();
            id = $('.uk-active').attr('id');
            if (id == 'P') {
                if (radio == 'I') {
                    $('#grid_tab').val('P');
                }
                else if (radio == 'S') {
                    $('#grid_tab').val('IC');
                }
                else if (radio == 'R') {
                    $('#grid_tab').val('SC');
                }
                else if (radio == 'Q') {
                    $('#grid_tab').val('RC');
                }
            }
            else {
                if (id == "A") {
                    $('#grid_tab').val(radio + 'A');
                } else if (id == "C") {
                    $('#grid_tab').val(radio + 'C');
                }
            }

            $('#file-info-grid').yiiGridView('update', {
                data: {fi_st: $('#grid_tab').val()},
                complete: function (jqXHR, status) {

                }
            });
            return false;
        });
        $('.tab_select').click(function () {
            radio = $("input[name='file_status']:checked").val();
            var id = $(this).attr('id');
            // Set id
            if (id == 'P') {
                if (radio == 'I') {
                    $('#grid_tab').val('P');
                }
                else if (radio == 'S') {
                    $('#grid_tab').val('IC');
                }
                else if (radio == 'R') {
                    $('#grid_tab').val('SC');
                }
                else if (radio == 'Q') {
                    $('#grid_tab').val('RC');
                }
            }
            else {
                if (id == "A") {
                    $('#grid_tab').val(radio + 'A');
                } else if (id == "C") {
                    $('#grid_tab').val(radio + 'C');
                }
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
    function IndexAllocate(id) {
        $("#fileinfoModal .uk-modal-header h3").html("Allocate to prepping");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/create') ?>/" + id,
            type: "post",
            data: {status: 'IA'},
            success: function (result) {
                $("#fileinfoModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }


    function SplitAllocate(id) {
        $("#fileinfoModal .uk-modal-header h3").html("Allocate to splitting");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/update') ?>/" + id,
            type: "post",
            data: {status: 'SA'},
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