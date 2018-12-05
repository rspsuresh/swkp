<?php

//include 'Net/SFTP.php';
require_once 'fpdf/fpdf.php';
require_once 'fpdf/PDFMerger-master/PDFMerger.php';
define("DIR_NAME", "filedownload/downloads/" . date('Y-m-d'));

class FiledownloadController extends RController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights'
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Author : Venkatesan.K
     * Purpose : Deamon for FTP/SFTP/Client portals file downloads
     * Created Date : 15-12-2015
     */

    /**
     * call back function for sync remote files to local for FTP
     * @param $dir
     */
    public function actionConnect() {

//        error_reporting(E_ALL);
//        date_default_timezone_set('Asia/Kolkata');
//        set_time_limit(0);
//        $servername = "localhost";
//        $username = "root";
//        $password = "";
//        $dbname = "kpws_latest";
//
//        $conn = new mysqli($servername, $username, $password, $dbname);
//        if ($conn->connect_error) {
//            die("Connection failed: " . $conn->connect_error);
//        }
//        echo "Database connected...<br><br>";


        $downloadqry = "SELECT p_downloadtype,p_pjt_id,p_url,p_port,p_folderpath,p_username,p_password FROM project_p WHERE p_flag='A' order by p_pjt_id desc";
        $result = Yii::app()->db->createCommand($downloadqry)->queryAll();


        $res = array();
        if (count($result) > 0) {
            $i = 0;

            foreach ($result as $val) {
                $res[$i]['type'] = $result[$i]["p_downloadtype"];
                $res[$i]['url'] = $result[$i]["p_url"];
                $res[$i]['username'] = $result[$i]["p_username"];
                $res[$i]['password'] = $result[$i]["p_password"];
                $res[$i]['port'] = $result[$i]["p_port"];
                $res[$i]['folderpath'] = $result[$i]["p_folderpath"];
                $res[$i]['projectid'] = $result[$i]['p_pjt_id'];
                $i++;
            }
        } else
            die("Connection disconnected...");
        foreach ($res as $key => $value) {
            $ftype = strtoupper($value["type"]);
            if (isset($ftype) && !empty($ftype)) {
                switch ($ftype) {
                    case 'F':
                        $this->actionftpdownload($value["url"], $value["username"], $value["password"], $value["port"], $value["folderpath"], $value['projectid']);
                        break;

                    case 'S':
                        $this->actionsftpdownload($value["url"], $value["username"], $value["password"], $value["port"], $value["folderpath"], $value['projectid']);
                        break;

                    case 'A':
                        header("Location: dropbox/index.php");
                        break;

                    default:
                        echo "Communication medium not found";
                        break;
                }
            }
        }
    }

    /**
     * FTP download method, that download the files from different portals
     * @param $url
     * @param $username
     * @param $password
     * @param $port
     * @param $folderpath
     */
    public function actionftpdownload($url, $username, $password, $port, $folderpath, $project_id) {

        global $conn_id;
        //ftp_chdir($conn_id,"/htdocs");
        if (!empty($url) && !empty($username) && !empty($password)) {
            try {
                if ($conn_id = @ftp_connect($url)) {

                    if (@ftp_login($conn_id, $username, $password)) {
                        if (!(is_dir(DIR_NAME))) {
                            mkdir(DIR_NAME);
                        }
                        $folderpath = '/in';
                        $this->ftp_syncfiles($folderpath, $project_id, $url);
//                        
//                        $this->test($folderpath);
                    } else {
                        throw new Exception("could not login into the FTP server : " . $url);
                    }
                } else
                    throw new Exception("could not communicate with FTP server :" . $url);
            } catch (Exception $e) {
                echo 'Message: ' . $e->getMessage() . "</br>";
            }
        }
    }

