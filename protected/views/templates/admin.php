<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */
?>

<h3 class="heading_b uk-margin-bottom">Manage User Details</h3>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#UserDetails_ud_flag').change(function(){
    var s=($(this).hasClass('inactive_record'))?'R':'A';
    $(this).toggleClass('inactive_record');
      
      $('#user-details-grid').yiiGridView('update', {
      data:{status:s}
    });
    return false;
});
");
?>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
            <div class="uk-width-medium-1-4">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <div class="uk-width-medium-1-4">
                <label for="UserDetails_ud_flag" class="inline-label">Inactive</label><!--switch_demo_small-->
                <input type="checkbox" data-switchery data-switchery-size="large" id="UserDetails_ud_flag" name="UserDetails[ud_flag]" class="inactive_record" checked/>
                <label for="UserDetails_ud_flag" class="inline-label">Active</label>
                <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick='userCreate()' href="javascript:void(0)">Create</a>-->
            </div><?php
            if (Yii::app()->session['user_type'] == 'A') { ?>
                <div class="uk-width-medium-1-4">
                    <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick='tempcreate()' href="javascript:void(0)">Create</a>
                </div>
                <?php
            } ?>
            <div class="uk-width-1-1">
                <ul id="UserStatusTab" class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <?php
                    if (Yii::app()->session['user_type'] == 'A') { ?>
                        <li class="uk-active uk-width-1-2 tab_select" id="P"><a href="#">Parent Template</a></li>
                        <li class="uk-width-1-2 tab_select" id="C"><a href="#"> Child Template</a></li>
                        <?php } ?>

                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="tmp_frm">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'templates-grid',
                                'template' => '{items}{summary}{pager}',
                                'dataProvider' => $model->search(),
                                //'afterAjaxUpdate' => 'js:function(){$("select[name=\'Category[ct_cat_id]\']").chosen();$("select[name=\'Category[ct_cat_type]\']").chosen();gridResetOption();}',
                                'filter' => $model,
                                'columns' => array(
                                    //    'ct_cat_id',
                                    // 'ct_cat_name',
                                    array(
                                        'name' => 'op_id',
                                        'filter' => CHtml::dropDownList('Templates[output]', $model->output,array('XLS' => 'XLS', 'XML' => 'XML', 'PDF' => 'PDF', 'DOCX' => 'DOCX'), array('empty' => 'Select output')),
                                        'value' => '$data->output',
                                    ),
                                    array(
                                        'name' => 'parent_id',
                                        'filter' => CHtml::dropDownlist('Templates[parent_id]', $model->parent_id, CHtml::listData(Templates::model()->findAll(array("condition" => "parent_id = '0'")), "id", "t_name"), array('empty' => 'Select Parent')),
                                        'value' => '$data->t_name',
                                        'visible' => isset($_GET["type"]) && $_GET["type"] == "C",
                                        'value' => function ($data) {
                                            if (isset($data['parent_id'])) {
                                                $id = $data['parent_id'];
                                                $model=Templates::model()->findByPk($id)->t_name;

                                                    return $model;

                                            }
                                        },
                                    ),
                                    array(
                                        'name' => 't_name',
                                    ),
                                    array(
                                        "header" => "Actions",
                                        "value" => 'Templates::ActionButtons($data->id)',
                                        'type' => 'raw',
                                    ),
                                ),
                            ));
                            ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="P">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--<div id="userModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#userModal'}" style="display: none;"></button>-->

<div id="templateModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#templateModal'}" style="display: none;"></button>
<style>
    .grid-view-loading {
        display: none;
    }
</style>
<script>
    var TModal = UIkit.modal("#templateModal");
    function tempcreate() {
        $("#templateModal .uk-modal-header h3").html("Template Create");
        var tab = $('#grid_tab').val();
        
        if (tab == 'P') {
            var curl = "<?php echo Yii::app()->createUrl('templates/parentcreate') ?>";
        } else {
            var curl = "<?php echo Yii::app()->createUrl('templates/create') ?>";
        }
        $.ajax({
            url: curl,
            type: "post",
            success: function (result) {
                $("#templateModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
	
	function tempedit(id) {
        $("#templateModal .uk-modal-header h3").html("Template Update");
        var tab = $('#grid_tab').val();
        
        /*if (tab == 'P') {
            var curl = "<?php echo Yii::app()->createUrl('templates/parentcreate') ?>";
        } else {
            var curl = "<?php echo Yii::app()->createUrl('templates/create') ?>";
        }*/
		var curl = "<?php echo Yii::app()->createUrl('templates/update') ?>/" + id;
        $.ajax({
            url: curl,
            type: "post",
            success: function (result) {
                $("#templateModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
	
    $('#templateModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#templateModal .uk-modal-header h3").html("");
            $("#templateModal .uk-modal-content").html("");
            $('#templates-grid').yiiGridView('update', {
                data: {}
            });
        }
    });
    //Tab
    var tab_column = {E: '', C: ''};
    $(document).ready(function () {
        var a = 0, tbl_view;
        $(document).on("click", "#expand_mr", function (e) {
            tbl_view = $(".detail-view").height();
            if (a == 0) {
                $(this).prev().animate({height: tbl_view}, 1500);
                $(this).find("i").text("expand_less");
                a = 1;
            } else {
                $(this).prev().animate({height: 200}, 1500);
                $(this).find("i").text("expand_more");
                a = 0;
            }
        });

        /*$("select[name='UserDetails[ud_empid]']").chosen();
        $("select[name='UserDetails[ud_name]']").chosen();
        $("select[name='UserDetails[ud_cat_id]']").chosen();
        $("select[name='UserDetails[ud_usertype_id]']").chosen();*/

        $(".choosen-select").chosen();
    });

    $('.tab_select').click(function () {
        beforeajax();
        var id = $(this).attr('id');
        // Set id
        if (id == "P") {
            $('#grid_tab').val('P');
        } else if (id == "C") {
            $('#grid_tab').val('C');
        }
        $('.uk-tab-grid li').each(function () {
            $(this).removeClass('uk-active');
        });
        $(this).addClass('uk-active');
        $('#templates-grid').yiiGridView('update', {
            data: {type: $(this).attr('id')},
            complete: function (jqXHR, status) {
                jqueryFunc.tabChange();
                afterajax();
            }
        });
        return false;
    });
    function templatedownload(id)
    {
        window.location.href='templatedownload?id='+id;
    }
</script>

