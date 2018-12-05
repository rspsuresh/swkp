<?php

/**
 * Class Filerecord
 * get a record based on File
 */
class Downloadtemplates extends CApplicationComponent
{


    // codes for xls

    public function WOSXLS($filename,$type='', $pid, $f_id)
    {
        $fileInfo = FileInfo::model()->findByPk($f_id);
        $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
        $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
        $prject_name = Project::model()->findByPk($project_id);
        $criteria=new CDbCriteria;
        $criteria->condition = "ja_partition_id !=0 AND ja_file_id = :ja_file_id AND ja_status =:ja_status ";
        $criteria->params = array (
            ':ja_file_id' => $f_id,
            ':ja_status' =>'QC',
        );
        $filePartition = JobAllocation::model()->find( $criteria );
        $rvrname = $filePartition->Rvrname->ud_name;
        $dir = "filepartition/" . $project_id . "_breakfile";
        $p_name = $prject_name->p_name;
        $heading = array('Page Nos', 'DOS [MM/DD/YY]', 'Provider', 'Title [Type of Service]', 'Category',
            'Summary', 'LastName', 'ReviewerName', 'MPN Reviewer Name', 'FileNameOrder');

        $fields = array('page_no', 'fl_dos', 'fl_provider', 'type_of_service', 'fl_category', 'fl_summary', 'l_name', 'rvr_nmae', 'mpn_rvr_name', 'fi_name');
        $files = array();
        $Sfiles = array();
        $subpages = '';

        if (is_dir($dir)) {
            $file_dir = $dir . "/" . $f_id . ".txt";
            if (file_exists($file_dir)) {
                $i = 0;
                $k = 0;
                $multiPages = array();
                foreach (file($file_dir) as $line) {
                    $exp_file = explode('|', trim($line));
                    $cat = Category::model()->findByPk($exp_file[3]);
                    $catname = $cat ? $cat->ct_cat_name : '';

                    if ($exp_file[1] != '') {
                        $files[$i]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
                        if (!empty($exp_file[0]) && $fileInfo->fi_split_files != "") {
                            $tempSubpages = explode(",", $exp_file[0]);
                            $mergefiles = FileinfoController::actionMultifile($tempSubpages, $fileInfo->fi_file_id);
                        }
                        $files[$i]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
                        $files[$i]['type_of_service'] = isset($exp_file[12]) ? $exp_file[12] : "";
                        $files[$i]['fi_summary'] = '';
                        $files[$i]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";;
                        $files[$i]['rvr_nmae'] = $rvrname;
                        $files[$i]['mpn_rvr_name'] = '';
                        $files[$i]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                        $files[$i]['fl_category'] = $catname;
                        $files[$i]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                        if($prject_name->skip_edit == 0){
							$files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
						}
						else{
							$files[$i]['fl_summary'] = "";
						}
                        $i++;
                    } else {
                        $Sfiles[$k]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
                        if (!empty($exp_file[0]) && $fileInfo->fi_split_files != "") {
                            $tempSubpages = explode(",", $exp_file[0]);
                            $mergefiles = FileinfoController::actionMultifile($tempSubpages, $fileInfo->fi_file_id);
                        }
                        $Sfiles[$k]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
                        $Sfiles[$k]['type_of_service'] = isset($exp_file[12]) ? $exp_file[12] : "";
                        $Sfiles[$k]['fi_summary'] = '';
                        $Sfiles[$k]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";;
                        $Sfiles[$k]['rvr_nmae'] = $rvrname;
                        $Sfiles[$k]['mpn_rvr_name'] = '';
                        $Sfiles[$k]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                        $Sfiles[$k]['fl_category'] = $catname;
                        $Sfiles[$k]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                        if($prject_name->skip_edit == 0){
							$Sfiles[$k]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
						}
						else{
							$Sfiles[$k]['fl_summary'] = "";
						}
                        $k++;
                    }
                }

                function date_sort($a, $b)
                {
                    /*$t1 = strtotime($a['fl_dos']);
                    $t2 = strtotime($b['fl_dos']);


                    return $t1 - $t2;
					*/
					$retval = strtotime($a['fl_dos']) - strtotime($b['fl_dos']);
					if ($retval == 0) {
						$retval = $a['fi_name'] - $b['fi_name'];
					}
					return $retval;

                }

                usort($files, "date_sort");
                foreach ($Sfiles as $key => $lines) {
                    array_push($files, $Sfiles[$key]);
                }

            }
        }
        XlsExporter::downloadXls('Completed', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);
    }

