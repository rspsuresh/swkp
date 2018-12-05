<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/pages/forms_advanced.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/kendo-ui/styles/kendo.common-material.min.css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/bower_components/kendo-ui/styles/kendo.material.min.css"/>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/kendoui_custom.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl ?>/altair_file/assets/js/pages/kendoui.min.js"></script>
<style>
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
    .uk-hide {
        display: none !important;
    }
    .uk-pagination {
        float: left;
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
    #cls {
        position: absolute;
        top: -5px;
        margin: 0;
        right: 0px;
        color: white;
        z-index: 1101;
        background: #ff8080;
        padding: 5px;
        border-radius: 28px;
        height: 100%;
        width: 10%;
    }


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
if (isset($_GET['id']) && isset($_GET['status'])) {
    $partition_id = $_GET['id'];
    $type = $_GET['status'];
    $filePartition = FilePartition::model()->findByPk($partition_id);
    if ($filePartition) {
        $file_id = $filePartition->fp_file_id;
        $firstpage = explode(',', $filePartition->fp_page_nums);
        $pageCount = count(explode(',', $filePartition->fp_page_nums));
        $oldpage = json_encode(explode(',', $filePartition->fp_page_nums));
        $showlink = true;
        if (isset($filePartition->FileInfo->fi_file_ori_location)) {
            $url = Yii::app()->baseUrl . '/' . $filePartition->FileInfo->fi_file_ori_location;
        }
        $cat_id = isset($filePartition->FileInfo->ProjectMaster->p_category_ids) ? $filePartition->FileInfo->ProjectMaster->p_category_ids : '';
        $noncat_id = isset($filePartition->FileInfo->ProjectMaster->non_cat_ids) ? $filePartition->FileInfo->ProjectMaster->non_cat_ids : '';
        //print_r($cat_id);
        //print_r($noncat_id);die;
        $poject_id = isset($filePartition->FileInfo->fi_pjt_id) ? $filePartition->FileInfo->fi_pjt_id : '';
        if ($type == "R") {
            $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "SA", 'ja_flag' => 'A'));
        } else {
            $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "SQP", 'ja_flag' => 'A'));
        }
        if ($job_model) {
            $job_id = $job_model->ja_job_id;
        }
    }
}
?>

