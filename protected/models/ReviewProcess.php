<?php

/**
 * This is the model class for Custom Model.
 *
 * The followings are the available columns in this Class:
 * @property string $dos
 * @property string $pos
 * @property string $pages
 * @property string $patient_name
 * @property string $description
 */
class ReviewProcess extends CFormModel {
    public $dos;
    public $pos;
    public $pages;
    public $description;
    public $patient_name;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dos,pos,pages,patient_name,description', 'required'),
            array('pos', 'length', 'max' => 100),
            array('dos', 'safe'),
            array('patient_name', 'length', 'max' => 40),
        );
    }

}

?>