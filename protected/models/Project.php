<?php

/**
 * This is the model class for table "project_p".
 *
 * The followings are the available columns in table 'project_p':
 * @property string $p_pjt_id
 * @property string $p_client_id
 * @property string $p_name
 * @property string $p_op_format
 * @property string $p_key_type
 * @property string $p_category_ids
 * @property string $p_process
 * @property string $p_downloadtype
 * @property string $p_url
 * @property string $p_port
 * @property string $p_folderpath
 * @property string $p_username
 * @property string $p_password
 * @property string $p_created_date
 * @property string $p_last_modified
 * @property string $p_flag
 */
class Project extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'project_p';
    }

    public $file_upload, $filenonmedical, $p_category, $non_category,$fileup_category,$filenonup_category,$format;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('p_client_id, p_name,p_downloadtype,date_format,p_url, p_port, p_username, p_password,template_id', 'required', 'on' => 'create'),
            array('p_client_id, p_name,p_downloadtype, p_url, p_port,date_format,p_username, p_password', 'required', 'on' => 'update'),
            array('p_category_ids,non_cat_ids', 'length', 'max' => '255', 'on' => 'update'),
            //array('p_url', 'url', 'message' => 'Please enter valid URL'),
            array('p_port', 'numerical', 'integerOnly' => true, 'message' => 'Allow only Port Number'),
            array('p_url', 'length', 'max' => 200),
            array('p_client_id', 'length', 'max' => 20),
            array('p_name', 'unique', 'message' => 'This project name is already in use', 'on' => 'create,update'),
            //array('p_name', 'unique', 'message' => Project::t("This project name is already in use."),'on' => 'create'),
            //array('p_name', 'unique', 'criteria' => array('condition' => 'p_pjt_id != :id', 'params' => array(':id' => $this->p_pjt_id)), 'message' => 'This project name is already in use', 'on' => 'update'),
            array('p_name', 'length', 'max' => 250),
            array('p_op_format', 'length', 'max' => 100),
            array('p_key_type, p_flag', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('p_pjt_id, p_client_id, p_name, p_op_format,p_process,date_format,p_key_type, p_category_ids,non_cat_ids,template_id,p_created_date, p_last_modified, p_flag,filenonmedical,format', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'UserMaster' => array(self::BELONGS_TO, 'UserDetails', 'p_client_id'),
            'template' => array(self::BELONGS_TO, 'Templates', 'template_id'),
            'FormMaster' => array(self::BELONGS_TO, 'FormsBuilder', 'p_form_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'p_pjt_id' => 'P Pjt',
            'p_client_id' => 'Client',
            'p_name' => 'Project Name',
            'p_op_format' => 'Output Format',
            'p_key_type' => 'Key Type',
            'p_category_ids' => 'Category',
            'non_cat_ids' => 'Non Category',
            'p_process' => 'QC Needed',
            'p_downloadtype' => 'Download Type',
            'p_created_date' => 'P Created Date',
            'p_last_modified' => 'P Last Modified',
            'p_projectid' => 'Project',
            'date_format'=>'Date Format',
            'p_url' => 'Url',
            'p_port' => 'Port',
            'p_folderpath' => 'Folderpath',
            'p_username' => ' Username',
            'p_password' => ' Password',
            'p_flag' => 'P Flag',
            'file_upload' => 'Medical Category',
            'filenonmedical' => 'Non-Medical Category ',
            'template_id'=>'Template',
			'p_form_id'=>'Forms',
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
        $criteria->with = array('template');
        $status = (isset($_GET['status'])) ? $_GET['status'] : "A";
        $criteria->addCondition(' p_flag = "' . $status . '"');

        $criteria->compare('template.id', $this->template_id, true);
        $criteria->addCondition("p_pjt_id LIKE '%$this->p_pjt_id%'");
        //$criteria->compare('p_client_id',$this->p_client_id,true);
        $criteria->compare('p_name', $this->p_name, true);
        $criteria->compare('p_op_format', $this->format, true);
        $criteria->compare('p_key_type', $this->p_key_type, true);
        $criteria->compare('non_cat_ids', $this->non_cat_ids, true);
        $criteria->compare('p_created_date', $this->p_created_date, true);
        $criteria->compare('p_last_modified', $this->p_last_modified, true);
        $criteria->compare('p_flag', $this->p_flag, true);
        if (Yii::app()->session['user_type'] == "C") {
            $criteria->addCondition(' p_client_id = "' . Yii::app()->session['user_id'] . '"');
        }
        if($this->p_category_ids){
            $criteria->addCondition("  find_in_set($this->p_category_ids,p_category_ids) ");
        }

        if (isset($_REQUEST['size'])) {
            $pagination = $_REQUEST['size'];
            Yii::app()->session['pagination'] = $_REQUEST['size'];
        } else {
            $pagination = yii::app()->session['pagination'];
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'p_name ASC',
            ),
            'pagination' => array(
                'pageSize' => $pagination,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Project the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {

        if ($this->isNewRecord) {
            $this->p_created_date = date("Y-m-d H:i");
        }
        $this->p_last_modified = date("Y-m-d H:i");
        return parent::beforeSave();
    }

    public static function ActionButtons($id) {
        $prj_status=Project::model()->findByPk($id);
        $buttons = "<div class='ActionButton'>";
        $buttons .= "<a class='projectView' href='javascript:void(0)' onclick='projectView($id)' title='View'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE8F4;</i></a>";
        if (Yii::app()->session['user_type'] != "C") {
            $buttons .= "<a class='projectUpdate' href='javascript:void(0)' onclick='projectUpdate($id)' title='Update'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>edit</i></a>";
           if($prj_status->p_flag=="A")
           {
            $buttons .= "<a class='projectRemove' href='javascript:void(0)' onclick='projectRemove($id,1)' title='Inactive'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons  md-24 dp48' style='font-weight:bold'>close</i></a>";
           }
           else
           {
               $buttons .= "<a class='projectRemove' href='javascript:void(0)' onclick='projectRemove($id,2)' title='Active'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons  md-24 ' style='font-weight:bold'>check</i></a>";
           }
        }
        $buttons .= "</div>";
        echo $buttons;
    }

}
