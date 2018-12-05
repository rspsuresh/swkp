<style>
    .subEnq{
        border: 1px solid black;
          margin-bottom: 5px;
            
              border-radius: 5px;
    }
     .subEnq:hover{
         box-shadow: 5px 5px 5px grey;
         transition-duration: 0.5s;
     }
    .subEnq form{
        padding-right: 10px;
        padding-left: 10px;
      
    }
    .subEnq h3{
        background-color: #1871cd;
        padding: 5px;
        color:#fff;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php
        foreach ($tempArray as $key => $val) {
            $table .= "<tr>";
            $priceTemp = array();
            foreach ($tempArray[$key] as $key1 => $val1) {
                $table .= "<td>";
                $table .= ($key1 == "price") ? "$ " . $val1 : $val1;
                $table .= "</td>";
            }
            $table .= "</tr>";
        }
        echo $table .= "</table>";
        ?>
    </div>

    <div class="col-md-12 col-sm-12" style="color: #fff; padding-top: 10px;padding-bottom: 5px;">
        <div class="subEnq">
            <h3>Submit Enquiry</h3>
            <form class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-4 col-sm-4">
                        <label class="control-label" for="name">Name:</label>
                        <input style="color:grey" type="name" class="form-control" id="cli_name" placeholder="Enter name">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label class="control-label" for="cli_email">Email:</label>
                        <?php echo CHtml::textField('email', "", array('id' => 'cli_email', 'placeholder' => 'Email', 'class' => 'form-control','style'=>"color:grey")); ?>
                    </div>
                    <div class="col-md-4 col-sm-4" style="margin-top: 27px;">                        
                        <?php echo CHtml::submitButton('Submit', array('id' => 'submit_enquiry', 'class' => 'btn btn-primary', 'disabled' => 'disabled')); ?>
                    </div>
                </div>               
            </form>
        </div>
    </div>
</div>
</div>
<script>
    $('#submit_enquiry').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: ' <?php echo Yii::app()->createUrl("userdetails/submitenquiry"); ?> ',
            type: "POST",
            data: {enquiry: '<?php echo json_encode($tempArray); ?>',
                cli_email: $('#cli_email').val(),
                cli_name: $('#cli_name').val()},
            success: function (response) {
                $('.close').trigger('click');

                window.location.href = '<?php echo Yii::app()->createUrl('userdetails/enquiry'); ?>?showMsg=S'
            }
        });
    });
    $('#cli_email').on('input', function () {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (re.test($(this).val())) {
            $('#submit_enquiry').attr('disabled', false);
        }
        else {
            $('#submit_enquiry').attr('disabled', true);
        }

    });
</script>