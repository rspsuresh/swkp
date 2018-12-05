<?php

/**
 * This is the model class for table "category_ct".
 *
 * The followings are the available columns in table 'category_ct':
 * @property string $ct_cat_id
 * @property string $ct_cat_name
 * @property string $ct_keywords
 * @property string $ct_cat_type
 * @property string $ct_created_date
 * @property string $ct_last_modified
 * @property string $ct_flag
 */
class Category extends CActiveRecord {
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'category_ct';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ct_cat_name, ct_keywords, ct_cat_type', 'required'),
            array('ct_created_date, ct_last_modified', 'safe'),
            array('ct_cat_name', 'length', 'max' => 250),
            array('ct_cat_type, ct_flag', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ct_cat_id, ct_cat_name, ct_keywords, ct_cat_type, ct_created_date, ct_last_modified, ct_flag', 'safe', 'on' => 'search'),
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
            'ct_cat_id' => 'Ct Cat',
            'ct_cat_name' => 'Category Name',
            'ct_keywords' => 'Keywords',
            'ct_cat_type' => 'Category Type',
            'ct_created_date' => 'Ct Created Date',
            'ct_last_modified' => 'Ct Last Modified',
            'ct_flag' => 'Ct Flag',
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
        $criteria->addCondition(' ct_flag = "' . $status . '"');

        $criteria->compare('ct_cat_id', $this->ct_cat_id, true);
        $criteria->compare('ct_cat_name', $this->ct_cat_name, true);
        $criteria->compare('ct_keywords', $this->ct_keywords, true);
        $criteria->compare('ct_cat_type', $this->ct_cat_type, true);
        $criteria->compare('ct_created_date', $this->ct_created_date, true);
        $criteria->compare('ct_last_modified', $this->ct_last_modified, true);
        $criteria->compare('ct_flag', $this->ct_flag, true);

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
     * @return Category the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public function beforeSave() {

        if ($this->isNewRecord) {
            $this->ct_created_date = date("Y-m-d H:i");
        }
        $this->ct_last_modified = date("Y-m-d H:i");
        return parent::beforeSave();
    }

    public static function ActionButtons($id) {
        $buttons = "<div class='ActionButton'>";
        $buttons .= "<a class='categoryView' href='javascript:void(0)' onclick='categoryView($id)' title='View'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE8F4;</i></a>";
        if (Yii::app()->session['user_type'] == "A") {
            $buttons .= "<a class='categoryUpdate' href='javascript:void(0)' onclick='categoryUpdate($id)' title='Update'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>edit</i></a>";
            $buttons .= "<a class='categoryRemove' href='javascript:void(0)' onclick='categoryRemove($id)' title='Delete'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE872;</i></a>";
        }
        $buttons .= "</div>";
        echo $buttons;
    }

    /**
     * @Explode Category
     */
    public static function getCategory($id) {
        $return = '';
        $explode = explode(',', $id);
        $query = Category::model()->findAllByPk($explode);
        $cat = array();
        if ($query) {
            foreach ($query as $value) {
                $cat[] = $value->ct_cat_name;
            }
            $return = implode(', ', $cat);
        }
        return $return;
    }

    /**
     * get Category Name
     */
    public static function getCatName($id) {
        $return = '';
        $query = Category::model()->findByPk($id);
        if ($query) {
            $return = $query->ct_cat_name;
        }
        return $return;

    }

}
