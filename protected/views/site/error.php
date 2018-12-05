<?php
/* @var $this SiteController */
/* @var $error array */

?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo Yii::app()->name . ' - Error'; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href='http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
    <style type="text/css">
        body {
            font-family: 'Love Ya Like A Sister', cursive;
        }
        body {
            background: #eaeaea;
        }
        .wrap {
            margin: 0 auto;
            width: 1000px;
        }
        .logo {
            text-align: center;
            margin-top: 100px;
        }
        .logo img {
            width: 350px;
        }
        .logo p {
            color: #272727;
            font-size: 40px;
            margin-top: 1px;
        }
        .logo p span {
            color: lightgreen;
        }
        .sub a {
            color: #fff;
            background: #272727;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 13px;
            font-family: arial, serif;
            font-weight: bold;
            -webkit-border-radius: .5em;
            -moz-border-radius: .5em;
            -border-radius: .5em;
        }
    </style>
</head>


<body>
<div class="wrap">
    <div class="logo">
        <?php
        switch ($error["code"]) {
            case 400: {
                $errorMessage = "Bad Request";
                $url = Yii::app()->baseUrl . "/images/400.png";
                break;
            }
            case 401: {
                $errorMessage = "Authorization Required";
                $url = Yii::app()->baseUrl . "/images/401.png";
                break;
            }
            case 403: {
                $errorMessage = "Forbidden";
                $url = Yii::app()->baseUrl . "/images/403.png";
                break;
            }
            case 404: {
                $errorMessage = "Page Not Found";
                $url = Yii::app()->baseUrl . "/images/404.png";
                break;
            }
            case 408: {
                $errorMessage = "Request Time-Out";
                $url = Yii::app()->baseUrl . "/images/408.png";
                break;
            }
            case 500: {
                $errorMessage = "Internal Server Error";
                $url = Yii::app()->baseUrl . "/images/500.png";
                break;
            }
            default: {
                $errorMessage = "Someting Went Wrong";
                $url = Yii::app()->baseUrl . "/images/404.png";
                break;
            }
        }
        ?>
        <p><?php echo CHtml::encode($errorMessage); ?></p>
        <img src="<?php echo $url; ?>"/>
        <div class="sub">
            <p><a href="#" onclick="goBack()">Back </a></p>
        </div>
    </div>
</div>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>