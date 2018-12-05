<?php

class ProjectController extends RController {

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
        $this->renderPartial('view', array(
            'model' => $this->loadModel($id),
                ), false, true);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Project;
        $model->scenario = 'create';
        $flag = false;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            $model->skip_edit = $_POST['Project']['skip_edit'];
			//$model->p_prep = $_POST['Project']['p_prep'];
            $model->template_id=$_POST['Project']['template_id'];
            $model->p_form_id=$_POST['Project']['p_form_id'];
            $model->p_key_type = "N"; //Setting both medical and non-medical pages review by default
            $transaction = Yii::app()->db->beginTransaction();
            try {

                //if (!empty($_FILES['Project']['tmp_name']['file_upload'])) {

                    //medical category
                    $handle='';
                    $file = CUploadedFile::getInstance($model, 'file_upload');
                    if(!empty($file)) {
                        $handle = fopen("$file->tempName", "r");
                    }
                    $row = 1;
                    $cat_id = array();
                    $criteria = new CDbCriteria();
                    $criteria->addInCondition('ct_cat_name', array('Duplicate','Others'));
                    $result = Category::model()->findAll($criteria);
					if(count($result) == 0){
                        $catone = new Category();
                        $cattwo = new Category();
                        $catone->ct_cat_name = "Duplicate";
                        $catone->ct_cat_type = "M";
                        $catone->save(false);
                        $result[0]['ct_cat_id']=$catone->ct_cat_id;
                        $cattwo->ct_cat_name = "Others";
                        $cattwo->ct_cat_type = "M";
                        $cattwo->save(false);
                        $result[1]['ct_cat_id']=$cattwo->ct_cat_id;
                    }
                    array_push($cat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);
					if($handle) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if ($row > 1) {
                                $getcategory_name = str_replace("'", "", $this->convert_smart_quotes($data[0]));
                                $getcategory_name = str_replace('"', '', $getcategory_name);
                                $categoryModel = Category::model()->find(array("condition" => "ct_cat_name='$getcategory_name' and ct_cat_type='M' "));
                                if ($categoryModel) {
                                    if ($categoryModel->ct_cat_id != $result[0]['ct_cat_id'] && $categoryModel->ct_cat_id != $result[1]['ct_cat_id']) {
                                        $cat_id[] = $categoryModel->ct_cat_id;
                                    }
                                } else {
                                    $catModel = new Category();
                                    $catModel->ct_cat_name = $getcategory_name;
                                    $catModel->ct_cat_type='M';
                                    $catModel->save(false);
                                    if ($catModel->ct_cat_id != $result[0]['ct_cat_id'] && $catModel->ct_cat_id != $result[1]['ct_cat_id']) {
                                        $cat_id[] = $catModel->ct_cat_id;
                                    }
                                }
                            }
                            $row++;
                        }
                    }

                    if(isset($_POST['Project']['fileup_category']) && !empty($_POST['Project']['fileup_category']))
                    {
                        $valarr=explode(',',$_POST['medval']);
                        $tmpar=$_POST['Project']['fileup_category'];
                        foreach($tmpar as $val )
                        {
                            if (in_array($val,$valarr )) {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $val;
                                $catModel->ct_cat_type='M';
                                $catModel->save(false);
                                $cat_id[] = $catModel->ct_cat_id;
                            }
                            else{
                                $cat_id[] = $val;
                            }
                        }

                    }
                    sort($cat_id);
                    $model->p_category_ids = implode(',', $cat_id);

                    //non medical category
                    $noncat_id = array();
                    if(isset($_POST['Project']['filenonup_category']) && !empty($_POST['Project']['filenonup_category']))
                    {
                        $nonvalarr=explode(',',$_POST['nonmedval']);
                        $nontmpar=$_POST['Project']['filenonup_category'];
                        foreach($nontmpar as $val )
                        {
                            if (in_array($val,$nonvalarr )) {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $val;
                                $catModel->ct_cat_type='N';
                                $catModel->save(false);
                                $noncat_id[] = $catModel->ct_cat_id;
                            }
                            else{
                                $noncat_id[] = $val;
                            }
                        }
                    }
                    $filenonmedical = CUploadedFile::getInstance($model, 'filenonmedical');
                    if(!empty($filenonmedical)) {
                        $handlenonmedical = fopen("$filenonmedical->tempName", "r");
                        $nonrow = 1;
                        while (($nondata = fgetcsv($handlenonmedical, 1000, ",")) !== FALSE) {
                            if ($nonrow > 1) {
                                $nongetcategory_name = str_replace("'", "", $this->convert_smart_quotes($nondata[0]));
                                $nongetcategory_name = str_replace('"', '', $nongetcategory_name);
                                $noncategoryModel = Category::model()->find(array("condition" => "ct_cat_name='$nongetcategory_name' and ct_cat_type='N'"));
                                if ($noncategoryModel) {
                                    $noncat_id[] = $noncategoryModel->ct_cat_id;
                                } else {

                                    $noncatModel = new Category();
                                    $noncatModel->ct_cat_name = $nongetcategory_name;
                                    $noncatModel->ct_cat_type = 'N';
                                    $noncatModel->save(false);
                                    $noncat_id[] = $noncatModel->ct_cat_id;
                                }

                            }
                            $nonrow++;
                        }

                        $criteria = new CDbCriteria();
                        $criteria->addInCondition('ct_cat_name', array('Duplicate','Others'));
                        $result = Category::model()->findAll($criteria);
                        if(isset($result))
                        {
                            array_push($noncat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);
                        }
                        sort($noncat_id);
                        $model->non_cat_ids = implode(',', $noncat_id);
                    }
                    else
                    {
                        $criteria = new CDbCriteria();
                        $criteria->addInCondition('ct_cat_name', array('Duplicate','Others'));
                        $result = Category::model()->findAll($criteria);
                        array_push($noncat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);

                        sort($noncat_id);
                        $model->non_cat_ids = implode(',', $noncat_id);
                        //echo $model->non_cat_ids;die;
                    }
                    if (!empty($_REQUEST['Project']['p_process'])) {
                        $model->p_process = implode(',', $_REQUEST['Project']['p_process']);
                    }
                    
                    if ($flag = $model->save()) {
                        $transaction->commit();
                        $msg['msg'] = 'Project created successfully';
                        $msg['status'] = 'S';
                        echo json_encode($msg, true);
                        die();
                    } else {
                        $error=$model->getErrors();
                      if(isset($error['p_name'])) {
                            $msg['msg'] = 'Project name should be unique';
                            $msg['status'] = 'E';
                            echo json_encode($msg, true);
                            die();
                        }
                        $transaction->rollback();
                    }
               // }
                /* $model->p_category_ids = implode(',', $model->p_category_ids);
                  $model->p_process = implode(',', $model->p_process);
                  if ($flag = $model->save()) {
                  // $client->cd_user_id = $model->p_client_id;
                  //$client->cd_projectid = $model->p_pjt_id;
                  //$flag = $client->save(false);
                  } */
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }

        $this->renderPartial('_form', array(
            'model' => $model
                ), false, true);
    }

    //Common
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $flag = false;
        if (isset($_POST['Project'])) {
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);
            $model->attributes = $_POST['Project'];
			$model->skip_edit = $_POST['Project']['skip_edit'];
			//$model->p_prep = $_POST['Project']['p_prep'];
			$model->template_id=$_POST['Project']['template_id'];
			$model->p_form_id=$_POST['Project']['p_form_id'];
