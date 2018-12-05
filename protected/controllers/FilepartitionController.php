<?php

class FilepartitionController extends RController {

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
		if($action->id == "filesplit"){
			if(isset($_GET['id']) && !empty($_GET['id'])){
				$partitioninfo = FilePartition::model()->findByPk($_GET['id']);
				$partfile = $partitioninfo->fp_file_id;
				$info=FileInfo::model()->findByPk($partfile);
				if(Yii::app()->session['user_type']=="R"){
					if($info->fi_admin_lock=="QL" || $info->fi_admin_lock=="L"){
						$this->redirect(array("filepartition/splitalloc"));
					}
				}
				else if(Yii::app()->session['user_type']=="QC"){
					if($info->fi_admin_lock=="RL" || $info->fi_admin_lock=="L"){
						$this->redirect(array("filepartition/splitalloc"));
					}
				}
				else if(Yii::app()->session['user_type']=="A"){
					if($info->fi_admin_lock=="RL" || $info->fi_admin_lock=="QL"){
						$this->redirect(array("fileinfo/allgrid"));
					}
				}
			}
			else{
				if(Yii::app()->session['user_type']=="A"){
					$this->redirect(array("fileinfo/allgrid"));
				}
				else if(Yii::app()->session['user_type']=="R" || Yii::app()->session['user_type']=="QC"){
					$this->redirect(array("filepartition/splitalloc"));
				}
			}
		}
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
        $model = new FilePartition;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['FilePartition'])) {
            $model->attributes = $_POST['FilePartition'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->fp_part_id));
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

        if (isset($_POST['FilePartition'])) {
            $model->attributes = $_POST['FilePartition'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->fp_part_id));
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
        $dataProvider = new CActiveDataProvider('FilePartition');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new FilePartition('editorsearch');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FilePartition']))
            $model->attributes = $_GET['FilePartition'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionSplitalloc() {
        if (!isset($_GET['fi_st'])) {
            if (Yii::app()->session['user_type'] == "R") {
                $_GET['fi_st'] = 'SA';
            } else if (Yii::app()->session['user_type'] == "A") {
                $_GET['fi_st'] = 'I';
            } else if (Yii::app()->session['user_type'] == "QC") {
                $_GET['fi_st'] = 'SC';
            }
        }
        $model = new FilePartition('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['FilePartition']))
            $model->attributes = $_GET['FilePartition'];

        $this->render('splitalloc', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return FilePartition the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = FilePartition::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param FilePartition $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-partition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @After file Splitting Proccess view
     */
    public function actionReviewprocess() {
        $model = new ReviewProcess();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'review-process-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ReviewProcess'])) {
            
        }
        $this->render('reviewprocess', array('model' => $model));
    }

    /**
     * @Pop Up Spilted Page View
     */
    public function actionSplitview() {
        if (isset($_REQUEST['id'])) {
            $model = FilePartition::model()->findByPk($_REQUEST['id']);
            $this->renderPartial('splitview', array('model' => $model), false, true);
        }
    }

    /**
     * @File partation breaking a pege
     */
    public function actionFilesplit() {
        //$model = new FilePartition();
        //$model->scenario = 'filesplit';
        $model = new DateCoding();
        $restore_partition = array();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-partition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
        if (isset($_POST['DateCoding'])) {
            $file_status = $this->saveDirectory($_POST['DateCoding']);
            $description = $file_status[0];
            $msg['msg'] = $file_status[0];
            $msg['pjson'] = $file_status[1];
            if (empty($file_status[2])) {
                $msg['status'] = 'S';
            } else {
                $msg['status'] = 'U';
            }
            $msg['append'] = Yii::app()->filerecord->getSavedRecord($_POST['DateCoding']['project'], $_POST['DateCoding']['file'], $_POST['DateCoding']['type']);
            echo json_encode($msg, true);
            die();
        }
        if (Yii::app()->session['user_type'] == "R" || Yii::app()->session['user_type'] == "QC") {
            $restore_array = array();
            $restore_json = "";
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $restore_partition = FilePartition::model()->findByPk($_GET['id']);
            }
            if (!empty($restore_partition)) {
                $restore_file_id = $restore_partition->fp_file_id;
                $restore_file_info = FileInfo::model()->findByPk($restore_file_id);
                $restore_project_id = $restore_file_info->fi_pjt_id;
                $restore_project = $restore_project_id . "_restore";
                if (!is_dir(Yii::app()->basePath . "/../file_restore/splitting" . $restore_project)) {
                    $restore_filename = Yii::app()->basePath . "/../file_restore/splitting/" . $restore_project . '/' . $restore_file_id . ".txt";
                    if (file_exists($restore_filename)) {
                        foreach (file($restore_filename) as $restore_line) {
                            $restore_array = explode('|', trim($restore_line));
                        }
                        $restore_json = json_encode($restore_array, true);
                    }
                }
                if (Yii::app()->session['user_type'] == "R") {
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_partition_id = $_GET[id] and ja_flag ='A' and ja_status = 'SA'"));
                    if ($jobAllc && $jobAllc->ja_reviewer_accepted_time == '0000-00-00 00:00:00') {
                        $jobAllc->ja_reviewer_accepted_time = date('Y-m-d H:i:s');
                        $jobAllc->save();
                    }
                    if (isset($_GET['status']) && $jobAllc && ($jobAllc->ja_reviewer_id == Yii::app()->session['user_id']) && Yii::app()->session['user_type'] == $_GET['status']) {
                        $filemodel = FileInfo::model()->findByPk($jobAllc->ja_file_id);
                        if ($filemodel->ProjectMaster->p_key_type == 'M') {
                            $this->render('file_split', array(
                                'model' => $model,
                                'restore_json' => $restore_json,
                            ));
                        } else {
                            $nonMedPart = $jobAllc->ja_npartition_id;
							if($filemodel && $filemodel->fi_admin_lock="O")
							{
								$filemodel->fi_admin_lock="RL";
								$filemodel->update("fi_admin_lock");
							}
                            // print_r($filemodel->ProjectMaster->p_json);die;
                            $this->render('nonmed_split', array(
                                'model' => $model,
                                'restore_json' => $restore_json,
                                'nonMedPart' => $nonMedPart,
                                'pjson' => $filemodel->ProjectMaster->p_json,
                                'job_model' => $jobAllc,
                            ));
                        }
                    } else {
                        $this->redirect(array("filepartition/splitalloc"));
                    }
                } else {
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_partition_id = $_GET[id] and ja_flag ='A' and ja_status = 'SQP'"));
                    if (isset($_GET['status']) && $jobAllc && ($jobAllc->ja_qc_id == Yii::app()->session['user_id']) && Yii::app()->session['user_type'] == $_GET['status']) {
                        $filemodel = FileInfo::model()->findByPk($jobAllc->ja_file_id);
                        if ($filemodel->ProjectMaster->p_key_type == 'M') {

                            $this->render('file_split', array(
                                'model' => $model,
                                'restore_json' => $restore_json,
                            ));
                        } else {
                            $nonMedPart = $jobAllc->ja_npartition_id;
                            $this->render('nonmed_split', array(
                                'model' => $model,
                                'restore_json' => $restore_json,
                                'nonMedPart' => $nonMedPart,
                                'pjson' => $filemodel->ProjectMaster->p_json,
                                'job_model' => $jobAllc,
                            ));
                        }
                    } else {
                        $this->redirect(array("filepartition/splitalloc"));
                    }
                }
            } else {
                $this->redirect(array("filepartition/splitalloc"));
            }
        } else if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
            //$this->redirect(array("fileinfo/allgrid"));
            $restore_array = array();
            $restore_json = "";
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $restore_partition = FilePartition::model()->findByPk($_GET['id']);
                $state = FileInfo::currentstatus($restore_partition->fp_file_id);
            }
            if (!empty($restore_partition)) {
                $restore_file_id = $restore_partition->fp_file_id;
                $restore_file_info = FileInfo::model()->findByPk($restore_file_id);
                $restore_project_id = $restore_file_info->fi_pjt_id;
                $restore_project = $restore_project_id . "_restore";
                if (!is_dir(Yii::app()->basePath . "/../file_restore/splitting" . $restore_project)) {
                    $restore_filename = Yii::app()->basePath . "/../file_restore/splitting/" . $restore_project . '/' . $restore_file_id . ".txt";
                    if (file_exists($restore_filename)) {
                        foreach (file($restore_filename) as $restore_line) {
                            $restore_array = explode('|', trim($restore_line));
                        }
                        $restore_json = json_encode($restore_array, true);
                    }
                }

                if ($state == 'SA') {
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_partition_id = $_GET[id] and ja_flag ='A' and ja_status = 'SA'"));
                } else if ($state == 'SC' || $state == 'SQP') {
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_partition_id = $_GET[id] and ja_flag ='A' and (ja_status = 'SQP' || ja_status = 'SC')"));
                    $jobAllc->ja_qc_id=Yii::app()->session['user_id'];
                    $jobAllc->save(false);
                } else if ($state == 'QEC') {
                    $jobAllc = JobAllocation::model()->find(array('condition' => "ja_file_id = $restore_file_id and ja_flag ='A' and ja_status = 'QEC'"));
                    $nonMedJob = JobAllocation::model()->find(array('condition' => "ja_file_id = $restore_file_id and ja_partition_id <> '' and ja_flag ='A' and ja_status = 'QC'"));
                }
                if (isset($_GET['status']) && isset($jobAllc) && ((($state == 'SA' || $state == 'QEC') && $_GET['status'] == "R") || (($state == 'SQP') && $_GET['status'] == "QC"))) {
                    $filemodel = FileInfo::model()->findByPk($jobAllc->ja_file_id);
                    if ($state != 'QEC') {
                        $nonMedPart = $jobAllc->ja_npartition_id;
                    } else {
                        $nonMedPart = $nonMedJob->ja_npartition_id;
                    }

                    $this->render('nonmed_split', array(
                        'model' => $model,
                        'restore_json' => $restore_json,
                        'nonMedPart' => $nonMedPart,
                        'pjson' => $filemodel->ProjectMaster->p_json,
                        'job_model' => $jobAllc,
                    ));
                } else {
                    $this->redirect(array("fileinfo/allgrid"));
                }
            } else {
                $this->redirect(array("fileinfo/allgrid"));
            }
        } else {
            $this->redirect(array("filepartition/splitalloc"));
        }
    }

    /* public function actionAutosavesplit($mode) {
      $autoprovider = !empty($_POST['DateCoding']['provider_name']) ? $_POST['DateCoding']['provider_name'] : '';
      $_POST['DateCoding']['provider_name'] = str_replace(PHP_EOL, '^', $autoprovider);
      $file_id = $_POST['DateCoding']['file'];
      $file_info = FileInfo::model()->findByPk($file_id);
      $project_id = $file_info->fi_pjt_id;
      $project = $project_id . "_restore";
      $resfield = array();

      if (isset($_POST['nonmedpage']) && isset($_POST['nonmedcat'])) {
      $fields = array('pages', 'dos', 'patient_name', 'category', 'provider_name', 'gender', 'doi', 'facility', 'title');
      foreach ($_POST['DateCoding'] as $key => $value) {
      if (in_array($key, $fields)) {
      if (!empty($value)) {
      $resfield[] = $value;
      }
      }
      }
      if (!empty($_POST['nonmedpage'])) {
      $resfield[] = $_POST['nonmedpage'];
      }
      if (!empty($_POST['nonmedcat'])) {
      $resfield[] = $_POST['nonmedcat'];
      }
      } else {
      $fields = array('pages', 'dos', 'patient_name', 'category', 'provider_name', 'gender', 'doi', 'facility', 'title');
      foreach ($_POST['DateCoding'] as $key => $value) {
      if (in_array($key, $fields)) {
      if (!empty($value)) {
      $resfield[] = $value;
      }
      }
      }
      }
      if (Yii::app()->session['user_type'] == 'R') {
      $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => 'SA', 'ja_flag' => 'A'), array('condition' => 'ja_partition_id <> 0'));
      } else if (Yii::app()->session['user_type'] == 'QC') {
      $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_flag' => 'A'), array("condition" => "ja_status = 'SQP'"));
      } else if(Yii::app()->session['user_type'] == 'A' || Yii::app()->session['user_type'] == 'TL'){
      $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_flag' => 'A'), array("condition" => "(ja_status = 'SA' and ja_partition_id <> 0) || ja_status = 'SC' || ja_status = 'SQP' || ja_status = 'QEC'"));
      }
      if (empty($resfield) || $mode == 'D' || empty($checkStatus)) {
      if (is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $project)) {
      $filename = Yii::app()->basePath . "/../file_restore/splitting/" . $project . '/' . $file_id . ".txt";
      if (file_exists($filename)) {
      unlink($filename);
      }
      }
      } else {
      if (!is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $project)) {
      mkdir(Yii::app()->basePath . "/../file_restore/splitting/" . $project, 0777, true);
      }
      if (isset($_POST['nonmedpage']) && isset($_POST['nonmedcat'])) {
      $txt = $_POST['DateCoding']['pages'] . "|" . $_POST['DateCoding']['dos'] . "|" . $_POST['DateCoding']['patient_name'] . "|" . $_POST['DateCoding']['category'] . "|" . $_POST['DateCoding']['provider_name'] . "|" . $_POST['DateCoding']['gender'] . "|" . $_POST['DateCoding']['doi'] . "|" . $_POST['DateCoding']['facility'] . "|" . $_POST['DateCoding']['title'] . "|" . $_POST['nonmedpage'] . "|" . $_POST['nonmedcat'];
      } else {
      $txt = $_POST['DateCoding']['pages'] . "|" . $_POST['DateCoding']['dos'] . "|" . $_POST['DateCoding']['patient_name'] . "|" . $_POST['DateCoding']['category'] . "|" . $_POST['DateCoding']['provider_name'] . "|" . $_POST['DateCoding']['gender'] . "|" . $_POST['DateCoding']['doi'] . "|" . $_POST['DateCoding']['facility'] . "|" . $_POST['DateCoding']['title'];
      }
      $filename = Yii::app()->basePath . "/../file_restore/splitting/" . $project . '/' . $file_id . ".txt";
      if (file_exists($filename)) {
      file_put_contents($filename, $txt);
      } else {
      file_put_contents($filename, $txt);
      }
      }
      } */

    public function actionAutosavesplit($mode) {
        $file_id = $_POST['formdata']['file'];
        $file_info = FileInfo::model()->findByPk($file_id);
        $project_id = $file_info->fi_pjt_id;
        $project = $project_id . "_restore";
        $resfield = array();

        $autoprovider = (isset($_POST['formdata']['provider_name']) && !empty($_POST['formdata']['provider_name'])) ? $_POST['formdata']['provider_name'] : '';
        $autoprovider = preg_replace("/\r|\n/", "^", $autoprovider);

        $autobodypart = (isset($_POST['formdata']['body_parts']) && !empty($_POST['formdata']['body_parts'])) ? $_POST['formdata']['body_parts'] : '';
        $autobodypart = preg_replace("/\r|\n/", "^", $autobodypart);

        $autoecd9 = (isset($_POST['formdata']['ecd_9_diagnoses']) && !empty($_POST['formdata']['ecd_9_diagnoses'])) ? $_POST['formdata']['ecd_9_diagnoses'] : '';
        $autoecd9 = preg_replace("/\r|\n/", "^", $autoecd9);

        $autoecd10 = (isset($_POST['formdata']['ecd_10_diagnoses']) && !empty($_POST['formdata']['ecd_10_diagnoses'])) ? $_POST['formdata']['ecd_10_diagnoses'] : '';
        $autoecd10 = preg_replace("/\r|\n/", "^", $autoecd10);

        $autodx = (isset($_POST['formdata']['dx_terms']) && !empty($_POST['formdata']['dx_terms'])) ? $_POST['formdata']['dx_terms'] : '';
        $autodx = preg_replace("/\r|\n/", "^", $autodx);

        $autopages = (isset($_POST['formdata']['pages']) && !empty($_POST['formdata']['pages'])) ? $_POST['formdata']['pages'] : '';

        $autodos = (isset($_POST['formdata']['dos']) && !empty($_POST['formdata']['dos'])) ? $_POST['formdata']['dos'] : '';

        $autopatient_name = (isset($_POST['formdata']['patient_name']) && !empty($_POST['formdata']['patient_name'])) ? $_POST['formdata']['patient_name'] : '';

        $autocategory = (isset($_POST['formdata']['category']) && !empty($_POST['formdata']['category'])) ? $_POST['formdata']['category'] : '';

        $autogender = (isset($_POST['formdata']['gender']) && !empty($_POST['formdata']['gender'])) ? $_POST['formdata']['gender'] : '';

        $autodoi = (isset($_POST['formdata']['doi']) && !empty($_POST['formdata']['doi'])) ? $_POST['formdata']['doi'] : '';

        $autofacility = (isset($_POST['formdata']['facility']) && !empty($_POST['formdata']['facility'])) ? $_POST['formdata']['facility'] : '';

        $autotitle = (isset($_POST['formdata']['title']) && !empty($_POST['formdata']['title'])) ? $_POST['formdata']['title'] : '';

        $autopages1 = (isset($_POST['formdata1']['pages1']) && !empty($_POST['formdata1']['pages1'])) ? $_POST['formdata1']['pages1'] : '';

        $autocategory1 = (isset($_POST['formdata1']['category1']) && !empty($_POST['formdata1']['category1'])) ? $_POST['formdata1']['category1'] : '';

        $autobody_part1 = (isset($_POST['formdata1']['body_part1']) && !empty($_POST['formdata1']['body_part1'])) ? $_POST['formdata1']['body_part1'] : '';
        $autobody_part1 = preg_replace("/\r|\n/", "^", $autobody_part1);

        $autoecd_9_diagnoses1 = (isset($_POST['formdata1']['ecd_9_diagnoses1']) && !empty($_POST['formdata1']['ecd_9_diagnoses1'])) ? $_POST['formdata1']['ecd_9_diagnoses1'] : '';
        $autoecd_9_diagnoses1 = preg_replace("/\r|\n/", "^", $autoecd_9_diagnoses1);

        $autoecd_10_diagnoses1 = (isset($_POST['formdata1']['ecd_10_diagnoses1']) && !empty($_POST['formdata1']['ecd_10_diagnoses1'])) ? $_POST['formdata1']['ecd_10_diagnoses1'] : '';
        $autoecd_10_diagnoses1 = preg_replace("/\r|\n/", "^", $autoecd_10_diagnoses1);

        $autodx_terms1 = (isset($_POST['formdata1']['dx_terms1']) && !empty($_POST['formdata1']['dx_terms1'])) ? $_POST['formdata1']['dx_terms1'] : '';
        $autodx_terms1 = preg_replace("/\r|\n/", "^", $autodx_terms1);

        $autodob = (isset($_POST['formdata']['dob']) && !empty($_POST['formdata']['dob'])) ? $_POST['formdata']['dob'] : '';

        $fields = array('pages', 'dos', 'patient_name', 'category', 'provider_name', 'gender', 'doi', 'facility', 'title', 'dob', 'body_parts', 'ecd_9_diagnoses', 'ecd_10_diagnoses', 'dx_terms');
        foreach ($_POST['formdata'] as $key => $value) {
            if (in_array($key, $fields)) {
                if (!empty($value)) {
                    $resfield[] = $value;
                }
            }
        }
        $field1 = array('pages1', 'category1', 'body_part1', 'ecd_9_diagnoses1', 'ecd_10_diagnoses1', 'dx_terms1');
        foreach ($_POST['formdata1'] as $key => $value) {
            if (in_array($key, $field1)) {
                if (!empty($value)) {
                    $resfield[] = $value;
                }
            }
        }

        if (Yii::app()->session['user_type'] == 'R') {
            $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => 'SA', 'ja_flag' => 'A'), array('condition' => 'ja_partition_id <> 0'));
        } else if (Yii::app()->session['user_type'] == 'QC') {
            $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_flag' => 'A'), array("condition" => "ja_status = 'SQP'"));
        } else if (Yii::app()->session['user_type'] == 'A' || Yii::app()->session['user_type'] == 'TL') {
            $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_flag' => 'A'), array("condition" => "(ja_status = 'SA' and ja_partition_id <> 0) || ja_status = 'SC' || ja_status = 'SQP' || ja_status = 'QEC'"));
        }
        if (empty($resfield) || $mode == 'D' || empty($checkStatus)) {
            if (is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $project)) {
                $filename = Yii::app()->basePath . "/../file_restore/splitting/" . $project . '/' . $file_id . ".txt";
                if (file_exists($filename)) {
                    unlink($filename);
                }
            }
        } else {
            if (!is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $project)) {
                mkdir(Yii::app()->basePath . "/../file_restore/splitting/" . $project, 0777, true);
            }
            $txt = $autopages . "|" . $autodos . "|" . $autopatient_name . "|" . $autocategory . "|" . $autoprovider . "|" . $autogender . "|" . $autodoi . "|" . $autofacility . "|" . $autotitle . "|" . $autopages1 . "|" . $autocategory1 . "|" . $autodob . "|" . $autobodypart . "|" . $autoecd9 . "|" . $autoecd10 . "|" . $autodx . "|" . $autobody_part1 . "|" . $autoecd_9_diagnoses1 . "|" . $autoecd_10_diagnoses1 . "|" . $autodx_terms1;
            $filename = Yii::app()->basePath . "/../file_restore/splitting/" . $project . '/' . $file_id . ".txt";
            if (file_exists($filename)) {
                file_put_contents($filename, $txt);
            } else {
                file_put_contents($filename, $txt);
            }
        }

        //$fields = array('patient_name', 'dob', 'gender', 'doi', 'pages', 'file', 'dos', 'provider_name', 'record_row', 'category', 'type', 'facility', 'body_parts', 'title', 'ecd_9_diagnoses', 'ecd_10_diagnoses', 'dx_terms', 'med_status');

        /* if (Yii::app()->session['user_type'] == 'R') {
          $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_status' => 'SA', 'ja_flag' => 'A'), array('condition' => 'ja_partition_id <> 0'));
          } else if (Yii::app()->session['user_type'] == 'QC') {
          $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_flag' => 'A'), array("condition" => "ja_status = 'SQP'"));
          } else if(Yii::app()->session['user_type'] == 'A' || Yii::app()->session['user_type'] == 'TL'){
          $checkStatus = JobAllocation::model()->findByAttributes(array('ja_file_id' => $file_id, 'ja_flag' => 'A'), array("condition" => "(ja_status = 'SA' and ja_partition_id <> 0) || ja_status = 'SC' || ja_status = 'SQP' || ja_status = 'QEC'"));
          }
          if (empty($resfield) || $mode == 'D' || empty($checkStatus)) {
          if (is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $project)) {
          $filename = Yii::app()->basePath . "/../file_restore/splitting/" . $project . '/' . $file_id . ".txt";
          if (file_exists($filename)) {
          unlink($filename);
          }
          }
          } else {
          if (!is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $project)) {
          mkdir(Yii::app()->basePath . "/../file_restore/splitting/" . $project, 0777, true);
          }
          if (isset($_POST['nonmedpage']) && isset($_POST['nonmedcat'])) {
          $txt = $_POST['DateCoding']['pages'] . "|" . $_POST['DateCoding']['dos'] . "|" . $_POST['DateCoding']['patient_name'] . "|" . $_POST['DateCoding']['category'] . "|" . $_POST['DateCoding']['provider_name'] . "|" . $_POST['DateCoding']['gender'] . "|" . $_POST['DateCoding']['doi'] . "|" . $_POST['DateCoding']['facility'] . "|" . $_POST['DateCoding']['title'] . "|" . $_POST['nonmedpage'] . "|" . $_POST['nonmedcat'];
          } else {
          $txt = $_POST['DateCoding']['pages'] . "|" . $_POST['DateCoding']['dos'] . "|" . $_POST['DateCoding']['patient_name'] . "|" . $_POST['DateCoding']['category'] . "|" . $_POST['DateCoding']['provider_name'] . "|" . $_POST['DateCoding']['gender'] . "|" . $_POST['DateCoding']['doi'] . "|" . $_POST['DateCoding']['facility'] . "|" . $_POST['DateCoding']['title'];
          }
          $filename = Yii::app()->basePath . "/../file_restore/splitting/" . $project . '/' . $file_id . ".txt";
          if (file_exists($filename)) {
          file_put_contents($filename, $txt);
          } else {
          file_put_contents($filename, $txt);
          }
          } */
    }

    public function actionGetsplitpages() {
        $partition_id = $_POST['partid'];
        $type = $_POST['usertype'];
        $returnarray = array();
        $filePartition = FilePartition::model()->findByPk($partition_id);
        if ($filePartition) {
            $returnarray['fileid'] = $filePartition->fp_file_id;
            $returnarray['firstpage'] = explode(',', $filePartition->fp_page_nums);
            $returnarray['pageCount'] = count(explode(',', $filePartition->fp_page_nums));
            $returnarray['oldpage'] = json_encode(explode(',', $filePartition->fp_page_nums));
            $returnarray['showlink'] = true;
            if (isset($filePartition->FileInfo->fi_file_ori_location)) {
                $returnarray['url'] = Yii::app()->baseUrl . '/' . $filePartition->FileInfo->fi_file_ori_location;
            }
            $returnarray['cat_id'] = isset($filePartition->FileInfo->ProjectMaster->p_category_ids) ? $filePartition->FileInfo->ProjectMaster->p_category_ids : '';
            $returnarray['poject_id'] = isset($filePartition->FileInfo->fi_pjt_id) ? $filePartition->FileInfo->fi_pjt_id : '';
            if ($type == "R") {
                $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $returnarray['fileid'], 'ja_status' => "SA", 'ja_flag' => 'A'));
            } else {
                $job_model = JobAllocation::model()->findByAttributes(array('ja_file_id' => $returnarray['fileid'], 'ja_status' => "SQP", 'ja_flag' => 'A'));
            }
            if ($job_model) {
                $returnarray['job_id'] = $job_model->ja_job_id;
            }
        }
        $return_json = json_encode($returnarray, true);
        die($return_json);
    }

    public function actionFinishfile() {
        $job_id = $_POST['jobid'];
        $type = $_POST['type'];
        $spvar = "";
        $jobModel = JobAllocation::model()->findByPk($job_id);
        if ($type == 'M') {
            $jobModel->ja_med_status = "C";
            $spvar = "Medical part";
        } else if ($type == 'N') {
            $jobModel->ja_nonmed_status = "C";
            $spvar = "Non Medical part";
        }
        if ($jobModel->save()) {
            $msg['msg'] = $spvar . ' finished successfuly';
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        } else {
            $msg['msg'] = 'Not able to finish';
            $msg['status'] = 'E';
            echo json_encode($msg, true);
            die();
        }
    }

    /**
     * @Protected File Save Directory
     */
    private function saveDirectory($filePartition) {
        //$file_status = '';
		$dos = "";
        $file_status = array();
        $file_id = $filePartition['file'];
        $project = $filePartition['project'] . "_breakfile";
        /* check Current date */
        if (!is_dir(Yii::app()->basePath . "/../filepartition/" . $project)) {
            mkdir(Yii::app()->basePath . "/../filepartition/" . $project, 0777, true);
        }
        $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
        //Datas:
        $current_date = date('Y-m-d H:i:s');
        //$dos = !empty($filePartition['dos']) ? $filePartition['dos'] : '';
        $fdos = !empty($filePartition['dos']) ? $filePartition['dos'] : '';
        $tdos = !empty($filePartition['todos']) ? $filePartition['todos'] : '';
		if(!empty($filePartition['dos'])){
			$dos = !empty($filePartition['todos']) ? $filePartition['dos']."-".$filePartition['todos'] : $filePartition['dos']; 
		}
        $patientName = !empty($filePartition['patient_name']) ? $filePartition['patient_name'] : "";
        $category = !empty($filePartition['category']) ? $filePartition['category'] : "";
        $providerName = !empty($filePartition['provider_name']) ? $filePartition['provider_name'] : '';
        $providerName = str_replace(PHP_EOL, '^', $providerName);
        if (!empty($providerName)) {
            $providerName = array_filter($providerName);
            asort($providerName);
            $providerName = implode("^", $providerName);
        }
        $gender = !empty($filePartition['gender']) ? $filePartition['gender'] : '';
        $doi = !empty($filePartition['doi']) ? $filePartition['doi'] : "";
        $facility = !empty($filePartition['facility']) ? $filePartition['facility'] : '';
        $catName = Category::getCatName($category);
        $type = !empty($filePartition['type']) ? $filePartition['type'] : '';
        $title = !empty($filePartition['title']) ? $filePartition['title'] : "";
        $dob = !empty($filePartition['dob']) ? $filePartition['dob'] : "";
        $formPages = !empty($filePartition['pages']) ? $filePartition['pages'] : "";
        $undated = !empty($filePartition['undated']) ? $filePartition['undated'] : "";
        $recordRow = !empty($filePartition['record_row']) ? $filePartition['record_row'] : '';
        $expNewPageNo = explode(',', $formPages);
        $bodyparts = !empty($filePartition['body_parts']) ? $filePartition['body_parts'] : '';
        $dxterms = !empty($filePartition['dx_terms']) ? $filePartition['dx_terms'] : '';
//        $dxterms = str_replace(PHP_EOL, '^', $dxterms); //Extra implode
//        $bodyparts = str_replace(PHP_EOL, '^', $bodyparts); //Extra implode
        $ecd_9_diagnoses = !empty($filePartition['ecd_9_diagnoses']) ? $filePartition['ecd_9_diagnoses'] : '';
        $ecd_10_diagnoses = !empty($filePartition['ecd_10_diagnoses']) ? $filePartition['ecd_10_diagnoses'] : '';
        if(!empty($filePartition['ecd_9_diagnoses'])){
             $ecd_9_diagnoses = implode("^",$ecd_9_diagnoses); //Extra implode
        }
        if(!empty($filePartition['ecd_10_diagnoses'])){
             $ecd_10_diagnoses = implode("^",$ecd_10_diagnoses); //Extra implode
        }
        if(!empty($filePartition['dx_terms'])){
             $dxterms = implode("^",$dxterms); //Extra implode
        }
        if(!empty($filePartition['body_parts'])){
             $bodyparts = implode("^",$bodyparts); //Extra implode
        }
		$ms_terms = "";
		$ms_value = "";
		$protem = Project::model()->with('template')->findByPk($filePartition['project']);
		$template = $protem->template->t_name; 
		if($template == "BACTESPDF"){
			$ms_terms = !empty($filePartition['ms_terms']) ? $filePartition['ms_terms'] : '';
			$ms_value = !empty($filePartition['ms_value']) ? $filePartition['ms_value'] : '';
		}
//        $ecd_9_diagnoses = str_replace(PHP_EOL, '^', $ecd_9_diagnoses); //Extra implode
       
//         echo "<pre>";
//        print_r($ecd_9_diagnoses);
//        die();

//        $ecd_10_diagnoses = str_replace(PHP_EOL, '^', $ecd_10_diagnoses); //Extra implode
        $diagnoses = $ecd_9_diagnoses . '~' . $ecd_10_diagnoses . '~' . $dxterms;
        $create_up = $recordRow;
        //$currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title;
        $summaryskipmodel = Project::model()->findByPk($filePartition['project']);
        if ($summaryskipmodel->skip_edit == 1) {
            //echo $dxterms;die;
            $currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title . "||" . $bodyparts . "|" . $diagnoses . "|" . $ms_terms. "|" . $ms_value;
        } else {
            $currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title;
        }

        // save auto complete json in project table for provider,facility,title
        $prevarr = json_decode($summaryskipmodel->p_json, true);
        if (empty($prevarr)) {
            $prevarr = array('P' => array(), 'F' => array(), 'T' => array(), 'B' => array(), 'E' => array(), 'N' => array(), 'DX' => array());
        }
        foreach ($prevarr as $keyprev => $prev) {
            switch ($keyprev) {
                case "P":
                    $variable = $providerName;
                    break;
                case "F":
                    $variable = $facility;
                    break;
                case "T":
                    $variable = $title;
                    break;
                case "B":
                    $variable = $bodyparts;
                    break;
                case "E":
                    $variable = $ecd_9_diagnoses;
                    break;
                case "N":
                    $variable = $ecd_10_diagnoses;
                    break;
                case "DX":
                    $variable = $dxterms;
                    break;
            }
            if (!in_array($variable, $prev)) {
                if ($variable != "") {
                    if ($keyprev == "P" || $keyprev == "B" || $keyprev == "E" || $keyprev == "N" || $keyprev == "DX") {
                        if (strpos($variable, '^') !== false) {
                            $partarr = array_filter(explode('^', $variable));
                            //array_values($partarr);
                            //$prev = array_unique(array_merge($prev, $partarr), SORT_REGULAR);
                            $prev = array_unique(array_merge($prev, $partarr));
                            $prev = array_values($prev);
                        } else {
                            array_push($prev, $variable);
                        }
                    } else {
                        array_push($prev, $variable);
                    }
                }
            }
            $prevarr[$keyprev] = $prev;
        }
        $newjson = json_encode($prevarr, true);
        //print_r($newjson);
        $summaryskipmodel->p_json = $newjson;
        $summaryskipmodel->save(false);
        // save auto complete json in project table for provider,facility,title

        if (file_exists($filename)) {
            $wholeFile = file($filename);
            $rowCount = count($wholeFile);
            if ($rowCount) {
                $i = 1;
                $newRowLine = array();
                $newRow = true;
                $unsetRow = false;
                foreach ($wholeFile as $rowLine) {
                    $rowField = explode('|', trim($rowLine));
                    if ($rowField) {
                        $expoldPageNo = explode(',', $rowField[0]);
                        $combination = false;
                        $rowType = !empty($rowField[10]) ? $rowField[10] : '';
                        $rowDos = !empty($rowField[1]) ? $rowField[1] : '';
                        if ($rowType == 'M' && $type == 'M') {
                            //if (!empty($providerName) && !empty($category) && !empty($rowField[3]) && !empty($rowField[4]) && $rowField[3] == $category && $rowField[4] == $providerName) {
                            if (!empty($category) && !empty($rowField[3]) && $rowField[3] == $category && $rowField[4] == $providerName) {
                                if(empty($filePartition['todos'])){
									if (empty($undated) && $rowDos) {
										if ($dos == $rowDos) {
											$combination = true;
										}
									} else if ($undated && empty($rowDos)) {
										$combination = true;
									}
								}
                            }
                        } else if ($rowType == 'N' && $type == 'N') {
                            if (!empty($category) && !empty($rowField[3]) && $rowField[3] == $category) {
                                $combination = true;
                            }
                        }
                        //Combination
                        if ($combination) {
                            $newRow = false;
                            if ($recordRow) {
                                if ($recordRow == $i) {
                                    $newRow = $formPages . $currentText . PHP_EOL;
                                    $newRowLine[] = $newRow;
                                } else {
                                    $unsetRow = true;
                                    $merNewPageNo = array_unique(array_merge($expoldPageNo, $expNewPageNo));
                                    sort($merNewPageNo);
                                    $newPageNo = implode(',', $merNewPageNo);
                                    $newPageNo .= $currentText . PHP_EOL;
                                    $newRowLine[] = $newPageNo;
                                }
                            } else {
                                $merNewPageNo = array_unique(array_merge($expoldPageNo, $expNewPageNo));
                                sort($merNewPageNo);
                                $newPageNo = implode(',', $merNewPageNo);
                                $newPageNo .= $currentText . PHP_EOL;
                                $newRowLine[] = $newPageNo;
                            }
                        } else {
                            $newRowLine[] = $rowLine;
                        }
                        $i++;
                    }
                }
                //Verify Data Processs
                if ($newRow) {
                    if ($recordRow) {
                        $current = $recordRow - 1;
                        $newRowLine[$current] = $formPages . $currentText . PHP_EOL;
                    } else {
                        $newRow = $formPages . $currentText . PHP_EOL;
                        $newRowLine[] = $newRow;
                    }
                }
                if ($unsetRow) {
                    $current = $recordRow - 1;
                    unset($newRowLine[$current]);
                }
                file_put_contents($filename, implode("", $newRowLine));
                $file_status[0] = 'Succesfully Generated';
            } else {
                $file_status[0] = $this->newRecordSave($filename, $currentText, $formPages);
            }
        } else {
            $file_status[0] = $this->newRecordSave($filename, $currentText, $formPages);
        }
        $file_status[1] = $newjson;
        $file_status[2] = $create_up;
        return $file_status;
    }

    //Only new recode
    public function actionNewrecord() {
        if (isset($_POST['DateCoding'])) {
            $filePartition = $_POST['DateCoding'];
            $file_id = $filePartition['file'];
            $project = $filePartition['project'] . "_breakfile";
            /* check Current date */
            if (!is_dir(Yii::app()->basePath . "/../filepartition/" . $project)) {
                mkdir(Yii::app()->basePath . "/../filepartition/" . $project, 0777, true);
            }
            $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
            //Datas:
            $current_date = date('Y-m-d H:i:s');
            $dos = !empty($filePartition['dos']) ? $filePartition['dos'] : '';
            $patientName = !empty($filePartition['patient_name']) ? $filePartition['patient_name'] : "";
            $category = !empty($filePartition['category']) ? $filePartition['category'] : "";
            $providerName = !empty($filePartition['provider_name']) ? $filePartition['provider_name'] : '';
//            $providerName = str_replace(PHP_EOL, '^', $providerName); //Extra implode
            
            if (!empty($providerName)) {
                $providerName = array_filter($providerName);
                asort($providerName);
                $providerName = implode("^", $providerName);
            }
            $gender = !empty($filePartition['gender']) ? $filePartition['gender'] : '';
            $doi = !empty($filePartition['doi']) ? $filePartition['doi'] : "";
            $facility = !empty($filePartition['facility']) ? $filePartition['facility'] : '';
            $catName = Category::getCatName($category);
            $type = !empty($filePartition['type']) ? $filePartition['type'] : '';
            $title = !empty($filePartition['title']) ? $filePartition['title'] : "";
            $dob = !empty($filePartition['dob']) ? $filePartition['dob'] : "";
            $formPages = !empty($filePartition['pages']) ? $filePartition['pages'] : "";
            $undated = !empty($filePartition['undated']) ? $filePartition['undated'] : "";
            $recordRow = !empty($filePartition['record_row']) ? $filePartition['record_row'] : '';
            $dxterms = !empty($filePartition['dx_terms']) ? $filePartition['dx_terms'] : '';
//            $dxterms = str_replace(PHP_EOL, '^', $dxterms); //Extra implode
            $expNewPageNo = explode(',', $formPages);
            $bodyparts = !empty($filePartition['body_parts']) ? $filePartition['body_parts'] : '';
//            $bodyparts = str_replace(PHP_EOL, '^', $bodyparts); //Extra implode
            $ecd_9_diagnoses = !empty($filePartition['ecd_9_diagnoses']) ? $filePartition['ecd_9_diagnoses'] : '';
//            $ecd_9_diagnoses = str_replace(PHP_EOL, '^', $ecd_9_diagnoses); //Extra implode
            $ecd_10_diagnoses = !empty($filePartition['ecd_10_diagnoses']) ? $filePartition['ecd_10_diagnoses'] : '';
//            $ecd_10_diagnoses = str_replace(PHP_EOL, '^', $ecd_10_diagnoses); //Extra implode
            if(!empty($ecd_9_diagnoses)){
             $ecd_9_diagnoses = implode("^",$ecd_9_diagnoses); //Extra implode
        }
        if(!empty($ecd_10_diagnoses)){
             $ecd_10_diagnoses = implode("^",$ecd_10_diagnoses); //Extra implode
        }
        if(!empty($dxterms)){
             $dxterms = implode("^",$dxterms); //Extra implode
        }
        if(!empty($bodyparts)){
             $bodyparts = implode("^",$bodyparts); //Extra implode
        }
		
			$ms_terms = "";
			$ms_value = "";
			$protem = Project::model()->with('template')->findByPk($filePartition['project']);
			$template = $protem->template->t_name; 
			if($template == "BACTESPDF"){
				$ms_terms = !empty($filePartition['ms_terms']) ? $filePartition['ms_terms'] : '';
				$ms_value = !empty($filePartition['ms_value']) ? $filePartition['ms_value'] : '';
			}
			
            $diagnoses = $ecd_9_diagnoses . '~' . $ecd_10_diagnoses . '~' . $dxterms;
            $create_up = $recordRow;
            //$currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title;
            $summaryskipmodel = Project::model()->findByPk($filePartition['project']);
            if ($summaryskipmodel->skip_edit == 1) {
                $currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title . "||" . $bodyparts . "|" . $diagnoses . "|" . $ms_terms . "|" . $ms_value;
            } else {
                $currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title;
            }

            // save auto complete json in project table for provider,facility,title
            $prevarr = json_decode($summaryskipmodel->p_json, true);
            if (empty($prevarr)) {
                $prevarr = array('P' => array(), 'F' => array(), 'T' => array(), 'B' => array(), 'E' => array(), 'N' => array(), 'DX' => array());
            }
            foreach ($prevarr as $keyprev => $prev) {
                switch ($keyprev) {
                    case "P":
                        $variable = $providerName;
                        break;
                    case "F":
                        $variable = $facility;
                        break;
                    case "T":
                        $variable = $title;
                        break;
                    case "B":
                        $variable = $bodyparts;
                        break;
                    case "E":
                        $variable = $ecd_9_diagnoses;
                        break;
                    case "N":
                        $variable = $ecd_10_diagnoses;
                        break;
                    case "DX":
                        $variable = $dxterms;
                        break;
                }
                if (!in_array($variable, $prev)) {
                    if ($variable != "") {
                        if ($keyprev == "B" || $keyprev == "E" || $keyprev == "N" || $keyprev == "DX") {
                            if (strpos($variable, '^') !== false) {
                                $partarr = array_filter(explode('^', $variable));
                                //array_values($partarr);
                                //$prev = array_unique(array_merge($prev, $partarr), SORT_REGULAR);
                                $prev = array_unique(array_merge($prev, $partarr));
                                $prev = array_values($prev);
                            } else {
                                array_push($prev, $variable);
                            }
                        } else {
                            array_push($prev, $variable);
                        }
                    }
                }
                $prevarr[$keyprev] = $prev;
            }
            //print_r($keyprev);die;
            $newjson = json_encode($prevarr, true);
            $summaryskipmodel->p_json = $newjson;
            $summaryskipmodel->save(false);
            // save auto complete json in project table for provider,facility,title
            if (file_exists($filename)) {
                $wholeFile = file($filename);
                $rowCount = count($wholeFile);
                if ($rowCount && $recordRow) {
                    $newRowLine = array();
                    foreach ($wholeFile as $rowLine) {
                        if ($recordRow) {
                            $newRowLine[] = $rowLine;
                        }
                    }
                    $current = $recordRow - 1;
                    $newRowLine[$current] = $formPages . $currentText . PHP_EOL;
                    file_put_contents($filename, implode("", $newRowLine));
                    $msg['msg'] = 'Successfuly Generated';
                    if (empty($create_up)) {
                        $msg['status'] = 'S';
                    } else {
                        $msg['status'] = 'U';
                    }
                } else {
                    $newRowLine = array();
                    foreach ($wholeFile as $rowLine) {
                        $newRowLine[] = $rowLine;
                    }
                    $newRow = $formPages . $currentText . PHP_EOL;
                    $newRowLine[] = $newRow;
                    file_put_contents($filename, implode("", $newRowLine));
                    $msg['msg'] = 'Successfuly Generated';
                    if (empty($create_up)) {
                        $msg['status'] = 'S';
                    } else {
                        $msg['status'] = 'U';
                    }
                }
            } else {
                $msg['msg'] = $this->newRecordSave($filename, $currentText, $formPages);
                $msg['status'] = 'S';
            }


            /* if (file_exists($filename)) {
              $wholeFile = file($filename);
              $newRowLine = array();
              foreach ($wholeFile as $rowLine) {
              $newRowLine[] = $rowLine;
              }
              $newRow = $formPages . $currentText . PHP_EOL;
              $newRowLine[] = $newRow;
              file_put_contents($filename, implode("", $newRowLine));
              $msg['msg'] = 'Successfuly Generated';
              $msg['status'] = 'S';
              } else {
              $msg['msg'] = $this->newRecordSave($filename, $currentText, $formPages);
              $msg['status'] = 'S';
              } */
            $msg['pjson'] = $newjson;
            $msg['append'] = Yii::app()->filerecord->getSavedRecord($_POST['DateCoding']['project'], $_POST['DateCoding']['file'], $_POST['DateCoding']['type']);
            echo json_encode($msg, true);
            die();
        }
    }

