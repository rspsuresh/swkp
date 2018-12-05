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
                    <a class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" onclick='userCreate()' href="javascript:void(0)">Create</a>
                </div>
                <?php
            } ?>
            <div class="uk-width-1-1">
                <ul id="UserStatusTab" class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <?php
                    if (Yii::app()->session['user_type'] == 'A') { ?>
                        <li class="uk-active uk-width-1-2 tab_select" id="E"><a href="#">Employee</a></li>
                        <li class="uk-width-1-2 tab_select" id="C"><a href="#"> Client</a></li>
                        <?php
                    } else if (Yii::app()->session['user_type'] == 'TL') { ?>
                        <li class="uk-active uk-width-1-1 tab_select" id="E"><a href="#">Employee</a></li>
                    <?php } ?>
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
                        <form id="user_frm">
                            <?php
                            $type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : "E";
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'user-details-grid',
                                'template' => '{items}{summary}{pager}',
                                'dataProvider' => $model->search(),
                                'afterAjaxUpdate' => 'js:function(){$("select[name=\'UserDetails[ud_empid]\']").chosen();$("select[name=\'UserDetails[ud_usertype_id]\']").chosen();$("select[name=\'UserDetails[ud_name]\']").chosen();$("select[name=\'UserDetails[ud_cat_id]\']").chosen();gridResetOption();}',
                                'filter' => $model,
                                'columns' => array(
                                    array(
                                        'name' => 'ud_empid',
                                        'value' => '$data->ud_empid',
                                        //'filter' => CHtml::dropDownlist('UserDetails[ud_empid]', $model->ud_empid, UserDetails::customUserdetail($type, 'ud_empid'), array('empty' => 'Select Employee Id')),
                                        'visible' => !isset($_GET["type"]) || $_GET["type"] != "C",
                                    ),
                                    array(
                                        'name' => 'ud_usertype_id',
                                        'value' => '!empty($data-> UserType->ut_usertype)?$data-> UserType->ut_usertype:"-"',
										'value' => '!empty($data-> UserType->ut_usertype)?UserDetails::getUserName($data->UserType->ut_usertype):"-" ',
                                        'filter' => CHtml::dropDownlist('UserDetails[ud_usertype_id]', $model->ud_usertype_id, CHtml::listData(UserType::model()->findAll(array("condition" => "ut_flag = 'A'")), "ut_refid", "ut_name"), array('empty' => 'Select User Type')),
                                        'htmlOptions'=>array('width'=>'10px'),
                                    ),
                                    array(
                                        'class' => 'DataColumn',
                                        'name' => 'ud_name',
                                        'evaluateHtmlOptions' => true,
                                        'value' => 'isset($data->ud_name)?$data->ud_name:""',
//                                        'filter' => CHtml::dropDownlist('UserDetails[ud_name]', $model->ud_name, UserDetails::customUserdetail($type, 'ud_name'), array('empty' => 'Select Employee Name')),
//                                        'htmlOptions' => array('class' => 'user-view-overlay', 'id' => '"ordering_{$data->ud_empid}"')
                                        'htmlOptions' => array('class' => '"user-view-overlay"', 'id' => '"{$data->ud_refid}"', 'onclick' => '"userView($data->ud_refid)"')
                                    ),
                                    //'ud_dob',
                                    array(
                                        'name' => 'ud_dob',
                                        'value' => '!empty($data->ud_dob)?Yii::app()->dateFormatter->format("d MMM y",strtotime($data->ud_dob)):""',
                                        'filter' => CHtml::activeTextField($model, 'ud_dob', array('data-uk-datepicker' => "{format:'DD MMM YYYY'}")),
                                    ),
//                                    array(
//                                        'name' => 'ud_cat_id',
//                                        'value' => 'isset($data->Category->ct_cat_name)?$data->Category->ct_cat_name:""',
//                                        'filter' => CHtml::dropDownlist('UserDetails[ud_cat_id]', $model->ud_cat_id, CHtml::listData(Category::model()->findAll(array("condition" => "ct_flag = 'A'", 'order' => 'ct_cat_name')), 'ct_cat_id', 'ct_cat_name'), array('empty' => 'Select Category')),
//                                        'visible' => !isset($_GET["type"]) || $_GET["type"] != "C",
//                                    ),
                                    // 'ud_cat_id',
                                    'ud_email',
                                    'ud_mobile',
                                    'ud_ipin',
                                    array(
                                        "header" => "Actions",
                                        "value" => 'UserDetails::ActionButtons($data->ud_refid)'
                                    ),
                                ),
                            ));
                            ?>
                            <input type="hidden" id="grid_tab" name="grid_tab" value="E">
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="userModal" class="uk-modal">
    <div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
        <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
            <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
            <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
        </div>
        <div class="uk-modal-content"></div>
        <div class="uk-modal-footer"></div>
    </div>
