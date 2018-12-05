<?php

class TemplatesController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'Rights', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    /*	public function accessRules()
        {
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array('index','view'),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>array('create','update'),
                    'users'=>array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array('admin','delete'),
                    'users'=>array('admin'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
        }*/

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->renderPartial('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Templates;
        $model->scenario = 'ccreate';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Templates']))
        {   //print_r($_POST);die;
            $model->attributes=$_POST['Templates'];
            $name=trim($_POST['Templates']['t_name']);
            $uniquecheck=Templates::model()->find('t_name = :t_name', array(":t_name"=>$name));
            if(empty($uniquecheck))
            {
                if($model->save(false))
                    $msg['msg'] = 'Templates created successfully';
                $msg['status'] = 'S';
            }
            else{
                $msg['msg'] = 'Templates name should be unique';
                $msg['status'] = 'U';
            }
            echo json_encode($msg, true);
            die();
        }
        $results = Yii::app()->db->createCommand()->
        select('t_name')->
        from('templates')->
        order('id DESC')->
        queryAll();
        $this->renderPartial('_form', array(
            'model' => $model,'results'=>$results,
        ),false,true);
    }
    public function actionParentcreate()
    {
        $model=new Templates;
        $model->scenario = 'pcreate';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Templates']))
        {
            $model->attributes=$_POST['Templates'];
			$model->t_status="R";
            $name=trim($_POST['Templates']['t_name']);
            $uniquecheck=Templates::model()->find('t_name = :t_name', array(":t_name"=>$name));
            if(empty($uniquecheck))
            {
                if($model->save(false))
                    $msg['msg'] = 'Templates created successfully';
                $msg['status'] = 'S';
            }
            else{
                $msg['msg'] = 'Templates name should be unique';
                $msg['status'] = 'U';
            }
            echo json_encode($msg, true);
            die();
        }

        $this->renderPartial('parent', array(
            'model' => $model,
        ),false,true);
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
		$model->scenario = 'ccreate';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Templates']))
        {
            $model->attributes=$_POST['Templates'];
			$model->t_status="R";
            $name=trim($_POST['Templates']['t_name']);
            $uniquecheck=Templates::model()->find('t_name = :t_name', array(":t_name"=>$name));
            //if(empty($uniquecheck))
            //{
                if($model->save(false))
                    $msg['msg'] = 'Templates update successfully';
                $msg['status'] = 'S';
            /*}
            else{
                $msg['msg'] = 'Templates name should be unique';
                $msg['status'] = 'U';
            }*/
            echo json_encode($msg, true);
            die();
        }
		$results = Yii::app()->db->createCommand()->
        select('t_name')->
        from('templates')->
        order('id DESC')->
        queryAll();
        $this->renderPartial('_form', array(
            'model' => $model,'results'=>$results,
        ),false,true);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Templates');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Templates('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Templates']))
            $model->attributes=$_GET['Templates'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Templates the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=Templates::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    public function actionRemove($id) {
        $model = $this->loadModel($id);
        if($model->t_status == "A"){
            $model->t_status = "R";
        }
        else if($model->t_status == "R"){
            $model->t_status = "A";
        }
        $model->save();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    /**
     * Performs the AJAX validation.
     * @param Templates $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='templates-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionTemplatedownload()
    {
        $model=Templates::model()->findByPk($_GET['id']);
        $name=strtolower($model->t_name);
        $pextn=($model->output =='DOCX')?'DOC':$model->output;
        $filename=$name.".".strtolower($pextn);
        $fulname = Yii::app()->basePath . "/../sampletemplates/".$filename;
        if(file_exists($fulname))
        {
            header('Content-Disposition: attachment; filename=' .$filename);
            readfile($fulname);
        }
        else
        {
            echo 'File does not exists on given path';
        }
    }



}