//Converted New record
    private function newRecordSave($fname, $text, $pages) {
        $row = $pages . $text . PHP_EOL;
        file_put_contents($fname, $row);
        return 'Succesfully Generated';
    }

    /**
     * @ File partation Complete
     */
    public function actionSplitcomplete() {
        $jobAlloc = JobAllocation::model()->findByPk($_REQUEST['job_id']);
        $fileInfo = FileInfo::model()->findByPk($jobAlloc->ja_file_id);
       if($fileInfo->fi_admin_lock !="O" )
        {
            $fileInfo->fi_admin_lock="O";
            $fileInfo->update("fi_admin_lock");
        }
        $sortarr=$_POST['cat_ids'];

        $filemedinfo=implode(",",$sortarr);
        $fileInfo->fi_medinfo=$filemedinfo;
        $fileInfo->update("file_medinfo");

        $status = FileinfoController::actionCheckqualitystatus($fileInfo->fi_pjt_id, $_REQUEST['mode'], $_REQUEST['job_id'], $_REQUEST['status']);

        if ($status) {
            $getProId = FileInfo::model()->findByPk($jobAlloc->ja_file_id);
            $project = $fileInfo->fi_pjt_id . "_breakfile";
            $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $jobAlloc->ja_file_id . ".txt";
            if (file_exists($filename)) {
                //$getFileCnt = count(file($filename));
                $record = array();
                $fileCntArr = array();
                $i = 1;
                foreach (file($filename) as $fileRow) {
                    $fileRow = str_replace(PHP_EOL, '', $fileRow);
                    $rowsArr = explode("|", $fileRow);
                    if (isset($rowsArr[10]) == 'M') {
                        $fileCntArr[] = $fileRow;
                    }
                    if (isset($rowsArr[13])) {
                        $rowsArr[13] = $i;
                        $str = implode('|', $rowsArr);
                    } else {
                        $str = $fileRow . "|" . $i;
                    }
                    $record[] = $str . PHP_EOL;
                    $i++;
                }
                $getFileCnt = count($fileCntArr);
                file_put_contents($filename, implode("", $record));
                $getProId->file_linecnt_fi = $getFileCnt;
                $getProId->save();
            }
            $description = "File has been completed";
            Yii::app()->Audit->writeAuditLog("Complete", "DateCoding", $_REQUEST['job_id'], $description);
            $msg['msg'] = 'File  Completed successfuly';
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
        /* if (isset($_REQUEST['job_id']) && isset($_REQUEST['status'])) {
          $jobAllocation = JobAllocation::model()->findByPk($_REQUEST['job_id']);
          if ($jobAllocation) {
          $jobAllocation->ja_status = $_REQUEST['status'];
          $jobAllocation->ja_reviewer_completed_time = date('Y-m-d H:i:s');
          if ($jobAllocation->save()) {
          $description = "File has been completed";
          $msg['msg'] = 'File completed successfuly';
          $msg['status'] = 'S';
          echo json_encode($msg, true);
          die();
          }
          }
          } */
    }

    public function actionPartitioncheck() {
        $jobAlloc = JobAllocation::model()->findByPk($_REQUEST['job_id']);
        $fileInfo = FileInfo::model()->findByPk($jobAlloc->ja_file_id);
        if ($fileInfo) {
            $getProId = FileInfo::model()->findByPk($jobAlloc->ja_file_id);
            $project = $fileInfo->fi_pjt_id . "_breakfile";
            if (file_exists($filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $jobAlloc->ja_file_id . ".txt")) {
                $description = "No Records Found";
                Yii::app()->Audit->writeAuditLog("check", "FilePage", $_REQUEST['job_id'], $description);
                $msg['msg'] = 'File Checked successfuly';
                $msg['status'] = 'RF';
            } else {
                $description = " Records Found";
                Yii::app()->Audit->writeAuditLog("check", "FilePage", $_REQUEST['job_id'], $description);
                $msg['msg'] = 'File Checked successfuly';
                $msg['status'] = 'NF';
            }
        }
        /* if(!$filecheck){
          $description ="No Records Found";
          Yii::app()->Audit->writeAuditLog("check", "FilePage", $_REQUEST['job_id'], $description);
          $msg['msg'] = 'File Checked successfuly';
          $msg['status'] = 'NF';
          }
          else
          {
          $description =" Records Found";
          Yii::app()->Audit->writeAuditLog("check", "FilePage", $_REQUEST['job_id'], $description);
          $msg['msg'] = 'File Checked successfuly';
          $msg['status'] = 'RF';
          } */
        echo json_encode($msg, true);
        die();
    }

    public static function actionDeleterestore($delt_fileid) {
        $delt_file_id = $delt_fileid;
        $delt_file_info = FileInfo::model()->findByPk($delt_file_id);
        $delt_project_id = $delt_file_info->fi_pjt_id;
        $delt_project = $delt_project_id . "_restore";

        if (is_dir(Yii::app()->basePath . "/../file_restore/splitting/" . $delt_project)) {
            $delt_filename = Yii::app()->basePath . "/../file_restore/splitting/" . $delt_project . '/' . $delt_file_id . ".txt";
            if (file_exists($delt_filename)) {
                unlink($delt_filename);
            }
        }
    }

    /**
     * @Move To Non Medical Page
     */
    public function actionMovenonmedical($file_id) {
        $fileInfo = FileInfo::model()->findByPk($file_id);
        $model = new DateCoding();
        $pages = $_REQUEST['pages'];
        //$file_status = "";
        $file_status = array();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-move-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['DateCoding'])) {
            $newpage = explode(',', $_POST['DateCoding']['pages']);
            $filePartition = FilePartition::model()->findAll(array('condition' => "fp_file_id=$file_id  and fp_flag='A'"));
            if ($filePartition && $fileInfo) {
                foreach ($filePartition as $nfile) {
                    if ($nfile->fp_page_nums != "") {
                        $oldpage = explode(',', $nfile->fp_page_nums);
                    } else {
                        $oldpage = array();
                    }
                    if ($nfile->fp_category == 'N') {
                        $currentPage = array_unique(array_merge($oldpage, $newpage));
                        asort($currentPage);
                        $nfile->fp_page_nums = implode(',', $currentPage);
                        //project
                        $skip_edit = Project::model()->findByPk($fileInfo->fi_pjt_id);
                        $project = $fileInfo->fi_pjt_id . "_breakfile";
                        $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
                        $newlines = array();
						
						$ms_terms = "";
						$ms_value = "";
			
                        if (file_exists($filename)) {
                            foreach (file($filename) as $line) {
                                $exp_file = explode('|', trim($line)); //Each Line
                                $fpage_no = explode(',', trim($exp_file[0])); // Page no
                                if ($exp_file[10] == 'M') {
                                    $pno = implode(',', array_diff($fpage_no, $currentPage));
                                } else {
                                    $pno = $exp_file[0];
                                }
								$protem = Project::model()->with('template')->findByPk($fileInfo->fi_pjt_id);
								$template = $protem->template->t_name; 
								if($template == "BACTESPDF"){
									$ms_terms = !empty($exp_file[16]) ? $exp_file[16] : '';
									$ms_value = !empty($exp_file[17]) ? $exp_file[17] : '';
								}
                                if ($skip_edit->skip_edit == 1) {
                                    $txt = $pno . "|" . $exp_file[1] . "|" . $exp_file[2] . "|" . $exp_file[3] . "|" . $exp_file[4] . "|" . $exp_file[5] . "|" . $exp_file[6] . "|" . $exp_file[7] . "|" . $exp_file[8] . "|" . $exp_file[9] . "|" . $exp_file[10] . "|" . $exp_file[11] . "|" . $exp_file[12] . "||" . $exp_file[14] . "|" . $exp_file[15] . "|" . $ms_terms . "|" . $ms_value . PHP_EOL;
                                } else {
                                    $txt = $pno . "|" . $exp_file[1] . "|" . $exp_file[2] . "|" . $exp_file[3] . "|" . $exp_file[4] . "|" . $exp_file[5] . "|" . $exp_file[6] . "|" . $exp_file[7] . "|" . $exp_file[8] . "|" . $exp_file[9] . "|" . $exp_file[10] . "|" . $exp_file[11] . "|" . $exp_file[12] . PHP_EOL;
                                }
                                $line = $txt;
                                if ($pno) {
                                    $newlines[] = $line;
                                }
                            }
                            // print_r($newlines);die;
                            file_put_contents($filename, implode("", $newlines));
                        }
                    } elseif ($nfile->fp_category == 'M') {
                        $currentPage = array_diff($oldpage, $newpage);
                        $nfile->fp_page_nums = implode(',', $currentPage);
                    }
                    if ($nfile->save()) {
                        $file_status = $this->saveDirectory($_POST['DateCoding']);
                    }
                }
                $description = 'Move to  Non Medical Pages';
                $msg['msg'] = 'Move to  Non Medical Pages';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            } else {
                $description = 'Not to  Non Medical Pages';
                $msg['msg'] = 'Not to  Non Medical Pages';
                $msg['status'] = 'N';
                echo json_encode($msg, true);
                die();
            }
        }
        //$filePartition = FilePartition::model()->findAll(array('condition' => "fp_file_id=$file_id and fp_flag='A'"));
        $this->renderPartial('movenonmedical', array('model' => $model, 'pages' => $pages, 'fileInfo' => $fileInfo, 'pjson' => $fileInfo->ProjectMaster->p_json), false, true);
    }

