<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word">
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
    $project=Project::model()->findByPk($pid);
    $temp = 0;
    $temp1 = 0;
    $summaryTemp = array();
    foreach (file($filename) as $key => $line) {
        $sumTempData = explode('|', trim($line));
        if (isset($sumTempData[15])) {
            if ($temp1 > 0) {
                $temp++;
                $temp1 = 0;
            }
            $summaryTemp[$temp] = empty($sumTempData[15]) ? "" : $sumTempData[15];
            $l = 16;
            while ($l > 0) {
                if (isset($sumTempData[$l])) {
                    $summaryTemp[$temp] .= " " . $sumTempData[$l];
                    $l++;
                } else {
                    break;
                }
            }
        } else {
            $summaryTemp[$temp] .= " " . $sumTempData[0];
        }
        $temp1++;

    }
    $temp3 = 0;

    $i = 1;
    $firstTime = true;
    $headerName = $headerDob = $sourcelist = $paragraph = '';
    $tableData = array();
    foreach (file($filename) as $data) {
        $expData = explode('|', $data);
        if (isset($expData[15])) {
            $pageNo = !empty($expData[0]) ? $expData[0] : '';
            $dos = !empty($expData[1]) ?  $expData[1]: 'Undated';
            $patien_name = !empty($expData[2]) ? $expData[2] : '';
            $category = !empty($expData[3]) ? $expData[3] : '';
            $providerName = !empty($expData[4]) ? str_replace("^"," ,",$expData[4] ): '';
            $gender = !empty($expData[5]) ? $expData[5] : '';
            $doi = !empty($expData[6]) ? $expData[6] : '';
            $facility = !empty($expData[7]) ? $expData[7] : '';
            $catName = !empty($expData[8]) ? $expData[8] : '';
            $dob = !empty($expData[9]) ? $expData[9]: '';
            $type = !empty($expData[10]) ? $expData[10] : '';
            $current_date = !empty($expData[11]) ? $expData[11] : '';
            $title = !empty($expData[12]) ? $expData[12] : '';
            $index = !empty($expData[13]) ? $expData[13] : '';
            $allocated_id = !empty($expData[14]) ? $expData[14] : '';
            //$summary = !empty($expData[15]) ? $expData[15] : '';

         /*   $search = array('^', '~', ' ');
            $replace = array(',', ' ,', '<br/>');
            $summary = str_replace($search,$replace,$summaryTemp[$temp3]);*/
         if($project->skip_edit ==0)
         {
             $summary = $summaryTemp[$temp3];
         }
         else{
             $summary = '';
         }
           //$summary = $summaryTemp[$temp3];
            $temp3++;
        } else {
            continue;
        }
        if ($firstTime) {
            $headerName = $patien_name;
            $headerDob = $dob;
            $firstTime = false;
        }
        if ($providerName) {
            $sourcelist .= '<div style="margin-left: 50px;height: 100%">' . $providerName . '</div>';
        }
        // $paragraph .= '<p>' . $dos . ': Patient was seen by ' . $patien_name . '&nbsp;&nbsp;' . $summary . '</p>';
        $paragraph .= '<p>' . $dos . ':' . $summary . '</p>';
        $tableData[] = array('data' => $dos, 'provider' => $providerName, 'treatment' => $summary, 'page' => $pageNo);
    }
    ?>
    <h3>Medical records provided for review came from the following sources</h3>
    <p>Page number references in the summary below refer to a scanned PDF file made from the medical records sent for my review. The records were reviewed, summarized, and put into chronological order as below.</p>
    <br>
    <h3 style="text-align: center">Source List</h3>
    <?php echo $sourcelist; ?>
    <h3 style="text-align: center">Brief Summary/Flow of Events</h3><br>
    <?php echo $paragraph; ?><br>
    <h3 style="text-align: center">Detailed Chronology</h3>
    <table style="border-collapse: collapse;width: 100%;" id="tab">
        <tr style="border: 1px solid black">
            <th style="border: 1px solid black;width:15%">Date</th>
            <th style="border: 1px solid black;width:20%">Provider</th>
            <th style="border: 1px solid black;width:45%">Occurrence/Treatment</th>
            <th style="border: 1px solid black;width:20%"
            ">Bates Reference</th>
        </tr>
        <?php
        if ($tableData) {
            $i = 0;
            foreach ($tableData as $rowData) {
                echo '<tr>';
                echo '<td style="border: 1px solid black;width:15%">' . $rowData['data'] . '</td>';
                echo '<td style="border: 1px solid black;width:20%">' . $rowData['provider'] . '</td>';
                echo '<td style="border: 1px solid black;width:45%">' . $rowData['treatment'] . '</td>';
                echo '<td style="border: 1px solid black;width:20%">' . str_replace(","," ,", $rowData['page']).'</td>';
                echo '</tr>';
                $i++;
            }
        }
        ?>
    </table>
    <br/>
    <table id='hrdftrtbl' border='1' cellspacing='0' cellpadding='0'>
        <tr>
            <td>
                <div style='mso-element:header' id="h1">
                    <p class="MsoHeader">
                    <table border="0" width="100%">
                        <tr>
                            <td><span>Patient Name:<?php echo $headerName; ?></span></td>
                            <td><span style="text-align: right">Dob:</span></td>
                        </tr>
                    </table>
                    </p>
                </div>
            </td>
            <td>
                <div style='mso-element:footer' id="f1">
                    <p class="MsoFooter">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" class="footer">
                                Page No:
                                <g:message code="offer.letter.page.label"/>
                                <span style='mso-field-code: PAGE '></span> of
                                <span style='mso-field-code: NUMPAGES '></span>
                            </td>
                        </tr>
                    </table>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>