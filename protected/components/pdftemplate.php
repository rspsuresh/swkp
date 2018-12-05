<?php

class pdftemplate extends FPDF1 {

    var $widths;
    var $aligns;

    function LoadData($file) {
        $lines = file($file);
        $data = array();
        $summaryTemp = array();
        $temp = 0;
        $temp1 = 0;
        $summaryTemp = array();
        foreach ($lines as $key => $line) {
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
        foreach ($lines as $key => $line) {
            $tempData = explode('|', trim($line));
            if (isset($tempData[15])) {
                $dos = empty($tempData[1]) ? "Undated" : $tempData[1];
                $page = empty($tempData[0]) ? "" : $tempData[0];
                $provider = empty($tempData[4]) ? "" :str_replace('^', ' ,',$tempData[4]);
                $summary = $summaryTemp[$temp3];
                $catId = empty($tempData[8]) ? "" : $tempData[8];
                $doi = empty($tempData[6]) ? "" : $tempData[6];
                $facility = empty($tempData[7]) ? "" : $tempData[7];
                $patname = empty($tempData[2]) ? "" : $tempData[2];
                $dob = empty($tempData[9]) ? "" : $tempData[9];
                $temp3++;
            } else {
                continue;
            }
            $tempData = array($dos, $page, $provider, $summary, $catId, $doi, $facility, $patname,$dob);
            $data[] = $tempData;
        }
        return $data;
    }

// Simple table
    function SocalTemplate($header, $data) {
        $this->SetY($this->GetY() + 17);
        $this->SetLineWidth(0.7);
        $this->Line($this->GetX() + 5, $this->GetY(), $this->GetX() + 165, $this->GetY());
        $this->SetLineWidth(0);

        $this->SetFont('Times', 'B', 11.5);
        $this->Cell(27, 9, "Control No:");
        $this->SetFont('Times', '', 11.5);
        $this->Cell("", 9, " 402857-06");
        $this->Ln();
//        $this->Ln();

        $this->SetFont('Times', 'BU', 11.5);
        $this->Cell("", 7, "Medical Record Excerpt & Outline", 0, 0, "C");
        $this->Ln();
        $this->Ln();

        $this->SetFont('Times', '', 11.5);
        $this->Cell(30, 7, "Patient Name");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, $data[0][7]);
//        $this->Ln();

        $this->Cell(30, 7, "Social Security No.");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, "XXX-XX-1614");

        $this->Cell(30, 7, "Date of Birth");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, $data[0][8]);

        $this->Cell(30, 7, "Date of Injury");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, $data[0][5]);

        $this->Cell(30, 7, "Records of");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, $data[0][6]);
        $this->Ln();

// Header
        $this->SetFont('Times', 'B', 11.5);
        $headerWidth = array(30, 30, 40, 90);
//        foreach ($header as $col){
        $this->Row(array($header[0], $header[1], $header[2], $header[3]), "H", "", "B");
