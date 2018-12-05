<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/pages/forms_advanced.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/kendo-ui/styles/kendo.common-material.min.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/kendo-ui/styles/kendo.material.min.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/css/jquery-ui.css">
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/kendoui_custom.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/pages/kendoui.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/jquery-ui.js"></script>
<?php
$hhh = json_decode($pjson, true);
$ecd9Arr = array();
$ecd10Arr = array();
$dxArr = array();
$bodyArr = array();
$proArr = array();
$facArr = array();
if (!empty($hhh)) {
    $ecd9Arr = $hhh["E"];
    $ecd10Arr = $hhh["N"];
    $dxArr = $hhh["DX"];
    $bodyArr = $hhh["B"];
    $proArr = $hhh["P"];
    $facArr = $hhh["F"];
}
if (count($ecd9Arr) > 0) {
    $ecd9Arr = array_combine($ecd9Arr, $ecd9Arr);
}
if (count($ecd10Arr) > 0) {
    $ecd10Arr = array_combine($ecd10Arr, $ecd10Arr);
}
if (count($dxArr) > 0) {
    $dxArr = array_combine($dxArr, $dxArr);
}
if (count($bodyArr) > 0) {
    $bodyArr = array_combine($bodyArr, $bodyArr);
}
if (count($proArr) > 0) {
    $proArr = array_combine($proArr, $proArr);
}
if (count($facArr) > 0) {
    $facArr = array_combine($facArr, $facArr);
}
if (count($dxArr) > 0) {
    $dxArr = array_combine($dxArr, $dxArr);
}
?>
<style>
    table.table_check {
        width: 100%;
    }
    table.table_check thead tr.filters td input {
        width: 120px;
        border-radius: 3px;
        padding: 7px;
        border: solid 1px #dcdcdc;
        transition: box-shadow 0.3s, border 0.3s;
    }
    table.table_check thead tr.filters td select {
        width: 100px;
        border-radius: 3px;
        padding: 6px;
        border: solid 1px #dcdcdc;
        transition: box-shadow 0.3s, border 0.3s;
    }
    table.table_check thead tr td {
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 130px;
        overflow: hidden;
        max-width: 130px;
    }
    table.table_check tbody tr td {
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 130px;
        overflow: hidden;
        max-width: 130px;
    }
    .row_checked {
        background: #e3f2fd;
    }
    .uk-achor a {
        display: inline-block;
    }
    .div-focus {
        border: 1px solid #1976d2;
        box-shadow: 0 0 5px #1976d2;
        outline: none;
    }
    .md-btn-blue-darken-1 {
        background: #1e88e5;
        color: #fff;
    }
    .splitbtn {
        padding: 0px 25px;
    }
    .md-list-heading {
        font-weight: bold !important;
    }
    #dateCodeLeg {
        width: 97%;
    }
    #dateCodeLeg > div {
        float: left;
        padding-top: 15px;
    }
    #dateCodeLeg > div:nth-child(2), #dateCodeLeg > div:nth-child(3) {
        padding-left: 25px;
    }
    .dateCodeLegPar {
        border: 1px solid grey;
        box-shadow: 2px 2px 4px grey;
        border-radius: 3px;
        margin: 0;
    }
    .uk-pagination > .uk-active > a {
        background: #00a8e6 !important;
    }
    .uk-non a {
        border: 1px solid black !important;
    }
    .uk-mon a {
        border: 1px solid #016e96 !important;
    }
    .uk-hide {
        display: none !important;
    }
    .uk-pagination {
        float: left;
    }
    .btn_shadow {
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.45) !important;
    }
    /* tooltip process*/

    .tooltip {
        transform: none;
        margin: 50px;
    }
    .tooltip:hover > .tooltip-text {
        pointer-events: auto;
        opacity: 1.0;
    }
    .tooltip > .tooltip-text {
        display: block;
        position: absolute;
        z-index: 6000;
        overflow: visible;
        padding: 5px 8px;
        margin-top: 10px;
        line-height: 16px;
        border-radius: 4px;
        text-align: left;
        color: #fff;
        background: #000;
        pointer-events: none;
        opacity: 0.0;
        -o-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }
    /* Arrow */
    .tooltip > .tooltip-text:before {
        display: inline;
        top: -5px;
        content: "";
        position: absolute;
        border: solid;
        border-color: rgba(0, 0, 0, 1) transparent;
        border-width: 0 .5em .5em .5em;
        z-index: 6000;
        left: 20px;
    }
    /* Invisible area so you can hover over tooltip */
    .tooltip > .tooltip-text:after {
        top: -20px;
        content: " ";
        display: block;
        height: 20px;
        position: absolute;
        width: 60px;
        left: 20px;
    }
    .tooltip-scroll {
        overflow-y: auto;
        max-height: 50px;
    }
    .cls {
        position: relative;
        /*top: -5px;*/
        margin: 0;
        right: -28px;
        color: white;
        z-index: 1101;
        background: #ff8080;
        padding: 8px;
        /*border-radius: 28px;*/
        height: 100%;
        width: 10%;
    }
    #the-canvas {
        min-height: 544px !important;
        max-width: 571px !important;
    }
    #the-canvas1 {
        max-width: 571px !important;
        min-height: 544px !important;
    }
    .magnify { position: relative; }
    .large {
        width: 800px; height: 1000px;
        position: absolute;
        box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85),
        0 0 7px 7px rgba(0, 0, 0, 0.25),
        inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
        background-repeat: no-repeat;
        transform: scale(1.5, 1.5);
        display: none;
    }
    .small { display: block; }
</style>
<?php
$url = '';
$id = '';
$job_id = '';
$partition_id = '';
$file_id = '';
$poject_id = '';
$cat_id = '';
$oldpage = '';
$showlink = false;
$type = '';
$pageCount = '';
$meddis = '';
$nonmeddis = '';
if (isset($_GET['id']) && isset($_GET['status'])) {
    $partition_id = $_GET['id'];
    $type = $_GET['status'];
    $filePartition = FilePartition::model()->findByPk($partition_id);
    $nonpartition = FilePartition::model()->findByPk($nonMedPart);
    $medarrays = json_encode(explode(',', $filePartition->fp_page_nums), JSON_NUMERIC_CHECK);
    $nonmedarrays = json_encode(explode(',', $nonpartition->fp_page_nums), JSON_NUMERIC_CHECK);

    if ($filePartition) {
        $file_id = $filePartition->fp_file_id;
        $firstpage = explode(',', $filePartition->fp_page_nums);
        $pageCount = count(explode(',', $filePartition->fp_page_nums));
        $oldpage = json_encode(explode(',', $filePartition->fp_page_nums));
        $showlink = true;
        if (isset($filePartition->FileInfo->fi_file_ori_location)) {
            $url = Yii::app()->baseUrl . '/' . $filePartition->FileInfo->fi_file_ori_location;
        }
        $template_name = $filePartition->FileInfo->ProjectMaster->template->t_name;
        $cat_id = isset($filePartition->FileInfo->ProjectMaster->p_category_ids) ? $filePartition->FileInfo->ProjectMaster->p_category_ids : '';
        $noncat_id = isset($filePartition->FileInfo->ProjectMaster->non_cat_ids) && ($filePartition->FileInfo->ProjectMaster->non_cat_ids != '') ?
            $filePartition->FileInfo->ProjectMaster->non_cat_ids : 0;
        $poject_id = isset($filePartition->FileInfo->fi_pjt_id) ? $filePartition->FileInfo->fi_pjt_id : '';

        $prj_dt_format = Project::model()->findByPk($poject_id);
        $data = array();
        if (!empty($prj_dt_format->date_format)) {
            $data = array_values(json_decode($prj_dt_format->date_format, true));
            $datakey = array_keys(json_decode($prj_dt_format->date_format, true));
        }
        $format = !empty($data[0]) ? $data[0] : 'dd/mm/yyyy';
        $check_skip_edt = Project::model()->findByPk($poject_id);
        /* if ($type == "R") {
          $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "SA", 'ja_flag' => 'A'));
          } else {
          $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "SQP", 'ja_flag' => 'A'));
          } */
        if ($job_model) {
            $job_id = $job_model->ja_job_id;
            if ($job_model->ja_med_status == 'C') {
                $meddis = 'disabled';
            }
            if ($job_model->ja_nonmed_status == 'C') {
                $nonmeddis = 'disabled';
            }
        }
    }
}
?>
<div class="md-card" data-uk-sticky="{ top: 48, media: 960 }" style="margin: 0px;">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-1-1 uk-achor">
                <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4', animation:'scale'}">
                    <li class="uk-width-1-2 uk-active medtab" onclick="Getpages('M')"><a href="#">Medical</a></li>
                    <li class="uk-width-1-2 nonmedtab" onclick="Getpages('N')"><a href="#">Non medical</a></li>
                </ul>
            </div>
        </div>
        <div class="uk-grid yespages">
            <div class="uk-width-3-10 uk-achor">
                <a id="prev" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)" title="Press left arrow key" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE314;</i></a>
                <a id="next" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)" title="Press right arrow key" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE315;</i></a>
                <!--<a class="md-fab md-fab-small md-fab-primary" href="<?php //echo $url; ?>" target="_blank" title="Pdf" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE89D;</i></a>-->
                <!--<a class="md-fab md-fab-small md-fab-primary view_short" href="javascript:void(0)" title="View Shortcuts" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">visibility</i></a>
                        <div id="kUI_window" style="display: none">
        <table class="uk-table uk-table-hover">
                                        <thead>
                                                <tr>
                                                        <th>Shortcuts</th>
                                                        <th>Description</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                        <td><span class="uk-badge uk-badge-primary status-badge">Left Arrow</span></td>
                                                        <td>Previous Page</td>
                                                </tr>
                                                <tr>
                                                        <td><span class="uk-badge uk-badge-primary status-badge">Right Arrow</span></td>
                                                        <td>Next Page</td>
                                                </tr>
                                                <tr>
                                                        <td><span class="uk-badge uk-badge-primary status-badge">Ctrl-Left Arrow</span></td>
                                                        <td>Deselect page</td>
                                                </tr>
                                                <tr>
                                                        <td><span class="uk-badge uk-badge-primary status-badge">Ctrl-Right Arrow</span></td>
                                                        <td>Select Page</td>
                                                </tr>
                                                <tr>
                                                        <td><span class="uk-badge uk-badge-primary status-badge">Esc</span></td>
                                                        <td>Change Focus Between PDF and Form</td>
                                                </tr>
                                                <tr>
                                                        <td><span class="uk-badge uk-badge-primary status-badge">+</span></td>
                                                        <td>Select Break Files</td>
                                                </tr>
                                        </tbody>
                                </table>
    </div>-->
                <a class="md-fab md-fab-small md-fab-primary zoom_in" href="javascript:void(0)" title="Zoom In" data-uk-tooltip="{pos:'bottom'}" onclick="zooming('in')"><i class="material-icons md-24 icon-white uk-text-bold">zoom_in</i></a>
                <a class="md-fab md-fab-small md-fab-primary zoom_out" href="javascript:void(0)" title="Zoom Out" onclick="zooming('out')" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">zoom_out</i></a>
                <a id="non_medical" class="md-fab md-fab-small md-fab-primary" onclick="non_medical()" href="javascript:void(0)" title="NonMedical Page" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">call_received</i></a>
                <a id="medicalmodal" class="md-fab md-fab-small md-fab-primary" onclick='medicalmodal()' title="Medical Page" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">call_made</i></a>
                <a id="pageRange" class="md-fab md-fab-small md-fab-primary" onclick='pageRange()' title="Page Range" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">settings_ethernet</i></a>
                <a id="missingPage" class="md-fab md-fab-small md-fab-primary" onclick='getMissingPages()' title="Missing Pages" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">find_in_page</i>
                </a>
            </div>
            <div class="uk-width-4-10 uk-container-center">
                <!--<div class="uk-width-medium-1-1" style="text-align:center;">
                    <h5><b>Move to Non-Medical</b><h5>
                </div>-->
                <div class="uk-width-medium-1-1">
                    <ul class="uk-pagination">

                    </ul>
                </div>
            </div>
            <div class="uk-width-1-10 uk-achor" style="font-size:12px; padding-top:7px;">
                <span class="uk-text-center">PageCount: <span id="page_count"><?php echo $pageCount ?></span></span>
            </div>
            <div class="uk-width-1-10 uk-achor">
                <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                <input type="number" id="pageNumber" class="toolbarField pageNumber md-input pgsearch1" value="1" size="4" min="1" tabindex="15">
            </div>
            <div class="uk-width-small-1-10 uk-achor">
                <div class="uk-float-left">
                    <a id="pagesearch" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8B6;</i></a>
                </div>
                <div class="uk-align-right uk-align-center">
                    <!--<span class="uk-text-center">PageNo: <span id="page_num"></span> / PageCount: <span id="page_count"><?php echo $pageCount ?></span></span>-->
                    <!--<a id="non_medical" class="md-fab md-fab-small md-fab-primary" 'onclick' ='non_medical()' href="javascript:void(0)" title="NonMedicalpPage" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">report</i></a>-->
                    <?php /* <a class="md-fab md-fab-small md-fab-primary tooltip" href="<?php echo Yii::app()->createUrl('fileinfo/indexalloc') ?>"><i class="material-icons md-24 icon-white uk-text-bold">&#xE5C4;</i><span class="tooltiptext">Back</span></a> */ ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;">
    <span class="uk-text-center">PageNo: <span id="page_num"></span> / PageCount: <span id="page_count"><?php echo $pageCount ?></span></span>
</div>
<!--<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
                        <div class="uk-width-medium-1-1" style="text-align:center;">
                                <h4><b>Move to Non-Medical</b><h4>
                        </div>
                        <div class="uk-width-1-1 uk-container-center">
                                <div class="uk-width-medium-1-1">
                                        <ul class="uk-pagination">

                                        </ul>
                </div>
            </div>
                </div>
        </div>