// move non medical to medical
    public function actionMovemedical($file_id) {

        $model = new DateCoding();
        $fileInfo = FileInfo::model()->findByPk($file_id);
        $pages = $_REQUEST['pages'];
        //$file_status = "";
        $file_status = array();
        $legArray = array();
        $filenm = Yii::app()->basePath . "/../filepartition/" . $fileInfo->fi_pjt_id . '_breakfile/' . $file_id . ".txt";
        if (file_exists($filenm)) {
            foreach (file($filenm) as $ln) {
                $exp_fl = explode('|', trim($ln));
                if ($exp_fl[10] == "M") {
                    $legArray[0] = $exp_fl[2];
                    $legArray[1] = $exp_fl[5];
                    $legArray[2] = $exp_fl[6];
					$legArray[3] = $exp_fl[9];
                }
            }
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-move-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['DateCoding'])) {
            $newpage = explode(',', $_POST['DateCoding']['pages']);
            $filePartition = FilePartition::model()->findAll(array('condition' => "fp_file_id=$file_id  and fp_flag='A'"));
            if ($filePartition && $fileInfo) {
				$nfile_st = true;
                foreach ($filePartition as $nfile) {
                    $oldpage = explode(',', $nfile->fp_page_nums);
                    if ($nfile->fp_category == 'M') {
                        $currentPage = array_unique(array_merge($oldpage, $newpage));
                        asort($currentPage);
                        $nfile->fp_page_nums = implode(',', $currentPage);
                        //project
                        $skip_edit = Project::model()->findByPk($fileInfo->fi_pjt_id);
                        $project = $fileInfo->fi_pjt_id . "_breakfile";
                        $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
                        $newlines = array();
						
						$ms_terms = "";
						$ms_value = "";

                        if (file_exists($filename)) {
                            foreach (file($filename) as $line) {
                                $exp_file = explode('|', trim($line)); //Each Line
                                $fpage_no = explode(',', trim($exp_file[0])); // Page no
                                if ($exp_file[10] == 'N') {
                                    $pno = implode(',', array_diff($fpage_no, $currentPage));
                                } else {
                                    $pno = $exp_file[0];
                                }
								
								$protem = Project::model()->with('template')->findByPk($fileInfo->fi_pjt_id);
								$template = $protem->template->t_name; 
								if($template == "BACTESPDF"){
									$ms_terms = !empty($exp_file[16]) ? $exp_file[16] : '';
									$ms_value = !empty($exp_file[17]) ? $exp_file[17] : '';
								}
								
                                if ($skip_edit->skip_edit == 1) {
                                    $txt = $pno . "|" . $exp_file[1] . "|" . $exp_file[2] . "|" . $exp_file[3] . "|" . $exp_file[4] . "|" . $exp_file[5] . "|" . $exp_file[6] . "|" . $exp_file[7] . "|" . $exp_file[8] . "|" . $exp_file[9] . "|" . $exp_file[10] . "|" . $exp_file[11] . "|" . $exp_file[12] . "||" . $exp_file[14] . "|" . $exp_file[15]  . "|" . $ms_terms . "|" . $ms_value . PHP_EOL;
                                } else {
                                    $txt = $pno . "|" . $exp_file[1] . "|" . $exp_file[2] . "|" . $exp_file[3] . "|" . $exp_file[4] . "|" . $exp_file[5] . "|" . $exp_file[6] . "|" . $exp_file[7] . "|" . $exp_file[8] . "|" . $exp_file[9] . "|" . $exp_file[10] . "|" . $exp_file[11] . "|" . $exp_file[12] . PHP_EOL;
                                }
                                $line = $txt;
                                if ($pno) {
                                    $newlines[] = $line;
                                }
                            }
                            // print_r($newlines);die;
                            file_put_contents($filename, implode("", $newlines));
                        }
                    } elseif ($nfile->fp_category == 'N') {
                        $currentPage = array_diff($oldpage, $newpage);
                        $nfile->fp_page_nums = implode(',', $currentPage);
                    }
                    if ($nfile->save()) {
                        //$file_status = $this->saveDirectory($_POST['DateCoding']);
                    }
					else{
						$nfile_st = false;
					}
                }
				if($nfile_st){
					$file_status = $this->saveDirectory($_POST['DateCoding']);
				}
                $description = 'Move to   Medical Pages';
                $msg['msg'] = 'Move to   Medical Pages';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            } else {
                $description = 'Not to   Medical Pages';
                $msg['msg'] = 'Not to    Medical Pages';
                $msg['status'] = 'N';
                echo json_encode($msg, true);
                die();
            }
        }
        $this->renderPartial('movemedical', array('model' => $model, 'pages' => $pages, 'fileInfo' => $fileInfo, 'legArray' => $legArray, 'pjson' => $fileInfo->ProjectMaster->p_json), false, true);
    }

