<?php

/**
 * This is the model class for table "templates".
 *
 * The followings are the available columns in table 'templates':
 * @property integer $id
 * @property integer $op_id
 * @property integer $t_id
 * @property string $t_status
 */
class Templates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'templates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, output, t_name', 'required'),
            array('output,t_name', 'required', 'on' => 'pcreate'),
            array('output,t_name,parent_id', 'required', 'on' => 'ccreate'),
			array('t_status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, output, t_name, t_status,parent_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'output' => array(self::BELONGS_TO, 'Output', 'op_id'),
		    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'output' => 'Output Format',
			't_name' => 'Template Name',
			't_status' => 'T Status',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $status = (isset($_GET['status'])) ? $_GET['status'] : "A";
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            if ($type == 'P') {
                $criteria->addCondition('parent_id = "0" and t_status = "' . $status . '"');
            } elseif ($type == 'C') {
                $criteria->addCondition('parent_id != "0" and t_status = "' . $status . '"');
            }
        } else {
            $criteria->addCondition('parent_id = "0" and t_status = "' . $status . '"');
        }
        $criteria->addCondition(' t_status = "' . $status . '"');
        $criteria->compare('id',$this->id);
		$criteria->compare('output',$this->output);
		$criteria->compare('t_name',$this->t_name);
		$criteria->compare('t_status',$this->t_status,true);

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
	 * @return Templates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function ActionButtons($id) {
		$model=Templates::model()->findByPk($id);
        $buttons = "<div class='ActionButton'>";
        $buttons .= "<a class='templateRemove' href='javascript:void(0)' onclick='templatedownload($id)' title='Download'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>&#xE2C4;</i></a>";
		if($model->parent_id != 0){
			$buttons .= "<a class='tempedit' href='javascript:void(0)' onclick='tempedit($id)' title='Update'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons md-24'>edit</i></a>";
        }
		$buttons .= "</div>";
        echo $buttons;
    }
}
