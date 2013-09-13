<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $id
 * @property string $name
 * @property string $create_at
 * @property string $modified_at
 * @property string $deleted_at
 * @property integer $active
 * @property integer $system_active
 *
 * The followings are the available model relations:
 * @property ServiceHasService[] $serviceHasServices
 * @property ServiceHasService[] $serviceHasServices1
 * @property ServiceImage[] $serviceImages
 * @property Organisation[] $organisations
 * @property ServiceProfile $serviceProfile
 * @property Users[] $users
 */
class Service extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Service the static model class
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
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, create_at', 'required'),
			array('active, system_active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('modified_at, deleted_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, create_at, modified_at, deleted_at, active, system_active', 'safe', 'on'=>'search'),
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
			'serviceHasServices' => array(self::HAS_MANY, 'ServiceHasService', 'service_id'),
			'serviceHasServices1' => array(self::HAS_MANY, 'ServiceHasService', 'service_id1'),
			'serviceImages' => array(self::HAS_MANY, 'ServiceImage', 'service_id'),			
			'organisations' => array(self::MANY_MANY, 'Organisation', 'service_organisation(service_id, organisation_id)'),
			'serviceProfile' => array(self::HAS_ONE, 'ServiceProfile', 'service_id'),
			'users' => array(self::MANY_MANY, 'Users', 'service_users(service_id, users_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'create_at' => 'Create At',
			'modified_at' => 'Modified At',
			'deleted_at' => 'Deleted At',
			'active' => 'Active',
			'system_active' => 'System Active',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('deleted_at',$this->deleted_at,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('system_active',$this->system_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		$this->modified_at =  new CDbExpression('NOW()');
		return parent::beforeSave();		
	}
}