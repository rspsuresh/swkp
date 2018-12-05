<?php
//if (Yii::app()->components['user']->loginRequiredAjaxResponse){
if (Yii::app()->user->loginRequiredAjaxResponse){
    Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
            jQuery(document).ajaxComplete(
                function(event, request, options) {
                    if (request.responseText == "'.Yii::app()->user->loginRequiredAjaxResponse.'") {
                        window.location.href = "'.Yii::app()->createUrl('/site/login?ajaxtimeout=timeout').'"
                    }
                }
            );
        ');
}
?>
<header id="header_main">
    <div class="header_main_content">
        <nav class="uk-navbar">
            <div class="main_logo_top">
                <!--                        <a href="index.html"><img src="<?php //echo $path;    ?>/assets/img/logo_main_white.png" alt="" height="15" width="71"/></a>-->
                <a href="<?php echo Yii::app()->createUrl('userdetails/admin'); ?>">
                    <h2 style="color:white;">KPWS</h2></a>

            </div>

            <!-- main sidebar switch -->
            <?php if (Yii::app()->session['user_status'] != "I") { ?>
                <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                    <span class="sSwitchIcon"></span>
                </a>

                <!-- secondary sidebar switch -->
                <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check"
                   style="display: none;">
                    <span class="sSwitchIcon"></span>
                </a>
            <?php } ?>


            <div class="uk-navbar-flip">
                <ul class="uk-navbar-nav user_actions">
                    <li style="margin-top: 15px;color: white;font-size: 16px;">
                        Hello! <?php echo Yii::app()->session['user_name']; ?></li>
                    <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                        <?php
                        //$path_image = (!empty(Yii::app()->session['profile_pic'])) ? Yii::app()->baseUrl . '/cdata/user/' . Yii::app()->session['user_id'] . '/' . Yii::app()->session['profile_pic'] : Yii::app()->baseUrl . '/images/sample.png';
                        $path_image = isset(Yii::app()->session['user_id']) ? UserDetails::getProfilepath(Yii::app()->session['user_id']) : '';
                        ?>
                        <a href="#" class="user_action_image"><img class="md-user-image"
                                                                   src="<?php echo $path_image; ?>" alt="Image"
                                                                   style=" padding: 2px;background: white;height: 71% !important;"/></a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav js-uk-prevent">
                                <?php if (isset(Yii::app()->session['user_type']) && Yii::app()->session['user_type'] == "C") { ?>
                                    <li>
                                        <a href="<?php echo Yii::app()->createUrl('userdetails/profileUpdate/' . Yii::app()->session['user_id']); ?>">Profile</a>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="<?php echo Yii::app()->createUrl("site/logout"); ?>"
                                       onclick="localStorage.removeItem('clickcount');">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="header_main_search_form">
        <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
        <form class="uk-form">
            <input type="text" class="header_main_search_input"/>
            <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i>
            </button>
        </form>
    </div>
</header>
<style>
    .custom-md-user-image {
        width: 38px;
        height: 38px;
        background: #f3f3f3;
        padding: 2px;
    }

    .chatLink {
        cursor: pointer;
    }

    ul#showColumn {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    ul#showColumn li.show {
        border-bottom: 1px solid #d3e5f3;
    }

    ul#showColumn li {
        padding: 10px 10px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    ul#showColumn li.selected-item {
        -webkit-transition: background 150ms, padding .2s;
        transition: background 150ms, padding .2s;
        /*color: #0e4010;*/
        /*text-shadow: 1px 1px 1px #3c9240;*/
        background: #e3f2fd;
    }

    .column-dropdown {
        padding: 0;
    }

    .buttonStyle {
        padding: 10px;
    }
