<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="fa fa-bars fa-lg"></span>
            </button>
            <a class="navbar-brand" href="<?php echo Yii::app()->createUrl('site'); ?>">
                <img src="<?php echo Yii::app()->baseUrl . "/Oleose-master/assets/img/freeze/logo.png"; ?>" alt="" class="logo">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo Yii::app()->createUrl('site/index#about'); ?>">about</a>
                </li>
                <li><a href="<?php echo Yii::app()->createUrl('site/index#features'); ?>">Workflow</a>
                </li>
                <li><a href="<?php echo Yii::app()->createUrl('site/index#reviews'); ?>">reviews</a>
                </li>
                <li><a href="<?php echo Yii::app()->createUrl('site/index#screens'); ?>">Services</a>
                </li>
                <li><a href="<?php echo Yii::app()->createUrl('site/index#demo'); ?>">demo</a>
                </li>
<!--                <li><a href="<?php // echo Yii::app()->createUrl('site/index#getApp'); ?>">get app</a>
                </li>-->
                <li><a href="<?php echo Yii::app()->createUrl('site/index#support'); ?>">support</a>
                </li>
                <li><a href="<?php echo Yii::app()->createUrl('site/login'); ?>">Login</a></li>
                <!--<li><a href="<?php // echo Yii::app()->createUrl('userdetails/signup'); ?>">Sign Up</a></li>-->
                <li><a href="<?php echo Yii::app()->createUrl('userdetails/enquiry'); ?>">Enquiry</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-->
</nav>