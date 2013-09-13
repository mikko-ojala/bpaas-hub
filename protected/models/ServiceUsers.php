<?php

/**
 * This is the model class for table "service_users".
 *
 * The followings are the available columns in table 'service_users':
 * @property integer $visibility
 * @property integer $privacy
 * @property integer $owner
 * @property integer $reserved1
 * @property integer $reserved2
 * @property integer $service_id
 * @property integer $users_id
 */
class ServiceUsers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visibility, privacy, owner, reserved1, reserved2, service_id, users_id', 'required'),
			array('visibility, privacy, owner, reserved1, reserved2, service_id, users_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('visibility, privacy, owner, reserved1, reserved2, service_id, users_id', 'safe', 'on'=>'search'),
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
			'visibility' => 'Visibility to users',
			'privacy' => 'Privacy to users',
			'owner' => 'Owner',
			'reserved1' => 'Reserved1',
			'reserved2' => 'Reserved2',
			'service_id' => 'Service',
			'users_id' => 'Users',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('visibility',$this->visibility);
		$criteria->compare('privacy',$this->privacy);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('reserved1',$this->reserved1);
		$criteria->compare('reserved2',$this->reserved2);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('users_id',$this->users_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}