</style>
<script type="text/javascript">
$(document).ready(function(){
 $(document).on({
    "contextmenu": function(e) {
        console.log("ctx menu button:", e.which); 

        // Stop the context menu
        e.preventDefault();
    },
    "mousedown": function(e) { 
        console.log("normal mouse down:", e.which); 
    },
    "mouseup": function(e) { 
        console.log("normal mouse up:", e.which); 
    }
});
});   
</script>
<script>
    jqueryFunc = {
        columnShowHide: function () {
            $("#showColumn > li").each(function (index) {
                index = index + 1;
                if ($(this).hasClass('show') || $(this).hasClass('ignore'))
                    $("table.items tr td:nth-child(" + index + "), table.items tr th:nth-child(" + index + ")").show();
                else
                    $("table.items tr td:nth-child(" + index + "), table.items tr th:nth-child(" + index + ")").hide();
            });
        },
        tabChange: function () {
            var _gridId = $(".grid-view").attr("id");
            var _tableIndex = '';
            var columnShow;
            var allReadyChecked;
            $("table.items tr th").each(function (index) {
                var classes = $(this).attr('class');
                columnShow = '';
                allReadyChecked = '';
                switch (classes) {
                    case "show": {
                        columnShow = "show selected-item";
                        allReadyChecked = "checked";
                        _tableIndex += "<li class='" + columnShow + "' id='" + index + "'><input type='checkbox' name='checkbox_demo' id='checkbox_demo" + index + "' data-md-icheck " + allReadyChecked + " />&nbsp;&nbsp; " + $(this).text() + "</li>";
                        break;
                    }
                    case "ignore": {
                        _tableIndex += "<li class='ignore' id='" + index + "'  style='display: none;'>&nbsp;&nbsp; " + $(this).text() + "</li>";
                        break;
                    }
                    case "hide": {
                        _tableIndex += "<li class='" + columnShow + "' id='" + index + "'><input type='checkbox' name='checkbox_demo' id='checkbox_demo" + index + "' data-md-icheck " + allReadyChecked + " />&nbsp;&nbsp; " + $(this).text() + "</li>";
                        break;
                    }
                    default: // without declare the values and equal to hide
                    {
                        _tableIndex += "<li class='" + columnShow + "' id='" + index + "'><input type='checkbox' name='checkbox_demo' id='checkbox_demo" + index + "' data-md-icheck " + allReadyChecked + " />&nbsp;&nbsp; " + $(this).text() + "</li>";
                        break;
                    }
                }
//                if (classes == "show" && (classes != "" || classes != undefined)) {
            });
            $("#showColumn").html(_tableIndex);
            altair_md.inputs();
            altair_md.checkbox_radio();
        }
    }
    $(document).ready(function () {

        $(document).on("mouseover", ".filters td .chosen-container", function () {
            $(this).parents().find(".grid-view").css({"overflow": "visible"});
        });
        $(document).on("mouseout", ".filters td .chosen-container", function () {
            $(this).parents().find(".grid-view").css({"overflow-x": "auto", "overflow-y": "hidden"});
        });
        jqueryFunc.tabChange();

        //function call
        $("#done").click(function () {
            jqueryFunc.columnShowHide();
        })

        $(document).on('ifClicked', '#showColumn input', function () {
            $(this).iCheck('toggle');
            $(this).parents("li").toggleClass("show selected-item");
        });

        $(document).on("click", "#showColumn > li", function () {
            $(this).toggleClass("show selected-item");
            $('#checkbox_demo' + this.id).iCheck('toggle');
        });


        $(document).on("mouseover", ".filters td .chosen-container", function () {
            $(this).parents().find(".grid-view").css({"overflow": "visible"});
        });
        $(document).on("mouseout", ".filters td .chosen-container", function () {
            $(this).parents().find(".grid-view").css({"overflow-x": "auto", "overflow-y": "hidden"});
        });
        jqueryFunc.tabChange();

        //function call
        $("#done").click(function () {
            jqueryFunc.columnShowHide();
        })

        $(document).on('ifClicked', '#showColumn input', function () {
            $(this).iCheck('toggle');
            $(this).parents("li").toggleClass("show selected-item");
        });

        $(document).on("click", "#showColumn > li", function () {
            $(this).toggleClass("show selected-item");
            $('#checkbox_demo' + this.id).iCheck('toggle');
        });
		
		$(document).keydown(function(event){
                                        if(event.keyCode==123){
                                            return false;
                                        }
                                        else if(event.ctrlKey && event.shiftKey && event.keyCode==73){
                                            return false;  //Prevent from ctrl+shift+i
                                        }
                                        else if(event.ctrlKey && event.shiftKey && event.keyCode==67){
                                            return false;  //Prevent from ctrl+shift+C
                                        }
                                        else if(event.ctrlKey && event.keyCode==80){
                                            return false;  //Prevent from ctrl+p
                                        }
                                    });

                                    //Disable right click script
                                    var message="Sorry, right-click has been disabled";
                                    function clickIE() {if (document.all) {(message);return false;}}
                                    function clickNS(e) {if
                                    (document.layers||(document.getElementById&&!document.all)) {
                                        if (e.which==2||e.which==3) {(message);return false;}}}
                                    if (document.layers)
                                    {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
                                    else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
                                    document.oncontextmenu=new Function("return false")
                                    function disableCtrlKeyCombination(e)
                                    {
                                        var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j' , 'w');
                                        var key;
                                        var isCtrl;
                                        if(window.event)
                                        {
                                            key = window.event.keyCode;     //IE
                                            if(window.event.ctrlKey)
                                                isCtrl = true;
                                            else
                                                isCtrl = false;
                                        }
                                        else
                                        {
                                            key = e.which;     //firefox
                                            if(e.ctrlKey)
                                                isCtrl = true;
                                            else
                                                isCtrl = false;
                                        }
                                        //if ctrl is pressed check if other key is in forbidenKeys array
                                        if(isCtrl)
                                        {
                                            for(i=0; i<forbiddenKeys.length; i++)
                                            {
                                                //case-insensitive comparation
                                                if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
                                                {
                                                    alert('Key combination CTRL + '+String.fromCharCode(key) +' has been disabled.');
                                                    return false;
                                                }
                                            }
                                        }
                                        return true;
                                    }
                                    //disable ctrl+u
                                    document.onkeydown = function(e) {
                                        if (e.ctrlKey &&
                                            (e.keyCode === 67 ||
                                            e.keyCode === 86 ||
                                            e.keyCode === 85 ||
                                            e.keyCode === 117)) {
                                            return false;
                                        } else {
                                            return true;
                                        }
                                    };

    });

    var msg1, msg2, res, msgdt, msgCount1, msgCount2, totalmsgcount;
    function beforeajax() {
        var prev_tab = $('.tab_select.uk-active').attr('id');
        var arr = [];
        $('#showColumn li:not(:has(.checked))').each(function () {
            arr.push($(this).attr('id'));
        });
        tab_column[prev_tab] = arr.join();
        console.log(tab_column);
    }
    function afterajax() {
        var curr_tab = $('.tab_select.uk-active').attr('id');
        arr = tab_column[curr_tab];
        arr = arr.split(',');
        console.log(arr);
        for (i = 0; i < arr.length && arr != ''; i++) {
            $('#showColumn').find('#' + arr[i]).removeClass('show selected-item').children().iCheck('uncheck');
        }
        $('#done').trigger('click');
        $('.column-dropdown').removeClass('uk-dropdown-active uk-dropdown-shown');
        $('.uk-button-dropdown').removeClass('uk-open');
    }
</script>