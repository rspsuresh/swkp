<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/1999/html">
<head>
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>90</w:Zoom>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
    <title>Word Paragraph Document</title>
    <style>
        <!-- /* Style Definitions */
        p.MsoHeader, li.MsoHeader, div.MsoHeader {
            margin: 0in;
            margin-top: .0001pt;
            mso-pagination: widow-orphan;
            tab-stops: center 3.0in right 6.0in;
        }
        p.MsoFooter, li.MsoFooter, div.MsoFooter {
            margin: 0in 0in 1in 0in;
            margin-bottom: .0001pt;
            mso-pagination: widow-orphan;
            tab-stops: center 3.0in right 6.0in;
        }
        .footer {
            font-size: 9pt;
        }
        @page Section1 {
            size: 8.5in 11.0in;
            margin: 1.0in 1.0in 1.0in 1.0in;
            mso-header-margin: 0.5in;
            mso-header: h1;
            mso-footer: f1;
            mso-footer-margin: 0.5in;
            mso-paper-source: 0;
        }
        div.Section1 {
            page: Section1;
        }
        table#hrdftrtbl {
            margin: 0in 0in 0in 9in;
        }
        -->
    </style>
    <style type="text/css" media="screen,print">
        body {
            font-family: "Times New Roman";
            font-size: 12pt;
        }
        pageBreak {
            clear: all;
            page-break-before: always;
            mso-special-character: line-break;
        }
    </style>
