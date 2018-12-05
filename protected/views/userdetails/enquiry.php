<?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
<link href="<?php echo $path; ?>assets/js/custom/select2/select2.min.css" rel="stylesheet"/>
<script src="<?php echo $path; ?>assets/js/custom/select2/select2.full.min.js"></script><link rel="stylesheet" href="<?php echo $path . "bower_components/uikit/css/uikit.almost-flat.min.css"; ?>"
                                                                                              <link rel="stylesheet" href="<?php echo $path . "bower_components/uikit/css/uikit.almost-flat.min.css"; ?>"
                                                                                              media="all"> 
<link rel="stylesheet" href="<?php echo $path . "assets/js/Anotify/Anotify.css"; ?> " media="all">


<style>
    .error > .errorMessage, .errorMessage, label > span.required {
        color: #fb4646;
    }
    .btn-primary {
        width: 100%;
    }
    .centrebtn {
        text-align: center;
    }
    table{
        width: 100%;
    }
    table td{
        padding: 10px;
    }

    //modal
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        height: 300px;
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s;
        max-height: 500px;
        overflow: scroll;
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:-300px; opacity:0} 
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:-300px; opacity:0}
        to {top:0; opacity:1}
    }

   

    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    .modal{position: absolute !important;
           padding-top: 10% !important;
           height: 100% !important;
           width: 100% !important;
           z-index: 9999 !important;
           overflow: visible !important;}
    .modal-content{overflow:auto !important; max-height: none !important;}
    .modal-header {
        padding: 2px 16px;
        background-color: #1871cd;
        color: white;
    }

    .modal-body {padding: 0px 15px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #1871cd;
        color: white;
    }   
    #overlayfade{
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: rgba(0,0,0,0.5);	
        display:none;
    }
    #submit_enquiry {
        color: #fff !important;
        border-color: #0D47A1 !important;
        background: #2196F3 !important;   
        height: 40px;
    }
    .modal-header .close {    
        opacity: 0.9 !important;
        color: #fff;
        border-radius: 20px;
        border: 2px solid;
        border-color: #fff;
        padding-left: 6px;
        padding-right: 6px;
    }

</style>

<div id="overlayfade"></div>

<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content" >
        <!--        <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#">Price Chart</a>
                             <span class="close">&times;</span>
                        </div>
                    </div>
                </nav>-->
        <div class="modal-header">
            <div>
                <span class="close">&times;</span>
                <h2 style="color:#fff">Price Chart</h2>
            </div>
        </div>
        <div class="modal-body">
        </div>
    </div>

</div>

<div class="wrapper" style="padding-top: 120px;">
    <section id="support" class="doublediagonal">
        <div class="container" style="width:50%;">
            <div class="section-heading scrollpoint sp-effect3">
                <h2>Enquiry</h2>
            </div>
            <?php
            $form1 = $this->beginWidget('CActiveForm', array(
                'id' => 'user-details-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                    'afterValidate' => 'js:function(form, data, hasError) { saveForm(form, data, hasError); }',
                )
            ));
            ?>
            <div>
                <div class="row">
                    <!--                    <div class="col-md-12">
                                            <div class="row">-->
                    <div class="col-md-8 col-sm-8 col-sm-offset-2 scrollpoint sp-effect1">
                        <!--<form role="form">-->
                        <div class="form-group">
                            <?php echo $form1->labelEx($model, 'cd_file_in_format'); ?>
                            <?php echo $form1->dropDownList($model, 'cd_file_in_format', array('xls' => 'xls', 'pdf' => 'pdf'), array("class" => "form-control", 'multiple' => true)); ?>
                            <?php echo $form1->error($model, 'cd_file_in_format'); ?>
                            <!--<input type="text" class="form-control" placeholder="Your name">-->
                        </div>
                        <div class="form-group">
                            <?php echo $form1->labelEx($model, 'cd_file_out_format'); ?>
                            <?php echo $form1->dropDownList($model, 'cd_file_out_format', array('csv' => 'csv', 'txt' => 'txt'), array("class" => "form-control", 'multiple' => true)); ?>
                            <?php echo $form1->error($model, 'cd_file_out_format', "", false); ?>
                            <!--<input type="email" class="form-control" placeholder="Your email">-->
                        </div>
                        <div class="form-group">
                            <?php echo $form1->labelEx($model, 'cd_hours'); ?>
                            <?php echo $form1->dropDownList($model, 'cd_hours', array(12 => 12, 24 => 24), array("class" => "form-control", 'multiple' => true)); ?>
                            <?php echo $form1->error($model, 'cd_hours', "", false); ?>
                            <!--<input type="email" class="form-control" placeholder="Your email">-->
                        </div>
                        <div class="form-group">
                            <?php echo CHtml::submitButton('Submit', array('id' => 'submit_signup', 'class' => 'btn btn-primary btn-lg')); ?>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
    </section>
    <button id="myBtn" style="display: none">Open Modal</button>
    <div id="Atoast" class="Atoastanimate">
        <div>
            <span id="ATInnerSpan"></span>
            <a href="javascript:void(0)" class="notify-action" id="ATanchor"><i class="uk-icon-close"></i></a> 
        </div>
    </div>