    public function WSXLS($filename,$type='', $pid, $f_id)
    {
        $heading = array('Page Numbers', 'DOS', 'Patient Name', 'Category', 'Provider', 'Processed Date', 'Summary', 'File');
        $fields = array('page_no', 'fl_dos', 'fl_patient', 'fl_category', 'fl_provider', 'fl_proc_date', 'fl_summary', 'fi_name');
        $files = array();
        $fileInfo = FileInfo::model()->findByPk($f_id);
        $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
        $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
        $prject_name = Project::model()->findByPk($project_id);
        $criteria=new CDbCriteria;
        $criteria->condition = "ja_partition_id !=0 AND ja_file_id = :ja_file_id AND ja_status =:ja_status ";
        $criteria->params = array (
            ':ja_file_id' => $f_id,
            ':ja_status' =>'QC',
        );
        $filePartition = JobAllocation::model()->find( $criteria );
        $rvrname = $filePartition->Rvrname->ud_name;
        $dir = "filepartition/" . $project_id . "_breakfile";
        $p_name = $prject_name->p_name;
        if (is_dir($dir)) {
            $file_dir = $dir . "/" . $f_id . ".txt";
            if (file_exists($file_dir)) {
                $i = 0;
                foreach (file($file_dir) as $line) {
                    $exp_file = explode('|', trim($line));
                    $cat = Category::model()->findByPk($exp_file[3]);
                    $catname = $cat ? $cat->ct_cat_name : '';
                    $files[$i]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
                    if (!empty($exp_file[0]) && $fileInfo->fi_split_files != "") {
                        $tempSubpages = explode(",", $exp_file[0]);
                        $mergefiles = FileinfoController::actionMultifile($tempSubpages, $fileInfo->fi_file_id);
                    }
                    $files[$i]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
                    $files[$i]['fl_patient'] = isset($exp_file[2]) ? $exp_file[2] : "";
                    $files[$i]['fl_category'] = $catname;
                    $files[$i]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                    $files[$i]['fl_proc_date'] = isset($exp_file[6]) ? $exp_file[6] : "";
                    $files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
                    $files[$i]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                    $i++;
                }
            }
        }
        XlsExporter::downloadXls(time() . 'sxlsCompleted', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);
    }

    //codes for XML

