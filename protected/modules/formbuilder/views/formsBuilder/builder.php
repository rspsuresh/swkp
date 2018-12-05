<?php
$str = $_REQUEST['json'];
$json = json_decode($str);
$fields = ($str != '')?json_encode($json->fields):"[]";
?>
<!doctype html>
<html>
<head>

  <title>Form Builder</title>
  <meta name="description" content="">
  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/vendor.css" />
  <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/builder.css" />
  <style>
  * {
    box-sizing: border-box;
  }

  .bd-class body {
    background-color: #444;
    font-family: sans-serif;
  }

  .fb-main {
    background-color: #fff;
    border-radius: 5px;
    min-height: 600px;
  }

  .bd-class input[type=text] {
    height: 26px;
    margin-bottom: 3px;
  }

  .bd-class select {
    margin-bottom: 5px;
    font-size: 40px;
  }
  #formJson{width:100%; height:150px}
  </style>
</head>
<body>
  <div class='fb-main'></div>

  <script src="<?php echo Yii::app()->baseUrl; ?>/js/vendor.js"></script>
  <script src="<?php echo Yii::app()->baseUrl; ?>/js/builder.js"></script>

  <script>
    $(function(){
      fb = new Formbuilder({
        selector: '.fb-main',
        bootstrapData:<?php echo $fields; ?> ,
      });
	 $("#formJson").appendTo('.fb-right').val('<?php echo $str; ?>');
      fb.on('save', function(payload){
		  $("#formJson").val(payload);
      })
    });
  </script>
  
<input type="hidden" id="formJson" />

</body>
</html>