</div>-->
<div class="md-card">
    <div class="md-card-content">
        <ul id="tabs_4" class="uk-switcher uk-margin">
            <li>
                <div class="uk-grid">
                </div>

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'file-partition-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => true,
                        'afterValidate' => 'js:function(form, data, hasError) { saveUserForm(form, data, hasError); }',
                    ),
                ));
                ?>
                <div>
                    <span class="curPageNewDiv" style="display:none">
                        <strong>Source page:</strong><span class="curPageNew"></span>
                    </span>
                    <span class="curPageNewDiv1" style="display:none">
                        <strong>Medical page:</strong><span class="curPageNew1"></span>
                    </span>
                </div>

                <div class="uk-grid dateCodeLegPar">
                    <!--<fieldset><legend>dsdsdsd</legend>-->
                    <?php if ($template_name == "BACTESPDF") { ?>
                        <div id="dateCodeLeg">
                            <div class="uk-width-1-5">
                                <?php echo $form->labelEx($model, 'patient_name'); ?>
                                <?php
                                echo $form->textField($model, 'patient_name', array('class' => "md-input label-fixed",
                                    'onfocus' => 'elementFocus()', 'data-name' => 'patient_name'));
                                ?>
                                <?php echo $form->hiddenField($model, 'project', array('class' => "md-input", 'value' => $poject_id, 'data-name' => 'project')); ?>
                                <?php echo $form->error($model, 'patient_name'); ?>
                            </div>
                            <div class="uk-width-1-5">
                                <?php echo $form->labelEx($model, 'dob'); ?>
                                <?php
                                echo $form->textField($model, 'dob', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
                                    'onfocus' => 'elementFocus()', 'data-name' => 'dob'));
                                ?>
                                <?php echo $form->error($model, 'dob'); ?>
                            </div>

                            <div class="uk-width-1-5 ">
                                <?php echo $form->labelEx($model, 'ms_value'); ?>
                                <?php
                                echo $form->textField($model, 'ms_value', array('class' => "md-input masked_input label-fixed", 'onfocus' => 'elementFocus()', 'data-name' => 'ms_value'));
                                ?>
                                <?php echo $form->error($model, 'ms_value'); ?>
                            </div>

                            <div class="uk-width-1-5">
                                <?php echo $form->labelEx($model, 'gender'); ?>
                                <?php
                                echo $form->radioButtonList($model, 'gender', array('M' => 'Male',
                                    'F' => 'Female',
                                ), array(
                                    'labelOptions' => array('style' => 'display:inline'), // add this code
                                    'separator' => '  ',
                                    'data-md-icheck' => "",
                                    'onfocus' => 'elementFocus()',
                                    'data-name' => 'gender'
                                ));
                                ?>
                                <?php echo $form->error($model, 'gender'); ?>
                            </div>

                            <div class="uk-width-1-5">
                                <?php echo $form->labelEx($model, 'doi'); ?>
                                <?php
                                echo $form->textField($model, 'doi', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
                                    'onfocus' => 'elementFocus()', 'data-name' => 'doi'));
                                ?>
                                <?php echo $form->error($model, 'doi'); ?>
                            </div>

                            <!--</fieldset>-->
                        </div>
                    <?php } else { ?>
                        <div id="dateCodeLeg">
                            <div class="uk-width-1-4">
                                <?php echo $form->labelEx($model, 'patient_name'); ?>
                                <?php
                                echo $form->textField($model, 'patient_name', array('class' => "md-input label-fixed",
                                    'onfocus' => 'elementFocus()', 'data-name' => 'patient_name'));
                                ?>
                                <?php echo $form->hiddenField($model, 'project', array('class' => "md-input", 'value' => $poject_id, 'data-name' => 'project')); ?>
                                <?php echo $form->error($model, 'patient_name'); ?>
                            </div>
                            <div class="uk-width-1-4">
                                <?php echo $form->labelEx($model, 'dob'); ?>
                                <?php
                                echo $form->textField($model, 'dob', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
                                    'onfocus' => 'elementFocus()', 'data-name' => 'dob'));
                                ?>
                                <?php echo $form->error($model, 'dob'); ?>
                            </div>
                            <div class="uk-width-1-4">
                                <?php echo $form->labelEx($model, 'gender'); ?>
                                <?php
                                echo $form->radioButtonList($model, 'gender', array('M' => 'Male',
                                    'F' => 'Female',
                                ), array(
                                    'labelOptions' => array('style' => 'display:inline'), // add this code
                                    'separator' => '  ',
                                    'data-md-icheck' => "",
                                    'onfocus' => 'elementFocus()',
                                    'data-name' => 'gender'
                                ));
                                ?>
                                <?php echo $form->error($model, 'gender'); ?>
                            </div>
                            <div class="uk-width-1-4">
                                <?php echo $form->labelEx($model, 'doi'); ?>
                                <?php
                                echo $form->textField($model, 'doi', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
                                    'onfocus' => 'elementFocus()', 'data-name' => 'doi'));
                                ?>
                                <?php echo $form->error($model, 'doi'); ?>
                            </div>
                            <!--</fieldset>-->
                        </div>
                    <?php } ?>
                </div>
                <div class="uk-grid" style="margin-left:0;">
                    <!--PDF Element--->
                    <div class="uk-width-medium-3-6 div-focus canvas_outer" id="indexdiv" tabindex="-1" style="text-align:center;overflow:scroll;padding-left: 0;position: relative">
                        <div class="magnify">
                            <canvas id="the-canvas" class="small" style="border:1px solid black;min-width:562 !important;min-width:571 !important"></canvas>
                            <div class="large"></div>
                        </div>
                    </div>
                    <!--Form Elementt--->
                    <div class="uk-width-medium-3-6">
                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_5'}">
                            <li class="uk-width-1-3 uk-active medform_tab" id="medform_li" onclick="Getmpartition('F')">
                                <a href="#">Form</a></li>
                            <li class="uk-width-1-3 medpart_tab" onclick="Getmpartition('P')"><a href="#">Partitions</a>
                            </li>
                        </ul>
                        <ul id="tabs_5" class="uk-switcher uk-margin">
                            <li>
                                <div class="md-card" style="border:1px solid black;" id="indexform" tabindex='1'>

                                    <div class="md-card-content" style="position: relative">
                                        <!--<canvas id="zoom" width="300" height="200" style="position:absolute; border:5px solid #2f6daa; top:0px; left:0px; display:none; z-index:999"></canvas>-->

                                        <!--<h4 class="heading_a" style="text-align:center ">Date Coding</h4>-->
                                        <?php echo CHtml::hiddenField('medid', "", array('id' => 'medid')); ?>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php //echo $form->labelEx($model, 'pages');  ?>
                                                <?php
                                                echo $form->textField($model, 'pages', array('class' => "md-input label-fixed DateCoding_pages medpages", 'readonly' => true
                                                , 'onfocus' => 'elementFocus()', 'data-name' => 'pages'));
                                                ?>
                                                <?php //echo CHtml::hiddenField('skips', '', array('id'=> 'skips', 'class' => "md-input label-fixed", 'readonly' => true));   ?>
                                                <?php echo $form->hiddenField($model, 'file', array('value' => $file_id, 'data-name' => 'file')); ?>
                                                <?php //echo $form->error($model, 'pages');   ?>

                                            </div>
                                        </div>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-3 ">
                                                <?php echo $form->labelEx($model, 'dos'); ?>
                                                <?php
                                                echo $form->textField($model, 'dos', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
                                                    'onfocus' => 'elementFocus()', 'data-name' => 'dos'));
                                                ?>
                                                <?php echo $form->error($model, 'dos'); ?>
                                            </div>
                                            <div class="uk-width-medium-1-3 ">
                                                <?php //echo $form->labelEx($model, 'todos'); ?>
                                                <?php
                                                echo $form->textField($model, 'todos', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': '$format'", "data-inputmask-showmaskonhover" => false,
                                                    'onfocus' => 'elementFocus()', 'data-name' => 'todos'));
                                                ?>
                                                <?php echo $form->error($model, 'todos'); ?>
                                            </div>
                                            <div class="uk-width-medium-1-3">
                                                <label>Undated</label>
                                                <?php
                                                echo $form->checkBox($model, 'undated');
                                                ?>
                                            </div>
                                        </div>
                                        <?php if ($check_skip_edt->p_name != "MV") { ?>
                                            <div class="uk-grid" data-uk-grid-margin="">
                                                <div class="uk-width-medium-1-1">
                                                    <?php echo $form->labelEx($model, 'provider_name'); ?>
                                                    <?php
                                                    //echo $form->textField($model, 'provider_name', array('class' => "md-input label-fixed",
                                                    // 'onfocus' => 'elementFocus()'));
                                                    //                                        echo $form->textArea($model, 'provider_name', array('class' => "md-input label-fixed",
                                                    //                                            'onfocus' => 'elementFocus()', 'data-name' => 'provider_name'));
                                                    echo $form->dropDownList($model, 'provider_name', $proArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_provider_name'));
                                                    ?>
                                                    <?php echo $form->error($model, 'provider_name'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php echo $form->hiddenField($model, 'record_row', array('class' => "md-input", 'data-name' => 'record_row')); ?>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php echo $form->labelEx($model, 'category'); ?>
                                                <?php
                                                echo $form->dropDownList($model, 'category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and (ct_cat_id IN($cat_id) or ct_cat_name ='Duplicate' or ct_cat_name ='Others')")), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category',
                                                    'onfocus' => 'elementFocus()', 'class' => "DateCoding_category", 'data-name' => 'category'));
                                                ?>
                                                <?php echo $form->error($model, 'category'); ?>
                                                <?php echo $form->hiddenField($model, 'type', array('class' => "md-input", 'value' => "M", 'data-name' => 'type')); ?>
                                            </div>
                                        </div>
                                        <?php if ($check_skip_edt->p_name != "MV") { ?>
                                            <div class="uk-grid" data-uk-grid-margin="">
                                                <?php
                                                $mediumclass = $check_skip_edt->skip_edit != 1 ? 'uk-width-medium-1-2' : 'uk-width-medium-2-2';
                                                ?>
                                                <div class='<?php echo $mediumclass; ?>'>
                                                    <?php echo $form->labelEx($model, 'facility'); ?>
                                                    <?php
                                                    //                                        echo $form->textField($model, 'facility', array('class' => "md-input label-fixed",
                                                    //                                            'onfocus' => 'elementFocus()', 'data-name' => 'facility'));
                                                    echo $form->dropDownList($model, 'facility', $facArr, array('onfocus' => 'elementFocus()', 'empty' => 'Select Facility', 'class' => 'DateCoding_facility'));
                                                    ?>
                                                    <?php echo $form->error($model, 'facility'); ?>
                                                </div>
                                                <?php if ($check_skip_edt->skip_edit != 1) { ?>
                                                    <div class="uk-width-medium-1-2 ">
                                                        <?php echo $form->labelEx($model, 'title'); ?>
                                                        <?php
                                                        echo $form->textField($model, 'title', array('class' => "md-input label-fixed",
                                                            'onfocus' => 'elementFocus()', 'data-name' => 'title'));
                                                        ?>
                                                        <?php echo $form->error($model, 'title'); ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php if ($check_skip_edt->skip_edit == 1) { ?>
                                                <div class="uk-grid" data-uk-grid-margin="">
                                                    <div class="uk-width-medium-1-1 ">
                                                        <?php echo $form->labelEx($model, 'body_parts'); ?>
                                                        <?php
                                                        //                                            echo $form->textArea($model, 'body_parts', array('class' => "md-input label-fixed",
                                                        //                                                'onfocus' => 'elementFocus()', 'data-name' => 'body_parts'));
                                                        echo $form->dropDownList($model, 'body_parts', $bodyArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_body_parts'));
                                                        echo $form->hiddenField($model, 'title', array('class' => "md-input label-fixed", 'data-name' => 'title'));
                                                        ?>
                                                        <?php echo $form->error($model, 'body_parts'); ?>
                                                    </div>
                                                </div>
                                                <div class="uk-grid" data-uk-grid-margin="">
                                                    <div class="uk-width-medium-1-2 ">
                                                        <?php echo $form->labelEx($model, 'ecd_9_diagnoses'); ?>
                                                        <?php
                                                        //echo $form->textArea($model, 'ecd_9_diagnoses', array('class' => "md-input label-fixed",
                                                        //'onfocus' => 'elementFocus()', 'data-name' => 'ecd_9_diagnoses'));
                                                        //                                          echo   $form->dropDownList($model, 'ecd_9_diagnoses', CHtml::listData(Project::model()->findAll(array("condition" => "p_flag = 'A'")), 'p_pjt_id', 'p_name'), array('multiple' => true));
                                                        echo $form->dropDownList($model, 'ecd_9_diagnoses', $ecd9Arr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_ecd_9_diagnoses'));
                                                        ?>
                                                        <?php echo $form->error($model, 'ecd_9_diagnoses'); ?>
                                                    </div>
                                                    <div class="uk-width-medium-1-2 ">
                                                        <?php echo $form->labelEx($model, 'ecd_10_diagnoses'); ?>
                                                        <?php
                                                        //                                            echo $form->textArea($model, 'ecd_10_diagnoses', array('class' => "md-input label-fixed",
                                                        //                                                'onfocus' => 'elementFocus()', 'data-name' => 'ecd_10_diagnoses'));
                                                        echo $form->dropDownList($model, 'ecd_10_diagnoses', $ecd10Arr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_ecd_10_diagnoses'));
                                                        ?>
                                                        <?php echo $form->error($model, 'ecd_10_diagnoses'); ?>
                                                    </div>
                                                </div>
                                                <div class="uk-grid" data-uk-grid-margin="">
                                                    <div class="uk-width-medium-1-1 ">
                                                        <?php echo $form->labelEx($model, 'dx_terms'); ?>
                                                        <?php
                                                        //                                            echo $form->textArea($model, 'dx_terms', array('class' => "md-input label-fixed",
                                                        //                                                'onfocus' => 'elementFocus()', 'data-name' => 'dx_terms'));
                                                        echo $form->dropDownList($model, 'dx_terms', $dxArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_dx_terms'));
                                                        ?>
                                                        <?php echo $form->error($model, 'dx_terms'); ?>
                                                    </div>
                                                </div>
                                                <?php if ($template_name == "BACTESPDF") { ?>
                                                    <div class="uk-grid" data-uk-grid-margin="">
                                                        <div class="uk-width-medium-1-1 ">
                                                            <?php echo $form->labelEx($model, 'ms_terms'); ?>
                                                            <?php
                                                            echo $form->textField($model, 'ms_terms', array('class' => "md-input label-fixed", 'onfocus' => 'elementFocus()', 'data-name' => 'ms_terms'));
                                                            ?>
                                                            <?php echo $form->error($model, 'ms_terms'); ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php echo CHtml::submitButton('Create', array('class' => "md-btn md-btn-success splitbtn createbtn shad_btn")); ?>
                                                <?php //echo CHtml::button('Finish', array('id' => 'medfinish','class' => "md-btn md-btn-primary $meddis", 'onclick' => "finishFile('M')"));  ?>
                                                <?php if ($_GET['status'] == 'QC') { ?>
                                                    <?php if (Yii::app()->session['user_type'] != 'A' && Yii::app()->session['user_type'] != 'TL') { ?>
                                                        <?php echo CHtml::button('FeedBack', array('class' => 'md-btn md-btn-primary splitbtn feedbackbtn shad_btn', 'onclick' => "feedback()")); ?>
                                                    <?php } ?>
                                                    <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-warning splitbtn completebtn shad_btn', 'onclick' => 'CompleteQc()')); ?>
                                                <?php } else { ?>
                                                    <?php if ($job_model->ja_status != 'QEC') { ?>
                                                        <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-warning completebtn shad_btn', 'onclick' => 'completeFile()')); ?>
                                                    <?php } ?>
                                                    <?php if (Yii::app()->session['user_type'] != 'A' && Yii::app()->session['user_type'] != 'TL') { ?>
                                                        <?php echo CHtml::button('Quit', array('class' => 'md-btn md-btn-danger quitbtn shad_btn', 'onclick' => 'quit()')); ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php //echo CHtml::button('Move NonMedical', array('class' => 'md-btn md-btn-danger', 'onclick' => 'non_medical()'));    ?>
                                            </div>
                                        </div>
                                        <?php $this->endWidget(); ?>
                                    </div>
                                </div>
                                <!--Old pages-->
                                <div class="md-card" style="border:1px solid black;max-height: 236px;overflow: auto;padding-right: 27px;" id="indexfile">
                                    <div class="md-card-content" id="filerecord">
                                    </div>
                                </div>
                            </li>
                            <!--Old pages-->
                            <li>
                                <div class="md-card" style="border:1px solid black;max-height: 1000px;overflow: auto;" id="tab_indexfile">
                                    <div class="md-card-content" id="tab_filerecord">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <?php echo CHtml::hiddenField('medstatus', $job_model->ja_med_status, array('id' => 'medstatus', 'data-name' => 'med_status')); ?>
                    </div>
                </div>
            </li>
            <li>
                <div>
                    <span class="curPageNewDiv">
                        <strong>Source Page:</strong><span class="curPageNew"></span>
                    </span>
                    <span class="curPageNewDiv1" style="display:none">
                        <strong>Non-Medical page:</strong><span class="curPageNew1"></span>
                    </span>
                </div>
                <div class="uk-grid cardcard" style="margin-left:0;">
                    <!--PDF Element--->
                    <div class="uk-width-medium-3-6 div-focus canvas_outer" id="nonindexdiv" tabindex="-1" style="text-align:center;overflow:scroll;padding-left: 0">
                        <div class="magnify">
                            <!--<canvas id="the-canvas1" style="border:1px solid black;min-width:562 !important;"></canvas>-->
                            <canvas id="the-canvas1" class="small" style="border:1px solid black;min-width:562 !important;min-width:571 !important"></canvas>
                            <div class="large"></div>
                        </div>

                    </div>
                    <div class="uk-width-medium-3-6">
                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_6'}">
                            <li class="uk-width-1-3 uk-active nonmedform_tab" id="nonmedform_li" onclick="Getnpartition('F')">
                                <a href="#">Form</a></li>
                            <li class="uk-width-1-3 nonmedpart_tab" onclick="Getnpartition('P')">
                                <a href="#">Partitions</a></li>
                        </ul>
                        <ul id="tabs_6" class="uk-switcher uk-margin">
                            <li>
                                <div class="md-card" style="border:1px solid black;" id="nonindexform" tabindex='1'>
                                    <div class="md-card-content">

                                        <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'id' => 'non-partition-form',
                                            'enableAjaxValidation' => false,
                                            'enableClientValidation' => true,
                                            'clientOptions' => array(
                                                'validateOnSubmit' => true,
                                                'validateOnChange' => true,
                                                'afterValidate' => 'js:function(form, data, hasError) { saveNonForm(form, data, hasError); }',
                                            ),
                                        ));
                                        ?>
                                        <?php echo CHtml::hiddenField('nonmedid', "", array('id' => 'nonmedid')); ?>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php //echo $form->labelEx($model, 'pages');  ?>
                                                <?php echo $form->hiddenField($model, 'project', array('class' => "md-input", 'value' => $poject_id)); ?>
                                                <?php
                                                echo $form->textField($model, 'pages', array('class' => "md-input label-fixed DateCoding_nonpages nonmedicalpages", 'readonly' => true
                                                , 'onfocus' => 'elementFocus()', 'data-name' => 'pages1'));
                                                ?>
                                                <?php //echo CHtml::hiddenField('skips', '', array('id'=> 'skips', 'class' => "md-input label-fixed", 'readonly' => true));   ?>
                                                <?php echo $form->hiddenField($model, 'file', array('value' => $file_id, 'data-name' => 'file1')); ?>
                                                <?php //echo $form->error($model, 'pages');   ?>

                                            </div>
                                        </div>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php echo $form->labelEx($model, 'category'); ?>
                                                <?php
                                                //print_r($cat_id);
                                                //echo $noncat_id;
                                                echo $form->dropDownList($model, 'category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and (ct_cat_id IN($noncat_id)) or ct_cat_name ='Duplicate' or ct_cat_name ='Others'")), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category',
                                                    'onfocus' => 'elementFocus()', 'class' => "DateCoding_noncategory", 'data-name' => 'category1'));
                                                ?>
                                                <?php echo $form->error($model, 'category'); ?>
                                                <?php echo $form->hiddenField($model, 'record_row', array('class' => "md-input", 'data-name' => 'record_row1')); ?>
                                                <?php echo $form->hiddenField($model, 'type', array('class' => "md-input", 'value' => "N", 'data-name' => 'type1')); ?>
                                            </div>
                                        </div>
                                        <?php if ($check_skip_edt->skip_edit == 1 && $check_skip_edt->p_name != "MV") { ?>
                                            <div class="uk-grid" data-uk-grid-margin="">
                                                <div class="uk-width-medium-1-1 ">
                                                    <?php echo $form->labelEx($model, 'body_parts'); ?>
                                                    <?php
                                                    //                                            echo $form->textArea($model, 'body_parts', array('class' => "md-input label-fixed",
                                                    //                                                'onfocus' => 'elementFocus()', 'data-name' => 'body_part1'));
                                                    echo $form->dropDownList($model, 'body_parts', $bodyArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_body_parts'));
                                                    ?>
                                                    <?php echo $form->error($model, 'body_parts'); ?>
                                                </div>
                                            </div>
                                            <div class="uk-grid" data-uk-grid-margin="">
                                                <div class="uk-width-medium-1-2 ">
                                                    <?php echo $form->labelEx($model, 'ecd_9_diagnoses'); ?>
                                                    <?php
                                                    //                                            echo $form->textArea($model, 'ecd_9_diagnoses', array('class' => "md-input label-fixed",
                                                    //                                                'onfocus' => 'elementFocus()', 'data-name' => 'ecd_9_diagnoses1'));
                                                    echo $form->dropDownList($model, 'ecd_9_diagnoses', $ecd9Arr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_ecd_9_diagnoses'));
                                                    ?>
                                                    <?php echo $form->error($model, 'ecd_9_diagnoses'); ?>
                                                </div>
                                                <div class="uk-width-medium-1-2 ">
                                                    <?php echo $form->labelEx($model, 'ecd_10_diagnoses'); ?>
                                                    <?php
                                                    //                                            echo $form->textArea($model, 'ecd_10_diagnoses', array('class' => "md-input label-fixed",
                                                    //                                                'onfocus' => 'elementFocus()', 'data-name' => 'ecd_10_diagnoses1'));
                                                    echo $form->dropDownList($model, 'ecd_10_diagnoses', $ecd10Arr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_ecd_10_diagnoses'));
                                                    ?>
                                                    <?php echo $form->error($model, 'ecd_10_diagnoses'); ?>
                                                </div>
                                            </div>
                                            <div class="uk-grid" data-uk-grid-margin="">
                                                <div class="uk-width-medium-1-1 ">
                                                    <?php echo $form->labelEx($model, 'dx_terms'); ?>
                                                    <?php
                                                    //                                            echo $form->textArea($model, 'dx_terms', array('class' => "md-input label-fixed",
                                                    //                                                'onfocus' => 'elementFocus()', 'data-name' => 'dx_terms1'));
                                                    echo $form->dropDownList($model, 'dx_terms', $dxArr, array('multiple' => true, 'onfocus' => 'elementFocus()', 'class' => 'DateCoding_dx_terms'));
                                                    ?>
                                                    <?php echo $form->error($model, 'dx_terms'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php echo CHtml::submitButton('Create', array('class' => "md-btn md-btn-success splitbtn createbtn shad_btn")); ?>
                                                <?php // echo CHtml::button('Finish', array('id' => 'nonmedfinish','class' => "md-btn md-btn-primary $nonmeddis", 'onclick' => "finishFile('N')"));  ?>
                                                <?php if ($_GET['status'] == 'QC') { ?>
                                                    <?php if (Yii::app()->session['user_type'] != 'A' && Yii::app()->session['user_type'] != 'TL') { ?>
                                                        <?php echo CHtml::button('FeedBack', array('class' => 'md-btn md-btn-primary splitbtn feedbackbtn shad_btn', 'onclick' => "feedback()")); ?>
                                                    <?php } ?>
                                                    <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-warning splitbtn completebtn shad_btn', 'onclick' => 'CompleteQc()')); ?>
                                                <?php } else { ?>
                                                    <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-warning completebtn shad_btn', 'onclick' => 'completeFile()')); ?>
                                                    <?php if (Yii::app()->session['user_type'] != 'A' && Yii::app()->session['user_type'] != 'TL') { ?>
                                                        <?php echo CHtml::button('Quit', array('class' => 'md-btn md-btn-danger quitbtn shad_btn', 'onclick' => 'quit()')); ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="uk-grid" data-uk-grid-margin="">
                                            <div class="uk-width-medium-1-1 ">
                                                <?php //echo CHtml::button('Move NonMedical', array('class' => 'md-btn md-btn-danger', 'onclick' => 'non_medical()'));    ?>
                                            </div>
                                        </div>
                                        <?php $this->endWidget(); ?>
                                    </div>
                                </div>
                                <div class="md-card" style="border:1px solid black;max-height: 236px;overflow: auto;padding-right: 27px;" id="nonindexfile">
                                    <div class="md-card-content" id="nonfilerecord">
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="md-card" style="border:1px solid black;max-height: 1000px;overflow: auto;" id="tab_nonindexfile">
                                    <div class="md-card-content" id="tab_nonfilerecord">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <?php echo CHtml::hiddenField('nonmedstatus', $job_model->ja_nonmed_status, array('id' => 'nonmedstatus', 'data-name' => 'nonmedstatus1')); ?>
                    </div>
                </div>
                <div class="uk-accordion accord" data-uk-accordion="{showfirst: false}" data-accordion-section-open="2">
                    <h3 class="uk-accordion-title uk-accordion-title-danger">No Pages in Non-Medical</h3>
                    <div class="uk-accordion-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>


<div id="style_switcher">
    <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
    <div class="uk-margin-medium-bottom">
        <h3><strong>Keyboard Shortcuts</strong></h3>
        <div class="uk-width-large-1-1 uk-width-medium-1-1">
            <ul class="md-list" style="max-height:450px; overflow-y:scroll;">
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Previous Page</span>
                        <span class="uk-text-small uk-text-muted">Left Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Next Page</span>
                        <span class="uk-text-small uk-text-muted">Right Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Deselect Page</span>
                        <span class="uk-text-small uk-text-muted">Ctrl-Left Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Select Page</span>
                        <span class="uk-text-small uk-text-muted">Ctrl-Right Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Zoom In</span>
                        <span class="uk-text-small uk-text-muted">Ctrl-Up Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Zoom Out</span>
                        <span class="uk-text-small uk-text-muted">Ctrl-Down Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Page Range</span>
                        <span class="uk-text-small uk-text-muted">Ctrl+X</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Save</span>
                        <span class="uk-text-small uk-text-muted">Alt-A</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Finish</span>
                        <span class="uk-text-small uk-text-muted">Alt-Z</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Complete</span>
                        <span class="uk-text-small uk-text-muted">Alt-C</span>
                    </div>
                </li>
                <?php if ($_GET['status'] == 'R') { ?>
                    <li>
                        <div class="md-list-content">
                            <span class="md-list-heading">Quit</span>
                            <span class="uk-text-small uk-text-muted">Alt-Q</span>
                        </div>
                    </li>
                <?php } ?>
                <?php if ($_GET['status'] == 'QC') { ?>
                    <li>
                        <div class="md-list-content">
                            <span class="md-list-heading">Feedback</span>
                            <span class="uk-text-small uk-text-muted">Alt-W</span>
                        </div>
                    </li>
                <?php } ?>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Medical tab</span>
                        <span class="uk-text-small uk-text-muted">Alt-Up Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Non-Medical tab</span>
                        <span class="uk-text-small uk-text-muted">Alt-Down Arrow</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Move Chosen pages</span>
                        <span class="uk-text-small uk-text-muted">Alt-Forward Slash</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Switch Focus</span>
                        <span class="uk-text-small uk-text-muted">Esc</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Select Break Files</span>
                        <span class="uk-text-small uk-text-muted">+</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Choose to Non-Medical</span>
                        <span class="uk-text-small uk-text-muted">N</span>
                    </div>
                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Choose to Medical</span>
                        <span class="uk-text-small uk-text-muted">M</span>
                    </div>

                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Full page</span>
                        <span class="uk-text-small uk-text-muted">F11</span>
                    </div>

                </li>
                <li>
                    <div class="md-list-content">
                        <span class="md-list-heading">Page search shortcut</span>
                        <span class="uk-text-small uk-text-muted">Alt+X</span>
                    </div>

                </li>
            </ul>
        </div>
    </div>
</div>

<div id="raneselectModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Page Range Select</h3>
            <button type="button" class="uk-modal-close uk-close" id="rangeclose" style="display: inline-block;float: right;color: #fff;background: #fff;" onChange="modelClose()"></button>
        </div>
        <div class="uk-form-row">
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-3 uk-row-first">
                    <div class="md-input-wrapper">
                        <label>From</label><input class="md-input" id="from" type="text" onkeypress="return isNumber(event)"><span class="md-input-bar "></span>
                    </div>
                </div>
                <div class="uk-width-medium-1-3">
                    <div class="md-input-wrapper"><label>To</label><input class="md-input" id="to"
                                                                          type="text" onkeypress="return isNumber(event)"><span class="md-input-bar "></span>
                    </div>
                    <!--<div class="errorMessage" id="to_error" style="display:none">To page no Exceeds Orginal pdf pages no</div>-->
                </div>

                <div class="uk-width-medium-1-3">
                    <button type="button" id="normal" class="md-btn" onclick="savePages()">Get Range</button>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-1">
                        <div class="errorMessage" id="from_error" style="display:none">Invalid pageno!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button id="raneModal" data-uk-modal="{target:'#raneselectModal'}" style="display: none;"></button>
<div id="PageMissingModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Missing Pages</h3>
            <button type="button" class="uk-modal-close uk-close" id="misclose" style="display: inline-block;float: right;color: #fff;background: #fff;" onChange="modelClose()"></button>
        </div>
        <div class="uk-form-row">
            <div class="uk-width-1-1 uk-achor">
                <ul class="md-list">
                    <li>
                        <div class="md-list-content">
                            <span class="md-list-heading">Medical</span>
                            <div class="uk-text-small uk-text-muted" id="misMedPag"></div>
                        </div>
                    </li>
                    <li>
                        <div class="md-list-content">
                            <span class="md-list-heading">Non-Medical</span>
                            <div class="uk-text-small uk-text-muted" id="misNMedPag"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<button id="pageMisModal" data-uk-modal="{target:'#PageMissingModal'}" style="display: none;"></button>
<script>
    $(function () {
        $("select[name='DateCoding[category]'").chosen();
        $('#file-partition-form #DateCoding_provider_name').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#file-partition-form #DateCoding_facility').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#file-partition-form #DateCoding_body_parts').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#file-partition-form #DateCoding_ecd_9_diagnoses').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#file-partition-form #DateCoding_ecd_10_diagnoses').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#file-partition-form #DateCoding_dx_terms').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#non-partition-form #DateCoding_provider_name').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#non-partition-form #DateCoding_facility').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#non-partition-form #DateCoding_body_parts').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#non-partition-form #DateCoding_ecd_9_diagnoses').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#non-partition-form #DateCoding_ecd_10_diagnoses').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
        $('#non-partition-form #DateCoding_dx_terms').chosen({
            no_results_text: "No result found. Press enter to add ",
            add_new: "Y"
        });
//                    $(document).keydown(function(e){
//            var nnn = 300;
//                    if (e.which == 13){
//            evt.preventDefault();
//                    if (this.results_showing) {
//            if (!this.is_multiple || this.result_highlight) {
//            return this.result_select(evt);
//            }
//            $(this.form_field).append('<option>' + $(evt.target).val() + '</option>');
//                    $(this.form_field).trigger('chosen:updated');
//                    this.result_highlight = this.search_results.find('li.active-result').lasteturn this.result_select(evt);
//            }
//            $('#file-partition-form #DateCoding_ecd_9_diagnoses').append(new Option('USA', nnn + 1));
//                    $('#file-partition-form #DateCoding_ecd_9_diagnoses').trigger("chosen:updated");
//            }
//            });
        $('#file-partition-form #DateCoding_undated').on('click', function () {
            var hideDiv = $('#file-partition-form #DateCoding_dos_em_').parent().eq(0);
            var hidetoDiv = $('#file-partition-form #DateCoding_todos_em_').parent().eq(0);
            if ($(this).prop('checked')) {
                $('#file-partition-form #DateCoding_dos').val("");
                $('#file-partition-form #DateCoding_todos').val("");
                hideDiv.hide('1000');
                hidetoDiv.hide('1000');
            }
            else {
                hideDiv.show('1000');
                hidetoDiv.show('1000');
            }
        });
    });

    var k_window = $('#kUI_window'),
        k_undo = $('.view_short')
            .bind("click", function () {
                k_window.data("kendoWindow").open();
            });

    var onClose = function () {
        k_undo.show();
    };

    if (!k_window.data("kendoWindow")) {
        k_window.kendoWindow({
            minWidth: "500px",
            maxHeight: "310px",
            width: "500px",
            title: "Shortcut Keys",
            actions: [
                "Minimize",
                "Maximize",
                "Close"
            ],
            close: onClose
        });
    }

</script>
<script src="<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.js' ?>"></script>
<script id="script">
    var mediType = '';
    var projectID = '<?php echo $poject_id ?>';
    var fileID = '<?php echo $file_id ?>';
    var completeFiles = false;
    var url = '<?php echo $url; ?>';
    var totalPageNumbers = "";
    PDFJS.disableWorker = true;
    PDFJS.workerSrc = '<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.worker.js' ?>';
    var pdfDoc = null,
        //pageNum = 1,
        pageNum = <?php echo $firstpage[0]; ?>,
        pageRendering = false,
        pageNumPending = null,
        scale = 0.8,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d'),
        pdfScale = 1,
        customPages = '<?php echo $oldpage; ?>',
        page = 0,
        type = '<?php echo $type; ?>'
    ;
    var pdfFocus = true;
    var nonPages = '';
    var monPages = '';
    var splitvalue = '';
    var initprovider = [];
    var initfacility = [];
    var inittitle = [];
    var initpart = [];
    var initnine = [];
    var initten = [];
    var dxterm = [];
    var pjson = "";
    var selectPartition = false;
    var medarrays =<?php echo $medarrays; ?>;
    var nonmedarrays =<?php echo $nonmedarrays; ?>;

    //  array value


    /*$(function() {
     var medarray=[],
     nonmedarray=[],
     combarray=[],
     wholearray=[],
     nonmedstr="",
     medstr="";
     setTimeout(function(){
     
     for(i=1;i<=totalPageNumbers;i++)
     {
     wholearray.push(i);
     }
     
     medstr=$('.medpages').val();
     var medarr=medstr.split(',');
     for(i=0; i <= medarr.length; i++) {
     medarray.push(medarr[i]);
     }
     
     
     if($('.nonmedtab' ).trigger('click'))
     {
     setTimeout(function(){
     nonmedstr=$('.nonmedicalpages').val();
     var nonmed=nonmedstr.split(',');
     for(i=0; i <= nonmed.length; i++) {
     nonmedarray.push(nonmed[i]);
     }
     $('.medtab' ).trigger('click')
     },2000);
     }
     
     
     },2000);
     });*/

    //Div Close
    function divCls(data) {
        var type = data.attr('data-type');
        var row = data.attr('data-row');
        var url = '<?php echo Yii::app()->createUrl('filepartition/removeRecord') ?>';
        UIkit.modal.confirm("Are you sure, you want to Remove the record?", function () {
            $.post(url,
                {
                    type: type,
                    row: row,
                    project_id: projectID,
                    file_id: fileID
                },
                function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S") {
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>" + obj.msg,
                            status: "success",
                            timeout: 500,
                            pos: 'top-right'
                        });
                        var appendData = obj.append;
                        if (appendData) {
                            $('#filerecord').empty().append(appendData.medi);
                            $('#nonfilerecord').empty().append(appendData.nonmedi);
                            $('#tab_filerecord').empty().append(appendData.tab_medi);
                            $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                            clearform();
                        }
                    } else {
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>" + obj.msg,
                            status: "error",
                            timeout: 500,
                            pos: 'top-right'
                        });
                    }

                });
        }, {labels: {'Ok': 'YES', 'Cancel': 'NO'}});
    }

    function delCls(data) {
        var type = data.attr('data-type');
        var row = data.attr('data-row');
        var url = '<?php echo Yii::app()->createUrl('filepartition/removeRecord') ?>';
        $.post(url,
            {
                type: type,
                row: row,
                project_id: projectID,
                file_id: fileID
            },
            function (result) {
                var obj = JSON.parse(result);
                if (obj.status == "S") {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>" + obj.msg,
                        status: "success",
                        timeout: 500,
                        pos: 'top-right'
                    });
                    var appendData = obj.append;
                    if (appendData) {
                        $('#filerecord').empty().append(appendData.medi);
                        $('#nonfilerecord').empty().append(appendData.nonmedi);
                        $('#tab_filerecord').empty().append(appendData.tab_medi);
                        $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                        clearform();
                    }
                } else {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>" + obj.msg,
                        status: "error",
                        timeout: 500,
                        pos: 'top-right'
                    });
                }

            });
    }

    function Dbclk(type, data) {
        UIkit.modal.confirm('Choose action', function () {
                Focuspartition(type, data);
                if (type === "M") {
                    $("#medid").val(data.attr('id'));
                    $("#nonmedid").val('');
                }
                else if (type === "N") {
                    $("#nonmedid").val(data.attr('id'));
                    $("#medid").val('');
                }
            }, function () {
                UIkit.modal.confirm('Are you sure want to delete?', function () {
                    delCls(data);
                }, {labels: {'Ok': 'Ok', 'Cancel': 'Cancel'}});
            }
            , {labels: {'Ok': 'Edit', 'Cancel': 'Delete'}});
    }

    function Focuspartition(type, data) {
        if (type === "M") {
            $("#medform_li").trigger("click");
        }
        else if (type === "N") {
            $("#nonmedform_li").trigger("click");
        }
        //id = data.closest('tr').attr('id');
        id = data.attr('id');
        getContent($('#' + id));
    }

    function Getmpartition(type) {
        $("#medid").val('');
        $("#nonmedid").val('');
        pdfDivfocus();
        if (type == "F") {
            partition = $('#filerecord a').last();
            if (partition.length > 0 && !selectPartition) {
                getContent(partition);
            }
        }
        else if (type == "P") {
            tablesort();
            if ($("#tab_filerecord tr").length !== 2) {
                tab_partition = $('#tab_filerecord tr').last();
            }
            if (tab_partition.length > 0 && !selectPartition) {
                getContent(tab_partition);
            }
            nonPages = "";
            $('.uk-non').removeClass('uk-non');
        }
    }

    function Getnpartition(type) {
        $("#medid").val('');
        $("#nonmedid").val('');
        pdfDivfocus();
        if (type == "F") {
            partition = $('#nonfilerecord a').last();
            if (partition.length > 0 && !selectPartition) {
                getContent(partition);
            }
        }
        else if (type == "P") {
            if ($("#tab_nonfilerecord tr").length !== 2) {
                tab_partition = $('#tab_nonfilerecord tr').last();
            }
            if (tab_partition.length > 0 && !selectPartition) {
                getContent(tab_partition);
            }
            monPages = "";
            $('.uk-mon').removeClass('uk-mon');
        }
    }

    //Medi - Non-medical Tab
    function Getpages(type) {
        $("#medid").val('');
        $("#nonmedid").val('');
        monPages = "";
        nonPages = "";
        if (type == 'M') {
            partid = '<?php echo $partition_id ?>';
            canvas = document.getElementById('the-canvas');
            ctx = canvas.getContext('2d');
            mediType = 'M';
            $('#medicalmodal').hide();
            $('#non_medical').show();
            $("#medform_li").trigger("click");
        }
        else if (type == 'N') {
            partid = '<?php echo $nonMedPart ?>';
            canvas = document.getElementById('the-canvas1');
            ctx = canvas.getContext('2d');
            mediType = 'N';
            $('#non_medical').hide();
            $('#medicalmodal').show();
            $("#nonmedform_li").trigger("click");
            pdfFocus = true;
        }
        usertype = '<?php echo $_GET['status'] ?>';
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('filepartition/getsplitpages') ?>",
            type: "post",
            data: {partid: partid, usertype: usertype},
            success: function (result) {
                var obj = JSON.parse(result);
                pageNum = Number(obj.firstpage[0]);
                customPages = obj.oldpage;
                customPagesArray = JSON.parse(customPages);
                if (customPagesArray[0] !== "") {
                    $('.yespages').show();
                    $('.cardcard').show();
                    $('.accord').hide();
                    pagecount = obj.pageCount;
                    $('#page_count').empty();
                    $('#page_count').append(pagecount);
                    pagination();
                    pdfCall();
                    page = 0;
                    $('#pageNumber').val(pageNum);
                }
                else {
                    pagecount = obj.pageCount;
                    $('.yespages').hide();
                    $('.cardcard').hide();
                    $('.accord').show();
                }
            }
        });
    }

    /**
     * Get page info from document, resize canvas accordingly, and render page.
     * @param num Page number.
     */
    function renderPage(num) {

        pageRendering = true;
        scale = pdfScale;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function (page) {
            var viewport = page.getViewport(scale);
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);
            // Wait for rendering to finish
            renderTask.promise.then(function () {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
        // Update page counters
        document.getElementById('page_num').textContent = pageNum;
        $('span.curPageNew').html(pageNum + '/' + totalPageNumbers);
        $('span.curPageNew1').html(pageNum + '/' + <?php echo $pageCount; ?>);
    }

    /**
     * If another page rendering in progress, waits until the rendering is
     * finised. Otherwise, executes rendering immediately.
     */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function zoom(num) {
        renderPage(num);
    }

    /**
     * Displays previous page.
     */
    function onPrevPage() {
        if (customPages != "") {
            //$('.uk-pagination #'+pageNum+'id').removeClass('uk-active');
            if ($('#tab_indexfile').find('.row_checked').length !== 0) {
                if ($('#tab_indexfile').is(':visible')) {
                    parti_pages = $('#tab_indexfile').find('.row_checked').attr('data-pagno');
                    parti_arr = parti_pages.split(',');
                    parti_index = parti_arr.indexOf(pageNum.toString());
                    if (parti_index === 0) {
                        Search(Number(parti_arr[parti_arr.length - 1]));
                    }
                    else {
                        Search(Number(parti_arr[parti_index - 1]));
                    }
                    return;
                }
            }
            if ($('#tab_nonindexfile').find('.row_checked').length !== 0) {
                if ($('#tab_nonindexfile').is(':visible')) {
                    nonparti_pages = $('#tab_nonindexfile').find('.row_checked').attr('data-pagno');
                    nonparti_arr = nonparti_pages.split(',');
                    nonparti_index = nonparti_arr.indexOf(pageNum.toString());
                    if (nonparti_index === 0) {
                        Search(Number(nonparti_arr[nonparti_arr.length - 1]));
                    }
                    else {
                        Search(Number(nonparti_arr[nonparti_index - 1]));
                    }
                    return;
                }
            }
            $('.uk-pagination li').removeClass('uk-active');
            var customPagesNew = JSON.parse(customPages);
            var customPagesLength = customPagesNew.length;
            if (pageNum <= customPagesNew[0]) {
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached first page!",
                        status: "error",
                        timeout: 1500,
                        pos: 'top-right'
                    });
                }
                retnum = pageNum;
                Search(customPagesNew[customPagesLength - 1]);
                $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
                return retnum;
            }
            if (page == "") {
                page = customPagesNew[0];
            }
            if (page > 0) {
                page--;
                $('span.curPageNew').html(pageNum - 1 + '/' + totalPageNumbers);
            }
            pageNum = Number(customPagesNew[page]);
            if ($('#' + pageNum + 'id').hasClass('uk-hide') == true) {
                $('#' + pageNum + 'id').removeClass('uk-hide');
                $('#' + pageNum + 'id').nextAll().eq(9).addClass('uk-hide');
            }
            $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
            queueRenderPage(pageNum);
            return Number(customPagesNew[page + 1]);
        }
    }

    document.getElementById('prev').addEventListener('click', onPrevPage);

    /**
     * Displays next page.
     */
    function onNextPage(lastpage) {
        if (customPages != "") {
            //$('.uk-pagination #'+pageNum+'id').removeClass('uk-active');
            if ($('#tab_indexfile').find('.row_checked').length !== 0) {
                if ($('#tab_indexfile').is(':visible')) {
                    parti_pages = $('#tab_indexfile').find('.row_checked').attr('data-pagno');
                    parti_arr = parti_pages.split(',');
                    parti_index = parti_arr.indexOf(pageNum.toString());
                    if (parti_index === parti_arr.length - 1) {
                        Search(Number(parti_arr[0]));
                    }
                    else {
                        Search(Number(parti_arr[parti_index + 1]));
                    }
                    return;
                }
            }
            if ($('#tab_nonindexfile').find('.row_checked').length !== 0) {
                if ($('#tab_nonindexfile').is(':visible')) {
                    nonparti_pages = $('#tab_nonindexfile').find('.row_checked').attr('data-pagno');
                    nonparti_arr = nonparti_pages.split(',');
                    nonparti_index = nonparti_arr.indexOf(pageNum.toString());
                    if (nonparti_index === nonparti_arr.length - 1) {
                        Search(Number(nonparti_arr[0]));
                    }
                    else {
                        Search(Number(nonparti_arr[nonparti_index + 1]));
                    }
                    return;
                }
            }
            $('.uk-pagination li').removeClass('uk-active');
            var customPagesNew = JSON.parse(customPages);
            var customPagesLength = customPagesNew.length;
            if (pageNum >= customPagesNew[customPagesLength - 1]) {
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached last page!",
                        status: "error",
                        timeout: 1500,
                        pos: 'top-right'
                    });
                }
                retnum = pageNum;
                //Search(1);
                Search(customPagesNew[0]);
                $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
                return retnum;
            }
            if (page == 0) {
                pageNum = customPagesNew[0];
            }
            page++;
            if (lastpage != undefined) {
                pageNum = Number(customPagesNew[lastpage]);
            }
            else {
                pageNum = Number(customPagesNew[page]);
            }

            if ($('#' + pageNum + 'id').hasClass('uk-hide') == true) {
                $('#' + pageNum + 'id').removeClass('uk-hide');
                $('#' + pageNum + 'id').prevAll().eq(9).addClass('uk-hide');
            }
            $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
            if (page < customPagesLength) { // prevent next page display on last page
                queueRenderPage(pageNum);
                $('span.curPageNew').html(pageNum + '/' + totalPageNumbers);
            }
            return Number(customPagesNew[page - 1]);
        }
    }

    document.getElementById('next').addEventListener('click', onNextPage);

    /**
     * Displays Search page.
     */
    function Search(lastpage) {
        if (typeof lastpage != "object") {
            var pageNo = parseInt(lastpage).toString();
        }
        else {
            var pageNo = parseInt($('#pageNumber').val()).toString();
        }
        var customPagesNew = JSON.parse(customPages);
        var customPagesLength = customPagesNew.length;
        if (jQuery.inArray(pageNo, customPagesNew) !== -1) {
            pageNum = parseInt(pageNo);
            queueRenderPage(pageNum);

            $('.uk-pagination .uk-active').removeClass('uk-active');
            $('.uk-pagination li').not(':first').not(':last').addClass('uk-hide');
            page = customPagesNew.indexOf(pageNum.toString());
            if (((customPagesLength - 1) - page) < 9) {
                modulo = (customPagesLength - 1) - page;
                nxtmod = 9 - modulo;
                $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
                $('#' + pageNum + 'id').prevAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').nextAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
            }
            else {
                modulo = page % 10;
                nxtmod = 9 - modulo;
                $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').prevAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
                $('#' + pageNum + 'id').nextAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
            }

            return pageNum;
        }
        else {

            UIkit.notify({
                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Invalid Page!",
                status: "warning",
                timeout: 500,
                pos: 'top-right'
            });
        }
    }

    document.getElementById('pagesearch').addEventListener('click', Search);

    /**
     * @Load a last saved Page
     */
    function lastLoad() {
        if (customPages != '') {
            var restricted = JSON.parse(customPages);
            var lastPage = restricted[restricted.length - 1];
            if (lastPage == pdfDoc.numPages) {
                if (pageNum < lastPage) {
                    pageNum++;
                    lastLoad();
                }
            } else {
                if (pageNum <= lastPage) {
                    pageNum++;
                    lastLoad();
                }
            }
        }
    }

    /**
     * Asynchronously downloads PDF.
     */
    function pdfCall() {
        PDFJS.getDocument({url: url, password: 'KJN98IONHO'}).then(function (pdfDoc_) {
            pdfDoc = pdfDoc_;
            var numPages = pdfDoc.numPages;
            totalPageNumbers = numPages;
            //document.getElementById('page_count').textContent = pdfDoc.numPages;
            // Initial/first page rendering
            if (customPages != undefined) {
                var partitionPages = JSON.parse(customPages);
                //            breakDivfocus();
                //            breakFocus();
                //var partition = $('#filerecord a').first();
                if (mediType == 'M') {
                    tablesort();
                    var partition = $('#filerecord a').last();
                    if ($("#tab_filerecord tr").length !== 2) {
                        var tab_partition = $('#tab_filerecord tr').last();
                    }
                } else if (mediType == 'N') {
                    var partition = $('#nonfilerecord a').last();
                    if ($("#tab_nonfilerecord tr").length !== 2) {
                        var tab_partition = $('#tab_nonfilerecord tr').last();
                    }
                }

                renderPage(Number(partitionPages[0]));
                if (tab_partition.length > 0 && !selectPartition) {
                    getContent(tab_partition);
                }
                if (partition.length > 0 && !selectPartition) {
                    getContent(partition);
                }
            }
            else {
                renderPage(pageNum);
            }

        });
    }

    function handlePages(page) {
        //This gives us the page's dimensions at full scale
        var viewport = page.getViewport(1);
        //We'll create a canvas for each page to draw it on
        var canvas = document.createElement("canvas");
        var canvas1 = document.createElement("input");
        canvas1.setAttribute("type", "checkbox");
        canvas1.setAttribute("name", (page.pageIndex + 1));
        canvas.style.display = "block";
        var context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        /* canvas.height = "500";
         canvas.width = "500";*/
        canvas.setAttribute("onClick", "setalert(" + (page.pageIndex + 1) + ")");
        //Draw it on the canvas
        page.render({canvasContext: context, viewport: viewport});
        //Add it to the web page
        document.body.appendChild(canvas);
        //Move to next page
        currPage++;
        if (thePDF !== null && currPage <= numPages) {
            thePDF.getPage(currPage).then(handlePages);
        }
    }

    function setalert(num) {
        renderPage(num);
    }

    function range(start, end, step) {
        var range = [];
        while (step > 0 ? end >= start : end <= start) {
            range.push(start);
            start += step;
        }
        return range;
    }

    function arr_diff(a1, a2) {
        var a = [], diff = [];
        for (var i = 0; i < a1.length; i++) {
            a[a1[i]] = true;
        }
        for (var i = 0; i < a2.length; i++) {
            if (a[a2[i]]) {
                delete a[a2[i]];
            } else {
                a[a2[i]] = true;
            }
        }
        for (var k in a) {
            diff.push(k);
        }
        return diff;
    }


    var myFuncCalls = 0;
    var timer = null;
    var temptimer;
    var tempSetIntr;

    function autoSave(mode) {
        if (temptimer != 0) {
            clearInterval(tempSetIntr);
        }
        temptimer = 10;
        if (mode !== 'D') {
//            if (myFuncCalls == 0) {
//                myFuncCalls++;

//                if (temptimer == 0) {
//                     autoSaveFunction(mode);
////                    timer = setTimeout(function () {
////                        myFuncCalls = 0;
////                        autoSaveFunction(mode);
////                    }, 10000);
//                }

            tempSetIntr = setInterval(function () {
                temptimer--;
                if (temptimer == 0) {
                    clearInterval(tempSetIntr);
                    autoSaveFunction(mode);
                }
            }, 1000);
//            }
        }
        else {
            autoSaveFunction(mode);
        }
    }

    function autoSaveFunction(mode) {
        //var formdata = new FormData($('#file-partition-form')[0]);
        //var formdata = new FormData($("#file-partition-form")[0]);
        //var formdata1 = new FormData($("#non-partition-form")[0]);
        //var formdata = JSON.stringify($("#file-partition-form").serialize());
        formdata = {};
        $("#file-partition-form :input").each(function () {
            formdata[$(this).attr('data-name')] = $(this).val();
        });
        formdata1 = {};
        $("#non-partition-form :input").each(function () {
            formdata1[$(this).attr('data-name')] = $(this).val();
        });
        //var formdata1 = JSON.stringify($("#non-partition-form").serialize());
        nonmedpage = $('.DateCoding_nonpages').val();
        nonmedcat = $('.DateCoding_noncategory').val();
        //formdata.append("nonmedpage", nonmedpage);
        //formdata.append("nonmedcat", nonmedcat);
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('filepartition/autosavesplit') ?>?mode=" + mode,
            type: "post",
            data: {formdata, formdata1},
            global: false,
            //contentType: false,
            cache: false,
            //processData: false,
            success: function (result) {
            }
        });
    }

    function oncancel() {
        //var partition = $('#filerecord a').first();
        if (mediType == 'M') {
            var partition = $('#filerecord a').last();
            if (partition.length > 0) {
                getContent(partition);
            }
        }
        else if (mediType == 'N') {
            var partition = $('#nonfilerecord a').last();
            if (partition.length > 0) {
                getContent(partition);
            }
        }
        autoSave('D');
    }

    function onconfirm() {

        <?php if (!empty($restore_json)) { ?>
        restore_json = <?php echo $restore_json; ?>;
        result = [];
        for (var i in restore_json) {
            result[i] = restore_json[i];
        }
        $('.DateCoding_pages').val(result[0]);
        $('#DateCoding_dos').val(result[1]);
        $('#DateCoding_dos').trigger('autoresize');
        $('#DateCoding_patient_name').val(result[2]);
        $('.DateCoding_category').val(result[3]);
        $('#DateCoding_provider_name').val(result[4].split('^'));
        $('#DateCoding_provider_name').trigger("chosen:updated");

        if (result[1] == "")
        //$('#DateCoding_undated').prop('checked','checked');
            $('#DateCoding_undated').trigger('click');
        $(".DateCoding_category").trigger("chosen:updated");
        var gender = result[5];
        if (gender !== '') {
            $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
            $('input[name="DateCoding[gender]"][value=' + gender + ']').prop('checked', true).iCheck('update');
        }
        $('#DateCoding_doi').val(result[6]);
        $('#DateCoding_facility').val(result[7]);
        $('#DateCoding_title').val(result[8]);
        $('.DateCoding_nonpages').val(result[9]);
        $('.DateCoding_noncategory').val(result[10]);
        $(".DateCoding_noncategory").trigger("chosen:updated");
        $('#DateCoding_dob').val(result[11]);
        $('#file-partition-form #DateCoding_body_parts').val(result[12].split('^'));
        $('#DateCoding_body_parts').trigger("chosen:updated");
        $('#file-partition-form #DateCoding_ecd_9_diagnoses').val(result[13].split('^'));
        $('#DateCoding_ecd_9_diagnoses').trigger("chosen:updated");
        $('#file-partition-form #DateCoding_ecd_10_diagnoses').val(result[14].split('^'));
        $('#DateCoding_ecd_10_diagnoses').trigger("chosen:updated");
        $('#file-partition-form #DateCoding_dx_terms').val(result[15].split('^'));
        $('#DateCoding_dx_terms').trigger("chosen:updated");
        $('#non-partition-form #DateCoding_body_parts').val(result[16].split('^'));
        $('#non-partition-form #DateCoding_body_parts').trigger("chosen:updated");
        $('#non-partition-form #DateCoding_ecd_9_diagnoses').val(result[17].split('^'));
        $('#non-partition-form #DateCoding_ecd_9_diagnoses').trigger("chosen:updated");
        $('#non-partition-form #DateCoding_ecd_10_diagnoses').val(result[18].split('^'));
        $('#non-partition-form #DateCoding_ecd_10_diagnoses').trigger("chosen:updated");
        $('#non-partition-form #DateCoding_dx_terms').val(result[19].split('^'));
        $('#non-partition-form #DateCoding_dx_terms').trigger("chosen:updated");
        autoSaveFunction('S');
        <?php } ?>
    }


    function zooming(type) {
        if (mediType == 'M') {
            currentWidth = $('#the-canvas').width();
            if (type === 'in') {
                $('#the-canvas').width(currentWidth + 150);
            }
            else {
                $('#the-canvas').width(currentWidth - 150);
            }
        }
        else if (mediType == 'N') {
            currentWidth = $('#the-canvas1').width();
            if (type === 'in') {
                $('#the-canvas1').width(currentWidth + 150);
            }
            else {
                $('#the-canvas1').width(currentWidth - 150);
            }
        }
    }

    function goToPage(pgnum) {
        var customPagesNew = JSON.parse(customPages);
        $('.uk-pagination .uk-active').removeClass('uk-active');
        $('.uk-pagination #' + pgnum + 'id').addClass('uk-active');
        pageNum = parseInt(pgnum);
        page = customPagesNew.indexOf(pgnum.toString());
        queueRenderPage(pageNum);
        return pageNum;
    }

    function loadToPage(pgnum) {
        var pageNo = parseInt(pgnum).toString();
        var customPagesNew = JSON.parse(customPages);
        var customPagesLength = customPagesNew.length;
        if (jQuery.inArray(pageNo, customPagesNew) !== -1) {
            pageNum = parseInt(pageNo);
            queueRenderPage(pageNum);
            $('.uk-pagination .uk-active').removeClass('uk-active');
            $('.uk-pagination li').not(':first').not(':last').addClass('uk-hide');
            page = customPagesNew.indexOf(pageNum.toString());
            if (((customPagesLength - 1) - page) < 9) {
                modulo = (customPagesLength - 1) - page;
                nxtmod = 9 - modulo;
                $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
                $('#' + pageNum + 'id').prevAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').nextAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
            }
            else {
                modulo = page % 10;
                nxtmod = 9 - modulo;
                $('.uk-pagination #' + pageNum + 'id').addClass('uk-active');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').prevAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
                $('#' + pageNum + 'id').nextAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
            }

            return pageNum;
        }
    }

    function pagination() {
        var paginCont = JSON.parse(customPages);
        var ukContent = '';
        ind = 0;
        ukContent = '<li><a href="#" onClick="onPrevPage()"><i class="uk-icon-angle-double-left"></i></a></li>';
        $.each(paginCont, function (key, value) {
            if (ind <= 9) {
                if (ind == 0) {
                    ukContent += '<li class="uk-active" id="' + value + 'id"><a href="#" onClick="goToPage(' + value + ')" ><span>' + value + '</span></a></li>';
                }
                else {
                    ukContent += '<li id="' + value + 'id"><a href="#" onClick="goToPage(' + value + ')" ><span>' + value + '</span></a></li>';
                }
            }
            else {
                ukContent += '<li class="uk-hide" id="' + value + 'id"><a href="#" onClick="goToPage(' + value + ')" ><span>' + value + '</span></a></li>';
            }
            ind++;
        });
        ukContent += '<li><a href="#" onClick="onNextPage()"><i class="uk-icon-angle-double-right"></i></a></li>';


        $('.uk-pagination').empty();
        $('.uk-pagination').append(ukContent);
    }

    function autocom(providerTags, facilityTags, titleTags, partTags, nineTags, tenTags, dxterm) {
//        $("#DateCoding_provider_name").autocomplete({
//            source: providerTags
//        });

//        $("#DateCoding_facility").autocomplete({
//            source: facilityTags
//        });
//        $("#DateCoding_title").autocomplete({
//            source: titleTags
//        })
//        $("#file-partition-form #DateCoding_body_parts, #non-partition-form #DateCoding_body_parts").on("keydown", function (event) {
//
//            if (event.keyCode === $.ui.keyCode.TAB &&
//                    $(this).autocomplete("instance").menu.active) {
//                event.preventDefault();
//            }
//        }).autocomplete({
//            minLength: 0,
//            source: function (request, response) {
//                response($.ui.autocomplete.filter(
//                        partTags, request.term.split("\n").pop())
//                        );
//            },
//            focus: function () {
//                return false;
//            },
//            select: function (event, ui) {
//
//                var terms = this.value.split("\n");
//                terms.pop();
//                terms.push(ui.item.value);
//                terms.push("");
//                this.value = terms.join("\n");
//                return false;
//            }
//        });
//        $("#file-partition-form #DateCoding_ecd_9_diagnoses, #non-partition-form #DateCoding_ecd_9_diagnoses").on("keydown", function (event) {
//        $("#file-partition-form #DateCoding_ecd_9_diagnoses, #non-partition-form #DateCoding_ecd_9_diagnoses").on("keydown", function (event) {
//            
//            if (event.keyCode === $.ui.keyCode.TAB &&
//                    $(this).autocomplete("instance").menu.active) {
//                event.preventDefault();
//            }
//
//        }).autocomplete({
//            minLength: 3,
//            delay:0,
////            source:nineTags,
////            source:function(request,response){
////                console.log(request);
////                console.log(response);
//////                response(return 9);
////                response($.ui.autocomplete.filter(
////                        nineTags, request.term.split("\n").pop()));
////                console.log($.ui.autocomplete.filter(
////                        nineTags, request.term.split("\n").pop()));
////                         
//////                        nineTags, request.term.split("\n").pop()));
////            },
//            source: function (request, response) {
//                response($.ui.autocomplete.filter(
//                        nineTags, request.term.split("\n").pop()));
//            },
//            focus: function () {
//                return false;
//            },
//            select: function (event, ui) {
//
//                var terms = this.value.split("\n");
//                terms.pop();
//                terms.push(ui.item.value);
//                terms.push("");
//                this.value = terms.join("\n");
//                return false;
//            }
//        });

        //dx terms


//        $("#file-partition-form #DateCoding_dx_terms, #non-partition-form #DateCoding_dx_terms").on("keydown", function (event) {
//            if (event.keyCode === $.ui.keyCode.TAB &&
//                    $(this).autocomplete("instance").menu.active) {
//                event.preventDefault();
//            }
//        }).autocomplete({
//            minLength: 0,
//            source: function (request, response) {
//                response($.ui.autocomplete.filter(
//                        dxterm, request.term.split("\n").pop()));
//            },
//            focus: function () {
//                return false;
//            },
//            select: function (event, ui) {
//
//                var terms = this.value.split("\n");
//                terms.pop();
//                terms.push(ui.item.value);
//                terms.push("");
//                this.value = terms.join("\n");
//                return false;
//            }
//        });
//        $("#file-partition-form #DateCoding_ecd_10_diagnoses, #non-partition-form #DateCoding_ecd_10_diagnoses").on("keydown", function (event) {
//            if (event.keyCode === $.ui.keyCode.TAB &&
//                    $(this).autocomplete("instance").menu.active) {
//                event.preventDefault();
//            }
//        }).autocomplete({
//            minLength: 0,
//            source: function (request, response) {
//                response($.ui.autocomplete.filter(
//                        tenTags, request.term.split("\n").pop()));
//            },
//            focus: function () {
//                return false;
//            },
//            select: function (event, ui) {
//
//                var terms = this.value.split("\n");
//                terms.pop();
//                terms.push(ui.item.value);
//                terms.push("");
//                this.value = terms.join("\n");
//                return false;
//            }
//        });
//        $("#file-partition-form #DateCoding_provider_name, #non-partition-form #DateCoding_provider_name").on("keydown", function (event) {
//            if (event.keyCode === $.ui.keyCode.TAB &&
//                    $(this).autocomplete("instance").menu.active) {
//                event.preventDefault();
//            }
//        }).autocomplete({
//            minLength: 0,
//            source: function (request, response) {
//                response($.ui.autocomplete.filter(
//                        providerTags, request.term.split("\n").pop()));
//            },
//            focus: function () {
//                return false;
//            },
//            select: function (event, ui) {
//
//                var terms = this.value.split("\n");
//                terms.pop();
//                terms.push(ui.item.value);
//                terms.push("");
//                this.value = terms.join("\n");
//                return false;
//            }
//        });
    }

    $(document).ready(function () {
        $("#indexdiv,#indexform").click(function () {
            var divid = $(this).attr('id');
            if (divid == "indexdiv") {
                pdfFocus = true;
            }
            else {
                pdfFocus = false;
            }
        });

        $('.shad_btn').on('focus', function () {
            $(this).addClass('btn_shadow');
        });
        $('.shad_btn').on('blur', function () {
            $(this).removeClass('btn_shadow');
        });
        window.onresize = function (event) {
            $('span.curPageNew').html(pageNum + '/' + totalPageNumbers);
            var maxHeight = window.screen.height,
                maxWidth = window.screen.width,
                curHeight = window.innerHeight,
                curWidth = window.innerWidth;
            if (maxWidth == curWidth && maxHeight == curHeight) {
                $('.dateCodeLegPar').hide();
                $('.uk-sticky-placeholder').hide();
                $('#indexdiv').css({'min-height': '825px'});
                $('.curPageNewDiv').show();
                $('.curPageNewDiv1').show();
                $('#header_main').hide();
                $('.uk-sticky-placeholder').hide();
                $('body').css({'padding-top': '0px'});
            }
            else {
                $('.dateCodeLegPar').show();
                $('.uk-sticky-placeholder').show();
                $('#indexdiv').css({'min-height': '600px'});
                $('.curPageNewDiv').hide();
                $('.curPageNewDiv1').hide();
                $('#header_main').show();
                $('.uk-sticky-placeholder').show();
                $('body').css({'padding-top': '48px'});
            }
        }


        mediType = 'M';
        Getpages(mediType);
        //pagination();
        //pdfCall();
        //Toogle Bar Full Width
        ($body.hasClass('sidebar_main_active') || ($body.hasClass('sidebar_main_open') && $window.width() >= 1220)) ? altair_main_sidebar.hide_sidebar() : altair_main_sidebar.show_sidebar();
        <?php if (!empty($restore_json)) { ?>
        selectPartition = true;
        UIkit.modal.confirm("Are you sure, you want to restore previous data?", onconfirm, oncancel, function () {
        }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});
        <?php } ?>
        appendRecord();
        if ($('#filerecord').children().length == 0) {
            $('<span></span>', {css: {"font-style": "oblique"}, text: "No Partition Created"}).appendTo('#filerecord');
        }
        if ($('#nonfilerecord').children().length == 0) {
            $('<span></span>', {
                css: {"font-style": "oblique"},
                text: "No Partition Created"
            }).appendTo('#nonfilerecord');
        }


        if ($('#tab_filerecord tr').length == 2) {
            $("#tab_filerecord").empty();
            $('<span></span>', {
                css: {"font-style": "oblique"},
                text: "No Partition Created"
            }).appendTo('#tab_filerecord');
        }
        if ($('#tab_nonfilerecord tr').length == 2) {
            $("#tab_nonfilerecord").empty();
            $('<span></span>', {
                css: {"font-style": "oblique"},
                text: "No Partition Created"
            }).appendTo('#tab_nonfilerecord');
        }

        $('#file-partition-form :input').on('keyup click change ifClicked', function () {
            autoSave('S');
        });
        <?php if (!empty($pjson)) { ?>
        pjson = <?php echo $pjson; ?>;
        initprovider = pjson.P;
        initfacility = pjson.F;
        inittitle = pjson.T;
        initpart = pjson.B;
        initnine = pjson.E;
        initten = pjson.N;
        dxterm = pjson.DX;
        <?php } ?>

        autocom(initprovider, initfacility, inittitle, initpart, initnine, initten, dxterm);
        $(document).unbind('keyup').keyup(function (e) {
            if ($('#quitModal').is(':visible') === false) {
                //Escape Key for Change Focus
                if (e.which === 27) {
                    //if ($('#indexform').is(':focus')) {
                    if (mediType === "M") {
//                        if ($('#DateCoding_dos').is(':focus') || $('#DateCoding_provider_name').is(':focus')) {
                        //if ($('#indexform input').is(':focus')) {
                        if ($('#indexform').hasClass('div-focus') || $('#tab_indexfile').hasClass('div-focus') || $('#indexfile').hasClass('div-focus')) {
//                            datecodeDivfocus();
                            pdfDivfocus();
                        }
//                        else if ($('#DateCoding_patient_name').is(':focus')) {
//                            pdfDivfocus();
//                        }
                        else {
                            if ($('.medform_tab').hasClass('uk-active')) {
                                formDivfocus();
                            }
                            else {
                                partDivfocus();
                            }
                        }
                    }
                    else if (mediType === "N") {
                        //if (pdfFocus) {
                        if ($('#nonindexform').hasClass('div-focus') || $('#tab_nonindexfile').hasClass('div-focus') || $('#nonindexfile').hasClass('div-focus')) {
                            //formDivfocus();
                            pdfDivfocus();
                            $('.DateCoding_noncategory').trigger("chosen:close");
                        }
                        else {
                            if ($('.nonmedform_tab').hasClass('uk-active')) {
                                //pdfDivfocus();
                                formDivfocus();
                                $('.DateCoding_noncategory').trigger('chosen:activate');
                            }
                            else {
                                partDivfocus();
                            }
                        }
                    }
                }
                //Plus Key for Select Break Files
                if (e.which === 107) {
                    breakDivfocus();
                    breakFocus();
                }
                <?php if ($_GET['status'] == 'R') { ?>
                if (e.which === 81 && e.altKey) {
                    if (mediType === "M") {
                        $("#file-partition-form .quitbtn").trigger("click");
                    }
                    else if (mediType === "N") {
                    }
                }
                <?php } ?>
                if (e.which === 65 && e.altKey) {
                    if (mediType === "M") {
                        $("#file-partition-form .createbtn").trigger("click");
                    }
                    else if (mediType === "N") {
                        $("#non-partition-form .createbtn").trigger("click");
                    }
                }
                if (e.which === 67 && e.altKey) {
                    if (mediType === "M") {
                        $("#file-partition-form .completebtn").trigger("click");
                    }
                    else if (mediType === "N") {
                        $("#non-partition-form .completebtn").trigger("click");
                    }
                }
                if (e.which === 90 && e.altKey) {
                    if (mediType === "M") {
                        $("#file-partition-form #medfinish").trigger("click");
                    }
                    else if (mediType === "N") {
                        $("#non-partition-form #nonmedfinish").trigger("click");
                    }
                }
                if (e.which === 38 && e.altKey) {
                    $(".medtab").trigger("click");
                }
                if (e.which === 40 && e.altKey) {
                    $(".nonmedtab").trigger("click");
                }
                if (e.which === 191 && e.altKey) {
                    if (mediType === "M") {
                        non_medical();
                    }
                    else if (mediType === "N") {
                        medicalmodal()
                    }
                }
                if (e.ctrlKey && e.which == 88) {
                    pageRange();
                }

                <?php if ($_GET['status'] == 'QC') { ?>
                if (e.which === 87 && e.altKey) {
                    if (mediType === "M") {
                        $("#file-partition-form .feedbackbtn").trigger("click");
                    }
                    else if (mediType === "N") {
                        $("#non-partition-form .feedbackbtn").trigger("click");
                    }
                }
                <?php } ?>
                if (pdfFocus) {
                    if (e.which === 39 && e.ctrlKey) {
                        var pgnos = [];
                        var nextPage = onNextPage();
                        if ($('.medtab').hasClass('uk-active')) {
                            if ($('.DateCoding_pages').val() != "") {
                                pgnos = $('.DateCoding_pages').val().split(',');
                            }
                            if (pgnos.indexOf(nextPage.toString()) == -1) {
                                pgnos.push(nextPage);
                            }
                            $('.DateCoding_pages').val(pgnos);
                            autoSave('S');
                        }
                        else {
                            if ($('.DateCoding_nonpages').val() != "") {
                                pgnos = $('.DateCoding_nonpages').val().split(',');
                            }
                            if (pgnos.indexOf(nextPage.toString()) == -1) {
                                pgnos.push(nextPage);
                            }
                            $('.DateCoding_nonpages').val(pgnos);
                            autoSave('S');
                        }
                    }
                    else if (e.which === 37 && e.ctrlKey) {
                        var prevPage = onPrevPage();
                        if ($('.medtab').hasClass('uk-active')) {
                            var splitval = $('.DateCoding_pages').val().split(',');
                            var index = splitval.indexOf(prevPage.toString());
                            if (index > -1) {
                                splitval.splice(index, 1);
                            }
                            $('.DateCoding_pages').val(splitval);
                            autoSave('S');
                        }
                        else {
                            var splitval = $('.DateCoding_nonpages').val().split(',');
                            var index = splitval.indexOf(prevPage.toString());
                            if (index > -1) {
                                splitval.splice(index, 1);
                            }
                            $('.DateCoding_nonpages').val(splitval);
                            autoSave('S');
                        }
                    }
                    else if (e.which === 37) {
                        onPrevPage();
                    }
                    else if (e.which === 39) {
                        onNextPage();
                    }
                    else if (e.which === 38 && e.ctrlKey) {
                        zooming('in');
                    }
                    else if (e.which === 40 && e.ctrlKey) {
                        zooming('out');
                    }
                    if (e.which === 78) {
                        if (mediType === "M") {
                            if ($('#indexfile').is(':visible')) {
                                var npgnos = [];
                                var nextPage = onNextPage();
                                if ($('#' + nextPage + 'id').hasClass('uk-non') === false) {
                                    $('#' + nextPage + 'id').addClass('uk-non');
                                }
                                else {
                                    $('#' + nextPage + 'id').removeClass('uk-non');
                                }
                                if (nonPages != "") {
                                    npgnos = nonPages.split(',');
                                }
                                if (npgnos.indexOf(nextPage.toString()) == -1) {
                                    npgnos.push(nextPage);
                                    nonPages = npgnos.join(',');
                                }
                                else {
                                    var nm_numbers = npgnos.map(function (v) {
                                        return parseInt(v)
                                    });
                                    var filtered = nm_numbers.filter(function (v) {
                                        if (v !== nextPage) {
                                            return v
                                        }
                                    });
                                    nonPages = filtered.join(",");
                                }
                            }
                        }
                    }

                    if (e.which === 77) {
                        if (mediType === "N") {
                            if ($('#nonindexfile').is(':visible')) {
                                var mpgnos = [];
                                var nextPage = onNextPage();
                                if ($('#' + nextPage + 'id').hasClass('uk-mon') === false) {
                                    $('#' + nextPage + 'id').addClass('uk-mon');
                                }
                                else {
                                    $('#' + nextPage + 'id').removeClass('uk-mon');
                                }
                                if (monPages != "") {
                                    mpgnos = monPages.split(',');
                                }
                                if (mpgnos.indexOf(nextPage.toString()) == -1) {
                                    mpgnos.push(nextPage);
                                    monPages = mpgnos.join(',');
                                }
                                else {
                                    var m_numbers = mpgnos.map(function (v) {
                                        return parseInt(v)
                                    });
                                    var filtered = m_numbers.filter(function (v) {
                                        if (v !== nextPage) {
                                            return v
                                        }
                                    });
                                    monPages = filtered.join(",");
                                }
                            }
                        }
                    }
                }
                if (e.which === 88 && e.altKey) {
                    $("#pageNumber").focus();
                }
                if (e.which == 13 && $("#pageNumber").is(":focus") === true) {
                    $('#pagesearch')[0].click();
                }
            }
        });


        var native_width = 0;
        var native_height = 0;

        $(".magnify").mouseenter(function (e) {
            if (mediType === "M") {
                var main = document.getElementById("the-canvas");
            }
            else if (mediType === "N") {
                var main = document.getElementById("the-canvas1");
            }
            var ctx = main.getContext("2d");
            var img = new Image();
            var url = main.toDataURL("image/png");
            $(".large").css("background-image", "url(" + url + ")");
        });
        $(".magnify").mousemove(function (e) {
            if (!native_width && !native_height) {
                var image_object = new Image();
                image_object.src = url;
                if (mediType === "M") {
                    native_width = $("#the-canvas").width();
                    native_height = $("#the-canvas").height();
                }
                else if (mediType === "N") {
                    native_width = $("#the-canvas1").width();
                    native_height = $("#the-canvas1").height();
                }
            }
            else {
                var magnify_offset = $(this).offset();
                var mx = e.pageX - magnify_offset.left;
                var my = e.pageY - magnify_offset.top;
                if (mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0) {
                    $(".large").fadeIn(100);
                }
                else {
                    $(".large").fadeOut(100);
                }

                if (mediType === "M") {
                    if ($("#indexdiv .large").is(":visible")) {
                        var rx = Math.round(mx / $("#indexdiv .small").width() * native_width - $("#indexdiv .large").width() / 2) * -1;
                        var ry = Math.round(my / $("#indexdiv .small").height() * native_height - $("#indexdiv .large").height() / 2) * -1;
                        var bgp = rx + "px " + ry + "px";
                        var px = mx - $("#indexdiv .large").width() / 2;
                        var py = my - $("#indexdiv .large").height() / 2;
                        $("#indexdiv .large").css({left: px, top: py, backgroundPosition: bgp});
                    }
                }
                else if (mediType === "N") {
                    if ($("#nonindexdiv .large").is(":visible")) {
                        var rx = Math.round(mx / $("#nonindexdiv .small").width() * native_width - $("#nonindexdiv .large").width() / 2) * -1;
                        var ry = Math.round(my / $("#nonindexdiv .small").height() * native_height - $("#nonindexdiv .large").height() / 2) * -1;
                        var bgp = rx + "px " + ry + "px";
                        var px = mx - $("#nonindexdiv .large").width() / 2;
                        var py = my - $("#nonindexdiv .large").height() / 2;
                        $("#nonindexdiv .large").css({left: px, top: py, backgroundPosition: bgp});
                    }
                }
            }
        });
        $(".magnify").mouseleave(function (e) {
            $(".large").fadeOut(100);
        });

        //$('.medfilter').on('keyup change', function(){
        $(document).on("keyup change", ".medfilter", function () {
            cat = $(this).val();
            x = document.getElementsByClassName("medfilter");
            $(this).parents("thead").eq(0).next("tbody").children('tr').each(function () {
                categ = $(this).attr("data-catname");
                pagnos = $(this).attr("data-pagno");
                doss = $(this).attr("data-dos");
                provdr = $(this).attr("data-provider");
                if (typeof x[3] != 'undefined') {
                    if (pagnos.indexOf(x[0].value) >= 0 && doss.startsWith(x[1].value) && categ.indexOf(x[2].value) >= 0 && provdr.startsWith(x[3].value)) {
                        $(this).css("display", "table-row");
                    }
                    else {
                        $(this).css("display", "none");
                    }
                }
                else {
                    if (pagnos.indexOf(x[0].value) >= 0 && doss.startsWith(x[1].value) && categ.indexOf(x[2].value) >= 0) {
                        $(this).css("display", "table-row");
                    }
                    else {
                        $(this).css("display", "none");
                    }
                }
            });
            if ($("#tab_filerecord tr:visible").length > 2) {
                tablesort();
                getContent($("#tab_filerecord tr:visible").last());
            }
        });

        //$('.nonmedfilter').on('keyup change', function(){
        $(document).on("keyup change", ".nonmedfilter", function () {
            cat = $(this).val();
            y = document.getElementsByClassName("nonmedfilter");
            $(this).parents("thead").eq(0).next("tbody").children('tr').each(function () {
                categ = $(this).attr("data-catname");
                pagnos = $(this).attr("data-pagno");
                if (pagnos.indexOf(y[0].value) >= 0 && categ.indexOf(y[1].value) >= 0) {
                    $(this).css("display", "table-row");
                }
                else {
                    $(this).css("display", "none");
                }
            });
            if ($("#tab_nonfilerecord tr:visible").length > 2) {
                getContent($("#tab_nonfilerecord tr:visible").last());
            }
        });


    });

    // Focus fot Form Text
    function inputFocus($val) {
        pdfFocus = $val;
    }

    //BreakFile Focus in Function
    function breakFocus() {
        if (mediType === 'M') {
            if ($('#filerecord').is(":visible")) {
                var a_count = parseInt($("#filerecord a").length) - 1;
                var currentFocus = $("#filerecord a").index($("#filerecord").find('a:focus'));
                if (currentFocus < 0 || currentFocus == a_count) {
                    $("#filerecord a").eq(0).focus();
                } else {
                    $("#filerecord a").eq(currentFocus + 1).focus();
                }
            }
            else if ($('#tab_filerecord').is(":visible")) {
                if ($("#tab_filerecord tr:visible").length > 2) {
                    if ($("#tab_filerecord tr.row_checked").nextAll('tr:visible:first').length > 0) {
                        nextelem = $("#tab_filerecord tr.row_checked").nextAll('tr:visible:first');
                        getContent(nextelem);
                    }
                    else {
                        getContent($("#tab_filerecord tr:visible").eq(2));
                    }
                }
            }
        }
        else if (mediType === 'N') {
            if ($('#nonfilerecord').is(":visible")) {
                var a_count = parseInt($("#nonfilerecord a").length) - 1;
                var currentFocus = $("#nonfilerecord a").index($("#nonfilerecord").find('a:focus'));
                if (currentFocus < 0 || currentFocus == a_count) {
                    $("#nonfilerecord a").eq(0).focus();
                } else {
                    $("#nonfilerecord a").eq(currentFocus + 1).focus();
                }
            }
            else if ($('#tab_nonfilerecord').is(":visible")) {
                if ($("#tab_nonfilerecord tr:visible").length > 2) {
                    if ($("#tab_nonfilerecord tr.row_checked").nextAll('tr:visible:first').length > 0) {
                        nextelem = $("#tab_nonfilerecord tr.row_checked").nextAll('tr:visible:first');
                        getContent(nextelem);
                    }
                    else {
                        getContent($("#tab_nonfilerecord tr:visible").eq(2));
                    }
                }
            }
        }
    }

    //Pdf Focus
    function pdfDivfocus() {


        if (mediType === 'M') {
            // $('#DateCoding_pages').blur();
            //$('#indexform').blur().removeClass('div-focus');
            $('#indexform').removeClass('div-focus');
            $('#dateCodeLeg').removeClass('div-focus');
            $('#tab_indexfile').removeClass('div-focus');
//            $('#DateCoding_patient_name').blur();
            $('#indexform input').blur();
            $('#DateCoding_dos').blur();
            $('#indexfile').removeClass('div-focus');
            $('#indexdiv').addClass('div-focus');
        }
        else if (mediType === 'N') {
            $('#nonindexform').removeClass('div-focus');
            $('#tab_nonindexfile').removeClass('div-focus');
            $('#nonindexdiv').addClass('div-focus');
        }
        pdfFocus = true;
    }

    //Form Focus
    function formDivfocus() {
        if (mediType === 'M') {
            $('#indexdiv').removeClass('div-focus');
            $('#dateCodeLeg').removeClass('div-focus');
            $('#indexfile').removeClass('div-focus');
            $('#tab_indexfile').removeClass('div-focus');
            //$('#indexform').focus().addClass('div-focus');
            $('#indexform').addClass('div-focus');
            if ($('#DateCoding_dos').is(':visible')) {
                $('#DateCoding_dos').focus();
            }
            else {
                $('#DateCoding_provider_name').focus();
            }
        }
        else if (mediType === 'N') {
            $('#nonindexdiv').removeClass('div-focus');
            $('#tab_nonindexfile').removeClass('div-focus');
            $('#nonindexform').addClass('div-focus');
        }
        pdfFocus = false;
    }

    //Form Focus
    function partDivfocus() {
        if (mediType === 'M') {
            $('#indexdiv').removeClass('div-focus');
            $('#dateCodeLeg').removeClass('div-focus');
            $('#indexfile').removeClass('div-focus');
            $('#indexform').removeClass('div-focus');
            $('#tab_indexfile').addClass('div-focus');
            //$('#indexform').focus().addClass('div-focus');
            if ($('#DateCoding_dos').is(':visible')) {
                $('#DateCoding_dos').focus();
            }
            else {
                $('#DateCoding_provider_name').focus();
            }
        }
        else if (mediType === 'N') {
            $('#nonindexdiv').removeClass('div-focus');
            $('#nonindexform').removeClass('div-focus');
            $('#tab_nonindexfile').addClass('div-focus');
        }
        pdfFocus = false;
    }

    //Form Focus
    function datecodeDivfocus() {
        if (mediType === 'M') {
            $('#indexdiv').removeClass('div-focus');
            $('#dateCodeLeg').removeClass('div-focus');
            $('#indexfile').removeClass('div-focus');
            $('#indexform').removeClass('div-focus');
            $('#DateCoding_dos').blur();
            //$('#indexform').focus().addClass('div-focus');
            $('#dateCodeLeg').addClass('div-focus');
            $('#DateCoding_patient_name').focus();
        }
        pdfFocus = false;
    }

    //Break Div Focus
    function breakDivfocus() {
        if (mediType === 'M') {
            $('.DateCoding_pages').blur();
            $('#indexdiv').blur().removeClass('div-focus');
            $('#indexform').blur().removeClass('div-focus');
            $('#indexfile').addClass('div-focus');
        }
        else if (mediType === 'N') {
            $('#nonindexdiv').blur().removeClass('div-focus');
            $('#nonindexform').blur().removeClass('div-focus');
            $('#nonindexfile').addClass('div-focus');
        }
    }

    //TextBox Div
    function elementFocus() {
        $('#indexdiv').removeClass('div-focus');
        $('#indexfile').removeClass('div-focus');
        $('#indexform').addClass('div-focus');
        pdfFocus = false;
    }

    function arrange(a, b) {
        return a - b;
    }

    //User Active form
    var tempclick;

    function saveUserForm(form, data, hasError) {

        var tempClickFunc = setInterval(function () {
            tempclick = true;
            clearInterval(tempClickFunc);
        }, 1000);
        if (tempclick == false) {
            return;
        }
        tempclick = false;
        if (hasError) {
            $(".errorMessage").not(':hidden').first().parent().find('input').not(':hidden').focus();
        }
        else {
            if ($('#DateCoding_dos').val() == "") {
                $('#DateCoding_dos').focus();
            }
        }
        var hiddenPages = $(".DateCoding_pages").val();
        if ($('#DateCoding_dos').val() == "" && !($('#DateCoding_undated').prop('checked'))) {
            $('#DateCoding_dos').parent().next('.errorMessage').html("Either Dos/Undated is required!").show();
            return false;
        }
        if (!hasError && completeFiles && hiddenPages) {
            var glbPages = range(1, totalPageNumbers, 1);
            //var nonmedicalPages = arr_diff(glbPages, $('#DateCoding_pages').val().split(','));
            //nonmedicalPages = nonmedicalPages.join(',');
            //$('#FilePartition_npages').val(nonmedicalPages);
            var formdata = new FormData($('#file-partition-form')[0]);
            completeFiles = false;
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/splitcomplete', array('job_id' => $job_id, 'status' => false, 'mode' => 'S')); ?>',
                type: "post",
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    console.log(result);
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        clearTimeout(timer);
                        myFuncCalls = 0;
                        autoSave('D');
                        window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                    }
                }
            });
        } else if (hiddenPages == '') {
            UIkit.notify({
                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>Select Aleast One Page",
                status: "warning",
                timeout: 2000,
                pos: 'top-right',
            });
        } else if (!hasError && !completeFiles) {
            var dos = $('#DateCoding_dos').val();
            var doi = $('#DateCoding_doi').val();
            var valid = true;
            if (dos.toLowerCase().match(/[a-z]/i)) {
                valid = false;
                $("#DateCoding_dos_em_").html('Enter Valid Date');
                $("#DateCoding_dos_em_").show();
            } else {
                $("#DateCoding_dos_em_").html('');
                $("#DateCoding_dos_em_").hide();
            }
            if (doi.toLowerCase().match(/[a-z]/i)) {
                valid = false;
                $("#DateCoding_doi_em_").html('Enter Valid Date');
                $("#DateCoding_doi_em_").show();
            } else {
                $("#DateCoding_doi_em_").html('');
                $("#DateCoding_doi_em_").hide();
            }
            if (valid) {
                <?php if ($check_skip_edt->skip_edit == 1) { ?>
                pagnumcheck();
                <?php } else {
                ?>
                pagnumcheck(); //commonfunction();
                <?php } ?>

            }
        } else {
//            $(".errorMessage:first").prev().focus();
        }
    }


    //User Active form
    function saveNonForm(form, data, hasError) {
        var hiddenPages = $(".DateCoding_nonpages").val();
        if (!hasError && completeFiles && hiddenPages) {
            var glbPages = range(1, totalPageNumbers, 1);
            //var nonmedicalPages = arr_diff(glbPages, $('#DateCoding_pages').val().split(','));
            //nonmedicalPages = nonmedicalPages.join(',');
            //$('#FilePartition_npages').val(nonmedicalPages);
            var formdata = new FormData($('#file-partition-form')[0]);
            completeFiles = false;
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/splitcomplete', array('job_id' => $job_id, 'status' => false, 'mode' => 'S')); ?>',
                type: "post",
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        clearTimeout(timer);
                        myFuncCalls = 0;
                        autoSave('D');
                        window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                    }
                }
            });
        } else if (hiddenPages == '') {
            UIkit.notify({
                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>Select Aleast One Page",
                status: "warning",
                timeout: 2000,
                pos: 'top-right',
            });
        } else if (!hasError && !completeFiles) {
            completeFiles = false;
            var formdata = new FormData($('#non-partition-form')[0]);
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/checkDuplicate') ?>',
                type: "post",
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success: function (result) {
                    if (result == "S") {
                        UIkit.modal.confirm('Details are exist in another partition.Are you sure, you want to merge the partition?', function () {
                            callNpartation(); //merge the file
                        }, function () {
                            duplicateNpartation(); //Added new record this file duplicated.
                        }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});
                    } else {
                        callNpartation();
                    }
                }
            });

        } else {
            $(".errorMessage:first").prev().focus();
        }
    }

    //Call Partation
    function callNpartation() {
        var formdata = new FormData($('#non-partition-form')[0]);
        dtpages = $('#non-partition-form #DateCoding_pages').val();
        dtpages_arr = dtpages.split(',');
        lastpgof = dtpages_arr[dtpages_arr.length - 1];
        var customPagesNew = JSON.parse(customPages);
        lastpg_ind = customPagesNew.indexOf(lastpgof);
        if (customPagesNew[Number(lastpg_ind) + 1] !== undefined) {
            ser_par = customPagesNew[Number(lastpg_ind) + 1];

        }
        else {
            ser_par = customPagesNew[0];
        }
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/filesplit', array('id' => $nonMedPart, 'status' => $type)) ?>',
            type: "post",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                var obj = JSON.parse(result);
                newjson = JSON.parse(obj.pjson);
                initprovider = newjson.P;
                initfacility = newjson.F;
                inittitle = newjson.T;
                initpart = newjson.B;
                initnine = newjson.E;
                initten = newjson.N;
                dxterm = newjson.DX;
                autocom(initprovider, initfacility, inittitle, initpart, initnine, initten, dxterm);
                if (obj.status == "S" || obj.status == "U") {
                    $('.uk-close')[0].click();
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: "success",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                    clearform();
                    clearTimeout(timer);
                    myFuncCalls = 0;
                    autoSave('D');
                    Search(ser_par);
                    /*if(obj.status == "U"){
                     onNextPage();
                     }*/
                    var appendData = obj.append;
                    if (appendData) {
                        $('#filerecord').empty().append(appendData.medi);
                        $('#nonfilerecord').empty().append(appendData.nonmedi);
                        $('#tab_filerecord').empty().append(appendData.tab_medi);
                        $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                    }
                    //$('#nonfilerecord').empty().append(obj.append);
                    nonmedid = $("#nonmedid").val();
                    if (nonmedid !== "") {
                        $('.nonmedpart_tab').trigger("click");
                        $('#brk_btn_' + nonmedid).trigger("click");
                        $("#medid").val('');
                        $("#nonmedid").val('');
                    }
                }
            }
        });
    }

    function duplicateNpartation() {
        var formdata = new FormData($('#non-partition-form')[0]);
        dtpages = $('#non-partition-form #DateCoding_pages').val();
        dtpages_arr = dtpages.split(',');
        lastpgof = dtpages_arr[dtpages_arr.length - 1];
        var customPagesNew = JSON.parse(customPages);
        lastpg_ind = customPagesNew.indexOf(lastpgof);
        if (customPagesNew[Number(lastpg_ind) + 1] !== undefined) {
            ser_par = customPagesNew[Number(lastpg_ind) + 1];
        }
        else {
            ser_par = 1;
        }
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/newrecord') ?>',
            type: "post",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                var obj = JSON.parse(result);
                newjson = JSON.parse(obj.pjson);
                initprovider = newjson.P;
                initfacility = newjson.F;
                inittitle = newjson.T;
                initpart = newjson.B;
                initnine = newjson.E;
                initten = newjson.N;
                dxterm = newjson.DX;
                autocom(initprovider, initfacility, inittitle, initpart, initnine, initten, dxterm);
                if (obj.status == "S" || obj.status == "U") {
                    $('.uk-close')[0].click();
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: "success",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                    clearform();
                    clearTimeout(timer);
                    myFuncCalls = 0;
                    autoSave('D');
                    Search(ser_par);
                    var appendData = obj.append;
                    if (appendData) {
                        $('#filerecord').empty().append(appendData.medi);
                        $('#nonfilerecord').empty().append(appendData.nonmedi);
                        $('#tab_filerecord').empty().append(appendData.tab_medi);
                        $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                    }
                    nonmedid = $("#nonmedid").val();
                    if (nonmedid !== "") {
                        $('.nonmedpart_tab').trigger("click");
                        $('#brk_btn_' + nonmedid).trigger("click");
                        $("#medid").val('');
                        $("#nonmedid").val('');
                    }
                }
            }
        });
    }

    function quitFile() {
        UIkit.modal.confirm("Are you sure, you want to Quit the file?", function () {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => 'SQ', 'jobId' => $job_id)); ?>',
                type: "post",
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                    }
                }
            });
        }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});
    }

    /**
     * clear form
     */
    function clearform() {
        if (mediType === "M") {
            var previousName = $("#DateCoding_patient_name").val();
            var previousDob = $("#DateCoding_dob").val();
            var previousDoi = $("#DateCoding_doi").val();
            var previousGen = $('input[name="DateCoding[gender]"]:checked').val();
            var previousmsValue = $("#DateCoding_ms_value").val();
            $("#file-partition-form").trigger('reset');
            $('#file-partition-form #DateCoding_dos_em_').parent().eq(0).show();
            $('#file-partition-form #DateCoding_todos_em_').parent().eq(0).show();
            $("#DateCoding_record_row").val('');
            $("#DateCoding_dos").val('');
            $(".DateCoding_category").trigger("chosen:updated");
            $(".DateCoding_provider_name").trigger("chosen:updated");
            $(".DateCoding_facility").trigger("chosen:updated");
            $(".DateCoding_ecd_9_diagnoses").trigger("chosen:updated");
            $(".DateCoding_ecd_10_diagnoses").trigger("chosen:updated");
            $(".DateCoding_dx_terms").trigger("chosen:updated");
            $(".DateCoding_body_parts").trigger("chosen:updated");
//            $('#non-partition-form #DateCoding_provider_name').trigger("chosen:updated");
//        $('#non-partition-form #DateCoding_facility').trigger("chosen:updated");
//        $('#non-partition-form #DateCoding_body_parts').trigger("chosen:updated");
//        $('#non-partition-form #DateCoding_ecd_9_diagnoses').trigger("chosen:updated");
//        $('#non-partition-form #DateCoding_ecd_10_diagnoses').trigger("chosen:updated");
//        $('#non-partition-form #DateCoding_dx_terms').trigger("chosen:updated");
            $("#DateCoding_patient_name").val(previousName);
            $("#DateCoding_doi").val(previousDoi);
            $("#DateCoding_dob").val(previousDob);
            $("#DateCoding_ms_value").val(previousmsValue);
            $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
            $('input[name="DateCoding[gender]"][value=' + previousGen + ']').prop('checked', true).iCheck('update');
            $('#file-partition-form input[type=submit]').val('Create');
            $('#file-partition-form input[type=submit]').hasClass('md-btn-warning') ? $('#file-partition-form input[type=submit]').removeClass('md-btn-warning').addClass('md-btn-success') : '';
            setClass();
            formDivfocus();
        }
        else if (mediType === "N") {
            $("#non-partition-form").trigger('reset');
            $(".DateCoding_noncategory").trigger("chosen:updated");
            $("#non-partition-form #DateCoding_record_row").val('');
            $('#non-partition-form input[type=submit]').val('Create');
            $('#non-partition-form input[type=submit]').hasClass('md-btn-warning') ? $('#non-partition-form input[type=submit]').removeClass('md-btn-warning').addClass('md-btn-success') : '';
            $(".DateCoding_ecd_9_diagnoses").trigger("chosen:updated");
            $(".DateCoding_ecd_10_diagnoses").trigger("chosen:updated");
            $(".DateCoding_dx_terms").trigger("chosen:updated");
            $(".DateCoding_body_parts").trigger("chosen:updated");
            /*$('#non-partition-form #DateCoding_pages').val($($this).attr('data-pagno'));
             $('#non-partition-form #DateCoding_category').val($($this).attr('data-cat'));
             $("#non-partition-form #DateCoding_category").trigger("chosen:updated");
             $('#non-partition-form #DateCoding_record_row').val($($this).attr('data-row'));
             $('#non-partition-form input[type=submit]').val('Update');*/
            setClass();
            pdfDivfocus();
        }
        /*$("#DateCoding_patient_name").val(previousName);
         $("#DateCoding_record_row").val('');
         $("#DateCoding_category").trigger("chosen:updated");
         $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
         $('input[type=submit]').val('Create');
         $('input[type=submit]').hasClass('md-btn-warning') ? $('input[type=submit]').removeClass('md-btn-warning').addClass('md-btn-success') : '';
         setClass();
         formDivfocus(); */
        /*$('#indexform').focus().addClass('div-focus');
         pdfFocus = false;
         $('#DateCoding_pages').focus();*/
    }

    /**
     * @Complete
     */
    /*function completeFile() {
     UIkit.modal.confirm("Are you sure, you want to complete the file?", function () {
     completeFiles = true;
     $('#file-partition-form').submit();
     });
     }*/

    function splitcall() {
        prtid = '<?php echo $nonMedPart ?>';
        utyp = '<?php echo $_GET['status'] ?>';
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('filepartition/getsplitpages') ?>",
            type: "post",
            async: false,
            data: {partid: prtid, usertype: utyp},
            success: function (result) {
                var obj = JSON.parse(result);
                customPg = obj.oldpage;
                customPgArray = JSON.parse(customPg);
                if (customPgArray[0] === "") {
                    splitvalue = 1;
                }
                else {
                    splitvalue = 2;
                }
            }
        });
    }

    function getcatlist() {
        var strcat = [];
        var catnofield = $("#filerecord a")
        $.each(catnofield, function (key, value) {
            var cdata = $(this).attr('data-cat');
            if ((jQuery.inArray(cdata, strcat)) == -1) {
                strcat.push(cdata);
            }

        });
        return strcat;
    }

    function completeFile() {
        var mdstatus = $('#medstatus').val();
        var nmdstatus = $('#nonmedstatus').val();
        var catids = getcatlist();
        catids = catids.sort();
        splitcall();
        alertMsg = '';
        if ($("#filerecord a").length > 0) {
            //if(mdstatus === 'C' && nmdstatus === 'C'){
            if ($('.uk-modal').is(':visible') === false) {
                var messagetxt = decidewhichpage();
                /* var text="";
                 var partitionmedi = $('#filerecord a');
                 var tmpmedi = '';
                 $.each(partitionmedi, function (key, value) {
                 tmpmedi += $(this).attr('data-pagno').split(",") + ",";
                 });
                 splitPageNomedi = tmpmedi.split(',').map(Number);
                 splitPageNomedi = jQuery.grep(splitPageNomedi, function(value) {
                 return value != 0;
                 });
                 splitPageNomedi = $.unique(splitPageNomedi);
                 if(medarrays.length >splitPageNomedi.length)
                 {
                 text+="Medical";
                 }
                 var partitionnonmedi = $('#nonfilerecord a');
                 var tmpnonmedi = '';
                 $.each(partitionnonmedi, function (key, value) {
                 tmpnonmedi += $(this).attr('data-pagno').split(",") + ",";
                 });
                 splitPageNononmedi = tmpnonmedi.split(',').map(Number);
                 splitPageNononmedi = jQuery.grep(splitPageNononmedi, function(value) {
                 return value != 0;
                 });
                 splitPageNononmedi = $.unique(splitPageNononmedi);
                 if(nonmedarrays.length >splitPageNononmedi.length)
                 {
                 text+="Non-Medical";
                 }
                 checkedarray = arrayUnique(splitPageNomedi.concat(splitPageNononmedi));
                 checkedarray.sort(function (a, b) {
                 return a - b
                 });*/
                if (checkedarray.length == wholearray.length) {
                    alertMsg = "Are you sure, you want to complete the file?";
                }
                else {

                    alertMsg = "Certain pages are not reviewed in " + messagetxt.fontcolor("blue") + ",Are you sure, you want to complete the file?";
                }
                UIkit.modal.confirm(alertMsg, function () {
                    $.ajax({
                        url: '<?php echo Yii::app()->createUrl('filepartition/Splitcomplete', array('mode' => 'S', 'status' => false)); ?>',
                        type: "post",
                        data: {job_id: <?php echo $job_id; ?>, cat_ids: catids},
                        success: function (result) {
                            var obj = JSON.parse(result);
                            if (obj.status == "S" || obj.status == "U") {
                                clearTimeout(timer);
                                myFuncCalls = 0;
                                autoSave('D');
                                <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                                window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/allgrid'); ?>';
                                <?php } else { ?>
                                window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                                <?php } ?>
                            }
                        }
                    });
                }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});
            }
        } else {
            if ($('.uk-notify').is(':visible') === false) {
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Create atleast one partition on both!",
                    status: "error",
                    timeout: 500,
                    pos: 'top-right'
                });
            }
        }
    }

    /* function getcatlist()
     {
         var strcat=[];
         var catnofield=$("#filerecord a")
         $.each(catnofield, function (key, value) {
             var cdata =$(this).attr('data-cat');
             strcat.push(cdata);
         });
         return strcat;
     }*/
    function CompleteQc() {

        var medstatus = $('#medstatus').val();
        var nmedstatus = $('#nonmedstatus').val();
        var catids = getcatlist();
        catids = catids.sort();
        splitcall();
        alertMsg = '';
        if ($('.uk-modal').is(':visible') === false) {
            if ($("#filerecord a").length > 0) {
                //if (medstatus === 'C' && nmedstatus === 'C') {
                var messagetxt = decidewhichpage();
                id = <?php echo $job_id; ?>;
                <?php if ($check_skip_edt->skip_edit == 1) { ?>
                if (checkedarray.length == wholearray.length) {
                    alertMsg = "Are you sure, you want to complete the file?";
                }
                else {
                    alertMsg = "Certain pages are not reviewed in" + messagetxt.fontcolor("blue") + ",Are you sure, you want to complete the file?";
                }
                <?php } else { ?>
                if (checkedarray.length == wholearray.length) {
                    alertMsg = "Move to Editing?";
                }
                else {
                    alertMsg = "Certain pages are not reviewed " + messagetxt.fontcolor("blue") + ",Move to Editing?";
                }
                <?php } ?>
                UIkit.modal.confirm(alertMsg, function () {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('joballocation/qualityupdate') ?>/" + id,
                        type: "post",
                        data: {status: 'SQC', cat_ids: catids},
                        success: function (result) {
                            clearTimeout(timer);
                            myFuncCalls = 0;
                            autoSave('D');
                            var obj = JSON.parse(result);
                            if (obj.status == "S" || obj.status == "U") {
                                <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                                window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/allgrid'); ?>';
                                <?php } else { ?>
                                window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                                <?php } ?>
                            }
                        }
                    });
                }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});

                /*}
                 else {
                 if ($('.uk-notify').is(':visible') === false) {
                 UIkit.notify({
                 message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Finish both medical and non medical",
                 status: "error",
                 timeout: 2000,
                 pos: 'top-right'
                 });
                 }
                 }*/
            }
            else {
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Create atleast one partition in medical!",
                        status: "error",
                        timeout: 500,
                        pos: 'top-right'
                    });
                }
            }

        }
    }

    function finishFile(typvar) {
        lengthof = '';
        typefile = '';
        if (typvar === "M") {
            lengthof = $("#filerecord a").length;
            typefile = 'Medical';
        }
        else if (typvar === "N") {
            lengthof = $("#nonfilerecord div").length;
            typefile = 'Non Medical';
        }
        if ($('.uk-modal').is(':visible') === false) {
            if (lengthof > 0) {
                id = <?php echo $job_id; ?>;
                UIkit.modal.confirm("Are you sure want to finish?", function () {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('filepartition/finishfile') ?>",
                        type: "post",
                        data: {jobid: id, type: typvar},
                        success: function (result) {
                            var obj = JSON.parse(result);
                            if (obj.status == "S") {
                                st = 'success';
                                if (typvar == 'M') {
                                    $('#medstatus').val('C');
                                    $('#medfinish').addClass('disabled');
                                    $('#file-partition-form .createbtn').addClass('disabled');
                                }
                                else if (typvar == 'N') {
                                    $('#nonmedstatus').val('C');
                                    $('#nonmedfinish').addClass('disabled');
                                    $('#non-partition-form .createbtn').addClass('disabled');
                                }
                            }
                            else if (obj.status == "E") {
                                st = 'error';
                            }
                            if ($('.uk-notify').is(':visible') === false) {
                                $('.uk-close')[0].click();
                                UIkit.notify({
                                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                                    status: st,
                                    timeout: 500,
                                    pos: 'top-right'
                                });
                            }
                        }
                    });
                });
            }
            else {
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Create atleast one partition in " + typefile + "!",
                        status: "error",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                }
            }
        }
    }

    /**
     * @append button
     */
    function appendRecord() {
        var val = <?php echo json_encode(Yii::app()->filerecord->getSavedRecord($poject_id, $file_id)); ?>;
        if (val) {
            $('#filerecord').empty().append(val.medi);
            $('#nonfilerecord').empty().append(val.nonmedi);
            $('#tab_filerecord').empty().append(val.tab_medi);
            $('#tab_nonfilerecord').empty().append(val.tab_nonmedi);
        }
        calculatearray(val.medi, val.nonmedi);
        //var val = "<?php //echo Yii::app()->filerecord->getSavedRecord($poject_id, $file_id);                   ?>";
        //$('#filerecord').empty().append(val);
    }

    var wholearray = [],
        splitPageNomedi = [],
        splitPageNononmedi = [],
        checkedarray = [];

    function calculatearray(medi, nonmedi) {

        if (medi) {

            var partitionmedi = $('#filerecord a');
            var tmpmedi = '';
            $.each(partitionmedi, function (key, value) {
                tmpmedi += $(this).attr('data-pagno').split(",") + ",";
            });
            splitPageNomedi = tmpmedi.split(',').map(Number);
        }
        if (nonmedi) {
            var partitionnonmedi = $('#nonfilerecord a');
            var tmpnonmedi = '';
            $.each(partitionnonmedi, function (key, value) {
                tmpnonmedi += $(this).attr('data-pagno').split(",") + ",";
            });
            splitPageNononmedi = tmpnonmedi.split(',').map(Number);

        }
        checkedarray = arrayUnique(splitPageNomedi.concat(splitPageNononmedi));
        checkedarray.sort(function (a, b) {
            return a - b
        });
        setTimeout(function () {
            for (i = 1; i <= totalPageNumbers; i++) {
                wholearray.push(i);
            }
        }, 3000);
    }

    function arrayUnique(array) {
        var a = array.concat();
        for (var i = 0; i < a.length; ++i) {
            for (var j = i + 1; j < a.length; ++j) {
                if (a[i] === a[j])
                    a.splice(j--, 1);
            }
        }

        return a;
    }

    function tablesort() {
        var $table = $('#tab_filerecord table');
        var rows = $table.find('tr.medicaltable').get();
        rows.sort(function (a, b) {
            var keyA = $(a).attr('data-dos').split("-")[0];
            var keyB = $(b).attr('data-dos').split("-")[0];
            if (keyA > keyB) return 1;
            if (keyA < keyB) return -1;
            return 0;
        });

        $.each(rows, function (index, row) {
            $table.children('tbody').append(row);
        });
    }

    function getContent($this) {
        //get PageNo
        var splitPageNo = $this.attr('data-pagno').split(",");
        pageNum = Number(splitPageNo[splitPageNo.length - 1]);
        loadToPage(pageNum);
        //Append Data
        if (mediType == 'M') {
            if ($this.prop("tagName") == "TR") {
                $('#tab_filerecord tr.row_checked').removeClass('row_checked');
                $($this).addClass("row_checked");
            }
            $('#file-partition-form #DateCoding_pages').val($($this).attr('data-pagno'));
            dos_string = $($this).attr('data-dos');
            if (dos_string.indexOf('-') > -1) {
                dos_arr = dos_string.split('-');
                $('#file-partition-form #DateCoding_dos').val(dos_arr[0]);
                $('#file-partition-form #DateCoding_todos').val(dos_arr[1]);
            }
            else {
                $('#file-partition-form #DateCoding_dos').val(dos_string);
                $('#file-partition-form #DateCoding_todos').val("");
            }
            //$('#file-partition-form #DateCoding_dos').val($($this).attr('data-dos'));
            $('#file-partition-form #DateCoding_dos').trigger('autoresize');
            $('#file-partition-form #DateCoding_todos').trigger('autoresize');
            $('#file-partition-form #DateCoding_patient_name').val($($this).attr('data-pname'));
            $('#file-partition-form #DateCoding_dob').val($($this).attr('data-dob'));
            $('#file-partition-form #DateCoding_category').val($($this).attr('data-cat'));
            $('#file-partition-form #DateCoding_provider_name').val($($this).attr('data-provider').split('^'));
            $('#file-partition-form #DateCoding_provider_name').trigger("chosen:updated");
            $('#file-partition-form #DateCoding_title').val($($this).attr('data-title'));
            if ($($this).attr('data-dos') == "") {
                $('#file-partition-form #DateCoding_undated').prop('checked', 'checked');
                $('#file-partition-form #DateCoding_dos_em_').parent().eq(0).hide();
                $('#file-partition-form #DateCoding_todos_em_').parent().eq(0).hide();
            }
            else {
                $('#file-partition-form #DateCoding_undated').prop('checked', false);
                $('#file-partition-form #DateCoding_dos_em_').parent().eq(0).show()
                $('#file-partition-form #DateCoding_todos_em_').parent().eq(0).show()
            }
            $("#file-partition-form #DateCoding_category").trigger("chosen:updated");
            $('#file-partition-form #DateCoding_record_row').val($($this).attr('data-row'));
            var gender = $($this).attr('data-gender');
            $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
            $('input[name="DateCoding[gender]"][value=' + gender + ']').prop('checked', true).iCheck('update');
            $('#file-partition-form #DateCoding_doi').val($($this).attr('data-doi'));
            $('#file-partition-form #DateCoding_facility').val($($this).attr('data-facility'));
            $('#file-partition-form #DateCoding_facility').trigger("chosen:updated");
            //Data explode and string replace........
            <?php if ($check_skip_edt->skip_edit == 1) { ?>
            //                var dataBodyPart = $($this).attr('data-bodyparts').split('^').join('\n');
            var dataBodyPart = $($this).attr('data-bodyparts').split('^');

            var ecd_diag = $($this).attr('data-diagonis').split('~');
            //var dataDiagnoses = $($this).attr('data-diagonis').split('^').join('\n');
            $('#file-partition-form #DateCoding_body_parts').val(dataBodyPart);
            $('#file-partition-form #DateCoding_body_parts').trigger("chosen:updated");
            //$('#file-partition-form #DateCoding_diagnoses').val(dataDiagnoses);
            //                $('#file-partition-form #DateCoding_ecd_9_diagnoses').val(ecd_diag[0].split('^').join('\n'));
            $('#file-partition-form #DateCoding_ecd_9_diagnoses').val(ecd_diag[0].split('^'));
            $('#file-partition-form #DateCoding_ecd_9_diagnoses').trigger("chosen:updated");
            $('#file-partition-form #DateCoding_ecd_10_diagnoses').val(ecd_diag[1].split('^'));
            $('#file-partition-form #DateCoding_ecd_10_diagnoses').trigger("chosen:updated");
            //                $('#file-partition-form #DateCoding_ecd_10_diagnoses').val(ecd_diag[1].split('^').join('\n'));
            // $('#file-partition-form #DateCoding_dx_terms').val($($this).attr('data-dxterms'));
            $('#file-partition-form #DateCoding_dx_terms').val(ecd_diag[2].split('^'));
            $('#file-partition-form #DateCoding_dx_terms').trigger("chosen:updated");
            <?php if($template_name == "BACTESPDF"){ ?>
            $('#file-partition-form #DateCoding_ms_terms').val($($this).attr('data-msterms'));
            $('#file-partition-form #DateCoding_ms_value').val($($this).attr('data-msvalue'));
            <?php } ?>
            <?php } ?>
            $('#file-partition-form input[type=submit]').val('Update');
            if ($this.prop("tagName") !== "TR") {
                setClass();
                $($this).hasClass('md-btn-primary') ? $($this).removeClass('md-btn-primary').addClass('md-btn-warning') : $($this).removeClass('md-btn-warning').addClass('md-btn-primary');
            }
            $('#file-partition-form input[type=submit]').hasClass('md-btn-success') ? $('#file-partition-form input[type=submit]').removeClass('md-btn-success').addClass('md-btn-warning') : '';
        }
        else if (mediType == 'N') {
            if ($this.prop("tagName") == "TR") {
                $('#tab_nonfilerecord tr.row_checked').removeClass('row_checked');
                $($this).addClass("row_checked");
            }
            $('#non-partition-form #DateCoding_pages').val($($this).attr('data-pagno'));
            $('#non-partition-form #DateCoding_category').val($($this).attr('data-cat'));
            $("#non-partition-form #DateCoding_category").trigger("chosen:updated");
            $('#non-partition-form #DateCoding_record_row').val($($this).attr('data-row'));
            /*$('#non-partition-form #DateCoding_body_parts').val($($this).attr('data-bodyparts'));
             $('#non-partition-form #DateCoding_diagnoses').val($($this).attr('data-diagonis'));*/
            <?php if ($check_skip_edt->skip_edit == 1) { ?>
            var dataBodyPart = $($this).attr('data-bodyparts').split('^');

            var ecd_diag = $($this).attr('data-diagonis').split('~');
            //var dataDiagnoses = $($this).attr('data-diagonis').split('^').join('\n');
            $('#non-partition-form #DateCoding_body_parts').val(dataBodyPart);
            $('#non-partition-form #DateCoding_body_parts').trigger("chosen:updated");
            //$('#non-partition-form #DateCoding_diagnoses').val(dataDiagnoses);
            //$('#non-partition-form #DateCoding_dx_terms').val($($this).attr('data-dxterms'));
            $('#non-partition-form #DateCoding_dx_terms').val(ecd_diag[2].split('^'));
            $('#non-partition-form #DateCoding_dx_terms').trigger("chosen:updated");
            $('#non-partition-form #DateCoding_ecd_9_diagnoses').val(ecd_diag[0].split('^'));
            $('#non-partition-form #DateCoding_ecd_9_diagnoses').trigger("chosen:updated");
            $('#non-partition-form #DateCoding_ecd_10_diagnoses').val(ecd_diag[1].split('^'));
            $('#non-partition-form #DateCoding_ecd_10_diagnoses').trigger("chosen:updated");
            <?php } ?>
            $('#non-partition-form input[type=submit]').val('Update');
            if ($this.prop("tagName") !== "TR") {
                setClass();
                $($this).hasClass('md-btn-primary') ? $($this).removeClass('md-btn-primary').addClass('md-btn-warning') : $($this).removeClass('md-btn-warning').addClass('md-btn-primary');
            }
            $('#non-partition-form input[type=submit]').hasClass('md-btn-success') ? $('#non-partition-form input[type=submit]').removeClass('md-btn-success').addClass('md-btn-warning') : '';
        }
        /* $('.DateCoding_pages').val($($this).attr('data-pagno'));
         $('#DateCoding_dos').val($($this).attr('data-dos'));
         $('#DateCoding_dos').trigger('autoresize');
         $('#DateCoding_patient_name').val($($this).attr('data-pname'));
         $('.DateCoding_category').val($($this).attr('data-cat'));
         $('#DateCoding_provider_name').val($($this).attr('data-provider'));
         $('#DateCoding_title').val($($this).attr('data-title'));
         if($($this).attr('data-dos') == ""){
         $('#DateCoding_undated').prop('checked','checked');
         $('#DateCoding_dos_em_').parent('.uk-row-first').hide();
         }
         else{
         $('#DateCoding_undated').prop('checked',false);
         $('#DateCoding_dos_em_').parent('.uk-row-first').show()
         }
         $(".DateCoding_category").trigger("chosen:updated");
         $('#DateCoding_record_row').val($($this).attr('data-row'));
         var gender = $($this).attr('data-gender');
         $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
         $('input[name="DateCoding[gender]"][value=' + gender + ']').prop('checked', true).iCheck('update');
         $('#DateCoding_doi').val($($this).attr('data-doi'));
         $('#DateCoding_facility').val($($this).attr('data-facility'));*/
        //$('#file-partition-form input[type=submit]').val('Update');
        //setClass();
        //$($this).hasClass('md-btn-primary') ? $($this).removeClass('md-btn-primary').addClass('md-btn-warning') : $($this).removeClass('md-btn-warning').addClass('md-btn-primary');
        //$('#file-partition-form input[type=submit]').hasClass('md-btn-success') ? $('#file-partition-form input[type=submit]').removeClass('md-btn-success').addClass('md-btn-warning') : '';

    }

    /**
     * @Set Class
     */
    function setClass() {
        if (mediType === 'M') {
            $('#filerecord  a').each(function () {
                if ($(this).hasClass('md-btn-warning')) {
                    $(this).removeClass('md-btn-warning').addClass('md-btn-primary');
                }
            });
        }
        else if (mediType === 'N') {
            $('#nonfilerecord  a').each(function () {
                if ($(this).hasClass('md-btn-warning')) {
                    $(this).removeClass('md-btn-warning').addClass('md-btn-primary');
                }
            });
        }
    }

    //Modal Popup
    var userModal = UIkit.modal("#quitModal");

    function quit() {
        $("#quitModal .uk-modal-header h3").html("Quit Description");
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => 'SQ', 'jobId' => $job_id)); ?>',
            type: "post",
            success: function (result) {
                $("#quitModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
                $('#JobAllocation_description').focus();
            }
        });
    }

    $('#quitModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#quitModal .uk-modal-header h3").html("");
            $("#quitModal .uk-modal-content").html("");
        }
    });

    //@Add FeedBack for Reviewer
    function feedback() {
        $("#quitModal .uk-modal-header h3").html("FeedBack");
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('joballocation/feedback', array('id' => $job_id)) ?>',
            type: "post",
            data: {'status': 'I'},
            success: function (result) {
                $("#quitModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
                $('#JobAllocation_ja_qc_feedback').focus();
            }
        });
    }

    // Focus fot Form Text
    function inputFocus($val) {
        pdfFocus = $val;
    }

    document.getElementById('non_medical').addEventListener('click', non_medical);
    document.getElementById('medicalmodal').addEventListener('click', medicalmodal);

    //Move to Non Medical
    function non_medical() {
        totalpages = JSON.parse(customPages);
        nonArray = nonPages.split(',');
        if (nonPages !== "" && totalpages.length !== nonArray.length) {
            $("#quitModal .uk-modal-header h3").html("Non Medical Page");
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/movenonmedical', array('file_id' => $file_id)) ?>',
                type: "post",
                data: {'pages': nonPages},
                success: function (result) {
                    $("#quitModal .uk-modal-content").html(result);
                    $("#triggerModal").trigger("click");
                    $("#page-move-form #DateCoding_pages").focus();
                }
            });
        }
        else {
            altmsg = "";
            if (nonPages === "") {
                altmsg = "Choose pages for Non Medical";
            }
            else {
                altmsg = "Cannot move all the pages to Non-Medical";
            }
            if ($('.uk-notify').is(':visible') === false) {
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + altmsg,
                    status: "error",
                    timeout: 2000,
                    pos: 'top-right'
                });
            }
        }
    }

    //move to medical pages
    function medicalmodal() {
        if (monPages !== "") {
            $("#quitModal .uk-modal-header h3").html("Medical Page");
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('filepartition/movemedical', array('file_id' => $file_id)) ?>',
                type: "post",
                data: {'pages': monPages},
                success: function (result) {
                    $("#quitModal .uk-modal-content").html(result);
                    $("#triggerModal").trigger("click");
                    $("#page-move-form #DateCoding_patient_name").focus();
                }
            });
        }
        else {
            altmsg = "Choose pages for Medical";
            if ($('.uk-notify').is(':visible') === false) {
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + altmsg,
                    status: "error",
                    timeout: 2000,
                    pos: 'top-right'
                });
            }
        }
    }

    function pagnumcheck() {
        var newsplitPageNomedi = [];
        var partitionmedi = $('#filerecord .md-btn-primary ');
        var tmpmedi = '';
        $.each(partitionmedi, function (key, value) {
            tmpmedi += $(this).attr('data-pagno').split(",") + ",";
        });
        newsplitPageNomedi = tmpmedi.split(',').map(Number);
        newsplitPageNomedi = jQuery.grep(newsplitPageNomedi, function (value) {
            return value != 0;
        });
        newsplitPageNomedi = $.unique(newsplitPageNomedi);
        var curnt = $("#DateCoding_pages").val().split(",").map(Number);
        var i = 0;
        var narray = [];
        $.grep(newsplitPageNomedi, function (el) {
            if ($.inArray(el, curnt) != -1) {
                narray.push(el);
                return false;
            }
            i++;
        });

        if (narray.length > 0) {
            var duplicatePg = narray.join(", ");
            var altr = "Created Partition page number (" + duplicatePg + ") already Exists";
            UIkit.modal.confirm(altr, function () {
                commonfunction();
            }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});
        }
        else {
            commonfunction();
        }

    }

    function commonfunction() {
        completeFiles = false;
        var formdata = new FormData($('#file-partition-form')[0]);
        //Check the combination link
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/checkDuplicate') ?>',
            type: "post",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                if (result == "S") {//combination match then ask to combine otr not
                    UIkit.modal.confirm('Details are exist in another partition.Are you sure, you want to merge the partition?', function () {
                        callMpartation(); //merge the file
                    }, function () {
                        addedDuplicate(); //Added new record this file duplicated.
                    }, {labels: {'Ok': 'Yes', 'Cancel': 'No'}});
                } else {
                    callMpartation(); //Added new record;
                }
            }
        });
    }

    function addedDuplicate() {
        completeFiles = false;
        var formdata = new FormData($('#file-partition-form')[0]);
        dtpages = $('#file-partition-form #DateCoding_pages').val();
        dtpages_arr = dtpages.split(',');
        lastpgof = dtpages_arr[dtpages_arr.length - 1];
        var customPagesNew = JSON.parse(customPages);
        lastpg_ind = customPagesNew.indexOf(lastpgof);
        if (customPagesNew[Number(lastpg_ind) + 1] !== undefined) {
            ser_par = customPagesNew[Number(lastpg_ind) + 1];
        }
        else {
            ser_par = 1;
        }
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/newrecord') ?>',
            type: "post",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                var obj = JSON.parse(result);
                newjson = JSON.parse(obj.pjson);
                initprovider = newjson.P;
                initfacility = newjson.F;
                inittitle = newjson.T;
                initpart = newjson.B;
                initnine = newjson.E;
                initten = newjson.N;
                dxterm = newjson.DX;
                autocom(initprovider, initfacility, inittitle, initpart, initnine, initten, dxterm);
                if (obj.status == "S" || obj.status == "U") {
                    $('.uk-close')[0].click();
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: "success",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                    clearform();
                    clearTimeout(timer);
                    myFuncCalls = 0;
                    autoSave('D');
                    Search(ser_par);
                    var appendData = obj.append;
                    if (appendData) {
                        $('#filerecord').empty().append(appendData.medi);
                        $('#nonfilerecord').empty().append(appendData.nonmedi);
                        $('#tab_filerecord').empty().append(appendData.tab_medi);
                        $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                    }
                    medid = $("#medid").val();
                    if (medid !== "") {
                        $('.medpart_tab').trigger("click");
                        $('#brk_btn_' + medid).trigger("click");
                        $("#medid").val('');
                        $("#nonmedid").val('');
                    }
                }
            }
        });
    }

    //file m partation
    function callMpartation() {
        completeFiles = false;
        var formdata = new FormData($('#file-partition-form')[0]);
        dtpages = $('#file-partition-form #DateCoding_pages').val();
        dtpages_arr = dtpages.split(',');
        lastpgof = dtpages_arr[dtpages_arr.length - 1];
        var customPagesNew = JSON.parse(customPages);
        lastpg_ind = customPagesNew.indexOf(lastpgof);
        if (customPagesNew[Number(lastpg_ind) + 1] !== undefined) {
            ser_par = customPagesNew[Number(lastpg_ind) + 1];
        }
        else {
            ser_par = customPagesNew[0];
        }

        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/filesplit', array('id' => $partition_id, 'status' => $type)) ?>',
            type: "post",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {

                var obj = JSON.parse(result);
                newjson = JSON.parse(obj.pjson);
                initprovider = newjson.P;
                initfacility = newjson.F;
                inittitle = newjson.T;
                initpart = newjson.B;
                initnine = newjson.E;
                initten = newjson.N;
                dxterm = newjson.DX;
                autocom(initprovider, initfacility, inittitle, initpart, initnine, initten, dxterm);
                if (obj.status == "S" || obj.status == "U") {
                    $('.uk-close')[0].click();
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: "success",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                    clearform();
                    clearTimeout(timer);
                    myFuncCalls = 0;
                    autoSave('D');
                    Search(ser_par);
                    /*if(obj.status == "U"){
                     onNextPage();
                     }*/
                    var appendData = obj.append;
                    if (appendData) {
                        $('#filerecord').empty().append(appendData.medi);
                        $('#nonfilerecord').empty().append(appendData.nonmedi);
                        $('#tab_filerecord').empty().append(appendData.tab_medi);
                        $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                    }
                    //$('#filerecord').empty().append(obj.append);
                    medid = $("#medid").val();
                    if (medid !== "") {
                        $('.medpart_tab').trigger("click");
                        $('#brk_btn_' + medid).trigger("click");
                        $("#medid").val('');
                        $("#nonmedid").val('');
                    }
                }
            }
        });
    }


    function mpartation() {
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/filesplit', array('id' => $partition_id, 'status' => $type)) ?>',
            type: "post",
            data: formdata,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                var obj = JSON.parse(result);
                newjson = JSON.parse(obj.pjson);
                initprovider = newjson.P;
                initfacility = newjson.F;
                inittitle = newjson.T;
                initpart = newjson.B;
                initnine = newjson.E;
                initten = newjson.N;
                dxterm = newjson.DX;
                autocom(initprovider, initfacility, inittitle, initpart, initnine, initten, dxterm);
                if (obj.status == "S" || obj.status == "U") {
                    $('.uk-close')[0].click();
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                        status: "success",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                    clearform();
                    clearTimeout(timer);
                    myFuncCalls = 0;
                    autoSave('D');
                    var appendData = obj.append;
                    if (appendData) {
                        $('#filerecord').empty().append(appendData.medi);
                        $('#nonfilerecord').empty().append(appendData.nonmedi);
                        $('#tab_filerecord').empty().append(appendData.tab_medi);
                        $('#tab_nonfilerecord').empty().append(appendData.tab_nonmedi);
                    }
                    //$('#filerecord').empty().append(obj.append);
                }
            }
        });
    }

    function decidewhichpage() {
        var text = "";
        var partitionmedi = $('#filerecord a');
        var tmpmedi = '';
        $.each(partitionmedi, function (key, value) {
            tmpmedi += $(this).attr('data-pagno').split(",") + ",";
        });
        splitPageNomedi = tmpmedi.split(',').map(Number);
        splitPageNomedi = jQuery.grep(splitPageNomedi, function (value) {
            return value != 0;
        });
        splitPageNomedi = $.unique(splitPageNomedi);
        if (medarrays.length > splitPageNomedi.length) {
            text += "Medical";
        }
        var partitionnonmedi = $('#nonfilerecord a');
        var tmpnonmedi = '';
        $.each(partitionnonmedi, function (key, value) {
            tmpnonmedi += $(this).attr('data-pagno').split(",") + ",";
        });
        splitPageNononmedi = tmpnonmedi.split(',').map(Number);
        splitPageNononmedi = jQuery.grep(splitPageNononmedi, function (value) {
            return value != 0;
        });
        splitPageNononmedi = $.unique(splitPageNononmedi);
        if (nonmedarrays.length > splitPageNononmedi.length) {
            text += "Non-Medical";
        }
        checkedarray = arrayUnique(splitPageNomedi.concat(splitPageNononmedi));
        checkedarray.sort(function (a, b) {
            return a - b
        });
        if (text == "MedicalNon-Medical" && text != '') {
            text = "Medical and Non-Medical";
        }
        return text;
    }

    function pageRange() {
        $("#raneModal").trigger("click");
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function savePages() {
        var tab;
        if ($('.uk-tab-grid').first().find('li.uk-active').hasClass('medtab')) {
            tab = "M";
        }
        else {
            tab = "N";
        }
        var fromPgNo = $('#from').val();
        var toPgNo = $('#to').val();
        var range = getRange(Number(fromPgNo), Number(toPgNo));
        var catValidate;
        if (range != "N") {
            if (tab == "M") {
                catValidate = validateRangeCategory(range, medarrays);
                if (catValidate) {
                    $('#DateCoding_pages').val(range);
                    $('#rangeclose').trigger('click');
                    $('#from_error').hide();
                    $('#from').val("");
                    $('#to').val("");
                }
                else {
                    $('#from_error').show().html('Invalid Page No!');
                }
            }
            else {
                catValidate = validateRangeCategory(range, nonmedarrays);
                if (catValidate) {
                    $('.nonmedicalpages').val(range);
                    $('#rangeclose').trigger('click');
                    $('#from_error').hide();
                    $('#from').val("");
                    $('#to').val("");
                }
                else {
                    $('#from_error').show().html('Invalid Page No!');
                }
            }
        }
        else {
            $('#from_error').show().html('Invalid Page range!');
            return "N";
        }

    }

    function getRange(from, to) {
        var validRange = validateRange(from, to);
        if (validRange) {
            var rangearr = [];
            for (var i = from; i <= to; i++) {
                rangearr.push(Number(i));
            }
            return rangearr;
        }
        else {
            return "N";
        }

    }

    function validateRange(from, to) {
        if (from >= to) {
            return false;
        }
        else {
            return true;
        }
    }

    function validateRangeCategory(ctmPages, cusPages) {
        var catValid = true;
        for (var i = 0; i < ctmPages.length; i++) {
            if ($.inArray(Number(ctmPages[i]), cusPages) == -1) {
                catValid = false;
                break;
            }
        }
        return catValid;
    }

    function getMissingPages() {
        $("#pageMisModal").trigger("click");
        var text = "";
        var partitionmedi = $('#filerecord a');
        var tmpmedi = '';
        $.each(partitionmedi, function (key, value) {
            tmpmedi += $(this).attr('data-pagno').split(",") + ",";
        });
        splitPageNomedi = tmpmedi.split(',').map(Number);
        splitPageNomedi = jQuery.grep(splitPageNomedi, function (value) {
            return value != 0;
        });
        splitPageNomedi = $.unique(splitPageNomedi);
        var arr1 = $(medarrays).not(splitPageNomedi).get();
        if (medarrays.length > splitPageNomedi.length) {
            $('#misMedPag').html(arr1.join(", "));
        }
        var partitionnonmedi = $('#nonfilerecord a');
        var tmpnonmedi = '';
        $.each(partitionnonmedi, function (key, value) {
            tmpnonmedi += $(this).attr('data-pagno').split(",") + ",";
        });
        splitPageNononmedi = tmpnonmedi.split(',').map(Number);
        splitPageNononmedi = jQuery.grep(splitPageNononmedi, function (value) {
            return value != 0;
        });
        splitPageNononmedi = $.unique(splitPageNononmedi);
        var arr2 = $(nonmedarrays).not(splitPageNononmedi).get();
        if (nonmedarrays.length > splitPageNononmedi.length) {
            $('#misNMedPag').html(arr2.join(", "));
        }
    }

    $(function () {
        /*$(document).keydown(function(event){
            if(event.keyCode==123){
                return false;
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode==73){
                return false;  //Prevent from ctrl+shift+i
            }
            else if(event.ctrlKey && event.shiftKey && event.keyCode==67){
                return false;  //Prevent from ctrl+shift+C
            }
            else if(event.ctrlKey && event.keyCode==80){
                return false;  //Prevent from ctrl+p
            }
        });

        //Disable right click script
        var message="Sorry, right-click has been disabled";
        function clickIE() {if (document.all) {(message);return false;}}
        function clickNS(e) {if
        (document.layers||(document.getElementById&&!document.all)) {
            if (e.which==2||e.which==3) {(message);return false;}}}
        if (document.layers)
        {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
        else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
        document.oncontextmenu=new Function("return false")
        function disableCtrlKeyCombination(e)
        {
            var forbiddenKeys = new Array('a', 'n', 'c', 'v', 'j' , 'w');
            var key;
            var isCtrl;
            if(window.event)
            {
                key = window.event.keyCode;     //IE
                if(window.event.ctrlKey)
                    isCtrl = true;
                else
                    isCtrl = false;
            }
            else
            {
                key = e.which;     //firefox
                if(e.ctrlKey)
                    isCtrl = true;
                else
                    isCtrl = false;
            }
            //if ctrl is pressed check if other key is in forbidenKeys array
            if(isCtrl)
            {
                for(i=0; i<forbiddenKeys.length; i++)
                {
                    //case-insensitive comparation
                    if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
                    {
                        alert('Key combination CTRL + '+String.fromCharCode(key) +' has been disabled.');
                        return false;
                    }
                }
            }
            return true;
        }
        //disable ctrl+u
        document.onkeydown = function(e) {
            if (e.ctrlKey &&
                (e.keyCode === 85 ||
                e.keyCode === 117)) {
                return false;
            } else {
                return true;
            }
        };*/
    });
</script>
<div id="quitModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#quitModal'}" style="display: none;"></button>