//Function
//File delete split;
    public function actionremoveRecord() {
        $type = $_POST['type'];
        $row = $_POST['row'];
        $project_id = $_POST['project_id'];
        $file_id = $_POST['file_id'];
        $filename = Yii::app()->basePath . "/../filepartition/" . $project_id . '_breakfile/' . $file_id . ".txt";
        if (file_exists($filename)) {
            $i = 1;
            $new_record = array();
            foreach (file($filename) as $rowLine) {
                $oldData = $rowLine;
                $exp_data = explode('|', $oldData);
                $oldType = !empty($exp_data[10]) ? $exp_data[10] : '';
                if ($row != $i) {
                    $new_record[] = $rowLine;
                }
                $i++;
            }
            file_put_contents($filename, implode("", $new_record));
            $msg['msg'] = 'Record Successfully deleted';
            $msg['status'] = 'S';
            $msg['append'] = Yii::app()->filerecord->getSavedRecord($project_id, $file_id, $type);
            echo json_encode($msg, true);
            die();
        } else {
            $msg['msg'] = 'Record Not deleted';
            $msg['status'] = 'N';
            echo json_encode($msg, true);
            die();
        }
    }

//Check Duplicate
    public function actioncheckduplicate() {
        $dos = "";
		$filePartition = $_POST['DateCoding'];
        $status = '';
        $file_status = array();
        $file_id = $filePartition['file'];
        $project = $filePartition['project'] . "_breakfile";
        /* check Current date */
        if (!is_dir(Yii::app()->basePath . "/../filepartition/" . $project)) {
            mkdir(Yii::app()->basePath . "/../filepartition/" . $project, 0777, true);
        }
        $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
        //Datas:
        $current_date = date('Y-m-d H:i:s');
        //$dos = !empty($filePartition['dos']) ? $filePartition['dos'] : '';
        $fdos = !empty($filePartition['dos']) ? $filePartition['dos'] : '';
		$ftdos = !empty($filePartition['todos']) ? $filePartition['todos'] : '';
		if(!empty($filePartition['dos'])){
			$dos = !empty($filePartition['todos']) ? $filePartition['dos']."-".$filePartition['todos'] : $filePartition['dos'];
		}
        $patientName = !empty($filePartition['patient_name']) ? $filePartition['patient_name'] : "";
        $category = !empty($filePartition['category']) ? $filePartition['category'] : "";
        $providerName = !empty($filePartition['provider_name']) ? $filePartition['provider_name'] : '';
//        $providerName = str_replace(PHP_EOL, '^', $providerName);
        if (!empty($providerName)) {
            $providerName = array_filter($providerName);
            asort($providerName);
            $providerName = implode("^", $providerName);
        }
        $gender = !empty($filePartition['gender']) ? $filePartition['gender'] : '';
        $doi = !empty($filePartition['doi']) ? $filePartition['doi'] : "";
        $facility = !empty($filePartition['facility']) ? $filePartition['facility'] : '';
        $catName = Category::getCatName($category);
        $type = !empty($filePartition['type']) ? $filePartition['type'] : '';
        $title = !empty($filePartition['title']) ? $filePartition['title'] : "";
        $dob = !empty($filePartition['dob']) ? $filePartition['dob'] : "";
        $formPages = !empty($filePartition['pages']) ? $filePartition['pages'] : "";
        $undated = !empty($filePartition['undated']) ? $filePartition['undated'] : "";
        $recordRow = !empty($filePartition['record_row']) ? $filePartition['record_row'] : '';
        $expNewPageNo = explode(',', $formPages);
        $bodyparts = !empty($filePartition['body_parts']) ? $filePartition['body_parts'] : '';
        $bodyparts = str_replace(PHP_EOL, '^', $bodyparts); //Extra implode
        $ecd_9_diagnoses = !empty($filePartition['ecd_9_diagnoses']) ? $filePartition['ecd_9_diagnoses'] : '';
//        $ecd_9_diagnoses = str_replace(PHP_EOL, '^', $ecd_9_diagnoses); //Extra implode
        $ecd_10_diagnoses = !empty($filePartition['ecd_10_diagnoses']) ? $filePartition['ecd_10_diagnoses'] : '';
        //$ecd_10_diagnoses = str_replace(PHP_EOL, '^', $ecd_10_diagnoses); //Extra implode
        //$diagnoses = $ecd_9_diagnoses . '~' . $ecd_10_diagnoses;
        //$currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title;
        $summaryskipmodel = Project::model()->findByPk($filePartition['project']);
        if(!empty($ecd_9_diagnoses)){
            $ecd_9_diagnoses = implode("^",$ecd_9_diagnoses);
        }
        if(!empty($ecd_10_diagnoses)){
            $ecd_10_diagnoses = implode("^",$ecd_10_diagnoses);
        }
		$diagnoses = $ecd_9_diagnoses . '~' . $ecd_10_diagnoses;
        if(!empty($bodyparts)){
            $bodyparts = implode("^",$bodyparts);
        }
		
			$ms_terms = "";
			$ms_value = "";
			$protem = Project::model()->with('template')->findByPk($filePartition['project']);
			$template = $protem->template->t_name; 
			if($template == "BACTESPDF"){
				$ms_terms = !empty($filePartition['ms_terms']) ? $filePartition['ms_terms'] : '';
				$ms_value = !empty($filePartition['ms_value']) ? $filePartition['ms_value'] : '';
			}
			
        if ($summaryskipmodel->skip_edit == 1) {
            $currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title . "||" . $bodyparts . "|" . $diagnoses . "|" . $ms_terms . "|" . $ms_value;
        } else {
            $currentText = "|" . $dos . "|" . $patientName . "|" . $category . "|" . $providerName . "|" . $gender . "|" . $doi . "|" . $facility . "|" . $catName . "|" . $dob . "|" . $type . "|" . $current_date . "|" . $title;
        }
        if (file_exists($filename)) {
            $wholeFile = file($filename);
            $rowCount = count($wholeFile);
            if ($rowCount) {
                $i = 1;
                $newRowLine = array();
                $newRow = true;
                $unsetRow = false;
                foreach ($wholeFile as $rowLine) {
                    $rowField = explode('|', trim($rowLine));
                    if ($rowField) {
                        $expoldPageNo = explode(',', $rowField[0]);
                        $combination = false;
                        $rowType = !empty($rowField[10]) ? $rowField[10] : '';
                        $rowDos = !empty($rowField[1]) ? $rowField[1] : '';
                        if ($rowType == 'M' && $type == 'M') {
                            //if (!empty($providerName) && !empty($category) && !empty($rowField[3]) && !empty($rowField[4]) && $rowField[3] == $category && $rowField[4] == $providerName) {
                            if (!empty($category) && !empty($rowField[3]) && $rowField[3] == $category && $rowField[4] == $providerName) {
                                if(empty($filePartition['todos'])){
									if (empty($undated) && $rowDos) {
										if ($dos == $rowDos) {
											if($recordRow != $i){
												$combination = true;
											}
										}
									} else if ($undated && empty($rowDos)) {
										if($recordRow != $i){
											$combination = true;
										}
									}
								}
                            }
                        } else if ($rowType == 'N' && $type == 'N') {
                            if (!empty($category) && !empty($rowField[3]) && $rowField[3] == $category) {
								if($recordRow != $i){
									$combination = true;
								}
                            }
                        }
                        //Combination
                        if ($combination) {
                            if ($recordRow) {
                                if ($recordRow == $i) {
                                    $newRow = true;
                                } else {
                                    $newRow = false;
                                }
                            } else {
                                $newRow = false;
                            }
                        }
                        $i++;
                    }
                }
                //Verify Data Processs
                if ($newRow) {
                    $status = 'N';
                } else {
                    $status = 'S';
                }
            } else {
                $status = 'N';
            }
        } else {
            $status = 'N';
        }
        echo $status;
    }

}
