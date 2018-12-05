<?php

/**
 * This is the model class for table "client_details_cd".
 *
 * The followings are the available columns in table 'client_details_cd':
 * @property string $cd_id
 * @property string $cd_downloadtype
 * @property integer $cd_projectid
 * @property string $cd_url
 * @property string $cd_username
 * @property string $cd_password
 * @property integer $cd_port
 * @property string $cd_folderpath
 * @property string $cd_file_out_format
 * @property string $cd_file_in_format
 * @property string $cd_price
 * @property string $otherHours
 * @property string $cd_created_date
 * @property string $cd_last_modified_date
 * @property string $cd_flag
 */
class ClientDetails extends CActiveRecord {

    public $cd_other_hours;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'client_details_cd';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cd_downloadtype, cd_projectid, cd_url, cd_port, cd_created_date, cd_last_modified_date', 'required'),
            array('cd_file_out_format, cd_file_in_format, cd_hours, cd_other_hours, cd_price', 'required', 'on' => 'signup,enquiry'),
            array('cd_projectid, cd_port, cd_other_hours', 'numerical', 'integerOnly' => true),
            array('cd_downloadtype, cd_flag', 'length', 'max' => 1),
//            array('cd_file_out_format, cd_file_in_format', 'length', 'max' => 10),
            array('cd_price', 'numerical'),
            array('cd_url, cd_folderpath', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cd_id, cd_downloadtype, cd_projectid, cd_url, cd_port, cd_folderpath, cd_created_date, cd_last_modified_date, cd_flag', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'cd_id' => 'Cd',
            'cd_downloadtype' => 'Download Type',
            'cd_projectid' => 'Project',
            'cd_url' => 'Url',
            //'cd_username' => ' Username',
            //'cd_password' => ' Password',
            'cd_port' => 'Port',
            'cd_folderpath' => 'Folderpath',
            'cd_file_out_format' => 'File Output Format',
            'cd_file_in_format' => 'File Input Format',
            'cd_hours' => 'Tat time',
            'cd_other_hours' => 'Other Hours',
            'cd_price' => 'Price',
            'cd_created_date' => 'Created Date',
            'cd_last_modified_date' => 'Last Modified Date',
            'cd_flag' => 'Flag',
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

        $criteria->compare('cd_id', $this->cd_id, true);
        $criteria->compare('cd_downloadtype', $this->cd_downloadtype, true);
        $criteria->compare('cd_projectid', $this->cd_projectid);
        $criteria->compare('cd_url', $this->cd_url, true);
        //$criteria->compare('cd_username',$this->cd_username,true);
        //$criteria->compare('cd_password',$this->cd_password,true);
        $criteria->compare('cd_port', $this->cd_port);
        $criteria->compare('cd_folderpath', $this->cd_folderpath, true);
        $criteria->compare('cd_created_date', $this->cd_created_date, true);
        $criteria->compare('cd_last_modified_date', $this->cd_last_modified_date, true);
        $criteria->compare('cd_flag', $this->cd_flag, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ClientDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {

        if ($this->isNewRecord) {
            $this->cd_created_date = date("Y-m-d H:i");
        }
        $this->cd_last_modified_date = date("Y-m-d H:i");
        return parent::beforeSave();
    }

    protected function afterFind() {
        if ($this->cd_port == '0') {
            $this->cd_port = "";
        }
        return parent::afterFind();
    }
}
