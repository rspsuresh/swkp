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
    <title>Word Paragraph Document</title>
</head>
<body>
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
foreach (file($filename) as $data) {
    $expData = explode('|', $data);
    if (isset($expData[15])) {
        $pageNo = !empty($expData[0]) ? $expData[0] : '';
        $dos = !empty($expData[1]) ? $expData[1]: 'Undated';
        //$dos = !empty($expData[1]) ? date('F d,Y', strtotime($expData[1])) : 'Undated';
        $patien_name = !empty($expData[2]) ? $expData[2] : '';
        $category = !empty($expData[3]) ? $expData[3] : '';
        $providerName = !empty($expData[4]) ? str_replace("^"," ,",$expData[4]) : '';
        $gender = !empty($expData[5]) ? $expData[5] : '';
        $doi = !empty($expData[6]) ? $expData[6]: 'Undated';
        //$doi = !empty($expData[6]) ? $expData[6] : '';
        $facility = !empty($expData[7]) ? $expData[7] : '';
        $catName = !empty($expData[8]) ? $expData[8] : '';
        $dob = !empty($expData[9]) ?$expData[9]: '';
        $type = !empty($expData[10]) ? $expData[10] : '';
        $current_date = !empty($expData[11]) ? $expData[11] : '';
        $title = !empty($expData[12]) ? $expData[12] : '';
        $index = !empty($expData[13]) ? $expData[13] : '';
        $allocated_id = !empty($expData[14]) ? $expData[14] : '';
        //$summary = !empty($expData[15]) ? $expData[15] : '';
        if($project->skip_edit ==0)
        {
            $summary = $summaryTemp[$temp3];
        }
         else{
             $summary ="No Summary";
         }
        $temp3++;
    } else {
        continue;
    }
    if ($firstTime) {

        echo '<span>Medical Records of Candice ' . $patien_name . '</span>';
        echo '<h5><b>GP Records</b></h5>';
        $firstTime = false;
    }
    echo '<p>On &nbsp;<b>' . $dos . '</b>,&nbsp; ' . $summary . '</p>';
    $i++;
}
?>
</table>
</body>
</html>