//            $this->Cell($headerWidth[$hwI], 7, $col, 1);
//        }
        $i = 0;
        $this->SetFont('Times', '', 11.5);
        $catSumBrk = "3";
        foreach ($data as $row) {
            $summary = $row[4] . PHP_EOL . $row[3];
            $this->Row(array($row[0], $row[1], $row[2], $summary), "C", $catSumBrk);
//            $this->Ln();
            $i++;
        }
    }

	// Simple table
    function BactespdfTemplate($header, $filename, $pid, $f_id) {
		
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
				'msterm' => !empty($expData[16]) ? $expData[16] : '',
				'msvalue' => !empty($expData[17]) ? $expData[17] : '',

			);
		}		

		/* 'dx_terms' => !empty($expData[16]) ? str_replace('^', '<br>', $expData[16]) : '',
				'uni_dx_terms' => !empty($expData[16]) ? $expData[16] : '',*/
		$headerName = $patien_name;
		$headerDob = $dob;
		$SumIcd9 = array_filter($SumIcd9);
		$SumIcd10 = array_filter($SumIcd10);
		//Date Sort
		/*if (!function_exists('date_sort')) {
			function date_sort($a, $b) {
				$t1 = strtotime($a['sort_dos']);
				$t2 = strtotime($b['sort_dos']);
				return $t2 - $t1;
			}
		}*/
		$tempDate = $oldata;
		/*echo "<pre>";
		print_r($tempDate);
		die();*/
		
		//usort($tempDate, "date_sort");
		$sort = array();
		foreach($tempDate as $k=>$v) {
			$sort['sort_dos'][$k] = $v['sort_dos'];
			$sort['msterm'][$k] = $v['msterm'];
		}
		# sort by event_type desc and then title asc
		array_multisort($sort['sort_dos'], SORT_DESC, $sort['msterm'], SORT_ASC,$tempDate);
		
		$tempCount = count($tempDate);
		$indexCount = $tempCount - 1;
		//unique proceess
		$uni_ms_term = $uni_ms_value = $uni_body = $uni_provider = $uni_facility = $uni_dos1 = $uni_dos2 = $uni_dx_terms = $unique_providerName = array();
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
			if (!empty($value['msterm'])) {
				$uni_ms_term [] = trim($value['msterm']);
			}
			if (!empty($value['msvalue'])) {
				$uni_ms_value [] = trim($value['msvalue']);
			}
			$uni_body = array_merge($uni_body, explode("^", $value['unique_body']));
			$unique_providerName = array_merge($unique_providerName, explode("^", $value['uniqueproviderName']));
			$uni_dos1 = array_merge($uni_dos1, explode("^", $value['uni_diagonis1']));
			$uni_dos2 = array_merge($uni_dos2, explode("^", $value['uni_diagonis2']));
			$uni_dx_terms = array_merge($uni_dx_terms, explode("^", $value['uni_dx_terms']));

		}
		sort($uni_ms_term);

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
		//MsTerm
		if ($uni_ms_term) {
			$uni_ms_term = FileInfo::checkUniq($uni_ms_term);
		}
		//MsValue
		if ($uni_ms_value) {
			$uni_ms_value = FileInfo::checkUniq($uni_ms_value);
		}
        $this->SetY($this->GetY() + 17);
        $this->SetLineWidth(0.7);
        //$this->Line($this->GetX() + 5, $this->GetY(), $this->GetX() + 165, $this->GetY());
        $this->SetLineWidth(0);

        $this->SetFont('Times', 'B', 11.5);
        $this->Cell(27, 9, "Patient Name:");
        $this->SetFont('Times', '', 11.5);
        $this->Cell("", 9, $headerName);
        $this->Ln(7);
		
		$this->SetFont('Times', 'B', 11.5);
        $this->Cell(12, 9, "DOB:");
        $this->SetFont('Times', '', 11.5);
        $this->Cell("", 9, FileInfo::dateformat($headerDob, $pid));
        $this->Ln();
//        $this->Ln();

        $this->SetFont('Times', 'BU', 11.5);
        $this->Cell("", 7, "Summarization", 0, 0, "C");
        $this->Ln();
        $this->Ln();

        $this->SetFont('Times', '', 11.5);
        $this->Cell(30, 7, "Measure Value");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $uni_ms_value));
//        $this->Ln();

        $this->Cell(30, 7, "Specific Index Term");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $uni_ms_term));
		
		$this->Cell(30, 7, "Date Range");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, $startDate . ' through ' . $endDate);
		
        $this->Cell(30, 7, "Providers");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $unique_providerName));

        $this->Cell(30, 7, "Facilities");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $uni_facility));
		$this->Ln();
		$this->Ln();
		
		$this->SetFont('Times', 'BU', 11.5);
        $this->Cell("", 7, "Index", 0, 0, "C");
        $this->Ln();
        $this->Ln();
        
// Header
        $this->SetFont('Times', 'B', 11.5);
        $headerWidth = array(30,40,30,50,40,30);
//        foreach ($header as $col){
       // $this->Row(array($header[0], $header[1], $header[2], $header[3], $header[4], $header[5], $header[6], $header[7], $header[8]), "H", "", "B","B");
        $this->Row(array($header[0], $header[1], $header[2], $header[3], $header[4], $header[5]), "H", "", "B","BT");