    public function NXML($filename,$type='', $pid, $f_id)
    {
        $criteria=new CDbCriteria;
        $criteria->condition = "ja_partition_id !=0 AND ja_file_id = :ja_file_id AND ja_status =:ja_status ";
        $criteria->params = array (
            ':ja_file_id' => $f_id,
            ':ja_status' =>'QC',
        );
        $filePartition = JobAllocation::model()->find( $criteria );
        $rvrname = $filePartition->Rvrname->ud_name;
        if (file_exists($filename)) {
            $pat_name = '';
            $doc_name = '';
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><RecordsManifest></RecordsManifest>');
            $xml->addAttribute('xmlns:xsd', 'http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance');
            $xml->addAttribute('ControlNum', date('Y-d-m'));
            if (file_exists($filename)) {
                $i = 0;
                $j = 1;
                $k = 1;
                foreach (file($filename) as $line) {
                    $explodeLine = explode('|', trim($line));
                    if ($i == 0) {
                        if (!empty($explodeLine[2])) {
                            $xml->addChild('LastName', $explodeLine[2]);
                        }
                        if (!empty($explodeLine[4])) {
                            $xml->addChild('ReviewerName', $rvrname);
                        }
                        $xml->addChild('ParaReviews');
                        $xml->addChild('Categories');
                        $xml->addChild('Pages');
                    }
                    //Page Review..
                    $pageReview = $xml->ParaReviews->addChild('ParaReview');
                    $pageReview->addAttribute('ParaReviewID', $j);
                    //$dos = !empty($explodeLine[1]) ? FileInfo::dateformat($explodeLine[1], $pid) : 'Undated';
                    $pageReview->addAttribute('DOS', $explodeLine[1]);

                    $providerName = !empty($explodeLine[4]) ? str_replace("^", " ,", $explodeLine[4]) : "";
                    $facility = !empty($explodeLine[7]) ? str_replace("^", " ,", $explodeLine[7]) : "";
                    $provider = $providerName;
                    $pageReview->addAttribute('Provider', $provider);
                    $pageReview->addAttribute('Facility', $facility);
                    $title = !empty($explodeLine[9]) ? $explodeLine[9] : "Progress Notes";
                    $pageReview->addAttribute('Title', $title);
                    $summary = !empty($explodeLine[10]) ? $explodeLine[10] : "";
                    $pageReview->addAttribute('Summary', $summary);

                    //Category
                    $category = $xml->Categories->addChild('Category ');
                    $category->addAttribute('CategoryID', $j);
                    $cat = !empty($explodeLine[3]) ? $explodeLine[3] : "";
                    $categoryQuery = Category::model()->findByPk($cat);
                    $catName = $categoryQuery ? $categoryQuery->ct_cat_name : '-';
                    $category->addAttribute('Title', $catName);
                    $category->addAttribute('Tab', $catName);
                    //Pages

                    if (!empty($explodeLine[0])) {

                        $pageNo = explode(',', $explodeLine[0]);
                        foreach ($pageNo as $pag) {
                            $pages = $xml->Pages->addChild('Page');
                            $pages->addAttribute('PageID', $pag);
                            $pages->addAttribute('CategoryID', $cat);
                            // ParaReviews
                            $pages->addChild('ParaReviews');
                            $subParam = $pages->ParaReviews->addChild('ParaReview');

                            //ParaReview
                            $subParam->addAttribute('ParaReviewID', '1');

                            $k++;
                        }
                    }
                    $i++;
                    $j++;
                }
            }
            ///$xml->asXML();
            if (!is_dir(Yii::app()->basePath . "/../xmlDocument/")) {
                mkdir(Yii::app()->basePath . "/../xmlDocument/", 0777, true);
            }
            $file = 'xmlDocument/config.xml';
            $xml->asXML($file);
            if (file_exists($file)) {
                header("Content-type: text/xml");
                header('Content-Disposition: attachment; filename="file.xml"');
                $xml_file = file_get_contents($file);
                echo $xml_file;
            }
        }
    }

// code for PDF files