//            $model->p_key_type = "N"; //Setting both medical and non-medical pages review by default
            $transaction = Yii::app()->db->beginTransaction();
            try {
                // medical category update
				$criteria = new CDbCriteria();
                $criteria->addInCondition('ct_cat_name', array('Duplicate','Others'));
                $result = Category::model()->findAll($criteria);
					if(count($result) == 0){
                        $catone = new Category();
                        $cattwo = new Category();
                        $catone->ct_cat_name = "Duplicate";
                        $catone->ct_cat_type = "M";
                        $catone->save(false);
                        $result[0]['ct_cat_id']=$catone->ct_cat_id;
                        $cattwo->ct_cat_name = "Others";
                        $cattwo->ct_cat_type = "M";
                        $cattwo->save(false);
                        $result[1]['ct_cat_id']=$cattwo->ct_cat_id;
                    }
                if (!empty($_FILES['Project']['tmp_name']['file_upload'])) {
                    $file = CUploadedFile::getInstance($model, 'file_upload');
                    $handle = fopen("$file->tempName", "r");
                    $row = 1;
                    $cat_id = array();
					array_push($cat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if ($row > 1) {
                            $getcategory_name = str_replace("'", "", $this->convert_smart_quotes($data[0]));
                            $getcategory_name = str_replace('"', '', $getcategory_name);
                            $categoryModel = Category::model()->find("ct_cat_name='$getcategory_name'");
                            if ($categoryModel) {
                                $cat_id[] = $categoryModel->ct_cat_id;
                            } else {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $getcategory_name;
                                $catModel->ct_cat_type='M';
                                $catModel->save(false);
                                $cat_id[] = $catModel->ct_cat_id;
                            }
                        }
                        $row++;
                    }
                    sort($cat_id);
                    if (isset($_POST['Project']['p_category'])) {
                        $cat_id = array_unique(array_merge($cat_id, $_POST['Project']['p_category']));
                        $valarr=explode(',',$_POST['medval']);
                        $tmpar=$_POST['Project']['p_category'];
                        foreach($tmpar as $val )
                        {
                            if (in_array($val,$valarr )) {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $val;
                                $catModel->ct_cat_type='M';
                                $catModel->save(false);
                                $cat_id[] = $catModel->ct_cat_id;
                            }
                            else{
                                $cat_id[] = $val;
                            }
                        }
                    }
                    $model->p_category_ids = implode(',', $cat_id);
                } else {
					$cat_id = array();
					array_push($cat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);
					if (isset($_POST['Project']['p_category'])) {
                        $cat_id = array_unique(array_merge($cat_id, $_POST['Project']['p_category']));

                        $valarr=explode(',',$_POST['medval']);
                        $tmpar=$_POST['Project']['p_category'];
                        foreach($tmpar as $val )
                        {
                            if (in_array($val,$valarr )) {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $val;
                                $catModel->ct_cat_type='M';
                                $catModel->save(false);
                                $cat_id[] = $catModel->ct_cat_id;
                            }
                            else{
                                $cat_id[] = $val;
                            }
                        }
                    }
                    $meduni=array_unique($cat_id);
                    $model->p_category_ids = implode(',', $meduni);
                }

                // non medical category update

                if (!empty($_FILES['Project']['tmp_name']['filenonmedical'])) {
                    $nonfile = CUploadedFile::getInstance($model, 'filenonmedical');
                    $nonhandle = fopen("$nonfile->tempName", "r");
                    $nonrow = 1;
                    $noncat_id = array();
					array_push($noncat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);
                    while (($nondata = fgetcsv($nonhandle, 1000, ",")) !== FALSE) {
                        if ($nonrow > 1) {
                            $nongetcategory_name = str_replace("'", "", $this->convert_smart_quotes($nondata[0]));
                            $nongetcategory_name = str_replace('"', '', $nongetcategory_name);
                            $noncategoryModel = Category::model()->find("ct_cat_name='$nongetcategory_name'");
                            if ($noncategoryModel) {
                                $noncat_id[] = $noncategoryModel->ct_cat_id;
                            } else {
                                $noncatModel = new Category();
                                $noncatModel->ct_cat_name = $nongetcategory_name;
                                $noncatModel->ct_cat_type='N';
                                $noncatModel->save(false);
                                $noncat_id[] = $noncatModel->ct_cat_id;
                            }
                        }
                        $nonrow++;
                    }
                    sort($noncat_id);
                    if (isset($_POST['Project']['non_category'])) {
                        //$cat_id = array_unique(array_merge($noncat_id, $_POST['Project']['non_category']));

                       $nonvalarr=explode(',',$_POST['nonmedval']);
                        $nontmpar=$_POST['Project']['non_category'];
                        foreach($nontmpar as $val )
                        {
                            if (in_array($val,$nonvalarr )) {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $val;
                                $catModel->ct_cat_type='N';
                                $catModel->save(false);
                                $noncat_id[] = $catModel->ct_cat_id;
                            }
                            else{
                                $noncat_id[] = $val;
                            }
                        }
                    }
                    $nonmeduni=array_unique($noncat_id);
                    $model->non_cat_ids = implode(',', $nonmeduni);
                } else {
					$noncat_id = array();
					array_push($noncat_id,$result[0]['ct_cat_id'],$result[1]['ct_cat_id']);
					if (isset($_POST['Project']['non_category'])) {
                        //$noncat_id = array_unique(array_merge($noncat_id, $_POST['Project']['non_category']));
                        $nonvalarr=explode(',',$_POST['nonmedval']);
                        $nontmpar=$_POST['Project']['non_category'];
                        foreach($nontmpar as $val )
                        {
                            if (in_array($val,$nonvalarr )) {
                                $catModel = new Category();
                                $catModel->ct_cat_name = $val;
                                $catModel->ct_cat_type='N';
                                $catModel->save(false);
                                $noncat_id[] = $catModel->ct_cat_id;
                            }
                            else{
                                $noncat_id[] = $val;
                            }
                        }

                    }
                    $nonmeduni=array_unique($noncat_id);
                    $model->non_cat_ids = implode(',', $nonmeduni);
                }

                if (!empty($_REQUEST['Project']['p_process'])) {
                    $model->p_process = implode(',', $_REQUEST['Project']['p_process']);
                }
				else{
					$model->p_process = "";
				}
                if ($flag = $model->save()) {
                    $transaction->commit();
                    $msg['msg'] = 'Project updated successfully';
                    $msg['status'] = 'S';
                    echo json_encode($msg, true);
                    die();
                } else {
                    $error=$model->getErrors();
                    if(isset($error['p_name'])) {
                        $msg['msg'] = 'Project name should be unique';
                        $msg['status'] = 'E';
                        echo json_encode($msg, true);
                        die();
                    }
                    $transaction->rollback();
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        if ($model) {
            $model->p_process = explode(',', $model->p_process);
            $model->p_category_ids = explode(',', $model->p_category_ids);

            //$model->p_process = explode(',', $model->p_process);
            $model->non_cat_ids = explode(',', $model->non_cat_ids);
        }
        $this->renderPartial('_form', array(
            //'model' => $model, 'client' => $client
            'model' => $model
                ), false, true);
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

    public function actionRemove($id) {
        $model = $this->loadModel($id);
        $model->setScenario("delete");
       
        if ($model->p_flag == "A") {
            $model->p_flag = "R";
        } else if ($model->p_flag == "R") {
            $model->p_flag = "A";
        }
        if($model->save()){
            
        }
       
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Project');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Project('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Project']))
            $model->attributes = $_GET['Project'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all User.
     */
    public function actionClientproject() {
        $model = new Project('search');
        $_GET['user_id'] = Yii::app()->session['user_id'];
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Project']))
            $model->attributes = $_GET['Project'];

        $this->render('clientproject', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Project the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Project::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Project $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'project-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetcategories() {
        $project = Project::model()->findByPk($_POST['projectId']);
        $category = Category::model()->findAll(array('condition' => 'ct_cat_id in(' . $project['p_category_ids'] . ')'));
        $category = CHtml::listData($category, 'ct_cat_id', 'ct_cat_name');

        foreach ($category as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }
    public function actionTemplates() {

        $outputarray=array(1 => 'XLS', 2 => 'XML', 3 => 'PDF', 4 => 'DOCX');
        $key=array_search($_POST['p_op_format'],$outputarray);
        $template = Templates::model()->findAll(array('condition' => 'op_id='.$key));
        echo CHtml::tag('option', array('value' =>0), CHtml::encode('Select template'), true);
        foreach ($template as $name)
        {
            echo CHtml::tag('option', array('value' => $name['id']), CHtml::encode($name['t_name']), true);
        }

    }

    public function actionPreview() {

           $filename = Yii::app()->basePath . "/../sampletemplates/".$_GET['filename'];
            $ext = pathinfo($_GET['filename'], PATHINFO_EXTENSION);
            $filename = Yii::app()->basePath . "/../sampletemplates/".$_GET['filename'];
            if(file_exists($filename))
            {
                header('Content-Disposition: attachment; filename=' .$_GET['filename']);
                readfile($filename);
            }
            else
            {
                echo 'File does not exists on given path';
            }
        }

}
