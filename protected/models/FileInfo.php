<?php

/**
 * This is the model class for table "file_info_fi".
 *
 * The followings are the available columns in table 'file_info_fi':
 * @property string $fi_file_id
 * @property string $fi_pjt_id
 * @property string $fi_file_name
 * @property string $fi_total_pages
 * @property string $fi_file_ori_location
 * @property string $fi_file_completed_location
 * @property string $fi_file_uploaded_date
 * @property string $fi_file_completed_time
 * @property string $fi_status
 * @property string $fi_created_date
 * @property string $fi_last_modified
 * @property string $fi_flag
 */
class FileInfo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'file_info_fi';
    }

    public $indexer;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fi_file_name,fi_pjt_id', 'required'),
            array('fi_template_id','required','on'=>'templatechange'),
            array('fi_pjt_id', 'length', 'max' => 20),
            array('fi_file_name', 'length', 'max' => 250),
            array('fi_file_ori_location, fi_file_completed_location', 'length', 'max' => 500),
            array('fi_status', 'length', 'max' => 2),
            array('fi_flag', 'length', 'max' => 1),
            array('fi_total_pages', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('fi_file_id, fi_pjt_id, fi_file_name, fi_file_ori_location, fi_file_completed_location, fi_file_uploaded_date, fi_file_completed_time, fi_status, fi_created_date, fi_last_modified, fi_flag,indexer,fi_medinfo,fi_template_id', 'safe', 'on' => 'search'),
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->fi_created_date = date("Y-m-d H:i:s");
            $this->fi_file_uploaded_date = date("Y-m-d H:i:s");
        }
        $this->fi_last_modified = date("Y-m-d H:i:s");
        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ProjectMaster' => array(self::BELONGS_TO, 'Project', 'fi_pjt_id'),
            'JobAllocation' => array(self::HAS_ONE, 'JobAllocation', 'ja_file_id', 'order' => 'ja_job_id desc'),
            'FilePartition' => array(self::HAS_ONE, 'FilePartition', 'fp_file_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'fi_file_id' => 'Fi File',
            'fi_pjt_id' => 'Project Name',
            'fi_file_name' => 'File Name',
            'fi_file_ori_location' => 'File Location',
            'fi_file_completed_location' => 'File Completed Location',
            'fi_file_uploaded_date' => 'Uploaded Date',
            'fi_file_completed_time' => 'Completed Time',
            'fi_status' => 'Fi Status',
            'fi_split_files' => 'fi_split_files',
            'fi_created_date' => 'Fi Created Date',
            'fi_last_modified' => 'Fi Last Modified',
            'fi_flag' => 'Fi Flag',
            'fi_editorskipqc' => 'fi_editorskipqc',
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


        $criteria->compare('fi_file_id', $this->fi_file_id, true);
        $criteria->compare('fi_pjt_id', $this->fi_pjt_id, true);
        $criteria->compare('fi_file_name', $this->fi_file_name, true);
        $criteria->compare('fi_file_ori_location', $this->fi_file_ori_location, true);
        $criteria->compare('fi_file_completed_location', $this->fi_file_completed_location, true);
        $criteria->compare('fi_file_uploaded_date', $this->fi_file_uploaded_date, true);
        $criteria->compare('fi_file_completed_time', $this->fi_file_completed_time, true);
        $criteria->compare('fi_status', $this->fi_status, true);
        $criteria->compare('fi_created_date', $this->fi_created_date, true);
        $criteria->compare('fi_last_modified', $this->fi_last_modified, true);
        $criteria->compare('fi_flag', $this->fi_flag, true);

        if (Yii::app()->session['user_type'] == "C") {
            $prjt_model = Project::model()->findAll(array('condition' => " p_client_id = " . Yii::app()->session['user_id'] . " and p_flag= 'A'"));
            if ($prjt_model) {
                $fparr = array();
                foreach ($prjt_model as $fp) {
                    $fparr[] = $fp->p_pjt_id;
                }
                $csv = implode(',', $fparr);
                $criteria->addCondition('fi_pjt_id in (' . $csv . ')');
            } else {
                $criteria->addCondition('fi_pjt_id = 0');
            }
            $criteria->addCondition("DATEDIFF(NOW(), fi_last_modified) <= 7");
        } elseif (Yii::app()->session['user_type'] != "C") {
            if (isset($_GET['fi_st']) && $_GET['fi_st'] != 'P' && empty($_GET['indexing'])) {
                if ($_GET['fi_st'] == 'IA') {
                    $criteria->with = array('FilePartition', 'JobAllocation', 'JobAllocation.UserDetails');
                    //$criteria->condition = "JobAllocation.ja_status = '$_GET[fi_st]'";
                    $criteria->addCondition("JobAllocation.ja_status = 'IA' and ((FilePartition.fp_part_id IS NULL or fp_flag = 'R') and JobAllocation.ja_flag = 'A')");
                    //com $criteria->condition = "((JobAllocation.ja_status = 'IA' and FilePartition.fp_part_id IS NULL)";

                    if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
                        $criteria->addCondition(" (JobAllocation.ja_status = 'IQ' and (FilePartition.fp_part_id IS NULL or FilePartition.fp_status = 'Q'))", "OR");
                        //com $criteria->condition .= " or (JobAllocation.ja_status = 'IQ' and (FilePartition.fp_part_id IS NULL or FilePartition.fp_status = 'Q'))";
                    }
                    $criteria->addCondition("(JobAllocation.ja_status = 'IA' and ja_flag = 'A' and  FilePartition.fp_status = 'N')", 'OR');

                    //com $criteria->condition .= " or (JobAllocation.ja_status = 'IA' and FilePartition.fp_status = 'N'))";

                    //$criteria->condition .= " or (JobAllocation.ja_status = 'IA' and FilePartition.fp_status = 'Q')";
                    //$criteria->condition .= " and FilePartition.fp_part_id IS NULL";
                    if (Yii::app()->session['user_type'] == "R") {
                        $criteria->addCondition('JobAllocation.ja_reviewer_id =' . Yii::app()->session['user_id']);
                        //com $criteria->condition .= ' and JobAllocation.ja_reviewer_id =' . Yii::app()->session['user_id'];
                        $criteria->addCondition("fi_admin_lock= 'RL' or fi_admin_lock= 'O'");
                    }
					//$criteria->addCondition("fi_admin_lock= 'O'");
                } else if ($_GET['fi_st'] == 'IC' || $_GET['fi_st'] == 'IQP') {
                    $criteria->with = array('FilePartition', 'JobAllocation', 'JobAllocation.UserDetails');
                    if (Yii::app()->session['user_type'] == "A") {
                        $criteria->addcondition("(JobAllocation.ja_status = 'IC' or JobAllocation.ja_status = 'IQP')");
                        //com $criteria->condition = "(JobAllocation.ja_status = 'IC' or JobAllocation.ja_status = 'IQP')"
                    } else {
                        $criteria->addCondition("JobAllocation.ja_status = '$_GET[fi_st]'");
                        //com $criteria->condition = "JobAllocation.ja_status = '$_GET[fi_st]'";
                    }
                    $criteria->addCondition("JobAllocation.ja_partition_id = '0'");
                    //com $criteria->condition .= " and JobAllocation.ja_partition_id = '0'";
                    //$criteria->condition .= " and FilePartition.fp_cat_id = '0'";
                    //$criteria->condition .= " and FilePartition.fp_category = 'M'";
                    if (Yii::app()->session['user_type'] == "QC" && $_GET['fi_st'] == 'IQP') {
                        //com $criteria->condition .= ' and JobAllocation.ja_qc_id =' . Yii::app()->session['user_id'];
                        $criteria->addCondition('JobAllocation.ja_qc_id =' . Yii::app()->session['user_id']);
						$criteria->addCondition("fi_admin_lock= 'QL'");
                    }
					else{
						$criteria->addCondition("fi_admin_lock= 'O'");
					}
                    $criteria->addCondition("ja_flag = 'A'");
                    $criteria->addCondition("fp_flag = 'A'");
                }
                  /*if($_GET['fi_st'] == 'IC')
                  {
                      $criteria->addCondition("fi_admin_lock= 'O'");
                  }
                  else if($_GET['fi_st'] == 'IQP')
                  {
                      $criteria->addCondition("fi_admin_lock= 'QL'");
                  }*/
                $criteria->order = 'JobAllocation.ja_last_modified DESC';
            } else {
                $criteria->with = array('JobAllocation');
                $criteria->addCondition("fi_status = 'P' and JobAllocation.ja_job_id IS NULL");
                //com $criteria->condition = "fi_status = 'P' and JobAllocation.ja_job_id IS NULL";
                $criteria->order = 'fi_created_date DESC';
            }
            //Check Admin is locked file not show to reviewer and qc
            //$criteria->addCondition("fi_admin_lock= 'O'");

        }

        /*if (Yii::app()->session['user_type'] == "R") {
			if (isset($_GET['tabname'])){
				if ($_GET['tabname'] == "index") {
					$criteria->with = array('JobAllocation');
					$criteria->condition = 'JobAllocation.ja_indexer_id =' . Yii::app()->session['user_id'];
					$criteria->addCondition("JobAllocation.ja_status = 'IA'");
				} else if ($_GET['tabname'] == "split") {
					$criteria->with = array('JobAllocation', 'FilePartition');
					$criteria->condition = "FilePartition.fp_category = 'M' and JobAllocation.ja_status = 'SA' and ja_splitter_id =" . Yii::app()->session['user_id'] . " and ja_partition_id = fp_part_id";
				}
			}
        } */
