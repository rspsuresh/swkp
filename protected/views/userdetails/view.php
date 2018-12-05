<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
?>
<?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
<style>
    #sidebar_secondary .uk-tab {
        position: relative;
    }
    #sidebar_secondary.tabbed_sidebar {
        padding-top: 0px;
    }
    #sidebar_secondary table.detail-view th {
        padding: 15px 0;
    }
    #sidebar_secondary table.detail-view td {
        text-align: right;
        padding: 15px 0;
    }
    #sidebar_secondary table.detail-view tr {
        background: transparent;
    }
    #sidebar_secondary {
        width: 335px !important;
        /*right: 0px;*/
        top: 0;
        z-index: 10000;
    }
    #sidebar_secondary table { width: 275px; margin: 0 auto; }
    .scrollbar-inner li {
    / / height: 100 %;
    }
    .allign-element {
        font-size: 13px;
        text-transform: uppercase;
        color: #212121;
        border: none;
        border-bottom: 2px solid transparent;
        border-radius: 0 !important;
        font-weight: 500;
        min-width: 100px;
        max-width: 100%;
        text-align: center;
        -webkit-transition: all 220ms cubic-bezier(0.4, 0, 0.2, 1);
        transition: all 220ms cubic-bezier(0.4, 0, 0.2, 1);
        padding: 8px !important;
        margin: 0 !important;
        box-sizing: border-box;
        position: relative;
        top: 1px;
    }
</style>
<?php
$allocatedCount = 0;
$completedlist = 0;
$jobAllocation = '';
$jobactivity = '';
if ($model->ud_usertype_id == "4") {
    //Allocated File List Query
    $jobAllocation = JobAllocation::model()->findAll(array("condition" => "ja_reviewer_id=$model->ud_refid and  ja_flag='A' and DATEDIFF(NOW(), ja_last_modified) <= 7"));
    $jobactivity = JobAllocation::model()->findAll(array("condition" => "ja_reviewer_id=$model->ud_refid and  ja_flag='A'", 'order' => 'ja_last_modified DESC', 'limit' => '5'));
}
if ($model->ud_usertype_id == "3") {
    //Allocated File List Query
    $jobAllocation = JobAllocation::model()->findAll(array("condition" => "ja_qc_id=$model->ud_refid and  ja_flag='A' and DATEDIFF(NOW(), ja_last_modified) <= 7"));
    $jobactivity = JobAllocation::model()->findAll(array("condition" => "ja_qc_id=$model->ud_refid and  ja_flag='A'", 'order' => 'ja_job_id DESC', 'limit' => '5'));
}

/**
 * @JobActivity Count
 */
if ($jobAllocation) {
    //Allocated File List
    $allocatedCount = count($jobAllocation);
    if ($jobAllocation) {
        $completedFilelist = array();
        foreach ($jobAllocation as $viewJob) {
            $fileList = isset($viewJob->fileinfo->fi_status) ? ($viewJob->fileinfo->fi_status == "C" ? $viewJob->fileinfo->fi_status : '') : '';
            if ($fileList) {
                $completedFilelist[] = $fileList;
            }
        }
        //Completed File List
        $completedlist = count($completedFilelist);
    }
}
?>
<?php if ($model->ud_usertype_id == 4 || $model->ud_usertype_id == 3) { ?>
    <div class="uk-grid allign-element">
        <div class="uk-width-1-2">
            <a href="#" title="Allocated Files">Allocated<span class="uk-badge uk-badge-notification uk-badge-warning" style="margin-bottom: 23px;"><?php echo $allocatedCount; ?></span></a>
        </div>
        <div class="uk-width-1-2">
            <a href="#" title="Completted Files">Completed<span class="uk-badge uk-badge-notification uk-badge-warning" style="margin-bottom: 23px;"><?php echo $completedlist ?></span></a>
        </div>
    </div>
    <?php
}
?>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">
        <div style="text-align: center;padding: 15px;width: 130px;border: 1px solid #cfcfcf;border-radius: 67%;height: 130px;margin: 15px auto;overflow: hidden;position: relative;background: #f2f2f2;">
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/sample.png" style="position: absolute;left: 18px;top: 5px;width: 95px;">
        </div>
        <div style="text-align: center;">
            <h2 style="margin-bottom: 5px;color: #555;"><?php echo $model->ud_name; ?></h2></div>
        <div style="text-align: center;margin-bottom: 10px;border-bottom: 1px solid #cfcfcf;">
            <h4 style="font-style: italic;color: #9f9f9f;"><?php echo $model->ud_permanent_address; ?></h4></div>
    </div>