</div>
<script src="<?php echo $path . "assets/js/Anotify/Anotify.js"; ?>"></script>
<script>
    $(document).ready(function () {
        appMaster.preLoader();
<?php if (!empty($_GET["showMsg"])) : ?>
            window.history.pushState("", "", window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
            AUIkit.init(document.getElementById('Atoast'), "Enquiry Submitted Successfully!", 'success', '5000');
<?php endif; ?>
    });

//    document.getElementsByClassName('toast').style.display = block';
    function saveForm(form, data, hasError) {
        if (hasError == false) {
            $.ajax({
                url: ' <?php echo Yii::app()->createUrl("userdetails/enquiry"); ?> ',
                type: "POST",
                data: $("#user-details-form").serialize(),
                success: function (result) {
                    $('.modal-body').html(result);
                    $('#myBtn').trigger('click');
//                    var obj = JSON.parse(result);
//                    if (obj.status == "S") {
//                        window.location.href = '<?php // echo Yii::app()->createUrl('site/login');                       ?>'
//                        UIkit.notify({
//                            message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> " + obj.msg,
//                            status: "success",
//                            timeout: 10000,
//                            pos: 'top-right'
//                        });
//                    }
                }
            });
        }
    }
//    $('#submit_signup').click(function (e) {
//       e.preventDefault();
//        $.ajax({
//            url: ' <?php // echo Yii::app()->createUrl("userdetails/enquiry");                   ?> ',
//            type: "POST",
//            data: $("#user-details-form").serialize(),
//            success: function (response) {
//                $('.modal-body').html(response);
//                $('#myBtn').trigger('click');
//            }
//        });
//    });
    var modal = document.getElementById('myModal');

// Get the button that opens the modal
    var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
    btn.onclick = function () {
        modal.style.display = "block";
        $("#overlayfade").show();
    }

// When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
        $("#overlayfade").hide();
    }

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    $("#ClientDetails_cd_file_in_format").select2();
    $("#ClientDetails_cd_file_out_format").select2();
    $("#ClientDetails_cd_hours").select2();

//    UIkit.notify({
//        message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> asasasasasas",
//        status: "success",
//        timeout: 10000,
//        pos: 'top-right'
//    });
<?php /* if(isset($tempArray)) { ?>
  $('#submit_enquiry').click(function (e) {
  e.preventDefault();
  //        console.log($('#user-details-form')[0].reset()));
  //         $('#user-details-form').reset;
  return false;
  $.ajax({
  url: ' <?php echo Yii::app()->createUrl("userdetails/submitenquiry"); ?> ',
  type: "POST",
  data: {enquiry: '<?php echo json_encode($tempArray); ?>',
  cli_email: $('#cli_email').val(),
  cli_name: $('#cli_name').val()},
  success: function (response) {
  $('.close').trigger('click');

  UIkit.notify({
  message: "<a href='#' class='notify-action'><i class='uk-icon-close'></i></a> asasasasasas",
  status: "success",
  timeout: 10000,
  pos: 'top-right'
  });
  }
  });
  });
  <?php } */ ?>
</script>
</body>

</html>
