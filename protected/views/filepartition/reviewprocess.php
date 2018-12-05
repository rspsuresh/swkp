<?php
$grid_id='';
$mpages = '';
$url = '';
$id = '';
$showlink = false;
if (isset($_GET['id'])) {
    $query = FilePartition::model()->findByPk($_GET['id']);
    if ($query) {
        $id = $query->fp_file_id;
        $grid_id = $query->fp_part_id;
        $explodepages = explode(',', $query->fp_page_nums);
        $mpages = json_encode($explodepages);
        if (isset($query->FileInfo->fi_file_name)) {
            $url = Yii::app()->baseUrl . '/plugin/' . $query->FileInfo->fi_file_name;
        }
        $count=count($explodepages);
        if ($count!=0) {
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
                <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon waves-effect waves-button waves-light" href="<?php echo Yii::app()->createUrl('fileinfo/indexinglist') ?>">
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
        <div class="uk-grid" id="indexdiv">
            <div class="uk-width-medium-3-6">
                <canvas id="the-canvas" style="border:1px solid black;width:100%"></canvas>
            </div>
            <div class="uk-width-medium-3-6">
                <div class="md-card" style="border:1px solid black;">
                    <div class="md-card-content">
                        <h3 class="heading_a" style="text-align:center ">Review Processing</h3>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'review-process-form',
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
                                <?php echo $form->labelEx($model, 'pos'); ?>
                                <?php echo $form->textField($model, 'pos', array('class' => "md-input")); ?>
                                <?php echo $form->error($model, 'pos'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php echo $form->labelEx($model, 'dos'); ?>
                                <?php echo $form->textField($model, 'dos', array('class' => "md-input","data-uk-datepicker" => "{format:'DD-MM-YYYY'}",'readonly'=>true)); ?>
                                <?php echo $form->error($model, 'dos'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php echo $form->labelEx($model, 'patient_name'); ?>
                                <?php echo $form->textField($model, 'patient_name', array('class' => "md-input")); ?>
                                <?php echo $form->error($model, 'patient_name'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php echo $form->labelEx($model, 'pages'); ?>
                                <?php echo $form->textArea($model, 'pages', array('class' => "md-input label-fixed  ")); ?>
                                <?php echo $form->error($model, 'pages'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <?php //echo $form->labelEx($model, 'description'); ?>
                                <?php echo $form->textArea($model, 'description', array('class' => "md-input")); ?>
                                <?php echo $form->error($model, 'description'); ?>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin="">
                            <div class="uk-width-medium-1-1 ">
                                <!---<button class="md-btn md-btn-primary" onclick="saveIndexing()">SAVE</button>-->
                                <?php echo CHtml::submitButton('Save', array('class' => 'md-btn md-btn-success')); ?>
                                <?php echo CHtml::button('Complete', array('class' => 'md-btn md-btn-success', 'onclick' => 'completeFile()')); ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- for legacy browsers add compatibility.js -->
<!--<script src="../compatibility.js"></script>-->
<script src="<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.js' ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/themes/rapid_theme/altair_file/bower_components/ckeditor/ckeditor.js'?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/themes/rapid_theme/altair_file/bower_components//ckeditor/adapters/jquery.js'?>"></script>
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
        $('#ReviewProcess_description').ckeditor();
        $('#indexdiv').attr('tabindex', -1).focus(function () {
            $(document).unbind().keyup(function (e) {
                if (e.which === 39 && e.ctrlKey) {
                    var pgnos = [];
                    var nextPage = onNextPage("add");
                    if ($('#ReviewProcess_pages').val() != "") {
                        pgnos = $('#ReviewProcess_pages').val().split(',');
                    }
                    if (pgnos.indexOf(nextPage.toString()) == -1) {
                        pgnos.push(nextPage);
                        /* pgnos = pgnos.map(function (x) {
                         return parseInt(x, 10);
                         });*/
                        //pgnos.sort();
                        pgnos.sort(sortNumber);
                    }
                    $('#ReviewProcess_pages').val(pgnos);
                }
                else if (e.which === 37 && e.ctrlKey) {
                    var prevPage = onPrevPage("remove");
                    var splitval = $('#ReviewProcess_pages').val().split(',');
                    var index = splitval.indexOf(prevPage.toString());
                    if (index > -1) {
                        splitval.splice(index, 1);
                    }
                    $('#ReviewProcess_pages').val(splitval);
                }
                else if (e.which === 37) {
                    onPrevPage("prev");
                }
                else if (e.which === 39) {
                    onNextPage("next");
                }
            });
        });
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
                url: '<?php echo Yii::app()->createUrl('fileinfo/filesplit', array('id' => $id)) ?>',
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
                url: '<?php echo Yii::app()->createUrl('fileinfo/completefile', array('id' => $_GET['id'], 'status' => 'SC')); ?>',
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
                            window.location.href = '<?php echo Yii::app()->createUrl('fileinfo/splitalloc'); ?>';
                        }, 3000);
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
        var curl = "<?php echo Yii::app()->createUrl('filepartition/splitview', array('id' => $grid_id))?>";
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
