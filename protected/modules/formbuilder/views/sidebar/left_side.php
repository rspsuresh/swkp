<?php

function t($message, $category = 'cms', $params = array(), $source = null, $language = null) {
    return Yii::t($category, $message, $params, $source, $language);
}
?>
<div id="othleft-sidebar">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'encodeLabel' => false,
        'activateItems' => true,
        'activeCssClass' => 'list_active',
        'items' => array(
             array('label'=>''.t('Manage Forms'), 'url'=> array('formsBuilder/admin') ,'linkOptions'=> array('class'=>'menu_0'), 'active'=> ((Yii::app()->controller->id=='admin') && (in_array(Yii::app()->controller->action->id,array('admin')))) ? true : false, 'visible'=> ($this->action->id=='create' || $this->action->id=='update') ? true : false),   
    		 array('label'=>''.t('Create Form'), 'url'=>array('formsBuilder/create') ,'linkOptions'=>array('class'=>'menu_0'),
       'active'=> ((Yii::app()->controller->id=='create') && (in_array(Yii::app()->controller->action->id,array('create')))) ? true : false, 'visible'=> ($this->action->id=='admin' || $this->action->id=='update') ? true : false),      
			 array('label' => '' . t('Assets'), 'url' => array('/asset/Assets/admin'), 'linkOptions' => array('class' => 'menu_0')),
        ),
    ));
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        //Hide the second level menu
        $('#othleft-sidebar ul li ul').hide();
        //Show the second level menu if an item inside it active
        $('li.list_active').parent("ul").show();
        $('#othleft-sidebar').children('ul').children('li').children('a').click(function () {
            if ($(this).parent().children('ul').length > 0) {
                $(this).parent().children('ul').toggle();
            }
        });
    });
</script>