//        $criteria->addCondition("fp_part_id IS NOT NULL or fp_flag = 'A'");
//        $criteria->addCondition("fp_flag = 'A'");

        if (!empty($_REQUEST['FileInfo']['indexer'])) {
            $indexer = $_REQUEST['FileInfo']['indexer'];
            $criteria->addCondition("UserDetails.ud_refid='$indexer'");
        }
        if (isset($_REQUEST['size'])) {
            $pagination = $_REQUEST['size'];
            Yii::app()->session['pagination'] = $_REQUEST['size'];
        } else {
            $pagination = Yii::app()->session['pagination'];
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'indexer' => array(
                        'asc' => 'UserDetails.ud_refid',
                        'desc' => 'UserDetails.ud_refid DESC',
                    ),
                    '*',
                ),
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
     * @return FileInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function GetName($uid, $status) {
        if ($status != 'P') {
            $usermodel = UserDetails::model()->findByPK($uid);
            return $usermodel->ud_username;
        } else {
            return null;
        }
    }

    public static function GetStatus($status) {
        if ($status == 'IC' || $status == 'SC') {
            return 'Pending';
        } else if ($status == 'IQP' || $status == "SQP") {
            return 'Progress';
        } else {
            return null;
        }
    }

    public static function GetFlag($status, $fi_status) {
        if ($fi_status == 'P') {
            switch ($status) {
                case "IA":
                    echo "<span class='uk-badge uk-badge-primary status-badge'>Prepping Progress</span>";
                    break;
                case "SA":
                    //echo "<span class='uk-badge uk-badge-warning status-badge'>Splitting Progress</span>";
                    echo "<span class='uk-badge uk-badge-warning status-badge'>Datecoding Progress</span>";
                    break;
                case "IQ":
                    echo "<span class='uk-badge uk-badge-danger status-badge'>Prepping Quitted</span>";
                    break;
                case "SQ":
                    echo "<span class='uk-badge uk-badge-danger status-badge'>Datecoding Quitted</span>";
                    break;
                case "IC":
                    echo "<span class='uk-badge uk-badge-grey status-badge'>Ready To prepping QC</span>";
                    break;
                case "SC":
                    echo "<span class='uk-badge uk-badge-grey status-badge'>Ready To Datecoding QC</span>";
                    break;
                case "SQP":
                    //echo "<span class='uk-badge uk-badge-pink status-badge'>Split QC Progress</span>";
                    echo "<span class='uk-badge uk-badge-pink status-badge'>Datecoding QC Progress</span>";
                    break;
                case "IQP":
                    echo "<span class='uk-badge uk-badge-pink status-badge'>Prepping QC Progress</span>";
                    break;
                case "QC":
                    echo "<span class='uk-badge uk-badge-success status-badge'>Ready For Editing</span>";
                    break;
                case "EA":
                    echo "<span class='uk-badge uk-badge-success status-badge'>Editing Progress</span>";
                    break;
                case "EC":
                    echo "<span class='uk-badge uk-badge-success status-badge'>Ready to Editing QC</span>";
                    break;
                case "EQ":
                    echo "<span class='uk-badge uk-badge-danger status-badge'>Editing Quitted</span>";
                    break;
                case "QEA":
                    echo "<span class='uk-badge uk-badge-success status-badge'>Editing QC Progress</span>";
                    break;
                case "QEC":
                    echo "<span class='uk-badge uk-badge-success status-badge'>Completed</span>";
                    break;
                default:
                    echo "<span class='uk-badge status-badge'>New File</span>";
            }
        } else if ($fi_status == 'C') {
            echo "<span class='uk-badge uk-badge-success status-badge'>Completed</span>";
        }
    }

    public static function getColor($pay_type) {
        $statuscolor = "";
        if ($pay_type == "IQP" || $pay_type == "SQP") {
            $statuscolor = 'green';
        } else if ($pay_type == "IQ" || $pay_type == "SQ") {
            $statuscolor = 'red';
        }
        return $statuscolor;
    }

    public static function ProcessVisible($Process) {
        switch ($Process) {
            case "All":
                return false;
                break;
            case "New":
                return false;
                break;
            case "Prepping":
                return true;
                break;
            case "Splitting":
                return true;
                break;
            case "Editor":
                return true;
                break;
            case "Completed":
                return false;
                break;
            default:
                return false;
        }
    }

	
	public static function currentstatus($cl_file_id) {
        $jobcl = JobAllocation::model()->findAll(array('condition' => "ja_file_id =$cl_file_id and ja_flag ='A'"));
        $clientarr = array();
        if ($jobcl) {
            foreach ($jobcl as $jbclient) {
                if ($jbclient->ja_status != "IQ" && $jbclient->ja_status != "SQ") {
                    $clientarr[] = $jbclient->ja_status;
                }
            }
            if (count($clientarr) == 1) {
                if ($clientarr[0] == 'SA') {
                    return 'IQ';
                } else {
                    return 'SQ';
                }
            } else if (count($clientarr) == 2) {
                if (in_array("SA", $clientarr)) {
                    $key = array_search('SA', $clientarr);
                    $inx = ($key == 0) ? 1 : 0;
                    switch ($clientarr[$inx]) {
                        case "IA":
                            return 'IA'; 
                            break;
                        case "IC":
                            return 'IC';
                            break;
                        case "IQP":
                            return 'IQP';
                            break;
                        case "QC":
                            return 'SA';
                            break;
                        default:
                            return "N";
                    }
                } else if (in_array("QC", $clientarr)) {
                    $key = array_search('QC', $clientarr);
                    $inx = ($key == 0) ? 1 : 0;
                    switch ($clientarr[$inx]) {
                        case "SA":
                            return 'SA';
                            break;
                        case "SC":
                            return 'SC';
                            break;
                        case "SQP":
                            return 'SQP';
                            break;
                        case "QC":
                            return 'QC';
                            break;
                        default:
                            return 'N';
                    }
                }
            } else {
                if (in_array("EA", $clientarr)) {
                    return 'EA';
                } else if (in_array("EC", $clientarr)) {
                    return 'EC';
                } else if (in_array("QEA", $clientarr)) {
                    return 'QEA';
                } else if (in_array("QEC", $clientarr)) {
                    return 'QEC';
                }
            }
        } else {
            return 'N';
        }
    }
	
	
    public static function clientstatus($cl_file_id) {
        $jobcl = JobAllocation::model()->findAll(array('condition' => "ja_file_id =$cl_file_id and ja_flag ='A'"));
        $clientarr = array();
        if ($jobcl) {
            foreach ($jobcl as $jbclient) {
                if ($jbclient->ja_status != "IQ" && $jbclient->ja_status != "SQ") {
                    $clientarr[] = $jbclient->ja_status;
                }
            }
            if (count($clientarr) == 1) {
                if ($clientarr[0] == 'SA') {
                    echo "<span class='uk-badge uk-badge-danger status-badge'>Prepping Quitted</span>";
                } else {
                    echo "<span class='uk-badge uk-badge-danger status-badge'>Datecoding Quitted</span>";
                }
            } else if (count($clientarr) == 2) {
                if (in_array("SA", $clientarr)) {
                    $key = array_search('SA', $clientarr);
                    $inx = ($key == 0) ? 1 : 0;
                    switch ($clientarr[$inx]) {
                        case "IA":
                            echo "<span class='uk-badge uk-badge-primary status-badge'>Prepping Progress</span>";
                            break;
                        case "IC":
                            echo "<span class='uk-badge uk-badge-grey status-badge'>Ready To prepping QC</span>";
                            break;
                        case "IQP":
                            echo "<span class='uk-badge uk-badge-pink status-badge'>Prepping QC Progress</span>";
                            break;
                        case "QC":
                            echo "<span class='uk-badge uk-badge-warning status-badge'>Datecoding Process</span>";
                            break;
                        default:
                            echo "<span class='uk-badge status-badge'>New File</span>";
                    }
                } else if (in_array("QC", $clientarr)) {
                    $key = array_search('QC', $clientarr);
                    $inx = ($key == 0) ? 1 : 0;
                    switch ($clientarr[$inx]) {
                        case "SA":
                            echo "<span class='uk-badge uk-badge-warning status-badge'>Datecoding Process</span>";
                            break;
                        case "SC":
                            echo "<span class='uk-badge uk-badge-grey status-badge'>Ready To Datecoding QC</span>";
                            break;
                        case "SQP":
                            echo "<span class='uk-badge uk-badge-pink status-badge'>Datecoding QC Process</span>";
                            break;
                        case "QC":
                            echo "<span class='uk-badge uk-badge-success status-badge'>Ready For Editing</span>";
                            break;
                        default:
                            echo "<span class='uk-badge status-badge'>New File</span>";
                    }
                }
            } else {
                if (in_array("EA", $clientarr)) {
                    echo "<span class='uk-badge uk-badge-success status-badge'>Editing Progress</span>";
                } else if (in_array("EC", $clientarr)) {
                    echo "<span class='uk-badge uk-badge-success status-badge'>Ready to Editing QC</span>";
                } else if (in_array("QEA", $clientarr)) {
                    echo "<span class='uk-badge uk-badge-success status-badge'>Editing QC Progress</span>";
                } else if (in_array("QEC", $clientarr)) {
                    echo "<span class='uk-badge uk-badge-success status-badge'>Completed</span>";
                }
            }
        } else {
            echo "<span class='uk-badge status-badge'>New File</span>";
        }
    }

    public static function clientflag($cl_file_id) {
        $jobcl = JobAllocation::model()->findAll(array('condition' => "ja_file_id =$cl_file_id and ja_flag ='A'"));
        $clientarr = array();
        if ($jobcl) {
            foreach ($jobcl as $jbclient) {
                if ($jbclient->ja_status != "IQ" && $jbclient->ja_status != "SQ") {
                    $clientarr[] = $jbclient->ja_status;
                }
            }
            if (in_array("QEC", $clientarr)) {
                return "C";
            }
        }
    }
	
    public static function ActionButton($fid, $utype, $jid = "", $jtype = "", $partId = "") {
        $buttons = "<div class='ActionButton'>";
        if ($jtype != "") {
            if ($jtype == "IA") {
                if ($utype == "R") {
                    $buttons .= "<a onclick='checklock($fid)' id='checkbefore_$fid' ><i class='material-icons'>&#xE8E5;</i></a>";
                    $buttons .= "<a  style='visibility:hidden;' id='checkafter_$fid' href='" . Yii::app()->createUrl('fileinfo/fileindexing', array('id' => $fid, 'status' => 'R')) . "'><i class='material-icons'>&#xE8E5;</i></a>";
                } elseif ($utype == "QC") {
                    $buttons .= "<a href='" . Yii::app()->createUrl('fileinfo/fileindexing', array('id' => $fid, 'status' => 'QC')) . "'><i class='material-icons'>&#xE8E5;</i></a>";
                    //$buttons .= "<a href='fileindexing/$fid'><i class='material-icons'>&#xE8E5;</i></a>";
                }
            } else if ($jtype == "IQ") {
                if ($utype == "A" || $utype == "TL") {
                    //$buttons .= "<a class='IndexReallocate' href='javascript:void(0)' onclick='IndexReallocate($jid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
                    $buttons .= "<a class='IndexReallocate' href='javascript:void(0)' onclick='IndexReallocate($fid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
                }
            } /* else if($jtype == "IC"){
			if($utype == "A"){   
			   $buttons .= "<a class='SplitAllocate' href='javascript:void(0)' onclick='SplitAllocate($jid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
			}
		   } */
            else if ($jtype == "IC") {
                if ($utype == "QC") {
                    $buttons .= "<a class='IndexQc' href='javascript:void(0)' onclick='IndexQc($jid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
                }
            } else if ($jtype == "IQP" || $jtype == "SQP") {
                if ($utype == "QC") {
                    if ($jtype == "IQP") {
                        $buttons .= "<a href='fileindexing/$partId?status=QC' title='Prepping Pages'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons'>&#xE8E5;</i></a>";
                    }
                    $jobloc = JobAllocation::model()->findByPk($jid);
                    $medloc = FilePartition::model()->find(array('condition' => "fp_file_id =$jobloc->ja_file_id and fp_flag ='A' and fp_category='M'"));
                    if (!empty($medloc->fp_page_nums)) {
                        $buttons .= "<a class='CompleteQc' href='javascript:void(0)' onclick='CompleteQc($jid)' title='Move to Split'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>folder_shared</i></a>";
                    }
                }
            } else if ($jtype == "SA") {
                if ($utype == "R" || $utype == "QC") {
                    $buttons .= "<a href='filesplit/$partId'><i class='material-icons'>&#xE8E5;</i></a>";
                } else if ($utype == "A" || $utype == "TL") {
                    $buttons .= "<a class='SplitReallocate' href='javascript:void(0)' onclick='SplitReallocate($jid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
                }
            }
        } else {
            if ($utype == "A") {
                $buttons .= "<a class='IndexAllocate' href='javascript:void(0)' onclick='IndexAllocate($fid)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
            } else if ($utype == "C") {
                $infomodel = FileInfo::model()->findByPk($fid);
                if (FileInfo::clientflag($fid) == "C") {
                    if ($infomodel->ProjectMaster->p_op_format == "XLS") {
                        $buttons .= '<a href="javascript:void(0)" class="export" onclick="exportxls(' . $fid . ')"><i class="material-icons">&#xE2C4;</i></a>';
                    } else if ($infomodel->ProjectMaster->p_op_format == "DOCX") {
                        $exactpath = Yii::app()->basePath . "/../clientdownload/" . Yii::app()->user->id . "/" . $fid . ".doc";
                        if (file_exists($exactpath)) {
                            $buttons .= CHtml::link('<i class="material-icons">&#xE2C4;</i>', Yii::app()->createUrl("fileinfo/clientdownload", array('cl_id' => Yii::app()->user->id, 'f_id' => $fid)));
                        }
                    } else {
                        $buttons .= CHtml::link('<i class="material-icons">&#xE2C4;</i>', Yii::app()->createUrl("fileinfo/download", array('p_id' => $infomodel->ProjectMaster->p_pjt_id, 'f_id' => $fid, 'f_format' => $infomodel->ProjectMaster->p_op_format)));
                    }
                }
                //$buttons .= "<a class='fileview' href='javascript:void(0)' onclick='fileview($fid)'><i class='material-icons md-24'>visibility</i></a>";
            }
        }
        $buttons .= "</div>";
        return $buttons;
    }


    public static function ActionButtons($id, $type, $tabname = "", $partId = "") {
        $buttons = "<div class='ActionButton'>";
        if ($type == "P" && empty($_GET['indexing'])) {
            $buttons .= "<a class='IndexAllocate' href='javascript:void(0)' onclick='IndexAllocate($id)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
        } else if ($type == "IC") {
            $buttons .= "<a class='SplitAllocate' href='javascript:void(0)' onclick='SplitAllocate($id)'><i class='material-icons md-24'>&#xE8E5;</i></a>";
        } else if (!empty($_GET['indexing'])) {
            if ($tabname == "index") {
                $buttons .= "<a class='IndexAllocate' href='fileindexing/$id'><i class='material-icons'>&#xE8E5;</i></a>";
            } else if ($partId != "") {
                $buttons .= "<a class='IndexAllocate' href='filesplit/$partId'><i class='material-icons'>&#xE8E5;</i></a>";
            }
        }

        //$buttons .= "<a class='ReviewAllocate' href='javascript:void(0)' onclick='ReviewAllocate($id)'><i class='material-icons'>&#xE8E5;</i></a>";
        $buttons .= "</div>";
        echo $buttons;
    }

    public static function dateformat($data, $prj_id) {
        $prjdetails = Project::model()->findByPk($prj_id);
        $filedata=array();
        if(!empty($prjdetails->date_format))
        {
            $filedata = array_keys(json_decode($prjdetails->date_format,true));
            //print_r($filedata[0]);die;
        }
        $dateformat =!empty($filedata[0])?$filedata[0]:'d M Y H:i:s';
        $data=str_replace('/','-',$data);
        $date = date($dateformat ,strtotime($data));
        return $date;
    }

    public static function checkUniq($array) {
        $newArray = array();
        $checkKey = array();
        foreach ($array as $key => $value) {
            $aValue = trim($value);
            if ($aValue) {
                if (!isset($checkKey[$aValue])) {
                    $newArray[] = $aValue;
                }
                $checkKey[$aValue] = $aValue;
            }
        }
        return $newArray;
    }

}
