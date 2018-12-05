<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
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
    <title>Word Document</title>
</head>
<body>
<table style="width: 100%">
    <col width="50">
    <col width="50">
    <tr>
        <th colspan="4" align="center"><h3>Medical Record Review</h3></th>
    </tr>
    <?php
    //Check For summary
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
                }
                else{
                    break;
                }
            }
        } else {
            $summaryTemp[$temp] .= " " . $sumTempData[0];
        }
        $temp1 ++;

    }
    $temp3 = 0;
    $i = 1;
    $firstTime = true;
    foreach (file($filename) as $data) {
        $expData = explode('|', $data);
        if (isset($expData[15])) {
            $pageNo = !empty($expData[0]) ? $expData[0] : '';
            $dos = !empty($expData[1]) ? $expData[1]: 'Undated';
            $patien_name = !empty($expData[2]) ? $expData[2] : '';
            $category = !empty($expData[3]) ? $expData[3] : '';
            $providerName = !empty($expData[4]) ? str_replace("^",",",$expData[4]): '';
            $gender = !empty($expData[5]) ? $expData[5] : '';
            $doi = !empty($expData[6]) ? $expData[6]: '';
            $facility = !empty($expData[7]) ? $expData[7] : '';
            $catName = !empty($expData[8]) ? $expData[8] : '';
            $dob = !empty($expData[9]) ? $expData[9]: '';
            $type = !empty($expData[10]) ? $expData[10] : '';
            $current_date = !empty($expData[11]) ? $expData[11] : '';
            $title = !empty($expData[12]) ? $expData[12] : '';
            $index = !empty($expData[13]) ? $expData[13] : '';
            $allocated_id = !empty($expData[14]) ? $expData[14] : '';
           // $summary = !empty($expData[15]) ? $expData[15] : '';
            $summary = $summaryTemp[$temp3];
            $temp3++;
        } else {
            continue;
        }

        if ($firstTime) {
            echo '<tr >';
            echo '<td align="left" colspan="2">Patient Name</td>';
            echo '<td colspan="2">:&nbsp;' . $patien_name . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td align="left" colspan="2">Case No</td>';
            echo '<td colspan="2">:&nbsp;Unknown</td>';
            echo '</tr>';
            echo '<tr >';
            echo '<td align="left" colspan="2">Social Security No</td>';
            echo '<td colspan="2">:&nbsp;Unknown</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td align="left" colspan="2">Date of Birth </td>';
            echo '<td colspan="2">:&nbsp;' . $dob . '</td>';
            echo '</tr>';
            echo '<tr >';
            echo '<td align="left" colspan="2">Records of Medical SVC </td>';
            echo '<td colspan="2">:&nbsp;Palo Alto Medical Foundation C/O ACTA 4050 Dublin Blvd. Dublin, CA 94568 </td>';
            echo '</tr>';
            echo '<tr >';
            echo '<td align="left" colspan="2">Date of Injury</td>';
            echo '<td colspan="2">:&nbsp;' . $doi . '</td>';
            echo '</tr>';
            echo '<tr >';
            echo '<td align="left" colspan="2">Method of Injury</td>';
            echo '<td colspan="2">:&nbsp;Trip and fell</td>';
            echo '</tr>';
            echo '<tr >';
            echo '<td align="left" colspan="2">Injuries Incurred</td>';
            echo '<td colspan="2">:&nbsp; Left arm, elbow, wrist, knee, and shoulder</td>';
            echo '</tr>';
            echo '</table>';
            //Print table boreder
            echo '<table style="border-collapse: collapse;width: 100%;">';
            echo '<tr>';
            echo '<th style="border: 1px solid black;width:15%">Date of Service</th>';
            echo '<th style="border: 1px solid black;width:25%">Page NO</th>';
            echo '<th style="border: 1px solid black;width:25%">Provider</th>';
            echo '<th style="border: 1px solid black;width:35%">Review</th>';
            echo '</tr>';
            $firstTime = false;
        }
        echo '<tr>';
        echo '<td style="border: 1px solid black;width:15%">' . $dos . '</td>';
        echo '<td style="border: 1px solid black;width:25%">'.str_replace(","," ,",$pageNo). '</td>';
        echo '<td style="border: 1px solid black;width:25%">' . $providerName . '</td>';
        echo '<td style="border: 1px solid black;width:35%">' . $summary . '</td>';
        echo '</tr>';
        $i++;
    }

    ?>
</table>
</body>
</html>