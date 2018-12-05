<?php

class UserdetailsController extends RController {

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
            //'accessControl', // perform access control for CRUD operations
            //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//    public function accessRules() {
//        return array(
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update'),
//                'users' => array('@'),
//            ),
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('admin', 'delete'),
//                'users' => array('admin'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
//        );
//    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = UserDetails::model()->with('UserType')->find(array("condition" => "ud_refid = $id"));
        $condition = "";
        if ($model['UserType']->ut_usertype == "R") {
            $condition = " where ja_reviewer_id = $id ";
        } else if ($model['UserType']->ut_usertype == "QC") {
            $condition = " where ja_qc_id = $id ";
        }

        $query = "select * from  job_allocation_ja inner join  file_info_fi on job_allocation_ja.ja_file_id = file_info_fi.fi_file_id $condition order by ja_created_date desc limit 5";
        $activity = Yii::app()->db->createCommand($query)->queryAll();
        $this->renderPartial('view', array(
            'model' => $model,
            'activity' => $activity,
        ), false, true);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new UserDetails;
        $model->scenario = 'create';
        //Set scenario
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            $pincode = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $model->ud_ipin=$pincode;
            $model->ud_password = md5($_POST['UserDetails']['ud_password']);
            if($_POST['UserDetails']['ud_usertype_id'] !=3 && $_POST['UserDetails']['ud_usertype_id'] !=2 ) {
                $projectCat = array();
                $subjects = json_decode($_POST['categories']);
                foreach ($_POST['project'] as $key => $value) {
                    $projectCat[$_POST['project'][$key]] = implode(',', $subjects[$key]);
                }
                if (isset($_POST['UserDetails']['ud_teamlead_id'])) {
                    $model->ud_teamlead_id = $_POST['UserDetails']['ud_teamlead_id'];
                }
                $model->ud_cat_id = json_encode($projectCat);
            }
            else{
                $projectCat = array();
                foreach ($_POST['project'] as $key => $value) {
                    $projectCat[$_POST['project'][$key]] = "";
                }
                if (isset($_POST['UserDetails']['ud_teamlead_id'])) {
                    $model->ud_teamlead_id = $_POST['UserDetails']['ud_teamlead_id'];
                }
                $model->ud_cat_id = json_encode($projectCat);
            }
            if ($model->save(false)) {

                $msg['msg'] = 'Your account created successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                $userType = UserType::model()->findByPk($model->ud_usertype_id);
                $userType = $userType->ut_name;
                $model->getPermission($model->ud_refid, $userType); // User Reference Id, User Type
                $description = $model->ud_name . "has been added";
                Yii::app()->Audit->writeAuditLog("Add", "userdetails", $model->ud_refid, $description);
                die();
            }
        }
        $this->renderPartial('_form', array(
            'model' => $model
        ), false, true);
    }

    /**
     * Creates a new model for client.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionClientcreate() {
        $model = new UserDetails;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $client = new ClientDetails;
        $model->scenario = "passCheck";
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            $pincode = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $model->ud_ipin=$pincode;
            $model->ud_password = md5($model->newPassword);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    $client->cd_user_id = $model->ud_refid;
                    $flag = $client->save(false);
                }
                if ($flag) {
                    $transaction->commit();
                    $msg['msg'] = 'Your account created successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    $userType = UserType::model()->findByPk($model->ud_usertype_id);
                    $userType = $userType->ut_name;
                    $model->getPermission($model->ud_refid, $userType); // User Reference Id, User Type
                    $description = $model->ud_name . "has been added";
                    Yii::app()->Audit->writeAuditLog("Add", "userdetails", $model->ud_refid, $description);
                    die();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        $this->renderPartial('admin_form', array(
            'model' => $model,
        ));
    }

    public function actionSignup() {
        $this->layout = "site_layout_content";
        $model = new UserDetails;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $client = new ClientDetails;
        $model->scenario = "passCheck";
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            $pincode = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $model->ud_ipin=$pincode;
            $model->ud_usertype_id = 5;
            if ($model->save()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $client->cd_user_id = $model->ud_refid;
                        $flag = $client->save(false);
                    }
                    if ($flag) {
                        $transaction->commit();
                        $subject = "KPWS - Registration";
                        $details = array();
                        $details["action"] = "userDetails/signup";
                        $details['link'] = Yii::app()->getBaseUrl(TRUE) . "/userdetails/userregupdate/" . $model->ud_refid;
                        $details["name"] = $model->ud_username;
                        $message = $this->renderPartial("/site/email", array("details" => $details), true);

                        $sendEmail = SiteController::actionSendmail($model->ud_email, $subject, $message);


                        $userType = UserType::model()->findByPk(5);
                        $userType = $userType->ut_name;
                        $model->getPermission($model->ud_refid, $userType); // User Reference Id, User Type
                        $description = $model->ud_name . "has been added";
                        Yii::app()->Audit->writeAuditLog("Add", "userdetails", $model->ud_refid, $description);
                        $msg['msg'] = 'Your account created successfuly';
                        $msg['status'] = 'S';
                        echo json_encode($msg, true);
                        die();
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        $this->render('signup', array(
            'model' => $model,
            'client' => $client,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            $model->ud_ipin=$_POST['UserDetails']['ud_ipin'];
            if(isset($_POST['editpass'])){
                $model->ud_password = md5($_POST['UserDetails']['ud_password']);
            }
            else{
                $model->ud_password = $_POST['UserDetails']['ud_password'];
            }
            $projectCat = array();
            if (!empty($_POST['categories']) && !is_null($_POST['categories'])) {
                $subjects = json_decode($_POST['categories']);
                foreach ($_POST['project'] as $key => $value) {
                    $projectCat[$_POST['project'][$key]] = implode(',', $subjects[$key]);
                }
            } else {
                if (isset($_POST['project'])) {
                    foreach ($_POST['project'] as $key => $value) {
                        $projectCat[$_POST['project'][$key]] = "";
                    }
                }
            }

            $model->ud_cat_id = json_encode($projectCat);
            if ($model->save(false)) {
                $description = $model->ud_name . "has been updated";
                Yii::app()->Audit->writeAuditLog("Update", "userdetails", $model->ud_refid, $description);
                $msg['msg'] = 'User details updated successfuly';
                $msg['status'] = 'S';
                echo json_encode($msg, true);
                die();
            } else {
                echo "<pre>";
                print_r($model);
                die();
            }
        }

        $model->category = explode(',', $model->ud_cat_id);

        $this->renderPartial('_form', array(
            'model' => $model,
        ), false, true);
    }

    //Updates a particular model for client profile.
    public function actionProfileupdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'ccreate';
        /* if ($model->ud_usertype_id == '5') {
          $client = ClientDetails::model()->findByAttributes(array('cd_user_id' => $id));
          } */
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            if(isset($_POST['md5password'])=='1' && !empty($_POST['md5password']))
            {
                $model->ud_password = md5($_POST['UserDetails']['newPassword']);
            }
            else
            {
                if(isset($_POST['editpass'])){
                    $model->ud_password = md5($_POST['UserDetails']['newPassword']);
                }
                else{
                    $model->ud_password = $_POST['UserDetails']['newPassword'];
                }
            }
            //$client->attributes = $_POST['ClientDetails'];
            $uploadedFile = CUploadedFile::getInstance($model, 'ud_picture');
            if (!empty($uploadedFile->extensionName)) {
                $model->ud_picture = $model->ud_refid . '.' . $uploadedFile->extensionName;
            }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    if (!empty($uploadedFile)) {
                        $uploadedFile->saveAs(Yii::app()->basePath . '/../images/profile/' . $model->ud_picture);
                    }
                    //$flag = $client->save(false);
                }
                if ($flag && Yii::app()->session['user_status'] != "A") {
                    Yii::app()->session['user_status'] = "A";
                    $transaction->commit();
                    $description = $model->ud_name . "has been updated";
                    Yii::app()->Audit->writeAuditLog("Update", "userdetails", $model->ud_refid, $description);
                    $msg['msg'] = 'Your Profile details updated successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                } else if (Yii::app()->session['user_status'] == "A") {
                    $transaction->commit();
                    $description = $model->ud_name . "has been updated";
                    Yii::app()->Audit->writeAuditLog("Update", "userdetails", $model->ud_refid, $description);
                    $msg['msg'] = 'Your Profile details updated successfuly';
                    $msg['status'] = 'A';
                    echo json_encode($msg, true);
                    die();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        $this->render('admin_form', array(
            'model' => $model,
        ), false, true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if($model->ud_flag=="A")
        {
            $model->ud_flag = "R";
        }
        else if($model->ud_flag=="R")
        {
            $model->ud_flag = "A";
        }
        $model->save(false);
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('UserDetails');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->session['user_type'] == 'TL') {
            $_GET['teamlead'] = Yii::app()->user->getId();
        }
        $model = new UserDetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserDetails']))
            $model->attributes = $_GET['UserDetails'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserDetails the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === 'user-details-form' || $_POST['ajax'] === "profile-form")) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUserregupdate($id) {
        $model = UserDetails::model()->findByPk($id);
        $model->scenario = 'ccreate';
        $this->performAjaxValidation($model);
        Yii::app()->session['user_id'] = $id;
        if ($model->ud_status != "A") {
            $this->layout = "blankcolumn";
        }
        $this->render('admin_form', array(
            'model' => $model,
        ));
    }

    /**
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    //Creates client from Admin panel.
    public function actionCreateclient() {
        $model = new UserDetails;
        $model->scenario = 'ccreate';
        // $client = new ClientDetails;
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];
            $pincode = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $model->ud_ipin=$pincode;
            $model->ud_password = md5($_POST['UserDetails']['ud_password']);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    // $client->attributes = $_POST['ClientDetails'];
                    //$client->cd_user_id = $model->ud_refid;
                    //$flag = $client->save(false);
                }
                if ($flag) {
                    $transaction->commit();
                    $msg['msg'] = 'Your account created successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    $userType = UserType::model()->findByPk($model->ud_usertype_id);
                    $userTypename = $userType->ut_name;
                    $model->getPermission($model->ud_refid, $userTypename); // User Reference Id, User Type
                    $description = $model->ud_name . "has been added";
                    Yii::app()->Audit->writeAuditLog("Add", "userdetails", $model->ud_refid, $description);
                    die();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        $this->renderPartial('_clientform', array(
            'model' => $model
        ), false, true);
    }

    /**
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    //Updates a client from admin panel.
    public function actionUpdateclient($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'ccreate';
        /* if ($model->ud_usertype_id == '5') {
          $client = ClientDetails::model()->findByAttributes(array('cd_user_id' => $id));
          } */
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UserDetails'])) {
            $model->attributes = $_POST['UserDetails'];

            if(isset($_POST['md5password'])=='1' && !empty($_POST['md5password']))
            {
                $model->ud_password = md5($_POST['UserDetails']['ud_password']);
            }
            else{
                if(isset($_POST['editpass'])){
                    $model->ud_password = md5($_POST['UserDetails']['ud_password']);
                }
                else{
                    $model->ud_password = $_POST['UserDetails']['ud_password'];
                }
            }

            //$client->attributes = $_POST['ClientDetails'];
            /* $uploadedFile = CUploadedFile::getInstance($model, 'ud_picture');
              $model->ud_picture = $model->ud_refid . '.' . $uploadedFile->extensionName; */
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($flag = $model->save(false)) {
                    /* if (!empty($uploadedFile)) {
                      $uploadedFile->saveAs(Yii::app()->basePath . '/../images/profile/' . $model->ud_picture);
                      } */
                    // $flag = $client->save(false);
                }
                if ($flag) {
                    $transaction->commit();
                    $description = $model->ud_name . "has been updated";
                    Yii::app()->Audit->writeAuditLog("Update", "userdetails", $model->ud_refid, $description);
                    $msg['msg'] = 'Your Profile details updated successfuly';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        $this->renderPartial('_clientform', array(
            'model' => $model,
        ), false, true);
    }

    public function actionEnquiry() {
        $this->layout = "site_layout_content";
        $model = new ClientDetails;
        $model->scenario = 'enquiry';
        $this->performAjaxValidation($model);
        if (isset($_POST['ClientDetails'])) {
            $dataArr = array();
            $table = "<table class='table table-striped'>";
            foreach ($_POST['ClientDetails'] as $key => $val) {
                $dataArr[] = $val;
                $table .= "<th>" . str_replace(array("CD_", "_"), " ", strtoupper($key)) . "</th>";
            }
            $table .= "<th>PRICE</th>";
            $combinations = $this->combinations($dataArr);
            $tempArray = array();
            $format = $_POST['ClientDetails'];


            for ($i = 0; $i < count($combinations); $i++) {
                $sub = 0;
                $priceTemp = array();
                foreach ($format as $index => $value):
                    $tempArray[$i][$index] = $combinations[$i][$sub];
                    if ($index == "cd_file_in_format") {
                        if ($tempArray[$i][$index] == "xls") {
                            $priceTemp[] = 2;
                        } else if ($tempArray[$i][$index] == "pdf") {
                            $priceTemp[] = 3;
                        }
                    } else if ($index == "cd_file_out_format") {
                        if ($tempArray[$i][$index] == "csv") {
                            $priceTemp[] = 4;
                        } else if ($tempArray[$i][$index] == "txt") {
                            $priceTemp[] = 5;
                        }
                    } else if ($index == "cd_hours") {
                        if ($tempArray[$i][$index] == 12) {
                            $priceTemp[] = 6;
                        } else if ($tempArray[$i][$index] == 24) {
                            $priceTemp[] = 7;
                        }
                    }
                    $sub++;
                endforeach;
                $priceTemp = array_product($priceTemp);
                $tempArray[$i]['price'] = $priceTemp;
            }
            $this->renderPartial('price_chart', array('model' => $model,
                'tempArray' => $tempArray,
                'table' => $table), false, true);
        } else {
            $this->render('enquiry', array('model' => $model));
        }
    }

    public function combinations($arrays, $i = 0) {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = $this->combinations($arrays, $i + 1);
        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $key => $v) {
            foreach ($tmp as $key1 => $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }

    public function actionSubmitenquiry() {
        if (isset($_POST['enquiry'])) {
            $eqmodel = new Enquiry();
            $eqmodel->eq_description = $_POST['enquiry'];
            $eqmodel->eq_mail = $_POST['cli_email'];
            $eqmodel->eq_name = $_POST['cli_name'];
            if ($eqmodel->save()) {
                echo "S";
            } else {
                echo "<pre>";
                print_r($eqmodel);
                die();
                echo "N";
            }
        } else {
            echo "NO Value";
        }
    }

}
