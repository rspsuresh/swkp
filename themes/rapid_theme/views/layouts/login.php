<?php $path = Yii::app()->theme->baseUrl . "/altair_file/"; ?>
<!doctype html>
<!--[if lte IE 9]>
<html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <!--        <link rel="icon" type="image/png" href="<?php //echo $path . "assets/img/favicon-16x16.png";                   ?>" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php //echo $path . "assets/img/favicon-32x32.png";                   ?>" sizes="32x32">-->
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
    <link rel="stylesheet" href="<?php echo $path . "assets/css/altairstyle.css"; ?>" media="all">
    <link rel="stylesheet" href="<?php echo $path . "assets/css/login_page.min.css"; ?>" media="all">

<!--    --><?php //Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
    <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
    <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
</head>
<body class="login_page">
<div class="login_page_wrapper">
    <?php echo $content; ?>
</div>
<!-- common functions -->
<script src="<?php echo $path . "assets/js/common.js"; ?>"></script>
<!-- uikit functions -->
<script src="<?php echo $path . "assets/js/uikit_custom.min.js"; ?>"></script>

<!-- altair common functions/helpers -->
<script src="<?php echo $path . "assets/js/altair_admin_common.min.js"; ?>"></script>
<script src="<?php echo $path . "assets/js/pages/login.js"; ?>"></script>

</body>

</html>