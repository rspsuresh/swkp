<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/kendo-ui/styles/kendo.common-material.min.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/kendo-ui/styles/kendo.material.min.css"/>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/kendoui_custom.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/pages/kendoui.min.js"></script>
<style>
    .disnon {
        /*display:none;*/
    }
    .overlay-details {
        /*        -ms-transform: translate(50px,100px);  IE 9
                -webkit-transform: translate(50px,100px);  Safari
                transform: translate(50px,100px);  Standard syntax
                position: fixed;*/
        bottom: 0;
        position: fixed;
        padding: 0px;
        width: 80%;
        /*margin-top: 46px;*/
    }
    .overlay-hide {
        /*        -ms-transform: translate(50px,100px);  IE 9
                -webkit-transform: translate(50px,100px);  Safari
                transform: translate(50px,100px);  Standard syntax
                position: static;*/
    }
    #indexdiv {
        transition-property: all;
        transition-duration: 1s;
    }
    .overlay_bottomdiv {
        -ms-transform: translate(50px, 100px); /* IE 9 */
        -webkit-transform: translate(50px, 100px); /* Safari */
        transform: translate(50px, 100px); /* Standard syntax */
        position: fixed;
    }
    .uk-width-medium-3-6, uk-width-medium-6-6 {
        transition-property: all;
        transition-duration: 1s;
    }
    .cusPageStyl {
        border: 1px solid #2196f3;
        border-radius: 20px;
        font-size: 25px;
        cursor: pointer;
        color: white;
        padding: 5px;
    }
    .uk-achor a {
        display: inline-block;
    }
    textarea.md-input {
        height: 50px !important;
        min-height: 50px !important;
    }
    .switch-lay .fullcode { width: 99.5% !important }
    .switch-lay .overlay-details > div { margin-left: 0 !important }
    .md-list-heading {
        font-weight: bold !important;
    }
    .k-widget .k-window {
        z-index: 100;
    }
    .uk-modal{
        z-index: 100000;
    }
   /* #the-canvas
    {
        min-height: 544px !important;
        max-width: 571px !important;
    }*/

   .magnify {position: relative;}
    .large {
        width: 544px; height: 571px;
        position: absolute;
        box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85),
        0 0 7px 7px rgba(0, 0, 0, 0.25),
        inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
        background-repeat:no-repeat;
        transform: scale(1.5,1.5);
        display: none;
    }
    .small { display: block; }
    .div-focus {
        border: 1px solid #1976d2;
        outline: none;
        overflow:scroll;
    }
    /*.small { display: block; }*/
</style>
<?php
/* echo Yii::app()->getBaseUrl(true); echo '<br>';  // => http://localhost/yii_projects
  echo Yii::app()->getHomeUrl();  echo '<br>';      // => /yii_projects/index.php
  echo Yii::app()->getBaseUrl(false);die;  // => /yii_projects */
$file_id = '';
$partation_id = '';
$oldpagetext = '';
$oldpage = '';
$url = '';
$id = '';
$projId = '';
$jobId = '';