//            $this->Cell($headerWidth[$hwI], 7, $col, 1);
//        }
        $i = 0;
        $this->SetFont('Times', '', 11.5);
        $catSumBrk = "3";
		/*foreach (file($filename) as $datum) {
			$linedata = explode("|",$datum);
			if(isset($linedata) && !empty($linedata)){
				$dateofser = !empty($linedata[1])?$linedata[1]:"Undated";
				$bodypt = !empty($linedata[14])?implode(",",explode("^",$linedata[14])):"";
				$provdr = !empty($linedata[4])?implode("/",explode("^",$linedata[4])):"";
				$diagonis1 = trim($tempDate[$i]['diagonis1']);
				$diagonis1 = !empty($diagonis1)?implode(",",explode("<br>",$diagonis1)):"";
                $diagonis2 = trim($tempDate[$i]['diagonis2']);
				$diagonis2 = !empty($diagonis2)?implode(",",explode("<br>",$diagonis2)):"";
                $dx_terms = trim($tempDate[$i]['dx_terms']);
				$dx_terms = !empty($dx_terms)?implode(",",explode("<br>",$dx_terms)):"";
				$this->Row(array($dateofser,$bodypt, $provdr,$linedata[7],"ICD-9 Codes:   $diagonis1 \n ICD-10 Codes:  $diagonis2 \n Dx-Terms:  $dx_terms",$linedata[8],$fileNam,!empty($tempDate[$i]['subpageno']) ? implode(' / ',array_keys($tempDate[$i]['subpageno'])) : $fileNam,$linedata[0]), "C", $catSumBrk,"","B");
			$i++;
			}
		}*/
		
		for ($j = 0; $j < $tempCount; $j++) {
			$tempDate[$j]['bodyparts'] = str_replace("&nbsp;"," ",$tempDate[$j]['bodyparts']);
			$tempDate[$j]['providerName'] = str_replace("&nbsp;"," ",$tempDate[$j]['providerName']);
			$diagonis1 = trim($tempDate[$j]['diagonis1']);
			$diagonis1 = !empty($diagonis1)?implode(", ",explode("<br>",$diagonis1)):"";
            $diagonis2 = trim($tempDate[$j]['diagonis2']);
			$diagonis2 = !empty($diagonis2)?implode(", ",explode("<br>",$diagonis2)):"";
            $dx_terms = trim($tempDate[$j]['dx_terms']);
			$dx_terms = !empty($dx_terms)?implode(", ",explode("<br>",$dx_terms)):"";
				//$this->Row(array($tempDate[$j]['dos'],$tempDate[$j]['bodyparts'], $tempDate[$j]['providerName'],$tempDate[$j]['facility'],"ICD-9 Codes:   $diagonis1 \n\n ICD-10 Codes:  $diagonis2 \n Dx-Terms:  $dx_terms",$tempDate[$j]['category'],$fileNam,!empty($tempDate[$j]['subpageno']) ? implode(' / ',array_keys($tempDate[$j]['subpageno'])) : $fileNam,!empty($tempDate[$j]['subpageno']) ? implode(' / ',array_values($tempDate[$j]['subpageno'])) : $tempDate[$j]['pageno']), "C", $catSumBrk,"","B");
				$this->Row(array($tempDate[$j]['msterm'],$tempDate[$j]['dos'], $tempDate[$j]['providerName'],$tempDate[$j]['facility'], !empty($tempDate[$j]['subpageno']) ? implode(' / ',array_keys($tempDate[$j]['subpageno'])) : $fileNam,!empty($tempDate[$j]['subpageno']) ? implode(' / ',array_values($tempDate[$j]['subpageno'])) : $tempDate[$j]['pageno']), "C", $catSumBrk,"","BT");
		}
        /*foreach ($datum as $row) {
            $summary = $row[4] . PHP_EOL . $row[3];
            //$this->Row(array($row[0], $row[1], $row[2], $summary), "C", $catSumBrk);
            $this->Row(array($row[0], $row[1], $row[2], $summary), "C", $catSumBrk,"","B");
//            $this->Ln();
            $i++;
        }*/
    }
	
	// Simple table
    function BactesTemplate($header, $filename, $pid, $f_id) {
		
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
		
        $this->SetY($this->GetY() + 17);
        $this->SetLineWidth(0.7);
        //$this->Line($this->GetX() + 5, $this->GetY(), $this->GetX() + 165, $this->GetY());
        $this->SetLineWidth(0);

        $this->SetFont('Times', 'B', 11.5);
        $this->Cell(27, 9, "Patient Name:");
        $this->SetFont('Times', '', 11.5);
        $this->Cell("", 9, $headerName);
        $this->Ln(7);
		
		$this->SetFont('Times', 'B', 11.5);
        $this->Cell(12, 9, "DOB:");
        $this->SetFont('Times', '', 11.5);
        $this->Cell("", 9, FileInfo::dateformat($headerDob, $pid));
        $this->Ln();
//        $this->Ln();

        $this->SetFont('Times', 'BU', 11.5);
        $this->Cell("", 7, "Summarization", 0, 0, "C");
        $this->Ln();
        $this->Ln();

        $this->SetFont('Times', '', 11.5);
        $this->Cell(30, 7, "Date Range");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, 'Medical records provided for review a timeframe from'.$startDate . ' through ' . $endDate);
