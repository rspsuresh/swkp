<?php
/* @var $this FormsBuilderController */
/* @var $model FormsBuilder */

$this->breadcrumbs=array(
	'Forms Builders'=>array('index'),
	'Create',
);
?>




<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="1%" valign="top">
            <?php  $this->renderPartial('/sidebar/left_side');?>
            
        </td>
        <td valign="top" style="background-color: #FFFFFF;">
            <div class="cont_right formWrapper">

                <div class="center">
                    <?php
                    echo "<h2 class='brown_title' >Create New Form</h2>";
                    ?>
                                    </div>
                <div>
                    <br />

                </div>   
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </td>
    </tr>
</table>
