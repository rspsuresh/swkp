<?php $ctrlAction = Yii::app()->controller->id . '/' . Yii::app()->controller->action->id; ?>
<aside id="sidebar_main">
    <div class="menu_section">
        <ul>
            <!--            <li title="Dashboard">-->
            <!--                <a href="index.html">-->
            <!--                    <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>-->
            <!--                    <span class="menu_title">Dashboard</span>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li>-->
            <!--                <a href="#">-->
            <!--                    <span class="menu_icon"><i class="material-icons">&#xE8D2;</i></span>-->
            <!--                    <span class="menu_title">Forms</span>-->
            <!--                </a>-->
            <!--                <ul>-->
            <!--                    <li><a href="forms_wizard.html">Wizard</a></li>-->
            <!--                    <li class="menu_subtitle">WYSIWYG Editors</li>-->
            <!--                    <li><a href="forms_wysiwyg_ckeditor.html">CKeditor</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <?php
            if (!Yii::app()->user->isGuest) {
                $user_record = UserDetails::model()->findByPK(Yii::app()->session['user_id']);
                if ($user_record->ud_flag == "A") {
                    ?>
                    <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                        <li class="<?php echo $ctrlAction == 'userdetails/admin' ? 'current_section' : ''; ?>">
                            <a href="<?php echo Yii::app()->createUrl('userdetails/admin'); ?>">
                                <span class="menu_icon"><i class="material-icons">&#xE851;</i></span>
                                <span class="menu_title">User Details</span>
                            </a>
                        </li>
                        <?php if (Yii::app()->session['user_type'] == "A") { ?>	
                            <li class="<?php echo $ctrlAction == 'category/admin' ? 'current_section' : ''; ?>">
                                <a href="<?php echo Yii::app()->createUrl('category/admin'); ?>">
                                    <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                                    <span class="menu_title">Category</span>
                                </a>
                            </li>
                            <li class="<?php echo $ctrlAction == 'templates/admin' ? 'current_section' : ''; ?>">
                                <a href="<?php echo Yii::app()->createUrl('templates/admin'); ?>">
                                    <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                                    <span class="menu_title">Templates</span>
                                </a>
                            </li>
                            <li class="<?php echo $ctrlAction == 'project/admin' ? 'current_section' : ''; ?>">
                                <a href="<?php echo Yii::app()->createUrl('project/admin'); ?>">
                                    <span class="menu_icon"><i class="material-icons">&#xE8F9;</i></span>
                                    <span class="menu_title">Project</span>
                                </a>
                            </li>
                        <?php } ?>	
                    <?php } ?>
        <!--            <li class="<?php // echo $ctrlAction == 'fileinfo/admin' ? 'current_section' : '';      ?>">
        <a href="<?php // echo Yii::app()->createUrl('fileinfo/admin');      ?>">
            <span class="menu_icon"><i class="material-icons">&#xE851;</i></span>
            <span class="menu_title">Fileinfo</span>
        </a>
        </li>-->
                    <?php if (Yii::app()->session['user_type'] == "C") { ?>
                        <li class="<?php echo $ctrlAction == 'fileinfo/admin' ? 'current_section' : ''; ?>">
                            <a href="<?php echo Yii::app()->createUrl('fileinfo/admin'); ?>">
                                <span class="menu_icon"><i class="material-icons">&#xE52D;</i></span>
                                <span class="menu_title">File List</span>
                            </a>
                        </li>
                        <li class="<?php echo $ctrlAction == 'project/admin' ? 'current_section' : ''; ?>">
                            <a href="<?php echo Yii::app()->createUrl('project/admin'); ?>">
                                <span class="menu_icon"><i class="material-icons">&#xE8F9;</i></span>
                                <span class="menu_title">Projects</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") { ?>
                            <li class="<?php echo $ctrlAction == 'fileinfo/allgrid' ? 'current_section' : ''; ?>">
                                <a href="<?php echo Yii::app()->createUrl('fileinfo/allgrid'); ?>">
                                    <span class="menu_icon"><i class="material-icons">&#xE52D;</i></span>
                                    <span class="menu_title">Workflow</span>
                                </a>
                            </li>	
                            <?php if (Yii::app()->session['user_type'] == "A") { ?>
                                <li class="<?php echo $ctrlAction == 'enquiry/admin' ? 'current_section' : ''; ?>">
                                    <a href="<?php echo Yii::app()->createUrl('enquiry/admin'); ?>">
                                        <span class="menu_icon"><i class="material-icons">&#xE0B0;</i></span>
                                        <span class="menu_title">Enquiry</span>
                                    </a>
                                </li>
                            <?php } ?>	
                        <?php } ?>
                        <?php if (Yii::app()->session['user_type'] != "A" && Yii::app()->session['user_type'] != "TL") { ?>
                            <li class="<?php echo $ctrlAction == 'fileinfo/indexalloc' ? 'current_section' : ''; ?>">
                                <a href="<?php echo Yii::app()->createUrl('fileinfo/indexalloc'); ?>">
                                    <span class="menu_icon"><i class="uk-icon-file-text-o uk-icon-small"></i></span>
                                    <span class="menu_title">PREPPING</span>
                                </a>
                            </li>
                            <li class="<?php echo $ctrlAction == 'filepartition/splitalloc' ? 'current_section' : ''; ?>">
                                <a href="<?php echo Yii::app()->createUrl('filepartition/splitalloc'); ?>">
                                    <span class="menu_icon"><i class="uk-icon-file-code-o uk-icon-small"></i></span>
                                    <span class="menu_title">DATECODING</span>
                                </a>
                            </li>
                        <?php } ?>	
                    <?php } ?>
                    <?php if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "C") { ?>
                        <li class="<?php echo $ctrlAction == 'fileinfo/uploadfile' ? 'current_section' : ''; ?>">
                            <a href="<?php echo Yii::app()->createUrl('fileinfo/uploadfile'); ?>">
                                <span class="menu_icon"><i class="material-icons">&#xE2C6;</i></span>
                                <span class="menu_title">Upload File</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                }
            }
            ?>		
        </ul>
    </div>
</aside>
<style>
    li.current_section a{
        background-color: #fff;
        border-bottom:1px solid #94a9ba;
        border-right: 5px solid #7cb342;
        /*width: 80%;*/
       /*display: inline-block !important;*/
        /*color:#7cb342 !important;*/
        /*color:#000 !important;*/
    }
/*    li.current_section:after{
        content:"";
        position: absolute;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-left: 10px solid green;

    }*/
    #sidebar_main .menu_section > ul > li.active_li > a span.menu_title, 
    #sidebar_main .menu_section > ul > li.active_li > a span.menu_icon i{
        /*color: #7cb342 !important;*/
    }
</style>
<script>
    $('li.current_section').parent().css('display', 'block');
</script>
