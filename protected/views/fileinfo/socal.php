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
                table{
                    table-layout: fixed;
                }

            }
            body{
                line-height:1.5;
                font-family: Futura;font-size:14;
            }



        </style>
    </head>
    <body>
        <hr style="height: 3px;width: 90%;border: none;color:#333;background-color:#333;">
            <table style="width: 100%;table-layout:fixed">
                <col width="50">
                    <col width="50">
                        <tr><b>Control No:</b> 402857-06</tr>
                        <tr></tr>
                        <tr>
                            <th colspan="4" align="center"><h3>Medical Record Review</h3></th>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <?php
                        $project=Project::model()->findByPk($pid);
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
                                    } else {
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
                                $providerName = !empty($expData[4]) ? $expData[4] : '';
                                $gender = !empty($expData[5]) ? $expData[5] : '';
                                $doi = !empty($expData[6]) ?$expData[6]: '';
                                $facility = !empty($expData[7]) ? $expData[7] : '';
                                $catName = !empty($expData[8]) ? $expData[8] : '';
                                $dob = !empty($expData[9]) ? $expData[9]: '';
                                $type = !empty($expData[10]) ? $expData[10] : '';
                                $current_date = !empty($expData[11]) ? $expData[11] : '';
                                $title = !empty($expData[12]) ? $expData[12] : '';
                                $index = !empty($expData[13]) ? $expData[13] : '';
                                $allocated_id = !empty($expData[14]) ? $expData[14] : '';
                                // $summary = !empty($expData[15]) ? $expData[15] : '';
                                if($project->skip_edit == 0)
                                {
                                    $summary = $summaryTemp[$temp3];
                                }
                                else
                                {
                                    $summary ='';
                                }


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

                                echo '<br/>';
                                echo '<br/>';
                                //Print table boreder
                                echo '<table style="border-collapse: collapse;width: 100%;">';
                                echo '<tr>';
                                echo '<th style="border: 1px solid black;width:20%">Date of Service</th>';
                                echo '<th style="border: 1px solid black;width:20%">Page NO</th>';
                                echo '<th style="border: 1px solid black;width:20%">Provider</th>';
                                echo '<th style="border: 1px solid black;width:40%">Excerpt</th>';
                                echo '</tr>';
                                $firstTime = false;
                            }
                            echo '<tr>';
                            echo '<td style="border: 1px solid black;20%">' . $dos . '</td>';
                            echo '<td style="border: 1px solid black;width:20%">' . str_replace(","," ,",$pageNo) . '</td>';
                            echo '<td style="border: 1px solid black;width:20%">' . str_replace("^"," ,",$providerName). '</td>';
                            echo '<td style="border: 1px solid black;width:40%">' . $summary . '</td>';
                            echo '</tr>';
                            $i++;
                        }
                        ?>
                        </table>
                        </body>
                        </html>