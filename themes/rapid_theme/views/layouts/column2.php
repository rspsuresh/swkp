<?php
//Yii::app()->clientScript->registerCoreScript('bbq');
//Yii::app()->clientScript->registerCoreScript('jquery');
?>
<!doctype html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
    <?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>

        <!--        <link rel="icon" type="image/png" href="<?php //echo $path . "assets/img/favicon-16x16.png";                     ?>" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php //echo $path . "assets/img/favicon-32x32.png";                     ?>" sizes="32x32">-->
        <link rel="shortcut icon"
              href="<?php echo Yii::app()->baseUrl . '/themes/rapid_theme/site_file/images/favicon.ico'; ?>"/>
        <title>KPWS</title>


        <!-- uikit -->
        <link rel="stylesheet" href="<?php echo $path . "bower_components/uikit/css/uikit.almost-flat.min.css"; ?>"
              media="all">

        <!-- flag icons -->
        <link rel="stylesheet" href="<?php echo $path . "assets/icons/flags/flags.min.css"; ?>" media="all">

        <!-- altair admin -->
        <link rel="stylesheet" href="<?php echo $path . "assets/css/main.css"; ?>" media="all">
        <link rel="stylesheet" href="<?php echo $path . "assets/css/altairstyle.css"; ?> " media="all">
        <link rel="stylesheet" href="<?php echo $path . "/chosen/chosen.css"; ?>">
        
        <!-- matchMedia polyfill for testing media queries in JS -->
        <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
        <![endif]-->
        <!-- common functions -->
        <script src="<?php echo $path . "assets/js/common.js"; ?>"></script>
        <!-- uikit functions -->
        <script src="<?php echo $path . "assets/js/uikit_custom.min.js"; ?>"></script>
        <!-- altair common functions/helpers -->

        <style>
            .action_buttons {
                display: inline-flex;
                text-align: center;
            }
            .pre-loader-div {
                position: absolute;
                right: 47%;
                top: 47%;
                z-index: 9999;
            }
            .errorMessage {
                color: red;
            }
            #sidebar_secondary {
                width: 400px !important;
                right: -410px;
                top: 0;
                z-index: 10000;
            }
            #cover {
                opacity: 0.4;
                background: #444;
                position: fixed;
                width: 100%;
                display: none;
                height: 100%;
                z-index: 9999;
            }
            .user-view-overlay:first-line{
                text-decoration: underline;
            }
            .user-view-overlay:hover{
                cursor: pointer;
            }
            .grid-view tr.filters td:last-child {
                text-align: center;
            }
            .grid-view tr.filters td:last-child button{
                padding:0px 10px !important;
            }
            #sidebar_main .menu_section li:not(.current_section) span.menu_title:after{
                content: '\00bb';
                opacity: 0;
                transition: opacity 0.8s;
                padding-left: 10px;
                font-size: 20px;
            }
            #sidebar_main .menu_section li:hover span.menu_title:after{
                /*color: #7cb342;*/
                 color:#000;
                opacity: 1;
            }
            #sidebar_main .menu_section li:hover span{
                padding-left: 10px;
                 color:#000;
            }
            #sidebar_main .menu_section li:hover span i{
                 color:#000;
            }
            #sidebar_main .menu_section li:hover:not(.current_section){
                background-color: #fff;
                border-bottom:1px solid #94a9ba;
               
            }
            #sidebar_main .menu_section li span{
                transition: padding-left 0.8s;
            }
            .current_section span{
                padding-left: 10px;
            }
            .current_section span.menu_title:after{
                content: '\00bb';
                opacity: 1;
                padding-left: 10px;
                font-size: 20px;
            }
            #sidebar_main{
                background-color: #3d587e;
            }
            #sidebar_main .menu_section > ul > li > a,#sidebar_main .menu_section > ul > li  span i{
                color:#fff;
            }
            #header_main{
                background-color: #2f6daa;
            }
            .current_section{
                /*display: inline-block;*/
            }
             
            
            
            


        </style>
    </head>
    <!--<div id="cover"></div>-->
    <body class=" sidebar_main_open sidebar_main_swipe header_full">
        <!--    <body class=" sidebar_main_open sidebar_main_swipe">-->

        <div class="pre-loader-div" style="display: none;">
            <div class="md-preloader">
                <svg viewBox="0 0 75 75" width="70" height="96" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <circle stroke-width="6" r="33.5" cy="37.5" cx="37.5"/>
                </svg>
            </div>
        </div>
        <!-- main header -->
        <?php require_once 'adminheader.php'; ?>
        <!-- main header end -->

        <!-- main sidebar -->
        <?php require_once 'adminsidebar.php'; ?>
        <!-- main sidebar end -->

        <!-- main content -->
        <div id="page_content">
            <div id="page_content_inner">
                <?php echo $content; ?>
                <!--        <h3 class="heading_b uk-margin-bottom">Blank Page</h3>
                        <div class="md-card">
                            <div class="md-card-content">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-1-1">
                                    </div>
                                </div>
                            </div>
                        </div>-->
            </div>
        </div>
        <aside id="sidebar_secondary">
        </aside>
        <!-- main content end -->

        <!-- secondary sidebar -->
        <!--    <aside id="sidebar_secondary">
                 <div style="text-align: center;padding-top: 7px;border-bottom: 1px solid #cfcfcf;padding-bottom: 10px;" class="uk-grid">
                         <div class="uk-width-medium-1-3"><div style="font-weight: bold;">15</div>
                         <i class="material-icons" style="font-size: 20pt;">note_add</i>
                         </div>
                          <div class="uk-width-medium-1-3">
                          <div style="font-weight: bold;">15</div>
                          <i class="material-icons" style="font-size: 20pt;">border_color</i>
                          </div>
                          <div class="uk-width-medium-1-3">
                          <div style="font-weight: bold;">15</div>
                          <i class="material-icons" style="font-size: 20pt;">done_all</i>
                          </div>  
                        </div>
                        <div style="text-align: center;padding: 15px;width: 130px;border: 1px solid #cfcfcf;border-radius: 67%;height: 130px;margin: 15px auto;overflow: hidden;position: relative;background: #f2f2f2;">
                            <img src="<?php // echo Yii::app()->baseUrl; ?>/images/sample.png" style="position: absolute;left: 18px;top: 5px;width: 95px;">
        </div>
                <div style="text-align: center;">
                        <h2 style="margin-bottom: 5px;color: #555;">Vignesh Rajendran</h2></div>
                        <div style="text-align: center;margin-bottom: 10px;border-bottom: 1px solid #cfcfcf;">
                        <h4 style="font-style: italic;color: #9f9f9f;">Cap Town, USA</h4></div>
                        
                <div class="scrollbar-inner" style="position: relative;">
                    <div id="sidebar_secondary_inner"></div>
                </div>
            </aside> secondary sidebar end -->


        <script>
            $(function () {
                // enable hires images
                altair_helpers.retina_images();
                // fastClick (touch devices)
                if (Modernizr.touch) {
                    FastClick.attach(document.body);
                }
            });
        </script>


        <div id="style_switcher">
            <!--            <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>--><!--Setting for grid color Change-->
            <div class="uk-margin-medium-bottom">
                <h4 class="heading_c uk-margin-bottom">Colors</h4>
                <ul class="switcher_app_themes" id="theme_switcher">
                    <li class="app_style_default active_theme" data-app-theme="">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_a" data-app-theme="app_theme_a">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_b" data-app-theme="app_theme_b">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_c" data-app-theme="app_theme_c">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_d" data-app-theme="app_theme_d">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_e" data-app-theme="app_theme_e">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_f" data-app-theme="app_theme_f">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_g" data-app-theme="app_theme_g">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_h" data-app-theme="app_theme_h">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                    <li class="switcher_theme_i" data-app-theme="app_theme_i">
                        <span class="app_color_main"></span>
                        <span class="app_color_accent"></span>
                    </li>
                </ul>
            </div>
            <div class="uk-visible-large uk-margin-medium-bottom">
                <h4 class="heading_c">Sidebar</h4>
                <p>
                    <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck/>
                    <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
                </p>
            </div>
            <div class="uk-visible-large uk-margin-medium-bottom">
                <h4 class="heading_c">Layout</h4>
                <p>
                    <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck/>
                    <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
                </p>
            </div>
            <div class="uk-visible-large">
                <h4 class="heading_c">Main menu accordion</h4>
                <p>
                    <input type="checkbox" name="accordion_mode_main_menu" id="accordion_mode_main_menu" data-md-icheck/>
                    <label for="accordion_mode_main_menu" class="inline-label">Accordion mode</label>
                </p>
            </div>
        </div>


        <!-- Popup text -->
        <button class="md-btn popup" data-uk-modal="{target:'#modal_header_footer',bgclose:false}" style="display: none;">Open</button>
        <div class="uk-modal" id="modal_header_footer">
            <div class="uk-modal-dialog  uk-modal-dialog-large" style="padding-top:0">
                <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
                    <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
                    <button type="button" class="uk-modal-close uk-close"
                            style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
                </div>
                <div class='uk-model_content'></div>
                <!--                <div class="uk-modal-footer uk-text-right">
                                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Action</button>
                                </div>-->
            </div>
        </div>

        <!-- Show the flash message -->
        <div class="uk-notify uk-notify-top-right" style="display: none;">
            <div id="div_flash_msg" class="uk-notify-message uk-notify-message-success"
                 style="opacity: 0.975528; margin-top: -1.02781px; margin-bottom: 9.75528px;">
                <a class="uk-close">x</a>
                <div class="alert_msgg"></div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                gridResetOption();
            });

            $(document).ajaxStart(function () {
                try {
                    $('.md-card').css({opacity: 0.3});
                    $('.pre-loader-div').show();
                } catch (e) {
                    //                    window.location.reload();
                }
            });
            $(document).find('.user-view-overlays').click(function () {
                $.ajax({url: '<?php echo Yii::app()->createUrl('userdetails/view/1'); ?>',
                    success: function (response) {
                        console.log();
                    }

                })
            });

            $(document).ajaxComplete(function () {
                try {
                    $('.md-card').css({opacity: 1});
                    $('.pre-loader-div').hide();
                } catch (e) {
                    //                    window.location.reload();
                }
            });
            $(function () {
                var $switcher = $('#style_switcher'),
                        $switcher_toggle = $('#style_switcher_toggle'),
                        $theme_switcher = $('#theme_switcher'),
                        $mini_sidebar_toggle = $('#style_sidebar_mini'),
                        $boxed_layout_toggle = $('#style_layout_boxed'),
                        $accordion_mode_toggle = $('#accordion_mode_main_menu'),
                        $body = $('body');


                $switcher_toggle.click(function (e) {
                    e.preventDefault();
                    $switcher.toggleClass('switcher_active');
                });

                $theme_switcher.children('li').click(function (e) {
                    e.preventDefault();
                    var $this = $(this),
                            this_theme = $this.attr('data-app-theme');

                    $theme_switcher.children('li').removeClass('active_theme');
                    $(this).addClass('active_theme');
                    $body
                            .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i')
                            .addClass(this_theme);

                    if (this_theme == '') {
                        localStorage.removeItem('altair_theme');
                    } else {
                        localStorage.setItem("altair_theme", this_theme);
                    }

                });

                // hide style switcher
                $document.on('click keyup', function (e) {
                    if ($switcher.hasClass('switcher_active')) {
                        if (
                                (!$(e.target).closest($switcher).length)
                                || (e.keyCode == 27)
                                ) {
                            $switcher.removeClass('switcher_active');
                        }
                    }
                });

                // get theme from local storage
                if (localStorage.getItem("altair_theme") !== null) {
                    $theme_switcher.children('li[data-app-theme=' + localStorage.getItem("altair_theme") + ']').click();
                }


                // toggle mini sidebar

                // change input's state to checked if mini sidebar is active
                if ((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                    $mini_sidebar_toggle.iCheck('check');
                }

                $mini_sidebar_toggle
                        .on('ifChecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.setItem("altair_sidebar_mini", '1');
                            location.reload(true);
                        })
                        .on('ifUnchecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.removeItem('altair_sidebar_mini');
                            location.reload(true);
                        });


                // toggle boxed layout

                if ((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                    $boxed_layout_toggle.iCheck('check');
                    $body.addClass('boxed_layout');
                    $(window).resize();
                }

                $boxed_layout_toggle
                        .on('ifChecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.setItem("altair_layout", 'boxed');
                            location.reload(true);
                        })
                        .on('ifUnchecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.removeItem('altair_layout');
                            location.reload(true);
                        });

                // main menu accordion mode
                if ($sidebar_main.hasClass('accordion_mode')) {
                    $accordion_mode_toggle.iCheck('check');
                }

                $accordion_mode_toggle
                        .on('ifChecked', function () {
                            $sidebar_main.addClass('accordion_mode');
                        })
                        .on('ifUnchecked', function () {
                            $sidebar_main.removeClass('accordion_mode');
                        });
                //            $("#cover").click(function () {
                //                $("#cover").hide();
                //                $("#sidebar_secondary_toggle").trigger("click");
                //            });
            });

            // left side toggle
            //        document.getElementById("sidebar_secondary_toggle").addEventListener("click", showCustom);

            //        function showCustom() {
            //            console.log("gghgg");
            //            document.getElementById("cover").style.display = "block";
            //        }

            function gridResetOption() {
                $grid = $(".grid-view");
                if ($grid.length) {
                    $grid.each(function () {
                        var buttonEnable = false;
                        var girdId = $(this).attr("id");
                        $("#" + girdId + " input").each(function () {
                            if ($(this).val() != "") {
                                buttonEnable = true;
                            }
                        });
                        $("#" + girdId + " select").each(function () {
                            if ($(this).val() != "") {
                                buttonEnable = true;
                            }
                        });
                        if (buttonEnable) {
                            $(this).find("tr.filters td:last").html("<button class='md-btn md-btn-small md-btn-warning md-btn-wave-light waves-effect waves-button waves-light' type='button' onclick=resetGrid('" + girdId + "')>reset</button>");
                        }
                    });
                }
            }

            function resetGrid(girdId) {
                $("#" + girdId + " input").each(function () {
                    $(this).val("");
                });
                $("#" + girdId + " select").each(function () {
                    $(this).val("");
                });
                var formData = $("#" + girdId + " select, #" + girdId + " input").serialize();
                $('#' + girdId).yiiGridView('update', {
                    data: formData
                });
            }

        </script>
        <style>
            .grid-view table.items {
                display: table;
            }
            .grid-view {
                overflow: auto;
            }
            .grid-view-loading {
                display: none;
            }
        </style>
    </body>
    <script src="<?php echo $path . "assets/js/altair_admin_common.js"; ?>"></script>
    <script src="<?php echo Yii::app()->baseUrl . '/themes/rapid_theme/altair_file/chosen/chosen.jquery.js'; ?>"></script>
    <script src="<?php // echo $path . "/chosen/chosen.jquery.min.js"; ?>"></script>
</html>
<?php Yii::app()->clientScript->registerScript('commonfunction', "
    $(document).on('change', '#selectf', function () {
      var RefCGridId = $('.grid-view').attr('id');
        $('#'+RefCGridId).yiiGridView('update', {
            data: {size: $('#selectf').val()}
        });
        return false;
    });
    
    /*----- Refresh the all grid page -----*/
    Refresh = {
            CgridRefresh: function(grid_id) {
                if(grid_id!='')
                {
                    $.fn.yiiGridView.update(grid_id);
                }
                else
                {
                    $('.grid-view').each(function () {
                        var RefCGridId = $(this).attr('id');
                        $.fn.yiiGridView.update(RefCGridId);
                    });
                }
            }
    }
    ");
?>