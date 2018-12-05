<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */
?>

<h3 class="heading_b uk-margin-bottom">Manage Splitting</h3>

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
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="trn_from">
                            <?php } else if (Yii::app()->session['user_type'] == "QC") { ?>
                            <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                                <li class="uk-active uk-width-1-2 tab_select" id="C"><a href="#">File List</a></li>
                                <li class="uk-width-1-2 tab_select" id="SQP"><a href="#">Allocation List</a></li>
                            </ul>
                            <ul id="tabs_4" class="uk-switcher uk-margin">
                                <li>
                                    <?php } ?>
                                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'file-partition-grid',
                                        'dataProvider' => $model->search(),
                                        'afterAjaxUpdate' => 'js:function(){$("select[name=\'FilePartition[project]\']").chosen();$("select[name=\'FilePartition[fp_category]\']").chosen();$("select[name=\'FilePartition[splitter]\']").chosen();gridResetOption();}',
                                        'filter' => $model,
                                        'template' => '{items}{summary}{pager}',
                                        'columns' => array(
                                            //'fp_part_id',
                                            array(
                                                'header' => 'Expand',
                                                'type' => 'raw',
                                                'htmlOptions' => array('class' => 'plus', 'id' => '$data->id'),
                                                'value' => function ($data) {
                                                    return "<a data-show='true' href='javascript:void(0)' onclick='gridload($data->fp_file_id,$(this))'><i class='material-icons'>add_circle_outline</i></a>";
                                                },
                                                'visible' => (isset($_GET['fi_st']) && $_GET['fi_st'] == 'SC' && Yii::app()->session['user_type'] == 'A') || (isset($_GET['fi_st']) && $_GET['fi_st'] == 'SQP' && Yii::app()->session['user_type'] == 'QC')
                                            ),
                                            array(
                                                'name' => 'project',
                                                'value' => 'isset($data->FileInfo->ProjectMaster->p_name)?$data->FileInfo->ProjectMaster->p_name:""',
                                                'filter' => CHtml::dropDownList('FilePartition[project]', $model->project, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name'), array('empty' => 'Select Project')),
                                            ),
                                            array(
                                                'name' => 'filename',
                                                'value' => 'isset($data->FileInfo->fi_file_name)?$data->FileInfo->fi_file_name:""',
                                                //'filter' => CHtml::dropDownList('FilePartition[filename]', $model->fp_file_id, CHtml::listData(FileInfo::model()->findAll(array("condition" => "fi_flag= 'A'", 'order' => 'fi_file_name')), 'fi_file_id', 'fi_file_name'), array('empty' => 'Select Filename')),
                                            ),
//                                                'fp_filepath',
                                            /*array(
                                                'name' => 'fp_category',
                                                'value' => '($data->fp_category == "M")?"Medical":"Non-medical"',
                                                'filter' => CHtml::dropDownList('FilePartition[fp_category]', $model->fp_category, array('M'=>'Medical','N'=>'Non-medical') , array('empty' => 'Select Type')),
                                            ),*/
                                            //'fp_category',
//                                                'fp_cat_id',
//                                                            array(
//                                                    "header" => "Category",
//                                                    //'visible' => '(isset($data->JobAllocation->ja_reviewer_id))?true:false',
//                                                    "value" => '$data->Category->ct_cat_name',
//                                                ),
                                            array(
                                                'name' => 'fp_page_nums',
                                                'type' => 'raw',
                                                'value' => function ($data) {
                                                    $filetotalpage=FileInfo::model()->findByPk($data->fp_file_id);
                                                    $totalpage = (!empty($filetotalpage) && $filetotalpage->fi_total_pages )?$filetotalpage->fi_total_pages:0;
                                                    return '<span class="uk-badge">Medical pages :'.count(explode(',', $data->fp_page_nums)).'</span>  <span class="uk-badge uk-badge-warning">Total Pages :'.$totalpage.'</span>';
                                                }
                                                //'value' => '$data->FileInfo->fi_file_name',
                                            ),
                                            //'fp_page_nums',
                                            array(
                                                "header" => "Splitter",
                                                'name' => 'splitter',
                                                'visible' => (($_GET["fi_st"] == "SA" || $_GET["fi_st"] == "SQP") && Yii::app()->session['user_type'] == 'QC'),
                                                "value" => '(isset($data->JobAllocation->ja_reviewer_id) && $data->JobAllocation->ja_status != "SQ")?FileInfo::GetName($data->JobAllocation->ja_reviewer_id,$data->JobAllocation->ja_status):""',
                                                'filter' => CHtml::dropDownList('FilePartition[splitter]', $model->splitter, CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id= '4' && ud_flag = 'A'", 'order' => 'ud_name')), 'ud_refid', 'ud_name'), array('empty' => 'Select Reviewer')),
                                            ),

                                            /*array(
                                                "header" => "Splitter",
                                                //'visible' => '(isset($data->JobAllocation->ja_reviewer_id))?true:false',
                                                "value" => '(isset($data->JobAllocation->ja_reviewer_id))?FileInfo::GetName($data->JobAllocation->ja_reviewer_id,$data->JobAllocation->ja_status):""',
                                            ),*/
                                            array(
                                                "header" => "QC",
                                                'visible' => (isset($_GET['fi_st']) && $_GET['fi_st'] == 'SC' && Yii::app()->session['user_type'] == 'A'),
                                                "value" => '(isset($data->JobAllocation->ja_qc_id))?FileInfo::GetName($data->JobAllocation->ja_qc_id,$data->JobAllocation->ja_status):"Not Accepted"',
                                            ),
                                            /*
                                            'fp_status',
                                            'fp_created_date',
                                            'fp_last_modified',
                                            'fp_flag',
                                            */
                                          /* array(
                                                "header" => "Status",
                                                "value" => '(isset($data->JobAllocation->ja_status))?FileInfo::GetStatus($data->JobAllocation->ja_status):""',
                                            ),*/
                                            array(
                                                "header" => "Actions",
                                                "value" => 'FilePartition::ActionButtons($data->fp_part_id,Yii::app()->session["user_type"],(isset($data->JobAllocation->ja_status))?$data->JobAllocation->ja_status:"",(isset($data->JobAllocation->ja_job_id))?$data->JobAllocation->ja_job_id:"",$data)',
												'type' => 'raw',
											),
                                        ),
                                    )); ?>
                                    <input type="hidden" id="grid_tab" name="grid_tab" value="I">
                                    <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>

                                </li>
                            </ul>
                        <?php } ?>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="PartitionModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#PartitionModal'}" style="display: none;"></button>
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
        $("select[name='FilePartition[fp_file_id]']").chosen();
        $("select[name='FilePartition[fp_category]']").chosen();
        $("select[name='FilePartition[project]']").chosen();
        $("select[name='FilePartition[splitter]']").chosen();
        <?php if (!empty($_GET["showMsg"])) : ?>
        window.history.pushState("", "", "splitalloc");
        UIkit.notify({
            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> <?php echo $_GET['showMsg'] ?>",
            status: "success",
            timeout: 10000,
            pos: 'top-right'
        });
        <?php endif; ?>
    });

    var PartitionModal = UIkit.modal("#PartitionModal");
    //Popup
    /*$('#PartitionModal').on({
     'show.uk.modal': function () {
     },
     'hide.uk.modal': function () {
     $("#PartitionModal .uk-modal-header h3").html("");
     $("#PartitionModal .uk-modal-content").html("");
     $('#file-partition-grid').yiiGridView('update', {
     data: {}
     });
     }
     });*/

    $('.tab_select').click(function () {
        var id = $(this).attr('id');
        if (id == 'P') {
            $('#grid_tab').val('I');
        }
        else if (id == "A") {
            $('#grid_tab').val('SA');
        }
        else if (id == "C") {
            $('#grid_tab').val('SC');
        }
        else if (id == "SQP") {
            $('#grid_tab').val('SQP');
        }
        $('.uk-tab-grid li').each(function () {
            $(this).removeClass('uk-active');
        });
        $(this).addClass('uk-active');
        $('#file-partition-grid').yiiGridView('update', {
            data: {fi_st: $('#grid_tab').val()},
            complete: function (jqXHR, status) {
            }
        });
        return false;

    });
    function SplitAllocate(id) {
        $("#PartitionModal .uk-modal-header h3").html("Allocate to splitting");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/create') ?>/" + id,
            type: "post",
            data: {status: 'SA'},
            success: function (result) {
                $("#PartitionModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }

    function SplitReallocate(id) {
        $("#PartitionModal .uk-modal-header h3").html("Reallocate to splitting");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/update') ?>/" + id,
            type: "post",
            data: {status: 'SA'},
            success: function (result) {
                $("#PartitionModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }


    function IndexQc(id) {
        UIkit.modal.confirm("Are you sure, you want to assign to yourself?", function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('joballocation/qualityupdate') ?>/" + id,
                type: "post",
                data: {status: 'SQP'},
                success: function (result) {
                    $('#file-partition-grid').yiiGridView('update', {
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
        UIkit.modal.confirm("Are you sure, you want to complete this process?", function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('joballocation/qualityupdate') ?>/" + id,
                type: "post",
                data: {status: 'SQC'},
                success: function (result) {
                    $('#file-partition-grid').yiiGridView('update', {
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
    /**
     * Re copmlete file
     */
    function completeReviewerFile($job_id) {
        UIkit.modal.confirm("Are you sure, you want to complete the file?", function () {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/splitcomplete', array('mode' => 'S', 'status' => false)); ?>',
                type: "post",
                data: {job_id: $job_id},
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                        setTimeout(function () {
                            $('#file-partition-grid').yiiGridView('update');
                        }, 2000);
                    }
                }
            });
        });
    }

    function gridload($id, $this) {
        var checkShowOrHide = $this.data("show");
        console.log($this);
        if (checkShowOrHide) {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/treegrid2') ?>',
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
    function datecodelock($id,$p_id)
    {

        var url = '<?php echo Yii::app()->createUrl("fileinfo/filelock")?>';
        $.ajax({
            url: url,
            type: "post",
            data: {'file_id':$id},
            success: function (result) {
                var obj = JSON.parse(result);
                if(obj.status=='C') {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: status,
                        timeout: 10000,
                        pos: 'top-right'
                    });
                }
                else if(obj.status=='N') {
                    var rurl='<?php echo Yii::app()->createUrl("filepartition/filesplit")?>/'+$p_id+'?status=R';
                    window.location.href = rurl;
                }
            },
        });
    }

</script>