<!doctype html>
<!--[if lt IE 7]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->

    <head>
        <meta charset="UTF-8">
        <title>KPWS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="shortcut icon" href="favicon.png">
        <?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
        <link rel="stylesheet" href="<?php echo $path . "assets/js/Anotify/Anotify.css"; ?> " media="all">


        <!-- Bootstrap 3.3.2 -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/bootstrap.min.css" ?>">

        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/animate.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/font-awesome.min.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/slick.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/rs-plugin/css/settings.css" ?>">

        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/styles.css" ?>">


        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/modernizr.custom.32033.js" ?>"></script>

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            header .navbar:not(.scrolled) {
                background: #2196F3;
                /* Old browsers */
                background: -moz-linear-gradient(-45deg, #66cdcc 0%, #336799 100%);
                /* FF3.6+ */
                background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, #2196F3), color-stop(100%, #0D47A1));
                /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(-45deg, #2196F3 0%, #0D47A1 100%);
                /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(-45deg, #66cdcc 0%, #336799 100%);
                /* Opera 11.10+ */
                background: -ms-linear-gradient(-45deg, #66cdcc 0%, #336799 100%);
                /* IE10+ */
                background: linear-gradient(-45deg, #2196F3 0%, #0D47A1 100%);
                /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#66cdcc, endColorstr=#336799, GradientType=1);
                /* IE6-9 fallback on horizontal gradient */
            }
        </style>
    </head>

    <body>

        <!--<div class="pre-loader">
            <div class="load-con">
                <img src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/img/freeze/logo.png"; ?>" class="animated fadeInDown" alt="">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
        </div>-->

        <header>
            <?php include_once ('site_menus.php'); ?>
        </header>

        <?php echo $content; ?>


        <div class="wrapper">
            <footer>
                <div class="container">
                    <a href="#" class="scrollpoint sp-effect3">
                        <img src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/img/freeze/logo.png"; ?>" alt="" class="logo">
                    </a>
                    <div class="social">
                        <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-twitter fa-lg"></i></a>
                        <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-google-plus fa-lg"></i></a>
                        <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-facebook fa-lg"></i></a>
                    </div>
                    <div class="rights">
                        <p>Copyright &copy; 2014</p>
                        <p>Template by <a href="http://rapidcareitservics.com" target="_blank">Rapid Care IT Services</a></p>
                    </div>
                </div>
            </footer>



        </div>
        <div id="Atoast" class="Atoastanimate">
            <div>
                <span id="ATInnerSpan"></span>
                <a href="javascript:void(0)" class="notify-action" id="ATanchor"><i class="uk-icon-close"></i></a>
            </div>
        </div>
        <script src="<?php echo $path . "assets/js/Anotify/Anotify.js"; ?>"></script>
        <!--        <script src="<?php //echo Yii::app()->baseUrl . "/Oleose-master/assets/js/jquery-1.11.1.min.js"  ?>"></script>-->
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/bootstrap.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/slick.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/placeholdem.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/rs-plugin/js/jquery.themepunch.plugins.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/waypoints.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/scripts.js" ?>"></script>
        

        <script>
            $(document).ready(function () {
//                jqueryFunc = {
//                    columnShowHide: function () {
//                        $("#showColumn > li").each(function (index) {
//                            index = index + 1;
//                            if ($(this).hasClass('show') || $(this).hasClass('ignore'))
//                                $("table.items tr td:nth-child(" + index + "), table.items tr th:nth-child(" + index + ")").show();
//                            else
//                                $("table.items tr td:nth-child(" + index + "), table.items tr th:nth-child(" + index + ")").hide();
//                        });
//                    },
//                    tabChange: function () {
//                        var _gridId = $(".grid-view").attr("id");
//                        var _tableIndex = '';
//                        var columnShow;
//                        var allReadyChecked;
//                        $("table.items tr th").each(function (index) {
//                            var classes = $(this).attr('class');
//                            columnShow = '';
//                            allReadyChecked = '';
//                            switch (classes) {
//                                case "show":
//                                {
//                                    columnShow = "show selected-item";
//                                    allReadyChecked = "checked";
//                                    _tableIndex += "<li class='" + columnShow + "' id='" + index + "'><input type='checkbox' name='checkbox_demo' id='checkbox_demo" + index + "' data-md-icheck " + allReadyChecked + " />&nbsp;&nbsp; " + $(this).text() + "</li>";
//                                    break;
//                                }
//                                case "ignore":
//                                {
//                                    _tableIndex += "<li class='ignore' id='" + index + "'  style='display: none;'>&nbsp;&nbsp; " + $(this).text() + "</li>";
//                                    break;
//                                }
//                                case "hide":
//                                {
//                                    _tableIndex += "<li class='" + columnShow + "' id='" + index + "'><input type='checkbox' name='checkbox_demo' id='checkbox_demo" + index + "' data-md-icheck " + allReadyChecked + " />&nbsp;&nbsp; " + $(this).text() + "</li>";
//                                    break;
//                                }
//                                default: // without declare the values and equal to hide
//                                {
//                                    _tableIndex += "<li class='" + columnShow + "' id='" + index + "'><input type='checkbox' name='checkbox_demo' id='checkbox_demo" + index + "' data-md-icheck " + allReadyChecked + " />&nbsp;&nbsp; " + $(this).text() + "</li>";
//                                    break;
//                                }
//                            }
////                if (classes == "show" && (classes != "" || classes != undefined)) {
//                        });
//                        $("#showColumn").html(_tableIndex);
////                        altair_md.inputs();
////                        altair_md.checkbox_radio();
//                    }
//                }



                appMaster.preLoader();

                $(document).on("mouseover", ".filters td .chosen-container", function () {
                    $(this).parents().find(".grid-view").css({"overflow": "visible"});
                });
                $(document).on("mouseout", ".filters td .chosen-container", function () {
                    $(this).parents().find(".grid-view").css({"overflow-x": "auto", "overflow-y": "hidden"});
                });
//                jqueryFunc.tabChange();

                //function call
                $("#done").click(function () {
                    jqueryFunc.columnShowHide();
                })

                $(document).on('ifClicked', '#showColumn input', function () {
                    $(this).iCheck('toggle');
                    $(this).parents("li").toggleClass("show selected-item");
                });

                $(document).on("click", "#showColumn > li", function () {
                    $(this).toggleClass("show selected-item");
                    $('#checkbox_demo' + this.id).iCheck('toggle');
                });
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
    </body>

</html>
