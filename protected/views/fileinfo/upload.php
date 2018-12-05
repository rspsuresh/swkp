<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - About';
$this->breadcrumbs = array(
    'About',
);
?>  
<style>
    .chosen-drop{
        color:#444;
    }
</style>
<?php
if (Yii::app()->session['user_type'] == "C") {
    $data = Project::model()->findAll(array('condition' => "p_flag ='A' and p_client_id='" . Yii::app()->session['user_id'] . "' order by p_name asc"));
} else {
    $data = Project::model()->findAll(array('condition' => "p_flag ='A' order by p_name asc"));
}
?>
<div class="md-card">
    <div class="md-card-content">
        <h3 class="heading_a">
            File Upload
        </h3>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'upload-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'afterValidate' => 'js:function(form, data, hasError) { afterValidation(form, data, hasError) }',
            ),
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>
        <div class="uk-grid">
            <div class="uk-width-1-1">

                <div id="file_upload-drop" class="uk-file-upload">
                    <div class="uk-width-1-5" style="margin:auto;padding:10px">
                        <?php // echo $form->labelEx($model, 'fi_pjt_id');  ?>
                        <?php
                        //echo $form->dropDownList($model, 'fi_pjt_id', CHtml::listData(Project::model()->findAll(array('condition' => "p_flag ='A' order by p_name asc")), 'p_pjt_id', 'p_name'), array("prompt" => "Select Project"));
                        echo $form->dropDownList($model, 'fi_pjt_id', CHtml::listData($data, 'p_pjt_id', 'p_name'), array("prompt" => "Select Project"));
                        ?>
                        <?php echo $form->error($model, 'fi_pjt_id'); ?>
                    </div>
                    <div>
                        <input type="radio" name="filetype" value="S" checked=true  onchange="changeInputType($(this))"/>Single
                        <input type="radio" name="filetype" value="F" onchange="changeInputType($(this))"/>Folder
                    </div>
                    <p class="uk-text" style="color:#444;">Drop file to upload</p>
                    <p class="uk-text-muted uk-text-small uk-margin-small-bottom">or</p>
                    <!--<a class="uk-form-file md-btn">choose file<input id="file_upload-select" type="file" onchange="atrt(this, event)"></a>-->
                    <!--                    <a class="uk-form-file md-btn">choose file
                                            <input onchange="atrt(this, event)"
                                                   name="FileInfo[fi_file_name]" id="FileInfo_fi_file_name" type="file"
                                                   accept=".tif,.pdf"/>
                                        
                    
                    <?php //echo $form->fileField($model, 'fi_file_name', array('onchange' => 'atrt(this, event)'));  ?></a>-->
                    <a class="uk-form-file md-btn">choose file
                        <input onchange="atrt(this, event)"
                               name="FileInfo[fi_file_name][]" id="FileInfo_fi_file_name" type="file"  multiple
                               accept=".tif,.pdf"  />

                        <?php //echo $form->fileField($model, 'fi_file_name', array('onchange' => 'atrt(this, event)'));  ?></a>
                    <span id="file" class="uk-text-muted uk-text-small uk-margin-small-bottom"></span>
                    <?php echo $form->error($model, 'fi_file_name'); ?>
                    <p style="padding: 25px;"><button class="md-btn md-btn-primary" type="submit">Upload</button></p>
                    <!--<p style="padding: 25px;"><button class="md-btn md-btn-primary" onclick="fileUpload(event)">Upload</button></p>-->
                </div>
                <div id="file_upload-progressbar" class="uk-progress uk-hidden">
                    <div class="uk-progress-bar" style="width:0">0%</div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div id="selectedFiles"></div>
<!--<div class="uk-notify uk-notify-top-right" style="display: none;">
    <div class="uk-notify-message">
        <a class="uk-close"></a>
        <div id="alert_msgg"></div>
    </div>
