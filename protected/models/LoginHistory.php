<?php

/**
 * This is the model class for table "login_history_lh".
 *
 * The followings are the available columns in table 'login_history_lh':
 * @property string $lh_id
 * @property string $lh_uid
 * @property string $lh_in_dt
 * @property string $lh_out_dt
 * @property string $lh_ip_address
 */
class LoginHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'login_history_lh';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lh_uid, lh_in_dt, lh_out_dt, lh_ip_address', 'required'),
			array('lh_uid', 'length', 'max'=>20),
			array('lh_ip_address', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lh_id, lh_uid, lh_in_dt, lh_out_dt, lh_ip_address', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lh_id' => 'Lh',
			'lh_uid' => 'Lh Uid',
			'lh_in_dt' => 'Lh In Dt',
			'lh_out_dt' => 'Lh Out Dt',
			'lh_ip_address' => 'Lh Ip Address',
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

		$criteria->compare('lh_id',$this->lh_id,true);
		$criteria->compare('lh_uid',$this->lh_uid,true);
		$criteria->compare('lh_in_dt',$this->lh_in_dt,true);
		$criteria->compare('lh_out_dt',$this->lh_out_dt,true);
		$criteria->compare('lh_ip_address',$this->lh_ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LoginHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
