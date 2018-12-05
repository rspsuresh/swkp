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
        <meta name="viewport" content="width=devic e-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl . "/Oleose-masterfavicon.png" ?>">

        <!-- Bootstrap 3.3.2 -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/bootstrap.min.css" ?>">

        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/animate.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/font-awesome.min.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/slick.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/rs-plugin/css/settings.css" ?>">

        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/css/styles.css" ?>">
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl . "/css/custom.css" ?>">


        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/modernizr.custom.32033.js" ?>"></script>

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            #notify_alert{
                display: none; 
                width:350px;
                height:40px;
                background-color: #7cb342;
                opacity: 1;
                border-radius:5px;
                position:fixed;
                padding:10px;
                color:#fff;
                font-size: 15px;
                top:150px;
                right:20px;
            }
        </style>
    </head>

    <body>

        <div class="pre-loader">
            <div class="load-con">
                <img src="<?php /*echo Yii::app()->baseUrl . "/Oleose-master/assets/img/freeze/logo.png" */?>" class="animated fadeInDown" alt="">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
        </div>

        <header>

            <nav class="navbar navbar-default navbar-fixed-top" style="background: linear-gradient(-45deg, #146fbd 0%, #4693de 100%);" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="fa fa-bars fa-lg"></span>
                        </button>
                        <a class="navbar-brand" href="index.html">
                            <img src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/img/freeze/logo.png" ?>" alt="" class="logo">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                            <!--                            <li><a href="#about">about</a>
                                                        </li>
                                                        <li><a href="#features">features</a>
                                                        </li>
                                                        <li><a href="#reviews">reviews</a>
                                                        </li>
                                                        <li><a href="#screens">screens</a>
                                                        </li>
                                                        <li><a href="#demo">demo</a>
                                                        </li>
                                                        <li><a class="getApp" href="#getApp">get app</a>
                                                        </li>
                                                        <li><a href="#support">support</a>
                                                        </li>-->
                            <li><a href="<?php echo Yii::app()->createUrl('site/index'); ?>">Home</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-->
            </nav>


            <!--RevSlider-->
        </header>
        <!--login -->
        <div class="wrapper" style="padding-top: 120px">
            <!--Request chenge password-->
            <section id="Rpsection">
                <div class="container" style="width:50%;">
                    <div class="section-heading scrollpoint sp-effect3">
                        <h2>Reset Password</h2>
                    </div>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'forget-password',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    ));
                    ?>
                    <div class="row">
                        <!--<div class="col-md-12">-->
                        <!--<div class="row">-->
                        <div class="col-md-8 col-sm-8 scrollpoint sp-effect1" style="margin: 0 auto;float: none;">
                            <!--<form role="form">-->
                            <div class="form-group">
                                <?php echo $form->labelEx($model, 'newPassword'); ?>
                                <?php echo $form->passwordField($model, 'newPassword', array("class" => "form-control")); ?>
                                <?php echo $form->error($model, 'newPassword'); ?>
                            </div>
                            <div class="form-group">
                                <?php echo $form->labelEx($model, 'confirmPassword'); ?>
                                <?php echo $form->passwordField($model, 'confirmPassword', array("class" => "form-control")); ?>
                                <?php echo $form->error($model, 'confirmPassword'); ?>
                            </div>
                            <div class="form-action" style="text-align:center;">
                                <?php echo CHtml::submitButton('Change Password', array("class" => "btn btn-primary btn-lg pass", "id" => "CP")); ?>
                            </div>
                        </div>
                        <!--</div>-->
                        <!--</div>-->
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </section>
            <!--Reset password-->

        </div>
        <div id="notify_alert">
            test
        </div> 
        <!--<script src="<?php // echo Yii::app()->baseUrl."/Oleose-master/assets/js/jquery-1.11.1.min.js"   ?>"></script>-->
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/bootstrap.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/slick.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/placeholdem.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/rs-plugin/js/jquery.themepunch.plugins.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/waypoints.min.js" ?>"></script>
        <script src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/js/scripts.js" ?>"></script>
        <script>
            $(document).ready(function () {
                appMaster.preLoader();
            });
            $('.pass').click(function () {
                if ($(this).attr('id') == "FP") {
                    $('#Lgsection').addClass('hide');
                    $('#Fpsection').removeClass('hide');
                }
               // console.log($(this).attr('id'));
            });
        </script>
    </body>

</html>
