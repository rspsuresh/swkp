<?php
/**
 *
 * @var FileInfoController $this
 */
//print_r($filePartition);die;
?>
<style>
    input[type=radio] {
        display: none;
    }
    input[type=radio] + label {
        display: inline-block;
        margin: -2px;
        padding: 4px 12px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 20px;
        color: #333;
        text-align: center;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
        vertical-align: middle;
        cursor: pointer;
        background-color: #f5f5f5;
        background-image: -moz-linear-gradient(top, #fff, #e6e6e6);
        background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fff), to(#e6e6e6));
        background-image: -webkit-linear-gradient(top, #fff, #e6e6e6);
        background-image: -o-linear-gradient(top, #fff, #e6e6e6);
        background-image: linear-gradient(to bottom, #fff, #e6e6e6);
        background-repeat: repeat-x;
        border: 1px solid #ccc;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
        border-bottom-color: #b3b3b3;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    input[type=radio]:checked + label {
        background-image: none;
        outline: 0;
        -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
        -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
        background-color: #e0e0e0;
    }
    tr.green {
        border-left: 5px solid #8BCE3E;
        background-color: rgba(139, 195, 74, 0.21);
    }
    tr.red {
        border-left: 5px solid rgba(244, 67, 54, 0.9);
        background-color: rgba(244, 67, 54, 0.17);
    }
    td.empty {
        text-align: center;
    }
    .uk-badge-grey {
        background-color: #616161;
    }
    .uk-badge-pink {
        background-color: #d81b60;
    }
    .status-badge {
        width: 90%;
        line-height: 17px;
        -webkit-box-shadow: 0 10px 6px -6px #777;
        -moz-box-shadow: 0 10px 6px -6px #777;
        box-shadow: 0 9px 6px -6px #777;
        border-radius: 8px;
    }
    .showCheck {
        display: block;
    }
    .hideCheck {
        display: none;
    }
    .chosen-single {
        margin-top: 13px;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        font: 400 14px / 1.42857143 "Roboto", sans-serif !important;
        color: #727272 !important;
    }
    .material-iconsupload {
        transform: rotate(180deg);
    }
    .lock-green {
        color: green;
    }
    .lock-red {
        color: #c33232;
    }
</style>

<h3 class="heading_b uk-margin-bottom">Manage Workflow</h3>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-1-6">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <div class="uk-width-1-6">
                <a id="fileAssignment" style="visibility: hidden" class='userView uk-button uk-button-success waves-effect waves-button waves-light' href='javascript:void(0)' onclick='fileAssignment()'>File Assignment</a>
                <a id="filedownload" style="visibility: hidden" class='userView uk-button uk-button-success waves-effect waves-button waves-light' href='javascript:void(0)'>Download</a>
            </div>
            <div class="uk-width-1-6">
                <a id="adminassignment" style="visibility: hidden" class='userView uk-button uk-button-success waves-effect waves-button waves-light' href='javascript:void(0)' onclick='adminAssignment()'>Self Allocate</a>
            </div>
            <div class="uk-width-3-6">
                <div class="uk-align-right">
                    <?php
                    echo CHtml::radioButtonList("prcessCheck", 'All', array(
                        'All' => 'All',
                        'New' => 'New',
                        'Prepping' => 'Prepping',
                        'Splitting' => 'DateCoding',
                        'Editor' => 'Editing',
                        'Completed' => 'Completed',
                    ), array(
                        'labelOptions' => array('style' => 'display:inline-block'), // add this code
                        'separator' => '  ',
                        'onchange' => 'processChange($(this))',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-1-5" data-uk-grid-margin="">
                <label>Review Process Date</label>
                <input id="rprocessDate" class="searchCollection md-input" name="searchDate" data-uk-datepicker="{format:'DD MMM YYYY'}" onchange="rdateChange($(this))">
                <!--<input id="searchDate" class="searchCollection md-input" name="searchDate" data-uk-datepicker="{format:'DD MMM YYYY'}" onchange="dateChange($(this))">-->
            </div>
            <div class="uk-width-1-5" data-uk-grid-margin="">
                <label>Qc Process Date</label>
                <input id="qprocessDate" class="searchCollection md-input" name="searchDate" data-uk-datepicker="{format:'DD MMM YYYY'}" onchange="qdateChange($(this))">
            </div>
            <div class="uk-width-1-5" data-uk-grid-margin="">
                <?php
                $type_list = CHtml::listData(Project::model()->findAll(array('condition' => "p_flag ='A' order by p_name asc")), 'p_pjt_id', 'p_name');
                echo CHtml::dropDownList('selectedProject', '', $type_list, array('prompt' => 'Select Project', 'onchange' => "projectChange($(this))"));
                ?>
            </div>
            <div class="uk-width-1-5" data-uk-grid-margin="">
                <?php
                $type_list = CHtml::listData(UserDetails::model()->findAll(array('condition' => "ud_flag ='A' order by ud_username asc")), 'ud_refid', 'ud_username');
                echo CHtml::dropDownList('selectedUser', '', $type_list, array('prompt' => 'Select User', 'onchange' => "userChange($(this))"));
                ?>
            </div>
            <div class="uk-width-1-5" data-uk-grid-margin="">
                <div class="uk-align-right">
                    <?php echo CHtml::textField('global_search', '', array('id' => 'global_search', 'class' => "md-input", 'placeholder' => 'Search', 'onkeyup' => 'searchChange($(this))')); ?>
                </div>
            </div>
        </div>
        <?php //print_r($dataProvider);?>
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-1-1" data-uk-grid-margin="">
                <?php
                $type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : "E";
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'All-details-grid',
                    'template' => '{items}{summary}{pager}',
                    'dataProvider' => $dataProvider,
                    //'rowCssClassExpression' => 'FileInfo::getColor($data["ja_status"])',
                    'afterAjaxUpdate' => 'js:function(){hideCheckColumn();}',
                    'columns' => array(
                        array(
                            'name' => 'check',
                            'id' => 'selectedIds',
                            'value' => '$data["primaryid"]',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '100',
                            'headerHtmlOptions' => array("class" => "", 'onchange' => "fn_onclick(2);"),
                            'htmlOptions' => array("class" => "", 'onchange' => "fn_onclick(2);"),
                        ),
                        array(
                            'header' => 'Actions',
                            //'value' => '(empty($_GET["curProcess"]) || $_GET["curProcess"] == "All") ? ($data["ja_status"]=="IQ" || $data["ja_status"]=="SQ" ?Buttons::AllgridButtons($data["ja_job_id"],$data["ja_status"]): Buttons::ProcessSwapButton($data["ja_job_id"])) : Buttons::AllgridButtons($data["ja_job_id"],$data["ja_status"])',
                            'value' => 'Buttons::ChooseButtons($data["ja_job_id"],$data["ja_status"],!empty($_GET["curProcess"])?$_GET["curProcess"]:"All",$data["primaryid"],$data["p_id"],$data)',
                            'visible' => (empty($_GET["curProcess"]) || ($_GET["curProcess"] != "New" && $_GET["curProcess"] != "Editor")),
                            'type' => 'raw',
                        ),
                        array(
                            'name' => 'checkcomplete',
                            'id' => 'selectedIds',
                            'value' => '$data["primaryid"]',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => '100',
                            'headerHtmlOptions' => array("class" => "", 'onchange' => "fn_onclick(1);"),
                            'htmlOptions' => array("class" => "", 'onchange' => "fn_onclick(1);"),
                            'visible' => false
                        ),
                        array(
                            'header' => 'Expand',
                            'type' => 'raw',
                            'htmlOptions' => array('class' => 'plus', 'id' => '$data->id'),
                            'value' => 'Buttons::Treebutton($data)',
                            'visible' => (!empty($_GET["curProcess"]) && ($_GET["curProcess"] == "Prepping" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Completed"))
                        ),
                        array(
                            'header' => 'Project Name',
                            'name' => 'project_name',
                            'value' => '$data["project_name"]',
                        ),
                        array(
                            'header' => 'File Name',
                            'name' => 'file_name',
                            'value' => '$data["file_name"]',
                        ),
                        array(
                            'header' => 'Status',
                            'value' => 'FileInfo::GetFlag($data["ja_status"],$data["fi_status"])',
                            'htmlOptions' => array("style" => "text-align:center"),
                        ),
                        array(
                            'header' => 'File Type',
                            //'name'=>'file_name',
                            'value' => 'pathinfo($data["file_name"], PATHINFO_EXTENSION)',
                        ),
                        /* array(
                          'header' => 'File Location',
                          'value' => '$data["file_location"]',
                          ), */
                        array(
                            'header' => 'Received Date',
                            'name' => 'upload_date',
                            'value' => '$data["upload_date"]',
                        ),
                        array(
                            'header' => 'Processed Date',
                            'name' => 'processed_date',
                            'value' => '$data["processed_date"]',
                            //'value' => 'isset($data["processed_date"])?date("d M Y",strtotime($data["processed_date"])):""',
                            //'visible' => (!empty($_GET["curProcess"]) ? $_GET["curProcess"] != "New" : true)
                            'visible' => (isset($_GET["curProcess"])) ? FileInfo::ProcessVisible($_GET["curProcess"]) : false,
                        ),
                        array(
                            'header' => 'Completed Date',
                            'name' => 'ja_last_modified',
                            'value' => '$data["ja_last_modified"]',
                            'visible' => (isset($_GET["curProcess"]) && $_GET["curProcess"] == "Completed") ? true : false,
                        ),
                        /*array(
                            'header' => 'revieweratime',
                            'name' => 'revieweratime',
                            'value' => 'isset($data["revieweratime"])?date("d M Y H:i:s",strtotime($data["revieweratime"])):""',
                            'visible' => (!empty($_GET["curProcess"]) ? ($_GET["curProcess"] == "Editor" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Prepping") : true)
                        ),*/
                        array(
                            'header' => 'revieweratime',
                            'name' => 'revieweratime',
                            'value' => 'isset($data["processed_date"]) && $data["processed_date"] != "0000-00-00 00:00:00" ? $data["processed_date"]:"-"',
                            'visible' => (!empty($_GET["curProcess"]) ? ($_GET["curProcess"] == "Editor" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Prepping") : true)
                        ),
                        array(
                            'header' => 'reviewerctime',
                            'name' => 'reviewerctime',
                            'value' => 'isset($data["prep_completed_date"]) && $data["prep_completed_date"] != "0000-00-00 00:00:00" ? $data["prep_completed_date"]:"-"',
                            'htmlOptions' => array("style" => "text-align:center"),
                            'visible' => (!empty($_GET["curProcess"]) ? ($_GET["curProcess"] == "Editor" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Prepping") : true)
                        ),
                        array(
                            'header' => 'QCatime',
                            'name' => 'QCatime',
                            'value' => '(isset($data["qcatime"]) && $data["ja_qc_id"] != 0)?$data["qcatime"]:"-"',
                            'htmlOptions' => array("style" => "text-align:center"),
                            'visible' => (!empty($_GET["curProcess"]) && ($_GET["curProcess"] == "Editor" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Prepping") ? true : false)
                        ),
                        /* array(
                             'header' => 'QCCtime',
                             'name' => 'QCCtime',
                             'value' => '(isset($data["qcctime"]) && $data["ja_qc_id"] != 0)?$data["qcctime"]:"Skipped"',
                             'visible' => (!empty($_GET["curProcess"]) && ($_GET["curProcess"] == "Editor" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Prepping") ? true : false)
                         ),*/
                        array(
                            'header' => 'Total Pages',
                            'name' => 'fi_total_pages',
                            'value' => '$data["fi_total_pages"]',
                        ),
                        array(
                            'header' => (!empty($_GET["curProcess"]) ? UserDetails::getHeaderName($_GET["curProcess"]) : ''),
                            'name' => 'reviewer_name',
                            'value' => 'UserDetails::getView(isset($data["reviewer_id"])?$data["reviewer_id"]:"")',
                            'type' => 'raw',
                            'visible' => (!empty($_GET["curProcess"]) ? ($_GET["curProcess"] != "New" && $_GET["curProcess"] != "All" && $_GET["curProcess"] != "Editor" && $_GET["curProcess"] != "Completed") : false)
                        ),
                        array(
                            'header' => 'QC',
                            'name' => 'qc_name',
                            'value' => 'UserDetails::getView(isset($data["qc_id"])?$data["qc_id"]:"")',
                            'type' => 'raw',
                            'visible' => (!empty($_GET["curProcess"]) ? ($_GET["curProcess"] != "New" && $_GET["curProcess"] != "All" && $_GET["curProcess"] != "Editor" && $_GET["curProcess"] != "Completed") : false)
                        ),
                        /* array(
                          'header' =>(!empty($_GET["curProcess"]) ? UserDetails::getHeaderName($_GET["curProcess"])  : ''),
                          'name'=>'employee',
                          'value' => 'UserDetails::getView(isset($data["user_id"])?$data["user_id"]:"")',
                          'type' => 'raw',
                          'visible' => (!empty($_GET["curProcess"]) ? $_GET["curProcess"] != "New" : false)
                          ),
                         */
						 /*array(
                            'header' => 'Interference',
                            'value' => 'FileInfo::getInterference($data["primaryid"])',
                            'visible' => (!empty($_GET["curProcess"]) && $_GET["curProcess"] == "Completed"),
                        ),*/
                        array(
                            'header' => 'FeedBack',
                            'value' => function ($data) {
                                if (isset($data['feedback'])) {
                                    $feedBack = $data['primaryid'];
                                    $list = Yii::app()->db->createCommand("SELECT A.`ja_qc_feedback`,A.`ja_status` from 
                                       `job_allocation_ja` as A WHERE `ja_file_id` =$feedBack  and (`ja_status`!='IQ' or `ja_status`!='EQ' or `ja_status`!='SQ') and `ja_flag`='A' and (`ja_qc_feedback` IS NOT NULL and `ja_qc_feedback` != '')")->queryAll();
                                    if (count($list) > 0) {
                                        return "<a href='#' title='Feedback' data-uk-tooltip = \"{pos:'top'}\" onclick=\"showModal($feedBack);\"><i class=\"uk-icon-newspaper-o uk-icon-medium\"></i></a>";
                                    }
                                } else {
                                    return '';
                                }
                            },
                            'type' => 'raw',
                            'htmlOptions' => array("style" => "text-align:center"),
                            'visible' => (empty($_GET["curProcess"]) || $_GET["curProcess"] != "New"),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div id="allGridMadal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#allGridMadal  '}" style="display: none;"></button>
<script>
    $(document).ready(function () {
        hideCheckColumn();
        $("#selectedProject").chosen();
        $("#selectedUser").chosen();
        $(document).unbind('keyup').keyup(function (e) {
            if (e.which === 39) {
                tabindex = $('input:radio[name=prcessCheck]:checked').index();
                tablen = $('input:radio[name=prcessCheck]').length;
                if (tabindex < (tablen - 1) * 2) {
                    $('input:radio[name=prcessCheck]')[(tabindex / 2) + 1].click();
                }
            }
            else if (e.which === 37) {
                tabindex = $('input:radio[name=prcessCheck]:checked').index();
                tablen = $('input:radio[name=prcessCheck]').length;
                if (tabindex > 0) {
                    $('input:radio[name=prcessCheck]')[(tabindex / 2) - 1].click();
                }
            }

        });
        setTimeout(function () {
            $("#prcessCheck_1").trigger("click");
        }, 100);
        <?php if(!empty($_GET['txt'])) { ?>
        var msg="File Downloaded sucessfully";
        UIkit.notify({
            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " +msg,
            status: "success",
            timeout: 10000,
            pos: 'top-right'
        });
        window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
        <?php } ?>
    })

    function fn_onclick(id) {
        if (id == 1) {
            var comid = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds").toString();
            if (comid != '') {
                $("#filedownload").css('visibility', 'visible');
            }
            else {
                $("#filedownload").css('visibility', 'hidden');
            }
        }
        else if (id == 2) {
            var cid = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds").toString();
            if (cid != '') {
                $("#fileAssignment").css('visibility', 'visible');
                $("#adminassignment").css('visibility', 'visible');
            }
            else {
                $("#fileAssignment").css('visibility', 'hidden');
                $("#adminassignment").css('visibility', 'hidden');
            }
        }
    }

    /* function completefn_onclick() {
         alert("jkdjskdj");
         var comid = $.fn.yiiGridView.getChecked("All-details-grid", "completeselectedIds").toString();

         if (comid != '') {
             $("#filedownload").css('visibility', 'visible');
         }
         else {
             $("#filedownload").css('visibility', 'hidden');
         }
     }*/
    function fileAssignment() {
        var $id = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds").toString();
        if ($id != '') {
            $("#allGridMadal .uk-modal-header h3").html("File Assignment");
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('fileinfo/fileassignment') ?>",
                type: "GET",
                data: {id: $id},
                success: function (result) {
                    $("#allGridMadal .uk-modal-content").html(result);
                    $("#triggerModal").trigger("click");
                    $("#JobAllocation_indexer_id").trigger('chosen:activate');
					$.UIkit.init();
                }
            });
        } else {
            var msg = "Please Select Atleast one File!";
            UIkit.notify({
                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + msg,
                status: "success",
                timeout: 10000,
                pos: 'top-right'
            });
        }
    }
    function adminAssignment() {
        UIkit.modal.confirm("Are you sure want to self allocate?", function () {
            var $id = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds").toString();
            if ($id != '') {
				var fi_prep = "";
				UIkit.modal.confirm("Do you need prepping for it?", onconfirm, oncancel, function () {
				});
            } else {
                var msg = "Please Select Atleast one File!";
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + msg,
                    status: "success",
                    timeout: 10000,
                    pos: 'top-right'
                });
            }
        });
    }
	
	function onconfirm(){
		var $id = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds").toString();
		$("#allGridMadal .uk-modal-header h3").html("File Assignment");
            $.ajax({
				url: "<?php echo Yii::app()->createUrl('fileinfo/adminassignment') ?>",
                type: "GET",
                dataType: "json",
                data: {id: $id, fi_prep :0},
                success: function (result) {
                UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + result.msg,
                        status: "success",
                        timeout: 10000,
                        pos: 'top-right'
                    });
                    //$("#prcessCheck_2")[0].click();
                    $("#prcessCheck_2").trigger('click');
                }
            });		
	}
	
	function oncancel(){
		var $id = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds").toString();
		$("#allGridMadal .uk-modal-header h3").html("File Assignment");
            $.ajax({
				url: "<?php echo Yii::app()->createUrl('fileinfo/adminassignment') ?>",
                type: "GET",
                dataType: "json",
                data: {id: $id, fi_prep :1},
                success: function (result) {
                UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + result.msg,
                        status: "success",
                        timeout: 10000,
                        pos: 'top-right'
                    });
                    //$("#prcessCheck_2")[0].click();
                    $("#prcessCheck_3").trigger('click');
                }
            });
	}
	
    $("#filedownload").click(function () {
        var $id = $.fn.yiiGridView.getChecked("All-details-grid", "selectedIds");
        window.location = 'downloadtotal?id=' + $id;
        <?php
        /* UIkit.notify({
             message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> File Downloaded",
             status: "warning",
             timeout: 500,
             pos: 'top-right'
         });*/
        /* }*/
        /* $.ajax({
               url: '<?php echo Yii::app()->createUrl('fileinfo/downloadtotal?id=') ?>' + $id,
               success: function (data) {
                   UIkit.notify({
                       message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> File Downloaded",
                       status: "warning",
                       timeout: 500,
                       pos: 'top-right'
                   });
               }
           });*/
        ?>

    });

    function exportxls($fid) {
        window.location = '<?php echo Yii::app()->createUrl('fileinfo/export'); ?>/' + $fid;
    }

    $('#allGridMadal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#allGridMadal .uk-modal-header h3").html("");
            $("#allGridMadal .uk-modal-content").html("");
            $('#All-details-grid').yiiGridView('update', {
                data: {}
            });
            $("#fileAssignment").css('visibility', 'hidden');
            $("#adminassignment").css('visibility', 'hidden');
        }
    });

    function processChange($this) {
        var curProcess = $this.val();
        $("#filedownload").css('visibility', 'hidden');
        $("#fileAssignment").css('visibility', 'hidden');
        $("#adminassignment").css('visibility', 'hidden');
        $('#All-details-grid').yiiGridView('update', {
            data: {curProcess: curProcess}
        });
    }

    /**
     * Tree grid Load
     */
    function gridload($id, $this) {
        var checkShowOrHide = $this.data("show");
        console.log($this);
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

    function gridloader($id, $this) {
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

    function Reallocate($id, $data) {
        $("#allGridMadal .uk-modal-header h3").html("Reallocate to Prepping");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/reallocate') ?>/" + $id,
            type: "post",
            data: {status: $data},
            success: function (result) {
                $("#allGridMadal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }

    function searchChange($this) {
        var searchText = $this.val();
        curProcess = $('input:radio[name=prcessCheck]:checked').val();
        $('#All-details-grid').yiiGridView('update', {
            data: {searchText: searchText, curProcess: curProcess}
        });
    }

    function dateChange($this) {
        var seletedDate = $this.val();

        $('#All-details-grid').yiiGridView('update', {
            data: {seletedDate: seletedDate}
        });
    }

    /**
     *@ Reviewer Date Search
     */
    function rdateChange($this) {
        var seletedDate = $this.val();
        $('#All-details-grid').yiiGridView('update', {
            data: {rseletedDate: seletedDate}
        });
    }

    /**
     *@ Qc Date Search
     */
    function qdateChange($this) {
        var seletedDate = $this.val();
        $('#All-details-grid').yiiGridView('update', {
            data: {qseletedDate: seletedDate}
        });
    }

    //Project Change
    function projectChange($this) {
        var seletedProject = $this.val();

        $('#All-details-grid').yiiGridView('update', {
            data: {seletedProject: seletedProject}
        });
    }

    //User Chanage
    function userChange($this) {
        var seletedUser = $this.val();

        $('#All-details-grid').yiiGridView('update', {
            data: {seletedUser: seletedUser}
        });
    }

    function hideCheckColumn() {
        if ($('input[name="prcessCheck"]:checked').val() != "New") {
            var grid = $('#All-details-grid');
            $('thead tr', grid).each(function () {
                $('th:eq(0)', this).has("input").remove();
            });
            $('tbody tr', grid).each(function () {
                $('td:eq(0)', this).has("input").remove();
            });
        }
    }

    function ProcessSwap($jobId) {
        $("#allGridMadal .uk-modal-header h3").html("Process Status Change");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/processswap') ?>/" + $jobId,
            type: "post",
            success: function (result) {
                $("#allGridMadal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function templatechange($fileid) {
        $("#allGridMadal .uk-modal-header h3").html("Template Change");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('fileinfo/templatechange') ?>/" + $fileid,
            type: "post",
            success: function (result) {
                $("#allGridMadal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function backprcs(jobId) {
        UIkit.modal.confirm("Init editing?", function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('joballocation/backprocess') ?>",
                type: "post",
                data: {jobid: jobId},
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                        setTimeout(function () {
                            $('#All-details-grid').yiiGridView('update');
                        }, 300);
                    }
                }
            });
        });
    }

    /**
     * @Quit Process
     */
    function quitprocess($id, $data) {
        $("#allGridMadal .uk-modal-header h3").html("Quit Processing");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/quitprocess') ?>/" + $id,
            type: "post",
            data: {status: $data},
            success: function (result) {
                $("#allGridMadal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }


    function adminrealloc($id) {
        $("#allGridMadal .uk-modal-header h3").html("Reallocate");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('joballocation/adminrealloc') ?>/" + $id,
            success: function (result) {
                $("#allGridMadal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
	
	function Interference($id) {
        $("#allGridMadal .uk-modal-header h3").html("Interference");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('fileinfo/interference') ?>?file_id=" + $id,
			type: "post",
            success: function (result) {
                $("#allGridMadal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
	
    /**
     * @UserDetial and Activity View
     */
    function userView(id) {
        $("#userModal .uk-modal-header h3").html("User View");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('userdetails/view') ?>/" + id,
            type: "post",
            success: function (result) {
                $("#sidebar_secondary").html(result);
                $("#sidebar_secondary_toggle").trigger("click");
            },
        });
    }

    /**
     * @ Show Modal
     */
    function showModal(data) {
        var url = '<?php echo Yii::app()->createUrl("fileinfo/feedback")?>';
        var res = '';
        $.ajax({
            url: url,
            type: "post",
            data: {'id': data},
            success: function (result) {
                UIkit.modal.alert(result);
            },
        });
    }

    /**
     * @File F && unlock for Admin
     * if lock the for admin
     * file not be open by reviewer or client.
     * the process also checked prepping and dos
     */
    function fileLock($file_id, $selector) {
        var url = '<?php echo Yii::app()->createUrl("fileinfo/filelock")?>';
        $.ajax({
            url: url,
            type: "post",
            data: {'file_id': $file_id},
            success: function (result) {
                var obj = JSON.parse(result);
                var status = (obj.status == "S") ? 'success' : 'warning';
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                    status: status,
                    timeout: 10000,
                    pos: 'top-right'
                });
                $('#All-details-grid').yiiGridView('update');
            },
        });
    }

    /**
     * @ Check file status link and redirect the process
     * prepping  reviewer or qc
     * dos reviewer or qc
     */
    function fileOpen($data) {
        var action = $data.attr('data-action');
        var url = '';
        if (action == 'fileindexing') {
            url = '<?php echo Yii::app()->createUrl('fileinfo/fileindexing/32?status=R'); ?>';
        } else if (action == 'filesplit') {
            url = '<?php echo Yii::app()->createUrl('filepartition/filesplit'); ?>';
        }
        window.location.href = url;
    }


    function browse(pid, fid) {
        $(".upload_" + fid).trigger('click');
    }

    function filesubmit(pid, fid) {
        var formdata = new FormData($('#clientform_' + fid)[0]);
        var url = '<?php echo Yii::app()->createUrl("fileinfo/clientsidefile")?>';
        $.ajax({
            url: url,
            data: formdata,
            type: "post",
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                var obj = JSON.parse(result);
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                    status: "success",
                    timeout: 10000,
                    pos: 'top-right'
                });
                $("#prcessCheck_0").trigger('click');
            }
        });
    }

</script>
<?php

function getAllFeedBack($id) {
    $out1 = '';
    $out = '<h3 style=text-align:center>FeedBack</h3><hr>';
    $jobAllocation = JobAllocation::model()->findAll(array('condition' => "ja_file_id=$id and (ja_status!='IQ' or ja_status!='EQ' or ja_status!='SQ') and ja_flag='A'"));
    if ($jobAllocation) {
        $stat = true;
        foreach ($jobAllocation as $job) {
            if ($job->ja_qc_feedback) {
                $stat = false;
                $convertValue = str_replace("'", "", convert_smart_quotes($job->ja_qc_feedback));
                $convertValue = str_replace('"', '', $convertValue);
                if ($job->ja_partition_id == '0' && ($job->ja_status == 'QC' || $job->ja_status == 'IC')) {
                    $out1 .= '<h3>Prepping:</h3>';
                    $out1 .= '<span style=font-size:16px>' . $convertValue . '</span>';
                } else if ($job->ja_status != '') {
                    $out1 .= '<h3>DateCoding:</h3>';
                    $out1 .= '<span style=font-size:16px>' . $convertValue . '</span>';
                } else {
                    $out .= '<h3>Editor:</h3>';
                    $out .= '<span style=font-size:16px>' . $convertValue . '</span>';
                }
            }
        }
        if ($stat) {
            $out .= '<h3 style=text-align:center>No Result Found</h3>';
        }
    } else {
        $out .= '<h3 style=text-align:center>No Result Found</h3>';
    }
    return $out;
}

//Common
function convert_smart_quotes($string) {
    $search = array(chr(145),
        chr(146),
        chr(147),
        chr(148),
        chr(151));

    $replace = array("'",
        "'",
        '"',
        '"',
        '-');

    return trim(str_replace($search, $replace, $string));
}


?>