//    public function test($dir) {
//       global $conn_id;
//        global $conn;
////        echo "<pre>";
//        @ftp_chdir($conn_id,$dir);
////        print_r(ftp_pwd($conn_id));
//////        print_r(getcwd());
////        die();
////        if ($dir != ".") {
////            if (@ftp_chdir($conn_id, $dir) == false) {
////                echo ("Change Dir Failed: $dir<BR>\r\n");
////                return;
////            }
////        }
//
//        $contents = ftp_nlist($conn_id, ".");
//        echo "<pre>";
//        print_r($contents);
//        die();
//    }
//    public function ftp_syncfiles($dir, $project_id,$url) {
//        $folderusr = "192.168.15.148";
//
//        global $conn_id;
//        global $conn;
//
////        if ($dir != ".") {
//////           
////////            echo "<pre>";
////////            print_r(ftp_pwd($conn_id));
////////            print_r(ftp_nlist($conn_id, "."));
////////            die();
////             ftp_mkdir($conn_id, "/");
////////            echo "<pre>";
////////            print_r("sjdlksldslds");
////////            die();
////            if (ftp_chdir($conn_id, $dir) == false) {
////                echo ("Change Dir Failed: $dir<BR>\r\n");
////                return;
////            }
////        }
//
////        $contents = ftp_nlist($conn_id, ".");
//        $contents = ftp_nlist($conn_id, "/htdocs/ddd");
//       
//        
//        if(count($contents)){
//            echo " File Download Path : ";
//        echo "<br><br>";
//        foreach ($contents as $file) {
//            if ($file == '.' || $file == '..')
//                continue;
//            if (@ftp_chdir($conn_id, $file)) {
//                ftp_chdir($conn_id, "..");
////                $this->ftp_syncfiles($file);
//            } else {
//                $date = date('YmdHis');
//                $filename = $date . "_" . str_replace("./", "", $file);
////                $filename = "test.php";
////                if (ftp_get($conn_id, DIR_NAME . "/" . $filename, $file, FTP_BINARY)) {
//                if (ftp_get($conn_id, DIR_NAME . "/" . $filename, $file, FTP_BINARY)) {
////                    echo "<pre>";
////                    print_r(count(ftp_nlist($conn_id, "../backup")));
////                    die();
//                    if (ftp_nlist($conn_id, "../backup") == false && count(ftp_nlist($conn_id, "../backup")) < 0) {
//                        ftp_mkdir($conn_id, "../backup");
//                    }
//                    ftp_rename($conn_id, $file, "../backup" . $file);
//                    $ori_location = DIR_NAME . "/" . $filename;
//                    $query = "INSERT into  file_info (file_name,created_date,file_ori_location,pjt_id) values('$filename','$date','$ori_location',$project_id)";
//                    $result = $conn->query($query);
//                    echo $ori_location;
//                    echo "<br>";
//                }
//                if (ftp_pwd($conn_id) != $dir) {
////ftp_rmdir($conn_id, ftp_pwd($conn_id)); //removing empty directory
//                }
//            }
//        }
//         echo "<br> Files downloaded Successfully...<br>";
//        ftp_chdir($conn_id, "..");
//        }
//        else{
//            echo "No Files in ".$url."!";
//            die();
//        }
//       
//    }

    public function ftp_syncfiles($dir, $project_id = "") {

        global $conn_id;
        global $conn;

        if ($dir != ".") {

            if (ftp_chdir($conn_id, $dir) == false) {
                echo ("Change Dir Failed: $dir<BR>\r\n");
                return;
            }
        }

        $contents = ftp_nlist($conn_id, ".");
        if (count($contents) < 1) {
            echo "No Files";
            return;
        }
        echo " File Download Path : ";
        echo "<br><br>";


        foreach ($contents as $file) {

            $file1 = $file;
            $file = str_replace("./", "", $file);
            if ($file == '.' || $file == '..')
                continue;
            if (@ftp_chdir($conn_id, $file)) { // folder upload
                $folderTime = strtotime(date("Ymdhis"));

                $file = str_replace("./", "", $file);
//                $this->ftp_syncfiles($file,$project_id);  //   previous ftp service

                $filename = $folderTime . "_" . $file;
                $path = 'filedownload/testpdfmerger/' . $folderTime . "_" . $file;
                $file_list = ftp_nlist($conn_id, ".");

                if (!$this->ftp_is_dir($conn_id, "/../backup")) {
                    ftp_mkdir($conn_id, "/../backup");
                }
                if (!is_dir(Yii::app()->basePath . "/../" . $path)) {
                    mkdir(Yii::app()->basePath . "/../" . $path, 0777, true);
                }

                foreach ($file_list as $dirFiles) {
                    $dirFiles = str_replace("./", "", $dirFiles);
                    $localpath = Yii::app()->basePath . "/../" . $path . "/" . $dirFiles;
                    ftp_get($conn_id, $localpath, $dirFiles, FTP_BINARY);
                    if (!$this->ftp_is_dir($conn_id, "/../backup/" . $folderTime . "_" . $file)) {
                        ftp_mkdir($conn_id, "/../backup/" . $folderTime . "_" . $file);
                    }
                    
                    $pdftext = file_get_contents($localpath);
                    $pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);
                    $pageCntArr[$dirFiles] = $pagenum;
                    ftp_rename($conn_id, $dirFiles, "/../backup/".$folderTime."_".$file."/". $dirFiles);
                }
                
                if(count(ftp_nlist($conn_id,".")) == 0){
                    ftp_rmdir($conn_id, ".");
                }
//                }
//                if ($uploadedFile[$fileKey]->saveAs(Yii::app()->basePath . "/../" . $path . "/" . $model->fi_file_name)) {
//                    
//                }
                if (count($file_list) > 0) {
                    $model = new FileInfo();
                    $model->fi_pjt_id = $project_id;
                    $fileUploaded = FileinfoController::actionPdfmerger($pageCntArr, $model, $path, $folderTime, $file . ".pdf");
                }
            } else { //single file upload
                $folderTime = strtotime(date("Ymdhis"));
                $date = date('YmdHis');
                $file = str_replace("./", "", $file);
                $filename = $date . "_" . $file;
                $dirname = date("Y-m-d");
                $path = 'filedownload/testpdfmerger/' . $folderTime . "_" . $file;
                $localpath = Yii::app()->basePath . "/../" . $path . "/" . $file;
                if (!is_dir(Yii::app()->basePath . "/../" . $path)) {
                    mkdir(Yii::app()->basePath . "/../" . $path, 0777, true);
                }
                if (ftp_get($conn_id, $localpath, $file, FTP_BINARY)) {
                    if (!$this->ftp_is_dir($conn_id, "/../backup")) {
                        ftp_mkdir($conn_id, "/../backup");
                    }

                    $ori_location = DIR_NAME . "/" . $filename;
                    $model = new FileInfo();
                    $model->fi_pjt_id = $project_id;
                    $fileUploaded = FileinfoController::actionPdfmerger(0, $model, $path, $folderTime, $file);
                     ftp_rename($conn_id, $file, "/backup/" . $file);
//                    $pdftext = file_get_contents($ori_location);
//                    $pgCount = JoballocationController::actionGetpdfpagecount($ori_location);
//                    $pgCount = $pgCount->getPagecount($ori_location);
//                 
//                    $pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);
//                    $query = "INSERT into  file_info_fi (fi_file_name,fi_created_date,fi_file_ori_location,fi_pjt_id,fi_total_pages) values('$filename','$date','$ori_location',$project_id,$pagenum)";
//                    $result = Yii::app()->db->createCommand($query)->execute();
//                    echo $ori_location;
//                    echo "<br>";
                }
                if (ftp_pwd($conn_id) != $dir) {
                    //ftp_rmdir($conn_id, ftp_pwd($conn_id)); //removing empty directory
                }
            }
            ftp_chdir($conn_id, "/in");
        }
        echo "<br> Files downloaded Successfully...<br>";
        ftp_chdir($conn_id, "..");
    }

    /**
     * SFTP download method, that download the files from different portals
     * @param $url
     * @param $username
     * @param $password
     * @param $port
     * @param $folderpath
     */
    public function sftpdownload($url, $username, $password, $port = 21, $folderpath, $project_id) {
        global $sftp;
        if (!empty($url) && !empty($username) && !empty($password)) {
            $sftp = new Net_SFTP($url, $port);
            try {
                if ($sftp->login($username, $password)) {
                    if ($sftp->chdir($folderpath)) {
//echo "We are here: ".$sftp->pwd();

                        $list = $sftp->rawlist('.', true);
                        sftp_syncfiles($list);
                    } else
                        throw new Exception("Could not change the directory : " . $folderpath, 1);
                } else
                    throw new Exception("Login failed : " . $url, 1);
            } catch (Exception $e) {
                echo "Message : " . $e->getMessage();
            }
        }
    }

    /**
     * Call back function for SFTP download files 
     * @param list of records
     */
    public function sftp_syncfiles($list) {
        global $sftp;
        global $conn;
        foreach ($list as $filename => $attr) {
            if ($filename != '.' && $filename != '..') {
                if (isset($attr->type)) {
                    $date = date('YmdHis');
                    $localfilename = $date . "_" . $filename;
                    $ori_location = DIR_NAME . '/' . $localfilename;

                    $sftp->get($filename, DIR_NAME . '/' . $localfilename);
                    $query = "INSERT into  file_info (file_name,created_date,file_ori_location) values('$localfilename','$date','$ori_location')";
                    $result = $conn->query($query);
                    echo $ori_location;
                    echo "<br>";
//$sftp->delete($value['filename']);
                } else {
                    $sftp->chdir($filename);
                    sftp_syncfiles($attr);
                    $sftp->chdir('..');
                }
            }
        }
    }

    private function actionXmloutput($filename, $pid) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $fi_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $output_name = "Output_" . $fi_id;
            $fileModel = FileInfo::model()->findByPk($fi_id);
            if ($fileModel) {
                $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
            }
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
                            $xml->addChild('ReviewerName', $explodeLine[4]);
                        }
                        $xml->addChild('ParaReviews');
                        $xml->addChild('Categories');
                        $xml->addChild('Pages');
                    }
                    //Page Review..
                    $pageReview = $xml->ParaReviews->addChild('ParaReview');
                    $pageReview->addAttribute('ParaReviewID', $j);
                    $dos = !empty($explodeLine[1]) ? FileInfo::dateformat($explodeLine[1], $pid) : 'Undated';
                    $pageReview->addAttribute('DOS', $dos);

                    $providerName = !empty($explodeLine[4]) ? $explodeLine[4] : "";
                    $facility = !empty($explodeLine[7]) ? $explodeLine[7] : "";
                    $provider = $providerName . ',' . $facility;
                    $pageReview->addAttribute('Provider', $provider);

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

            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                if ($xml->asXML('ftp://' . $auth . '@' . $ftp_url . '/out/' . $output_name . '.xml')) {
                    $fileModel->out_status = "C";
                    $fileModel->save();
                    echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
                }
            }
        }
    }

    public function actionWosxls($id) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        $fileInfo = FileInfo::model()->findByPk($id);
        $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileInfo->fi_file_ori_location));
        $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
        $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
        $prject_name = Project::model()->findByPk($project_id);
        $ftp_url = $prject_name->p_url;
        $ftp_uname = $prject_name->p_username;
        $ftp_pass = $prject_name->p_password;
        $filePartition = JobAllocation::model()->find(array('condition' => "ja_file_id=$id  and ja_status='QC'"));
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
            $file_dir = $dir . "/" . $id . ".txt";
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
                        $files[$i]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";
                        ;
                        $files[$i]['rvr_nmae'] = $rvrname;
                        $files[$i]['mpn_rvr_name'] = '';
                        $files[$i]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                        $files[$i]['fl_category'] = $catname;
                        $files[$i]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                        if ($prject_name->skip_edit == 0) {
                            $files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
                        } else {
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
                        $Sfiles[$k]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";
                        ;
                        $Sfiles[$k]['rvr_nmae'] = $rvrname;
                        $Sfiles[$k]['mpn_rvr_name'] = '';
                        $Sfiles[$k]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                        $Sfiles[$k]['fl_category'] = $catname;
                        $Sfiles[$k]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                        if ($prject_name->skip_edit == 0) {
                            $Sfiles[$k]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
                        } else {
                            $files[$i]['fl_summary'] = "";
                        }
                        $k++;
                    }
                }


                usort($files, function ($a, $b) {
                    $t1 = strtotime($a['fl_dos']);
                    $t2 = strtotime($b['fl_dos']);
                    return $t2 - $t1;
                });


                foreach ($Sfiles as $key => $lines) {
                    array_push($files, $Sfiles[$key]);
                }
            }
            if (!empty($files)) {
                $returnval = XlsExporter::ftpXls('Completed', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);

                if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                    $ftp_server = $ftp_url;
                    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                    $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                    if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                        ftp_mkdir($ftp_conn, "out");
                    }

                    $auth = $ftp_uname . ":" . $ftp_pass;
                    $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".xls", "w") or die("Unable to open file!");
                    fwrite($myfile, $returnval);
                    fclose($myfile);
                    $fileInfo->out_status = "C";
                    $fileInfo->save();
                    echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
                }
            }
        }
    }

    public function actionWsxls($id) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        $fileInfo = FileInfo::model()->findByPk($id);
        $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileInfo->fi_file_ori_location));
        $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
        $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
        $prject_name = Project::model()->findByPk($project_id);
        $ftp_url = $prject_name->p_url;
        $ftp_uname = $prject_name->p_username;
        $ftp_pass = $prject_name->p_password;
        $filePartition = JobAllocation::model()->find(array('condition' => "ja_file_id=$id  and ja_status='QC'"));
        $rvrname = $filePartition->Rvrname->ud_name;
        $dir = "filepartition/" . $project_id . "_breakfile";
        $p_name = $prject_name->p_name;

        $heading = array('Page Numbers', 'DOS', 'Patient Name', 'Category', 'Provider', 'Processed Date', 'Summary');
        $fields = array('page_no', 'fl_dos', 'fl_patient', 'fl_category', 'fl_provider', 'fl_proc_date', 'fl_summary');
        $files = array();
        if (is_dir($dir)) {
            $file_dir = $dir . "/" . $id . ".txt";
            if (file_exists($file_dir)) {
                $i = 0;
                foreach (file($file_dir) as $line) {
                    $exp_file = explode('|', trim($line));
                    $cat = Category::model()->findByPk($exp_file[3]);
                    $catname = $cat ? $cat->ct_cat_name : '';
                    $files[$i]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
                    $files[$i]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
                    $files[$i]['fl_patient'] = isset($exp_file[2]) ? $exp_file[2] : "";
                    $files[$i]['fl_category'] = $catname;
                    $files[$i]['fl_provider'] = isset($exp_file[4]) ? $exp_file[4] : "";
                    $files[$i]['fl_proc_date'] = isset($exp_file[6]) ? $exp_file[6] : "";
                    $files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
                    $i++;
                }
            }
        }

        if (!empty($files)) {
            $returnval = XlsExporter::ftpXls('Completed', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);

            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }

                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".xls", "w") or die("Unable to open file!");
                fwrite($myfile, $returnval);
                fclose($myfile);
                $fileInfo->out_status = "C";
                $fileInfo->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    /* public function actionExport($id)
      {
      $ftp_url = "";
      $ftp_uname = "";
      $ftp_pass = "";
      $fileInfo = FileInfo::model()->findByPk($id);
      $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileInfo->fi_file_ori_location));
      $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
      $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
      $prject_name = Project::model()->findByPk($project_id);
      $ftp_url = $prject_name->p_url;
      $ftp_uname = $prject_name->p_username;
      $ftp_pass = $prject_name->p_password;
      $filePartition = JobAllocation::model()->find(array('condition' => "ja_file_id=$id  and ja_status='QC'"));
      $rvrname = $filePartition->Rvrname->ud_name;
      $dir = "filepartition/" . $project_id . "_breakfile";
      $p_name = $prject_name->p_name;
      if ($prject_name->p_name === 'BIS XLSX') {

      $heading = array('Page Nos', 'DOS [MM/DD/YY]', 'Provider', 'Title [Type of Service]', 'Category',
      'Summary', 'LastName', 'ReviewerName', 'MPN Reviewer Name', 'FileNameOrder');

      $fields = array('page_no', 'fl_dos', 'fl_provider', 'type_of_service', 'fl_category', 'fi_summary', 'l_name', 'rvr_nmae', 'mpn_rvr_name', 'fi_name');
      $files = array();
      $Sfiles = array();
      $subpages = '';

      if (is_dir($dir)) {
      $file_dir = $dir . "/" . $id . ".txt";
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
      $files[$i]['type_of_service'] = '';
      $files[$i]['fi_summary'] = '';
      $files[$i]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";;
      $files[$i]['rvr_nmae'] = $rvrname;
      $files[$i]['mpn_rvr_name'] = '';
      $files[$i]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
      $files[$i]['fl_category'] = $catname;
      $files[$i]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
      $files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
      $i++;
      } else {
      $Sfiles[$k]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
      if (!empty($exp_file[0]) && $fileInfo->fi_split_files != "") {
      $tempSubpages = explode(",", $exp_file[0]);
      $mergefiles = FileinfoController::actionMultifile($tempSubpages, $fileInfo->fi_file_id);
      }
      $Sfiles[$k]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
      $Sfiles[$k]['type_of_service'] = '';
      $Sfiles[$k]['fi_summary'] = '';
      $Sfiles[$k]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";;
      $Sfiles[$k]['rvr_nmae'] = $rvrname;
      $Sfiles[$k]['mpn_rvr_name'] = '';
      $Sfiles[$k]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
      $Sfiles[$k]['fl_category'] = $catname;
      $Sfiles[$k]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
      $Sfiles[$k]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
      $k++;
      }
      }


      usort($files, function ($a, $b) {
      $t1 = strtotime($a['fl_dos']);
      $t2 = strtotime($b['fl_dos']);
      return $t2 - $t1;
      });


      foreach ($Sfiles as $key => $lines) {
      array_push($files, $Sfiles[$key]);
      }

      }
      }
      } else {
      $heading = array('Page Numbers', 'DOS', 'Patient Name', 'Category', 'Provider', 'Processed Date', 'Summary');
      $fields = array('page_no', 'fl_dos', 'fl_patient', 'fl_category', 'fl_provider', 'fl_proc_date', 'fl_summary');
      $files = array();
      if (is_dir($dir)) {
      $file_dir = $dir . "/" . $id . ".txt";
      if (file_exists($file_dir)) {
      $i = 0;
      foreach (file($file_dir) as $line) {
      $exp_file = explode('|', trim($line));
      $cat = Category::model()->findByPk($exp_file[3]);
      $catname = $cat ? $cat->ct_cat_name : '';
      $files[$i]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
      $files[$i]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
      $files[$i]['fl_patient'] = isset($exp_file[2]) ? $exp_file[2] : "";
      $files[$i]['fl_category'] = $catname;
      $files[$i]['fl_provider'] = isset($exp_file[4]) ? $exp_file[4] : "";
      $files[$i]['fl_proc_date'] = isset($exp_file[6]) ? $exp_file[6] : "";
      $files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
      $i++;
      }
      }
      }
      }
      if(!empty($files)){
      $returnval = XlsExporter::ftpXls('Completed', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);

      if(!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)){
      $ftp_server = $ftp_url;
      $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
      $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

      if(!$this->ftp_is_dir($ftp_conn, "/out")) {
      ftp_mkdir($ftp_conn, "out");
      }

      $auth = $ftp_uname.":".$ftp_pass;
      $myfile = fopen("ftp://".$auth."@".$ftp_url."/out/".$output_name.".xls", "w") or die("Unable to open file!");
      fwrite($myfile, $returnval);
      fclose($myfile);
      $fileInfo->out_status = "C";
      $fileInfo->save();
      echo 'Message: Output file is moved to FTP server : '.$ftp_url.'</br>';
      }
      }
      } */

    public function actionWorddoc($filename, $type, $p_id) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $fi_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $output_name = "Output_" . $fi_id;
            $fileModel = FileInfo::model()->findByPk($fi_id);
            if ($fileModel) {
                $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
            }
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
                $doc = $this->renderPartial('../fileinfo/jvcword', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages, 'pid' => $p_id), true);
            } else {
                $doc = $this->renderPartial('../fileinfo/worddoc', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages, 'pid' => $p_id), true);
            }
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $fileModel->out_status = "C";
                $fileModel->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionWordparagraph($filename, $pid) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $fi_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $output_name = "Output_" . $fi_id;
            $fileModel = FileInfo::model()->findByPk($fi_id);
            if ($fileModel) {
                $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/wordparagraph', array('filename' => $filename, 'pid' => $pid), true);
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $fileModel->out_status = "C";
                $fileModel->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionWordcombine($filename, $pid) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $fi_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $output_name = "Output_" . $fi_id;
            $fileModel = FileInfo::model()->findByPk($fi_id);
            if ($fileModel) {
                $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/wordcombine', array('filename' => $filename, 'pid' => $pid), true);
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $fileModel->out_status = "C";
                $fileModel->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionDrg($filename, $pid, $f_id) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            if ($model) {
                $p_model = Project::model()->findByPk($model->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($model->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/drg', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $pid), true);
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $model->out_status = "C";
                $model->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionConvertword($filename, $p_id, $f_id) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            if ($model) {
                $p_model = Project::model()->findByPk($model->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($model->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/printlayout', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $p_id), true);
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $model->out_status = "C";
                $model->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionPsi($filename, $pid, $f_id) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            if ($model) {
                $p_model = Project::model()->findByPk($model->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($model->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/psi', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $pid), true);
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $model->out_status = "C";
                $model->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionSocal($filename, $pid) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $fi_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $output_name = "Output_" . $fi_id;
            $fileModel = FileInfo::model()->findByPk($fi_id);
            if ($fileModel) {
                $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/socal', array('filename' => $filename, 'pid' => $pid), true);
            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $fileModel->out_status = "C";
                $fileModel->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    public function actionWordformat($filename, $f_id, $pid) {
        $ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
        if (file_exists($filename)) {
            $output_name = "Output_" . $f_id;
            $srcName = FileInfo::model()->findByPk($f_id);
            if ($srcName) {
                $p_model = Project::model()->findByPk($srcName->fi_pjt_id);
                $ftp_url = $p_model->p_url;
                $ftp_uname = $p_model->p_username;
                $ftp_pass = $p_model->p_password;
                $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($srcName->fi_file_ori_location));
            }
            $doc = $this->renderPartial('../fileinfo/wordformat', array('filename' => $filename, 'f_id' => $f_id, 'pid' => $pid), true);

            if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
                $myfile = fopen("ftp://" . $auth . "@" . $ftp_url . "/out/" . $output_name . ".doc", "w") or die("Unable to open file!");
                fwrite($myfile, $doc);
                fclose($myfile);
                $srcName->out_status = "C";
                $srcName->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
        }
    }

    private function actionPDFoutput($filename) {
        require_once 'fpdf/fpdf.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
		$fileloc = "";
        if (file_exists($filename)) {
            $fi_id = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($filename));
            $fileModel = FileInfo::model()->findByPk($fi_id);
            if ($fileModel) {
                $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
				$fileloc = $fileModel->fi_file_ori_location;
            }
            $header = array('Date of Service', 'Page No.', 'Provider', 'Excerpt');

            $data = $pdf->LoadData($filename);
            $pdf->SetFont('Times', '', 11.5);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(30, 50, 30, 40));
            $pdf->AddPage('P', 'A4');
            $pdf->SocalTemplate($header, $data);
			$tempfilename = 'samplepdfs/final.pdf';
			$pdf->Output($tempfilename, 'F');

            $this->actionMikeoutput($filename, $fileloc, $fi_id);
        }
    }
	
	public function actionMikeoutput($filename, $mainFile, $fi_id) {

        require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf1 = new PDFMerger();
		$ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
		$output_name = "Output_" . $fi_id;
		$fileModel = FileInfo::model()->findByPk($fi_id);
        if ($fileModel) {
            $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
            $ftp_url = $p_model->p_url;
            $ftp_uname = $p_model->p_username;
            $ftp_pass = $p_model->p_password;
            $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
        }
			
        $mergePages = $this->actionGetpdfpages(array("Dr. Notes"), $filename);
        $docnotes = isset($mergePages['Dr. Notes']) ? $mergePages['Dr. Notes'] : "";
        $pdf1->addPDF('samplepdfs/final.pdf', 'all');
        if (!empty($docnotes)) {
            $pdf1->addPDF($mainFile, $docnotes);
        }
		$pdf1->merge('file',Yii::app()->basePath . '/../samplepdfs/final.pdf');
			if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
				ftp_put($ftp_conn, 'out/'.$output_name.'.pdf', 'samplepdfs/final.pdf', FTP_BINARY);
				//$pdf1->merge('file', 'ftp://' . $auth . '@' . $ftp_url . '/out/' . $output_name . '.pdf');
                $fileModel->out_status = "C";
                $fileModel->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
    }


    public function actionGetpdfpages($catNameArray = "", $filename = "") {
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
	
	public function actionBACTESPDF($filename,$type='', $pid,$f_id) {
        require_once 'fpdf/fpdf.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
        /* check Current date */
        if (file_exists($filename)) {
        // Column headings
            $header = array('Measure Terms', 'Date of Service', 'Providers', 'Facilitites', 'Bates/References', 'Pages');
        // Data loading

            $data = $pdf->LoadData($filename);
			
            $pdf->SetFont('Times', '', 11.5);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(30, 50, 30, 40));
            $pdf->AddPage('P', 'A4');
            $pdf->BactespdfTemplate($header, $filename, $pid, $f_id);

            $tempfilename = 'samplepdfs/final.pdf';

            $pdf->Output($tempfilename, 'F');
			
			$mainFile = FileInfo::model()->findByPk($f_id);

            $this->actionMerger($filename, $mainFile->fi_file_ori_location, $f_id);

        }
    }
	
	public function actionBISPDF($filename,$type='', $pid,$f_id) {
        require_once 'fpdf/fpdf.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
        /* check Current date */
        if (file_exists($filename)) {
        // Column headings
            $header = array('Date of Service', 'Body Parts', 'Providers', 'Facilitites', 'Diagnoses', 'Category', 'Filename', 'Bates/References', 'Pages');
        // Data loading

            $data = $pdf->LoadData($filename);
			
            $pdf->SetFont('Times', '', 11.5);
            $pdf->AliasNbPages();
            $pdf->SetWidths(array(30, 50, 30, 40));
            $pdf->AddPage('P', 'A4');
            $pdf->BactesTemplate($header, $filename, $pid, $f_id);

            $tempfilename = 'samplepdfs/final.pdf';

            $pdf->Output($tempfilename, 'F');
			
			$mainFile = FileInfo::model()->findByPk($f_id);

            $this->actionMerger($filename, $mainFile->fi_file_ori_location, $f_id);

        }
    }
	
	 public function actionMerger($filename, $mainFile, $fi_id) {

        require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf1 = new PDFMerger();
		$ftp_url = "";
        $ftp_uname = "";
        $ftp_pass = "";
		$output_name = "Output_" . $fi_id;
		$fileModel = FileInfo::model()->findByPk($fi_id);
        if ($fileModel) {
            $p_model = Project::model()->findByPk($fileModel->fi_pjt_id);
            $ftp_url = $p_model->p_url;
            $ftp_uname = $p_model->p_username;
            $ftp_pass = $p_model->p_password;
            $output_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($fileModel->fi_file_ori_location));
        }
		
        $pdf1->addPDF('samplepdfs/final.pdf', 'all');
        $pdf1->addPDF($mainFile);

        $pdf1->merge('file',Yii::app()->basePath . '/../samplepdfs/final.pdf');
			if (!empty($ftp_url) && !empty($ftp_uname) && !empty($ftp_pass)) {
                $ftp_server = $ftp_url;
                $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
                $login = ftp_login($ftp_conn, $ftp_uname, $ftp_pass);

                if (!$this->ftp_is_dir($ftp_conn, "/out")) {
                    ftp_mkdir($ftp_conn, "out");
                }
                $auth = $ftp_uname . ":" . $ftp_pass;
				ftp_put($ftp_conn, 'out/'.$output_name.'.pdf', 'samplepdfs/final.pdf', FTP_BINARY);
				//$pdf1->merge('file', 'ftp://' . $auth . '@' . $ftp_url . '/out/' . $output_name . '.pdf');
                $fileModel->out_status = "C";
                $fileModel->save();
                echo 'Message: Output file is moved to FTP server : ' . $ftp_url . '</br>';
            }
    }
	
	
    public function actionSendout() {
        $FileInfo = FileInfo::model()->findAll();
        foreach ($FileInfo as $key => $value) {
            if (FileInfo::currentstatus($value->fi_file_id) == "QEC" && $value->out_status == "P") {
                $f_id = $value->fi_file_id;
                $p_id = $value->fi_pjt_id;
                $tmp_id = !empty($value->fi_template_id) ? $value->fi_template_id : $value->ProjectMaster->template_id;
                if (!empty($p_id) && !empty($f_id) && !empty($tmp_id)) {
                    $makeModels = Templates::model()->findByPk($tmp_id);
                    $project = $p_id . "_breakfile";
                    $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $f_id . ".txt";

                    if ($makeModels->t_name == 'NXML') {
                        $this->actionXmloutput($filename, $p_id);
                    } else if ($makeModels->t_name == 'PDF') {
                        $this->actionPDFoutput($filename, $p_id);
                    } else if ($makeModels->t_name == 'JWORDDOC') {
                        $this->actionWorddoc($filename, 'j', $p_id);
                    } else if ($makeModels->t_name == 'SWORDDOC') {
                        $this->actionWorddoc($filename, 's', $p_id);
                    } else if ($makeModels->t_name == 'WORDPARAGRAPH') {
                        $this->actionWordparagraph($filename, $p_id);
                    } else if ($makeModels->t_name == 'WORDCOMBINE') {
                        $this->actionWordcombine($filename, $p_id);
                    } else if ($makeModels->t_name == 'DRG') {
                        $this->actionDrg($filename, $p_id, $f_id);
                    } else if ($makeModels->t_name == 'CONVERTWORD') {
                        $this->actionConvertword($filename, $p_id, $f_id);
                    } else if ($makeModels->t_name == 'PSI') {
                        $this->actionPsi($filename, $p_id, $f_id);
                    } else if ($makeModels->t_name == 'SOCAL') {
                        $this->actionSocal($filename, $p_id);
                    } else if ($makeModels->t_name == 'WORDFORMAT') {
                        $this->actionWordformat($filename, $f_id, $p_id);
                    } else if ($makeModels->t_name == 'WSXLS') {
                        $this->actionWsxls($f_id);
                    } else if ($makeModels->t_name == 'WOSXLS') {
                        $this->actionWosxls($f_id);
                    } else if ($makeModels->t_name == 'BISPDF') {
						$this->actionBISPDF($filename,'', $p_id,$f_id);
					} else if ($makeModels->t_name == 'BACTESPDF') {
						$this->actionBACTESPDF($filename,'', $p_id,$f_id);
					}
                }
            }
        }
    }

    /* public function actionSendout() {
      $FileInfo = FileInfo::model()->findAll();
      foreach($FileInfo as $key => $value){
      if(FileInfo::currentstatus($value->fi_file_id) == "QEC" && $value->out_status == "P"){
      $f_id = $value->fi_file_id;
      $p_id = $value->fi_pjt_id;
      $f_format = $value->ProjectMaster->p_op_format;
      if (!empty($p_id) && !empty($f_id) && !empty($f_format)) {
      $project = $p_id . "_breakfile";
      $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $f_id . ".txt";
      if ($f_format == "XML") {
      $this->actionXmloutput($filename, $p_id);
      } else if ($f_format == "PDF") {
      $this->actionPDFoutput($filename, $p_id);
      } else if ($f_format == "DOCX") {
      $project = Project::model()->findByPk($p_id);
      $project_name = $project ? $project->p_name : '';
      if ($project_name == 'SLI') {
      $this->actionWorddoc($filename, 's', $p_id);
      } elseif ($project_name == 'DR.C') {
      $this->actionWordparagraph($filename, $p_id);
      } elseif ($project_name == 'DK' || $project_name == 'GSL') {
      $this->actionWordcombine($filename, $p_id);
      } elseif ($project_name == 'AH, Dr. B, JVC') {
      $this->actionWorddoc($filename, 'j', $p_id);
      } elseif ($project_name == 'DR.G') {
      $this->actionDrg($filename, $p_id, $f_id);
      } elseif ($project_name == 'cohen') {

      } elseif ($project_name == 'ANC') {
      $this->actionConvertword($filename, $p_id, $f_id);
      } elseif ($project_name == 'PPMC') {

      } elseif ($project_name == 'PLCP') {

      } elseif ($project_name == 'DR.PM') {

      } elseif ($project_name == 'PSI') {
      $this->actionPsi($filename, $p_id, $f_id);
      } elseif ($project_name == 'SOCAL' || $project_name == 'BACTES1') {
      $this->actionSocal($filename, $p_id);
      } elseif ($project_name == 'MIKE') {
      $this->actionSocal($filename, $p_id);
      } elseif ($project_name == 'BIS-INS' || $project_name == 'BACTES') {
      $this->actionWordformat($filename, $f_id, $p_id);
      }
      } else if($f_format == "XLS") {
      //$pjt = Project::model()->findByPk($p_id);
      //$project_name = $pjt ? $pjt->p_name : '';
      //if ($project_name == 'BIS XLSX') {
      $this->actionExport($f_id);
      //}
      }
      }
      }
      }
      } */

    public function ftp_is_dir($ftp, $dir) {
        $pushd = ftp_pwd($ftp);

        if ($pushd !== false && @ftp_chdir($ftp, $dir)) {
            ftp_chdir($ftp, $pushd);
            return true;
        }

        return false;
    }

}
