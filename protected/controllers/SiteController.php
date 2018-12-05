<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public $layout = '//layouts/column2';

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        if (Yii::app()->user->isGuest) {
            $this->actionSiteindex();
        } else {
            if (Yii::app()->session['user_type'] == "R" || Yii::app()->session['user_type'] == "QC") {
                $this->redirect(array('fileinfo/indexinglist'));
            } else if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
                $this->redirect(array('userdetails/admin'));
            } else if (Yii::app()->session['user_type'] == "C") {
                $this->redirect(array('joballocation/admin'));
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('error', array("error" => $error));
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
//        $this->layout = "site_layout";
        $this->layout = "site_layout_content";
        $model = new LoginForm;

        $userdetail = new UserDetails;
        $userdetail->scenario = "passCheck";
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
               if($model->validate() && $model->login())
               {
                $username=$_POST['LoginForm']['username'];
                $password=$_POST['LoginForm']['password'];

                   $this->redirect(array("site/sitepin"));

                }
            }
        $this->render('sitelogin', array('model' => $model, 'userdetail' => $userdetail));
    }
    public function actionSitepin()
    {   $this->layout = "site_layout_content";
        $model = new LoginForm;
        $this->performAjaxValidation($model);
        $model->scenario = "pincheck";
        $msg=array();
        if (isset($_POST['LoginForm'])) {
            $users = UserDetails::model()->with('UserType', 'ClientDetails')->findByAttributes(array("ud_ipin"=>$_POST['LoginForm']['ipin'],"ud_username" => $_POST['LoginForm']['username'], "ud_password" =>md5($_POST['LoginForm']['password']),'ud_flag'=>'A'));
            if(count($users)==1)
            {
                unset(Yii::app()->request->cookies['username']);
                unset(Yii::app()->request->cookies['password']);
                Yii::app()->session['user_id'] = $users['ud_refid'];
                Yii::app()->session['user_name'] = $users['ud_username'];
                Yii::app()->session['user_type'] = $users->UserType->ut_usertype;
                Yii::app()->session['user_type_name'] = $users->UserType->ut_name;
                Yii::app()->session['user_status'] = $users['ud_flag'];
                Yii::app()->session['user_project_id'] = isset($users->ClientDetails->cd_projectid) ? $users->ClientDetails->cd_projectid : "";
                Yii::app()->session['pagination'] = 10;
                $msg['req_status']='L';

                $login_user_detail = Yii::app()->db->createCommand('select ud_refid from user_details_ud where ud_username="' . $_POST['LoginForm']['username'] . '" and ud_password="' . md5($_POST['LoginForm']['password']) . '" ')->queryRow();
                if($login_user_detail)
                {
                    $log_in_history = new LoginHistory;
                    $log_in_history->lh_uid = $login_user_detail['ud_refid'];
                    $log_in_history->lh_in_dt = Yii::app()->localtime->UTCNow;
                    $log_in_history->lh_out_dt = '0000-00-00 00:00:00';
                    $log_in_history->lh_ip_address = $_SERVER['REMOTE_ADDR'];
                    $log_in_history->save();
                }

                $user_status = UserDetails::model()->findByPK(Yii::app()->session['user_id']);
                $msg['user_type']=Yii::app()->session['user_type'];
                $msg['ud_flag']=$user_status->ud_flag;
                echo json_encode($msg, true);
            }
            else
            {
                $msg['req_status']='NL';
                echo json_encode($msg, true);
            }
            die();
        }
        $this->render('sitepin',array('model' => $model));
    }
    public function actionSitesignup() {
        $this->layout = "site_layout_content";
        $userdetail = new UserDetails("passCheck");
        // Uncomment the following line if AJAX validation is needed
        $userdetail->performAjaxValidation($userdetail);
        $userdetail->scenario = "passCheck";
        $client = new ClientDetails;

        if (isset($_POST['UserDetails'])) {
            if ($userdetail->save()) {

            }
        }
        $this->render('signup', array('userdetail' => $userdetail));
    }

    public function actionSiteindex() {
        $this->layout = "site_layout";
//        $this->render('sitelogin');
        $this->actionLogin();
        
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $logedin_lhid = LoginHistory::model()->findBySql("select lh_id from login_history_lh where lh_uid='" . Yii::app()->session['user_id'] . "' order by lh_id desc limit 1 ");
        if ($logedin_lhid) {
            $updarte_log_out_time = Yii::app()->db->createCommand("update login_history_lh set lh_out_dt = '" . Yii::app()->localtime->UTCNow . "' where lh_id = $logedin_lhid->lh_id")->execute();
        }
        Yii::app()->user->logout();
        $this->redirect('login');
    }

    public function actionForgetpassword() {
        if (!empty($_POST["login_email_reset"])) {
            $user = UserDetails::model()->find(array("condition" => "ud_email = '$_POST[login_email_reset]'"));
            if(!isset($user->rand_key)) {
                $rand=rand();
                $user->rand_key = $rand;
                $user->save(false);
            }
            else
            {
                $rand=$user->rand_key;
            }

            if ($user) {
                $subject = "Kpws - Forget Passowrd";
                $details = array();
                $details["action"] = "site/forgetpassword";
                $details['link'] = Yii::app()->getBaseUrl(TRUE) . "/site/setpassword/$user->ud_refid?token=$rand";
                $details["name"] = $user->ud_username;
                $message = $this->renderPartial("email", array("details" => $details), true);

                $sendEmail = $this->actionSendmail($_POST["login_email_reset"], $subject, $message);
                if ($sendEmail) {
                    echo "S";
                } else {
                    echo "N";
                }
            } else {
                echo "N";
            }
        }
    }

    public function actionSetpassword($id)
    {
//        $this->layout = "login";
        $this->layout = "sitelayout";
        $user = new UserDetails();
        $user->scenario = "passCheck";
        $usercheck =UserDetails::model()->find('ud_refid=:userId And rand_key=:key', array(':userId'=>$id,':key'=>$_GET['token']));
        if (count($usercheck) > 0 && isset($_GET['token']))
        {
            if (!empty($_POST["UserDetails"])) {
                $user =UserDetails::model()->find('ud_refid=:userId And rand_key=:key',
                    array(':userId'=>$id,':key'=>$_GET['token']));
                $user->ud_password = $_POST['UserDetails']['newPassword'];
                $user->rand_key='';
                if ($user->save(false)) {
                    $this->redirect(array('login'));
                } else {
                    echo "<pre>";
                    print_r($user);
                    die();
                }
            }
        }
        $this->render('siteforget', array('model' => $user));
    }

    public static function actionSendmail($to, $subject, $message, $attachment = NULL, $cc = NULL) {
        $mail = Yii::app()->Smtpmail;
        $mail->SMTPAuth = true;
        $mail->SetFrom(Yii::app()->Smtpmail->Username, Yii::app()->Smtpmail->Sender_name);
        $mail->Subject = $subject;
        if ($cc != NULL) {
            $cc = explode(",", $cc);
            foreach ($cc as $key => $value) {
                $mail->AddCC($value);
            }
        }
        $mail->MsgHTML($message);
        if ($attachment != NULL) {
            $mail->AddAttachment($attachment);
        }
        $mail->AddAddress($to, "");
        if ($mail->Send()) {
            $mail->ClearAllRecipients();
            return TRUE;
        } else {
            $mail->ClearAllRecipients();
            echo "<pre>";
            print_r($mail);
            die();
            return FALSE;
        }
    }
    public function actionPasswordcheck()
    {
        $this->username=$_POST['username'];
        $this->password=$_POST['password'];
        $users = UserDetails::model()->findByAttributes(array("ud_username" => $this->username, "ud_password" => $this->password,'ud_flag'=>'A'));
        if(count($users)>0)
        {
            $msg['msg'] = 'check pin code';
            $msg['status'] = 'A';
            echo json_encode($msg, true);
        }
        else
        {
            $msg['msg'] = 'Incorrect username and password';
            $msg['status'] = 'A';
            echo json_encode($msg, true);
        }
        die();
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

}