</head>
<body style='tab-interval:.5in'>
<div class=Section1>
    <?php
    $file = FileInfo::model()->findByPk($f_id);
    $fileNam = $file ? $file->fi_file_name : '';

    $patien_name = "";
    $gender = "";
    $doi = "";
    $dob = "";
    $summaryTemp = array();
    $fileCount = count(file($filename));
    $i = 1;
    $firstTime = true;
    $headerName = $headerDob = '';
    $pageNo = $dos = $facility = $providerName = $facility = $bodyParts = $diagnoses = $bodyParts1 = array();
    $icd9 = $icd10 = $dxTerms = '';
    $tableData = array();
    $subpages = '';
    $SumIcd9 = array();
    $SumIcd10 = array();
    $Sumdx = array();
    $multiPages = array();
    foreach (file($filename) as $data) {
        $expData = explode('|', $data);
        if (!empty($expData[0]) && $file->fi_split_files != "") {
            $tempSubpages = explode(",", $expData[0]);
            //$mergefiles = FileinfoController::actionGetsplitpages($tempSubpages[0], $f_id);
            $mergefiles = FileinfoController::actionMultifile($tempSubpages, $f_id);
            $subpages = $mergefiles;
            $multiPages = $mergefiles;			
        }		
        $pageNo[] = !empty($expData[0]) ? $expData[0] : '';
        //$dos[] = !empty($expData[1]) ? FileInfo::dateformat($expData[1], $pid) : 'Undated';
        $dos[] = !empty($expData[1]) ? $expData[1] : 'Undated';
        $doshead[] = !empty($expData[1]) ? $expData[1] : '';
        $category = !empty($expData[3]) ? $expData[3] : '';
        // $providerName[] = !empty($expData[4]) ? $expData[4] : '';
        if ($expData[10] == "M") {
            $patien_name = !empty($expData[2]) ? $expData[2] : '';
            $gender = !empty($expData[5]) ? $expData[5] : '';
           $doi = !empty($expData[6]) ? FileInfo::dateformat($expData[6], $pid) : '';
            $dob = !empty($expData[9]) ?$expData[9]: '';

        }
        //$facility[] = !empty($expData[7]) ? $expData[7] : '';
        $catName = !empty($expData[8]) ? $expData[8] : '';

        $type = !empty($expData[10]) ? $expData[10] : '';
        $current_date = !empty($expData[11]) ? $expData[11] : '';
        $title = !empty($expData[12]) ? $expData[12] : '';
        $index = !empty($expData[13]) ? $expData[13] : '';
        $bodyParts[] = !empty($expData[14]) ? str_replace('^', ',&nbsp;', $expData[14]) : '';
        if (!empty($expData[14])) {
            $bodyParts1 = array_merge($bodyParts1, explode("^", $expData[14]));
        }
        $icd = '';
        if (strpos($expData[15], '~') !== false) {

            $icd = explode("~", $expData[15]);

            if (!empty($icd[0])) {
                $SumIcd9 = array_merge($SumIcd9, explode('^', trim($icd[0])));
            }
            if (!empty($icd[1])) {
                $SumIcd10 = array_merge($SumIcd10, explode('^', trim($icd[1])));
            }
            if (!empty($icd[2])) {
                $Sumdx = array_merge($Sumdx, explode('^', trim($icd[2])));
            }
            $icd9 = !empty($icd [0]) ? str_replace('^', '<br>', $icd[0]) : '';
            $icd10 = !empty($icd [1]) ? str_replace('^', '<br>', $icd[1]) : '';
            $dxTerms = !empty($icd [2]) ? str_replace('^', '<br>', $icd[2]) : '';
        }

        $oldata[] = array(
            'dos' => !empty($expData[1]) ? $expData[1] : 'Undated',
            'sort_dos' => !empty($expData[1]) ? $expData[1] : '',
            'bodyparts' => !empty($expData[14]) ? str_replace('^', ',&nbsp;', $expData[14]) : '',
            'uniqueproviderName' => !empty($expData[4]) ? $expData[4] : '',
            'providerName' => !empty($expData[4]) ? str_replace('^', '/&nbsp;', $expData[4]) : '',
            'facility' => !empty($expData[7]) ? $expData[7] : '',
            'diagonis1' => $icd9,
            'diagonis2' => $icd10,
            'subpageno' => $multiPages,
            'pageno' => !empty($expData[0]) ? $expData[0] : '',
            'uni_diagonis1' => !empty($icd [0]) ? $icd[0] : '',
            'uni_diagonis2' => !empty($icd [1]) ? $icd[1] : '',
            'unique_body' => !empty($expData[14]) ? $expData[14] : '',
            'dx_terms' => $dxTerms,
            'uni_dx_terms' => !empty($icd [2]) ? $icd[2] : '',
            'category' => !empty($expData[8]) ? $expData[8] : '',

        );
    }		

    /* 'dx_terms' => !empty($expData[16]) ? str_replace('^', '<br>', $expData[16]) : '',
            'uni_dx_terms' => !empty($expData[16]) ? $expData[16] : '',*/
    $headerName = $patien_name;
    $headerDob = $dob;
    $SumIcd9 = array_filter($SumIcd9);
    $SumIcd10 = array_filter($SumIcd10);
    //Date Sort
    if (!function_exists('date_sort')) {
        function date_sort($a, $b) {
            $t1 = strtotime($a['sort_dos']);
            $t2 = strtotime($b['sort_dos']);
            return $t2 - $t1;
        }
    }
    $tempDate = $oldata;
    usort($tempDate, "date_sort");
    $tempCount = count($tempDate);
    $indexCount = $tempCount - 1;
    //unique proceess
    $uni_body = $uni_provider = $uni_facility = $uni_dos1 = $uni_dos2 = $uni_dx_terms = $unique_providerName = array();
    //Single Dimenssion
    $startDate = $endDate = '';
    $k = 0;
    foreach ($tempDate as $key => $value) {
        if (!empty($value['sort_dos'])) {
            if ($k == 0) {
                $endDate = $value['sort_dos'];
            }
            $k++;
            $startDate = $value['sort_dos'];
        }
        if (!empty($value['providerName'])) {
            $uni_provider [] = trim($value['providerName']);
        }
        if (!empty($value['facility'])) {
            $uni_facility [] = trim($value['facility']);
        }
        $uni_body = array_merge($uni_body, explode("^", $value['unique_body']));
        $unique_providerName = array_merge($unique_providerName, explode("^", $value['uniqueproviderName']));
        $uni_dos1 = array_merge($uni_dos1, explode("^", $value['uni_diagonis1']));
        $uni_dos2 = array_merge($uni_dos2, explode("^", $value['uni_diagonis2']));
        $uni_dx_terms = array_merge($uni_dx_terms, explode("^", $value['uni_dx_terms']));

    }

    //Get term (trim,remove empty space,uinque)
    //dx-term
    if ($uni_dx_terms) {
        $uni_dx_terms = FileInfo::checkUniq($uni_dx_terms);
    }
    //icd-9
    if ($uni_dos1) {
        $uni_dos1 = FileInfo::checkUniq($uni_dos1);
    }
    //icd-10
    if ($uni_dos2) {
        $uni_dos2 = FileInfo::checkUniq($uni_dos2);
    }
    //Provider
    if ($uni_provider) {
        $uni_provider = FileInfo::checkUniq($uni_provider);
    }
    //Provider
    if ($unique_providerName) {
        $unique_providerName = FileInfo::checkUniq($unique_providerName);
    }
    //Facility
    if ($uni_facility) {
        $uni_facility = FileInfo::checkUniq($uni_facility);
    }
    //body
    if ($uni_body) {
        $uni_body = FileInfo::checkUniq($uni_body);
    }
	
	
    //$startDate = !empty($tempDate[$indexCount]['sort_dos']) ? $tempDate[$indexCount]['sort_dos'] : '';
    //$endDate = !empty($tempDate[$indexCount]['sort_dos']) ? $tempDate[0]['sort_dos'] : '';
    ?>
    <div><strong>Patient Name</strong>: <span><?php echo $headerName; ?></span></div>
    <div><strong>DOB</strong>: <span><?php echo FileInfo::dateformat($headerDob, $pid); ?></span></div>
    <h4 align="center">Summarization</h4>
    <table style="border-collapse: collapse;width: 100%;">
        <col width="65%">
        <col width="55%">
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Date Range</th>
            <td style="border: 1px solid black">Medical records provided for review a timeframe from <?php echo $startDate . ' through ' . $endDate; ?></td>
        </tr>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Body Parts</th>
            <td style="border: 1px solid black"><?php echo implode('<br>', $uni_body); ?></td>
        </tr>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Providers</th>
            <td style="border: 1px solid black"><?php echo implode('<br>', $unique_providerName); ?></td>
        </tr>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Facilities</th>
            <td style="border: 1px solid black"><?php echo implode('<br>', $uni_facility); ?></td>
        </tr>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Diagnoses</th>
            <td style="border: 1px solid black"><?php
                $rowData = '';
                if ($uni_dos1) {
                    $rowData = '<strong>ICD-9 Codes:</strong><br>' . implode('<br>', $uni_dos1) . '<br><br>';
                }
                if ($uni_dos2) {
                    $rowData .= '<strong>ICD-10 Codes:</strong><br>' . implode('<br>', $uni_dos2) . '<br><br>';
                }
                if ($uni_dx_terms) {
                    $rowData .= '<strong>Dx-Terms:</strong><br>' . implode('<br>', $uni_dx_terms);
                }
                echo $rowData;
                ?>
            </td>
        </tr>
    </table>
    <br style="page-break-before: always">
    <div><strong>Patient Name</strong>: <span><?php echo $headerName; ?></span></div>
    <div><strong>DOB</strong>: <span><?php echo $headerDob; ?></span></div>
    <h4 align="center">Index</h4>
    <table style="border-collapse: collapse;width: 100%;">
        <thead>
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black">Dates of Service</th>
            <th style="border: 1px solid black">Body Parts</th>
            <th style="border: 1px solid black">Providers</th>
            <th style="border: 1px solid black">Facilities</th>
            <th style="border: 1px solid black">Diagnoses</th>
             <th style="border: 1px solid black">Category</th>
             <th style="border: 1px solid black">Filename</th>
            <th style="border: 1px solid black">Bates/References</th>
            <th style="border: 1px solid black">Pages</th>
           
        </tr>
        </thead>
        <tbody>
        <?php
        for ($j = 0; $j < $tempCount; $j++) {
            ?>
            <tr style="border: 1px solid black">
                <td style="border: 1px solid black"><?php echo $tempDate[$j]['dos']; ?></td>
                <td style="border: 1px solid black"><?php echo $tempDate[$j]['bodyparts']; ?></td>
                <td style="border: 1px solid black"><?php echo $tempDate[$j]['providerName']; ?></td>
                <td style="border: 1px solid black"><?php echo $tempDate[$j]['facility']; ?></td>
                <!--<td style="border: 1px solid black"><?php //echo $diagnoses[$i];?></td>-->
                <td style="border: 1px solid black"><?php
                    $rowData = '';
                    $tempDate[$j]['diagonis1'] = trim($tempDate[$j]['diagonis1']);
                    $tempDate[$j]['diagonis2'] = trim($tempDate[$j]['diagonis2']);
                    $tempDate[$j]['dx_terms'] = trim($tempDate[$j]['dx_terms']);
                    if (!empty($tempDate[$j]['diagonis1'])) {
                        $rowData = '<strong>ICD-9 Codes:</strong><br>' . $tempDate[$j]['diagonis1'] . '<br><br>';
                    }
                    if (!empty($tempDate[$j]['diagonis2'])) {
                        $rowData .= '<strong>ICD-10 Codes:</strong><br>' . $tempDate[$j]['diagonis2'] . '<br><br>';
                    }
                    if (!empty($tempDate[$j]['dx_terms'])) {
                        $rowData .= '<strong>Dx-Terms:</strong><br>' . $tempDate[$j]['dx_terms'];
                    }
                    echo $rowData;
                    //echo '<strong>ICD-9 Codes:</strong><br> '.$tempicd9.' <br><br><strong>ICD-10 Codes:</strong><br> '.$tempicd10;
                    ?></td>
                  <td style="border: 1px solid black"><?php
				echo $tempDate[$j]['category'];                    
                    ?></td>
                  <td style="border: 1px solid black"><?php
				echo $fileNam;                    
                    ?></td>
                <td style="border: 1px solid black"><?php				
                    echo !empty($tempDate[$j]['subpageno']) ? implode(' / ',array_keys($tempDate[$j]['subpageno'])) : $fileNam;                    
                    ?></td>
                <td style="border: 1px solid black"><?php
				echo !empty($tempDate[$j]['subpageno']) ? implode(' / ',array_values($tempDate[$j]['subpageno'])) : $tempDate[$j]['pageno'];                    
                    //echo (!empty($tempDate[$j]['subpageno']) ? $tempDate[$j]['subpageno'] : "") . "<br/>" . $tempDate[$j]['pageno'];
                    //echo (!empty($tempDate[$j]['subpageno']) ? $tempDate[$j]['subpageno'] : "") . "<br/>" . $tempDate[$j]['pageno'];
                    ?></td>
              

            </tr>
            <?php
        }		
        ?>
        </tbody>
    </table>
</div>
</body>
</html>