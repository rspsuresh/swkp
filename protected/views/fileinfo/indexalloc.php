<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
?>

<h3 class="heading_b uk-margin-bottom">Manage Prepping</h3>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-5-6">
            </div>
            <div class="uk-width-medium-1-6">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <div class="uk-width-1-1">
                <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-active uk-width-1-3 tab_select" id="P"><a href="#">File List</a></li>
                    <li class="uk-width-1-3 tab_select" id="A"><a href="#">Allocation List</a></li>
                    <li class="uk-width-1-3 tab_select" id="C"><a href="#">Quality Control</a></li>
                    <!--<li class="uk-width-1-3 tab_select" id="C"><a href="#">Completed list</a></li>-->
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="trn_from">
                            <?php } else if (Yii::app()->session['user_type'] == "QC") { ?>
                            <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                                <li class="uk-active uk-width-1-2 tab_select" id="C"><a href="#">File List</a></li>
                                <li class="uk-width-1-2 tab_select" id="IQP"><a href="#">Allocation List</a></li>
                            </ul>
                            <ul id="tabs_4" class="uk-switcher uk-margin">
                                <li>
                                    <form id="trn_from">
                                        <?php } ?>
                                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'file-info-grid',
                                            'dataProvider' => $model->search(),
                                            'afterAjaxUpdate' => 'js:function(){$("select[name=\'FileInfo[fi_pjt_id]\']").chosen();$("select[name=\'FileInfo[indexer]\']").chosen(); gridResetOption();}',
                                            'filter' => $model,
                                            'template' => '{items}{summary}{pager}',
                                            'columns' => array(
                                                //  'fi_file_id',
                                                //  'fi_pjt_id',
                                                array(
                                                    'header' => 'Expand',
                                                    'type' => 'raw',
                                                    'htmlOptions' => array('class' => 'plus', 'id' => '$data->id'),
                                                    'value' => function ($data) {
                                                        return "<a data-show='true' href='javascript:void(0)' onclick='gridload($data->fi_file_id,$(this))'><i class='material-icons'>add_circle_outline</i></a>";
                                                    },
                                                    'visible' => (isset($_GET['fi_st']) && $_GET['fi_st'] == 'IC' && Yii::app()->session['user_type'] == 'A') || (isset($_GET['fi_st']) && $_GET['fi_st'] == 'IQP' && Yii::app()->session['user_type'] == 'QC')
                                                ),
                                                array(
                                                    'name' => 'fi_pjt_id',
                                                    'value' => 'isset($data->ProjectMaster->p_name)?$data->ProjectMaster->p_name:""',
                                                    'filter' => CHtml::dropDownList('FileInfo[fi_pjt_id]', $model->fi_pjt_id, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project')),
                                                ),
                                                'fi_file_name',
                                                //'fi_file_ori_location',
                                                //'fi_file_completed_location',
                                                // 'fi_file_uploaded_date',
                                                /*
                                                'fi_file_completed_time',
                                                'fi_status',
                                                'fi_created_date',
                                                'fi_last_modified',
                                                'fi_flag',
                                                */
                                                array(
                                                    "header" => "Indexer",
                                                    'name' => 'indexer',
                                                     'visible' => ((isset($_GET["fi_st"]) == "IA" || isset($_GET["fi_st"]) == "IQP") && Yii::app()->session['user_type'] == 'QC'),
                                                    "value" => '(isset($data->JobAllocation->ja_reviewer_id) && $data->JobAllocation->ja_status != "IQ")?FileInfo::GetName($data->JobAllocation->ja_reviewer_id,$data->JobAllocation->ja_status):""',
                                                    'filter' => CHtml::dropDownList('FileInfo[indexer]', $model->indexer, CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name'), array('empty' => 'Select Reviewer')),
                                                ),
                                                /*array(
                                                    "header" => "Status",
                                                    "value" => '(isset($data->JobAllocation->ja_status))?FileInfo::GetStatus($data->JobAllocation->ja_status):""',
                                                ),*/
                                                array(
                                                    "header" => "Actions",
                                                    "value" => 'FileInfo::ActionButton($data->fi_file_id,Yii::app()->session["user_type"],(isset($data->JobAllocation->ja_job_id))?$data->JobAllocation->ja_job_id:"",(isset($data->JobAllocation->ja_status))?$data->JobAllocation->ja_status:"",(isset($data->FilePartition->fp_part_id))?$data->FilePartition->fp_part_id:"")',
													'type' => 'raw',
												),
                                            ),
                                        )); ?>
                                        <input type="hidden" id="grid_tab" name="grid_tab" value="P">
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
        $("select[name='FileInfo[indexer]']").chosen();

        $('.tab_select').click(function () {
            var id = $(this).attr('id');

            if (id == 'P') {
                $('#grid_tab').val('P');
            }
            else if (id == "A") {
                $('#grid_tab').val('IA');
            }
            else if (id == "C") {
                $('#grid_tab').val('IC');
            }
            else if (id == "IQP") {
                $('#grid_tab').val('IQP');
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
            url: "<?php echo Yii::app()->createUrl('Joballocation/create') ?>/" + id,
            type: "post",
            data: {status: 'IA', mode: 'A'},
            success: function (result) {
                $("#fileinfoModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }

    function IndexReallocate(id) {
        $("#fileinfoModal .uk-modal-header h3").html("Reallocate to prepping");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('Joballocation/create') ?>/" + id,
            type: "post",
            data: {status: 'IA', mode: 'R'},
            success: function (result) {
                $("#fileinfoModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }

    function IndexerReallocate(id) {
        $("#fileinfoModal .uk-modal-header h3").html("Allocate to prepping");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('Joballocation/update') ?>/" + id,
            type: "post",
            data: {status: 'IA'},
            success: function (result) {
                $("#fileinfoModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }


    /*function IndexQc(id) {
     $("#fileinfoModal .uk-modal-header h3").html("Allocate to Quality Control");
     $.ajax({
     url: "  //echo Yii::app()->createUrl('Joballocation/update') ?>/" + id,
     type: "post",
     data:{status:'QA'},
     success: function (result) {
     $("#fileinfoModal .uk-modal-content").html(result);
     $("#triggerModal").trigger("click");
     }
     });
     }*/


    function IndexQc(id) {
        UIkit.modal.confirm("Are you sure, you want to assign to yourself?", function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('Joballocation/qualityupdate') ?>/" + id,
                type: "post",
                data: {status: 'IQP'},
                success: function (result) {
                    $('#file-info-grid').yiiGridView('update', {
                        data: {}
                    });
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        $('.uk-close')[0].click();
						if ($('.uk-notify').is(':visible') === false) {
							UIkit.notify({
								message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
								status: "success",
								timeout: 10000,
								pos: 'top-right'
							});
						}
                    }
					else if(obj.status == "E"){
						$('.uk-close')[0].click();
						if ($('.uk-notify').is(':visible') === false) {
							UIkit.notify({
								message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
								status: "error",
								timeout: 10000,
								pos: 'top-right'
							});
						}
					}
                }
            });
        });
    }

    function CompleteQc(id) {
        UIkit.modal.confirm("Move to splitting?", function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('Joballocation/qualityupdate') ?>/" + id,
                type: "post",
                data: {status: 'IQC'},
                success: function (result) {
                    $('#file-info-grid').yiiGridView('update', {
                        data: {}
                    });
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                    }
                }
            });
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

    function gridload($id, $this) {
        var checkShowOrHide = $this.data("show");
        if (checkShowOrHide) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/treegrid') ?>',
                type: 'get',
                data: {'id': $id},
                success: function (data) {
                    $this.closest("tr").after(data);
                    $this.html("<i class='material-icons'>remove_circle_outline</i>");
                    $this.data("show", false);
                }
            });
        } else {
            $this.html("<i class='material-icons'>add_circle_outline</i>");
            $this.closest("tr").next().remove();
            $this.data("show", true);
        }

    }
    function checklock($file_id)
    {
     if($file_id)
     {
         var url = '<?php echo Yii::app()->createUrl("fileinfo/filelock")?>';
         $.ajax({
             url: url,
             type: "post",
             data: {'file_id': $file_id},
             success: function (result) {
                 var obj = JSON.parse(result);
                 var status = (obj.status == "C") ? 'warning':'success';
                 if(obj.status=='C') {
                     UIkit.notify({
                         message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                         status: status,
                         timeout: 10000,
                         pos: 'top-right'
                     });
                 }
                 else if(obj.status=='N') {
                     var rurl='<?php echo Yii::app()->createUrl("fileinfo/fileindexing")?>/'+$file_id+'?status=R';
                     window.location.href = rurl;
                 }
             },
         });
     }
    }
</script>