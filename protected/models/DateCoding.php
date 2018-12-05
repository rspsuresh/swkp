<?php

/**
 * This is the model class for Custom Model.
 *
 * The followings are the available columns in this Class:
 * @property string $pages
 * @property string $dos
 * @property string $project
 * @property string $provider_name
 * @property string $patient_name
 * @property string $description
 */
class DateCoding extends CFormModel {

    public $pages;
    public $dos;
	public $todos;
	public $dob;
    public $project;
    public $file;
    public $provider_name;
    public $patient_name;
    public $category;
    public $record_row;
    public $gender;
    public $doi;
    public $facility;
    public $undated;
    public $title;
    public $type;
    public $body_parts;
    public $ecd_9_diagnoses;
    public $ecd_10_diagnoses;
    public $dx_terms;
	public $ms_terms;
	public $ms_value;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pages,project,file,patient_name,category,gender,doi,type,dob', 'required'),
//            array('dos,undated', 'oneOfThree'),
            array('pages', 'length', 'max' => 250),
            //array('body_parts', 'diagnoses','length', 'max' => 250),
//            array('patient_name,provider_name', 'length', 'max' => 25),
            array('pages', 'length', 'max' => 250),
            array('dos,todos', 'length', 'max' => 20),
            array('file,project,category', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'doi' => 'DOI',
			'ecd_9_diagnoses' => 'Diagnosis (ICD-9 Codes)',
			'ecd_10_diagnoses' => 'Diagnosis (ICD-10 Codes)',
            'dx_terms'=>'Dx Terms',
			'todos' => 'To DOS', 
			'ms_terms' => 'Measure Terms',
			'ms_value' => 'Measure Value',
        );
    }

    public function passwordStrength($attribute, $params) {

        if ($attribute) {
            $this->addError($attribute, 'your password is not strong enough!');
            return false;
        }
    }

    public function my_required($attribute_name, $params) {
        if (empty($this->username) && empty($this->email)
        ) {
            $this->addError($attribute_name, Yii::t('user', 'At least 1 of the field must be filled up properly'));

            return false;
        }

        return true;
    }

    public function oneOfThree($attribute, $params) {

        if ($_POST['DateCoding']['dos'] == "" && !$_POST['DateCoding']['undated']) {
            $this->addError($attribute, 'Either DOS or Undated is required!.');
        } else {
            return true;
        }
    }

}

?>