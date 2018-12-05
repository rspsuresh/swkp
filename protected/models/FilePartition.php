<?php

/**
 * This is the model class for table "file_partition_fp".
 *
 * The followings are the available columns in table 'file_partition_fp':
 * @property string $fp_part_id
 * @property string $fp_file_id
 * @property string $fp_job_id
 * @property string $fp_category
 * @property string $fp_cat_id
 * @property string $fp_page_nums
 * @property string $fp_status
 * @property string $fp_created_date
 * @property string $fp_last_modified
 * @property string $fp_flag
 */
class FilePartition extends CActiveRecord {
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'file_partition_fp';
    }

    public $npages, $mpages, $project, $filename, $patient_name, $dos, $description, $provider_name, $record_row, $splitter;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('fp_file_id, fp_filepath, fp_category, fp_cat_id, fp_page_nums, fp_created_date, fp_last_modified', 'required'),
            array('fp_file_id,fp_cat_id, fp_page_nums,patient_name,dos,provider_name', 'required', 'on' => 'filesplit'),
            array('fp_file_id,fp_page_nums,fp_job_id', 'required', 'on' => 'fileindex'),
            array('npages', 'required', 'on' => 'nonpages'),
            array('mpages', 'required', 'on' => 'medicalpages'),
            array('fp_file_id, fp_job_id', 'numerical', 'integerOnly' => true),
            array('fp_file_id, fp_cat_id', 'length', 'max' => 20),
            array('fp_category, fp_flag', 'length', 'max' => 1),
            array('fp_status', 'length', 'max' => 2),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('fp_part_id, fp_file_id, fp_category, fp_cat_id, fp_page_nums, fp_status, fp_created_date, fp_last_modified, fp_flag,project,filename,splitter', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'JobAllocation' => array(self::HAS_ONE, 'JobAllocation', 'ja_partition_id'),
            'JobAllocation_part' => array(self::BELONGS_TO, 'JobAllocation', 'fp_job_id'),
            'FileInfo' => array(self::BELONGS_TO, 'FileInfo', 'fp_file_id'),
            'Category' => array(self::BELONGS_TO, 'Category', 'fp_cat_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'fp_part_id' => 'Fp Part',
            'fp_file_id' => 'File Name',
            'fp_job_id' => 'JOb ID',
            'fp_category' => 'Medical/Non-medical',
            'fp_cat_id' => 'Category',
            'fp_page_nums' => 'Page Numbers',
            'fp_status' => 'Fp Status',
            'fp_created_date' => 'Fp Created Date',
            'fp_last_modified' => 'Fp Last Modified',
            'fp_flag' => 'Fp Flag',
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
        $criteria->with = array('FileInfo', 'FileInfo.ProjectMaster', 'JobAllocation', 'JobAllocation.UserDetails');

        $criteria->compare('fp_part_id', $this->fp_part_id, true);
        $criteria->compare('fp_file_id', $this->fp_file_id, true);
        $criteria->compare('fp_category', $this->fp_category, true);
        $criteria->compare('fp_cat_id', $this->fp_cat_id, true);
        $criteria->compare('fp_page_nums', $this->fp_page_nums, true);
        $criteria->compare('fp_status', $this->fp_status, true);
        $criteria->compare('fp_created_date', $this->fp_created_date, true);
        $criteria->compare('fp_last_modified', $this->fp_last_modified, true);
        $criteria->compare('fp_flag', $this->fp_flag, true);
        //$criteria->addCondition("FileInfo.fi_admin_lock= 'O'");

        if (!empty($_REQUEST['FilePartition']['filename'])) {
            $fileid = $_REQUEST['FilePartition']['filename'];
            $criteria->addCondition("FileInfo.fi_file_name LIKE '%$fileid%'");
        }
        if (!empty($_REQUEST['FilePartition']['project'])) {
            $proj = $_REQUEST['FilePartition']['project'];
            $criteria->addCondition("ProjectMaster.p_pjt_id ='" . $proj . "'");
        }
        if (!empty($_REQUEST['FilePartition']['splitter'])) {
            $splitter = $_REQUEST['FilePartition']['splitter'];
            $criteria->addCondition("UserDetails.ud_refid='$splitter'");
        }

        if (Yii::app()->session['user_type'] != "C") {

            if (isset($_GET['fi_st']) && $_GET['fi_st'] != 'I') {
                if ($_GET['fi_st'] == 'SA') {

                    // $criteria->with = array('JobAllocation');
                    //com $criteria->condition = "JobAllocation.ja_status = '$_GET[fi_st]'";
                    $criteria->addCondition("JobAllocation.ja_status='$_GET[fi_st]'");
                    if (Yii::app()->session['user_type'] == "R") {
                        //print_r("kdkgkg");die;
                        //com $criteria->condition .= ' and JobAllocation.ja_reviewer_id =' . Yii::app()->session['user_id'] . ' and ja_flag = "A" and fp_status = "I"';
                        $criteria->addCondition("JobAllocation.ja_reviewer_id=" . Yii::app()->session['user_id'] . " and JobAllocation.ja_flag='A' and  fp_status='I'");
                    }
					$criteria->addCondition("FileInfo.fi_admin_lock= 'RL' or FileInfo.fi_admin_lock= 'O' ");
//                     $criteria->condition .= " and fp_file_id = 1 and fp_category = 'M' and fp_flag = 'A'";
                } else if ($_GET['fi_st'] == 'SC' || $_GET['fi_st'] == 'SQP') {
                    //echo "jhjh";die;
                    //$criteria->with = array('JobAllocation');
                    if (Yii::app()->session['user_type'] == "A") {
                        //com $criteria->condition = "(JobAllocation.ja_status = 'SC' or JobAllocation.ja_status = 'SQP') and ja_flag = 'A'";
                        $criteria->addCondition("JobAllocation.ja_status='SC' or JobAllocation.ja_status = 'SQP' and JobAllocation.ja_flag = 'A'");
                    } else {
                        //com  $criteria->condition = "JobAllocation.ja_status = '$_GET[fi_st]'";
                        $criteria->addCondition("JobAllocation.ja_status='$_GET[fi_st]'");
                    }
                    //com $criteria->condition .= " and fp_cat_id = '0'";
                    //com $criteria->condition .= " and fp_category = 'M'";
                    $criteria->addCondition("fp_cat_id='0' and fp_category='M'");
                    if (Yii::app()->session['user_type'] == "QC" && $_GET['fi_st'] == 'SQP') {
                        //com $criteria->condition .= ' and JobAllocation.ja_qc_id =' . Yii::app()->session['user_id'] . ' and ja_flag = "A"';
                        $criteria->addCondition("JobAllocation.ja_qc_id =" . Yii::app()->session['user_id'] . " and ja_flag = 'A'");
                        $criteria->addCondition("FileInfo.fi_admin_lock= 'QL'");
                    }
                    else
                    {
                        $criteria->addCondition("FileInfo.fi_admin_lock= 'O'");
                    }

                }
            } else {
                //com $criteria->with = array('JobAllocation');
                $criteria->addCondition("fp_status='I' and fp_category='M'");
                //com $criteria->condition = "fp_status = 'I' and fp_category = 'M'";

            }
        }
		$criteria->order='JobAllocation.ja_last_modified DESC';
        $criteria->addCondition('fp_flag = "A"');
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

    /**
     * @Active Record  File Partiton Editor View
     */
    public function editorsearch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('FileInfo', 'FileInfo.ProjectMaster', 'JobAllocation');

        $criteria->compare('fp_part_id', $this->fp_part_id, true);
        //$criteria->compare('fp_file_id', $this->fp_file_id, true);
        //$criteria->compare('fp_category', $this->fp_category, true);
        //$criteria->compare('fp_cat_id', $this->fp_cat_id, true);
        $criteria->compare('fp_page_nums', $this->fp_page_nums, true);
        //$criteria->compare('fp_status', $this->fp_status, true);
        $criteria->compare('fp_created_date', $this->fp_created_date, true);
        $criteria->compare('fp_last_modified', $this->fp_last_modified, true);
        $criteria->compare('fp_flag', $this->fp_flag, true);
        if (!empty($_REQUEST['FilePartition']['filename'])) {
            $fileid = $_REQUEST['FilePartition']['filename'];
            $criteria->addCondition("FileInfo.fi_file_name LIKE '%$fileid%'");
        }
        if (!empty($_REQUEST['FilePartition']['project'])) {
            $proj = $_REQUEST['FilePartition']['project'];
            $criteria->addCondition("ProjectMaster.p_pjt_id ='" . $proj . "'");
        }
        $status = isset($_GET['status']) ? $_GET['status'] : 'F';
        if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
            if ($status == 'F') {
                $criteria->addCondition("fp_cat_id!= '' and fp_category='' and fp_status='N'");
            } elseif ($status == 'A') {
                $criteria->addCondition("fp_cat_id!= '' and fp_category='' and fp_status='S'");
                $criteria->addCondition("JobAllocation.ja_status ='RA'");
            } else {
                $criteria->addCondition("JobAllocation.ja_status ='RC'");
                $criteria->addCondition("fp_cat_id!= '' and fp_category='' and fp_status='S'");
            }
        } else {

            if (Yii::app()->session['user_type'] != "C") {
                if (Yii::app()->session['user_type'] != "R") {
                    $criteria->addCondition("JobAllocation.ja_reviewer_id ='" . Yii::app()->session['user_id'] . "'");
                } else {
                    $criteria->addCondition("JobAllocation.ja_qc_id ='" . Yii::app()->session['user_id'] . "'");
                }
                $cat = $this->getUsercategory(Yii::app()->session['user_id']);
                $criteria->addInCondition("fp_cat_id", $cat);
                if ($status == 'F') {
                    $criteria->addCondition("fp_category='' and fp_status='N'");
                } elseif ($status == 'A') {
                    $criteria->addCondition("JobAllocation.ja_status ='RA'");
                    $criteria->addCondition("fp_category='' and fp_status='S'");
                } else {
                    $criteria->addCondition("JobAllocation.ja_status ='RC'");
                    $criteria->addCondition("fp_category='' and fp_status='S'");
                }
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'project' => array(
                        'asc' => 'ProjectMaster.p_pjt_id',
                        'desc' => 'ProjectMaster.p_pjt_id DESC',
                    ),
                    'filename' => array(
                        'asc' => 'FileInfo.fi_file_name',
                        'desc' => 'FileInfo.fi_file_name DESC',
                    ),
                    '*'
                ),
            ),
        ));
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FilePartition the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {

        if ($this->isNewRecord) {
            $this->fp_created_date = date("Y-m-d H:i");
        }
        $this->fp_last_modified = date("Y-m-d H:i");
        return parent::beforeSave();
    }


    public static function ActionButtons($partId, $Uid, $ja_status = "", $jid = "", $data = '') {
        $filepartition=FilePartition::model()->findByPk($partId);
        if($filepartition)
        {
            $fileid=$filepartition->fp_file_id;
        }
        $jobmedStatus = !empty($data->JobAllocation->ja_med_status) ? $data->JobAllocation->ja_med_status : '';
        $jobnonmedStatus = !empty($data->JobAllocation->ja_nonmed_status) ? $data->JobAllocation->ja_nonmed_status : '';
        $buttons = "<div class='ActionButton'>";
        if ($ja_status == '') {
            if ($Uid == 'A') {
                $buttons .= "<a class='SplitAllocate' href='javascript:void(0)' onclick='SplitAllocate($partId)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
            }
        } else if ($ja_status == 'SA') {

            if ($Uid == "R") {
                //$buttons .= "<a href='".Yii::app()->createUrl('Fileinfo/filesplit/'.$partId)."'><i class='material-icons'>&#xE8E5;</i></a>";
                $buttons .= "<a onclick=datecodelock($fileid,$partId) id='datecode_$partId'><i class='material-icons'>&#xE8E5;</i></a>";
                $buttons .= "<a  style='visibility:hidden;' href='" . Yii::app()->createUrl('filepartition/filesplit', array('id' => $partId, 'status' => 'R')) . "'><i class='material-icons'>&#xE8E5;</i></a>";
                if (FilePartition::checkBreakfile($jid)) {
                    //if ($jobmedStatus == 'C' && $jobnonmedStatus == "C") {
                        $buttons .= "<a class='splitcomplete' href='javascript:void(0)' onclick='completeReviewerFile($jid)' title='Complete'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>beenhere</i></a>";
                    //}
                }
            } else if ($Uid == "A" || $Uid == "TL") {
                $buttons .= "<a class='SplitReallocate' href='javascript:void(0)' onclick='SplitReallocate($jid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
            }

        } else if ($ja_status == "SC") {
            if ($Uid == "QC") {
                $buttons .= "<a class='SplitQc' href='javascript:void(0)' onclick='IndexQc($jid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
            }
        } else if ($ja_status == "IQP" || $ja_status == "SQP") {
            if ($Uid == "QC") {
                //if ($jobmedStatus == 'C' && $jobnonmedStatus == "C") {
                    $buttons .= "<a class='CompleteQc' href='javascript:void(0)' onclick='CompleteQc($jid)' title='Complete'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>beenhere</i></a>";
                //}
                $buttons .= "<a href='" . Yii::app()->createUrl('filepartition/filesplit', array('id' => $partId, 'status' => 'QC')) . "' title='Splitting Pages'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>folder_shared</i></a>";
            }
        }
        $buttons .= "</div>";
        return $buttons;
    }

    /**
     * @get Category for  current user
     */
    public function getUsercategory($id) {
        $explode = array();
        $query = UserDetails::model()->findByPk($id);
        if ($query) {
            $explode = explode(',', $query->ud_cat_id);
        }
        return $explode;
    }

    /**
     * @Check split taken or not
     */
    public static function checkBreakfile($job_id) {
        $return = false;
        $jobAllocation = JobAllocation::model()->findByPk($job_id);
        $file_id = $jobAllocation ? $jobAllocation->ja_file_id : '';
        $fileInfo = FileInfo::model()->findByPk($file_id);
        $project_id = $fileInfo ? $fileInfo->fi_pjt_id : '';
        $dir = "filepartition/" . $project_id . "_breakfile";
        if (is_dir($dir)) {
            $file_dir = $dir . "/" . $file_id . ".txt";
            if (file_exists($file_dir)) {
                $return = true;
            }
        }
        return $return;
    }
}
