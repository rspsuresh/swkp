<?php

/**
 * This is the model class for table "user_details_ud".
 *
 * The followings are the available columns in table 'user_details_ud':
 * @property string $ud_refid
 * @property string $ud_empid
 * @property string $ud_username
 * @property string $ud_password
 * @property string $ud_name
 * @property string $ud_gender
 * @property string $ud_dob
 * @property string $ud_marital_status
 * @property string $ud_email
 * @property string $ud_temp_address
 * @property string $ud_permanent_address
 * @property string $ud_mobile
 * @property string $ud_picture
 * @property string $ud_emergency_contatct_details
 * @property string $ud_cat_id
 * @property string $ud_status
 * @property string $ud_created_date
 * @property string $ud_last_modified
 * @property string $ud_flag
 * @property string $ud_usertype_id
 * @property string $confirmPassword
 * @property string $newPassword
 */
class UserDetails extends CActiveRecord {

    public $confirmPassword;
    public $newPassword;
    public $category;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_details_ud';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // array('ud_empid, ud_username, ud_password, ud_name, ud_dob, ud_email, ud_temp_address, ud_permanent_address, ud_mobile, ud_picture, ud_emergency_contatct_details, ud_cat_id,ud_usertype_id', 'required'),
            // array('ud_empid, ud_name,ud_usertype_id,ud_cat_id,ud_username,ud_password,ud_gender, ud_dob,ud_mobile,ud_email,ud_emergency_contatct_details, ud_temp_address,ud_permanent_address', 'required', 'on' => 'create'),
            //Employee Rule
            array('ud_empid, ud_name,ud_usertype_id,ud_username,ud_password,ud_gender, ud_dob,ud_mobile,ud_email', 'required', 'on' => 'create,update'),
            array('ud_picture', 'file', 'allowEmpty' => true, 'types' => 'jpg, gif, png', 'on' => 'create,update,ccreate'),
            array('category', 'length', 'max' => 20, 'on' => 'create,update'),
            array('ud_ipin', 'required','on' => 'update'),
            // array('ud_empid, ud_name,ud_usertype_id,ud_username,ud_password,ud_gender, ud_dob,ud_mobile,ud_email,ud_emergency_contatct_details, ud_temp_address,ud_permanent_address', 'required', 'on' => 'update'),
            //Client Rule for create Account
            array('ud_email', 'required', 'on' => 'passCheck'),
            array('confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'operator' => '=', 'message' => 'Confirm Password did not match.', 'on' => 'ccreate'),
            array('ud_name,ud_usertype_id,ud_username,ud_password,ud_gender,ud_ipin, ud_dob,ud_mobile,ud_email,newPassword,confirmPassword', 'required', 'on' => 'ccreate'),

            //array('ud_ipin', 'unique', 'message' => 'This pin is already in use'),
            array('ud_username', 'unique', 'message' => 'This Username is already in use'),
//            array('ud_username', 'unique', 'message' => 'This Username is already in use','on' => 'ccreate'),
            array('ud_email', 'email'),
            array('ud_email', 'unique', 'message' => 'This Email is already in use'),
            array('ud_emergency_contatct_details, ud_mobile', 'numerical', 'integerOnly' => true),
            array('ud_emergency_contatct_details', 'length', 'max' => 10, 'min' => 6),
            array('ud_empid', 'length', 'max' => 20),
            array('ud_username, ud_password', 'length', 'max' => 200),
            array('ud_name', 'length', 'max' => 250),
            array('ud_gender, ud_flag', 'length', 'max' => 1),
            array('ud_marital_status, ud_status', 'length', 'max' => 2),
            array('ud_teamlead_id,ud_mobile,ud_emergency_contatct_details', 'numerical', 'integerOnly' => true),
            // array('ud_username, ud_password, ud_email, ud_usertype_id, confirmPassword, newPassword', 'required', 'on' => 'passCheck'),
            // array('ud_email, ud_picture', 'length', 'max' => 150),
            array('ud_temp_address, ud_permanent_address, ud_emergency_contatct_details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ud_refid, ud_empid, ud_username, ud_password, ud_name, ud_gender, ud_dob, ud_marital_status,ud_ipin,ud_email, ud_temp_address, ud_permanent_address, ud_mobile, ud_picture, ud_emergency_contatct_details, ud_cat_id, ud_status, ud_created_date, ud_last_modified, ud_flag, ud_usertype_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'UserType' => array(self::BELONGS_TO, 'UserType', 'ud_usertype_id'),
            'Category' => array(self::BELONGS_TO, 'Category', 'ud_cat_id'),
            'ClientDetails' => array(self::HAS_ONE, 'ClientDetails', 'cd_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'ud_refid' => 'Refid',
            'ud_empid' => 'Employee ID',
            'ud_usertype_id' => 'User type',
            'ud_teamlead_id' => 'Team Lead',
            'ud_username' => 'Username',
            'ud_password' => 'Password',
            'ud_name' => 'Name',
            'ud_gender' => 'Gender',
            'ud_dob' => 'DOB',
            'ud_marital_status' => 'Marital Status',
            'ud_email' => 'Email',
            'ud_temp_address' => 'temporary Address',
            'ud_permanent_address' => 'Permanent Address',
            'ud_mobile' => 'Mobile',
            'ud_picture' => 'Picture',
            'ud_emergency_contatct_details' => 'Emergency Contact Details',
            'ud_cat_id' => 'Category',
            'ud_ipin'=>'User Pin',
            'ud_status' => 'Status',
            'ud_created_date' => 'Created Date',
            'ud_last_modified' => 'Last Modified',
            'ud_flag' => 'Flag',
            'newPassword' => 'New Password',
            'confirmPassword' => 'Confirm Password',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $status = (isset($_GET['status'])) ? $_GET['status'] : "A";
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            if ($type == 'E') {
                $criteria->addCondition('ud_usertype_id != "5" and ud_flag = "' . $status . '"');
            } elseif ($type == 'C') {
                $criteria->addCondition('ud_usertype_id = "5" and ud_flag = "' . $status . '"');
            }
        } else {
            $criteria->addCondition('ud_usertype_id != "5" and ud_flag = "' . $status . '"');
        }
        if (isset($_GET['UserDetails']['ud_empid']) && !empty($_GET['UserDetails']['ud_empid'])) {
           // $criteria->addcondition(' ud_refid =  ' . $_GET['UserDetails']['ud_empid']);          // for exact match
        }
        if (isset($_GET['UserDetails']['ud_name']) && !empty($_GET['UserDetails']['ud_name'])) {
           // $criteria->addcondition(' ud_refid =  ' . $_GET['UserDetails']['ud_name']);          // for exact match
        }
        if (isset($_GET['teamlead'])) {
            $criteria->addcondition(' ud_teamlead_id 	 =  ' . $_GET['teamlead']);          // for exact match
        }
        if (isset($_GET['UserDetails']['ud_dob']) && !empty($_GET['UserDetails']['ud_dob'])) {
			 $this->ud_dob = date('Y-m-d', strtotime($this->ud_dob));
            $criteria->compare('ud_dob', $this->ud_dob, true);
            $this->ud_dob = date('d M Y', strtotime($this->ud_dob));
        }

        $criteria->compare('ud_refid', $this->ud_refid, true);
        $criteria->compare('ud_empid', $this->ud_empid, true);
        $criteria->compare('ud_usertype_id', $this->ud_usertype_id, true);
        $criteria->compare('ud_username', $this->ud_username, true);
        $criteria->compare('ud_password', $this->ud_password, true);
        $criteria->compare('ud_name', $this->ud_name, true);
        $criteria->compare('ud_gender', $this->ud_gender, true);
        // $criteria->compare('ud_dob', $this->ud_dob, true);
        $criteria->compare('ud_marital_status', $this->ud_marital_status, true);
        $criteria->compare('ud_email', $this->ud_email, true);
        $criteria->compare('ud_temp_address', $this->ud_temp_address, true);
        $criteria->compare('ud_permanent_address', $this->ud_permanent_address, true);
        $criteria->compare('ud_mobile', $this->ud_mobile, true);
        $criteria->compare('ud_ipin', $this->ud_ipin, true);

        $criteria->compare('ud_picture', $this->ud_picture, true);
        $criteria->compare('ud_emergency_contatct_details', $this->ud_emergency_contatct_details, true);
        $criteria->compare('ud_cat_id', $this->ud_cat_id, true);
        $criteria->compare('ud_status', $this->ud_status, true);
        $criteria->compare('ud_created_date', $this->ud_created_date, true);
        $criteria->compare('ud_last_modified', $this->ud_last_modified, true);
        $criteria->compare('ud_flag', $this->ud_flag, true);

        if (isset($_REQUEST['size'])) {
            $pagination = $_REQUEST['size'];
            Yii::app()->session['pagination'] = $_REQUEST['size'];
        } else {
            $pagination = yii::app()->session['pagination'];
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pagination,
            ),
        ));
    }

    public function getPermission($userRefId, $userType) {
        $connection = Yii::app()->db;
        $checkitem = "select * from authassignment where userid=" . $userRefId;
        $cmd = $connection->createCommand($checkitem);
        $checkitem = $cmd->queryColumn();

//        if (count($checkitem) > 0) {
//            $delitem = "DELETE from authassignment where userid=" . $userRefId;
//            $cmd = $connection->createCommand($delitem)->execute();
//        }

        if (count($checkitem) == 0) {
            $userSql = "insert into authassignment (itemname, userid, data ) values('$userType','$userRefId','N;')";
            $connection->createCommand($userSql)->execute();
        }

    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->ud_created_date = date("Y-m-d H:i");
        }
        $this->ud_last_modified = date("Y-m-d H:i");
        if ($this->ud_dob != '0000-00-00' && $this->ud_dob != '') {
            $this->ud_dob = date("Y-m-d", strtotime($this->ud_dob));
        }
        return parent::beforeSave();
    }

    public static function ActionButtons($id) {
        $usr_status=UserDetails::model()->findByPk($id);
        $buttons = "<div class='ActionButton'>";
        if(Yii::app()->session['user_type'] == 'A') {
            $buttons .= "<a class='userView' href='javascript:void(0)' onclick='userView($id)'  title='View'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE8F4;</i></a>";
            $buttons .= "<a class='userUpdate' href='javascript:void(0)' onclick='userUpdate($id)' title='Update'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>edit</i></a>";
          if($usr_status->ud_flag =='A')
          {
              $buttons .= "<a class='userDelete' href='javascript:void(0)' onclick='userDelete($id,1)' title='Inactive'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24' style='font-weight:bold '>clear</i></a>";
          }
          else if($usr_status->ud_flag=='R')
          {
              $buttons .= "<a class='userDelete' href='javascript:void(0)' onclick='userDelete($id,2)' title='Active'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24' style='font-weight:bold '>check</i></a>";
          }

        }
        if(Yii::app()->session['user_type'] == 'TL') {
            $buttons .= "<a class='userUpdate' href='javascript:void(0)' onclick='userUpdate($id)' title='Update'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>edit</i></a>";
        }
        $buttons .= "</div>";
        echo $buttons;
    }


    protected function afterFind() {
        if ($this->ud_dob == '0000-00-00') {
            $this->ud_dob = "";
        } else {
            $this->ud_dob = date("d-m-Y", strtotime($this->ud_dob));
        }
        if ($this->ud_mobile == '0') {
            $this->ud_mobile = "";
        }
        if ($this->ud_password != "") {
            $this->newPassword = $this->ud_password;
            $this->confirmPassword = $this->ud_password;
        }
        return parent::afterFind();
    }

    public static function customUserdetail($type, $condtion) {
        switch ($type) {
            case 'E':
                $condition = 'ud_usertype_id!="5" and ud_flag="A" and ud_empid!=""';
                break;
            case 'C':
                $condition = 'ud_usertype_id="5" and ud_flag="A" and ud_empid!=""';
                break;
        }
        $userdetails = CHtml::listData(UserDetails::model()->findAll(array('condition' => $condition)), 'ud_refid', $condtion);
        return $userdetails;
    }

    /*
     * Profile Path
     */
    public static function getProfilepath($id) {
        $query = UserDetails::model()->findByPk($id);
        if ($query) {
            $image = isset($query->ud_picture) ? $query->ud_picture : '';
            if ($image) {
                $path = Yii::app()->request->baseUrl . '/images/profile/' . "$image";
            } else {
                $path = Yii::app()->baseUrl . '/images/sample.png';
            }

        } else {
            $path = Yii::app()->baseUrl . '/images/sample.png';
        }
        return $path;
    }

    /**
     * @User View
     */
    public static function getView($id) {
        $return = '';
        $query = UserDetails::model()->findByPk($id);
        if ($query) {
            $return = "<a class='userView' href='javascript:void(0)' onclick='userView($id)'  title='View'  data-uk-tooltip = \"{pos:'bottom'}\">$query->ud_name</a>";
        }
        return $return;
    }

    /**
     * @User Reviewer header Name
     */
    public static function getHeaderName($status) {
        $out = '';
        switch ($status) {
            case 'Prepping':
                $out = 'Prepper';
                break;
            case 'Splitting':
                $out = 'Date Coder';
                break;
            case 'Editor':
                $out = 'Reviewer';
                break;
            default:
                $out = '';
        }
        return $out;
    }
	

    public static function getUserName($type) {
        $typename = '';
        switch ($type) {
            case 'A':
                $typename = 'Admin';
                break;
            case 'TL':
                $typename = 'Team Lead';
                break;
            case 'QC':
                $typename = 'Qulaity Control';
                break;
			case 'R':
                $typename = 'Reviewer';
                break;
			case 'C':
                $typename = 'Client';
                break;	
			case 'M':
                $typename = 'Manager';
                break;	
			case 'AM':
                $typename = 'Assistant Manager';
                break;			
            default:
                $typename = '';
        }
        return $typename;
    }

}
