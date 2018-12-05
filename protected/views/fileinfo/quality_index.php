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
	.md-list-heading{
		font-weight : bold !important;
	}
        .uk-modal{
            z-index: 100000;
        }


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
</style>
<?php
$file_id = '';
$partation_id = '';
$oldpagetext = '';
$oldpage = '';
$url = '';
$id = '';
$projId = '';
$jobId = '';
$medpages = array();
$nonpages = array();
if (isset($_GET['status']) && isset($_GET['id'])) {
    $type = $_GET['status'];
    $id = $_GET['id'];
    $partation_id = $_GET['id'];
    $partation = FilePartition::model()->findByPk($partation_id);

    if ($partation) {
        $oldpages = FilePartition::model()->findAllByAttributes(array('fp_file_id' => $partation->fp_file_id, 'fp_cat_id' => 0), array('condition' => 'fp_flag = "A" and (fp_category="M" or fp_category="N")'));

        if (!empty($oldpages[0]->fp_page_nums)) {
            $medpages = explode(",", $oldpages[0]->fp_page_nums);
        }
        if (!empty($oldpages[1]->fp_page_nums)) {
            $nonpages = explode(",", $oldpages[1]->fp_page_nums);
        }
        $totpages = array_merge($medpages, $nonpages);
        $totpages = array_values($totpages);
        sort($totpages);
        $oldpage = json_encode($totpages);
        //$oldpage = json_encode(explode(',', $partation->fp_page_nums));
        //$oldpagetext = $partation->fp_page_nums;
        $file_id = $partation->fp_file_id;
        //$jobId=isset($partation->JobAllocation_part->ja_job_id);
        $info = FileInfo::model()->findByPk($file_id);
        if ($info) {
            $url = Yii::app()->baseUrl . '/' . $info->fi_file_ori_location;
           if(Yii::app()->session['user_type'] == "QC" )
           {
               $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => "IQP", 'ja_flag' => 'A'));
           }
           else if(Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL" )
           {
               $job_model = JobAllocation::model()->find(array('condition' => "ja_file_id =$file_id and ja_flag ='A' and (ja_status = 'IQP' or ja_status='IC') "));
           }
            $jobId = isset($job_model) ? $job_model->ja_job_id : '';
            $projId = isset($info->ProjectMaster->p_pjt_id);
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
                <!--<a class="md-fab md-fab-small md-fab-primary" onclick="rangegselect()" title="page range select" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8A0;</i></a>-->
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
                            <td>Move To Medical</td>
                        </tr>
                        <tr>
                            <td><span class="uk-badge uk-badge-primary status-badge">N</span></td>
                            <td>Move To Non-Medical</td>
                        </tr>
                        </tbody>
                    </table>
                </div>-->
                <a class="md-fab md-fab-small md-fab-primary zoom_in" href="javascript:void(0)" title="Zoom In" data-uk-tooltip="{pos:'bottom'}" onclick = "zooming('in')"><i class="material-icons md-24 icon-white uk-text-bold">zoom_in</i></a>
                <a class="md-fab md-fab-small md-fab-primary zoom_out" href="javascript:void(0)" title="Zoom Out" onclick = "zooming('out')" data-uk-tooltip="{pos:'bottom'}" ><i class="material-icons md-24 icon-white uk-text-bold">zoom_out</i></a>
                <a class="md-fab md-fab-small md-fab-primary view_pages" href="javascript:void(0)" title="View Pages" data-uk-tooltip="{pos:'bottom'}" style="display:none;"><i class="material-icons md-24 icon-white uk-text-bold">add circle</i></a>
                <!--<a class="md-fab md-fab-small md-fab-primary" onclick="rangeselect()" title="page range select" data-uk-tooltip="{pos:'bottom'}"><i class="material-icons md-24 icon-white uk-text-bold">&#xE8A0;</i></a>-->
                <?php if (!isset($oldpages[0]->fp_page_nums) && !isset($oldpages[1]->fp_page_nums)) { ?>
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
                    <?php /* <a class="md-fab md-fab-small md-fab-primary tooltip" href="<?php echo Yii::app()->createUrl('fileinfo/indexalloc') ?>"><i class="material-icons md-24 icon-white uk-text-bold">&#xE5C4;</i><span class="tooltiptext">Back</span></a>*/ ?>
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
        <div class="uk-grid switch-lay">
            <!--<div class="uk-width-medium-6-6" id="indexdiv">
                <div class="uk-width-medium-6-6 canvas_outer" style="text-align:center; max-height:100%; min-height:100%; overflow:scroll;">
                    <canvas id="the-canvas" style="border:2px solid black;width: 50%;max-height:100% !important" height="100%"></canvas>
                </div>
            </div>-->

            <div class="uk-width-medium-1-3"></div>
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
                            <input type='hidden' value="<?php echo $file_id; ?>" id="fileid">
                            <input type='hidden' id="catgry">
                            <div class="uk-width-medium-6-6">
                                <?php
                                echo CHtml::radioButtonList("displayCheck", 'A',
                                    array(
                                        'A' => 'All',
                                        'M' => 'Medical',
                                        'N' => 'Non-Medical',
                                    ),
                                    array(
                                        'labelOptions' => array('style' => 'display:inline'), // add this code
                                        'separator' => '  ',
                                        'onchange' => 'displayChange($(this))'
                                    ));
                                ?>
                                <div style="float:right;">
                                    <?php echo CHtml::button('Add FeedBack', array('class' => 'md-btn md-btn-warning feedbackbtn', 'onclick' => "feedback()")); ?>
                                </div>
                            </div>

                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-6-6" id="meddiv">
                                <label style="font-weight:bold;">Medical pages: </label>
                                <?php echo CHtml::textArea('medical_pages', (!empty($oldpages[0]->fp_page_nums) ? $oldpages[0]->fp_page_nums : ""), array('id' => 'medpg', 'class' => "md-input", 'readonly' => true)); ?>
                                <?php //echo $form->textArea($model, 'fp_page_nums', array('class' => "md-input", 'value' => $oldpages[0]->fp_page_nums, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-6-6" id="nonmeddiv">
                                <label style="font-weight:bold;">Non-Medical pages: </label>
                                <?php echo CHtml::textArea('non_medical_pages', (!empty($oldpages[1]->fp_page_nums) ? $oldpages[1]->fp_page_nums : ""), array('id' => 'nonmedpg', 'class' => "md-input", 'readonly' => true)); ?>
                                <?php //echo $form->textArea($model, 'fp_page_nums', array('class' => "md-input", 'value' => $oldpages[1]->fp_page_nums, 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="uk-grid">
                            <div class="uk-width-medium-1-1 ">
                                <?php //echo CHtml::button('Add FeedBack', array('class' => 'md-btn md-btn-warning', 'onclick' => "feedback()")); ?>
                                <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-success completebtn', 'onclick' => 'CompleteQc()')); ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



`	<div id="style_switcher">
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
							<span class="md-list-heading">Move To Medical</span>
                            <span class="uk-text-small uk-text-muted">M</span>
                        </div>
                    </li>
					<li>
						<div class="md-list-content">
							<span class="md-list-heading">Move To Non-Medical</span>
                            <span class="uk-text-small uk-text-muted">N</span>
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
							<span class="md-list-heading">Feedback</span>
                            <span class="uk-text-small uk-text-muted">Alt-W</span>
                        </div>
                    </li>
					<li>
						<div class="md-list-content">
							<span class="md-list-heading">Switch Next</span>
                            <span class="uk-text-small uk-text-muted">+</span>
                        </div>
                    </li>
					<li>
						<div class="md-list-content">
							<span class="md-list-heading">Switch Previous</span>
                            <span class="uk-text-small uk-text-muted">-</span>
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
                            <span class="md-list-heading">Page search shortcut</span>
                            <span class="uk-text-small uk-text-muted">Alt+X</span>
                        </div>
                    </li>
                </ul>
			</div>
        </div>
    </div>
<li>
    <div class="md-list-content">
        <span class="md-list-heading">Modal Close</span>
        <span class="uk-text-small uk-text-muted">Esc</span>
    </div>
</li>
<!---PDF Script--->
<script src="<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.js' ?>"></script>
<script id="script">
    //Kendo window
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
			position: { left: '2%', top:'80%' },
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
            canvas.height =700;
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
        document.getElementById('page_num1').textContent = pageNum;
        medpgs = document.getElementById('medpg').value;
        nonmedpgs = document.getElementById('nonmedpg').value;
        var split_medpgs = medpgs.split(",");
        var split_nonmedpgs = nonmedpgs.split(",");
        if (split_medpgs.indexOf(String(pageNum)) !== -1) {
            $('#nonmed').removeClass('md-btn-primary');
            $('#med').removeClass('md-btn-default');
            $('#med').addClass('md-btn-primary');
            $('#catgry').val('M');
        }
        else if (split_nonmedpgs.indexOf(String(pageNum)) !== -1) {
            $('#med').removeClass('md-btn-primary');
            $('#nonmed').removeClass('md-btn-default');
            $('#nonmed').addClass('md-btn-primary');
            $('#catgry').val('N');
        }
        else {
            $('#med,#nonmed').removeClass('md-btn-primary');
            $('#nonmed,#med').addClass('md-btn-default');
        }
        /* fileid = document.getElementById('fileid').value;
         $.ajax({
         url: ' Yii::app()->createUrl('fileinfo/findpagetype'); ?>',
         data: {pagenum: pageNum, fileid: fileid},
         type: "POST",
         success: function (result) {
         var obj = JSON.parse(result);
         document.getElementById('catgry').value = obj.category
         if (obj.category == 'M') {
         $('#nonmed').removeClass('md-btn-primary');
         $('#med').removeClass('md-btn-default');
         $('#med').addClass('md-btn-primary');
         }
         else if (obj.category == 'N') {
         $('#med').removeClass('md-btn-primary');
         $('#nonmed').removeClass('md-btn-default');
         $('#nonmed').addClass('md-btn-primary');
         }
         }
         }); */
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
        if(isNaN(pageNo))
            return false;
        if (type == 'R') {
            if (pageNo > pdfDoc.numPages || pageNo <= 0) {
                return;
            }
            pageNum = pageNo;
            queueRenderPage(pageNo);
            return pageNum;
        } else {
            var customPagesNew = JSON.parse(customPages);
            var newPage = pageNo.toString();
            if (jQuery.inArray(newPage, customPagesNew) == -1) {
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
    PDFJS.getDocument({ url: url, password: 'KJN98IONHO'}).then(function (pdfDoc_) {
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
    function displayChange($this) {
        var curDisplay = $this.val();
        if (curDisplay == 'A') {
            $('#meddiv').show();
            $('#nonmeddiv').show();
            mdvalue = $('#medpg').val();
            nmvalue = $('#nonmedpg').val();
            mdarray = mdvalue.split(',');
            nmarray = nmvalue.split(',');
            if (mdvalue !== '' && nmvalue !== '') {
                mdres = mdarray.concat(nmarray);
                mdres.sort(arrange);
                pageNum = parseInt(mdres[0]);
                customPages = JSON.stringify(mdres);
                renderPage(pageNum);
            }
            else if (mdvalue == '') {
                pageNum = parseInt(nmarray[0]);
                customPages = JSON.stringify(nmarray);
                renderPage(pageNum);
            }
            else if (nmvalue == '') {
                pageNum = parseInt(mdarray[0]);
                customPages = JSON.stringify(mdarray);
                renderPage(pageNum);
            }
        }
        else if (curDisplay == 'M') {
            $('#meddiv').show();
            $('#medpg').focus();
            $('#nonmeddiv').hide();
            mdvalue = $('#medpg').val();
            if (mdvalue !== "") {
                mdarray = mdvalue.split(',');
                pageNum = parseInt(mdarray[0]);
                customPages = JSON.stringify(mdarray);
                renderPage(pageNum);
            }
            else {
                $('#displayCheck_0').click();
                $('.uk-close')[0].click();
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> No Pages in Medical",
                        status: "error",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                }
            }
        }
        else if (curDisplay == 'N') {
            $('#meddiv').hide();
            $('#nonmeddiv').show();
            $('#nonmedpg').focus();
            nmvalue = $('#nonmedpg').val();
            if (nmvalue !== '') {
                nmarray = nmvalue.split(',');
                pageNum = parseInt(nmarray[0]);
                customPages = JSON.stringify(nmarray);
                renderPage(pageNum);
            }
            else {
                $('#displayCheck_0').click();
                $('.uk-close')[0].click();
                if ($('.uk-notify').is(':visible') === false) {
                    UIkit.notify({
                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> No Pages in Non-Medical",
                        status: "error",
                        timeout: 2000,
                        pos: 'top-right'
                    });
                }
            }
        }
    }

    function arrange(a, b) {
        return a - b;
    }
    myFuncCalls = 0;
    $(document).on('ready', function () {
        //Toogle Bar Full Width
        ( $body.hasClass('sidebar_main_active') || ($body.hasClass('sidebar_main_open') && $window.width() >= 1220) ) ? altair_main_sidebar.hide_sidebar() : altair_main_sidebar.show_sidebar();
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
        $('#indexdiv').attr('tabindex', -1).trigger('focus');
        if ($('#indexdiv').attr('tabindex', -1).is(":focus")) {
            $(document).unbind('keyup').keyup(function (e) {
			if($('#quitModal').is(':visible') === false && !$('#raneselectModal').is(':visible')){
				if (e.which === 107) {
                    tabindex = $('input:radio[name=displayCheck]:checked').index();
                    tablen = $('input:radio[name=displayCheck]').length;
                    if (tabindex < (tablen - 1) * 2) {
                        $('input:radio[name=displayCheck]')[(tabindex / 2) + 1].click();
                    }
                }
                else if (e.which === 109) {
                    tabindex = $('input:radio[name=displayCheck]:checked').index();
                    tablen = $('input:radio[name=displayCheck]').length;
                    if (tabindex > 0) {
                        $('input:radio[name=displayCheck]')[(tabindex / 2) - 1].click();
                    }
                }
				
				if (e.which === 87 && e.altKey) {
					$(".feedbackbtn").trigger("click");
				}
				if (e.which === 67 && e.altKey) {
					$(".completebtn").trigger("click");
				}
                if (e.which === 39 && e.ctrlKey) {
                    var pgnos = [];
                    var nextPage = onNextPage();
                    if ($('#FilePartition_fp_page_nums').val() != "") {
                        pgnos = $('#FilePartition_fp_page_nums').val().split(',');
                    }
                    if (pgnos.indexOf(nextPage.toString()) == -1) {
                        pgnos.push(nextPage);
                    }

                    $('#FilePartition_fp_page_nums').val(pgnos);
                }
                else if (e.which === 37 && e.ctrlKey) {
                    var prevPage = onPrevPage();
                    var splitval = $('#FilePartition_fp_page_nums').val().split(',');
                    var index = splitval.indexOf(prevPage.toString());
                    if (index > -1) {
                        splitval.splice(index, 1);
                    }
                    $('#FilePartition_fp_page_nums').val(splitval);
                }
                else if (e.which === 37) {
                    //	onPrevPage();
                    var newCustomPages = JSON.parse(customPages);
                    var newCustomPagesLength = newCustomPages.length;
                    indexPage = newCustomPages.indexOf(String(pageNum));
                    renderindex = indexPage - 1;
                    if (indexPage !== 0) {
                        pageNum = newCustomPages[parseInt(renderindex)];
                        renderPage(parseInt(pageNum));
                    }
                }
                else if (e.which === 39) {
                    //	onNextPage();
                    var newCustomPages = JSON.parse(customPages);
                    var newCustomPagesLength = newCustomPages.length;
                    indexPage = newCustomPages.indexOf(String(pageNum));
                    renderindex = indexPage + 1;
                    if (indexPage !== newCustomPagesLength - 1) {
                        pageNum = newCustomPages[parseInt(renderindex)];
                        renderPage(parseInt(pageNum));
                    }
                    if (parseInt(pageNum) === parseInt(newCustomPages[newCustomPagesLength - 1])) {
                        if ($('.uk-notify').is(':visible') === false) {
                            UIkit.notify({
                                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached last page!",
                                status: "error",
                                timeout: 1500,
                                pos: 'top-right'
                            });
                        }
                    }
                }
                else if (e.which === 77 || e.which === 78) {
                    catgry = $('#catgry').val();
                    if ((catgry == 'M' && e.which === 77) || (catgry == 'N' && e.which === 78)) {
                        $('.uk-close')[0].click();
                        if ($('.uk-notify').is(':visible') === false) {
                            UIkit.notify({
                                message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Can't Move!",
                                status: "error",
                                timeout: 2000,
                                pos: 'top-right'
                            });
                        }
                    }
                    else {
                        if (myFuncCalls == 0) {
                            myFuncCalls++;
                            $.ajax({
                                url: '<?php echo Yii::app()->createUrl('fileinfo/fileswaping', array('file_id' => $file_id, 'status' => $type))?>',
                                data: {fp_page_nums: pageNum, fp_category: catgry},
                                type: "POST",
                                success: function (result) {
                                    var obj = JSON.parse(result);
                                    if (obj.status == "S") {
                                        myFuncCalls = 0;
                                        if (obj.med !== '') {
                                            $('#medpg').focus();
                                        }
                                        $('#medpg').val(obj.med);
                                        if (obj.nonmed !== '') {
                                            $('#nonmedpg').focus();
                                        }
                                        $('#nonmedpg').val(obj.nonmed);

                                        radioval = $('input:radio[name=displayCheck]:checked').val();

                                        var newCustomPages = JSON.parse(customPages);
                                        var newCustomPagesLength = newCustomPages.length;
                                        if (newCustomPagesLength > 1) {
                                            indexPage = newCustomPages.indexOf(String(pageNum));
                                            if (indexPage !== newCustomPagesLength - 1) {
                                                renderindex = indexPage + 1;
                                            }
                                            else {
                                                if (radioval !== 'A') {
                                                    renderindex = indexPage - 1;
                                                }
                                                else {
                                                    renderindex = indexPage;
                                                }
                                            }
                                            pageNum = newCustomPages[parseInt(renderindex)];
                                            renderPage(parseInt(pageNum));
                                            if (parseInt(pageNum) === parseInt(newCustomPages[newCustomPagesLength - 1])) {
                                                if ($('.uk-notify').is(':visible') === false) {
                                                    UIkit.notify({
                                                        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> Reached last page!",
                                                        status: "error",
                                                        timeout: 1500,
                                                        pos: 'top-right'
                                                    });
                                                }
                                            }
                                        }
                                        else {
                                            $('#displayCheck_0').click();
                                        }


                                        if (radioval == 'A') {
                                            medicalvalue = $('#medpg').val();
                                            nonmedicalvalue = $('#nonmedpg').val();
                                            medicalarray = medicalvalue.split(',');
                                            nonmedicalarray = nonmedicalvalue.split(',');
                                            if (medicalvalue !== '' && nonmedicalvalue !== '') {
                                                medicaldres = medicalarray.concat(nonmedicalarray);
                                                medicaldres.sort(arrange);
                                                customPages = JSON.stringify(medicaldres);
                                            }
                                            else if (medicalvalue == '') {
                                                customPages = JSON.stringify(nonmedicalarray);
                                            }
                                            else if (nonmedicalvalue == '') {
                                                customPages = JSON.stringify(medicalarray);
                                            }
                                        }
                                        else if (radioval == 'M') {
                                            medicalvalue = $('#medpg').val();
                                            if (medicalvalue !== "") {
                                                medicalarray = medicalvalue.split(',');
                                                customPages = JSON.stringify(medicalarray);
                                            }
                                        }
                                        else if (radioval == 'N') {
                                            nonmedicalvalue = $('#nonmedpg').val();
                                            if (nonmedicalvalue !== '') {
                                                nonmedicalarray = nonmedicalvalue.split(',');
                                                customPages = JSON.stringify(nonmedicalarray);
                                            }
                                        }

                                    }
                                }
                            });
                        }
                    }
                }
				else if(e.which === 38 && e.ctrlKey){
					zooming('in');
				}
				else if(e.which === 40 && e.ctrlKey){
					zooming('out');
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
            });
        }
        return false;
    });


    //Modal Popup

    /*function quit() {
        $("#quitModal .uk-modal-header h3").html("Quit Description");
        $.ajax({
            url: '<?php //echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => 'IQ', 'jobId' => $jobId)) ?>',
            type: "post",
            success: function (result) {
                $("#quitModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }*/
    $('#sidebar_main_toggle').on('click', function () {
        var temp = $('#sidebar_main').width();


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
    /**
     * @Add FeedBack for Reviewer
     */
    function feedback() {
        $("#quitModal .uk-modal-header h3").html("FeedBack");
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('joballocation/feedback', array('id' => $jobId)) ?>',
            type: "post",
            data: {'status': 'I'},
            success: function (result) {
                $("#quitModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
				$('#JobAllocation_ja_qc_feedback').focus();
            }
        });

    }

    function CompleteQc() {
		if($('#medpg').val() !== ""){
			if($('.uk-modal').is(':visible') === false){
				id = <?php echo $jobId; ?>;
				UIkit.modal.confirm("Move to splitting?", function () {
					$.ajax({
						url: "<?php echo Yii::app()->createUrl('Joballocation/qualityupdate') ?>/" + id,
						type: "post",
						data: {status: 'IQC'},
						success: function (result) {
							var obj = JSON.parse(result);
							if (obj.status == "S" || obj.status == "U") {
								$('.uk-close')[0].click();
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
		else{
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
	
	function zooming(type){
		currentWidth = $('#the-canvas').width();
		if(type === 'in'){
			$('#the-canvas').width(currentWidth+20);
		}
		else{
			$('#the-canvas').width(currentWidth-20);
		}
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
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
   //qc from to page select
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
    function subtractarrays(array1, array2) {
        var difference = [];
        for (var i = 0; i < array1.length; i++) {
            if ($.inArray(array1[i], array2) == -1) {
                difference.push(array1[i]);
            }
        }
        return difference;
    }
    function updateclosedicon()
    {
        var fromv =isNaN(parseInt($("#from").val()))? 0 :parseInt($("#from").val()) ,
            tov = isNaN(parseInt($("#to").val()))? 0 :parseInt($("#to").val()) ;

        if(fromv ==0)
        {
            $("#from_error").text("From Cannot  be blank").show();
        }
        else if(tov ==0)
        {
            $("#to_error").text("To Cannot  be blank").show();
        }
        else if(fromv > tov)
        {
            $("#from_error").text("From page no should not be greater than To  ").show();
        }
        else if(parseInt($("#page_count").text()) < tov)
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
        var fromv =isNaN(parseInt($("#from").val()))? 0 :parseInt($("#from").val()) ,
            tov = isNaN(parseInt($("#to").val()))? 0 :parseInt($("#to").val()) ;
        if(fromv !=0 && tov !=0 )
        {
            closediconcheck();
        }
        else if(fromv ==0)
        {
            $("#from_error").text("From Cannot  be blank").show();
        }
        else if(tov ==0)
        {
            $("#to_error").text("To Cannot  be blank").show();
        }
        else if(fromv > tov)
        {
            $("#from_error").text("From page no should not be greater than To  ").show();
        }
        else if(parseInt($("#page_count").text()) < parseInt($("#to").val()))
        {

            $("#to_error").text("To page no should not be greater than Total Page  ").show();
        }
    }
    $(function () {
        setTimeout(function () {
            for (i = 1; i <= parseInt($("#page_count").text()); i++) {
                A.push(i);
            }
            var upmedical = $("#medpg").val();
            var upnonmedical = $("#nonmedpg").val();
            if (upmedical != '' && upnonmedical != "") {
                $("#update").show();
                $("#normal").hide();
            }
            else {
                $("#normal").show();
                $("#update").hide();
            }
        }, 3000);
    });

    function closediconcheck() {
        var selValue = $('input[name=rbnNumber]:checked').val()
        var fromv = parseInt($("#from").val()),
            tov = parseInt($("#to").val());
        $("#rangeclose").trigger("click");
        for (i = 1; i <= parseInt($("#page_count").text()); i++) {
            A.push(i);
        }
        if (selValue == 1) {
            var temp = [];
            for (j = fromv; j <= tov; j++) {
                B.push(j);
                B = unique(B);
                temp = B;
            }
            C = subtractarrays(C, temp);
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
            $('#medpg').focus();

        } else {
            for (j = fromv; j <= tov; j++) {
                C.push(j);
                C = uniquenon(C);
            }
            B = subtractarrays(B, C);
            B = B.sort(function (a, b) {
                return a - b;
            });
            newstfy = B.toString();
            srfy = C.toString();
            $("#nonmedpg").val(srfy);
            $('#nonmedpg').focus();
        }
        /*}*/
        $("#medpg").val(newstfy);
        text = '';
        newstfy = '';
        stfy = '';
        $from.val('');
        $to.val('');

    }
    function updateclosediconcheck() {
        var selValue = $('input[name=rbnNumber]:checked').val();
        var upmedical = $("#medpg").val();
        var upnonmedical = $("#nonmedpg").val();
        var fromv = parseInt($("#from").val()),
            tov = parseInt($("#to").val());
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
            $('#medpg').focus();

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
        $("#medpg").val(newstfy);
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
            if (!found) newArr.push(origArr[x]);
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
            if (!found) newArrnon.push(origArr[x]);
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
            if (!found) newArrupdate.push(origArrupdate[x]);
        }

        return newArrupdate;
    }
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
    }
    $(function () {
       /* $(document).keydown(function(event){
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
     //pdf magnifier

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
    });

</script>
<div id="raneselectModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Page Range select</h3>
            <button type="button" class="uk-modal-close uk-close" id="rangeclose" style="display: inline-block;float: right;color: #fff;background: #fff;" onChange="modelClose()"></button>
        </div>
        <div class="uk-width-medium-3-5">
            <input type="radio" id="medical" name="rbnNumber" value="1" checked style="display:inline !important;">Medical
            <input type="radio" id="nonmediacal" name="rbnNumber" value="2" style="display:inline !important;"> Non Medical
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
                    <button type="button" id="normal" class="md-btn" onclick="closedicon()" style="display:block">Save</button>
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

