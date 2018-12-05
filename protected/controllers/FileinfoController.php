<?php

class FileinfoController extends RController {

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
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
        );
    }

    protected function beforeAction($action) {
        if ($action->id == "fileindexing") {
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                if (Yii::app()->session['user_type'] == "R") {
                    $info = FileInfo::model()->findByPk($_GET['id']);
                    if ($info->fi_admin_lock == "QL" || $info->fi_admin_lock == "L") {
                        $this->redirect(array("fileinfo/indexalloc"));
                    }
                } else if (Yii::app()->session['user_type'] == "QC") {
                    $partitioninfo = FilePartition::model()->findByPk($_GET['id']);
                    $partfile = $partitioninfo->fp_file_id;
                    $info = FileInfo::model()->findByPk($partfile);
                    if ($info->fi_admin_lock == "RL" || $info->fi_admin_lock == "L") {
                        $this->redirect(array("fileinfo/indexalloc"));
                    }
                } else if (Yii::app()->session['user_type'] == "A") {
                    if (isset($_GET['status']) && !empty($_GET['status'])) {
                        if ($_GET['status'] == 'R') {
                            $info = FileInfo::model()->findByPk($_GET['id']);
                            $currentstate = isset($info->fi_file_id) ? FileInfo::currentstatus($info->fi_file_id) : "";
                            if (empty($currentstate) && $currentstate != "IA") {
                                $this->redirect(array("fileinfo/allgrid"));
                            }
                        } else if ($_GET['status'] == 'QC') {
                            $partitioninfo = FilePartition::model()->findByPk($_GET['id']);
                            $info = isset($partitioninfo->fp_file_id) ? FileInfo::model()->findByPk($partitioninfo->fp_file_id) : "";
                            $currentstate = isset($info->fi_file_id) ? FileInfo::currentstatus($info->fi_file_id) : "";
                            if (empty($currentstate) && $currentstate != "IQP") {
                                $this->redirect(array("fileinfo/allgrid"));
                            }
                        }
                        if ($info->fi_admin_lock == "RL" || $info->fi_admin_lock == "QL") {
                            $this->redirect(array("fileinfo/allgrid"));
                        }
                    } else {
                        $this->redirect(array("fileinfo/allgrid"));
                    }
                }
            } else {
                if (Yii::app()->session['user_type'] == "A") {
                    $this->redirect(array("fileinfo/allgrid"));
                } else if (Yii::app()->session['user_type'] == "R" || Yii::app()->session['user_type'] == "QC") {
                    $this->redirect(array("fileinfo/indexalloc"));
                }
            }
        }

        if ($action->id != "uploadservice") {
            if (empty(Yii::app()->session['user_id'])) {
                $this->redirect(Yii::app()->createUrl('/site/login'));
            }
        }

        if ((Yii::app()->session['user_type'] == "C") && (Yii::app()->session['user_status'] == 'I'))
            $this->redirect(array("site/userregupdate"));
        return parent::beforeAction($action);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
                ), false, true);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new FileInfo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['FileInfo'])) {
            $model->attributes = $_POST['FileInfo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->fi_file_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['FileInfo'])) {
            $model->attributes = $_POST['FileInfo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->fi_file_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('FileInfo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new FileInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FileInfo']))
            $model->attributes = $_GET['FileInfo'];
        $this->render('filelist', array(
            'model' => $model,
        ));
    }

    public function actionIndexalloc() {
        if (!isset($_GET['fi_st'])) {
            if (Yii::app()->session['user_type'] == "R") {
                $_GET['fi_st'] = 'IA';
            } else if (Yii::app()->session['user_type'] == "QC") {
                $_GET['fi_st'] = 'IC';
            }
        }
        $model = new FileInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FileInfo']))
            $model->attributes = $_GET['FileInfo'];
        $this->render('indexalloc', array(
            'model' => $model,
        ));
    }

    public function actionSplitalloc() {
        if (!isset($_GET['fi_st'])) {
            if (Yii::app()->session['user_type'] == "R" || Yii::app()->session['user_type'] == "QC") {
                $_GET['fi_st'] = 'SA';
            } else {
                $_GET['fi_st'] = 'IC';
            }
        }
        $model = new FileInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FileInfo']))
            $model->attributes = $_GET['FileInfo'];
        $this->render('splitalloc', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return FileInfo the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = FileInfo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param FileInfo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-info-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionDependency() {
        $data = array();
        if (isset($_POST['ustyp']) && !empty($_POST['ustyp'])) {
            $data = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id = '" . $_POST['ustyp'] . "'")), 'ud_refid', 'ud_username');
        }
        echo '<option value="">Select User</option>';
        foreach ($data as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    public static function actionPdfmerger($pageCntArr, $model, $subpath, $folderTime, $filename = "") {

        require_once 'fpdf/PDFMerger-master/PDFMerger.php';
        // ini_set('memory_limit', '-1');
        $pdf1 = new PDFMerger();

        if (is_dir($subpath)) { // for application upload and ftp upload multiple files
            $files = scandir($subpath);
            foreach ($files as $value) {
                if ($value != '.' && $value != '..') {
                    $pdf1->addPDF($subpath . "/" . $value, 'all');
                }
            }
        } else { // for ftp upload single file
            $pdf1->addPDF($subpath, 'all');
            $subpath = "filedownload/testpdfmerger";
        }

        $pdf1->merge('file', Yii::app()->basePath . '/../' . $subpath . '/merge.pdf');
        $source_file = Yii::app()->basePath . '/../' . $subpath . '/merge.pdf';
        $dirname = date("Y-m-d");
        if (!is_dir(Yii::app()->basePath . "/../filedownload/downloads/" . $dirname)) {
            mkdir(Yii::app()->basePath . "/../filedownload/downloads/" . $dirname, 0777, true);
        }
        //        $t = date("Ymdhis");
        if (!empty($_POST['folderName'])) {
            $foldername = $_POST['folderName'];
        } else if ($filename != "") {
            $foldername = $filename;
        } else {
            $foldername = $folderTime;
        }

        $dest_file = Yii::app()->basePath . "/../filedownload/downloads/" . $dirname . "/" . $foldername;

        if (copy($source_file, $dest_file)) {
            $pdftext = file_get_contents($dest_file);
            $pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);

            $model->fi_split_files = ($pageCntArr != 0) ? json_encode($pageCntArr) : 0;
            $model->fi_total_pages = $pagenum;
            $model->fi_file_ori_location = 'filedownload/downloads/' . $dirname . "/" . (($filename != "") ? $filename : $foldername.".pdf");
            $model->fi_file_name = (($filename != "") ? $filename : $foldername.".pdf");

            $flag = $model->save(false);
            if ($flag) {
                $message = "File has been added successfully";
                $msg['status'] = 'S';
                $msg['path'] = Yii::app()->baseUrl . "/filedownload/downloads/" . $dirname . "/" . $foldername . ".pdf";
                $msg['msg'] = $message;
                $msg['upid'] = Yii::app()->db->getLastInsertID();
            } else {
                array_map("unlink", glob($savedFile));
                $message = "File not uploaded";
                $msg['status'] = 'N';
                $msg['path'] = "";
                $msg['msg'] = $message;
            }
        } else {
            $message = "Error on Merging Files";
            $msg['status'] = 'N';
            $msg['path'] = "";
            $msg['msg'] = $message;
        }
        return $msg;
    }

    public function actionUploadfile() {
        $model = new FileInfo();
        $message = '';
        $dirname = date("Y-m-d");
        $t = date("Ymdhis");
        $folderTime = "";
        $pageCntArr = array();
        $filetypes = array("pdf", "tiff", "PDF");

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'upload-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['FileInfo'])) {
            if (empty(Yii::app()->session['user_id'])) {
                $msg['msg'] = "Your session has been Expired";
                $msg['status'] = 'LG';
                $msg['path'] = "";
                echo json_encode($msg, true);
                die();
            }
            if (!empty($_POST['filetype']) && $_POST['filetype'] == "F") {
                $path = 'filedownload/testpdfmerger/' . $t;
                $fileNm = $path;
                $folderTime = $t;
                $t = "";
            } else {
                $path = 'filedownload/downloads/' . $dirname;
            }

            foreach ($_FILES['FileInfo']['name']['fi_file_name'] as $fileKey => $fileval) {
                $model = new FileInfo();
                $model->attributes = $_POST['FileInfo'];
                $model->fi_pjt_id = $_GET['pid'];
                $uploadedFile = CUploadedFile::getInstances($model, 'fi_file_name');

                if (in_array($uploadedFile[$fileKey]->getExtensionName(), $filetypes)) {
//                    if (!empty($_POST['filetype']) && $_POST['filetype'] == "F") {
//                        $model->fi_file_name = $uploadedFile[$fileKey]->getName();
//                    } else {
//                        $model->fi_file_name = $uploadedFile[$fileKey]->getName();
//                    }
                    $model->fi_file_name = $uploadedFile[$fileKey]->getName();
                    $model->fi_file_ori_location = $path . '/' . $model->fi_file_name;
                    $transaction = Yii::app()->db->beginTransaction();

                    try {
                        if (!empty($_POST['filetype']) && $_POST['filetype'] == "F") {

                            if (!is_dir(Yii::app()->basePath . "/../" . $path)) {
                                mkdir(Yii::app()->basePath . "/../" . $path, 0777, true);
                            }
                            if ($uploadedFile[$fileKey]->saveAs(Yii::app()->basePath . "/../" . $path . "/" . $model->fi_file_name)) {
                                $savedFile = $path . "/" . $model->fi_file_name;
                                $pdftext = file_get_contents($savedFile);
                                $pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);
                                $transaction->commit();
                            }
                        } else if ($flag = $model->save()) {
                            $lastid = Yii::app()->db->getLastInsertID();
                            if (!is_dir(Yii::app()->basePath . "/../" . $path)) {
                                mkdir(Yii::app()->basePath . "/../" . $path, 0777, true);
                            }
                            $uploadedFile[$fileKey]->saveAs(Yii::app()->basePath . "/../" . $path . "/" . $model->fi_file_name);

                            //Get the pageNumber Code....
                            $savedFile = $path . "/" . $model->fi_file_name;
                            $pdftext = file_get_contents($savedFile);
                            $pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);
                            $updateQuery = FileInfo::model()->findByPk($model->fi_file_id);
                            $updateQuery->fi_total_pages = $pagenum;
                            $flag = $updateQuery->save();
                            if ($flag) {
                                $transaction->commit();
                                $message = "File has been added successfully";
                                $msg['status'] = 'S';
                                $msg['path'] = Yii::app()->baseUrl . "/" . $savedFile;
                                $msg['upid'] = $lastid;
                            } else {
                                array_map("unlink", glob($savedFile));
                                $transaction->rollback();
                                $message = "File not uploaded";
                                $msg['status'] = 'N';
                                $msg['path'] = "";
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                    }
                    $msg['msg'] = $message;
                    $pageCntArr[$model->fi_file_name] = $pagenum;
                } else {

                    $message = 'Only pdf and tiff types  allowed';
                    $msg['msg'] = $message;
                    $msg['status'] = 'I';
                    $msg['path'] = "";
                    echo json_encode($msg, true);
                    die();
                }
            }
            if (!empty($_POST['filetype']) && $_POST['filetype'] == "F") {
                $fileUploaded = $this->actionPdfmerger($pageCntArr, $model, $path, $folderTime);
                echo json_encode($fileUploaded, true);
                die();
            } else {
                echo json_encode($msg, true);
                die();
            }
        }
        $this->render('upload', array('model' => $model));
    }

    public function actionPagecount($id) {
        $updateQuery = FileInfo::model()->findByPk($id);
        if(!empty($_POST['tot'])) {
            $updateQuery->fi_total_pages = $_POST['tot'];
        }
        if ($updateQuery->save()) {
            $message = "File has been added successfully";
            $msg['msg'] = $message;
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
    }

    /**
     * @File Prepping
     */
    public function actionFileindexing() {
        //echo "hai";die;
        //$info = FileInfo::model()->findByPk($_GET['id']);
        $flag = false;
        $upflag = false;
        $model = new FilePartition();
        $model->scenario = 'fileindex';
        $msg = '';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-partition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }


        if (isset($_POST['FilePartition'])) {
            $model->attributes = $_POST['FilePartition'];
            if ($_GET['status'] == 'R') {
                $query = FilePartition::model()->findAll(array('condition' => "fp_file_id =$model->fp_file_id and fp_flag ='A'"));
                if ($query) {
                    foreach ($query as $queryprocess) {
                        if ($queryprocess->fp_category == 'M') {
                            $fpart_page_arr = explode(',', $_POST['FilePartition']['fp_page_nums']);
                            sort($fpart_page_arr);
                            $fpart_page_num = implode(',', $fpart_page_arr);
                            $queryprocess->fp_page_nums = $fpart_page_num;
                            //$queryprocess->fp_page_nums = $_POST['FilePartition']['fp_page_nums'];
//                            $queryprocess->fp_job_id = $_POST['FilePartition']['fp_job_id'];
                            $upflag = $queryprocess->save(false);
                        } else {
                            $queryprocess->fp_page_nums = $_POST['FilePartition']['npages'];
                            $upflag = $queryprocess->save(false);
                        }
                    }
                } else {
                    $model->fp_category = "M";
                    $model->fp_file_id = $_POST['FilePartition']['fp_file_id'];
                    $model->fp_job_id = $_POST['FilePartition']['fp_job_id'];
                    if (isset($_POST['FilePartition']['npages'])) {
                        if ($flag = $model->save(false)) {
                            $model1 = new FilePartition();
                            $model1->fp_file_id = $_POST['FilePartition']['fp_file_id'];
                            $model1->fp_job_id = $_POST['FilePartition']['fp_job_id'];
                            $model1->fp_category = "N";
                            $model1->fp_page_nums = $_POST['FilePartition']['npages'];
                            $flag = $model1->save();
                        }
                    } else {
                        $flag = $model->save(false);
                    }
                }
            } else {
                $filePartition = FilePartition::model()->findByPk($_GET['id']);
                $nonmedicalquery = FilePartition::model()->find(array('condition' => "fp_file_id =$model->fp_file_id and fp_flag ='A' and fp_category='N'"));
                $medicalquery = FilePartition::model()->find(array('condition' => "fp_file_id =$model->fp_file_id and fp_flag ='A' and fp_category='M'"));
                if ($filePartition && $nonmedicalquery) {
                    if ($filePartition->fp_category == 'M') {
                        $oldPage = explode(',', $medicalquery->fp_page_nums);
                        $newPage = explode(',', $_POST['FilePartition']['fp_page_nums']);
                        $nmPage = explode(',', $nonmedicalquery->fp_page_nums);
                        $result = array_diff($oldPage, $newPage);
                        $revresult = array_diff($newPage, $oldPage);
                        if (!empty($result) && empty($revresult)) {
                            $nmNum = array_merge($nmPage, $newPage);
                            $nmNum = array_values($nmNum);
                            sort($nmNum);
                            $mNum = array_values($result);
                            sort($mNum);
                            $filePartition->fp_page_nums = implode(',', $mNum);
                            $upflag = $filePartition->save(false);
                            $nonmedicalquery->fp_page_nums = implode(',', $nmNum);
                            $upflag = $nonmedicalquery->save(false);
                            $description = "Moved To Non-Medical";
                            Yii::app()->Audit->writeAuditLog("Moved", "FileIndex", $nonmedicalquery->fp_part_id, $description);
                            $msg['pages'] = json_encode($mNum, true);
                            $msg['msg'] = 'Moved To Non-Medical successfuly';
                            $msg['status'] = 'M';
                            echo json_encode($msg, true);
                            die();
                        } else {
                            $msg['msg'] = 'Cannot Move it!';
                            $msg['status'] = 'E';
                            echo json_encode($msg, true);
                            die();
                        }
                    } else {
                        $oldPage = explode(',', $nonmedicalquery->fp_page_nums);
                        $newPage = explode(',', $_POST['FilePartition']['fp_page_nums']);
                        $mPage = explode(',', $medicalquery->fp_page_nums);
                        $result = array_diff($oldPage, $newPage);
                        $revresult = array_diff($newPage, $oldPage);
                        if (!empty($result) && empty($revresult)) {
                            $mNum = array_merge($mPage, $newPage);
                            $mNum = array_values($mNum);
                            sort($mNum);
                            $nmNum = array_values($result);
                            sort($nmNum);
                            $filePartition->fp_page_nums = implode(',', $nmNum);
                            $upflag = $filePartition->save(false);
                            $medicalquery->fp_page_nums = implode(',', $mNum);
                            $upflag = $medicalquery->save(false);
                            $description = "Moved To Medical";
                            Yii::app()->Audit->writeAuditLog("Moved", "FileIndex", $medicalquery->fp_part_id, $description);
                            $msg['pages'] = json_encode($nmNum, true);
                            $msg['msg'] = 'Moved To Medical successfuly';
                            $msg['status'] = 'M';
                            echo json_encode($msg, true);
                            die();
                        } else {
                            $msg['msg'] = 'Cannot Move it!';
                            $msg['status'] = 'E';
                            echo json_encode($msg, true);
                            die();
                        }
                    }
                }
            }
            if ($flag) {
                $description = "File Index has been created";
                Yii::app()->Audit->writeAuditLog("Create", "FileIndex", $model->fp_part_id, $description);
                $msg['msg'] = 'File Index created successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
            if ($upflag) {
                $description = "File Update has been created";
                Yii::app()->Audit->writeAuditLog("Update", "FileIndex", $model->fp_part_id, $description);
                $msg['msg'] = 'File Index Update successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
            die();
        }
        if (Yii::app()->session['user_type'] == "R" || Yii::app()->session['user_type'] == "QC") {
            if (Yii::app()->session['user_type'] == 'R') {

                $jobAllc = JobAllocation::model()->find(array('condition' => "ja_file_id =$_GET[id] and ja_flag ='A' and ja_status = 'IA'"));
                if ($jobAllc && $jobAllc->ja_reviewer_accepted_time == '0000-00-00 00:00:00' && Yii::app()->session['user_type'] == "R") {
                    $jobAllc->ja_reviewer_accepted_time = date('Y-m-d H:i:s');
                    $jobAllc->save();
                }
                if ($jobAllc && ($jobAllc->ja_reviewer_id == Yii::app()->session['user_id'])) {
                    $restore_array = array();
                    $restore_json = "";
                    $restore_file_id = $jobAllc->ja_file_id;
                    $restore_file_info = FileInfo::model()->findByPk($restore_file_id);
                    $restore_project_id = $restore_file_info->fi_pjt_id;
                    $restore_project = $restore_project_id . "_restore";
                    if (!is_dir(Yii::app()->basePath . "/../file_restore/prepping" . $restore_project)) {
                        $restore_filename = Yii::app()->basePath . "/../file_restore/prepping/" . $restore_project . '/' . $restore_file_id . ".txt";
                        if (file_exists($restore_filename)) {
                            foreach (file($restore_filename) as $restore_line) {
                                $restore_array = explode('|', trim($restore_line));
                            }
                            $restore_json = json_encode($restore_array, true);
                        }
                    }
                    $nmedquery = array();
                    $nmedquery = FilePartition::model()->find(array('condition' => "fp_file_id =$_GET[id] and fp_category ='N' and fp_flag ='A'"));
//						$filepass = fopen('');
                    if (isset($_GET['status']) && isset($jobAllc) && (($jobAllc->ja_status == 'IA' && Yii::app()->session['user_type'] == $_GET['status']))) {
                        if ($restore_file_info && $restore_file_info->fi_admin_lock = "O") {
                            $restore_file_info->fi_admin_lock = "RL";
                            $restore_file_info->update("fi_admin_lock");
                        }
                        $this->render('file_index', array(
                            'model' => $model,
                            'nmedquery' => $nmedquery,
                            'restore_json' => $restore_json,
                        ));
                    } else {
                        $this->redirect(array("fileinfo/indexalloc"));
                    }
                } else {
                    $this->redirect(array("fileinfo/indexalloc"));
                }
            } else {
                $partitionmodel = FilePartition::model()->findByPk($_GET['id']);
                if (!empty($partitionmodel)) {
                    $fp_file = $partitionmodel->fp_file_id;
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_file_id =$fp_file and ja_flag ='A' and ja_status = 'IQP'"));
                    if (isset($_GET['status']) && $jobAllc && ($jobAllc->ja_qc_id == Yii::app()->session['user_id'])) {
                        if (isset($jobAllc) && ((($jobAllc->ja_status == 'IQP') && Yii::app()->session['user_type'] == $_GET['status']))) {
                            $this->render('quality_index', array(
                                'model' => $model
                            ));
                        } else {
                            $this->redirect(array("fileinfo/indexalloc"));
                        }
                    } else {
                        $this->redirect(array("fileinfo/indexalloc"));
                    }
                } else {
                    $this->redirect(array("fileinfo/indexalloc"));
                }
            }
        } else if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
            if ($_GET['status'] == 'R') {
                $jobAllc = JobAllocation::model()->find(array('condition' => "ja_file_id =$_GET[id] and ja_flag ='A' and ja_status = 'IA'"));
                if ($jobAllc && $jobAllc->ja_reviewer_accepted_time == '0000-00-00 00:00:00' || Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
                    $jobAllc->ja_reviewer_accepted_time = date('Y-m-d H:i:s');
                    $jobAllc->save();

                    if ($jobAllc && ($jobAllc->ja_reviewer_id == Yii::app()->session['user_id'] || (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL" ))) {
                        $restore_array = array();
                        $restore_json = "";
                        $restore_file_id = $jobAllc->ja_file_id;
                        $restore_file_info = FileInfo::model()->findByPk($restore_file_id);
                        $restore_project_id = $restore_file_info->fi_pjt_id;
                        $restore_project = $restore_project_id . "_restore";
                        if (!is_dir(Yii::app()->basePath . "/../file_restore/prepping" . $restore_project)) {
                            $restore_filename = Yii::app()->basePath . "/../file_restore/prepping/" . $restore_project . '/' . $restore_file_id . ".txt";
                            if (file_exists($restore_filename)) {
                                foreach (file($restore_filename) as $restore_line) {
                                    $restore_array = explode('|', trim($restore_line));
                                }
                                $restore_json = json_encode($restore_array, true);
                            }
                        }

                        $nmedquery = array();
                        $nmedquery = FilePartition::model()->find(array('condition' => "fp_file_id =$_GET[id] and fp_category ='N' and fp_flag ='A'"));
                        //$filepass = fopen('');
                        if (isset($jobAllc) && (($jobAllc->ja_status == 'IA' && $_GET['status'] == "R"))) {
                            $this->render('file_index', array(
                                'model' => $model,
                                'nmedquery' => $nmedquery,
                                'restore_json' => $restore_json,
                            ));
                        } else {
                            $this->redirect(array("fileinfo/allgrid"));
                        }
                    } else {
                        $this->redirect(array("fileinfo/allgrid"));
                    }
                }
            } else {
                $partitionmodel = FilePartition::model()->findByPk($_GET['id']);
                if (!empty($partitionmodel)) {
                    $fp_file = $partitionmodel->fp_file_id;
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_file_id =$fp_file and ja_flag ='A' and (ja_status = 'IQP' or ja_status='IC')"));
                    $jobAllc->ja_qc_id = Yii::app()->session['user_id'];
                    $jobAllc->save(false);

                    if ($jobAllc) {
                        if (isset($jobAllc) && ((($jobAllc->ja_status == 'IQP' || $jobAllc->ja_status == 'IC') && $_GET['status'] == "QC"))) {
                            $this->render('quality_index', array(
                                'model' => $model
                            ));
                        } else {
                            $this->redirect(array("fileinfo/allgrid"));
                        }
                    } else {
                        $this->redirect(array("fileinfo/allgrid"));
                    }
                } else {
                    $this->redirect(array("fileinfo/allgrid"));
                }
            }
        } else {
            $this->redirect(array("fileinfo/indexalloc"));
        }
    }

    public function actionFileswaping() {
        $nonmedicalquery = FilePartition::model()->find(array('condition' => "fp_file_id =$_GET[file_id] and fp_flag ='A' and fp_category='N'"));
        $medicalquery = FilePartition::model()->find(array('condition' => "fp_file_id =$_GET[file_id] and fp_flag ='A' and fp_category='M'"));
        if ($_POST['fp_category'] == 'M') {
            $oldPage = explode(',', $medicalquery->fp_page_nums);
            $res = array_diff($oldPage, array($_POST['fp_page_nums']));
            $res = array_values($res);
            sort($res);
            $medicalquery->fp_page_nums = implode(',', $res);
            if ($medicalquery->save()) {
                $newPage = explode(',', $nonmedicalquery->fp_page_nums);
                $merge = array_merge($newPage, array($_POST['fp_page_nums']));
                $merge = array_filter($merge);
                $merge = array_values($merge);
                sort($merge);
                $nonmedicalquery->fp_page_nums = implode(',', $merge);
                if ($nonmedicalquery->save()) {
                    $description = "Moved to Non-Medical";
                    Yii::app()->Audit->writeAuditLog("Create", "FilePage", $medicalquery->fp_part_id, $description);
                    $msg['med'] = $medicalquery->fp_page_nums;
                    $msg['nonmed'] = $nonmedicalquery->fp_page_nums;
                    $msg['msg'] = 'Moved to Non-Medical successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                }
            }
        } else if ($_POST['fp_category'] == 'N') {
            $oldPage = explode(',', $nonmedicalquery->fp_page_nums);
            $res = array_diff($oldPage, array($_POST['fp_page_nums']));
            $res = array_values($res);
            sort($res);
            $nonmedicalquery->fp_page_nums = implode(',', $res);
            if ($nonmedicalquery->save()) {
                $newPage = explode(',', $medicalquery->fp_page_nums);
                $merge = array_merge($newPage, array($_POST['fp_page_nums']));
                $merge = array_filter($merge);
                $merge = array_values($merge);
                sort($merge);
                $medicalquery->fp_page_nums = implode(',', $merge);
                if ($medicalquery->save()) {
                    $description = "Moved to Medical";
                    Yii::app()->Audit->writeAuditLog("Create", "FilePage", $nonmedicalquery->fp_part_id, $description);
                    $msg['med'] = $medicalquery->fp_page_nums;
                    $msg['nonmed'] = $nonmedicalquery->fp_page_nums;
                    $msg['msg'] = 'Moved to Medical successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                }
            }
        }
    }

    public function actionFindpagetype() {
        $pgtype = FilePartition::model()->findByAttributes(array('fp_file_id' => $_POST['fileid'], 'fp_cat_id' => 0), array('condition' => 'FIND_IN_SET(' . $_POST["pagenum"] . ',fp_page_nums) > 0 and fp_flag = "A" and (fp_category="M" or fp_category="N")'));
        $msg['category'] = $pgtype->fp_category;
        echo json_encode($msg, true);
        die();
    }

    public function actionAutosaveindex() {

        $file_id = $_POST['prepfileid'];
        $file_info = FileInfo::model()->findByPk($file_id);
        $project_id = $file_info->fi_pjt_id;
        $project = $project_id . "_restore";

        $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => 'IA', 'ja_flag' => 'A'));

        if ($_POST['mode'] == 'S' && $checkStatus) {
            if (!is_dir(Yii::app()->basePath . "/../file_restore/prepping/" . $project)) {
                mkdir(Yii::app()->basePath . "/../file_restore/prepping/" . $project, 0777, true);
            }
            $txt = $_POST['fpmedpages'] . "|" . $_POST['fpnonmed'];
            $filename = Yii::app()->basePath . "/../file_restore/prepping/" . $project . '/' . $file_id . ".txt";
            if (file_exists($filename)) {
                file_put_contents($filename, $txt);
                /* if ($valid) {
                  $fp = fopen($filename, 'a+');//opens file in append mode
                  fwrite($fp, $txt);
                  } */
            } else {
                file_put_contents($filename, $txt);
            }
        } else if ($_POST['mode'] == 'D') {
            if (is_dir(Yii::app()->basePath . "/../file_restore/prepping/" . $project)) {
                $filename = Yii::app()->basePath . "/../file_restore/prepping/" . $project . '/' . $file_id . ".txt";
                if (file_exists($filename)) {
                    unlink($filename);
                }
            }
        }
    }

    /**
     * @Indexing List
     */
    public function actionIndexinglist() {
        $_GET['indexing'] = "indexing";

        $model = new FileInfo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FileInfo']))
            $model->attributes = $_GET['FileInfo'];
        if (!empty($_POST['id'])) {
            $this->render('file_index', array(
                'model' => $model,
            ));
        } else {
            $this->render('user_view_index', array(
                'model' => $model,
            ));
        }
    }

    public function actionUploadservice() {
        $t = date("Ymdhis");
        if (isset($_FILES['file'])) {
            move_uploaded_file($_FILES['file']['tmp_name'], Yii::app()->basePath . "/../filepartition/" . $_REQUEST['path'] . "/" . $_FILES['file']['name']);
        }
    }

    /**
     * File Spliting
     */
    public function actionFilesplit() {
        $model = new FilePartition();
        $model->scenario = 'filesplit';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-partition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['FilePartition'])) {
            if ($_GET['status'] != 'QC') {
                $model->attributes = $_POST['FilePartition'];
                $model->fp_job_id = $_POST['FilePartition']['fp_job_id'];
                $validate = FilePartition::model()->findByAttributes(array('fp_file_id' => $model->fp_file_id, 'fp_cat_id' => $model->fp_cat_id), array('condition' => 'fp_category=""'));
                if ($validate) {
                    $oldPage = explode(',', $validate->fp_page_nums);
                    $newPage = explode(',', $model->fp_page_nums);
                    $diff = array_diff($newPage, $oldPage);
                    $merge = array_merge($oldPage, $diff);
                    sort($merge);
                    $validate->fp_page_nums = implode(',', $merge);
                    $validate->fp_cat_id = $model->fp_cat_id;
                    if ($validate->save()) {
                        $description = "File Page has been Updated";
                        Yii::app()->Audit->writeAuditLog("Update", "FilePage", $model->fp_part_id, $description);
                        $msg['msg'] = 'File page updated successfuly';
                        $msg['status'] = 'S';
                        echo json_encode($msg, true);
                        die();
                    }
                } else {
                    if ($model->save()) {
                        $description = "File Page has been created";
                        Yii::app()->Audit->writeAuditLog("Create", "FilePage", $model->fp_part_id, $description);
                        $msg['msg'] = 'File page created successfuly';
                        $msg['status'] = 'S';
                        echo json_encode($msg, true);
                        die();
                    }
                }
            } else {
                $model->attributes = $_POST['FilePartition'];
                $oldmodel = FilePartition::model()->findByAttributes(array('fp_file_id' => $model->fp_file_id, 'fp_cat_id' => $_POST['old_cat_id']), array('condition' => 'fp_category=""'));
                $oldPage = explode(',', $oldmodel->fp_page_nums);
                $res = array_diff($oldPage, array($_POST['curnt_page']));
                $res = array_values($res);
                sort($res);
                $oldmodel->fp_page_nums = implode(',', $res);
                if (empty($oldmodel->fp_page_nums)) {
                    if ($oldmodel->delete()) {
                        $model_status = true;
                    }
                    $msg['status'] = 'N';
                } else {
                    if ($oldmodel->save(false)) {
                        $model_status = true;
                    }
                    $msg['status'] = 'M';
                }
                if ($model_status) {
                    $newmodel = FilePartition::model()->findByAttributes(array('fp_file_id' => $model->fp_file_id, 'fp_cat_id' => $model->fp_cat_id), array('condition' => 'fp_category=""'));
                    if ($newmodel) {
                        $newPage = explode(',', $newmodel->fp_page_nums);
                        $merge = array_merge($newPage, array($_POST['curnt_page']));
                        $merge = array_values($merge);
                        sort($merge);
                        $newmodel->fp_page_nums = implode(',', $merge);
                    } else {
                        $newmodel = new FilePartition();
                        $newmodel->fp_file_id = $model->fp_file_id;
                        $newmodel->fp_job_id = $model->fp_job_id;
                        $newmodel->fp_cat_id = $model->fp_cat_id;
                        $newmodel->fp_page_nums = $_POST['curnt_page'];
                    }

                    if ($newmodel->save(false)) {
                        $pg_arr = explode(',', $oldmodel->fp_page_nums);
                        $msg['pages'] = json_encode($pg_arr, true);
                        $description = "Page Moved To Another Category";
                        Yii::app()->Audit->writeAuditLog("Move", "FilePage", $newmodel->fp_part_id, $description);
                        $msg['msg'] = 'Page Moved Successfuly';
                        echo json_encode($msg, true);
                        die();
                    }
                }
            }
        }
        $this->render('file_split', array(
            'model' => $model,
        ));
    }

    /**
     * @Quit Job Status based indexingFile and SplitFile
     */
    public function actionQuitfile() {
        $model = new JobAllocation();
        $model->scenario = 'quit';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-quit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $flag = false;
        if (isset($_GET['jobId']) && isset($_GET['status']) && isset($_GET['id']) && isset($_POST['JobAllocation'])) {
            if ($_GET['status'] == 'IQ') {
                $jobAllocation = JobAllocation::model()->findByAttributes(array('ja_file_id' => $_GET['id'], 'ja_status' => 'IA', 'ja_flag' => 'A'));
                $jobAllocation->ja_status = $_GET['status'];
                $jobAllocation->ja_reason = json_encode($_POST['JobAllocation']);
                $filePartition = FilePartition::model()->findAll(array('condition' => "fp_file_id ='" . $_GET['id'] . "' and fp_category <>'' and fp_cat_id =0"));
                if ($filePartition) {
                    foreach ($filePartition as $fp) {
                        $fp->fp_status = 'Q';
                        $fp->save(false);
                    }
                }
                $msg['typ'] = 'IQ';
                $this->actionDeleterestore($_GET['id']);
            } else if ($_GET['status'] == 'SQ') {
                $jobAllocation = JobAllocation::model()->findByPk($_GET['jobId']);
                $jobAllocation->ja_status = $_GET['status'];
                $jobAllocation->ja_reason = json_encode($_POST['JobAllocation']);
                $filePartition = FilePartition::model()->findAll(array('condition' => "fp_job_id ='" . $_GET['jobId'] . "' and fp_category = '' and fp_cat_id <> 0"));
                if ($filePartition) {
                    foreach ($filePartition as $fp) {
                        $fp->fp_status = 'Q';
                        $fp->save(false);
                    }
                }
                $msg['typ'] = 'SQ';
                FilepartitionController::actionDeleterestore($jobAllocation->ja_file_id);
            }
            if ($jobAllocation->save(false)) {
                $file_unlock = FileInfo::model()->findByPk($_GET['id']);
                $file_unlock->fi_admin_lock = "O";
                $file_unlock->save();
                $description = "File has been Quit";
                Yii::app()->Audit->writeAuditLog("Create", "FilePage", $_GET['jobId'], $description);
                $msg['msg'] = 'File  Quit successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
        }
        $this->renderPartial('quitProcess', array('model' => $model), false, true);
    }

    /**
     * @Complete Job Status based indexingFile and SplitFile
     */
    public function actionCompletefile() {
        if (isset($_GET['id']) && isset($_GET['status']) && isset($_POST['FilePartition'])) {
            $filePartition = FilePartition::model()->find(array("condition" => "fp_file_id = '$_GET[id]' and fp_flag = 'A'"));
            if (!$filePartition) {
                $model = new FilePartition();
                $model->fp_file_id = $_GET['id'];
                $model->fp_category = "M";
                $model->fp_page_nums = trim($_POST['FilePartition']['fp_page_nums'], ",");
                $model->save();
                $model = new FilePartition();
                $model->fp_file_id = $_GET['id'];
                $model->fp_category = "N";
                $model->fp_page_nums = trim($_POST['FilePartition']['npages'], ",");
                $model->save();
            }
        }
        $status = $this->actionCheckqualitystatus($_GET['projectId'], $_GET['mode'], $_GET['jobId'], $_GET['status']);
        if ($status) {
            $fileopen = FileInfo::model()->findByPk($_GET['id']);
            $fileopen->fi_admin_lock = "O";
            $fileopen->update('fi_admin_lock');
            $description = "File has been completed";
            Yii::app()->Audit->writeAuditLog("Complete", "Prepping", $_GET['jobId'], $description);
            $msg['msg'] = 'File  Completed successfuly';
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
    }

    public function actionInterference($file_id) {
        $returnvalue = array();
        $jobcl = JobAllocation::model()->findAll(array('condition' => "ja_file_id =$file_id and (ja_status = 'QC' or ja_status = 'QEC') and ja_flag ='A'"));
        foreach ($jobcl as $key => $value) {
            if ($value->ja_status == "QC" && $value->ja_partition_id == 0) {
                $pr_arr = array_filter(array_unique(Yii::app()->Audit->readAuditLog("Prepping", $value->ja_job_id)));
                $returnvalue[] = array_values($pr_arr);
                $pq_arr = array_filter(array_unique(Yii::app()->Audit->readAuditLog("Prepping QC", $value->ja_job_id)));
                $returnvalue[] = array_values($pq_arr);
            } else if ($value->ja_status == "QC" && $value->ja_partition_id <> 0) {
                $dr_arr = array_filter(array_unique(Yii::app()->Audit->readAuditLog("Datecoding", $value->ja_job_id)));
                $returnvalue[] = array_values($dr_arr);
                $dq_arr = array_filter(array_unique(Yii::app()->Audit->readAuditLog("Datecoding QC", $value->ja_job_id)));
                $returnvalue[] = array_values($dq_arr);
            }
        }
        $this->renderPartial('interference', array('returnvalue' => $returnvalue), false, true);
    }

    public static function actionDeleterestore($delt_fileid) {
        $delt_file_id = $delt_fileid;
        $delt_file_info = FileInfo::model()->findByPk($delt_file_id);
        $delt_project_id = $delt_file_info->fi_pjt_id;
        $delt_project = $delt_project_id . "_restore";

        if (is_dir(Yii::app()->basePath . "/../file_restore/prepping/" . $delt_project)) {
            $delt_filename = Yii::app()->basePath . "/../file_restore/prepping/" . $delt_project . '/' . $delt_file_id . ".txt";
            if (file_exists($delt_filename)) {
                unlink($delt_filename);
            }
        }
    }

    public static function actionCheckqualitystatus($projectId, $processState, $jobid, $qcComplete) {
        $ProcessArray = array();

        if ($projectId != "") {
            $ProjectProcess = Project::model()->findByPk($projectId)->p_process;
            $ProcessArray = explode(",", $ProjectProcess);
        }
        if ($jobid != "") {
            $jobAlloc = JobAllocation::model()->findByPk($jobid);
        }
        if ($processState == "I") {

            if (empty($jobAlloc->ja_skip_qc) && in_array("QI", $ProcessArray) && $qcComplete == false) {
                $jobAlloc->ja_status = "IC";
                $jobAlloc->ja_reviewer_completed_time = date('Y-m-d H:i:s');
                $jobAlloc->ja_last_modified = date('Y-m-d H:i:s');
                $jobAlloc->ja_status = "IC";
                $jobAlloc->save(false);
                return "IC";
            } else {
                $criteria = new CDbCriteria;
                $criteria->addInCondition("fp_file_id", array($jobAlloc->ja_file_id));
                $filePart = FilePartition::model()->updateAll(array('fp_status' => 'I'), $criteria);
                $FilePartModel = FilePartition::model()->find(array('condition' => " fp_file_id = " . $jobAlloc->ja_file_id . " and fp_category = 'M' and fp_cat_id = 0 and fp_flag = 'A'"));
                $FileNonPartModel = FilePartition::model()->find(array('condition' => " fp_file_id = " . $jobAlloc->ja_file_id . " and fp_category = 'N' and fp_cat_id = 0 and fp_flag = 'A'"));
                $JobSpAlloc = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $jobAlloc->ja_file_id . " and ja_status = 'SA' and ja_flag = 'A'"));
                $JobSpAlloc->ja_partition_id = $FilePartModel->fp_part_id;
                $JobSpAlloc->ja_npartition_id = $FileNonPartModel->fp_part_id;

                $filemodel = FileInfo::model()->findByPk($JobSpAlloc->ja_file_id);
                if ($filemodel->ProjectMaster->p_key_type == 'N') {
                    $JobSpAlloc->ja_med_status = "R";
                    $JobSpAlloc->ja_nonmed_status = "R";
                }

                $JobSpAlloc->save(false);

                $jobAlloc->ja_status = "QC";
                if ($qcComplete == false) {
                    $jobAlloc->ja_reviewer_completed_time = date('Y-m-d H:i:s');
                } else {
                    $jobAlloc->ja_qc_completed_time = date('Y-m-d H:i:s');
                }
                $jobAlloc->ja_last_modified = date('Y-m-d H:i:s');
                $jobAlloc->save(false);
                return "IQC";
            }
        } else if ($processState == "S") {
            $filefinmodel = FileInfo::model()->findByPk($jobAlloc->ja_file_id);
            if ($filefinmodel->ProjectMaster->p_key_type == 'N') {
                $jobAlloc->ja_med_status = "C";
                $jobAlloc->ja_nonmed_status = "C";
            }
            $jobAlloc->ja_reviewer_completed_time = date('Y-m-d H:i:s');
            $jobAlloc->ja_last_modified = date('Y-m-d H:i:s');
            if (empty($jobAlloc->ja_skip_qc) && in_array("QS", $ProcessArray) && $qcComplete == false) {
                $jobAlloc->ja_status = "SC";
                $jobAlloc->save(false);
                return "SC";
            } else {
                /* $criteria = new CDbCriteria;
                  $criteria->addInCondition("fp_file_id", array($jobAlloc->ja_file_id));
                  $filePart = FilePartition::model()->updateAll(array('fp_status' => 'S'), $criteria); */

                $jobAlloc->ja_status = "QC";
                $jobAlloc->save(false);
                $check_skip_ed = Project::model()->findByPk($filefinmodel->fi_pjt_id);
                if ($check_skip_ed->skip_edit == 1) {
                    $ed_model = new JobAllocation();
                    $ed_model->ja_file_id = $jobAlloc->ja_file_id;
                    $ed_model->ja_status = "QEC";
                    $ed_model->save(false);
                }
                return "SQC";
//                
            }
        }
//        else if ($processState == "E") {
//            if (in_array("QE", $ProcessArray) && $qcComplete == false) {
//                $filePart = FilePartition::model()->find(array("condition" => "fp_file_id =" . $jobAlloc->ja_file_id));
//                $filePart->fp_status = "C";
//                $filePart->save();
//                die("EP");
//            } else {
//                $jobAlloc->ja_status = "QC";
//                $jobAlloc->save();
//                die("EC");
//            }
//        }
    }

    /**
     * @Pop Up Spilted Page View
     */
    public function actionSplitview() {
        if (isset($_REQUEST['id'])) {
            $model = FilePartition::model()->findAllByAttributes(array('fp_file_id' => $_REQUEST['id']), array('condition' => 'fp_category="" and  fp_cat_id!=""'));
            $this->renderPartial('splitview', array('model' => $model), false, true);
        }
    }

    public function actionExport($id) {
        $fileInfo = FileInfo::model()->findByPk($id);
        $tmp_id = !empty($fileInfo->fi_template_id) ? $fileInfo->fi_template_id : $fileInfo->ProjectMaster->template_id;
        $makeModels = Templates::model()->find(array("select" => "t_name", "condition" => "id=" . $tmp_id));
        $template = $makeModels->t_name;
        switch ($template) {
            case "WSXLS":
                Yii::app()->downloadtemplates->$template($id);
                break;
            case "WOSXLS":
                Yii::app()->downloadtemplates->$template($id);
                break;
        }
        /* $fileInfo = FileInfo::model()->findByPk($id);
          $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
          $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
          $prject_name = Project::model()->findByPk($project_id);
          $filePartition = JobAllocation::model()->find(array('condition' => "ja_file_id=$id  and ja_status='QC'"));
          $rvrname = $filePartition->Rvrname->ud_name;
          $dir = "filepartition/" . $project_id . "_breakfile";
          $p_name = $prject_name->p_name;
          if ($prject_name->p_name === 'MV') {

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

          function date_sort($a, $b)
          {
          $t1 = strtotime($a['fl_dos']);
          $t2 = strtotime($b['fl_dos']);


          return $t2 - $t1;

          }

          usort($files, "date_sort");
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

          XlsExporter::downloadXls('Completed', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name); */
    }

    public function actionNewexport($id) {
        $heading = array('Page Numbers', 'DOS', 'Patient Name', 'Category', 'Provider', 'Processed Date', 'Summary');
        $fields = array('page_no', 'fl_dos', 'fl_patient', 'fl_category', 'fl_provider', 'fl_proc_date', 'fl_summary');
        $files = array();
        $fileInfo = FileInfo::model()->findByPk($id);
        $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
        $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
        $prject_name = Project::model()->findByPk($project_id);
        $filePartition = JobAllocation::model()->find(array('condition' => "ja_file_id=$id  and ja_status='QC'"));
        $rvrname = $filePartition->Rvrname->ud_name;
        $dir = "filepartition/" . $project_id . "_breakfile";
        $p_name = $prject_name->p_name;
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
        XlsExporter::downloadXls('Completed', $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);
    }

    public function actionClientdownload($cl_id, $f_id) {
        $exactpath = Yii::app()->basePath . "/../clientdownload/" . $cl_id . "/" . $f_id . ".doc";
        if (file_exists($exactpath)) {
            $name = 'wordformat.doc';
            file_put_contents($name, $exactpath);
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

    public function actionTreegrid($id) {
        $filePartition = FilePartition::model()->findAll(array('condition' => " fp_file_id = $id and fp_category != '' and fp_cat_id = 0 and fp_flag = 'A'"));
        $result = "<tr><td colspan='100'><table style='width: 100%;'><tr><th>Category</th><th>No. Of Pages</th>";
        if (Yii::app()->session['user_type'] == 'QC') {
            // $result .= "<th>Action</th>";
        }
        $result .= "</tr>";

        if ($filePartition) {
            foreach ($filePartition as $key => $value) {
                if ($value->fp_page_nums) {
                    $explodePage = count(explode(',', $value->fp_page_nums));
                } else {
                    $explodePage = 0;
                }
                $category = $value->fp_category == 'M' ? 'Medical' : 'Non-Medical';
                $result .= '<tr><td style="background-color: aliceblue;text-align: center">' . $category . '</td><td style="background-color: aliceblue; text-align: center"><span data-uk-tooltip="{cls:\'long-text\'}" title="' . $value->fp_page_nums . '">' . $explodePage . '</span></td>';
                if (Yii::app()->session['user_type'] == "QC") {
                    // $result .= "<td style='background-color: aliceblue;text-align: center'><a class='SplitQc' href='" . Yii::app()->createUrl('fileinfo/fileindexing', array('id' => $value->fp_part_id, 'status' => 'QC')) . "'><i class='material-icons md-24'>&#xE8E5;</i></a></td>";
                }
                $result .= '</tr>';
            }
        } else {
            $result .= '<tr><td colspan="2" style="background-color: aliceblue;text-align: center"> No Result </td></tr>';
        }
        $result .= "</table></td></tr>";
        echo $result;
    }

    public function actionTreegrid2($id) {
        $result = "<tr><td colspan='100'><table style='width: 100%;'><tr><th>Category</th><th>Patient Name</th><th>DOS</th><th>Partation Taken</th><th>No. Of Pages</th>";
        if (Yii::app()->session['user_type'] == "QC") {
            //$result .= '<th>Action</th>';
        }
        $fileInfo = FileInfo::model()->findByPk($id);
        $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
        $dir = "filepartition/" . $project_id . "_breakfile";
        if (is_dir($dir)) {
            $file_dir = $dir . "/" . $id . ".txt";
            if (file_exists($file_dir)) {
                foreach (file($file_dir) as $line) {
                    $exp_file = explode('|', trim($line));
                    $no_of_page = count(explode(',', $exp_file[0]));
                    $cat = Category::model()->findByPk($exp_file[3]);
                    $catname = $cat ? $cat->ct_cat_name : '';
                    $reviewer = $exp_file[14] ? $exp_file[14] : '-';
                    $name = Yii::app()->filerecord->getUsername($reviewer);
                    $result .= '<tr><td style="background-color: aliceblue;text-align: center">' . $catname . '</td>';
                    $result .= '<td style="background-color: aliceblue;text-align: center">' . $exp_file[2] . '</td>';
                    $result .= '<td style="background-color: aliceblue;text-align: center">' . $exp_file[1] . '</td>';
                    $result .= '<td style="background-color: aliceblue;text-align: center">' . $name . '</td>';
                    $result .= '<td style="background-color: aliceblue; text-align: center">' . $no_of_page . '</td>';
                }
            } else {
                $result .= '<tr><td colspan="4" style="background-color: aliceblue;text-align: center"> No Result </td></tr>';
            }
        } else {
            $result .= '<tr><td colspan="4" style="background-color: aliceblue;text-align: center"> No Result </td></tr>';
        }


        $result .= "</table></td></tr>";
        echo $result;
        /* $filePartition = FilePartition::model()->findAll(array('condition' => " fp_file_id = $id and fp_category = '' and fp_cat_id != 0 "));
          $result = "<tr><td colspan='100'><table style='width: 100%;'><tr><th>Category</th><th>No. Of Pages</th>";
          if (Yii::app()->session['user_type'] == "QC") {
          $result .= '<th>Action</th>';
          }
          $result .= '</tr>';
          if ($filePartition) {
          foreach ($filePartition as $key => $value) {
          $explodePage = count(explode(',', $value->fp_page_nums));
          $category = isset($value->Category->ct_cat_name) ? $value->Category->ct_cat_name : '';
          $result .= '<tr><td style="background-color: aliceblue;text-align: center">' . $category . '</td><td style="background-color: aliceblue; text-align: center">' . $explodePage . '</td>';
          if (Yii::app()->session['user_type'] == "QC") {
          $result .= "<td style='background-color: aliceblue;text-align: center'><a class='SplitQc' href='" . Yii::app()->createUrl('fileinfo/filesplit', array('id' => $value->fp_part_id, 'status' => 'QC')) . "'><i class='material-icons md-24'>&#xE8E5;</i></a></td>";
          }
          $result .= '</tr>';
          }
          } else {
          $result .= '<tr><td colspan="2" style="background-color: aliceblue;text-align: center"> No Result </td></tr>';
          }
          $result .= "</table></td></tr>";
          echo $result; */
    }

    public function actionAllgrid() {
        $condition = "1=1";
        $concat_condn = "";
        if (!empty($_GET["seletedDate"])) {
            $seletedDate = date("Y-m-d", strtotime($_GET["seletedDate"]));
            $condition .= " and fi_created_date like '%$seletedDate%' ";
        }
        if (!empty($_GET["rseletedDate"])) {
            $seletedDate = date("Y-m-d", strtotime($_GET["rseletedDate"]));
            $condition .= " and ja_reviewer_allocated_time like '%$seletedDate%' ";
        }
        if (!empty($_GET["qseletedDate"])) {
            $seletedDate = date("Y-m-d", strtotime($_GET["qseletedDate"]));
            $condition .= " and ja_qc_accepted_time like '%$seletedDate%' ";
        }
        if (!empty($_GET["seletedProject"])) {
            $condition .= " and fi_pjt_id ='$_GET[seletedProject]' ";
        }
        if (!empty($_GET["seletedUser"])) {
            $condition .= " and (job_allocation_ja.ja_reviewer_id ='$_GET[seletedUser]' or job_allocation_ja.ja_qc_id ='$_GET[seletedUser]')";
        }
        if (!empty($_GET["searchText"])) {
            if ($_GET["curProcess"] == "Prepping" || $_GET["curProcess"] == "Splitting" || $_GET["curProcess"] == "Editor") {
                $concat_condn = "or qc.ud_name LIKE '%$_GET[searchText]%'
								or rv.ud_name LIKE '%$_GET[searchText]%'";
            }
            $condition .= " and (
								fi_file_name LIKE '%$_GET[searchText]%'
								or p_name LIKE '%$_GET[searchText]%'
								or fi_created_date LIKE '%$_GET[searchText]%'
								or ja_reviewer_allocated_time LIKE '%$_GET[searchText]%'
								or fi_total_pages LIKE '%$_GET[searchText]%'
								$concat_condn
							)";
        }
        if (empty($_GET["curProcess"]) || $_GET["curProcess"] == "All") {
            $filInfoQuery = "SELECT 
                        fi_file_id AS primaryid, 
                        fi_file_name AS file_name, 
                        fi_file_ori_location AS file_location, 
                        fi_admin_lock AS ad_lock, 
                        ja_reviewer_allocated_time AS processed_date,
                        ja_reviewer_completed_time AS prep_completed_date, 
                        fi_created_date AS upload_date, 
                        p_name AS project_name, 
                        project_p.p_pjt_id As p_id,
                        project_p.p_op_format As pr_format,
                        ja_job_id, ja_status, 
                        rv.ud_name as reviewer_name,
                        rv.ud_refid AS reviewer_id,
                        qc.ud_name as qc_name,
                        qc.ud_refid AS qc_id,
						ja_qc_feedback AS feedback,
                        fi_status, 
                        fi_pjt_id,
                        fi_total_pages
                        FROM file_info_fi
                        LEFT JOIN file_partition_fp ON fi_file_id = fp_file_id AND fp_flag = 'A'
                        LEFT JOIN project_p ON fi_pjt_id = p_pjt_id
                        LEFT JOIN job_allocation_ja ON fi_file_id = ja_file_id AND ja_flag = 'A'
                        LEFT JOIN user_details_ud as rv on job_allocation_ja.ja_reviewer_id=rv.ud_refid
                        LEFT JOIN user_details_ud as qc on job_allocation_ja.ja_qc_id=qc.ud_refid
                        WHERE ((
                        fi_status =  'P'
                        AND ja_job_id IS NULL
                        )
                        OR (
                        ja_job_id IS NOT NULL 
                        AND ja_job_id
                        IN (
                        
                        SELECT MAX( ja_job_id ) 
                        FROM job_allocation_ja
                        WHERE ja_flag = 'A'
						and (ja_status =  'IA'
                        OR ja_status =  'IC'
                        OR ja_status =  'IQP'
                        OR ja_status =  'IQ'
                        OR (ja_status ='QC' and ja_partition_id = 0))
                        GROUP BY ja_file_id
                        )
                        AND ja_status <>  'QC'
                        )
						OR (
						ja_job_id IS NOT NULL 
                        AND ja_job_id
                        IN (
                        
                        SELECT MAX( ja_job_id ) 
                        FROM job_allocation_ja
                        WHERE ja_flag = 'A'  
						and (ja_status =  'SA'
                        OR ja_status =  'SC'
                        OR ja_status =  'SQP'
                        OR ja_status =  'SQ'
						OR (ja_status ='QC' and ja_partition_id <> 0))
                        GROUP BY ja_file_id
                        )
                        AND ja_status <>  'QC'
						AND fp_category =  'M'
                        AND fp_cat_id =0
                        AND fp_status =  'I'
						)
                        OR (
                        ja_job_id IS NOT NULL
						and
							ja_job_id
							IN (
								select max(ja_job_id) 
								from job_allocation_ja 
								where ja_flag = 'A' 
								and ((ja_status ='QC' and ja_partition_id <> 0)
								or ja_status ='EA' 
								or ja_status ='EC' 
								or ja_status ='QEA' 
								or ja_status = 'EQ' 
								or ja_status ='QEC') 
								GROUP BY ja_file_id
                                                                
							)
						and ja_status <> 'QEC'
                        AND fp_category =  'M'
                        AND fp_cat_id =0
                        AND fp_status =  'I'
                        )
						OR(
						ja_status ='QEC'
						AND fp_category =  'M'
                        AND fp_cat_id =0
                        AND fp_status =  'I'
						)) and $condition
                        GROUP BY fi_file_id order by fi_last_modified desc";
        } else if ($_GET["curProcess"] == "New") {
            $condition .= " and fi_status = 'P' and ja_job_id is NULL ";
            $filInfoQuery = "select 
                          fi_file_id as primaryid,
                          fi_file_name as file_name,
                          fi_file_ori_location as file_location,
                          fi_admin_lock AS ad_lock, 
						  ja_reviewer_allocated_time AS processed_date, 
						  fi_created_date AS upload_date,
                          p_name as project_name, 
                          project_p.p_pjt_id As p_id,
                          project_p.p_op_format As pr_format,
                          ja_job_id,
                          ja_status,
                          rv.ud_name as reviewer_name,
                          rv.ud_refid AS reviewer_id,
                          qc.ud_name as qc_name,
                          qc.ud_refid AS qc_id,
						  fi_status,
                          fi_total_pages
                          from file_info_fi 
                          LEFT JOIN project_p on fi_pjt_id = p_pjt_id
                          LEFT JOIN job_allocation_ja on fi_file_id = ja_file_id AND ja_flag = 'A'
                          LEFT JOIN user_details_ud as rv on job_allocation_ja.ja_reviewer_id=rv.ud_refid
                          LEFT JOIN user_details_ud as qc on job_allocation_ja.ja_qc_id=qc.ud_refid
                          where $condition
						  ORDER BY fi_created_date DESC";
        } else if ($_GET["curProcess"] == "Prepping") {
            $condition .= " and ja_job_id IS NOT NULL 
							and ja_job_id IN (select max(ja_job_id) from job_allocation_ja where ja_flag = 'A' and (ja_status ='IA' or ja_status ='IC' or ja_status ='IQP' or ja_status ='IQ' or (ja_status ='QC' and ja_partition_id = 0)) GROUP BY ja_file_id)
							and ja_status <> 'QC'";
            $filInfoQuery = "select 
                          fi_file_id as primaryid,
                          fi_file_name as file_name,
                          fi_file_ori_location as file_location,
                          fi_admin_lock AS ad_lock, 
						  ja_reviewer_allocated_time AS processed_date,
						  ja_reviewer_completed_time AS prep_completed_date, 
						  fi_created_date AS upload_date,
						  project_p.p_pjt_id As p_id,
                          p_name as project_name,
                          project_p.p_op_format As pr_format,
                          ja_job_id,
                          ja_status,
						  ja_qc_feedback AS feedback,
                          rv.ud_name as reviewer_name,
                          rv.ud_refid AS reviewer_id,
                          qc.ud_name as qc_name,
                          qc.ud_refid AS qc_id,
						  fi_status,
                          fi_total_pages
                          from file_info_fi
                          LEFT JOIN project_p on fi_pjt_id = p_pjt_id
                          LEFT JOIN job_allocation_ja on fi_file_id = ja_file_id AND ja_flag = 'A'
                          LEFT JOIN user_details_ud as rv on job_allocation_ja.ja_reviewer_id=rv.ud_refid
                          LEFT JOIN user_details_ud as qc on job_allocation_ja.ja_qc_id=qc.ud_refid
						  where $condition
						  ORDER BY ja_last_modified DESC";
        } elseif ($_GET["curProcess"] == "Splitting") {
            $condition .= " and ja_job_id IS NOT NULL 
							and ja_job_id IN (select max(ja_job_id) from job_allocation_ja where ja_flag = 'A' and (ja_status ='SA' or ja_status ='SC' or ja_status ='SQP' or ja_status ='SQ' or (ja_status ='QC' and ja_partition_id <> 0)) GROUP BY ja_file_id)
							and ja_status <> 'QC'";
            $condition .= " and fp_category = 'M' and fp_cat_id = 0 and fp_status = 'I' ";
            $filInfoQuery = "select 
                          fi_file_id as primaryid,
                          fi_file_name as file_name,
                          fi_file_ori_location as file_location,
                          fi_admin_lock AS ad_lock, 
						  ja_reviewer_allocated_time AS processed_date, 
						  ja_reviewer_completed_time AS prep_completed_date, 
						  fi_created_date AS upload_date,
						  fp_part_id AS partitionid,
						  project_p.p_pjt_id As p_id,
                          p_name as project_name, 
                          project_p.p_op_format As pr_format,
						  ja_job_id,
                          ja_status,
						  ja_qc_feedback AS feedback,
						  rv.ud_name as reviewer_name,
                          rv.ud_refid AS reviewer_id,
                          qc.ud_name as qc_name,
                          qc.ud_refid AS qc_id,
						  fi_status,
						  fi_total_pages,
                          ja_reviewer_accepted_time AS revieweratime,
                          ja_reviewer_completed_time AS reviewerctime,
                          ja_qc_accepted_time AS qcatime,
                          ja_qc_completed_time AS qcctime,
                          ja_qc_id,
                          ja_reviewer_id
						  from file_info_fi 
						  LEFT JOIN file_partition_fp on fi_file_id = fp_file_id AND fp_flag = 'A'
                          LEFT JOIN project_p on fi_pjt_id = p_pjt_id
						  LEFT JOIN job_allocation_ja on fi_file_id = ja_file_id AND ja_flag = 'A'
						  LEFT JOIN user_details_ud as rv on job_allocation_ja.ja_reviewer_id=rv.ud_refid
                          LEFT JOIN user_details_ud as qc on job_allocation_ja.ja_qc_id=qc.ud_refid
                          where $condition
						  ORDER BY ja_last_modified DESC";
        } elseif ($_GET["curProcess"] == "Editor") {
            $condition .= " and ja_job_id IS NOT NULL 
							and ja_job_id IN (select max(ja_job_id) from job_allocation_ja where ja_flag = 'A' and ((ja_status ='QC' and ja_partition_id <> 0) or ja_status ='EA' or ja_status ='EC' or ja_status ='QEA' or ja_status = 'EQ' or ja_status ='QEC') GROUP BY ja_file_id)
							and ja_status <> 'QEC'";
            $condition .= " and fp_category = 'M' and fp_cat_id = 0 and fp_status = 'I' ";
            $filInfoQuery = "select 
                          fi_file_id as primaryid,
                          fi_file_name as file_name,
                          fi_file_ori_location as file_location,
                          fi_admin_lock AS ad_lock, 
						  ja_reviewer_allocated_time AS processed_date, 
						  fi_created_date AS upload_date,
						  project_p.p_pjt_id As p_id,
                          p_name as project_name, 
                          project_p.p_op_format As pr_format,
						  ja_job_id,
                          ja_status,
						  ja_qc_feedback AS feedback,
						  rv.ud_name as reviewer_name,
                          rv.ud_refid AS reviewer_id,
                          qc.ud_name as qc_name,
                          qc.ud_refid AS qc_id,
						  fi_status,
						  fi_total_pages,
                          ja_reviewer_accepted_time AS revieweratime,
                          ja_reviewer_completed_time AS reviewerctime,
                          ja_qc_accepted_time AS qcatime,
                          ja_qc_completed_time AS qcctime,
                          ja_qc_id,
                          ja_reviewer_id
						  from file_info_fi 
						  LEFT JOIN file_partition_fp on fi_file_id = fp_file_id AND fp_flag = 'A'
                          LEFT JOIN project_p on fi_pjt_id = p_pjt_id
						  LEFT JOIN job_allocation_ja on fi_file_id = ja_file_id AND ja_flag = 'A'
						  LEFT JOIN user_details_ud as rv on job_allocation_ja.ja_reviewer_id=rv.ud_refid
                          LEFT JOIN user_details_ud as qc on job_allocation_ja.ja_qc_id=qc.ud_refid
                          where $condition
						  ORDER BY ja_last_modified DESC";
        } elseif ($_GET["curProcess"] == "Completed") {
            $condition .= " and ja_status ='QEC' ";
            $condition .= " and fp_category = 'M' and fp_cat_id = 0 and fp_status = 'I' ";
            $filInfoQuery = "select 
                          fi_file_id as primaryid,
                          fi_file_name as file_name,
                          fi_file_ori_location as file_location,
                          fi_admin_lock AS ad_lock, 
						  ja_reviewer_allocated_time AS processed_date, 
						  fi_created_date AS upload_date,
						  fp_part_id AS partitionid,
						  project_p.p_pjt_id As p_id,
						  project_p.p_op_format As pr_format,
                          p_name as project_name, 
						  ja_job_id,
                          ja_status,
						  ja_last_modified,
						  rv.ud_name as reviewer_name,
                          rv.ud_refid AS reviewer_id,
                          qc.ud_name as qc_name,
                          qc.ud_refid AS qc_id,
						  fi_status,
						  fi_total_pages
						  from file_info_fi 
						  LEFT JOIN file_partition_fp on fi_file_id = fp_file_id AND fp_flag = 'A'
                          LEFT JOIN project_p on fi_pjt_id = p_pjt_id
						  LEFT JOIN job_allocation_ja on fi_file_id = ja_file_id AND ja_flag = 'A'
						  LEFT JOIN user_details_ud as rv on job_allocation_ja.ja_reviewer_id=rv.ud_refid
                          LEFT JOIN user_details_ud as qc on job_allocation_ja.ja_qc_id=qc.ud_refid
                          
                          where $condition
						  ORDER BY ja_last_modified DESC";
        }
        //print_r($filInfoQuery);
        $filePartition = Yii::app()->db->createCommand($filInfoQuery)->queryAll();

        if (isset($_REQUEST['size'])) {
            $pagination = $_REQUEST['size'];
            Yii::app()->session['pagination'] = $_REQUEST['size'];
        } else {
            $pagination = Yii::app()->session['pagination'];
        }
        $sort = array();
        if (isset($filePartition[0])) {
            $sort = array_keys($filePartition[0]);
        }

        $dataProvider = new CArrayDataProvider($filePartition, array(
            'keyField' => 'primaryid',
            'sort' => array(
                'attributes' => $sort,
            ),
            'pagination' => array(
                'pageSize' => $pagination,
            ),
        ));
        $this->render('Allgrid', array('filePartition' => $filePartition, "dataProvider" => $dataProvider), false, true);
    }

    /**
     * @Pop up Form View
     */
    public function actionFileassignment($id) {
        $model = new JobAllocation();
        $flag = false;
        $model->scenario = 'allocate';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-partition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['JobAllocation'])) {
            $model->attributes = $_POST['JobAllocation'];
            //Indexer
            $fileExplode = explode(',', $id);
            foreach ($fileExplode as $fileId) {
                $model->ja_file_id = $fileId;
                $model->ja_allocated_by = Yii::app()->session['user_id'];
                $model->ja_reviewer_allocated_time = date('Y-m-d H:i:s');
                //Indexer
                $model->isNewRecord = true;
                $model->ja_job_id = NULL;
                $model->ja_reviewer_id = ($_POST['fi_prep'] == 0) ? $model->indexer_id : 0;
                $model->ja_status = ($_POST['fi_prep'] == 0) ? "IA" : "QC";
                $model->ja_skip_qc = isset($_POST['prepSkip']) ? $_POST['prepSkip'] : 0;
                $flag = $model->save(false);
                $prepid = Yii::app()->db->getLastInsertID();

                //Splitter
                $model->isNewRecord = true;
                $model->ja_job_id = NULL;
                $model->ja_reviewer_id = $model->splitter_id;
                $model->ja_status = "SA";
                $model->ja_skip_qc = isset($_POST['splitSkip']) ? $_POST['splitSkip'] : 0;
                $flag = $model->save(false);
                $splitid = Yii::app()->db->getLastInsertID();

                $fileModel = FileInfo::model()->findByPk($fileId);
                if ($_POST['fi_prep'] == 1) {
                    //$filepath = Yii::app()->basePath . "/../" . $fileModel->fi_file_ori_location;
                    //$pdftext = file_get_contents($filepath);
                    //$pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);
                    $pagenum = $fileModel->fi_total_pages;
                    $rangearr = range(1, $pagenum);
                    $md_partn = implode(",", $rangearr);

                    $jobsplitmodel = JobAllocation::model()->findByPk($splitid);

                    $medmodel = new FilePartition();
                    $medmodel->fp_file_id = $fileId;
                    $medmodel->fp_job_id = $prepid;
                    $medmodel->fp_category = "M";
                    $medmodel->fp_page_nums = $md_partn;
                    $medmodel->fp_status = "I";
                    $medmodel->save(false);
                    $jobsplitmodel->ja_partition_id = Yii::app()->db->getLastInsertID();

                    $nonmedmodel = new FilePartition();
                    $nonmedmodel->fp_file_id = $fileId;
                    $nonmedmodel->fp_job_id = $prepid;
                    $nonmedmodel->fp_category = "N";
                    $nonmedmodel->fp_page_nums = "";
                    $nonmedmodel->fp_status = "I";
                    $nonmedmodel->save(false);
                    $jobsplitmodel->ja_npartition_id = Yii::app()->db->getLastInsertID();

                    $jobsplitmodel->save(false);
                }
                $fileModel->fi_prep = isset($_POST['fi_prep']) ? $_POST['fi_prep'] : 0;
                $fileModel->fi_editorskipqc = isset($_POST['editorSkip']) ? $_POST['editorSkip'] : 0;
                $flag = $fileModel->save(false);
            }
            if ($flag) {
                $description = "File has been completed";
                Yii::app()->Audit->writeAuditLog("Create", "File", $_GET['id'], $description);
                $msg['msg'] = 'File  Assigned successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
        }
        $this->renderPartial('fileassignment', array('model' => $model), false, true);
    }

    public function actionAdminassignment($id) {
        $model = new JobAllocation();
        $flag = false;
        $model->scenario = 'allocate';
        if (isset($id) && $id != '') {
            //$model->attributes = $_POST['JobAllocation'];
            //Indexer
            $fileExplode = explode(',', $id);
            foreach ($fileExplode as $fileId) {
                $model->ja_file_id = $fileId;
                $model->ja_allocated_by = Yii::app()->session['user_id'];
                $model->ja_reviewer_allocated_time = date('Y-m-d H:i:s');
                //Indexer
                $model->isNewRecord = true;
                $model->ja_job_id = NULL;
                $model->ja_reviewer_id = ($_GET['fi_prep'] == 0) ? Yii::app()->session['user_id'] : 0;
                $model->ja_status = ($_GET['fi_prep'] == 0) ? "IA" : "QC";
                $model->ja_skip_qc = isset($_POST['prepSkip']) ? $_POST['prepSkip'] : 0;
                $flag = $model->save(false);
                $prepid = Yii::app()->db->getLastInsertID();

                //Splitter
                $model->isNewRecord = true;
                $model->ja_job_id = NULL;
                $model->ja_reviewer_id = Yii::app()->session['user_id'];
                $model->ja_status = "SA";
                $model->ja_skip_qc = isset($_POST['splitSkip']) ? $_POST['splitSkip'] : 0;
                $flag = $model->save(false);
                $splitid = Yii::app()->db->getLastInsertID();

                $fileModel = FileInfo::model()->findByPk($fileId);
                if ($_GET['fi_prep'] == 1) {
                    //$filepath = Yii::app()->basePath . "/../" . $fileModel->fi_file_ori_location;
                    //$pdftext = file_get_contents($filepath);
                    //$pagenum = preg_match_all("/\/Page\W/", $pdftext, $dummy);
                    $pagenum = $fileModel->fi_total_pages;
                    $rangearr = range(1, $pagenum);
                    $md_partn = implode(",", $rangearr);

                    $jobsplitmodel = JobAllocation::model()->findByPk($splitid);

                    $medmodel = new FilePartition();
                    $medmodel->fp_file_id = $fileId;
                    $medmodel->fp_job_id = $prepid;
                    $medmodel->fp_category = "M";
                    $medmodel->fp_page_nums = $md_partn;
                    $medmodel->fp_status = "I";
                    $medmodel->save(false);
                    $jobsplitmodel->ja_partition_id = Yii::app()->db->getLastInsertID();

                    $nonmedmodel = new FilePartition();
                    $nonmedmodel->fp_file_id = $fileId;
                    $nonmedmodel->fp_job_id = $prepid;
                    $nonmedmodel->fp_category = "N";
                    $nonmedmodel->fp_page_nums = "";
                    $nonmedmodel->fp_status = "I";
                    $nonmedmodel->save(false);
                    $jobsplitmodel->ja_npartition_id = Yii::app()->db->getLastInsertID();

                    $jobsplitmodel->save(false);
                }

                $fileModel->fi_prep = isset($_GET['fi_prep']) ? $_GET['fi_prep'] : 0;
                $fileModel->fi_editorskipqc = isset($_POST['editorSkip']) ? $_POST['editorSkip'] : 0;
                $flag = $fileModel->save(false);
            }
            if ($flag) {
                $description = "File has been completed";
                Yii::app()->Audit->writeAuditLog("Create", "File", $_GET['id'], $description);
                $msg['msg'] = 'File  Assigned to Admin successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
        }
        // $this->renderPartial('fileassignment', array('model' => $model), false, true);
    }

    /**
     * @Autocomplete Search
     */
    public function actionAutocompleteTest() {
        $res = array();
        if (isset($_GET['term'])) {
            $data = Project::model()->findAll(array('condition' => "p_flag ='A' and p_name LIKE '%$_GET[term]%' order by p_name asc"));
            $res = CHtml::listData($data, 'p_pjt_id', 'p_name');
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }

    /**
     * @File Download
     */
    private function actionPDFoutput($filename) {
        require_once 'fpdf/fpdf.php';
//        require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf = new pdftemplate('P', 'mm', 'A4');
//        $pdf1 = new PDFMerger();
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

    private function actionXmloutput($filename, $pid) {
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
            ///$xml->asXML();
            if (!is_dir(Yii::app()->basePath . "/../xmlDocument/")) {
                mkdir(Yii::app()->basePath . "/../xmlDocument/", 0777, true);
            }
            $file = 'xmlDocument/config.xml';
            $xml->asXML($file);
            if (file_exists($file)) {
                header("Content-type: text/xml");
                header('Content-Disposition: attachment; filename="text.xml"');
                $xml_file = file_get_contents($file);
                echo $xml_file;
            }
            //$this->renderPartial('xmlTemplate', array('data' => $fullData, 'pat_name' => $pat_name, 'doc_name' => $doc_name));
        }
    }

    public function actionDownload($p_id, $f_id) {

        $fileInfo = FileInfo::model()->findByPk($f_id);
        $tmp_id = !empty($fileInfo->fi_template_id) ? $fileInfo->fi_template_id : $fileInfo->ProjectMaster->template_id;
        $makeModels = Templates::model()->find(array("select" => "t_name", "condition" => "id=" . $tmp_id));
        //$template=($makeModels->t_name=='SWORDDOC' || 'JWORDDOC')? 'WORDDOC':$makeModels->t_name;
        if ($makeModels->t_name == 'SWORDDOC' || $makeModels->t_name == 'JWORDDOC') {
            $template = "WORDDOC";
            if ($makeModels->t_name == 'SWORDDOC') {
                $type = 's';
            } else {
                $type = 'j';
            }
        } else {
            $template = $makeModels->t_name;
            $type = '';
        }
        //$template=$makeModels->t_name;
        //print_r($makeModels->t_name);die;
        if (!empty($p_id) && !empty($f_id)) {
            $project = $p_id . "_breakfile";
            $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $f_id . ".txt";
            Yii::app()->downloadtemplates->$template($filename, $type, $p_id, $f_id);
            /* if ($f_format == "XML") {
              switch ($template) {
              case "NXML":
              Yii::app()->downloadtemplates->$template($filename, $p_id,$f_id);
              break;
              }
              //$this->actionXmloutput($filename, $p_id);
              } else if ($f_format == "PDF") {
              switch ($template) {
              case "PDF":
              Yii::app()->downloadtemplates->$template($filename, $p_id,$f_id);
              break;
              }
              //$this->actionPDFoutput($filename, $p_id);
              } else if ($f_format == "DOCX") {
              $project = Project::model()->findByPk($p_id);
              $project_name = $project ? $project->p_name : '';
              switch ($template) {
              case "JWORDDOC":
              Yii::app()->downloadtemplates->WORDDOC($filename, 'j', $p_id);
              break;
              case "SWORDDOC":
              Yii::app()->downloadtemplates->WORDDOC($filename, 's', $p_id);
              break;
              case "WORDCOMBINE":
              Yii::app()->downloadtemplates->$template($filename, $p_id);
              break;
              case "WORDPARAGRAPH":
              Yii::app()->downloadtemplates->$template($filename, $p_id);
              break;
              case "DRG":
              Yii::app()->downloadtemplates->$template($filename, $p_id, $f_id);
              break;
              case "PSI":
              Yii::app()->downloadtemplates->$template($filename, $p_id, $f_id);
              break;
              case "SOCAL":
              Yii::app()->downloadtemplates->$template($filename, $p_id);
              break;
              case "WORDFORMAT":
              //echo "nkk";die;
              Yii::app()->downloadtemplates->$template($filename, $f_id, $p_id);
              break;
              case "CONVERTWORD":
              Yii::app()->downloadtemplates->$template($filename, $p_id, $f_id);
              break;
              default:
              }
              //echo "<span class='uk-badge status-badge'>New File</span>";
              //    if ($project_name == 'SLI') {
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
              } elseif ($project_name == 'SOCAL') {
              $this->actionSocal($filename, $p_id);
              } elseif ($project_name == 'MIKE') {
              $this->actionSocal($filename, $p_id);
              } elseif ($project_name == 'BIS-INS') {
              $this->actionWordformat($filename, $f_id, $p_id);
              }//
              }
              else if($f_format == "XLSX")
              {
              $project = Project::model()->findByPk($p_id);
              $project_name = $project ? $project->p_name : '';
              if ($project_name == 'MV' ) {
              $this->actionExport($f_id);
              }
              else
              {
              $this->actionNewexport($f_id);
              }
              } */
        }
    }

    public function actionOpenfile() {
        $file = Yii::app()->basePath . "/../" . $_REQUEST["filename"];
        $name = $_REQUEST["filename"];
        header("Cache-Control: no-store");
        header("Expires: 0");
        header("Content-Type: application/pdf");
        header("Content-disposition: attachment; filename=\"" . basename($name) . "\"");
        readfile($file);
    }

    //Table Word Formate
    public function actionWorddoc($filename, $type, $p_id) {
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
                $doc = $this->renderPartial('jvcword', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages, 'pid' => $p_id), true);
            } else {
                $doc = $this->renderPartial('worddoc', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages, 'pid' => $p_id), true);
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

    //Table Word JVC
    public function actionJvc($filename) {
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
            $doc = $this->renderPartial('jvcword', array('filename' => $filename, 'dosSummary' => $dosSummary, 'pages' => $pages), true);
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
            //$this->renderPartial('worddoc',array('filename'=>$filename));
        }
    }

    //Table Paragarph table format
    public function actionWordparagraph($filename, $pid) {
        if (file_exists($filename)) {
            $doc = $this->renderPartial('wordparagraph', array('filename' => $filename, 'pid' => $pid), true);
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

    //wordDoc combine paragraph and rtable format
    public function actionWordcombine($filename, $pid) {
        if (file_exists($filename)) {
            $doc = $this->renderPartial('wordcombine', array('filename' => $filename, 'pid' => $pid), true);
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

    public function actionMikeoutput($filename, $mainFile) {

        require_once 'fpdf/PDFMerger-master/pdfmerger.php';
        $pdf1 = new PDFMerger();

        $mergePages = $this->actionGetpdfpages(array("Dr. Notes"), $filename);
        $docnotes = isset($mergePages['Dr. Notes']) ? $mergePages['Dr. Notes'] : "";
        $pdf1->addPDF('samplepdfs/final.pdf', 'all');
        if (!empty($docnotes)) {
            $pdf1->addPDF($mainFile, $docnotes);
        }

//                ->merge('file', 'samplepdfs/TEST2.pdf');
        $pdf1->merge('/samplepdfs/TEST2.pdf');
//        $pdf1->merge('download', 'samplepdfs/test.pdf');
    }

    public function actionConvertword($filename, $p_id, $f_id) {
        $model = FileInfo::model()->findByPk($f_id);
        $this->renderPartial('printlayout', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $p_id), true);
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

    public function actionDrg($filename, $pid, $f_id) {
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            $doc = $this->renderPartial('drg', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $pid), true);
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

    public function actionPsi($filename, $pid, $f_id) {
        if (file_exists($filename)) {
            $model = FileInfo::model()->findByPk($f_id);
            $doc = $this->renderPartial('psi', array('filename' => $filename, 'nameoffile' => $model->fi_file_name, 'pid' => $pid), true);
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

    public function actionSocal($filename, $pid) {
        if (file_exists($filename)) {
            $doc = $this->renderPartial('socal', array('filename' => $filename, 'pid' => $pid), true);
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

    private function actionGetpdfpages($catNameArray = "", $filename = "") {
//        $project = "1_breakfile";
//        $f_id = 3;
//        $filename = "filepartition\\" . $project . '\\' . $f_id . " . txt";
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

    public function actionFeedback() {
        $id = $_POST['id'];
        $out = '<h3 style=text-align:center>FeedBack</h3><hr>';
        $jobAllocation = JobAllocation::model()->findAll(array('condition' => "ja_file_id=$id and (ja_status!='IQ' or ja_status!='EQ' or ja_status!='SQ') and ja_flag='A'"));
        //print_r($jobAllocation);die;
        if ($jobAllocation) {
            $stat = true;
            foreach ($jobAllocation as $job) {
                if ($job->ja_qc_feedback) {
                    $stat = false;
                    $convertValue = str_replace("'", "", $this->convert_smart_quotes($job->ja_qc_feedback));
                    $convertValue = str_replace('"', '', $convertValue);
                    if ($job->ja_partition_id == '0' && ($job->ja_status == 'QC' || $job->ja_status == 'IC')) {
                        $out .= '<h3>Prepping:</h3>';
                        $out .= '<span style=font-size:16px>' . $convertValue . '</span><span class="md-btn-flat-primary">-' . $job->UserDetailsqc->ud_username . '</span>';
                    } else if ($job->ja_status != '') {
                        $out .= '<h3>DateCoding:</h3>';
                        $out .= '<span style=font-size:16px>' . $convertValue . '</span><span class="md-btn-flat-primary">-' . $job->UserDetailsqc->ud_username . '</span>';
                    } else {
                        $out .= '<h3>Editor:</h3>';
                        $out .= '<span style=font-size:16px>' . $convertValue . '</span><span class="md-btn-flat-primary">-' . $job->UserDetailsqc->ud_username . '</span>';
                    }
                }
            }
            if ($stat) {
                $out .= '<h3 style=text-align:center>No Result Found</h3>';
            }
        } else {
            $out .= '<h3 style=text-align:center>No Result Found</h3>';
        }
        echo $out;
        Yii::app()->end();
    }

    //
    private function convert_smart_quotes($string) {
        $search = array(chr(145),
            chr(146),
            chr(147),
            chr(148),
            chr(151));

        $replace = array("'",
            "'",
            '"',
            '"',
            '-');

        return trim(str_replace($search, $replace, $string));
    }

    public function actionWordformat($filename, $f_id, $pid) {
        if (file_exists($filename)) {
            $srcName = FileInfo::model()->findByPk($f_id);
            $srcName = explode(".", $srcName->fi_file_name);
            $srcName = $srcName[0];
            $doc = $this->renderPartial('wordformat', array('filename' => $filename, 'f_id' => $f_id, 'pid' => $pid), true);
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
            //$this->renderPartial('worddoc',array('filename'=>$filename));
        }
    }

    public static function actionGetsplitpages($pageno = 2, $fileId = 1) {
        if ($pageno != "") {
            $model = FileInfo::model()->findByPk($fileId);
            $pageArr = json_decode($model->fi_split_files, true);
            $pages = 0;
            foreach ($pageArr as $key => $val) {
                $pages = $val + $pages;
                if ($pageno <= $pages) {
                    return $key;
                }
            }
        }
    }

    /**
     * @Get multi file name and page number
     */
    public static function actionMultifile($pageno, $fileId) {
        $returnArray = array();
        if ($pageno != "") {
            $model = FileInfo::model()->findByPk($fileId);
            $pageArr = json_decode($model->fi_split_files, true);
            $startNumber = 1;
            $endNumber = 0;
            foreach ($pageArr as $key => $val) {
                $pageNumbers = array();
                $endNumber += $val;
                foreach ($pageno as $pageVal) {
                    if ($startNumber <= $pageVal && $endNumber >= $pageVal) {
                        $pageNumbers[] = $pageVal;
                    }
                }
                $startNumber+=$val;
                if ($pageNumbers) {
                    $returnArray[$key] = implode(',', $pageNumbers);
                }
            }
        }
        return $returnArray;
    }

    public function actionDownloadtotal() {
        if (isset($_GET['id'])) {
            $fileIds = explode(",", $_GET['id']);
            foreach ($fileIds as $key => $fileId) {
                $file = FileInfo::model()->findByPk($fileId);
                $format = Project::model()->findByPk($file->fi_pjt_id);
                $project = $file->fi_pjt_id . "_breakfile";
                $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $fileId . ".txt";
                if (isset($filename)) {

                    $doc = $this->renderPartial('wordformat', array('filename' => $filename, 'f_id' => $fileId, 'pid' => $file->fi_pjt_id), true);
                    $name = $fileId . time() . 'wordformat.doc';
                    $fileLocation = Yii::app()->basePath . "/../zip/" . $name;
                    $dirname = "tempzip";
                    if (!is_dir(Yii::app()->basePath . "/../zip/" . $dirname)) {
                        mkdir(Yii::app()->basePath . "/../zip/" . $dirname, 0777, true);
                    }
                    $fileLocation = Yii::app()->basePath . "/../zip/" . $dirname . "/" . $name;
                    $file = fopen($fileLocation, "w");
                    $content = $doc;
                    fwrite($file, $content);
                    fclose($file);
                }
            }

            $archive_file_name = 'Kpws-archive.zip';
            $file_path = Yii::app()->basePath . "/../zip/tempzip/";
            $this->zipFilesAndDownload($archive_file_name, $file_path);
        }
    }

    public function zipFilesAndDownload($archive_file_name, $file_path) {
        $zip = new ZipArchive();
        //create the file and throw the error if unsuccessful
        if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
            exit("cannot open <$archive_file_name>\n");
        }
        $files = scandir($file_path);
        unset($files[0], $files[1]);
        $file_names = array();
        foreach ($files as $file) {
            $file_names[] = $file;
        }
        //add each files of $file_name array to archive
        foreach ($file_names as $files) {
            $zip->addFile($file_path . $files, $files);
        }
        $zip->close();
        $zipped_size = filesize($archive_file_name);
        header("Content-Description: File Transfer");
        header("Content-type: application/zip");
        header("Content-Type: application/force-download"); // some browsers need this
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header("Content-Length:" . " $zipped_size");
        ob_clean();
        flush();
        readfile("$archive_file_name");
        $fileToDelete = glob(Yii::app()->basePath . "/../zip/tempzip/*");
        foreach ($fileToDelete as $file) {
            if (is_file($file))
                unlink($file);
        }

        unlink("$archive_file_name"); // Now delete the temp file (some servers need this option)
        exit;
    }

    public function actionCommondownload() {
        $sql = 'SELECT DISTINCT job_allocation_ja.ja_file_id,file_info_fi.fi_pjt_id,project_p.p_name,project_p.p_op_format
                 FROM `job_allocation_ja` inner join file_info_fi
                 inner join project_p
                 on job_allocation_ja.ja_file_id=file_info_fi.fi_file_id and file_info_fi.fi_pjt_id=project_p.p_pjt_id and (project_p.p_op_format="XLS" or project_p.p_op_format="XML" or project_p.p_op_format="DOCX" or project_p.p_op_format="PDF") and project_p.p_flag="A"
                 where job_allocation_ja.ja_status="QC"';
        $compfile = Yii::app()->db->createCommand($sql)->queryAll();
        $comp = array();
        $i = 0;
        foreach ($compfile as $key => $val) {
            $comp[$i]['ja_file_id'] = $val['ja_file_id'];
            $comp[$i]['p_op_format'] = $val['p_op_format'];
            $comp[$i]['fi_pjt_id'] = $val['fi_pjt_id'];
            $this->filemove($comp[$i]['ja_file_id'], $comp[$i]['p_op_format'], $comp[$i]['fi_pjt_id']);
            $i++;
        }
        $this->redirect(array("fileinfo/allgrid?txt=File downloaded successfully"));
    }

    public function filemove($file, $opformat, $p_id) {
        $project = $p_id . "_breakfile";
        if ($opformat == 'DOCX') {
            $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file . ".txt";
            if (file_exists($filename)) {
                $doc = $this->renderPartial('wordformat', array('filename' => $filename, 'f_id' => $file, 'pid' => $p_id), true);
                $name = $file . '_' . time() . 'wordformat.doc';
                $dir_to_save = Yii::app()->basePath . "/../completefiles/";
                file_put_contents($dir_to_save . $name, $doc);
                return true;
            }
        } else if ($opformat == 'XLS') {
            $fileInfo = FileInfo::model()->findByPk($file);
            $fileNam = $fileInfo ? $fileInfo->fi_file_name : '';
            $project_id = isset($fileInfo) ? $fileInfo->fi_pjt_id : '';
            $prject_name = Project::model()->findByPk($project_id);
            $filePartition = JobAllocation::model()->find(array('condition' => "ja_file_id=$file  and ja_status='QC'"));
            $rvrname = $filePartition->Rvrname->ud_name;
            $dir = "filepartition/" . $project_id . "_breakfile";
            $p_name = $prject_name->p_name;
            if ($prject_name->p_name === 'BIS XLSX' || $prject_name->p_name != 'BIS XLSX') {


                $heading = array('Page Nos', 'DOS [MM/DD/YY]', 'Provider', 'Title [Type of Service]', 'Category',
                    'Summary', 'LastName', 'ReviewerName', 'MPN Reviewer Name', 'FileNameOrder');

                $fields = array('page_no', 'fl_dos', 'fl_provider', 'type_of_service', 'fl_category', 'fi_summary', 'l_name', 'rvr_nmae', 'mpn_rvr_name', 'fi_name');
                $files = array();
                $Sfiles = array();
                $subpages = '';

                if (is_dir($dir)) {


                    $file_dir = $dir . "/" . $file . ".txt";
                    if (file_exists($file_dir)) {

                        $i = 0;
                        $k = 0;
                        $multiPages = array();
                        foreach (file($file_dir) as $line) {
                            $exp_file = explode('|', trim($line));
                            $cat = Category::model()->findByPk($exp_file[3]);
                            $catname = $cat ? $cat->ct_cat_name : '';

                            if ($exp_file[1] != '') {
                                //print_r("ntempty");
                                $files[$i]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
                                if (!empty($exp_file[0]) && $fileInfo->fi_split_files != "") {
                                    $tempSubpages = explode(",", $exp_file[0]);
                                    $mergefiles = FileinfoController::actionMultifile($tempSubpages, $fileInfo->fi_file_id);
                                }
                                $files[$i]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
                                $files[$i]['type_of_service'] = '';
                                $files[$i]['fi_summary'] = '';
                                $files[$i]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";
                                ;
                                $files[$i]['rvr_nmae'] = $rvrname;
                                $files[$i]['mpn_rvr_name'] = '';
                                $files[$i]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                                $files[$i]['fl_category'] = $catname;
                                $files[$i]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                                $files[$i]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
                                $i++;
                            } else {
                                //print_r("else");
                                $Sfiles[$k]['page_no'] = isset($exp_file[0]) ? str_replace(",", " ,", $exp_file[0]) : "";
                                if (!empty($exp_file[0]) && $fileInfo->fi_split_files != "") {
                                    $tempSubpages = explode(",", $exp_file[0]);
                                    $mergefiles = FileinfoController::actionMultifile($tempSubpages, $fileInfo->fi_file_id);
                                }
                                $Sfiles[$k]['fl_dos'] = isset($exp_file[1]) ? $exp_file[1] : "";
                                $Sfiles[$k]['type_of_service'] = '';
                                $Sfiles[$k]['fi_summary'] = '';
                                $Sfiles[$k]['l_name'] = isset($exp_file[2]) ? $exp_file[2] : "";
                                ;
                                $Sfiles[$k]['rvr_nmae'] = $rvrname;
                                $Sfiles[$k]['mpn_rvr_name'] = '';
                                $Sfiles[$k]['fi_name'] = !empty($mergefiles) ? implode(' / ', array_keys($mergefiles)) : $fileNam;
                                $Sfiles[$k]['fl_category'] = $catname;
                                $Sfiles[$k]['fl_provider'] = isset($exp_file[4]) ? str_replace("^", " ,", $exp_file[4]) : "";
                                $Sfiles[$k]['fl_summary'] = isset($exp_file[15]) ? $exp_file[15] : "";
                                $k++;
                            }
                        }
                        if (!function_exists('date_sort1')) {

                            function date_sort1($a, $b) {
                                $t1 = strtotime($a['fl_dos']);
                                $t2 = strtotime($b['fl_dos']);


                                return $t2 - $t1;
                            }

                        }

                        usort($files, "date_sort1");
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
                    $file_dir = $dir . "/" . $file . ".txt";
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

            $returnvl = XlsExporter::ftpXls($file, $files, 'List of partitions', $heading, $fields, 'Partitions', $p_name);
            $new_name = $file . '_' . time() . '.xls';
            $savdir = Yii::app()->basePath . "/../completefiles/";
            file_put_contents($savdir . $new_name, $returnvl);
        } else if ($opformat == 'XML') {
            $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file . ".txt";
            if (isset($filename)) {
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
                        $dos = !empty($explodeLine[1]) ? FileInfo::dateformat($explodeLine[1], $p_id) : 'Undated';
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
                $dir_to_save = Yii::app()->basePath . "/../completefiles/";
                $filename = $dir_to_save . $file . '_' . time() . ".xml";
                $xml->asXML($filename);
                return true;
            }
        } else if ($opformat == 'PDF') {
            $project = $p_id . "_breakfile";
            $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file . ".txt";

            require_once 'fpdf/fpdf.php';
            //  require_once 'fpdf/PDFMerger-master/pdfmerger.php';
            $pdf = new pdftemplate('P', 'mm', 'A4');
            //  $pdf1 = new PDFMerger();
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
                $tempfilename = 'completefiles/' . $file . '_' . time() . '.pdf';
                $pdf->Output($tempfilename, 'F');

                //$mainFile = FileInfo::model()->findByPk($_REQUEST['f_id']);
                ///$this->actionMikeoutput($filename, $mainFile->fi_file_ori_location);
            }
        }
    }

    public function actionclientsidefile() {
        if (isset($_POST['fileid']) && isset($_POST['pid'])) {
            $prj_details = Project::model()->findByPk($_POST['pid']);
            if (!is_dir(Yii::app()->basePath . "/../clientdownload/" . $prj_details->p_client_id)) {
                mkdir(Yii::app()->basePath . "/../clientdownload/" . $prj_details->p_client_id, 0777, true);
            }
            $target_dir = Yii::app()->basePath . "/../clientdownload/" . $prj_details->p_client_id . "/";
            $imageFileType = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            ;
            $newfilename = $_POST['fileid'] . "." . $imageFileType;
            $target_file = $target_dir . $newfilename;
            if (file_exists($target_file)) {
                $one_exten = "";
                $exten = "";
                $list_docs = array();
                foreach (glob($target_dir . '/*.*') as $flist) {
                    $doc_name = substr($flist, strrpos($flist, '/') + 1);
                    if ($this->startsWith($doc_name, $_POST['fileid'])) {
                        $list_docs[] = $target_dir . $doc_name;
                    }
                    if ($this->startsWith($doc_name, $_POST['fileid'] . "Rev_1")) {
                        $one_exten = pathinfo($doc_name, PATHINFO_EXTENSION);
                    }
                    if ($this->startsWith($doc_name, $_POST['fileid'] . "Rev_2")) {
                        $two_exten = pathinfo($doc_name, PATHINFO_EXTENSION);
                    }
                }
                $exten = pathinfo($target_file, PATHINFO_EXTENSION);
                if (count($list_docs) < 3) {
                    rename($target_file, $target_dir . $_POST['fileid'] . "Rev_" . count($list_docs) . "." . $exten);
                } else {
                    unlink($target_dir . $_POST['fileid'] . "Rev_1." . $one_exten);
                    rename($target_dir . $_POST['fileid'] . "Rev_2." . $two_exten, $target_dir . $_POST['fileid'] . "Rev_1." . $two_exten);
                    rename($target_file, $target_dir . $_POST['fileid'] . "Rev_2." . $exten);
                }

                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
                $msg['msg'] = 'File  uploaded successfuly';
                $msg['status'] = 'S';
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
                $msg['msg'] = 'File  uploaded successfuly';
                $msg['status'] = 'S';
            }
        }
        echo json_encode($msg, true);
        die();
    }

    function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @File lock and unlock
     */
    public function actionFilelock() {
        $msg = '';
        if (isset($_REQUEST['file_id'])) {
            $fileInfo = FileInfo::model()->findByPk($_REQUEST['file_id']);
            $cur_state = FileInfo::currentstatus($_REQUEST['file_id']);
            if ($fileInfo->fi_admin_lock == "O") {
                if ($cur_state == "IC") {
                    $job_ic = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $_REQUEST['file_id'] . " and ja_status = 'IC' and ja_partition_id = 0 and ja_flag = 'A'"));
                    $job_ic->ja_status = "IQP";
                    $job_ic->ja_qc_id = Yii::app()->session['user_id'];
                    $job_ic->save(false);
                } else if ($cur_state == "SC") {
                    $job_ic = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $_REQUEST['file_id'] . " and ja_status = 'SC' and ja_partition_id <> 0 and ja_flag = 'A'"));
                    $job_ic->ja_status = "SQP";
                    $job_ic->ja_qc_id = Yii::app()->session['user_id'];
                    $job_ic->save(false);
                }
            } else if ($fileInfo->fi_admin_lock == "QL") {
                $msg['status'] = 'S';
                $msg['msg'] = 'Cannot lock file,Qc already locked file!!!!';
                echo json_encode($msg, true);
                Yii::app()->end();
            } else if ($fileInfo->fi_admin_lock == "RL" && (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "C" )) {
                $msg['msg'] = 'Cannot lock file,Reviewer already locked file!!!!';
                echo json_encode($msg, true);
                Yii::app()->end();
            } else if ($fileInfo->fi_admin_lock == "L" && ( Yii::app()->session['user_type'] == "R" || Yii::app()->session['user_type'] == "QC" )) {
                $msg['msg'] = 'Cannot lock file,Admin already locked file!!!!';
                $msg['status'] = 'C';
                echo json_encode($msg, true);
                Yii::app()->end();
            } else {
                if ($cur_state == "IQP") {
                    $job_ic = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $_REQUEST['file_id'] . " and ja_status = 'IQP' and ja_partition_id = 0 and ja_flag = 'A'"));
                    $job_ic->ja_status = "IC";
                    $job_ic->ja_qc_id = 0;
                    $job_ic->save(false);
                } else if ($cur_state == "SQP") {
                    $job_ic = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $_REQUEST['file_id'] . " and ja_status = 'SQP' and ja_partition_id <> 0 and ja_flag = 'A'"));
                    $job_ic->ja_status = "SC";
                    $job_ic->ja_qc_id = 0;
                    $job_ic->save(false);
                }
            }
            if ($fileInfo && ( Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL" )) {
                $fileInfo->fi_admin_lock = ($fileInfo->fi_admin_lock == 'O') ? 'L' : (($fileInfo->fi_admin_lock == 'L') ? 'O' : 'L');
                if ($fileInfo->save()) {
                    if ($fileInfo->fi_admin_lock == 'O') {
                        $msg['msg'] = 'File has been Unlocked';
                    } else {
                        $msg['msg'] = 'File has been locked';
                    }
                    $msg['status'] = 'S';
                }
            } else {
                $msg['msg'] = 'Redirect';
                $msg['status'] = 'N';
            }
        } else {
            $msg['msg'] = 'Something Goes Wrong';
            $msg['status'] = 'N';
        }
        echo json_encode($msg, true);
        Yii::app()->end();
    }

    public function actionTemplatechange($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'templatechange';
        if (isset($_POST['FileInfo'])) {

            $model->fi_template_id = $_POST['FileInfo']['fi_template_id'];
            $model->update('fi_template_id');

            $msg['msg'] = 'Template Changed successfuly';
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
        $this->renderPartial('templatechange', array(
            'model' => $model
                ), false, true);
    }

}