//        $this->Ln();

        $this->Cell(30, 7, "Body Parts");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $uni_body));

        $this->Cell(30, 7, "Providers");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $unique_providerName));

        $this->Cell(30, 7, "Facilities");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
        $this->MultiCell(70, 7, implode(',', $uni_facility));

        $this->Cell(30, 7, "Diagnoses");
        $this->SetX($this->GetX() + 60);
        $this->Cell(10, 7, ":");
		$icd9 = implode(',', $uni_dos1);
		$icd10 = implode(',', $uni_dos2);
        $dxtrm = implode(',', $uni_dx_terms);
		$this->MultiCell(70, 7, " ICD-9 Codes:   $icd9 \n ICD-10 Codes:   $icd10 \n Dx-Terms:   $dxtrm");
        $this->Ln();

		$this->SetFont('Times', 'BU', 11.5);
        $this->Cell("", 7, "Index", 0, 0, "C");
        $this->Ln();
        $this->Ln();
// Header
        $this->SetFont('Times', 'B', 11.5);
        $headerWidth = array(17,22,20,20,20,20,20,20,30);
//        foreach ($header as $col){
        $this->Row(array($header[0], $header[1], $header[2], $header[3], $header[4], $header[5], $header[6], $header[7], $header[8]), "H", "", "B","B");
//            $this->Cell($headerWidth[$hwI], 7, $col, 1);
//        }
        $i = 0;
        $this->SetFont('Times', '', 11.5);
        $catSumBrk = "3";
		/*foreach (file($filename) as $datum) {
			$linedata = explode("|",$datum);
			if(isset($linedata) && !empty($linedata)){
				$dateofser = !empty($linedata[1])?$linedata[1]:"Undated";
				$bodypt = !empty($linedata[14])?implode(",",explode("^",$linedata[14])):"";
				$provdr = !empty($linedata[4])?implode("/",explode("^",$linedata[4])):"";
				$diagonis1 = trim($tempDate[$i]['diagonis1']);
				$diagonis1 = !empty($diagonis1)?implode(",",explode("<br>",$diagonis1)):"";
                $diagonis2 = trim($tempDate[$i]['diagonis2']);
				$diagonis2 = !empty($diagonis2)?implode(",",explode("<br>",$diagonis2)):"";
                $dx_terms = trim($tempDate[$i]['dx_terms']);
				$dx_terms = !empty($dx_terms)?implode(",",explode("<br>",$dx_terms)):"";
				$this->Row(array($dateofser,$bodypt, $provdr,$linedata[7],"ICD-9 Codes:   $diagonis1 \n ICD-10 Codes:  $diagonis2 \n Dx-Terms:  $dx_terms",$linedata[8],$fileNam,!empty($tempDate[$i]['subpageno']) ? implode(' / ',array_keys($tempDate[$i]['subpageno'])) : $fileNam,$linedata[0]), "C", $catSumBrk,"","B");
			$i++;
			}
		}*/
		
		for ($j = 0; $j < $tempCount; $j++) {
			$tempDate[$j]['bodyparts'] = str_replace("&nbsp;"," ",$tempDate[$j]['bodyparts']);
			$tempDate[$j]['providerName'] = str_replace("&nbsp;"," ",$tempDate[$j]['providerName']);
			$diagonis1 = trim($tempDate[$j]['diagonis1']);
			$diagonis1 = !empty($diagonis1)?implode(", ",explode("<br>",$diagonis1)):"";
            $diagonis2 = trim($tempDate[$j]['diagonis2']);
			$diagonis2 = !empty($diagonis2)?implode(", ",explode("<br>",$diagonis2)):"";
            $dx_terms = trim($tempDate[$j]['dx_terms']);
			$dx_terms = !empty($dx_terms)?implode(", ",explode("<br>",$dx_terms)):"";
				$this->Row(array($tempDate[$j]['dos'],$tempDate[$j]['bodyparts'], $tempDate[$j]['providerName'],$tempDate[$j]['facility'],"ICD-9 Codes:   $diagonis1 \n\n ICD-10 Codes:  $diagonis2 \n Dx-Terms:  $dx_terms",$tempDate[$j]['category'],$fileNam,!empty($tempDate[$j]['subpageno']) ? implode(' / ',array_keys($tempDate[$j]['subpageno'])) : $fileNam,!empty($tempDate[$j]['subpageno']) ? implode(' / ',array_values($tempDate[$j]['subpageno'])) : $tempDate[$j]['pageno']), "C", $catSumBrk,"","B");
		}
        /*foreach ($datum as $row) {
            $summary = $row[4] . PHP_EOL . $row[3];
            //$this->Row(array($row[0], $row[1], $row[2], $summary), "C", $catSumBrk);
            $this->Row(array($row[0], $row[1], $row[2], $summary), "C", $catSumBrk,"","B");
//            $this->Ln();
            $i++;
        }*/
    }