</div>
<button id="triggerModal" data-uk-modal="{target:'#userModal'}" style="display: none;"></button>
<style>
    .grid-view-loading {
        display: none;
    }
</style>
<script>

    var userModal = UIkit.modal("#userModal");
    function userView(id) {

        //$("#userModal .uk-modal-header h3").html("User View");
        $.ajax({
            url: "<?php echo Yii::app()->createUrl('userdetails/view') ?>/" + id,
            type: "post",
            success: function (result) {
//                  $("#sidebar_secondary_inner").html(result);
//                $("#sidebar_secondary_toggle").trigger("click");
                $("#sidebar_secondary").html(result);
                $("#sidebar_secondary_toggle").trigger("click");
//
            },

        });
    }
    function userUpdate(id) {
        $("#userModal .uk-modal-header h3").html("User Update");
        var tab = $('#grid_tab').val();
        if (tab == 'E') {
            var curl = "<?php echo Yii::app()->createUrl('userdetails/update') ?>/" + id;
        } else {
            var curl = "<?php echo Yii::app()->createUrl('userdetails/updateclient') ?>/" + id;
        }
        $.ajax({
            url: curl,
            type: "post",
            success: function (result) {
                $("#userModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    function userDelete(id,action) {
        if(action==1)
        {
            var toast="Are you sure, you want to change the user status to inactive?";
        }
        else {
            var toast="Are you sure, you want to change the user status to active?";
        }
        UIkit.modal.confirm(toast, function () {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('userdetails/delete') ?>/" + id,
                type: "post",
                success: function (result) {
                    $('#user-details-grid').yiiGridView('update', {
                        data: {}
                    });
                }
            });
        });
    }
    function userCreate() {
        $("#userModal .uk-modal-header h3").html("User Create");
        var tab = $('#grid_tab').val();
        if (tab == 'E') {
            var curl = "<?php echo Yii::app()->createUrl('userdetails/create') ?>";
        } else {
            var curl = "<?php echo Yii::app()->createUrl('userdetails/createclient') ?>";
        }
        $.ajax({
            url: curl,
            type: "post",
            success: function (result) {
                $("#userModal .uk-modal-content").html(result);
                $("#triggerModal").trigger("click");
            }
        });
    }
    $('#userModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#userModal .uk-modal-header h3").html("");
            $("#userModal .uk-modal-content").html("");
            $('#user-details-grid').yiiGridView('update', {
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

        $("select[name='UserDetails[ud_empid]']").chosen();
        $("select[name='UserDetails[ud_name]']").chosen();
        $("select[name='UserDetails[ud_cat_id]']").chosen();
        $("select[name='UserDetails[ud_usertype_id]']").chosen();

        $(".choosen-select").chosen();
    });

    $('.tab_select').click(function () {
        beforeajax();
        var id = $(this).attr('id');
        // Set id
        if (id == "E") {
            $('#grid_tab').val('E');
        } else if (id == "C") {
            $('#grid_tab').val('C');
        }
        $('.uk-tab-grid li').each(function () {
            $(this).removeClass('uk-active');
        });
        $(this).addClass('uk-active');
        $('#user-details-grid').yiiGridView('update', {
            data: {type: $(this).attr('id')},
            complete: function (jqXHR, status) {
                jqueryFunc.tabChange();
                afterajax();
            }
        });
        return false;
    });

</script>