</div>-->
<!--<div class="uk-notify uk-notify-top-right" style="display: none;"></div>-->
<script src="<?php echo Yii::app()->baseUrl . '/plugin/build/pdf.js' ?>"></script>
<script>
//    $(document).on('ready', function () { #444444
   var folderName = "";
    function atrt(t, event) {
        var filename = t.value;
        filename = filename.slice(12);
        $('span#file').html(filename);
        prepareUpload(event);
    }
    function prepareUpload(event)
    {
        files = event.target.files;
        folderName  = files[0]['webkitRelativePath'].split("/");
        folderName  = folderName[0];
    }
    $(document).ready(function () {
        $("#FileInfo_fi_pjt_id").chosen();
    });
    var msg;
    function afterValidation(form, data, hasError) {
        if (!hasError) {
            var formdata = new FormData($('#upload-form')[0]);
            formdata.append("folderName",folderName);
            $.ajax({url: '<?php echo Yii::app()->createUrl('fileinfo/uploadfile'); ?>' + "?pid=" + $('#FileInfo_fi_pjt_id').val(),
                data: formdata,
                //test: $('#upload-form').serialize(),
                type: "POST",
                contentType: false,
                cache: false,
                processData: false,
				global: false,
                success: function (result) {
                    var obj = JSON.parse(result);
                    if (obj.status == "S" || obj.status == "U") {
                        /*$('body').css({opacity: 1});
                        $('.pre-loader-div').hide();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });*/
						var totalpages = "";
						PDFJS.getDocument(obj.path).then(function(pdf) {
							  totalpages = pdf.numPages;

						});
						setTimeout(function () {
							upid = obj.upid;
							$.ajax({
								url: "<?php echo Yii::app()->createUrl('fileinfo/pagecount') ?>/" + upid,
								type: "post",
								data: {tot: totalpages},
								global: false,
								success: function (result) {
									$('body').css({opacity: 1});
									$('.pre-loader-div').hide();
									var objc = JSON.parse(result);
									if (objc.status == "S") {
										$('.uk-close')[0].click();
										UIkit.notify({
											message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + objc.msg,
											status: "success",
											timeout: 10000,
											pos: 'top-right'
										});
									}
								}
							});
						}, 2000);
                    }
                    else if (obj.status == "I")
                    {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });
                    }
                    else if (obj.status == "LG")
                    {
                        $('.uk-close')[0].click();
                        UIkit.notify({
                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
                            status: "success",
                            timeout: 10000,
                            pos: 'top-right'
                        });

                        window.location.href = '<?php echo Yii::app()->createUrl('/site/login?ajaxtimeout=timeout')?>';
                    }
                    $('#FileInfo_fi_pjt_id').val('').trigger('chosen:updated');
                    $('#FileInfo_fi_file_name').val("");
                    $('#file').html("");
                   // $('.uk-notify').show();
                    $('.alert_msgg').html(msg);
                    setTimeout(function () {
                        $('.uk-notify').hide();
                    }, 5000);
                },
				beforeSend:function(){
					$('body').css({opacity: 0.4});
					$('.pre-loader-div').show();   
				},
            });
        }
        return false;
    }
//    changeInputType();
    function changeInputType($this) {
        if ($this != undefined && $this.val() == "F") {
            $('#file_upload-drop > a:first > input').attr("webkitdirectory","").attr("directory","");
        }
        else if ($this == undefined || ($this != undefined && $this.val() == "S")) {
            $('#file_upload-drop > a:first > input').removeAttr("webkitdirectory","").removeAttr("directory","");
        }
    }
</script>

<script>
//    var selDiv = "";
//
//    document.addEventListener("DOMContentLoaded", init, false);
//
//    function init() {
//        document.querySelector('#FileInfo_fi_file_name').addEventListener('change', handleFileSelect, false);
//        selDiv = document.querySelector("#selectedFiles");
//    }
//
//    function handleFileSelect(e) {
//
//        if (!e.target.files)
//            return;
//
//        selDiv.innerHTML = "";
//
//        var files = e.target.files;
//        for (var i = 0; i < files.length; i++) {
//            var f = files[i];
//
//            selDiv.innerHTML += f.name + "<span><a href='javascript:void(0)'></a><span><br/>";
//
//        }
//        console.log($("#FileInfo_fi_file_name")[0].files);
//
//    }
</script>