</div>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-1-1">
        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_1', animation:'slide-horizontal'}">
            <?php if ($model->ud_usertype_id == 4 || $model->ud_usertype_id == 3) { ?>
                <li class="uk-active uk-width-1-2"><a href="#">General</a></li>
                <li class="uk-width-1-2" onclick="activeScroll()"><a href="#">Activity</a></li>
            <?php } else { ?>
                <li class="uk-active uk-width-1-1"><a href="#">General</a></li>
            <?php }
            ?>
        </ul>

        <!--<aside id="sidebar_secondarysd" class="tabbed_sidebar">-->
        <div class="scrollbar-inner" style="max-height:275px">
            <ul id="tabs_1" class="uk-switcher">
                <li>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <?php
                            $this->widget('zii.widgets.CDetailView', array(
                                'data' => $model,
                                'attributes' => array(
                                    //'ud_refid',
                                    array(
                                        'name' => 'ud_empid',
                                        'value' => isset($model->ud_empid) ? $model->ud_empid : '',
                                        'visible' => $model->ud_usertype_id != "5",
                                    ),
                                    array(
                                        'name' => 'ud_name',
                                        'value' => isset($model->ud_name) ? $model->ud_name : '',
                                    ),
                                    array(
                                        'name' => 'ud_gender',
                                        'value' => !empty($model->ud_gender) ? $model->ud_gender == 'M' ? 'Male' : 'Female' : '',
                                    ),
                                    array(
                                        'name' => 'ud_dob',
                                        'value' => isset($model->ud_dob) ? $model->ud_dob : '',
                                    ),
                                    array(
                                        'name' => 'ud_marital_status',
                                        'value' => !empty($model->ud_marital_status) ? ($model->ud_marital_status == 'UM' ? 'UnMarried' : 'Married') : '',
                                    ),
                                    array(
                                        'name' => 'ud_email',
                                        'value' => isset($model->ud_email) ? $model->ud_email : '',
                                    ),
                                    array(
                                        'name' => 'ud_temp_address',
                                        'value' => isset($model->ud_temp_address) ? $model->ud_temp_address : '',
                                    ),
                                    array(
                                        'name' => 'ud_permanent_address',
                                        'value' => isset($model->ud_permanent_address) ? $model->ud_permanent_address : '',
                                    ),
                                    array(
                                        'name' => 'ud_mobile',
                                        'value' => isset($model->ud_mobile) ? $model->ud_mobile : '',
                                    ),
                                    array(
                                        'name' => 'ud_emergency_contatct_details',
                                        'value' => isset($model->ud_emergency_contatct_details) ? $model->ud_emergency_contatct_details : '',
                                    ),
                                    array(
                                        'name' => 'ud_cat_id',
                                        'type'=>'raw',
                                        //'value'=>isset($model->Category->ct_cat_name)?$model->Category->ct_cat_name:"",
                                        'value' => "<span style='word-break:break-all;'>".catergory($model->ud_cat_id)."</span>",
                                        'visible' => $model->ud_usertype_id != "5",
                                    ),
                                    array(
                                        //'header'=>'Team Lead',
                                        'name' => 'Team Lead ',
                                        'value' => isset($model->ud_teamlead_id) ? Yii::app()->filerecord->getUsername($model->ud_teamlead_id) : "",
                                        'visible' => ($model->ud_usertype_id == 3 || $model->ud_usertype_id == 4),
                                    ),
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </li>
                <?php if ($model->ud_usertype_id == 4 || $model->ud_usertype_id == 3) { ?>
                    <li>
                        <div class="uk-grid">
                            <div class="uk-width-1-1">
                                <h3 class="uk-text-left">Recent Activity</h3>
                                <?php
                                $colorArr = array("timeline_icon_success", "timeline_icon_danger", "timeline_icon_primary", "timeline_icon_warning");
                                if ($jobactivity) {
                                    $i = 0;
                                    foreach ($jobactivity as $jobValue) {
                                        ?>
                                        <div class="timeline uk-text-left">
                                            <div class="timeline_item">
                                                <div class="timeline_icon <?php echo isset($colorArr[$i]) ? $colorArr[$i] : $colorArr[0]; ?>">
                                                    <i class="material-icons"></i></div>
                                                <div class="timeline_date">
                                                    <?php
                                                    // echo $jobValue->ja_job_id;
                                                    if ($model->ud_usertype_id == 4) {
                                                        $allocated = $jobValue->ja_reviewer_allocated_time; // 11 October 2013
                                                        $completed = $jobValue->ja_reviewer_completed_time; // 13 October 2013
                                                        if ($completed != '0000-00-00 00:00:00') {
                                                            echo "<h4 class='uk-text-left'>$jobValue->ja_reviewer_completed_time</h4>";
                                                            //$status = $jobValue->ja_partition_id != 0 ? "Spllitting Completed" : "Prepping Completed";
                                                            echo "<span class='uk-text-left'>" . getTittle($jobValue) . "</span>";
                                                            echo "<span class='uk-text-left'>" . $jobValue->fileinfo->fi_file_name . "</span>";
                                                        } else {
                                                            echo "<h4 class='uk-text-left'>$jobValue->ja_reviewer_allocated_time</h4>";
                                                            //$status = $jobValue->ja_partition_id != 0 ? "Spllitting Allocated" : "Prepping Allocated";
                                                            echo "<span class='uk-text-left'>" . getTittle($jobValue) . "</span>";
                                                            echo "<span class='uk-text-left'>" . $jobValue->fileinfo->fi_file_name . "</span>";
                                                        }
                                                    }
                                                    if ($model->ud_usertype_id == 3) {
                                                        $allocated = new DateTime($jobValue->ja_qc_accepted_time); // 11 October 2013
                                                        $completed = new DateTime($jobValue->ja_qc_completed_time); // 13 October 2013
                                                        if (!$completed) {
                                                            echo "<h4 class='uk-text-left'>$jobValue->ja_qc_completed_time</h4>";
                                                            // $status = $jobValue->ja_partition_id != 0 ? "QC Spllitting Completed" : "QC Prepping Completed";
                                                            echo "<span class='uk-text-left'>" . getTittle($jobValue) . "</span>";
                                                            echo "<span class='uk-text-left'>" . $jobValue->fileinfo->fi_file_name . "</span>";
                                                        } else {
                                                            echo "<h4 class='uk-text-left'>$jobValue->ja_qc_accepted_time</h4>";
                                                            // $status = $jobValue->ja_partition_id != 0 ? "QC Spllitting Allocated" : "QC Prepping Allocated";
                                                            echo "<span class='uk-text-left'>" . getTittle($jobValue) . "</span>";
                                                            echo "<span class='uk-text-left'>" . $jobValue->fileinfo->fi_file_name . "</span>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!--</aside>-->
    </div>
</div>

<?php

function catergory($id) {
    $out = '';
    $explode = explode(',', $id);
    $query = Category::model()->findAllByPk($explode);
    if ($query) {
        $queryArray = array();
        foreach ($query as $querydata) {
            $queryArray[] = $querydata->ct_cat_name;
        }
        $out = implode(',', $queryArray);
    }
    return $out;
}

function getTittle($jobValue) {
    $data = '';
    switch ($jobValue->ja_status) {
        case 'IA':
            $data = 'Prepping Allocated';
            break;
        case 'IC':
            $data = 'Prepping Completed';
            break;
        case 'IQP':
            $data = 'Prepping Allocated';
            break;
        case 'QC':
            $data = $jobValue->ja_partition_id == 0 ? 'Prepping Completed' : 'Dos Completed';
            break;
        case 'SA':
            $data = 'Dos Allocated';
            break;
        case 'SC':
            $data = 'Dos Completed';
            break;
        case 'SQP':
            $data = 'Dos Allocated';
            break;
        case 'EA':
            $data = 'Review Allocated';
            break;
        case 'EC':
            $data = 'Review Completed';
            break;
        case 'QEA':
            $data = 'Review Allocated';
            break;
        case 'QEC':
            $data = 'Review Completed';
            break;
        default:
            $data = 'No result';
            break;

    }
    return $data;

}


?>
<script src="<?php echo $path . "assets/js/uikit_custom.min.js"; ?>"></script>
<script>
    jQuery(document).ready(function () {
        //altair_secondary_sidebar.init();
    });
</script>

