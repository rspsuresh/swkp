<?php

class JoballocationController extends RController {

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
        $model = new JobAllocation;
        $fl_model = array();
        $pt_model = array();
        $jobstatus = '';

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['JobAllocation'])) {
            $model->attributes = $_POST['JobAllocation'];
            if (!empty($model->ja_file_id)) {
                $file_model = FileInfo::model()->findByPK($model->ja_file_id);
                //$file_model->fi_status = "I";
                $model->ja_reviewer_id = $model->user_id;
                $model->ja_allocated_by = Yii::app()->session['user_id'];

                if ($model->save()) {
                    $file_model->save();
                    if (isset($_POST['mode']) && $_POST['mode'] == "R") {
                        $fp_model = FilePartition::model()->findAllByAttributes(array('fp_file_id' => $model->ja_file_id), array('condition' => '(fp_category="M" or fp_category="N") and  fp_cat_id =0'));
                        $cnt = count($fp_model);
                        for ($i = 0; $i < $cnt; $i++) {
                            $fp_model[$i]->fp_status = "N";
                            $fp_model[$i]->save(false);
                        }
                    }
                    if ($model->ja_status == 'IA') {
                        $msg['msg'] = 'Allocated for indexing successfully';
                    } else if ($model->ja_status == 'SA') {
                        $msg['msg'] = 'Allocated for splitting successfully';
                    }
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                }
            }
            //if($model->save())
            //$this->redirect(array('view','id'=>$model->ja_job_id));
        }

        if (isset($_GET['id'])) {
            if ($_POST['status'] == 'IA') {
                $fl_model = FileInfo::model()->findByPK($_GET['id']);
            } else if ($_POST['status'] == 'SA') {
                $pt_model = FilePartition::model()->findByPK($_GET['id']);
                $fl_model = FileInfo::model()->findByPK($pt_model->fp_file_id);
            }
        }

        if (isset($_POST['status'])) {
            $jobstatus = $_POST['status'];
        }
        $this->renderPartial('_form', array(
            'model' => $model,
            'fl_model' => $fl_model,
            'pt_model' => $pt_model,
        ), false, true);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $pt_model = FilePartition::model()->findByPK($model->ja_partition_id);
        $fl_model = array();
        $jobstatus = '';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['JobAllocation'])) {
            $model->attributes = $_POST['JobAllocation'];
            if (!empty($model->ja_file_id)) {
                if ($model->ja_status == 'SA') {
                    $model->ja_reviewer_id = $model->user_id;
                } else if ($model->ja_status == 'IA') {
                    $model->ja_reviewer_id = $model->user_id;
                }
                $model->ja_qc_allocated_by = Yii::app()->session['user_id'];
                if ($model->save()) {
                    if ($model->ja_status == 'SA') {
                        $msg['msg'] = 'Reallocated for splitting successfully';
                    } else if ($model->ja_status == 'IA') {
                        $msg['msg'] = 'Reallocated for indexing successfully';
                    } else {
                        $msg['msg'] = 'Success';
                    }
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                }
            }
            //if($model->save())
            //$this->redirect(array('view','id'=>$model->ja_job_id));
        }
        if (isset($_POST['status'])) {
            $jobstatus = $_POST['status'];
        }
        $fl_model = FileInfo::model()->findByPK($model->ja_file_id);
        $this->renderPartial('_form', array(
            'model' => $model,
            'fl_model' => $fl_model,
            'pt_model' => $pt_model,
            'jobstatus' => $jobstatus,
        ), false, true);
    }

    public function actionReallocate($id) {
        $model = $this->loadModel($id);
        $dropdown = CHtml::listData(UserDetails::model()->findAll(array("condition" => "ud_usertype_id = 4")), 'ud_refid', 'ud_username');
        $model->scenario = 'reallocate';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-allocation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['JobAllocation'])) {
            $new_model = new JobAllocation;
            $model->ja_reviewer_id = $_POST['JobAllocation']['user_id'];
            $new_model->attributes = $model->attributes;
            $new_model->ja_file_id = $model->ja_file_id;
            if ($_POST['JobAllocation']['ja_status'] == 'IQ') {
                $new_model->ja_status = 'IA';
            } else if ($_POST['JobAllocation']['ja_status'] == 'SQ') {
                $new_model->ja_status = 'SA';
            }
            if ($new_model->save(false)) {
                if ($new_model->ja_status == 'IA') {
                    $filePartition = FilePartition::model()->findAll(array('condition' => "fp_job_id ='" . $model->ja_job_id . "' and fp_cat_id = 0 and (fp_category = 'M' or fp_category = 'N')"));
                } else if ($new_model->ja_status == 'SA') {
                    $filePartition = FilePartition::model()->findAll(array('condition' => "fp_job_id ='" . $model->ja_job_id . "' and fp_cat_id <> 0 and fp_category = ''"));
                }
                if ($filePartition) {
                    foreach ($filePartition as $fp) {
                        $fp->fp_job_id = $new_model->ja_job_id;
                        $fp->fp_status = 'N';
                        $fp->save(false);
                    }
                }
            }
            if ($new_model->save(false)) {
                $description = "File has been Reallocated";
                Yii::app()->Audit->writeAuditLog("Reallocate", "FilePage", $new_model->ja_job_id, $description);
                $msg['msg'] = 'Reallocated successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
        }
        $this->renderPartial('_realloc', array(
            'model' => $model,
            'dropdown' => $dropdown,
        ), false, true);
    }

    public function actionQualityupdate($id) {
        $model = $this->loadModel($id);
        $jobal=JobAllocation::model()->findByPk($id);
        $fileinfo=FileInfo::model()->findByPk($jobal->ja_file_id);
        if(isset($_POST['cat_ids']) && !empty($_POST['cat_ids'])) {
            $sortarr = $_POST['cat_ids'];
            $filemedinfo = implode(",", $sortarr);
            $fileinfo->fi_medinfo = $filemedinfo;
            $fileinfo->update("file_medinfo");
        }
        if ($_POST['status'] == "IQP") {
			if($model->ja_status == "IC"){
				$model->ja_status = "IQP";
				$model->ja_qc_id = Yii::app()->session['user_id'];
				$model->ja_qc_accepted_time = date('Y-m-d H:i:s');
				$model->ja_last_modified = date('Y-m-d H:i:s');
				if($jobal && $fileinfo )
                {
                    $fileinfo->fi_admin_lock="QL";
                    $fileinfo->update("fi_admin_lock");
                }
				if ($model->save(false)) {
					$msg['msg'] = 'Assigned to yourself successfully';
					$msg['status'] = 'S';
					echo json_encode($msg, true);
					die();
				}
			}
			else{
				$msg['msg'] = 'Sorry! someone else assigned';
				$msg['status'] = 'E';
				echo json_encode($msg, true);
				die();
			}
        } else if ($_POST['status'] == "SQP") {
			if($model->ja_status == "SC"){
				$model->ja_status = "SQP";
				$model->ja_qc_accepted_time = date('Y-m-d H:i:s');
				$model->ja_qc_id = Yii::app()->session['user_id'];
				$filemodel = FileInfo::model()->findByPk($model->ja_file_id);
				if ($filemodel->ProjectMaster->p_key_type == 'N') {
					$model->ja_med_status = "Q";
					$model->ja_nonmed_status = "Q";
				}
                $model->ja_last_modified = date('Y-m-d H:i:s');
                if($jobal && $fileinfo )
                {
                    $fileinfo->fi_admin_lock="QL";
                    $fileinfo->update("fi_admin_lock");
                }
				if ($model->save(false)) {
					$msg['msg'] = 'Assigned to yourself successfully';
					$msg['status'] = 'S';
					echo json_encode($msg, true);
					die();
				}
			}
			else{
				$msg['msg'] = 'Sorry! someone else assigned';
				$msg['status'] = 'E';
				echo json_encode($msg, true);
				die();
			}
        } else if ($_POST['status'] == "IQC") {
            $model->ja_status = "QC";
            $status = FileinfoController::actionCheckqualitystatus("", "I", $model->ja_job_id, true);

//			$fp_model = FilePartition::model()->findByAttributes(array('fp_file_id' => $model->ja_file_id,'fp_category' => 'M','fp_cat_id' => 0));;
//			$fp_model->fp_status = "I";
            if($jobal && $fileinfo )
            {
                $fileinfo->fi_admin_lock="O";
                $fileinfo->update("fi_admin_lock");
            }
            if ($status) {
				$description = "File has been completed";
				Yii::app()->Audit->writeAuditLog("Complete", "Prepping QC", $model->ja_job_id, $description);
//				$fp_model->save(false);
                $msg['msg'] = 'Moved to splitting';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
        } else if ($_POST['status'] == "SQC") {
			$ja_id = $model->ja_job_id;
            $filefinmodel = FileInfo::model()->findByPk($model->ja_file_id);
            if ($filefinmodel->ProjectMaster->p_key_type == 'N') {
                $model->ja_med_status = "C";
                $model->ja_nonmed_status = "C";
            }
            $model->ja_status = "QC";
            $model->ja_qc_completed_time = date('Y-m-d H:i:s');
            if($jobal && $fileinfo )
            {
                $fileinfo->fi_admin_lock="O";
                $fileinfo->update("fi_admin_lock");
            }
            $fp_model = FilePartition::model()->findAllByAttributes(array('fp_file_id' => $model->ja_file_id), array('condition' => 'fp_category="" and  fp_cat_id!=""'));;
            $cnt = count($fp_model);
            for ($i = 0; $i < $cnt; $i++) {
                $fp_model[$i]->fp_status = "S";
                $fp_model[$i]->save(false);
            }
            $model->ja_last_modified = date('Y-m-d H:i:s');
            if ($model->save(false)) {
                //add total filelinecount
                $getProId = FileInfo::model()->findByPk($model->ja_file_id);
                $project = $getProId->fi_pjt_id . "_breakfile";
                $file_id = $model->ja_file_id;
                $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
                if (file_exists($filename)) {
                    $fileCntArr = array();
                    $record = array();
                    $i = 1;
                    foreach (file($filename) as $fileRow) {
                        $fileRow = str_replace(PHP_EOL, '', $fileRow);
                        $rowsArr = explode("|", $fileRow);
                        if (!empty($rowsArr[10]) && $rowsArr[10] == 'M') {
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
                //add total filelinecount end
				$description = "File has been completed";
				Yii::app()->Audit->writeAuditLog("Complete", "Datecoding QC", $ja_id, $description);
				$check_skip_ed = Project::model()->findByPk($filefinmodel->fi_pjt_id);
				if($check_skip_ed->skip_edit == 1){
					$ed_model = new JobAllocation();
					$ed_model->ja_file_id = $filefinmodel->fi_file_id;
					$ed_model->ja_status = "QEC";
					$ed_model->save(false);

					$msg['msg'] = 'File completed Succesfully';
					$msg['status'] = 'S';
					echo json_encode($msg, true);
					die();
				}
				else{
					$msg['msg'] = 'Moved to Editing';
					$msg['status'] = 'S';
					echo json_encode($msg, true);
					die();
				}
            }
        }
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
        $dataProvider = new CActiveDataProvider('JobAllocation');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new JobAllocation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['JobAllocation']))
            $model->attributes = $_GET['JobAllocation'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return JobAllocation the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = JobAllocation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param JobAllocation $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-allocation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionProcessswap($id) {
        $model = $this->loadModel($id);
        $partStatus = "";
        $partCond = "";
        $jobStatus = "";

        $model->scenario = 'processSwap';
        if (isset($_POST['JobAllocation'])) {
            //new condition
            $fp_flag = "";
            $ja_flag = "";
            $fp_status = "";

            switch ($_POST['JobAllocation']['ja_status']) {
                case "N": //new file
                    $toProcess = "N";
                    $fp_flag = "R";
                    $ja_flag = "R";
                    break;
                case "IA": //init prepping
                    $toProcess = "IA";
                    $fp_flag = "R";
                    break;
                case "IC": //complete prepping
                    $toProcess = "IC";
                    $fp_status = "I";
                    break;
                case "SA": //init split
                    $toProcess = "SA";
                    break;
                case "SQC": // Complete split quality
                    $toProcess = "QC";
                    $fp_flag = "I";
                    break;
                case "RPQ": //Reallocate prepping quality
                    $toProcess = "RPQ";
                    $fp_status = "N";
                    $ja_flag = "IC";
                    break;
                case "RSQ": //Reallocate split quality
                    $toProcess = "SC";
                    $ja_flag = "SC";
                    break;
				case "IE": //Init editing
                    $toProcess = "IE";
                    break;	
				case "EC": //Reallocate edit quality
                    $toProcess = "EC";
                    break;	
                case "QEC": //Complete
                    $toProcess = "QEC";
                    break;
            }

            JoballocationController::actionChangeprocess($model, $id, $toProcess, $fp_flag, $ja_flag, $fp_status);
            //new condition end
        }
        $this->renderPartial('processswap', array(
            'model' => $model
        ), false, true);
    }

    //Changeprocess
    public static function actionChangeprocess($model, $jobId, $toProcess, $fp_flag = "", $ja_flag = "", $fp_status) {
        $processnow = "";
		$curstatus = $model->ja_status;
		$withdata = 1;
        if (isset($_POST['withdata'])) {
            $withdata = $_POST['withdata'];
        }
        /*if (($toProcess != "QEC") && ($model->ja_status == "QEC" || $model->ja_status == "QEA" || $model->ja_status == "EC" || $model->ja_status == "EA")) {
            $model->ja_flag = "R";
            $model->save();
        }*/
		if($model->ja_status == "EA" || ($model->ja_status == "EC" && $toProcess != "IE" && $toProcess != "QEC") || ($model->ja_status == "QEA" && $toProcess != "IE" && $toProcess != "QEC") || ($model->ja_status == "QEC" && $toProcess != "IE" && $toProcess != "EC")){
			$jafileid = $model->ja_file_id;
			$model->ja_flag = "R";
            $model->save();
			$model = JobAllocation::model()->find(array("condition" => "ja_file_id = " . $jafileid . " and ja_status = 'QC' and ja_partition_id <> 0 and ja_flag = 'A'"));
		}
        if ($toProcess == "N" || $toProcess == "IA" || $toProcess == "IC" || $toProcess == "SA") {
            if ($toProcess != "SA" || $withdata != 1) {
                // To delete the breakfiles on process back
                JoballocationController::actionDeletepartition($model->ja_file_id);
                //to delete feedback on process back
            }
            if ($toProcess == "IA") {
				if(isset($_POST['JobAllocation']['revchk']) && $_POST['JobAllocation']['revchk'] == 1){
					$jbc_model = JobAllocation::model()->findByPk($jobId);
					$jbsts = "";
					if ($jbc_model->ja_status == 'IC' || $jbc_model->ja_status == 'IQP') {
						$jbsts = "SA";
					}
					else{
						$jbsts = "QC";
					}
					$jbo_model = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $jbc_model->ja_file_id . " and ja_status = '". $jbsts ."' and ja_partition_id = 0 and ja_flag = 'A'"));
					
					$djbc_model = new JobAllocation();
					foreach($jbc_model->attributes as $keyjbc => $jbc){
						if($keyjbc != 'ja_job_id'){
							$djbc_model->$keyjbc = $jbc;
						}
					}
					
					$djbo_model = new JobAllocation();
					foreach($jbo_model->attributes as $keyjbo => $jbo){
						if($keyjbo != 'ja_job_id'){
							$djbo_model->$keyjbo = $jbo;
						}
					}
					if ($jbc_model->ja_status == 'IC' || $jbc_model->ja_status == 'IQP') {
						$djbc_model->ja_reviewer_id = $_POST['JobAllocation']['review'];
						$djbc_model->save();
						$djbo_model->save();
					}
					else{
						$djbo_model->ja_reviewer_id = $_POST['JobAllocation']['review'];
						$djbo_model->save();
						$djbc_model->save();
					}
					$jbc_model->ja_flag = "R";
					$jbo_model->ja_flag = "R";
					$jbc_model->save();
					$jbo_model->save();
					
					$jobmodel = JobAllocation::model()->findByPk($djbc_model->ja_job_id);
				}
				else{
						$jobmodel = JobAllocation::model()->findByPk($jobId);
				}
                //$jobmodel = JobAllocation::model()->findByPk($jobId);
                //$minId = Yii::app()->db->createCommand("SELECT min(ja_job_id) as minid FROM  job_allocation_ja where ja_flag = 'A' and ja_file_id =" . $jobmodel->ja_file_id)->queryScalar();
                //$model = JobAllocation::model()->findByPk($minId);
                if ($jobmodel->ja_status == 'IC' || $jobmodel->ja_status == 'IQP') {
                    $model = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $jobmodel->ja_file_id . " and ja_status = '" . $jobmodel->ja_status . "' and ja_flag = 'A'"));
                } else {
                    $jobmodel->ja_status = 'SA';
                    $jobmodel->ja_partition_id = 0;
                    $jobmodel->ja_npartition_id = 0;
                    $jobmodel->ja_qc_id = 0;
                    $jobmodel->ja_med_status = "C";
                    $jobmodel->ja_nonmed_status = "C";
                    $jobmodel->ja_qc_feedback = "";
                    $jobmodel->save();
                    $model = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $jobmodel->ja_file_id . " and ja_status = 'QC' and ja_flag = 'A'"));
                }
                $model->ja_qc_id = 0;
                $model->ja_qc_feedback = "";
                $toProcess == "IA";
            } else if ($toProcess == "N") {
                $criteria = new CDbCriteria;
                $criteria->addCondition("ja_file_id = " . $model->ja_file_id);
                //$job = JobAllocation::model()->updateAll(array('ja_flag' => $ja_flag), $criteria);
                $job = JobAllocation::model()->updateAll(array('ja_flag' => $ja_flag, 'ja_med_status' => 'C', 'ja_nonmed_status' => 'C'), $criteria);
				$file_info_model = FileInfo::model()->findByPk($model->ja_file_id);
				$file_info_model->fi_template_id=0;
				$file_info_model->fi_prep = 0;
				$file_info_model->save();
			} else if ($toProcess == "IC") {
                $filePartModel = FilePartition::model()->find(array('condition' => "fp_file_id =" . $model->ja_file_id . " and fp_category = 'M' and fp_flag = 'A'"));
                $fileNonPartModel = FilePartition::model()->find(array('condition' => "fp_file_id =" . $model->ja_file_id . " and fp_category = 'N' and fp_flag = 'A'"));
                //$maxId = Yii::app()->db->createCommand("SELECT max(ja_job_id) as maxid FROM  job_allocation_ja where ja_flag = 'A' and ja_file_id =" . $model->ja_file_id)->queryScalar();
                //$maxModel = JobAllocation::model()->findByPk($maxId);
                $maxModel = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $model->ja_file_id . " and ja_status = 'SA' and ja_flag = 'A'"));
                $maxModel->ja_partition_id = $filePartModel->fp_part_id;
                $maxModel->ja_npartition_id = $fileNonPartModel->fp_part_id;

                $filemodel = FileInfo::model()->findByPk($maxModel->ja_file_id);
                if ($filemodel->ProjectMaster->p_key_type == 'N') {
                    $maxModel->ja_med_status = "R";
                    $maxModel->ja_nonmed_status = "R";
                }

                $maxModel->save();

                $toProcess = "QC";
            } else if ($toProcess == "SA") {
				if(isset($_POST['JobAllocation']['revchk']) && $_POST['JobAllocation']['revchk'] == 1){
					$newmodel = new JobAllocation();
					foreach($model->attributes as $keyjob => $job){
						if($keyjob != 'ja_job_id'){
							$newmodel->$keyjob = $job;
						}
					}
					$newmodel->save();
					$lastins_id =Yii::app()->db->getLastInsertID();
					$model->ja_flag = "R";
					$model->save();
					$model = JobAllocation::model()->findByPk($lastins_id);
					$model->ja_reviewer_id = $_POST['JobAllocation']['review'];
				}
                $jobStatus = "SA";
                $model->ja_qc_feedback = '';

                $filemodel = FileInfo::model()->findByPk($model->ja_file_id);
                if ($filemodel->ProjectMaster->p_key_type == 'N') {
                    $model->ja_med_status = "R";
                    $model->ja_nonmed_status = "R";
                }

            }
            if (!empty($fp_flag) || !empty($fp_status)) {
                $criteria1 = new CDbCriteria;
                $criteria1->addCondition("fp_file_id = " . $model->ja_file_id);
                $criteria1->addCondition("fp_flag='A'");
                if (!empty($fp_status)) {
                    $filePart = FilePartition::model()->updateAll(array('fp_status' => $fp_status), $criteria1);
                } else {
                    if ($toProcess == "IA" && $withdata == 1) {
                        $filePart = FilePartition::model()->updateAll(array('fp_status' => 'N'), $criteria1);
                    } else {
                        $filePart = FilePartition::model()->updateAll(array('fp_flag' => $fp_flag), $criteria1);
                    }
                }
            }
            if ($toProcess == "N") {
				$file_unlock = FileInfo::model()->findByPk($model->ja_file_id);
				$file_unlock->fi_admin_lock = "O";
				$file_unlock->save();
                $msg['msg'] = 'Process Changed successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            }
        } else if ($toProcess == "SQC" || $toProcess == "RPQ") {
            $jobStatus = "QC";
            if ($toProcess == "RPQ") {
                //$jobmodel = JobAllocation::model()->findByPk($jobId);
                //$minId = Yii::app()->db->createCommand("SELECT min(ja_job_id) as minid FROM  job_allocation_ja where ja_flag = 'A' and ja_file_id =" . $jobmodel->ja_file_id)->queryScalar();
                //$minJobStatus = JobAllocation::model()->findByPk($minId);
                JoballocationController::actionDeletepartition($model->ja_file_id);
                $minJobStatus = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $model->ja_file_id . " and ja_status = 'QC' and ja_partition_id = 0 and ja_flag = 'A'"));
                $minJobStatus->ja_qc_id = 0;
				$minJobStatus->ja_status = "IC";
                $minJobStatus->save();
                $toProcess = "SA";
                $model->ja_qc_id = 0;
                $model->ja_partition_id = 0;
                $model->ja_npartition_id = 0;
                $model->ja_med_status = "C";
                $model->ja_nonmed_status = "C";
                $model->ja_qc_feedback = '';
            }
            $criteria = new CDbCriteria;
            $criteria->addCondition("fp_file_id = " . $model->ja_file_id);
            $criteria->addCondition("fp_flag='A'");
            $filePart = FilePartition::model()->updateAll(array('fp_status' => $fp_status), $criteria);
        } else if ($toProcess == "RSQ") {
            // $jobmodel = JobAllocation::model()->findByPk($jobId);
            // $maxId = Yii::app()->db->createCommand("SELECT max(ja_job_id) as maxid FROM  job_allocation_ja where ja_flag = 'A' and ja_file_id =" . $jobmodel->ja_file_id)->queryScalar();
            // $maxJobStatus = JobAllocation::model()->findByPk($maxId);
            $maxJobStatus = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $model->ja_file_id . " and ja_status = 'QC' and ja_partition_id <> 0 and ja_flag = 'A'"));
            $maxJobStatus->ja_status = "SC";
            $maxJobStatus->ja_med_status = "C";
            $maxJobStatus->ja_nonmed_status = "C";
            $maxJobStatus->save();
        } else if ($toProcess == "RSQ") {
            $maxJobStatus = JobAllocation::model()->find(array('condition' => " ja_file_id = " . $model->ja_file_id . " and ja_status = 'EC' and ja_partition_id = 0 and ja_flag = 'A'"));
            $maxJobStatus->ja_status = $toProcess;
            $maxJobStatus->save();
        } else if ($toProcess == "SC" || $toProcess == "QC") {
            if (($toProcess == "SC" && $model->ja_status == 'QC') || ($toProcess == "QC" && $model->ja_status == 'SQP')) {
                $model->ja_med_status = "C";
                $model->ja_nonmed_status = "C";
            }
			if($toProcess == "SC"){
				$model->ja_qc_id = 0;
			}
			if($toProcess == "QC"){
				$fileskip_ed = FileInfo::model()->findByPk($model->ja_file_id);
				$check_skip_edt = Project::model()->findByPk($fileskip_ed->fi_pjt_id);
				if($check_skip_edt->skip_edit == 1){
					$edt_model = new JobAllocation();
					$edt_model->ja_file_id = $model->ja_file_id;
					$edt_model->ja_status = "QEC";
					$edt_model->save(false);
				}
			}
        } else if ($toProcess == "IE"){
			$model->ja_flag = "R";
			$processnow = $toProcess;
			$toProcess = $model->ja_status;
		}
		else if($toProcess == "EC"){
			$model->ja_qc_id = 0;
		}
        $model->ja_status = $toProcess;
        //add total filelinecount
        $getProId = FileInfo::model()->findByPk($model->ja_file_id);
        $project = $getProId->fi_pjt_id . "_breakfile";
        $file_id = $model->ja_file_id;
		$filarr = array();
        $filename = Yii::app()->basePath . "/../filepartition/" . $project . '/' . $file_id . ".txt";
        if (file_exists($filename)) {
            $fileCntArr = array();
            $record = array();
            $i = 1;
			
			//if($processnow == "IE" && $withdata != 1){
			if((($processnow == "IE" && $withdata != 1) || $toProcess == "SQP" || $toProcess == "SC" || ($toProcess == "SA" && $withdata == 1)) && ($curstatus == "EA" || $curstatus == "EC" || $curstatus == "QEA" || $curstatus == "QEC")){
				$xra = JobAllocation::LoadData($filename);
				for($y = 0; $y < count($xra); $y++) {
					$xra[$y] = implode('|', $xra[$y]).PHP_EOL;
				}
				$filarr = $xra;
			}
			else{
				$filarr = file($filename);
			}
			
            foreach ($filarr as $fileRow) { 
                if ($toProcess == "SA" && $withdata == 1) {
                    $fileRow = str_replace(PHP_EOL, '', $fileRow);
                }
                $rowsArr = explode("|", $fileRow);
                if (!empty($rowsArr[10]) && $rowsArr[10] == 'M') {
                    $fileCntArr[] = $fileRow;
                }
				if(($processnow == "IE" || $toProcess == "SQP" || $toProcess == "SC" || ($toProcess == "SA" && $withdata == 1)) && ($curstatus == "EA" || $curstatus == "EC" || $curstatus == "QEA" || $curstatus == "QEC")){
					if (isset($rowsArr[14]) || isset($rowsArr[15]) || isset($rowsArr[13])) {
						if(isset($rowsArr[14])){
							$rowsArr[14] = '';
						}
						if($processnow != "IE" || $withdata != 1){
							if(isset($rowsArr[15])){
								$rowsArr[15] = '';
							}
						}
						if($toProcess == "SA"){
							if(isset($rowsArr[13])){
								$rowsArr[13] = '';
							}
						}
						$str = implode('|', $rowsArr);
						$record[] = $str . PHP_EOL;
					} 
					else {
						$record[] = $fileRow . PHP_EOL;
					}
				}
                else if($toProcess == "SA" && $withdata == 1 && $curstatus != "EA" && $curstatus != "EC" && $curstatus != "QEA" && $curstatus != "QEC"){
                    if (isset($rowsArr[13])) {
                        $rowsArr[13] = '';
                        $str = implode('|', $rowsArr);
                        $record[] = $str . PHP_EOL;
                    } else {
                        $record[] = $fileRow . PHP_EOL;
                    }
                } 
				else {
                    $record[] = $fileRow;
                }
                $i++;
            }
            file_put_contents($filename, implode("", $record));
            $getProId->file_linecnt_fi = count($fileCntArr);
//            $updfilecnt = FilePartition::model()->findByPk($model->ja_partition_id);
//            $updfilecnt->file_linecnt_fp = $getFileCnt;
            $getProId->save();
        } else {
            $getProId->file_linecnt_fi = 0;
            $getProId->save();
        }
        //add total filelinecount end
        if ($model->save()) {
			$file_unlock = FileInfo::model()->findByPk($model->ja_file_id);
			$file_unlock->fi_admin_lock = "O";
			$file_unlock->save();
            $msg['msg'] = 'Process Changed successfuly';
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
    }

    public static function actionDeletepartition($delt_file_id) {
        $fileinfo_model = FileInfo::model()->findByPk($delt_file_id);
        $pjt_id = $fileinfo_model->fi_pjt_id;
        $delt_project = $pjt_id . "_breakfile";
        $delt_filename = Yii::app()->basePath . "/../filepartition/" . $delt_project . '/' . $delt_file_id . ".txt";
        if (file_exists($delt_filename)) {
            unlink($delt_filename);
        }
    }

    public function actionAdminrealloc($id) {
        $model = new JobAllocation();
        $model->scenario = 'quitProcess';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-quit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['JobAllocation'])) {
            $model->attributes = $_POST['JobAllocation'];
            $allocmodel = JobAllocation::model()->findByPk($id);
           /* if(($allocmodel->ja_status=="SA" || $allocmodel->ja_status=="IA" ) && $allocmodel->ja_qc_id==0 &&(Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") )
            {
                $fileinfomodel=FileInfo::model()->findByPk($allocmodel->ja_file_id);
                if($fileinfomodel->fi_admin_lock =="L")
                {
                    $fileinfomodel->fi_admin_lock="O";
                    $fileinfomodel->update('fi_admin_lock');
                }
            } */
            if ($allocmodel->ja_status == 'IA') {
                $allocmodel->ja_status = 'IQ';
            } else if ($allocmodel->ja_status == 'SA') {
                $allocmodel->ja_status = 'SQ';
            }
            if ($allocmodel->save(false)) {
				$file_unlock = FileInfo::model()->findByPk($allocmodel->ja_file_id);
				$file_unlock->fi_admin_lock = "O";
				$file_unlock->save();
                $flag = $this->quitreallocate($_POST['JobAllocation']['option'], $id);
                if ($flag) {
                    $description = "File has been Reallocated";
                    Yii::app()->Audit->writeAuditLog("Reallocate", "FilePage", $flag, $description);
                    $msg['msg'] = 'Reallocated successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                }
            }
        }

        $this->renderPartial('adminrealloc', array(
            'model' => $model, 'id' => $id
        ), false, true);
    }

    /**
     * @param $id
     * @throws CException
     * @Quit Process
     */
    public function actionQuitprocess($id) {
        $model = new JobAllocation();
        $model->scenario = 'quitProcess';
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'job-quit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['JobAllocation'])) {
            if ($_POST['JobAllocation']['quit_process'] == 'R') {
                $model->attributes = $_POST['JobAllocation'];
                $flag = $this->quitreallocate($_POST['JobAllocation']['option'], $id);
                if ($flag) {
                    $description = "File has been Reallocated";
                    Yii::app()->Audit->writeAuditLog("Reallocate", "FilePage", $flag, $description);
                    $msg['msg'] = 'Reallocated successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                }
            } elseif ($_POST['JobAllocation']['quit_process'] == 'B') {
                $model = $this->loadModel($id);
                if ($model->ja_status == 'IQ') {
                    $model->ja_status = 'IC';
                } else if ($model->ja_status == 'SQ') {
                    $model->ja_status = 'SC';
                }
                $model->ja_reason = '';
                $model->save();
                //$model->attributes = $_POST['JobAllocation'];
                $fp_flag = "";
                $ja_flag = "";
                $fp_status = "";
                switch ($_POST['JobAllocation']['option']) {
                    case "N": //new file
                        $toProcess = "N";
                        $fp_flag = "R";
                        $ja_flag = "R";
                        break;
                    case "IA": //init prepping
                        $toProcess = "IA";
                        $fp_flag = "R";
                        break;
                    case "IC": //complete prepping
                        $toProcess = "IC";
                        $fp_status = "I";
                        break;
                    case "SA": //init split
                        $toProcess = "SA";
                        break;
                    case "SQC": // Complete split quality
                        $toProcess = "QC";
                        $fp_flag = "I";
                        break;
                    case "RPQ": //Reallocate prepping quality
                        $toProcess = "RPQ";
                        $fp_status = "N";
                        $ja_flag = "IC";
                        break;
                    case "RSQ": //Reallocate split quality
                        $toProcess = "SC";
                        $ja_flag = "SC";
                        break;
                }
                JoballocationController::actionChangeprocess($model, $id, $toProcess, $fp_flag, $ja_flag, $fp_status);
            }
        }

        $this->renderPartial('quitprocess', array(
            'model' => $model, 'id' => $id
        ), false, true);
    }

    /**
     * @Reallocate Function
     */
    public static function quitreallocate($option, $job_id) {
        $model = new JobAllocation();
        $updatemodel = JobAllocation::model()->findByPk($job_id);
        $model->attributes = $updatemodel->attributes;
        $model->ja_reviewer_id = $option;
        $model->ja_reviewer_allocated_time = date('Y-m-d H:i:s');
        $model->ja_file_id = $updatemodel->ja_file_id;
        $model->ja_med_status = $updatemodel->ja_med_status;
        $model->ja_nonmed_status = $updatemodel->ja_nonmed_status;
        $model->ja_npartition_id = $updatemodel->ja_npartition_id;
        if ($updatemodel->ja_status == 'IQ') {
            $model->ja_status = 'IA';
        } else if ($updatemodel->ja_status == 'SQ') {
            $model->ja_status = 'SA';
        }
        $flag_id = '';
        if ($model->save(false)) {
            $flag_id = $model->ja_job_id;
            $filePartition = '';
            if ($model->ja_status == 'IA') {
                $filePartition = FilePartition::model()->findAll(array('condition' => "fp_job_id ='" . $updatemodel->ja_job_id . "' and fp_cat_id = 0 and (fp_category = 'M' or fp_category = 'N')"));
            } else if ($model->ja_status == 'SA') {
                $filePartition = FilePartition::model()->findAll(array('condition' => "fp_job_id ='" . $updatemodel->ja_job_id . "' and fp_cat_id <> 0 and fp_category = ''"));
            }
            if ($filePartition) {
                foreach ($filePartition as $fp) {
                    $fp->fp_job_id = $model->ja_job_id;
                    $fp->fp_status = 'N';
                    $fp->save(false);
                }
            }
        }
        return $flag_id;
    }

    /**
     * @Add FeedBack Form
     */
    public function actionFeedback() {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $model = JobAllocation::model()->findByPk($id);
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'file-partition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['JobAllocation'])) {
            $model->attributes = $_POST['JobAllocation'];
            if ($_POST['JobAllocation']['ja_qc_feedback']) {
                $model->ja_qc_feedback = $_POST['JobAllocation']['ja_qc_feedback'];
                $model->save();
                $msg['msg'] = 'Feedback Added successfuly';
            } else {
                $msg['msg'] = 'Feedback Not Added';
            }
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
        $this->renderPartial('feedback', array('model' => $model), false, true
        );
    }

    public function actionBackprocess() {
        $model = JobAllocation::model()->findByPk($_POST['jobid']);
        $model->ja_flag = 'R';
        if ($model->save()) {
            $msg['msg'] = 'Ready for editing';
            $msg['status'] = 'S';
            echo json_encode($msg, true);
            die();
        }
    }

}