<div class="md-card" data-uk-sticky="{ top: 48, media: 960 }" style="margin: 0px;">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-3-10 uk-achor">
                <a id="prev" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)" title="Press left arrow key" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE314;</i></a>
                <a id="next" class="md-fab md-fab-small md-fab-primary" href="javascript:void(0)" title="Press right arrow key" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE315;</i></a>
                <a class="md-fab md-fab-small md-fab-primary" href="<?php echo $url; ?>" target="_blank" title="Pdf" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE89D;</i></a>
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
                <a id="non_medical" class="md-fab md-fab-small md-fab-primary" 'onclick' ='non_medical()' href="javascript:void(0)" title="NonMedicalpPage" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">call_received</i></a>
                <!--<a id="medicalmodal" class="md-fab md-fab-small md-fab-primary" 'onclick' ='medicalmodal()'  title="Medical Page" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">call_received</i>
                </a>-->
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
                <input type="number" id="pageNumber" class="toolbarField pageNumber md-input" value="1" size="4" min="1" tabindex="15">
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
        <div class="uk-grid dateCodeLegPar">
            <!--<fieldset><legend>dsdsdsd</legend>-->
            <div id="dateCodeLeg">
                <div class="uk-width-3-10">
                    <?php echo $form->labelEx($model, 'patient_name'); ?>
                    <?php
                    echo $form->textField($model, 'patient_name', array('class' => "md-input label-fixed",
                        'onfocus' => 'elementFocus()'));
                    ?>
                    <?php echo $form->hiddenField($model, 'project', array('class' => "md-input", 'value' => $poject_id)); ?>
                    <?php echo $form->error($model, 'patient_name'); ?>
                </div>
                <div class="uk-width-3-10">
                    <?php echo $form->labelEx($model, 'gender'); ?>
                    <?php
                    echo $form->radioButtonList($model, 'gender', array('M' => 'Male',
                        'F' => 'Female',
                    ), array(
                        'labelOptions' => array('style' => 'display:inline'), // add this code
                        'separator' => '  ',
                        'data-md-icheck' => "",
                        'onfocus' => 'elementFocus()'
                    ));
                    ?>
                    <?php echo $form->error($model, 'gender'); ?>
                </div>
                <div class="uk-width-3-10">
                    <?php echo $form->labelEx($model, 'doi'); ?>
                    <?php
                    echo $form->textField($model, 'doi', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': 'dd-mm-yyyy'", "data-inputmask-showmaskonhover" => false,
                        'onfocus' => 'elementFocus()'));
                    ?>
                    <?php echo $form->error($model, 'doi'); ?>
                </div>

                <!--</fieldset>-->
            </div>
        </div>
        <div class="uk-grid" style="margin-left:0;">
            <!--PDF Element--->
            <div class="uk-width-medium-3-6 div-focus canvas_outer" id="indexdiv" tabindex="-1" style="text-align:center; max-height:600px; min-height:600px; overflow:scroll;padding-left: 0">
                <canvas id="the-canvas" style="border:1px solid black;width:100%;"></canvas>
            </div>
            <!--Form Elementt--->
            <div class="uk-width-medium-3-6">
                <div class="md-card" style="border:1px solid black;" id="indexform" tabindex='1'>
                    <div class="md-card-content">
                        <!--<h4 class="heading_a" style="text-align:center ">Date Coding</h4>-->
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php //echo $form->labelEx($model, 'pages'); ?>
                                <?php
                                echo $form->textField($model, 'pages', array('class' => "md-input label-fixed", 'readonly' => true
                                , 'onfocus' => 'elementFocus()'));
                                ?>
                                <?php //echo CHtml::hiddenField('skips', '', array('id'=> 'skips', 'class' => "md-input label-fixed", 'readonly' => true));   ?>
                                <?php echo $form->hiddenField($model, 'file', array('value' => $file_id)); ?>
                                <?php //echo $form->error($model, 'pages');   ?>

                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-3 ">
                                <?php echo $form->labelEx($model, 'dos'); ?>
                                <?php
                                echo $form->textField($model, 'dos', array('class' => "md-input masked_input label-fixed", "data-inputmask" => "'alias': 'dd-mm-yyyy'", "data-inputmask-showmaskonhover" => false,
                                    'onfocus' => 'elementFocus()'));
                                ?>
                                <?php echo $form->error($model, 'dos'); ?>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <label>Undated</label>
                                <?php
                                echo $form->checkBox($model, 'undated');
                                ?>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <?php echo $form->labelEx($model, 'provider_name'); ?>
                                <?php
                                echo $form->textField($model, 'provider_name', array('class' => "md-input label-fixed",
                                    'onfocus' => 'elementFocus()'));
                                ?>
                                <?php echo $form->hiddenField($model, 'record_row', array('class' => "md-input")); ?>
                                <?php echo $form->error($model, 'provider_name'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php echo $form->labelEx($model, 'category'); ?>
                                <?php
                                echo $form->dropDownList($model, 'category', CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and (ct_cat_id IN($cat_id) or ct_cat_name ='Duplicate' or ct_cat_name ='Others')")), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category',
                                    'onfocus' => 'elementFocus()'));
                                ?>
                                <?php echo $form->error($model, 'category'); ?>
                                <?php echo $form->hiddenField($model, 'type', array('class' => "md-input", 'value' => "M")); ?>
                            </div>
                        </div>

                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-2 ">
                                <?php echo $form->labelEx($model, 'facility'); ?>
                                <?php
                                echo $form->textField($model, 'facility', array('class' => "md-input label-fixed",
                                    'onfocus' => 'elementFocus()'));
                                ?>
                                <?php echo $form->error($model, 'facility'); ?>
                            </div>
                            <div class="uk-width-medium-1-2 ">
                                <?php echo $form->labelEx($model, 'title'); ?>
                                <?php
                                echo $form->textField($model, 'title', array('class' => "md-input label-fixed",
                                    'onfocus' => 'elementFocus()'));
                                ?>
                                <?php echo $form->error($model, 'title'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php echo CHtml::submitButton('Create', array('class' => 'md-btn md-btn-success splitbtn createbtn')); ?>
                                <?php if ($_GET['status'] == 'QC') { ?>
                                    <?php echo CHtml::button('FeedBack', array('class' => 'md-btn md-btn-primary splitbtn feedbackbtn', 'onclick' => "feedback()")); ?>
                                    <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-warning splitbtn completebtn', 'onclick' => 'CompleteQc()')); ?>
                                <?php } else { ?>
                                    <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-warning completebtn', 'onclick' => 'completeFile()')); ?>
                                    <?php echo CHtml::button('Quit', array('class' => 'md-btn md-btn-danger quitbtn', 'onclick' => 'quit()')); ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php //echo CHtml::button('Move NonMedical', array('class' => 'md-btn md-btn-danger', 'onclick' => 'non_medical()'));   ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
                <!--Old pages-->
                <div class="md-card" style="border:1px solid black;max-height: 236px;overflow: auto; padding-right: 27px;" id="indexfile">
                    <div class="md-card-content" id="filerecord">
                    </div>
                </div>
            </div>
        </div>
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
            </ul>
        </div>
    </div>
</div>


<script>
    $(function () {
        $("select[name='DateCoding[category]'").chosen();

        $('#DateCoding_undated').on('click', function () {
            var hideDiv = $('#DateCoding_dos_em_').parent().eq(0);
            if ($(this).prop('checked')) {
                $('#DateCoding_dos').val("");
                hideDiv.hide('1000');
            }
            else {
                hideDiv.show('1000');
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
    var selectPartition = false;

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
            $('#' + pageNum + 'id').removeClass('uk-active');
            var customPagesNew = JSON.parse(customPages);
            var customPagesLength = customPagesNew.length;
            if (pageNum <= customPagesNew[0]) {
                $('#' + pageNum + 'id').addClass('uk-active');
                return pageNum;
            }
            if (page == "") {
                page = customPagesNew[0];
            }
            if (page > 0) {
                page--;
            }
            pageNum = Number(customPagesNew[page]);
            if ($('#' + pageNum + 'id').hasClass('uk-hide') == true) {
                $('#' + pageNum + 'id').removeClass('uk-hide');
                $('#' + pageNum + 'id').nextAll().eq(9).addClass('uk-hide');
            }
            $('#' + pageNum + 'id').addClass('uk-active');
            queueRenderPage(pageNum);
            return Number(customPagesNew[page + 1]);
        }
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);
    /**
     * Displays next page.
     */
    function onNextPage() {
        if (customPages != "") {
            $('#' + pageNum + 'id').removeClass('uk-active');
            var customPagesNew = JSON.parse(customPages);
            var customPagesLength = customPagesNew.length;
            if (pageNum >= customPagesNew[customPagesLength - 1]) {
                $('#' + pageNum + 'id').addClass('uk-active');
                return pageNum;
            }
            if (page == 0) {
                pageNum = customPagesNew[0];
            }
            page++;
            pageNum = Number(customPagesNew[page]);
            if ($('#' + pageNum + 'id').hasClass('uk-hide') == true) {
                $('#' + pageNum + 'id').removeClass('uk-hide');
                $('#' + pageNum + 'id').prevAll().eq(9).addClass('uk-hide');
            }
            $('#' + pageNum + 'id').addClass('uk-active');
            if (page < customPagesLength) { // prevent next page display on last page
                queueRenderPage(pageNum);
            }
            return Number(customPagesNew[page - 1]);
        }
    }
    document.getElementById('next').addEventListener('click', onNextPage);
    /**
     * Displays Search page.
     */
    function Search() {
        var pageNo = parseInt($('#pageNumber').val()).toString();
        var customPagesNew = JSON.parse(customPages);
        var customPagesLength = customPagesNew.length;
        if (jQuery.inArray(pageNo, customPagesNew) !== -1) {
            pageNum = parseInt(pageNo);
            queueRenderPage(pageNum);

            $('.uk-active').removeClass('uk-active');
            $('.uk-pagination li').not(':first').not(':last').addClass('uk-hide');
            page = customPagesNew.indexOf(pageNum.toString());
            if (((customPagesLength - 1) - page) < 9) {
                modulo = (customPagesLength - 1) - page;
                nxtmod = 9 - modulo;
                $('#' + pageNum + 'id').addClass('uk-active');
                $('#' + pageNum + 'id').prevAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').nextAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
            }
            else {
                modulo = page % 10;
                nxtmod = 9 - modulo;
                $('#' + pageNum + 'id').addClass('uk-active');
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
            var partition = $('#filerecord a').last();
            renderPage(Number(partitionPages[0]));
            if (partition.length > 0 && !selectPartition) {
                getContent(partition);
            }
        }
        else {
            renderPage(pageNum);
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
        var formdata = new FormData($('#file-partition-form')[0]);
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('filepartition/autosavesplit') ?>?mode=" + mode,
            type: "post",
            data: formdata,
            global: false,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
            }
        });
    }
    function oncancel() {
        //var partition = $('#filerecord a').first();
        var partition = $('#filerecord a').last();
        if (partition.length > 0) {
            getContent(partition);
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
        $('#DateCoding_pages').val(result[0]);
        $('#DateCoding_dos').val(result[1]);
        $('#DateCoding_dos').trigger('autoresize');
        $('#DateCoding_patient_name').val(result[2]);
        $('#DateCoding_category').val(result[3]);
        $('#DateCoding_provider_name').val(result[4]);

        if (result[1] == "")
        //$('#DateCoding_undated').prop('checked','checked');
            $('#DateCoding_undated').trigger('click');
        $("#DateCoding_category").trigger("chosen:updated");
        var gender = result[5];
        if (gender !== '') {
            $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
            $('input[name="DateCoding[gender]"][value=' + gender + ']').prop('checked', true).iCheck('update');
        }
        $('#DateCoding_doi').val(result[6]);
        $('#DateCoding_facility').val(result[7]);
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

    function goToPage(pgnum) {
        var customPagesNew = JSON.parse(customPages);
        $('.uk-active').removeClass('uk-active');
        $('#' + pgnum + 'id').addClass('uk-active');
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

            $('.uk-active').removeClass('uk-active');
            $('.uk-pagination li').not(':first').not(':last').addClass('uk-hide');
            page = customPagesNew.indexOf(pageNum.toString());
            if (((customPagesLength - 1) - page) < 9) {
                modulo = (customPagesLength - 1) - page;
                nxtmod = 9 - modulo;
                $('#' + pageNum + 'id').addClass('uk-active');
                $('#' + pageNum + 'id').prevAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').nextAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
            }
            else {
                modulo = page % 10;
                nxtmod = 9 - modulo;
                $('#' + pageNum + 'id').addClass('uk-active');
                if (modulo !== 0) {
                    $('#' + pageNum + 'id').prevAll(':lt(' + modulo + ')').removeClass('uk-hide');
                }
                $('#' + pageNum + 'id').nextAll(':lt(' + nxtmod + ')').andSelf().removeClass('uk-hide');
            }

            return pageNum;
        }
    }

    $(document).ready(function () {
        var paginCont = JSON.parse(customPages);
        wholemedicalarray = paginCont.map(Number);
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
        //Toogle Bar Full Width
        ($body.hasClass('sidebar_main_active') || ($body.hasClass('sidebar_main_open') && $window.width() >= 1220)) ? altair_main_sidebar.hide_sidebar() : altair_main_sidebar.show_sidebar();
        <?php if (!empty($restore_json)) { ?>
        selectPartition = true;
        UIkit.modal.confirm("Are you sure, you want to restore previous data?", onconfirm, oncancel, function () {
        });
        <?php } ?>
        appendRecord();
        if ($('#filerecord').children().length == 0) {
            $('<span></span>', {css: {"font-style": "oblique"}, text: "No Partition Created"}).appendTo('#filerecord');
        }
        $('#file-partition-form :input').on('keyup click change ifClicked', function () {
            autoSave('S');
        });
        $(document).unbind('keyup').keyup(function (e) {
            if ($('#quitModal').is(':visible') === false) {
                //Escape Key for Change Focus
                if (e.which === 27) {
                    //if ($('#indexform').is(':focus')) {
                    //if ($('#DateCoding_dos').is(':focus')) {
                    if ($('#DateCoding_dos').is(':focus') || $('#DateCoding_provider_name').is(':focus')) {
                        datecodeDivfocus();
                    } else if ($('#DateCoding_patient_name').is(':focus')) {
                        pdfDivfocus();
                    } else {
                        formDivfocus();
                    }
                }
                //Plus Key for Select Break Files
                if (e.which === 107) {
                    breakDivfocus();
                    breakFocus();
                }
                if (e.which === 191 && e.altKey) {
                    non_medical();
                }
                <?php if ($_GET['status'] == 'R') { ?>
                if (e.which === 81 && e.altKey) {
                    $(".quitbtn").trigger("click");
                }
                <?php } ?>
                if (e.which === 65 && e.altKey) {
                    $(".createbtn").trigger("click");
                }
                if (e.which === 67 && e.altKey) {
                    $(".completebtn").trigger("click");
                }
                <?php if ($_GET['status'] == 'QC') { ?>
                if (e.which === 87 && e.altKey) {
                    $(".feedbackbtn").trigger("click");
                }
                <?php } ?>
                if (pdfFocus) {
                    if (e.which === 39 && e.ctrlKey) {
                        var pgnos = [];
                        var nextPage = onNextPage();
                        if ($('#DateCoding_pages').val() != "") {
                            pgnos = $('#DateCoding_pages').val().split(',');
                        }
                        if (pgnos.indexOf(nextPage.toString()) == -1) {
                            pgnos.push(nextPage);
                        }
                        $('#DateCoding_pages').val(pgnos);
                        autoSave('S');
                    }
                    else if (e.which === 37 && e.ctrlKey) {
                        var prevPage = onPrevPage();
                        var splitval = $('#DateCoding_pages').val().split(',');
                        var index = splitval.indexOf(prevPage.toString());
                        if (index > -1) {
                            splitval.splice(index, 1);
                        }
                        $('#DateCoding_pages').val(splitval);
                        autoSave('S');
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
                    /* else if (e.which === 77 || e.which === 78) {
                     if (e.which === 78) {
                     mdpags = $('#DateCoding_pages').val();
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
                     $('#DateCoding_pages').val(joined);
                     $('#DateCoding_pages').focus();
                     }
                     nmpags = $('#skips').val();
                     if (nmpags !== "") {
                     var split_nmpags = nmpags.split(",");
                     if (split_nmpags.indexOf(String(pageNum)) === -1) {
                     nmdvalue = nmpags + ',' + pageNum;
                     var nmdres = nmdvalue.split(",");
                     nmdres.sort(arrange);
                     retval = nmdres.join();
                     $('#skips').val(retval);
                     $('#skips').focus();
                     }
                     }
                     else {
                     $('#skips').val(pageNum);
                     $('#skips').focus();
                     }
                     if (parseInt(pageNum) === parseInt(pdfDoc.numPages)) {
                     renderPage(pageNum);
                     }
                     else {
                     onNextPage();
                     }
                     }
                     else if (e.which === 77) {
                     nmpags = $('#skips').val();
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
                     $('#skips').val(joined);
                     $('#skips').focus();
                     }
                     mdpags = $('#DateCoding_pages').val();
                     if (mdpags !== "") {
                     var split_mdpags = mdpags.split(",");
                     if (split_mdpags.indexOf(String(pageNum)) === -1) {
                     mdvalue = mdpags + ',' + pageNum;
                     var mdres = mdvalue.split(",");
                     mdres.sort(arrange);
                     retval = mdres.join();
                     $('#DateCoding_pages').val(retval);
                     $('#DateCoding_pages').focus();
                     //$('#FilePartition_fp_page_nums').val(mdpags+','+pageNum);
                     }
                     }
                     else {
                     $('#DateCoding_pages').val(pageNum);
                     $('#DateCoding_pages').focus();
                     }
                     if (parseInt(pageNum) === parseInt(pdfDoc.numPages)) {
                     renderPage(pageNum);
                     }
                     else {
                     onNextPage();
                     }
                     }
                     } */
                }
            }
        });

        return false;
    });
    // Focus fot Form Text
    function inputFocus($val) {
        pdfFocus = $val;
    }
    //BreakFile Focus in Function
    function breakFocus() {
        var a_count = parseInt($("#filerecord a").length) - 1;
        var currentFocus = $("#filerecord a").index($("#filerecord").find('a:focus'));
        if (currentFocus < 0 || currentFocus == a_count) {
            $("#filerecord a").eq(0).focus();
        } else {
            $("#filerecord a").eq(currentFocus + 1).focus();
        }
    }
    //Pdf Focus
    function pdfDivfocus() {
        // $('#DateCoding_pages').blur();
        //$('#indexform').blur().removeClass('div-focus');
        $('#indexform').removeClass('div-focus');
        $('#dateCodeLeg').removeClass('div-focus');
        //$('#DateCoding_dos').blur();
        $('#DateCoding_patient_name').blur();
        $('#indexfile').removeClass('div-focus');
        $('#indexdiv').addClass('div-focus');
        pdfFocus = true;
    }
    //Form Focus
    function formDivfocus() {
        $('#indexdiv').removeClass('div-focus');
        $('#dateCodeLeg').removeClass('div-focus');
        $('#indexfile').removeClass('div-focus');
        //$('#indexform').focus().addClass('div-focus');
        $('#indexform').addClass('div-focus');
        //$('#DateCoding_dos').focus();
        if ($('#DateCoding_dos').is(':visible')) {
            $('#DateCoding_dos').focus();
        }
        else {
            $('#DateCoding_provider_name').focus();
        }
        pdfFocus = false;
    }

    //Form Focus
    function datecodeDivfocus() {
        $('#indexdiv').removeClass('div-focus');
        $('#dateCodeLeg').removeClass('div-focus');
        $('#indexfile').removeClass('div-focus');
        $('#indexform').removeClass('div-focus');
        $('#DateCoding_dos').blur();
        //$('#indexform').focus().addClass('div-focus');
        $('#dateCodeLeg').addClass('div-focus');
        $('#DateCoding_patient_name').focus();
        pdfFocus = false;
    }

    //Break Div Focus
    function breakDivfocus() {
        $('#DateCoding_pages').blur();
        $('#indexdiv').blur().removeClass('div-focus');
        $('#indexform').blur().removeClass('div-focus');
        $('#indexfile').addClass('div-focus');
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
    function saveUserForm(form, data, hasError) {
        var hiddenPages = $("#DateCoding_pages").val();
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
                timeout: 10000,
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
                completeFiles = false;
                var formdata = new FormData($('#file-partition-form')[0]);
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl('filepartition/filesplit', array('id' => $partition_id, 'status' => $type)) ?>',
                    type: "post",
                    data: formdata,
                    contentType: false,
                    cache: false,
                    processData: false,
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
                            clearform();
                            clearTimeout(timer);
                            myFuncCalls = 0;
                            autoSave('D');
                            var appendData = obj.append;
                            if (appendData) {
                                $('#filerecord').empty().append(appendData.medi);
                            }
                        }
                    }
                });
            }
        } else {
            $(".errorMessage:first").prev().focus();
        }
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
        });
    }
    /**
     * clear form
     */
    function clearform() {
        var previousName = $("#DateCoding_patient_name").val();
        var previousDoi = $("#DateCoding_doi").val();
        var previousGen = $('input[name="DateCoding[gender]"]:checked').val();
        $("#file-partition-form").trigger('reset');
        $('#DateCoding_dos_em_').parent().eq(0).show();
        $("#DateCoding_record_row").val('');
        $("#DateCoding_dos").val('');
        $("#DateCoding_category").trigger("chosen:updated");
        $("#DateCoding_patient_name").val(previousName);
        $("#DateCoding_doi").val(previousDoi);
        $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
        $('input[name="DateCoding[gender]"][value=' + previousGen + ']').prop('checked', true).iCheck('update');
        $('input[type=submit]').val('Create');
        $('input[type=submit]').hasClass('md-btn-warning') ? $('input[type=submit]').removeClass('md-btn-warning').addClass('md-btn-success') : '';
        setClass();
        formDivfocus();
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


    function completeFile() {
        var partfiles = $('#filerecord').html();
        var len = $('.partionlen').length;
        if ($("#filerecord div").length > 0) {
            var $filecheck = '';
            alertMsg = '';
            if ($('.uk-modal').is(':visible') === false && $("#filerecord div").length > 0) {
                if (splitPageNomedi.length != wholemedicalarray.length) {
                    alertMsg = "Are you sure, you want to complete the file?";
                }
                else {
                    alertMsg = "Still some pages are not reviewed ,Are you sure, you want to complete the file?";
                }

                UIkit.modal.confirm(alertMsg, function () {
                    if (len != 0) {
                        $.ajax({
                            url: '<?php echo Yii::app()->createUrl('filepartition/splitcomplete', array('mode' => 'S', 'status' => false)); ?>',
                            type: "post",
                            data: {job_id: <?php echo $job_id; ?>},
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
                    }
                });
                /*	$.ajax({
                 url: '<?php echo Yii::app()->createUrl('filepartition/partitioncheck', array('mode' => 'C', 'status' => false)); ?>',
                 type: "post",
                 data: {job_id: <?php echo $job_id; ?>},
                 success: function (result) {
                 var obj = JSON.parse(result);
                 if (obj.status == "NF") {
                 clearTimeout(timer);
                 UIkit.notify({
                 message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Need to create atleast one partition before complete!",
                 status: "error",
                 timeout: 500,
                 pos: 'top-right'
                 });
                 }
                 else {
                 $filecheck == "RF";
                 UIkit.modal.confirm(alertMsg, function () {
                 if (len != 0) {
                 $.ajax({
                 url: '<?php echo Yii::app()->createUrl('filepartition/splitcomplete', array('mode' => 'S', 'status' => false)); ?>',
                 type: "post",
                 data: {job_id: <?php echo $job_id; ?>},
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
                 }
                 });
                 }
                 }
                 }); */

            }
        } else {
            if ($('.uk-notify').is(':visible') === false) {
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Need to create atleast one partition before complete!",
                    status: "error",
                    timeout: 500,
                    pos: 'top-right'
                });
            }
        }
    }

    function CompleteQc() {
        alertMsg = '';
        if ($('.uk-modal').is(':visible') === false) {
            if ($("#filerecord div").length > 0) {
                id = <?php echo $job_id; ?>;
                if (splitPageNomedi.length != wholemedicalarray.length) {
                    alertMsg = "Move to Editing?";
                }
                else {
                    alertMsg = "Still some pages are not reviewed ,Move to Editing?";
                }
                UIkit.modal.confirm(alertMsg, function () {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('joballocation/qualityupdate') ?>/" + id,
                        type: "post",
                        data: {status: 'SQC'},
                        success: function (result) {
                            clearTimeout(timer);
                            myFuncCalls = 0;
                            autoSave('D');
                            var obj = JSON.parse(result);
                            if (obj.status == "S" || obj.status == "U") {
                                window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                            }
                        }
                    });
                });
            }
            else {
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Need to create atleast one partition before complete!",
                        status: "error",
                        timeout: 500,
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
        }
        calculatearray(val.medi, val.nonmedi);
    }
    var wholemedicalarray = [],
        splitPageNomedi = [];
    function calculatearray(medi) {
        if (medi) {
            var partitionmedi = $('#filerecord a');
            var tmpmedi = '';
            $.each(partitionmedi, function (key, value) {
                tmpmedi += $(this).attr('data-pagno').split(",");
            });
            splitPageNomedi = tmpmedi.split(',').map(Number);
        }

    }

    function getContent($this) {
        //get PageNo
        var splitPageNo = $this.attr('data-pagno').split(",");
        pageNum = Number(splitPageNo[splitPageNo.length - 1]);
        loadToPage(pageNum);
        //Append Data
        $('#DateCoding_pages').val($($this).attr('data-pagno'));
        $('#DateCoding_dos').val($($this).attr('data-dos'));
        $('#DateCoding_dos').trigger('autoresize');
        $('#DateCoding_patient_name').val($($this).attr('data-pname'));
        $('#DateCoding_category').val($($this).attr('data-cat'));
        $('#DateCoding_provider_name').val($($this).attr('data-provider'));
        $('#DateCoding_title').val($($this).attr('data-title'));
        if ($($this).attr('data-dos') == "") {
            $('#DateCoding_undated').prop('checked', 'checked');
            $('#DateCoding_dos_em_').parent().eq(0).hide();
        }
        else {
            $('#DateCoding_undated').prop('checked', false);
            $('#DateCoding_dos_em_').parent().eq(0).show();
        }
        $("#DateCoding_category").trigger("chosen:updated");
        $('#DateCoding_record_row').val($($this).attr('data-row'));
        var gender = $($this).attr('data-gender');
        $('input[name="DateCoding[gender]"]').prop('checked', false).iCheck('update');
        $('input[name="DateCoding[gender]"][value=' + gender + ']').prop('checked', true).iCheck('update');
        $('#DateCoding_doi').val($($this).attr('data-doi'));
        $('#DateCoding_facility').val($($this).attr('data-facility'));
        $('input[type=submit]').val('Update');
        setClass();
        $($this).hasClass('md-btn-primary') ? $($this).removeClass('md-btn-primary').addClass('md-btn-warning') : $($this).removeClass('md-btn-warning').addClass('md-btn-primary');
        $('input[type=submit]').hasClass('md-btn-success') ? $('input[type=submit]').removeClass('md-btn-success').addClass('md-btn-warning') : '';

    }
    /**
     * @Set Class
     */
    function setClass() {
        $('#filerecord  a').each(function () {
            if ($(this).hasClass('md-btn-warning')) {
                $(this).removeClass('md-btn-warning').addClass('md-btn-primary');
            }
        });
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
    // document.getElementById('medicalmodal').addEventListener('click', medicalmodal);
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
			altmsg =  "";
			if(nonPages === ""){
				altmsg = "Choose pages for Non Medical";
			}
			else{
				altmsg = "Cannot move all the pages to Non-Medical";
			}
            if ($('.uk-notify').is(':visible') === false) {
                UIkit.notify({
                    message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a>"+altmsg,
                    status: "error",
                    timeout: 2000,
                    pos: 'top-right'
                });
            }
        }
    }
    //move to medical pages
    function medicalmodal() {
        $("#quitModal .uk-modal-header h3").html("Medical Page");
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('filepartition/movemedical', array('file_id' => $file_id)) ?>',
            type: "post",
            data: {'pages': nonPages},
            success: function (result) {
                $("#quitModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
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