<?php

/**
 * This is the model class for table "enquiry_eq".
 *
 * The followings are the available columns in table 'enquiry_eq':
 * @property integer $eq_id
 * @property integer $eq_description
 * @property integer $eq_mail
 * @property integer $eq_created_dt
 * @property integer $eq_last_modified
 * @property string $eq_flag
 */
class Enquiry extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'enquiry_eq';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('eq_description', 'required'),
            array('eq_flag', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('eq_id, eq_description, eq_mail, eq_created_dt, eq_last_modified, eq_flag', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'eq_id' => 'Eq',
            'eq_description' => 'Eq Description',
            'eq_name' => 'Name',
            'eq_mail' => 'Mail',
            'eq_created_dt' => 'Enquiry Date',
            'eq_last_modified' => 'Eq Last Modified',
            'eq_flag' => 'Eq Flag',
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

        $criteria->compare('eq_id', $this->eq_id);
        $criteria->compare('eq_description', $this->eq_description);
        $criteria->compare('eq_mail', $this->eq_mail);
        $criteria->compare('eq_created_dt', $this->eq_created_dt);
        $criteria->compare('eq_last_modified', $this->eq_last_modified);
        $criteria->compare('eq_flag', $this->eq_flag, true);
        
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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Enquiry the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {

        if ($this->isNewRecord) {
            $this->eq_created_dt = date("Y-m-d H:i");
        }
        $this->eq_last_modified = date("Y-m-d H:i");
        return parent::beforeSave();
    }
    public static function ActionButtons($id) {
        $buttons = "<div class='ActionButton'>";
        $buttons .= "<a class='categoryView' href='javascript:void(0)' onclick='enquiryView($id)' title='View'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE8F4;</i></a>";
        $buttons .= "</div>";
        echo $buttons;
    }

}