if (isset($_GET['status']) && isset($_GET['id'])) {
    $type = $_GET['status'];
    $id = $_GET['id'];
    if ($_GET['status'] == "R") {
        $file_id = $_GET['id'];
        $info = FileInfo::model()->findByPk($file_id);
        if ($info) {
            $url = Yii::app()->baseUrl . '/' . $info->fi_file_ori_location;
            $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "IA", 'ja_flag' => 'A'));
            $jobId = isset($job_model) ? $job_model->ja_job_id : '';
            //$jobId=isset($info->JobAllocation->ja_job_id);
            $projId = isset($info->fi_pjt_id) ? $info->fi_pjt_id : "";
        }
        $query = FilePartition::model()->findByAttributes(array('fp_file_id' => $file_id, 'fp_category' => "M", 'fp_flag' => "A"));
        if ($query) {
            $oldpagetext = $query->fp_page_nums;
            $oldpage = json_encode(explode(',', $query->fp_page_nums));
        }
    } elseif ($_GET['status'] == "QC") {
        $partation_id = $_GET['id'];
        $partation = FilePartition::model()->findByPk($partation_id);

        if ($partation) {
            $oldpage = json_encode(explode(',', $partation->fp_page_nums));
            //$oldpagetext = $partation->fp_page_nums;
            $file_id = $partation->fp_file_id;
            //$jobId=isset($partation->JobAllocation_part->ja_job_id);
            $info = FileInfo::model()->findByPk($file_id);
            if ($info) {

                $url = Yii::app()->baseUrl . '/' . $info->fi_file_ori_location;
                //$jobId=isset($info->JobAllocation->ja_job_id);
                $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "IQP", 'ja_flag' => 'A'));
                $jobId = isset($job_model) ? $job_model->ja_job_id : '';
                $projId = isset($info->fi_pjt_id) ? $info->fi_pjt_id : "";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="md-card" data-uk-sticky="{ top: 48, media: 960 }" style="margin: 0px;">
            <div class="md-card-content">
                <div class="uk-grid">
                    <div class="uk-width-3-10 uk-achor">
                        <a id="prev" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)" title="Press left arrow key" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE314;</i></a>
                        <a id="next" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)" title="Press right arrow key" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE315;</i></a>
                        <!--<a class="md-fab md-fab-small md-fab-primary" href="<?php //echo $url; ?>" target="_blank" title="Pdf" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE89D;</i></a>-->
                        <!--<a class="md-fab md-fab-small md-fab-primary switch-display" href="javascript:void(0)" title="Switch" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8DE;</i></a>
                                        <a class="md-fab md-fab-small md-fab-primary view_short" href="javascript:void(0)" title="View Shortcuts" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">visibility</i></a>
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
                                                                                <td><span class="uk-badge uk-badge-primary status-badge">M</span></td>
                                                                                <td>Add To Medical</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td><span class="uk-badge uk-badge-primary status-badge">N</span></td>
                                                                                <td>Add To Non-Medical</td>
                                                                        </tr>
                                                                </tbody>
                                                        </table>
                            </div>-->
                        <a class="md-fab md-fab-small md-fab-primary zoom_in" href="javascript:void(0)" title="Zoom In" data-uk-tooltip="{pos:'bottom'}" onclick="zooming('in')"><i class="material-icons md-24 icon-white uk-text-bold">zoom_in</i></a>
                        <a class="md-fab md-fab-small md-fab-primary zoom_out" href="javascript:void(0)" title="Zoom Out" data-uk-tooltip="{pos:'bottom'}" onclick="zooming('out')"><i class="material-icons md-24 icon-white uk-text-bold">zoom_out</i></a>
                        <a class="md-fab md-fab-small md-fab-primary view_pages" href="javascript:void(0)" title="View Pages" data-uk-tooltip="{pos:'bottom'}" style="display:none;"><i class="material-icons md-24 icon-white uk-text-bold">add circle</i></a>
                        <?php if (!isset($oldpagetext) && !isset($nmedquery)) { ?>
                            <a class="md-fab md-fab-small md-fab-primary" onclick="rangeselect()" title="page range select" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8A0;</i></a>
                        <?php } else { ?>
                            <a class="md-fab md-fab-small md-fab-primary" onclick="updaterangeselect()"
                               title="page range select" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8A0;</i></a>
                           <?php } ?>
                    </div>
                    <div class="uk-width-4-10 uk-achor" style="text-align:center;">
                        <button class="md-btn md-btn-default md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" id="med" href="javascript:void(0)">Medical</button>
                        <button class="md-btn md-btn-default md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" id="nonmed" href="javascript:void(0)">Non-Medical</button>
                    </div>
                    <div class="uk-width-1-10 uk-achor">
                        <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                        <input type="number" id="pageNumber" class="toolbarField pageNumber md-input" value="1" size="4" min="1" tabindex="15" onfocus="inputFocus(false)" onblur="inputFocus(true)">
                    </div>
                    <div class="uk-width-small-2-10 uk-achor">
                        <div class="uk-float-left">
                            <a id="pagesearch" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8B6;</i></a>
                        </div>
                        <div class="uk-float-right" style="text-align: center">
                            Page: <span id="page_num"></span> / <span id="page_count"></span>
                            <?php /* <a class="md-fab md-fab-small md-fab-primary tooltip" href="<?php echo Yii::app()->createUrl('fileinfo/indexalloc') ?>"><i class="material-icons md-24 icon-white uk-text-bold">&#xE5C4;</i><span class="tooltiptext">Back</span></a> */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="md-card">
            <div class="md-card-content">
                <div class="curPageNewDiv" style="display:none">
                   Page: <span id="page_num1"></span> / <span id="page_count1"></span>
                </div>
                <canvas id="zoom"  width="576" height="744" margin-left="600px" style="position:absolute; border:5px solid #2f6daa; top:0px; left:0px; display:none; z-index:999"></canvas>
                <?php /* <div class="uk-grid">
                  <div class="uk-width-medium-1-5">
                  <a class="tooltip" href="#"><i id="prev" class="material-icons md-btn-primary cusPageStyl">&#xE314;</i><span class="tooltiptext">Previous</span></a>
                  <a href="javascript:void(0)" class="tooltip"><i id="next" class="material-icons md-btn-primary cusPageStyl">&#xE315;</i><span class="tooltiptext">Next</span></a>
                  <a href="<?php echo $url; ?>" target="_blank" class="tooltip"><i id="next" class="material-icons md-btn-primary cusPageStyl">&#xE89D;</i><span class="tooltiptext">View Pdf</span></a>
                  <a href="javascript:void(0)" class="tooltip"><i class="material-icons md-btn-primary switch-display cusPageStyl">&#xE8DE;</i><span class="tooltiptext">Switch Tab</span></a>

                  <!--                        <a id="prev" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                  <i class="uk-icon-chevron-circle-left" style="color: white"></i>
                  Previous
                  </a>-->
                  <!--                        <a id="next" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                  <i class="uk-icon-chevron-circle-right" style="color: white"></i>
                  Next
                  </a>-->
                  <!--                        <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="<?php echo $url; ?>" target="_blank">
                  <i class="uk-icon-file-pdf-o" style="color: white"></i>
                  PDF
                  </a>-->
                  <!--                        <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light switch-display" href="javascript:void(0)">
                  <i class="uk-icon-file-pdf-o" style="color: white"></i>
                  switch
                  </a>-->
                  <!--- <div class="uk-width-1-4">
                  <a id="zoomin" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                  <i class="uk-icon-search-plus" style="color: white"></i>
                  </a>
                  </div>
                  <div class="uk-width-1-4">
                  <a id="zoomout" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                  <i class="uk-icon-search-minus" style="color: white"></i>
                  </a>
                  </div> -->
                  </div>
                  <div class="uk-width-medium-1-3">
                  <div class="uk-width-medium-6-6" style="text-align:right;">
                  <button class="md-btn md-btn-default md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" id="med" href="javascript:void(0)">Medical</button>
                  <button class="md-btn md-btn-default md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" id="nonmed" href="javascript:void(0)">Non-Medical</button>
                  </div>
                  </div>
                  <div class="uk-width-medium-2-5">

                  <!--                        <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="<?php echo Yii::app()->createUrl('fileinfo/indexalloc') ?>">
                  <i class="uk-icon-chevron-circle-left" style="color: white"></i>
                  Back
                  </a>-->
                  <span style="float:right">
                  <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                  <input style="width:90px;" type="number" id="pageNumber" class="toolbarField pageNumber uk-width-medium-1-2" value="1" size="4" min="1" tabindex="15">
                  <a id="pagesearch" href="javascript:void(0)"><i class="material-icons cusPageStyl md-btn-primary">&#xE8B6;</i></a>
                  <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                  <a href="<?php echo Yii::app()->createUrl('fileinfo/indexalloc') ?>" style="float:right"><i class="material-icons md-btn-primary cusPageStyl">&#xE5C4;</i></a>
                  </span>
                  <!--                        <a id="pagesearch" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                  <i class="uk-icon-search" style="color: white"></i>
                  </a>-->


                  </div>

                  </div><!--Next Row--->
                 */ ?>
                <div class="uk-grid cardcard" style="margin-left:0;">

                    <div class="uk-width-medium-1-4"></div>
                    <div class="uk-width-medium-3-6 div-focus canvas_outer" id="indexdiv" tabindex="-1" style="text-align:center;width:auto;overflow:scroll;padding-left: 0">
                        <div class="magnify">
                            <canvas id="the-canvas" class="small"  style="border:1px solid black;min-width:562 !important;min-width:571 !important"></canvas>
                            <div class="large"></div>
                        </div>

                    </div>

                    <div class="uk-width-medium-6-6 overlay-details">

                        <div class="md-card" id="kUI_window1">
                            <div class="md-card-content" style="margin-right:25px;">
                                <!-- <h3 class="heading_a" style="text-align:center ">Prepping</h3> -->
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
                                <div class="uk-grid" data-uk-grid-margin="">
                                    <?php //echo $form->labelEx($model, 'fp_page_nums'); ?>
                                    <div class="uk-width-medium-6-6">
                                        <label style="font-weight:bold;">Medical pages: </label>
                                        <?php echo $form->textArea($model, 'fp_page_nums', array('class' => "md-input", 'value' => isset($oldpagetext) ? $oldpagetext : '', 'readonly' => true)); ?>
                                        <?php echo $form->error($model, 'fp_page_nums'); ?>
                                    </div>
                                    <div class="uk-width-medium-6-6">
                                        <label style="font-weight:bold;">Non-Medical pages: </label>
                                        <?php echo CHtml::textArea('non_medical_pages', (!empty($nmedquery) ? $nmedquery->fp_page_nums : ""), array('id' => 'nonmedpg', 'class' => "md-input", 'readonly' => true)); ?>
                                    </div>
                                    <?php echo $form->hiddenField($model, 'npages'); ?>
                                    <?php echo $form->hiddenField($model, 'fp_job_id', array('value' => $jobId)); ?>
                                    <?php echo $form->hiddenField($model, 'fp_file_id', array('value' => $file_id)); ?>
                                </div>
                                <div class="uk-grid" data-uk-grid-margin="" style="margin-top:10px">
                                    <div class="uk-width-medium-1-1 ">
                                        <?php echo CHtml::submitButton('Save', array('class' => 'md-btn md-btn-warning createbtn')); ?>
                                        <?php if ($_GET['status'] != 'QC') { ?>
                                            <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-success completebtn', 'onclick' => 'completeFile()')); ?>
                                        <?php } ?>
                                        <?php
                                        if(Yii::app()->session['user_type'] !="A") {
                                            echo CHtml::button('Quit', array('class' => 'md-btn md-btn-danger quitbtn', 'onclick' => 'quit()'));
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="md-card-content overlay-details">-->

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
                                <span class="md-list-heading">Add To Medical</span>
                                <span class="uk-text-small uk-text-muted">M</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="md-list-heading">Add To Non-Medical</span>
                                <span class="uk-text-small uk-text-muted">N</span>
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
                                <span class="md-list-heading">Complete</span>
                                <span class="uk-text-small uk-text-muted">Alt-C</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="md-list-heading">Quit</span>
                                <span class="uk-text-small uk-text-muted">Alt-Q</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="md-list-heading">Page Range Select</span>
                                <span class="uk-text-small uk-text-muted">Alt-R</span>
                            </div>
                        </li>
                        <li>
                            <div class="md-list-content">
                                <span class="md-list-heading">Modal Close</span>
                                <span class="uk-text-small uk-text-muted">Esc</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!--</div>-->


        <!--        <div class="overlay-details">
                    <div class="md-card">-->

        <!--            </div>
                </div>-->

        <!---PDF Script--->

        <script src="<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.js' ?>"></script>
        <script id="script">
                            //Kendo Window

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
                                    maxHeight: "240px",
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


                            var k_window1 = $('#kUI_window1'),
                                    k_undo1 = $('.view_pages')
                                    .bind("click", function () {
                                        k_window1.data("kendoWindow").open();
                                        k_undo1.hide();
                                    });
                            var onClose = function () {
                                k_undo1.show();
                            };
                            if (!k_window1.data("kendoWindow")) {
                                k_window1.kendoWindow({
                                    minWidth: "500px",
                                    width: "96%",
                                    position: {left: '2%', top: '80%'},
                                    title: "Prepping",
                                    actions: [
                                        "Minimize",
                                        "Maximize",
                                        "Close"
                                    ],
                                    close: onClose
                                });
                            }

                            var url = '<?php echo $url; ?>';
                            var totalPageNumbers = "";
                            PDFJS.disableWorker = true;
                            PDFJS.workerSrc = '<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.worker.js' ?>';
                            var pdfDoc = null,
                                    pageNum = 1,
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
                            var quitModal = UIkit.modal("#quitModal");
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
                                    canvas.width = viewport.width;
                                    canvas.height = viewport.height;
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
                                document.getElementById('page_num1').textContent = pageNum;
                                medpgs = document.getElementById('FilePartition_fp_page_nums').value;
                                nonmedpgs = document.getElementById('nonmedpg').value;
                                var split_medpgs = medpgs.split(",");
                                var split_nonmedpgs = nonmedpgs.split(",");
                                if (split_medpgs.indexOf(String(pageNum)) !== -1) {
                                    $('#nonmed').removeClass('md-btn-primary');
                                    $('#med').removeClass('md-btn-default');
                                    $('#med').addClass('md-btn-primary');
                                }
                                else if (split_nonmedpgs.indexOf(String(pageNum)) !== -1) {
                                    $('#med').removeClass('md-btn-primary');
                                    $('#nonmed').removeClass('md-btn-default');
                                    $('#nonmed').addClass('md-btn-primary');
                                }
                                else {
                                    $('#med,#nonmed').removeClass('md-btn-primary');
                                    $('#nonmed,#med').addClass('md-btn-default');
                                }
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
                                if (type == 'R') {
                                    if (pageNum <= 1) {
                                        return pageNum;
                                    }
                                    pageNum--;
                                    queueRenderPage(pageNum);
                                    return pageNum + 1;
                                } else {
                                    if (customPages != "") {
                                        var customPagesNew = JSON.parse(customPages);
                                        var customPagesLength = customPagesNew.length;
                                        if (pageNum <= customPagesNew[0]) {
                                            return pageNum;
                                        }
                                        if (page == "") {
                                            page = customPagesNew[0];
                                        }
                                        if (page > 0) {
                                            page--;
                                        }
                                        pageNum = Number(customPagesNew[page]);
                                        queueRenderPage(pageNum);
                                        return Number(customPagesNew[page + 1]);
                                    }
                                }

                            }
                            document.getElementById('prev').addEventListener('click', onPrevPage);
                            /**
                             * Displays next page.
                             */
                            function onNextPage() {
                                if (type == 'R') {
                                    if (pageNum >= pdfDoc.numPages) {
                                        return pageNum;
                                    }
                                    pageNum++;
                                    queueRenderPage(pageNum)
                                    return pageNum - 1;
                                } else {
                                    if (customPages != "") {
                                        var customPagesNew = JSON.parse(customPages);
                                        var customPagesLength = customPagesNew.length;
                                        if (pageNum >= customPagesNew[customPagesLength - 1]) {
                                            return pageNum;
                                        }
                                        if (page == 0) {
                                            pageNum = customPagesNew[0];
                                        }
                                        page++;
                                        pageNum = Number(customPagesNew[page]);
                                        if (page < customPagesLength) { // prevent next page display on last page
                                            queueRenderPage(pageNum);
                                        }
                                        return Number(customPagesNew[page - 1]);
                                    }
                                }
                            }
                            document.getElementById('next').addEventListener('click', onNextPage);
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
                             * Displays Search page.
                             */
                            function Search() {
                                var pageNo = parseInt($('#pageNumber').val());
                                if (isNaN(pageNo))
                                    return false;
                                if (type == 'R') {
                                    if (pageNo > pdfDoc.numPages || pageNo <= 0) {
                                        UIkit.notify({
                                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Invalid Page!",
                                            status: "warning",
                                            timeout: 500,
                                            pos: 'top-right'
                                        });
                                        return;
                                    }
                                    pageNum = pageNo;
                                    queueRenderPage(pageNo);
                                    return pageNum;
                                } else {
                                    var customPagesNew = JSON.parse(customPages);
                                    var newPage = pageNo.toString();
                                    if (jQuery.inArray(newPage, customPagesNew) == -1) {
                                        return;
                                    }
                                    pageNum = pageNo;
                                    queueRenderPage(pageNo);
                                    return pageNum;
                                }
                            }
                            document.getElementById('pagesearch').addEventListener('click', Search);
                            /**
                             * @ Zoom In PDF
                             */
                            /* function onZoomIn() {
                             
                             pdfScale = parseFloat(pdfScale) + 0.25;
                             
                             zoom(pageNum);
                             }
                             document.getElementById('zoomin').addEventListener('click', onZoomIn);*/
                            /**
                             * @ Zoom OUT PDF
                             */
                            /*function onZoomOut() {
                             if (pdfScale <= 1) {
                             return;
                             }
                             pdfScale = parseFloat(pdfScale) - 0.25;
                             zoom(pageNum);
                             }
                             document.getElementById('zoomout').addEventListener('click', onZoomOut);*/

                            /**
                             * Asynchronously downloads PDF.
                             */
                            PDFJS.getDocument(url).then(function (pdfDoc_) {
                                pdfDoc = pdfDoc_;
                                var numPages = pdfDoc.numPages;
                                totalPageNumbers = numPages;
                                document.getElementById('page_count').textContent = pdfDoc.numPages;
                                document.getElementById('page_count1').textContent = pdfDoc.numPages;
                                // Initial/first page rendering
                                if (type == 'R') {
                                    lastLoad();
                                    renderPage(pageNum);
                                } else {
                                    if (customPages != undefined) {
                                        var partitionPages = JSON.parse(customPages);
                                        pageNum = Number(partitionPages[0]);
                                        console.log(partitionPages[0]);
                                        renderPage(Number(partitionPages[0]));
                                    }
                                    else {
                                        renderPage(pageNum);
                                    }
                                }
                            });
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
                            /*document.onkeydown = checkKey;
                             
                             function checkKey(e) {
                             if(e.keyCode === 27)
                             {
                             if($("#indexdiv").is(":focus") === true)
                             {
                             $("#indexdiv").blur();
                             $(".overlay-details").focus();
                             }
                             else
                             {
                             $(".overlay-details").blur();
                             $("#indexdiv").focus();
                             }
                             }
                             }*/
                            document.onkeydown = checkKey;

                            function checkKey(e) {
                                if ($('#quitModal').is(':visible') === false) {
                                    if (e.keyCode == 77) {
                                        $("#med").addClass("md-btn-primary");//.delay(5000).removeClass("md-btn-primary");
                                    } else if (e.keyCode == 78) {
                                        $("#nonmed").addClass("md-btn-primary");//.delay(5000).removeClass("md-btn-primary");
                                    }
                                }
                            }
                            function oncancel() {
                                autoSave('D');
                            }
                            function onconfirm() {
<?php if (!empty($restore_json)) { ?>
                                    restore_json = <?php echo $restore_json; ?>;
                                    result = [];
                                    for (var i in restore_json) {
                                        result[i] = restore_json[i];
                                    }
                                    $('#FilePartition_fp_page_nums').val(result[0]);
                                    $('#FilePartition_fp_page_nums').focus();
                                    $('#nonmedpg').val(result[1]);
                                    $('#nonmedpg').focus();
                                    mdp = $('#FilePartition_fp_page_nums').val();
                                    nmp = $('#nonmedpg').val();
                                    var split_mdp = mdp.split(",");
                                    var split_nmp = nmp.split(",");
                                    if (split_mdp.indexOf(String(pageNum)) !== -1) {
                                        $('#nonmed').removeClass('md-btn-primary');
                                        $('#med').removeClass('md-btn-default');
                                        $('#med').addClass('md-btn-primary');
                                    }
                                    else if (split_nmp.indexOf(String(pageNum)) !== -1) {
                                        $('#med').removeClass('md-btn-primary');
                                        $('#nonmed').removeClass('md-btn-default');
                                        $('#nonmed').addClass('md-btn-primary');
                                    }
                                    autoSaveFunction('S');
<?php } ?>
                            }


                            function zooming(type) {
                                currentWidth = $('#the-canvas').width();
                                if (type === 'in') {
                                    $('#the-canvas').width(currentWidth + 20);
                                }
                                else {
                                    $('#the-canvas').width(currentWidth - 20);
                                }
                            }

                            $(document).on('ready', function () {
                                //Toogle Bar Full Width
                                ($body.hasClass('sidebar_main_active') || ($body.hasClass('sidebar_main_open') && $window.width() >= 1220)) ? altair_main_sidebar.hide_sidebar() : altair_main_sidebar.show_sidebar();
                                $("#sidebar_main_toggle").on("click", function () {
                                    $(".overlay-details").toggleClass("fullcode");
                                });
                                $(".switch-display").on("click", function () {
                                    $(".overlay-details").parent().toggleClass("switch-lay");
                                });
                                $('#quitModal').on({
                                    'show.uk.modal': function () {
                                        pdfFocus = false;
                                    },
                                    'hide.uk.modal': function () {
                                        $("#quitModal .uk-modal-header h3").html("");
                                        $("#quitModal .uk-modal-content").html("");
                                        pdfFocus = true;
                                    },
                                });
<?php if (!empty($restore_json)) { ?>
                                    UIkit.modal.confirm("Are you sure, you want to restore previous data?", onconfirm, oncancel, function () {
                                    });
<?php } ?>
                                //$('#indexdiv').attr('tabindex', -1).trigger('focus');
                                //if ($('#indexdiv').attr('tabindex', -1).is(":focus")) {
                                $(document).unbind('keyup').keyup(function (e) {

                                    if (!$('#raneselectModal').is(':visible')) {

                                        if (e.which === 81 && e.altKey) {
                                            $(".quitbtn").trigger("click");
                                        }
                                        if (e.which === 65 && e.altKey) {
                                            $(".createbtn").trigger("click");
                                        }
                                        if (e.which === 67 && e.altKey) {
                                            $(".completebtn").trigger("click");
                                        }
                                        if (pdfFocus) {
                                            if (e.which === 37) {
                                                if (checkfocus() == true) {
                                                    onPrevPage();
                                                }
                                            }
                                            else if (e.which === 39) {
                                                /* mdpags = $('#FilePartition_fp_page_nums').val();
                                                 nmpags = $('#nonmedpg').val();
                                                 var split_mdpags = mdpags.split(",");
                                                 var split_nmpags = nmpags.split(",");
                                                 if (split_nmpags.indexOf(String(pageNum)) === -1 && split_mdpags.indexOf(String(pageNum)) === -1) {
                                                 if (split_mdpags.indexOf(String(pageNum)) !== -1) {
                                                 var med_numbers = split_mdpags.map(function (v) {
                                                 return parseInt(v)
                                                 });
                                                 var filtered = med_numbers.filter(function (v) {
                                                 if (v !== pageNum) {
                                                 return v
                                                 }
                                                 });
                                                 var joined = filtered.join(",");
                                                 $('#FilePartition_fp_page_nums').val(joined);
                                                 $('#FilePartition_fp_page_nums').focus();
                                                 }
                                                 if (nmpags !== "") {
                                                 $('#nonmedpg').val(nmpags + ',' + pageNum);
                                                 $('#nonmedpg').focus();
                                                 }
                                                 else {
                                                 $('#nonmedpg').val(pageNum);
                                                 $('#nonmedpg').focus();
                                                 }
                                                 }
                                                 autoSave('S'); */
                                                if (parseInt(pageNum) === parseInt(pdfDoc.numPages)) {
                                                    renderPage(pageNum);
                                                    if ($('.uk-notify').is(':visible') === false) {
                                                        UIkit.notify({
                                                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached last page!",
                                                            status: "error",
                                                            timeout: 1500,
                                                            pos: 'top-right'
                                                        });
                                                    }
                                                }
                                                else {
                                                    if (checkfocus() == true) {
                                                        onNextPage();
                                                    }
                                                }
                                            }
                                            else if (e.which === 77 || e.which === 78) {
                                                if (e.which === 78) {
                                                    mdpags = $('#FilePartition_fp_page_nums').val();
                                                    var split_mdpags = mdpags.split(",");
                                                    if (split_mdpags.indexOf(String(pageNum)) !== -1) {
                                                        var med_numbers = split_mdpags.map(function (v) {
                                                            return parseInt(v)
                                                        });
                                                        var filtered = med_numbers.filter(function (v) {
                                                            if (v !== pageNum) {
                                                                return v
                                                            }
                                                        });
                                                        var joined = filtered.join(",");
                                                        $('#FilePartition_fp_page_nums').val(joined);
                                                        $('#FilePartition_fp_page_nums').focus();
                                                    }
                                                    nmpags = $('#nonmedpg').val();
                                                    if (nmpags !== "") {
                                                        var split_nmpags = nmpags.split(",");
                                                        if (split_nmpags.indexOf(String(pageNum)) === -1) {
                                                            nmdvalue = nmpags + ',' + pageNum;
                                                            var nmdres = nmdvalue.split(",");
                                                            nmdres.sort(arrange);
                                                            retval = nmdres.join();
                                                            $('#nonmedpg').val(retval);
                                                            $('#nonmedpg').focus();
                                                        }
                                                    }
                                                    else {
                                                        $('#nonmedpg').val(pageNum);
                                                        $('#nonmedpg').focus();
                                                    }
                                                    autoSave('S');
                                                    if (parseInt(pageNum) === parseInt(pdfDoc.numPages)) {
                                                        renderPage(pageNum);
                                                        if ($('.uk-notify').is(':visible') === false) {
                                                            UIkit.notify({
                                                                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached last page!",
                                                                status: "error",
                                                                timeout: 1500,
                                                                pos: 'top-right'
                                                            });
                                                        }
                                                    }
                                                    else {
                                                        onNextPage();
                                                    }
                                                }
                                                else if (e.which === 77) {
                                                    nmpags = $('#nonmedpg').val();
                                                    var split_nmpags = nmpags.split(",");
                                                    if (split_nmpags.indexOf(String(pageNum)) !== -1) {
                                                        var nm_numbers = split_nmpags.map(function (v) {
                                                            return parseInt(v)
                                                        });
                                                        var filtered = nm_numbers.filter(function (v) {
                                                            if (v !== pageNum) {
                                                                return v
                                                            }
                                                        });
                                                        var joined = filtered.join(",");
                                                        $('#nonmedpg').val(joined);
                                                        $('#nonmedpg').focus();
                                                    }
                                                    mdpags = $('#FilePartition_fp_page_nums').val();
                                                    if (mdpags !== "") {
                                                        var split_mdpags = mdpags.split(",");
                                                        if (split_mdpags.indexOf(String(pageNum)) === -1) {
                                                            mdvalue = mdpags + ',' + pageNum;
                                                            var mdres = mdvalue.split(",");
                                                            mdres.sort(arrange);
                                                            retval = mdres.join();
                                                            $('#FilePartition_fp_page_nums').val(retval);
                                                            $('#FilePartition_fp_page_nums').focus();
                                                            //$('#FilePartition_fp_page_nums').val(mdpags+','+pageNum);
                                                        }
                                                    }
                                                    else {
                                                        $('#FilePartition_fp_page_nums').val(pageNum);
                                                        $('#FilePartition_fp_page_nums').focus();
                                                    }
                                                    autoSave('S');
                                                    if (parseInt(pageNum) === parseInt(pdfDoc.numPages)) {
                                                        renderPage(pageNum);
                                                        if ($('.uk-notify').is(':visible') === false) {
                                                            UIkit.notify({
                                                                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached last page!",
                                                                status: "error",
                                                                timeout: 1500,
                                                                pos: 'top-right'
                                                            });
                                                        }
                                                    }
                                                    else {
                                                        onNextPage();
                                                    }
                                                }
                                            }
                                            else if (e.which === 38 && e.ctrlKey) {
                                                zooming('in');
                                            }
                                            else if (e.which === 40 && e.ctrlKey) {
                                                zooming('out');
                                            }
                                        }
                                    }
                                    // search box open short cut key
                                    if (e.which === 82 && e.altKey) {   // alt+R
                                        $("#raneModal").trigger("click");
                                        $("#from").focus();
                                    }
                                    if (e.which === 88 && e.altKey) {
                                        $("#pageNumber").focus();
                                    }
                                    if(e.which == 13 && $("#pageNumber").is(":focus")===true ) {
                                        $('#pagesearch')[0].click();
                                    }
                                });///
                                //}

                                //PDF Magnifier


                                var native_width = 0;
                                var native_height = 0;

                                $(".magnify").mouseenter(function(e){
                                        var main = document.getElementById("the-canvas");
                                    var ctx = main.getContext("2d");
                                    var img = new Image();
                                    var url = main.toDataURL("image/png");
                                    $(".large").css("background-image","url("+url+")");
                                });
                                $(".magnify").mousemove(function(e){
                                    if(!native_width && !native_height)
                                    {
                                        var image_object = new Image();
                                        image_object.src = url;
                                            native_width = $("#the-canvas").width();
                                            native_height = $("#the-canvas").height();



                                    }
                                    else
                                    {
                                        var magnify_offset = $(this).offset();
                                        var mx = e.pageX - magnify_offset.left;
                                        var my = e.pageY - magnify_offset.top;
                                        if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
                                        {
                                            $(".large").fadeIn(100);
                                        }
                                        else
                                        {
                                            $(".large").fadeOut(100);
                                        }

                                            if($("#indexdiv .large").is(":visible"))
                                            {

                                                var rx = Math.round(mx/$("#indexdiv .small").width()*native_width - $("#indexdiv .large").width()/2)*-1;
                                                var ry = Math.round(my/$("#indexdiv .small").height()*native_height - $("#indexdiv .large").height()/2)*-1;
                                                var bgp = rx + "px " + ry + "px";
                                                var px = mx - $("#indexdiv .large").width()/2;
                                                var py = my - $("#indexdiv .large").height()/2;
                                                $("#indexdiv .large").css({left: px, top: py, backgroundPosition: bgp});
                                            }
                                        }


                                });
                                $(".magnify").mouseleave(function(e){
                                    $(".large").fadeOut(100);
                                });
                               /* var main = document.getElementById("the-canvas");
                                var zoom = document.getElementById("zoom");
                                var ctx = main.getContext("2d")
                                var zoomCtx = zoom.getContext("2d");
                                var img = new Image();
                                var url = main.toDataURL();
                                img.src = url;
                                img.onload = run;

                                function run() {
                                    ctx.drawImage(img, 0, 0);
                                }

                                main.addEventListener("mousemove", function (e) {
                                    zoomCtx.fillStyle = "white";
                                    //zoomCtx.clearRect(0,0, zoom.width, zoom.height);
                                    //zoomCtx.fillStyle = "transparent";
                                    zoomCtx.fillRect(0, 0, zoom.width, zoom.height);
                                    zoomCtx.drawImage(main, e.x - 350, e.y + 140, 300, -300, 0, 0, 500, 500);
                                    //console.log(zoom.style);
                                    //zoom.style.top = e.pageY + -220 + "px";
                                    //zoom.style.left = e.pageX + 200 + "px";
                                    zoom.style.top = "0px";
                                    zoom.style.left = "100px";
                                    zoom.style.display = "block";
                                });

                                main.addEventListener("mouseout", function () {
                                    zoom.style.display = "none";
                                });

                                window.onresize = function (event) {
//                                    $('span.curPageNew').html(pageNum + '/' + totalPageNumbers);
                                    var maxHeight = window.screen.height,
                                            maxWidth = window.screen.width,
                                            curHeight = window.innerHeight,
                                            curWidth = window.innerWidth;
                                            
                                        document.getElementById('the-canvas').style.height = (curHeight-150)+'px';
//                                        window.innerHeight = document.getElementById('the-canvas').style.height;
                                    if (maxWidth == curWidth && maxHeight == curHeight) {
//                                        $('.dateCodeLegPar').hide();
//                                        $('.uk-sticky-placeholder').hide();
//                                        $('#indexdiv').css({'min-height': '825px'});
                                        $('.curPageNewDiv').show();
                                        $('#header_main').hide();
                                        $('.uk-sticky-placeholder').hide();
                                        $('body').css({'padding-top': '0px'});
                                    }
                                    else {
//                                        $('.dateCodeLegPar').show();
//                                        $('.uk-sticky-placeholder').show();
//                                        $('#indexdiv').css({'min-height': '600px'});
                                        $('.curPageNewDiv').hide();
                                        $('#header_main').show();
                                        $('.uk-sticky-placeholder').show();
                                        $('body').css({'padding-top': '48px'});
                                    }
                                }*/



                                //PDF Magnifier End
                                return true;
                            });

                            function arrange(a, b) {
                                return a - b;
                            }

                            var myFuncCalls = 0;
                            var timer = null;

                            function autoSave(mode) {
                                if (mode !== 'D') {
                                    if (myFuncCalls == 0) {
                                        myFuncCalls++;
                                        timer = setTimeout(function () {
                                            myFuncCalls = 0;
                                            autoSaveFunction(mode);
                                        }, 10000);
                                    }
                                }
                                else {
                                    autoSaveFunction(mode);
                                }
                            }

                            function autoSaveFunction(mode) {
                                fpmedpages = $('#FilePartition_fp_page_nums').val();
                                fpnonmed = $('#nonmedpg').val();
                                prepfileid = <?php echo $id; ?>;
                                $.ajax({
                                    url: '<?php echo Yii::app()->createUrl('fileinfo/autosaveindex') ?>',
                                    type: "post",
                                    data: {fpmedpages: fpmedpages, fpnonmed: fpnonmed, prepfileid: prepfileid, mode: mode},
                                    global: false,
                                    success: function (result) {
                                    }
                                });
                            }

                            //User Active form
                            function saveUserForm(form, data, hasError) {
                                if (!hasError) {
                                    /* get Non Medical*/
                                    var glbPages = range(1, totalPageNumbers, 1);
                                    var nonmedicalPages = arr_diff(glbPages, $('#FilePartition_fp_page_nums').val().split(','));
                                    nonmedicalPages = nonmedicalPages.join(',');
                                    $('#FilePartition_npages').val(nonmedicalPages);
                                    var formdata = new FormData($('#file-partition-form')[0]);
                                    $.ajax({
                                        url: '<?php echo Yii::app()->createUrl('fileinfo/fileindexing', array('id' => $id, 'status' => $type)) ?>',
                                        type: "post",
                                        data: formdata,
                                        contentType: false,
                                        cache: false,
                                        processData: false,
                                        success: function (result) {
                                            var obj = JSON.parse(result);
                                            if (obj.status == "S" || obj.status == "U") {
                                                $('.uk-close')[0].click();
                                                if ($('.uk-notify').is(':visible') === false) {
                                                    UIkit.notify({
                                                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                                                        status: "success",
                                                        timeout: 2000,
                                                        pos: 'top-right'
                                                    });
                                                }
                                                //clearform();
                                            }
                                            else if (obj.status == "M") {
                                                $('.uk-close')[0].click();
                                                if ($('.uk-notify').is(':visible') === false) {
                                                    UIkit.notify({
                                                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                                                        status: "success",
                                                        timeout: 2000,
                                                        pos: 'top-right'
                                                    });
                                                }
                                                customPages = obj.pages;
                                                console.log(customPages);
                                                customPagesNew = JSON.parse(customPages);
                                                pageNum = parseInt(customPagesNew[0]);
                                                lastLoad();
                                                onPrevPage();
                                                clearform();
                                            }
                                            else if (obj.status == "E") {
                                                $('.uk-close')[0].click();
                                                if ($('.uk-notify').is(':visible') === false) {
                                                    UIkit.notify({
                                                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                                                        status: "error",
                                                        timeout: 2000,
                                                        pos: 'top-right'
                                                    });
                                                }
                                            }
                                            clearTimeout(timer);
                                            myFuncCalls = 0;
                                            autoSave('D');
                                        }
                                    });
                                } else {
                                    $(".errorMessage:first").prev().focus();
                                }
                            }
                            /**
                             * clear form
                             */
                            function clearform() {
                                $("#file-partition-form").trigger('reset');
                            }
                            /**
                             * @Complete
                             */
                            function completeFile() {
                                if ($('#FilePartition_fp_page_nums').val() !== "") {
                                    if ($('.uk-modal').is(':visible') === false) {
                                        UIkit.modal.confirm("Are you sure, you want to complete the file?", function () {
                                            var glbPages = range(1, totalPageNumbers, 1);
                                            var nonmedicalPages = arr_diff(glbPages, $('#FilePartition_fp_page_nums').val().split(','));
                                            nonmedicalPages = nonmedicalPages.join(',');
                                            $('#FilePartition_npages').val(nonmedicalPages);
                                            var formdata = new FormData($('#file-partition-form')[0]);
                                            $.ajax({
                                                url: '<?php echo Yii::app()->createUrl('fileinfo/completefile', array('id' => $id, 'status' => 'IC', 'mode' => 'I', 'projectId' => $projId, 'jobId' => $jobId, 'status' => false)); ?>',
                                                type: "post",
                                                data: formdata,
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                success: function (result) {
                                                    clearTimeout(timer);
                                                    myFuncCalls = 0;
                                                    autoSave('D');
                                                    var obj = JSON.parse(result);
                                                    if (obj.status == "S" || obj.status == "U") {
                                                        <?php if(Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL" ) { ?>
                                                        window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/allgrid'); ?>';
                                                        <?php }
                                                        else { ?>
                                                        window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/indexalloc'); ?>?showMsg=' + obj.msg;
                                                        <?php } ?>
                                                    }
                                                }
                                            });
                                        });
                                    }
                                }
                                else {
                                    if ($('.uk-notify').is(':visible') === false) {
                                        UIkit.notify({
                                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Medical field cannot be empty",
                                            status: "error",
                                            timeout: 500,
                                            pos: 'top-right'
                                        });
                                    }
                                }
                            }
                            /**
                             * @Quit file
                             */
                            function quitFile() {
                                UIkit.modal.confirm("Are you sure, you want to Quit the file?", function () {
                                    $.ajax({
                                        url: '<?php echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => 'IQ', 'jobId' => $jobId)); ?>',
                                        type: "post",
                                        success: function (result) {
                                            var obj = JSON.parse(result);
                                            if (obj.status == "S" || obj.status == "U") {
                                                $('.uk-close')[0].click();
                                                window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/indexalloc'); ?>?showMsg=' + obj.msg;
                                            }
                                        }
                                    });
                                });

                            }
                            //Modal Popup

                            function quit() {
                                $("#quitModal .uk-modal-header h3").html("Quit Description");
                                $.ajax({
                                    url: '<?php echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => 'IQ', 'jobId' => $jobId)) ?>',
                                    type: "post",
                                    success: function (result) {
                                        $("#quitModal .uk-modal-content").html(result);
                                        $("#triggerModal").trigger("click");
                                        $('#JobAllocation_description').focus();
                                    }
                                });
                            }
                            $('#sidebar_main_toggle').on('click', function () {
                                var temp = $('#sidebar_main').width();
                                console.log($('#page_content_inner').width());
                                console.log(temp);

                                //        $('.overlay-details').css('width',$('#page_content_inner').width() - $('#sidebar_main').width());
                                //                $('.overlay-details').css("width", "calc(" + $('#page_content_inner').width() + "-" + temp + "px)");

                            });
                            $('.switch-display').click(function () {
                                if ($('#indexdiv').hasClass('uk-width-medium-3-6')) {
                                    $('#indexdiv').addClass('uk-width-medium-6-6').removeClass('uk-width-medium-3-6');
                                }
                                else {
                                    $('#indexdiv').addClass('uk-width-medium-3-6').removeClass('uk-width-medium-6-6');
                                }
                                if ($('.overlay-details').hasClass('uk-width-medium-3-6')) {
                                    $('.overlay-details').css({
                                        position: 'fixed',
                                        width: '80%'
                                    }).delay(3000).addClass('uk-width-medium-6-6').removeClass('uk-width-medium-3-6');
                                    $('#the-canvas').css('width', '50%');
                                    $('.canvas_outer').css('max-height', '700px');
                                    $('.canvas_outer').css('min-height', '700px');
                                }
                                else {
                                    $('#the-canvas').css('width', '100%');
                                    $('.overlay-details').css({
                                        position: 'static',
                                        width: '50%'
                                    }).delay(3000).addClass('uk-width-medium-3-6').removeClass('uk-width-medium-6-6');
                                    $('.canvas_outer').css('max-height', '600px');
                                    $('.canvas_outer').css('min-height', '600px');
                                }

                                //                if ($('.overlay-details').hasClass('uk-width-medium-3-6')) {
                                //                    $('.overlay-details').addClass('uk-width-medium-6-6').removeClass('uk-width-medium-3-6');
                                //                }
                                //                else {
                                //                    $('.overlay-details').addClass('uk-width-medium-3-6').removeClass('uk-width-medium-6-6').css({width:'50%'});
                                //                }


                                //                $('#indexdiv').toggleClass('uk-width-medium-3-6').toggleClass('uk-width-medium-6-6');
                                //                $('.overlay-details').toggleClass('uk-width-medium-3-6').toggleClass('uk-width-medium-6-6');
                                //                $('.overlay-details').toggleClass('overlay-details').addClass('overlay-hide');
                                //                $('.overlay-hide').toggleClass('overlay-hide').addClass('overlay-details');
                            });
                            /**
                             * Focus
                             * @param $val
                             */
                            function inputFocus($val) {
                                pdfFocus = $val;
                            }

                            $(document).ready(function () {
                                $("#miniz").on("click", function () {
                                    $(this).parent().slideUp();
                                    $("#maxz").show();
                                });
                                $("#maxz").on("click", function () {
                                    $(this).next().slideDown();
                                    $(this).hide();
                                });


                            });
                            /* function rangeselect() {
                             $("#raneModal").trigger("click");
                             }
                             var $pagno=$("#pageNumber"),
                             $from=$("#from"),
                             $to=$("#to"),
                             text='',
                             dtext='',
                             srfy='', newstfy='',
                             flag=0
                             A=[],
                             B = [],
                             C=[];
                             
                             function closedicon()
                             {
                             var selValue = $('input[name=rbnNumber]:checked').val();
                             
                             var fromv=parseInt($("#from").val()),
                             tov=parseInt($("#to").val());
                             if (fromv > tov)
                             {
                             $("#from_error").show();
                             $("#raneModal").trigger("click");
                             var eflag=1;
                             }
                             else if(parseInt($("#page_count").text()) < parseInt($("#to").val()))
                             {
                             
                             $("#to_error").show();
                             $("#raneModal").trigger("click");
                             var wef=2;
                             }
                             else if(eflag !=1 && wef !=2){
                             $("#rangeclose").trigger("click");
                             for (i = 1; i <= parseInt($("#page_count").text()); i++) {
                             A.push(i);
                             }
                             
                             for (j = parseInt($("#from").val()); j <= parseInt($("#to").val()); j++) {
                             text += j + ",";
                             B.push(j);
                             newstfy=B.toString();
                             
                             }
                             $.each(A, function(i,e) {
                             if ($.inArray(e, B) == -1) C.push(e);
                             });
                             srfy=C.toString();
                             }
                             $("#FilePartition_fp_page_nums").val(newstfy);
                             $("#nonmedpg").val(srfy)
                             text='';
                             newstfy='';
                             stfy='';
                             $from.val('');
                             $to.val('');
                             
                             }*/
                            var $pagno = $("#pageNumber"), $from = $("#from"),
                                    $to = $("#to"), text = '', dtext = '', srfy = '',
                                    newstfy = '', flag = 0, A = [], B = [], tempB = [], tempA = [],
                                    tempC = [], C = [];
                            function updaterangeselect() {
                                $("#raneModal").trigger("click");

                            }
                            function rangeselect() {
                                $("#raneModal").trigger("click");
                            }
                            function updateclosedicon()
                            {
                                var fromv = isNaN(parseInt($("#from").val())) ? 0 : parseInt($("#from").val()),
                                        tov = isNaN(parseInt($("#to").val())) ? 0 : parseInt($("#to").val());

                                if (fromv == 0)
                                {
                                    $("#from_error").text("From Cannot  be blank").show();
                                }
                                else if (tov == 0)
                                {
                                    $("#to_error").text("To Cannot  be blank").show();
                                }
                                else if (fromv > tov)
                                {
                                    $("#from_error").text("From page no should not be greater than To  ").show();
                                }
                                else if (parseInt($("#page_count").text()) < tov)
                                {

                                    $("#to_error").text("To page no should not be greater than Total Page  ").show();
                                }
                                else
                                {
                                    updateclosediconcheck();
                                }
                            }
                            function closedicon()
                            {
                                var fromv = isNaN(parseInt($("#from").val())) ? 0 : parseInt($("#from").val()),
                                        tov = isNaN(parseInt($("#to").val())) ? 0 : parseInt($("#to").val());
                                if (fromv != 0 && tov != 0)
                                {
                                    closediconcheck();
                                }
                                else if (fromv == 0)
                                {
                                    $("#from_error").text("From Cannot  be blank").show();
                                }
                                else if (tov == 0)
                                {
                                    $("#to_error").text("To Cannot  be blank").show();
                                }
                                else if (fromv > tov)
                                {
                                    $("#from_error").text("From page no should not be greater than To  ").show();
                                }
                                else if (parseInt($("#page_count").text()) < parseInt($("#to").val()))
                                {

                                    $("#to_error").text("To page no should not be greater than Total Page  ").show();
                                }
                            }
                            $(function () {
                                setTimeout(function () {
                                    for (i = 1; i <= parseInt($("#page_count").text()); i++) {
                                        A.push(i);
                                    }
                                    var upmedical = $("#FilePartition_fp_page_nums").val();
                                    var upnonmedical = $("#nonmedpg").val();
                                    if (upmedical != '' && upnonmedical != "") {
                                        $("#update").show();
                                    }
                                    else {
                                        $("#normal").show();
                                    }
                                }, 3000);
                            });
                            function subtractarrays(array1, array2) {
                                var difference = [];
                                for (var i = 0; i < array1.length; i++) {
                                    if ($.inArray(array1[i], array2) == -1) {
                                        difference.push(array1[i]);
                                    }
                                }
                                return difference;
                            }

                            function closediconcheck() {
                                var selValue = $('input[name=rbnNumber]:checked').val();
                                var upmedical = $("#FilePartition_fp_page_nums").val();
                                var upnonmedical = $("#nonmedpg").val();
                                var fromv = parseInt($("#from").val()),
                                        tov = parseInt($("#to").val());
                                /*  if (fromv > tov) {
                                 $("#from_error").show();
                                 $("#raneModal").trigger("click");
                                 var eflag = 1;
                                 } else if (parseInt($("#page_count").text()) < parseInt($("#to").val())) {
                                 
                                 $("#to_error").show();
                                 $("#raneModal").trigger("click");
                                 var wef = 2;
                                 } else {*/
                                $("#rangeclose").trigger("click");
                                for (i = 1; i <= parseInt($("#page_count").text()); i++) {
                                    A.push(i);
                                }
                                if (selValue == 1) {
                                    var temp = [];

                                    if (upmedical != "") {
                                        var arr = upmedical.split(',');
                                        for (i = 0; i < arr.length; i++) {
                                            B.push(parseInt(arr[i]));
                                        }
                                    }
                                    if (upnonmedical != "") {
                                        var arrnon = upnonmedical.split(',');
                                        for (i = 0; i < arrnon.length; i++) {
                                            C.push(parseInt(arrnon[i]));
                                        }
                                    }

                                    for (j = fromv; j <= tov; j++) {
                                        B.push(j);
                                        B = unique(B);
                                        temp = B;
                                    }
                                    C = subtractarrays(C, temp);
                                    C = uniqueupdate(C);
                                    C = C.sort(function (a, b) {
                                        return a - b;
                                    });
                                    srfy = C.toString();
                                    $("#nonmedpg").val(srfy);
                                    B = subtractarrays(temp, C);
                                    B = B.sort(function (a, b) {
                                        return a - b;
                                    });
                                    srfy = B.toString();
                                    newstfy = B.toString();
                                    $('#FilePartition_fp_page_nums').focus();

                                } else {
                                    if (upmedical != "") {
                                        var arr = upmedical.split(',');
                                        for (i = 0; i < arr.length; i++) {
                                            B.push(parseInt(arr[i]));
                                        }
                                    }
                                    if (upnonmedical != "") {
                                        var arrnon = upnonmedical.split(',');
                                        for (i = 0; i < arrnon.length; i++) {
                                            C.push(parseInt(arrnon[i]));
                                        }
                                    }
                                    for (j = fromv; j <= tov; j++) {
                                        B.push(j);
                                        B = uniqueupdate(B);
                                        temp = B;
                                    }

                                    for (j = fromv; j <= tov; j++) {
                                        C.push(j);
                                        C = uniquenon(C);
                                    }
                                    B = subtractarrays(B, C);
                                    B = uniquenon(B);
                                    B = B.sort(function (a, b) {
                                        return a - b;
                                    });
                                    C = C.sort(function (a, b) {
                                        return a - b;
                                    });



                                    console.log(B);
                                    console.log(C);
//                                    for (j = fromv; j <= tov; j++) {
//                                        C.push(j);
//                                        C = uniquenon(C);
//                                    }
//                                    B = subtractarrays(B, C);
//                                    B = B.sort(function (a, b) {
//                                        return a - b;
//                                    });
                                    newstfy = B.toString();
                                    srfy = C.toString();
                                    $("#nonmedpg").val(srfy);
                                    $('#nonmedpg').focus();
                                }
                                /*}*/
                                $("#FilePartition_fp_page_nums").val(newstfy);
                                text = '';
                                newstfy = '';
                                stfy = '';
                                $from.val('');
                                $to.val('');

                            }
                            function updateclosediconcheck() {
                                var selValue = $('input[name=rbnNumber]:checked').val();
                                var upmedical = $("#FilePartition_fp_page_nums").val();
                                var upnonmedical = $("#nonmedpg").val();
                                var fromv = parseInt($("#from").val()),
                                        tov = parseInt($("#to").val());
                                /* if (fromv > tov) {
                                 $("#from_error").show();
                                 $("#raneModal").trigger("click");
                                 var eflag = 1;
                                 } else if (parseInt($("#page_count").text()) < parseInt($("#to").val())) {
                                 
                                 $("#to_error").show();
                                 $("#raneModal").trigger("click");
                                 var wef = 2;
                                 } else if(eflag !=1 && wef !=2 ) {*/
                                $("#rangeclose").trigger("click");
                                for (i = 1; i <= parseInt($("#page_count").text()); i++) {
                                    A.push(i);
                                }
                                if (selValue == 1) {
                                    var temp = [];

                                    var arr = upmedical.split(',');
                                    for (i = 0; i < arr.length; i++) {
                                        B.push(parseInt(arr[i]));
                                    }
                                    var arrnon = upnonmedical.split(',');
                                    for (i = 0; i < arrnon.length; i++) {
                                        C.push(parseInt(arrnon[i]));
                                    }
                                    for (j = fromv; j <= tov; j++) {
                                        B.push(j);
                                        B = uniqueupdate(B);
                                        temp = B;
                                    }
                                    C = subtractarrays(C, B);
                                    C = uniqueupdate(C);
                                    C = C.sort(function (a, b) {
                                        return a - b;
                                    });
                                    srfy = C.toString();
                                    $("#nonmedpg").val(srfy);
                                    B = subtractarrays(temp, C);
                                    B = B.sort(function (a, b) {
                                        return a - b;
                                    });
                                    srfy = B.toString();
                                    newstfy = B.toString();
                                    $('#FilePartition_fp_page_nums').focus();

                                } else {
                                    var arr = upmedical.split(',');
                                    for (i = 0; i < arr.length; i++) {
                                        B.push(parseInt(arr[i]));
                                    }
                                    var arrnon = upnonmedical.split(',');
                                    for (i = 0; i < arrnon.length; i++) {
                                        C.push(parseInt(arrnon[i]));
                                    }
                                    for (j = fromv; j <= tov; j++) {
                                        C.push(j);
                                        C = uniquenon(C);
                                    }
                                    B = subtractarrays(B, C);
                                    B = uniquenon(B);
                                    B = B.sort(function (a, b) {
                                        return a - b;
                                    });
                                    C = C.sort(function (a, b) {
                                        return a - b;
                                    });
                                    newstfy = B.toString();
                                    srfy = C.toString();
                                    $("#nonmedpg").val(srfy);
                                    $('#nonmedpg').focus();
                                }
                                /*  }*/
                                $("#FilePartition_fp_page_nums").val(newstfy);
                                text = '';
                                newstfy = '';
                                stfy = '';
                                $from.val('');
                                $to.val('');

                            }
                            var unique = function (origArr) {
                                var newArr = [],
                                        origLen = origArr.length,
                                        found,
                                        x, y;

                                for (x = 0; x < origLen; x++) {
                                    found = undefined;
                                    for (y = 0; y < newArr.length; y++) {
                                        if (origArr[x] === newArr[y]) {
                                            found = true;
                                            break;
                                        }
                                    }
                                    if (!found)
                                        newArr.push(origArr[x]);
                                }
                                return newArr;
                            }
                            var uniquenon = function (origArr) {
                                var newArrnon = [],
                                        origLen = origArr.length,
                                        found,
                                        x, y;

                                for (x = 0; x < origLen; x++) {
                                    found = undefined;
                                    for (y = 0; y < newArrnon.length; y++) {
                                        if (origArr[x] === newArrnon[y]) {
                                            found = true;
                                            break;
                                        }
                                    }
                                    if (!found)
                                        newArrnon.push(origArr[x]);
                                }
                                return newArrnon;
                            }
                            var uniqueupdate = function (origArrupdate) {

                                var newArrupdate = [],
                                        origLen = origArrupdate.length,
                                        found,
                                        x, y;

                                for (x = 0; x < origLen; x++) {
                                    found = undefined;
                                    for (y = 0; y < newArrupdate.length; y++) {
                                        if (origArrupdate[x] === newArrupdate[y]) {
                                            found = true;
                                            break;
                                        }
                                    }
                                    if (!found)
                                        newArrupdate.push(origArrupdate[x]);
                                }

                                return newArrupdate;
                            }
                            function isNumber(evt) {
                                evt = (evt) ? evt : window.event;
                                var charCode = (evt.which) ? evt.which : evt.keyCode;
                                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                                    return false;
                                }
                                return true;
                            }
                            function checkfocus()
                            {
                                if ($("#kUI_window1").is(":focus") === false && $("#file-partition-form").is(":focus") == false && $("#nonmedpg").is(":focus") == false && $("#FilePartition_fp_page_nums").is(":focus") == false) {
                                    return true
                                }
                                else
                                {
                                    return false;
                                }
                            }
                                $(function(){

                                    var canvas = $("#canvas");
                                    canvas.height = '100%';

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
                                        var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j' , 'w');
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
                                            (e.keyCode === 67 ||
                                            e.keyCode === 86 ||
                                            e.keyCode === 85 ||
                                            e.keyCode === 117)) {
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    };*/

                                });

        </script>
        <div id="raneselectModal" class="uk-modal">
            <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
                <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
                    <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Page Range select</h3>
                    <button type="button" class="uk-modal-close uk-close" id="rangeclose" style="display: inline-block;float: right;color: #fff;background: #fff;" onChange="modelClose()"></button>
                </div>
                <div class="uk-width-medium-3-5">
                    <input type="radio" id="medical" name="rbnNumber" value="1" checked>Medical
                    <input type="radio" id="nonmediacal" name="rbnNumber" value="2"> Non Medical
                </div>
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-3 uk-row-first">
                            <div class="md-input-wrapper">
                                <label>From</label><input class="md-input" id="from" type="text" onkeypress="return isNumber(event)"><span class="md-input-bar "></span>
                            </div>
                            <div class="errorMessage" id="from_error" style="display:none">From page should less than To page no.</div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <div class="md-input-wrapper"><label>To</label><input class="md-input" id="to"
                                                                                  type="text" onkeypress="return isNumber(event)"><span class="md-input-bar "></span>
                            </div>
                            <div class="errorMessage" id="to_error" style="display:none">To page no Exceeds Orginal pdf pages no</div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <button type="button" id="normal" class="md-btn" onclick="closedicon()" style="display:none">Save</button>
                            <button type="button" id="update" class="md-btn" onclick="updateclosedicon()" style="display:none">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button id="raneModal" data-uk-modal="{target:'#raneselectModal'}" style="display: none;"></button>
        <div id="quitModal" class="uk-modal">
            <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
                <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
                    <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
                    <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;" onChange="modelClose()"></button>
                </div>
                <div class="uk-modal-content"></div>
                <div class="uk-modal-footer"></div>
            </div>
        </div>
        <button id="triggerModal" data-uk-modal="{target:'#quitModal',bgclose:false}" style="display: none;"></button>
    </body>
</html>

