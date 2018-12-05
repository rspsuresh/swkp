<?php

/**
 * This is the model class for table "job_allocation_ja".
 *
 * The followings are the available columns in table 'job_allocation_ja':
 * @property string $ja_job_id
 * @property string $ja_partition_id
 * @property string $ja_qc_id
 * @property string $ja_qc_allocated_time
 * @property string $ja_allocated_by
 * @property string $ja_qc_allocated_by
 * @property string $ja_qc_accepted_time
 * @property string $ja_qc_completed_time
 * @property string $ja_qc_notes
 * @property string $ja_reviewer_id
 * @property string $ja_reviewer_allocated_time
 * @property string $ja_reviewer_accepted_time
 * @property string $ja_reviewer_completed_time
 * @property string $ja_reviewer_notes
 * @property string $ja_tl_id
 * @property string $ja_tl_accepted_time
 * @property string $ja_tl_completed_time
 * @property string $ja_tl_notes
 * @property string $ja_status
 * @property string $ja_created_date
 * @property string $ja_last_modified
 * @property string $ja_reason
 * @property string $ja_flag
 */
class JobAllocation extends CActiveRecord {
    public $user_id;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'job_allocation_ja';
    }

    public $indexer_id, $splitter_id, $description, $option,$quit_process,$ja_qc_feedback,$ja_reviewer_feedback,$revchk,$review;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('ja_partition_id, ja_file_id, ja_qc_id, ja_qc_allocated_time, ja_allocated_by, ja_qc_allocated_by, ja_qc_accepted_time, ja_qc_completed_time, ja_qc_notes, ja_reviewer_id, ja_reviewer_allocated_time, ja_reviewer_accepted_time, ja_reviewer_completed_time, ja_reviewer_notes, ja_tl_id, ja_tl_accepted_time, ja_tl_completed_time, ja_tl_notes, ja_created_date, ja_last_modified', 'required'),
            //array('user_id, ja_file_id', 'required'),
            array('indexer_id,splitter_id', 'required', 'on' => 'allocate'),
            array('description,option', 'required', 'on' => 'quit'),
            array('option,quit_process', 'required', 'on' => 'quitProcess'),
            array('user_id', 'required', 'on' => 'reallocate'),
            array('ja_status', 'required', 'on' => 'processSwap'),
           // array('ja_partition_id, ja_qc_id, ja_allocated_by, ja_qc_allocated_by, ja_reviewer_id, ja_tl_id', 'length', 'max' => 20),
            array('ja_partition_id, ja_qc_id, ja_allocated_by,ja_reviewer_id', 'length', 'max' => 20),
            array('ja_status', 'length', 'max' => 3),
            array('ja_flag, ja_skip_qc', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //array('ja_job_id, ja_partition_id, ja_qc_id, ja_qc_allocated_time, ja_allocated_by, ja_qc_allocated_by, ja_qc_accepted_time, ja_qc_completed_time, ja_qc_notes, ja_reviewer_id, ja_reviewer_allocated_time, ja_reviewer_accepted_time, ja_reviewer_completed_time, ja_reviewer_notes, ja_tl_id, ja_tl_accepted_time, ja_tl_completed_time, ja_tl_notes, ja_status, ja_created_date, ja_last_modified, ja_flag', 'safe', 'on' => 'search'),
            array('ja_job_id, ja_partition_id, ja_qc_id, ja_allocated_by, ja_skip_qc, ja_qc_accepted_time, ja_qc_completed_time, ja_qc_notes, ja_reviewer_id, ja_reviewer_allocated_time, ja_reviewer_accepted_time, ja_reviewer_completed_time, ja_status, ja_created_date, ja_last_modified, ja_flag', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'FileInfo' => array(self::HAS_ONE, 'FileInfo', 'fi_file_id'),
            'UserDetails' => array(self::BELONGS_TO, 'UserDetails', 'ja_reviewer_id'),
            'UserDetailsqc' => array(self::BELONGS_TO, 'UserDetails', 'ja_qc_id'),
            'fileinfo' => array(self::BELONGS_TO, 'FileInfo', 'ja_file_id'),
            'Rvrname' => array(self::BELONGS_TO, 'UserDetails', 'ja_reviewer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'Employee',
            'ja_job_id' => 'Ja Job',
            'ja_partition_id' => 'Ja Partition',
            'ja_file_id' => 'File Id',
            'ja_qc_id' => 'Ja Qc',
            //'ja_qc_allocated_time' => 'Ja Qc Allocated Time',
            'ja_allocated_by' => 'Ja Allocated By',
           // 'ja_qc_allocated_by' => 'Ja Qc Allocated By',
            'ja_qc_accepted_time' => 'Ja Qc Accepted Time',
            'ja_qc_completed_time' => 'Ja Qc Completed Time',
            //'ja_qc_notes' => 'Ja Qc Notes',
            'ja_reviewer_id' => 'Ja Reviewer',
            'ja_reviewer_allocated_time' => 'Ja Reviewer Allocated Time',
            'ja_reviewer_accepted_time' => 'Ja Reviewer Accepted Time',
            'ja_reviewer_completed_time' => 'Ja Reviewer Completed Time',
            //'ja_reviewer_notes' => 'Ja Reviewer Notes',
            //'ja_tl_id' => 'Ja Tl',
            //'ja_tl_accepted_time' => 'Ja Tl Accepted Time',
            //'ja_tl_completed_time' => 'Ja Tl Completed Time',
            //'ja_tl_notes' => 'Ja Tl Notes',
            'ja_status' => 'Status',
			'ja_skip_qc' => 'Skipping QC',
            'ja_created_date' => 'Ja Created Date',
            'ja_last_modified' => 'Ja Last Modified',
            'ja_flag' => 'Ja Flag',
            'indexer_id' => 'Prepper',
            'splitter_id' => 'DateCoder',
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

        $criteria->compare('ja_job_id', $this->ja_job_id, true);
        $criteria->compare('ja_partition_id', $this->ja_partition_id, true);
        $criteria->compare('ja_qc_id', $this->ja_qc_id, true);
        $criteria->compare('ja_qc_allocated_time', $this->ja_qc_allocated_time, true);
        $criteria->compare('ja_allocated_by', $this->ja_allocated_by, true);
       // $criteria->compare('ja_qc_allocated_by', $this->ja_qc_allocated_by, true);
        $criteria->compare('ja_qc_accepted_time', $this->ja_qc_accepted_time, true);
        $criteria->compare('ja_qc_completed_time', $this->ja_qc_completed_time, true);
        //$criteria->compare('ja_qc_notes', $this->ja_qc_notes, true);
        $criteria->compare('ja_reviewer_id', $this->ja_reviewer_id, true);
        $criteria->compare('ja_reviewer_allocated_time', $this->ja_reviewer_allocated_time, true);
        $criteria->compare('ja_reviewer_accepted_time', $this->ja_reviewer_accepted_time, true);
        $criteria->compare('ja_reviewer_completed_time', $this->ja_reviewer_completed_time, true);
        //$criteria->compare('ja_reviewer_notes', $this->ja_reviewer_notes, true);
        //$criteria->compare('ja_tl_id', $this->ja_tl_id, true);
        //$criteria->compare('ja_tl_accepted_time', $this->ja_tl_accepted_time, true);
        //$criteria->compare('ja_tl_completed_time', $this->ja_tl_completed_time, true);
        //$criteria->compare('ja_tl_notes', $this->ja_tl_notes, true);
        $criteria->compare('ja_status', $this->ja_status, true);
        $criteria->compare('ja_skip_qc', $this->ja_skip_qc, true);
        $criteria->compare('ja_created_date', $this->ja_created_date, true);
        $criteria->compare('ja_last_modified', $this->ja_last_modified, true);
        $criteria->compare('ja_flag', $this->ja_flag, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobAllocation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @Grid Action Button
     */
    public static function ActionButtons($id) {
        $buttons = "<div class='ActionButton'>";
        $buttons .= "<a class='userView' href='javascript:void(0)' onclick='userView($id)'  title='View'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE8F4;</i></a>";
        $buttons .= "<a class='userUpdate' href='javascript:void(0)' onclick='userUpdate($id)' title='Update'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>edit</i></a>";
        $buttons .= "<a class='userDelete' href='javascript:void(0)' onclick='userDelete($id)' title='Delete'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE872;</i></a>";
        $buttons .= "</div>";
        echo $buttons;
    }
	
	public static function LoadData($file) {
        $lines = file($file);
        $data = array();
        $summaryTemp = array();
        $temp = 0;
        $temp1 = 0;
        $summaryTemp = array();
        foreach ($lines as $key => $line) {
            $sumTempData = explode('|', trim($line));
            if (isset($sumTempData[15])) {
                if ($temp1 > 0) {
                    $temp++;
                    $temp1 = 0;
                }
                $summaryTemp[$temp] = empty($sumTempData[15]) ? "" : $sumTempData[15];
                $l = 16;
                while ($l > 0) {
                    if (isset($sumTempData[$l])) {
                        $summaryTemp[$temp] .= " " . $sumTempData[$l];
                        $l++;
                    }
                    else{
                        break;
                    }
                }
            } else {
                $summaryTemp[$temp] .= " " . $sumTempData[0];
            }
            $temp1 ++;
        }
      $temp3 = 0;
        foreach ($lines as $key => $line) {
      
            $tempData = explode('|', trim($line));
            if (isset($tempData[15])) {
				$page = empty($tempData[0]) ? "" : $tempData[0];
                $dos = empty($tempData[1]) ? "Undated" : $tempData[1];
				$patname = empty($tempData[2]) ? "" : $tempData[2];
				$category = empty($tempData[3]) ? "" : $tempData[3];
                $provider = empty($tempData[4]) ? "" : $tempData[4];
				$gender = empty($tempData[5]) ? "" : $tempData[5];
				$doi = empty($tempData[6]) ? "" : $tempData[6];
				$facility = empty($tempData[7]) ? "" : $tempData[7];
				$catname = empty($tempData[8]) ? "" : $tempData[8];
				$dob = empty($tempData[9]) ? "" : $tempData[9];
				$type = empty($tempData[10]) ? "" : $tempData[10];
				$current_date = empty($tempData[11]) ? "" : $tempData[11];
				$title = empty($tempData[12]) ? "" : $tempData[12];
				$serial = empty($tempData[13]) ? "" : $tempData[13];
				$reviewer_id = empty($tempData[14]) ? "" : $tempData[14];
                $summary = $summaryTemp[$temp3];
                $temp3++;
            } else {
                continue;
            }
            $tempData = array($page,$dos,$patname,$category,$provider,$gender,$doi,$facility,$catname,$dob,$type,$current_date,$title,$serial,$reviewer_id,$summary);
            $data[] = $tempData;
        }
        return $data;
    }
}
