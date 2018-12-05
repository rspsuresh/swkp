<?php
$mpages = '';
$url = '';
$id = '';
$pojectId = '';
$showlink = false;
$oldpagetext = '';
$jobId = '';
if (isset($_GET['id']) && isset($_GET['status'])) {
    $query = FilePartition::model()->findByPk($_GET['id']);
    if ($query) {
        $id = $query->fp_file_id;
        //File info Program
        $proId = $query->FileInfo->fi_pjt_id;
        if ($_GET['status'] == 'R') {
            $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $query->fp_file_id, 'ja_status' => "SA"));
        } else {
            //$model->fp_cat_id=$query->fp_cat_id;
            $old_cat_id = $query->fp_cat_id;
            $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $query->fp_file_id, 'ja_status' => "SQP"));
            //$oldpagetext = $query->fp_page_nums;
        }
        $jobId = $job_model->ja_job_id;
        $pojectId = isset($query->FileInfo->ProjectMaster->p_category_ids) ? $query->FileInfo->ProjectMaster->p_category_ids : '';
        //$getExplode=explode(',',$pojectId);
        $explodepages = explode(',', $query->fp_page_nums);
        $mpages = json_encode($explodepages);
        if (isset($query->FileInfo->fi_file_ori_location)) {
            $url = Yii::app()->baseUrl . '/' . $query->FileInfo->fi_file_ori_location;
            //$url = Yii::app()->baseUrl . '/plugin/' . $query->FileInfo->fi_file_name;
        }
        $partationQuery = FilePartition::model()->findAllByAttributes(array('fp_file_id' => $id), array('condition' => 'fp_category="" and  fp_cat_id!=""'));
        if ($partationQuery) {
            $showlink = true;
        }

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Previous/Next example</title>
</head>
<body>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-3-6">
                <a id="prev" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                    <i class="uk-icon-chevron-circle-left" style="color: white"></i>
                    Previous
                </a>
                <a id="next" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                    <i class="uk-icon-chevron-circle-right" style="color: white"></i>
                    Next
                </a>
                <!--<a id="zoomin" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                    <i class="uk-icon-search-plus" style="color: white"></i>
                    Zoom In
                </a>
                <a id="zoomout" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                    <i class="uk-icon-search-minus" style="color: white"></i>
                    Zoom In
                </a>-->
                <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="<?php echo $url; ?>" target="_blank">
                    <i class="uk-icon-file-pdf-o" style="color: white"></i>
                    PDF
                </a>
                <?php
                if ($showlink) {
                    ?>
                    <a class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" onclick='userCreate()' href="javascript:void(0)" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'bottom'}" title="Splited Pages"><i class="uk-icon-folder-open-o" style="color: white"></i></a>
                    <?php
                }
                ?>
            </div>
            <div class="uk-width-medium-3-6">
                <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="<?php echo Yii::app()->createUrl('filepartition/splitalloc') ?>">
                    <i class="uk-icon-chevron-circle-left" style="color: white"></i>
                    Back
                </a>
                <!-- <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                 <input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="4" min="1" tabindex="15">
                 <a id="pagesearch" class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="javascript:void(0)">
                     <i class="uk-icon-search" style="color: white"></i>
                 </a>-->
                <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>

            </div>
        </div>
        <?php if ($_GET['status'] == 'R') { ?>
            <div class="uk-grid" id="indexdiv">
                <div class="uk-width-medium-3-6">
                    <canvas id="the-canvas" style="border:1px solid black;width:100%"></canvas>
                </div>
                <div class="uk-width-medium-3-6">
                    <div class="md-card" style="border:1px solid black;">
                        <div class="md-card-content">
                            <h3 class="heading_a" style="text-align:center ">Page Number With Category</h3>
                            <!---  <div id="indexpageno" style="width:50%;height:680px;float: left;">-->
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
                                <div class="uk-width-medium-1-1 ">
                                    <?php //echo $form->labelEx($model, 'fp_page_nums'); ?>
                                    <?php echo $form->textArea($model, 'fp_page_nums', array('class' => "md-input", 'value' => $oldpagetext)); ?>
                                    <?php echo $form->hiddenField($model, 'fp_file_id', array('class' => "md-input", 'value' => $id)); ?>
                                    <?php echo $form->hiddenField($model, 'fp_job_id', array('class' => "md-input", 'value' => $jobId)); ?>
                                    <?php echo $form->error($model, 'fp_page_nums'); ?>

                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-medium-1-1 ">
                                    <?php echo $form->labelEx($model, 'fp_cat_id'); ?>
                                    <?php echo $form->dropDownList($model, 'fp_cat_id', CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and ct_cat_id IN($pojectId)")), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category')); ?>
                                    <?php echo $form->error($model, 'fp_cat_id'); ?>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-medium-1-1 ">
                                    <!---<button class="md-btn md-btn-primary" onclick="saveIndexing()">SAVE</button>-->
                                    <?php echo CHtml::submitButton('Save', array('class' => 'md-btn md-btn-success')); ?>
                                    <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-danger', 'onclick' => 'completeFile()')); ?>
                                    <?php echo CHtml::button('Quit', array('class' => 'md-btn md-btn-warning', 'onclick' => 'quitFile()')); ?>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="uk-grid" id="indexdiv">
                <div class="uk-width-medium-3-6">
                    <canvas id="the-canvas" style="border:1px solid black;width:100%"></canvas>
                </div>
                <div class="uk-width-medium-3-6">
                    <div class="md-card" style="border:1px solid black;">
                        <div class="md-card-content">
                            <h3 class="heading_a" style="text-align:center ">Move This Page To</h3>
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
                                <div class="uk-width-medium-1-1 ">
                                    <?php //echo $form->labelEx($model, 'fp_page_nums'); ?>
                                    <?php echo CHtml::hiddenField('old_cat_id', $old_cat_id, array('class' => 'md-input')); ?>
                                    <?php echo CHtml::hiddenField('curnt_page', '', array('class' => 'md-input')); ?>
                                    <?php //echo $form->textArea($model, 'fp_page_nums', array('class' => "md-input",'value'=>$oldpagetext)); ?>
                                    <?php echo $form->hiddenField($model, 'fp_file_id', array('class' => "md-input", 'value' => $id)); ?>
                                    <?php echo $form->hiddenField($model, 'fp_job_id', array('class' => "md-input", 'value' => $jobId)); ?>
                                    <?php echo $form->error($model, 'fp_page_nums'); ?>

                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-medium-1-1 ">
                                    <?php echo $form->labelEx($model, 'fp_cat_id'); ?>
                                    <?php echo $form->dropDownList($model, 'fp_cat_id', CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A' and ct_cat_id IN($pojectId)")), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category')); ?>
                                    <?php echo $form->error($model, 'fp_cat_id'); ?>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin="">
                                <div class="uk-width-medium-1-1 ">
                                    <?php echo CHtml::submitButton('Save', array('class' => 'md-btn md-btn-success')); ?>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- for legacy browsers add compatibility.js -->
<!--<script src="../compatibility.js"></script>-->
<script src="<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.js' ?>"></script>
<script id="script">
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
        customPages = '<?php echo $mpages; ?>',
        page = 0
    ;
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
        if (document.getElementsByName("curnt_page").length !== 0) {
            document.getElementsByName("curnt_page")[0].value = pageNum;
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

//                if (pageNum < 1) {
//                    return;
//                }
//                pageNum--;
//                queueRenderPage(pageNum);
//                return pageNum + 1;
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);
    /**
     * Displays next page.
     */
    function onNextPage(mode) {
//                if (mode == "add") {

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
//                }
//                else if(mode == "next"){
//                    if (pageNum >= pdfDoc.numPages) {
//                        return;
//                    }
//                    pageNum++;
//                    queueRenderPage(pageNum)
//                    return pageNum - 1;
//                }
    }
    document.getElementById('next').addEventListener('click', onNextPage);
    /**
     * Displays Search page.
     */
    /* function Search() {
     var pageNo = parseInt($('#pageNumber').val());
     if (pageNo < pdfDoc.numPages && pageNo < 0) {
     return;
     }
     queueRenderPage(pageNo)
     pageNum = pageNo;
     return pageNum;
     }
     document.getElementById('pagesearch').addEventListener('click', Search);

     function onZoomIn() {
     pdfScale = parseFloat(pdfScale) + 0.25;
     zoom(pageNum);
     }
     document.getElementById('zoomin').addEventListener('click', onZoomIn);

     function onZoomOut() {
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
        // Initial/first page rendering
//                console.log(pageNum);
//                console.log(JSON.parse(customPages));
        if (customPages != undefined) {
            var partitionPages = JSON.parse(customPages);
            pageNum = Number(partitionPages[0]);
            renderPage(Number(partitionPages[0]));
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
        document.body.appendChild(canvas1);

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
    $(document).on('ready', function () {
        $("select[name='FilePartition[fp_cat_id]'").chosen();
        $('#indexdiv').attr('tabindex', -1).trigger('focus');
        if ($('#indexdiv').attr('tabindex', -1).is(":focus")) {
//        $('#indexdiv').attr('tabindex', -1).focus(function () {
            $(document).unbind().keyup(function (e) {
                if (e.which === 39 && e.ctrlKey) {
                    var pgnos = [];
                    var nextPage = onNextPage("add");
                    if ($('#FilePartition_fp_page_nums').length !== 0) {
                        if ($('#FilePartition_fp_page_nums').val() != "") {
                            pgnos = $('#FilePartition_fp_page_nums').val().split(',');
                        }
                        if (pgnos.indexOf(nextPage.toString()) == -1) {
                            pgnos.push(nextPage);
                            /* pgnos = pgnos.map(function (x) {
                             return parseInt(x, 10);
                             });*/
                            //pgnos.sort();
                            pgnos.sort(sortNumber);
                        }
                        $('#FilePartition_fp_page_nums').val(pgnos);
                    }
                }
                else if (e.which === 37 && e.ctrlKey) {
                    var prevPage = onPrevPage("remove");
                    if ($('#FilePartition_fp_page_nums').length !== 0) {
                        var splitval = $('#FilePartition_fp_page_nums').val().split(',');
                        var index = splitval.indexOf(prevPage.toString());
                        if (index > -1) {
                            splitval.splice(index, 1);
                        }
                        $('#FilePartition_fp_page_nums').val(splitval);
                    }
                }
                else if (e.which === 37) {
                    onPrevPage("prev");
                }
                else if (e.which === 39) {
                    onNextPage("next");
                }
            });
        }
        ;
        return false;
    });


    /**
     * @ Sort Function
     */
    function sortNumber(num1, num2) {
        return num1 - num2;
    }
    //USer form
    function saveUserForm(form, data, hasError) {
        if (!hasError) {
            var formdata = new FormData($('#file-partition-form')[0]);
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/filesplit', array('id' => $id, 'status' => $_GET['status'])) ?>',
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
                    }
                    else if (obj.status == "M") {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                        customPages = obj.pages;
                        customPagesNew = JSON.parse(customPages);
                        pageNum = parseInt(customPagesNew[0]);
                        queueRenderPage(pageNum);
                    }
                    else if (obj.status == "N") {
                        window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>?showMsg=' + obj.msg;
                    }
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
        $('#FilePartition_fp_cat_id').val('').trigger('chosen:updated');
    }
    /**
     * Complete Form
     */
    function completeFile() {
        UIkit.modal.confirm("Are you sure, you want to complete the file?", function () {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/completefile', array('id' => $_GET['id'], 'mode' => 'S', 'projectId' => $proId, 'jobId' => $jobId, 'status' => false)); ?>',
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
     * @Quit file
     */
    function quitFile() {
        UIkit.modal.confirm("Are you sure, you want to Quit the file?", function () {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl('fileinfo/quitfile', array('id' => $_GET['id'], 'status' => 'SQ', 'jobId' => $jobId)); ?>',
                type: "post",
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
                            window.location.href = '<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>';
                        }, 2000);
                    }
                }
            });
        });
    }
    /**
     * @Update Popup Form
     */
    function userCreate() {
        $("#userModal .uk-modal-header h3").html("Split View");
        var curl = "<?php echo Yii::app()->createUrl('fileinfo/splitview', array('id' => $id))?>";
        $.ajax({
            url: curl,
            type: "post",
            success: function (result) {
                $("#userModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    $('#userModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#userModal .uk-modal-header h3").html("");
            $("#userModal .uk-modal-content").html("");
        }
    });
</script>
<div id="userModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#userModal'}" style="display: none;"></button>
</body>
</html>