// Better table
//    function ImprovedTable($header, $data) {
//        // Column widths
//        $w = array(40, 35, 40, 45);
//        // Header
//        for ($i = 0; $i < count($header); $i++)
//            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
//        $this->Ln();
//        // Data
//        foreach ($data as $row) {
//            $this->Cell($w[0], 6, $row[0], 'LR');
//            $this->Cell($w[1], 6, $row[1], 'LR');
//            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
//            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
//            $this->Ln();
//        }
//        // Closing line
//        $this->Cell(array_sum($w), 0, '', 'T');
//    }
//
//// Colored table
//    function FancyTable($header, $data) {
//        // Colors, line width and bold font
//        $this->SetFillColor(255, 0, 0);
//        $this->SetTextColor(255);
//        $this->SetDrawColor(128, 0, 0);
//        $this->SetLineWidth(.3);
//        $this->SetFont('', 'B');
//        // Header
//        $w = array(30, 30, 40, 70);
//        for ($i = 0; $i < count($header); $i++)
//            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
//        $this->Ln();
//        // Color and font restoration
//        $this->SetFillColor(224, 235, 255);
//        $this->SetTextColor(0);
//        $this->SetFont('');
//        // Data
//        $fill = false;
//        foreach ($data as $row) {
//            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
//            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
//            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
//            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
//            $this->Ln();
//            $fill = !$fill;
//        }
//        // Closing line
//        $this->Cell(array_sum($w), 0, '', 'T');
//    }

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data, $align = "", $catSumBrk = "", $style = "", $action = "") {
        //Calculate the height of the row
        $nb = 0;
		if($action == ""){
			$this->SetWidths(array(30, 30, 40, 70));
			if ($align == "H") {
				$this->SetAligns(array("C", "C", "C", "C"));
			} else {
				$this->SetAligns(array("L", "L", "L", "L"));
			}
		}
		else if($action == "B"){
			$this->SetWidths(array(17,22,20,20,20,20,20,20,30));
		}
		else if($action == "BT"){
			$this->SetWidths(array(25,35,25,45,35,25));
		}
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->SetFont("Times", $style, 11.5);

//            $k = 1; 
//            if($i == $catSumBrk){
//               $k = 2;
//                $this->SetFont("","B",11.5);
//                $lastx = $this->GetX();
//                $lasty = $this->GetY();
//                $this->Write(5,'www.fpdf.org');
//                $this->SetXY($lastx,$lasty+10);
//                $this->SetFont("","",11.5);
//                $this->MultiCell($w, 5, $data[$i], 0, $a,"",$catSumBrk);
//            }

            $this->MultiCell($w, 5, $data[$i], 0, $a);

//            $this->writeHTML('This is my disclaimer. <b>THESE WORDS NEED TO BE BOLD.</b> These words do not need to be bold.');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

//    function GenerateWord() {
//        //Get a random word
//        $nb = rand(3, 10);
//        $w = '';
//        for ($i = 1; $i <= $nb; $i++)
//            $w.=chr(rand(ord('a'), ord('z')));
//        return $w;
//    }
//
//    function GenerateSentence() {
//        //Get a random sentence
//        $nb = rand(1, 10);
//        $s = '';
//        for ($i = 1; $i <= $nb; $i++)
//            $s.= $this->GenerateWord() . ' ';
//        return substr($s, 0, -1);
//    }
}
