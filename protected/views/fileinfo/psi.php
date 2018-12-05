<?php
/*header("Cache-Control: ");// leave blank to avoid IE errors
header("Pragma: ");// leave blank to avoid IE errors
header("Content-type: application/octet-stream");
header("content-disposition: attachment;filename=PSIFILENAME.doc");*/
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <!--[if gte mso 9]><xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:DoNotHyphenateCaps/>
            <w:PunctuationKerning/>
            <w:DrawingGridHorizontalSpacing>9.35 pt</w:DrawingGridHorizontalSpacing>
            <w:DrawingGridVerticalSpacing>9.35 pt</w:DrawingGridVerticalSpacing>
        </w:WordDocument>
    </xml>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script>
        window.console = window.console || function (t) {
            };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>
    <style type="text/css">
        @media print {
            table {page-break-after: always;}
        }
        body{
            line-height:1.5;
            font-family: Futura;font-size:14;
        }
    </style>
</head>
<body>
<div class="Section0">
    <p class="Header">
        <span style="font-family:Times New Roman;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">AmadaGonzalez</span>
        <span style="font-family:Calibri;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;mso-spacerun:yes;"></span>
        <span style="font-family:Calibri;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">-</span>
        <!--[if supportFields]>
        <span style="mso-element:field-begin"></span>
        <span style="font-family:Calibri;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;"> PAGE   \* MERGEFORMAT </span>
        <span style="mso-element:field-separator"></span>
        <![endif]-->
        <span style="font-family:Calibri;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">3</span>
        <!--[if supportFields]>
        <span style="mso-element:field-end"></span>
        <![endif]-->
        <span style="font-family:Calibri;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">-</span>
    </p>
    <p class="Header">
        <span style="font-family:Calibri;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;">&#xa0;</span>
    </p>
    <?php
    $medicalrecords=0;
    foreach (file($filename) as $data) {
    $expData = explode('|', $data);
    if ($expData[10] == 'M') {
        $pageNo = !empty($expData[0]) ? $expData[0] : '';
        $myArray = explode(',', $pageNo);
        $medicalrecords=$medicalrecords+count($myArray);
    }
    }

    echo"<p style='text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115%;margin-top:0pt;margin-bottom:10pt;'>
        <span style='font-family:Times New Roman;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;line-height:115%;'>$nameoffile    Medical Records $medicalrecords Pages</span>
    </p>";
    $project=Project::model()->findByPk($pid);
    foreach (file($filename) as $data) {
        $expData = explode('|', $data);
        if ($expData[10] == 'M') {
            $pageNo = !empty($expData[0]) ? $expData[0] : '';
            $myArray = explode(',', $pageNo);
            $medicalrecords=$medicalrecords+count($myArray);
            $dos = !empty($expData[1]) ? $expData[1]: '';
            $patien_name = !empty($expData[2]) ? $expData[2] : '';
            $category = !empty($expData[3]) ? $expData[3] : '';
            $cat = Category::model()->findByPk($category);
            $catname = $cat ? $cat->ct_cat_name : '';
            $providerName = !empty($expData[4]) ? $expData[4] : '';
            $gender = !empty($expData[5]) ? $expData[5] : '';
            $doi = !empty($expData[6]) ? $expData[6]: 'undated';
            $facility = !empty($expData[7]) ? $expData[7] : '';
            $dob = !empty($expData[9]) ?$expData[9] : '';
            $type = !empty($expData[10]) ? $expData[10] : '';
            $current_date = !empty($expData[11]) ? $expData[11] : '';
            $title = !empty($expData[12]) ? $expData[12] : '';
            $index = !empty($expData[13]) ? $expData[13] : '';
            $allocated_id = !empty($expData[14]) ? $expData[14] : '';
            if($project->skip_edit ==0)
            {
                $summary = !empty($expData[15]) ? $expData[15] : '';
            }
            else{
                $summary = 'No summary';
            }

            echo "
            <p style='text-align:justify;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;line-height:115%;margin-top:0pt;margin-bottom:10pt;'>
				<span style='letter-spacing:-0.15pt;font-family:Times New Roman;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;text-decoration: underline;line-height:115%;'>Date of Injury:</span>
				<span style='letter-spacing:-0.15pt;font-family:Times New Roman;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;text-decoration: underline;line-height:115%;'></span>
				<span style='letter-spacing:-0.15pt;font-family:Times New Roman;font-size:11pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;text-decoration: underline;line-height:115%;'>$doi</span>
			</p>
         <p style='text-align:left;page-break-inside:auto;page-break-after:auto;page-break-before:avoid;margin-top:0pt;margin-bottom:10pt;'>
            <span style='font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;'>
                $dos $summary</span><span style='font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;
                font-variant:normal;'>
             ( $facility  </span><span style='font-family:Times New Roman;font-size:12pt;text-transform:none;font-weight:normal;font-style:normal;font-variant:normal;'>
             $nameoffile Pages $pageNo)</span>
        </p>";
        }

    }
    ?>
</div>
</body>
</html>