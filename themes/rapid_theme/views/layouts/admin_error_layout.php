<html>
    <head>
        <title>easyDictate Error !</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php $baseUrl = $baseUrl."/altair_file"; ?>
        <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>/images/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php echo $baseUrl; ?>/imgages/favicon-32x32.png" sizes="32x32">
        <!-- uikit -->
        <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/uikit.almost-flat.css" media="all">
        <!-- flag icons -->
        <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/flags.css" media="all">
        <!-- altair admin -->
        <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/main.css" media="all">
        <style>
            .bg-blue{background:#1976d2;height: 100%;}
            .error-main{width:400px;margin: 0 auto;display: block;max-width:100%;}
            .error-main a{    display: block;    text-align: center;    text-decoration: none;    color: #fff;  background: #075eb4;    padding: 20px;    border-radius: 3px;    border: 1px solid #0555A5;transition:box-shadow 0.3s;line-height: 2;margin: 0 10%;}
            .error-main a:hover{box-shadow:0px 3px 5px rgba(0, 0, 0, 0.56);}
            .error-img{max-width:100%;display: block;}
            .fa-5, h2 {
                font-size: 12em;
                font-weight: 600;
                display:inline-block;
                margin: 0;
            }
            .error_page_header >  div {
                font-size: 12em;
                font-weight: 600;
                display:inline-block;
                margin: 0;
                color: white;
            }
            .myicon{
                color: white;
                font-size: 140px;
            }
            .error_msg{
                font-weight: 300;
                font-size: 30px;
                line-height: 20px;
                display: block;
                color: white;
            }
        </style>
    </head>
    <body class="bg-blue error_page">
        <div class="">
            <center>
                <div>
                    <?php echo $content; ?>
                </div>	
            </center>
        </div>
    </body>
</html>