    public function PDF($filename,$type='', $pid,$f_id) {
        require_once 'fpdf/fpdf.php';
        // require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
        // $pdf1 = new PDFMerger();
        /* check Current date */
        if (file_exists($filename)) {
        // Column headings
            $header = array('Date of Service', 'Page No.', 'Provider', 'Excerpt');
        // Data loading

            $data = $pdf->LoadData($filename);
            $pdf->SetFont('Times', '', 11.5);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(30, 50, 30, 40));
            $pdf->AddPage('P', 'A4');
            $pdf->SocalTemplate($header, $data);
            $tempfilename = 'samplepdfs/final.pdf';

            $pdf->Output($tempfilename, 'F');

            $mainFile = FileInfo::model()->findByPk($_REQUEST['f_id']);

            $this->actionMikeoutput($filename, $mainFile->fi_file_ori_location);
        }
    }

    public function actionMikeoutput($filename, $mainFile) {

        require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf1 = new PDFMerger();

        $mergePages = $this->actionGetpdfpages(array("Dr. Notes"), $filename);
        $docnotes = isset($mergePages['Dr. Notes']) ? $mergePages['Dr. Notes'] : "";
        $pdf1->addPDF('samplepdfs/final.pdf', 'all');
        if (!empty($docnotes)) {
            $pdf1->addPDF($mainFile, $docnotes);
        }

        // ->merge('file', 'samplepdfs/TEST2.pdf');
        $pdf1->merge('/samplepdfs/TEST2.pdf');
        // $pdf1->merge('download', 'samplepdfs/test.pdf');
    }


    public function actionGetpdfpages($catNameArray = "", $filename = "") {
        //  $project = "1_breakfile";
        //  $f_id = 3;
        //  $filename = "filepartition\\" . $project . '\\' . $f_id . " . txt";
        $partition = file($filename);
        $temp = array();
        $docFiles = array();

        foreach ($partition as $key => $val) {
            $pagesArr = explode("|", $partition[$key]);
            if (isset($pagesArr[3]) && $pagesArr[3] == 1) { //Dr.notes done statically for temporary purpose
                array_push($temp, $pagesArr[0]);
            }
        }
        if (!empty($temp)) {
            $docFiles['Dr. Notes'] = implode(",", $temp);
        }

        return $docFiles;
    }

	
	public function BACTESPDF($filename,$type='', $pid,$f_id) {
        require_once 'fpdf/fpdf.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
        /* check Current date */
        if (file_exists($filename)) {
        // Column headings
            $header = array('Measure Terms', 'Date of Service', 'Providers', 'Facilitites', 'Bates/References', 'Pages');
        // Data loading

            $data = $pdf->LoadData($filename);
			/*foreach (file($filename) as $datum) {
				$linedata = explode("|",$datum);
				if(isset($linedata) && !empty($linedata)){
					echo "<pre>";
					print_r($linedata);
					
				}
			}
			die();*/
            $pdf->SetFont('Times', '', 11.5);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(30, 50, 30, 40));
            $pdf->AddPage('P', 'A4');
            $pdf->BactespdfTemplate($header, $filename, $pid, $f_id);

            $tempfilename = 'samplepdfs/final.pdf';

            $pdf->Output($tempfilename, 'F');
			
			$mainFile = FileInfo::model()->findByPk($f_id);

            $this->actionMerger($filename, $mainFile->fi_file_ori_location);

        }
    }
	
	public function BISPDF($filename,$type='', $pid,$f_id) {
        require_once 'fpdf/fpdf.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
        /* check Current date */
        if (file_exists($filename)) {
        // Column headings
            $header = array('Date of Service', 'Body Parts', 'Providers', 'Facilitites', 'Diagnoses', 'Category', 'Filename', 'Bates/References', 'Pages');
        // Data loading

            $data = $pdf->LoadData($filename);
			/*foreach (file($filename) as $datum) {
				$linedata = explode("|",$datum);
				if(isset($linedata) && !empty($linedata)){
					echo "<pre>";
					print_r($linedata);
					
				}
			}
			die();*/
            $pdf->SetFont('Times', '', 11.5);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(30, 50, 30, 40));
            $pdf->AddPage('P', 'A4');
            $pdf->BactesTemplate($header, $filename, $pid, $f_id);

            $tempfilename = 'samplepdfs/final.pdf';

            $pdf->Output($tempfilename, 'F');
			
			$mainFile = FileInfo::model()->findByPk($f_id);

            $this->actionMerger($filename, $mainFile->fi_file_ori_location);

        }
    }
	
	 public function actionMerger($filename, $mainFile) {

        require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf1 = new PDFMerger();

        $pdf1->addPDF('samplepdfs/final.pdf', 'all');
        $pdf1->addPDF($mainFile);

        $pdf1->merge('/samplepdfs/TEST2.pdf');
    }
	
	
    //code for DOCX
    public function WORDDOC($filename, $type='', $p_id,$f_id) {
        if (file_exists($filename)) {
            $dosSummary = "Duplicate Records<br/>";
            $pages = "";
            foreach (file($filename) as $data) {
                $expData = explode('|', $data);
                $catName = !empty($expData[8]) ? $expData[8] : '';
                if ($catName == "Duplicate") {
                    $dos = !empty($expData[1]) ? $expData[1] : 'Undated';
                    $summary = !empty($expData[15]) ? $expData[15] : '';
                    $pageNo = !empty($expData[0]) ? $expData[0] : '';
                    $dosSummary .= $dos . "-" . $summary . "<br/>";
                    $pages .= $pageNo;
                }
            }
            if ($type == 'j') {
                $doc = Yii::app()->controller->renderPartial('jvcword', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages, 'pid' => $p_id), true);
            } else {
                $doc = Yii::app()->controller->renderPartial('worddoc', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages, 'pid' => $p_id), true);
            }
            $name = 'worddoc.doc';
            $fname = file_put_contents($name, $doc);
            ob_clean();
            header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
        }
    }

    //wordDoc combine paragraph and rtable format
    public function WORDCOMBINE($filename,$type='', $pid,$f_id) {
        if (file_exists($filename)) {
            $doc=Yii::app()->controller->renderPartial('wordcombine', array('filename' => $filename, 'pid' => $pid), true);
            //$doc = $this->renderPartial('wordcombine', array('filename' => $filename, 'pid' => $pid), true);
            $name = 'wordcombine.doc';
            file_put_contents($name, $doc);
            ob_clean();
            header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
            //$this->renderPartial('worddoc',array('filename'=>$filename));
        }
    }

    //Table Paragarph table format
    public function WORDPARAGRAPH($filename,$type='', $pid,$f_id) {
        if (file_exists($filename)) {
            $doc = Yii::app()->controller->renderPartial('wordparagraph', array('filename' => $filename, 'pid' => $pid), true);
            $name = 'wordparagraph.doc';
            $fname = file_put_contents($name, $doc);
            ob_clean();
           header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
            //$this->renderPartial('worddoc',array('filename'=>$filename));
        }
    }

    public function DRG($filename, $type='',$pid, $f_id) {
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            $doc = Yii::app()->controller->renderPartial('drg', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $pid), true);
            $name = 'DRGFILENAME.doc';
            file_put_contents($name, $doc);
            ob_clean();
            header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
        }
    }

    public function CONVERTWORD($filename,$type='', $p_id, $f_id) {
        $model = FileInfo::model()->findByPk($f_id);
        $doc=Yii::app()->controller->renderPartial('printlayout', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $p_id), true);
        $name = 'FILENAME.doc';
        file_put_contents($name, $doc);
        ob_clean();
        header("Cache-Control: no-store");
        header("Expires: 0");
        header("Content-Type: application/octet-stream");
        header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
        header("Content-Transfer-Encoding: binary");
        header('Content-Length: ' . filesize($name));
        readfile($name);
    }


    public function PSI($filename,$type='', $pid, $f_id) {
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            $doc = Yii::app()->controller->renderPartial('psi', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $pid), true);
            $name = 'PSIFILENAME.doc';
            file_put_contents($name, $doc);
            ob_clean();
            header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
        }
    }

    public function SOCAL($filename,$type='', $pid,$f_id) {
        if (file_exists($filename)) {
            $doc = Yii::app()->controller->renderPartial('socal', array('filename' => $filename, 'pid' => $pid), true);
            $name = 'SOFILENAME.doc';
            file_put_contents($name, $doc);
            ob_clean();
            header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
        }
    }

    public function WORDFORMAT($filename,$type='', $pid,$f_id) {
        if (file_exists($filename)) {
            $srcName = FileInfo::model()->findByPk($f_id);
            $srcName = explode(".", $srcName->fi_file_name);
            $srcName = $srcName[0];
            $doc = Yii::app()->controller->renderPartial('wordformat', array('filename' => $filename, 'f_id' => $f_id, 'pid' => $pid), true);
            $name = $srcName . ".doc";
            file_put_contents($name, $doc);
            ob_clean();
            header("Cache-Control: no-store");
            header("Expires: 0");
            header("Content-Type: application/octet-stream");
            header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($name));
            readfile($name);
        }
    }


}

?>
