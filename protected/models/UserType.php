<?php

/**
 * This is the model class for table "user_type_ut".
 *
 * The followings are the available columns in table 'user_type_ut':
 * @property string $ut_refid
 * @property string $ut_usertype
 * @property string $ut_created_date
 * @property string $ut_last_modified_date
 * @property string $ut_flag
 */
class UserType extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_type_ut';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ut_usertype, ut_name', 'required'),
            array('ut_usertype', 'length', 'max' => 3),
            array('ut_flag', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ut_refid, ut_usertype,ut_name, ut_created_date, ut_last_modified_date, ut_flag', 'safe', 'on' => 'search'),
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
            'ut_refid' => 'Ut Refid',
            'ut_usertype' => 'Ut Usertype',
            'ut_name' => 'Ut Name',
            'ut_created_date' => 'Ut Created Date',
            'ut_last_modified_date' => 'Ut Last Modified Date',
            'ut_flag' => 'Ut Flag',
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

        $criteria->compare('ut_refid', $this->ut_refid, true);
        $criteria->compare('ut_usertype', $this->ut_usertype, true);
        $criteria->compare('ut_created_date', $this->ut_created_date, true);
        $criteria->compare('ut_last_modified_date', $this->ut_last_modified_date, true);
        $criteria->compare('ut_flag', $this->ut_flag, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if ($this->getIsNewRecord())
            $this->ut_created_date = date('Y-m-d H:i:s');

        $this->ut_last_modified_date = date('Y-m-d H:i:s');
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
