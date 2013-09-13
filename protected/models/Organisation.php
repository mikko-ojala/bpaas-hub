<?php

/**
 * This is the model class for table "organisation".
 *
 * The followings are the available columns in table 'organisation':
 * @property integer $id
 * @property string $create_at
 * @property string $modified_at
 * @property string $deleted_at
 * @property integer $active
 * @property integer $system_active
 * @property string $name
 *
 * The followings are the available model relations:
 * @property OrganisationHasOrganisation[] $organisationHasOrganisations
 * @property OrganisationHasOrganisation[] $organisationHasOrganisations1
 * @property OrganisationImage[] $organisationImages
 * @property OrganisationProfile $organisationProfile
 * @property Users[] $users
 * @property Service[] $services
 */
class Organisation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Organisation the static model class
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
		return 'organisation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_at, name', 'required'),
			array('active, system_active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('modified_at, deleted_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, create_at, modified_at, deleted_at, active, system_active, name', 'safe', 'on'=>'search'),
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
			'organisationHasOrganisations' => array(self::HAS_MANY, 'OrganisationHasOrganisation', 'organisation_id'),
			'organisationHasOrganisations1' => array(self::HAS_MANY, 'OrganisationHasOrganisation', 'organisation_id1'),
			'organisationImages' => array(self::HAS_MANY, 'OrganisationImage', 'organisation_id'),
			'organisationProfile' => array(self::HAS_ONE, 'OrganisationProfile', 'organisation_id'),
			'users' => array(self::MANY_MANY, 'Users', 'organisation_users(organisation_id, users_id)'),
			'services' => array(self::MANY_MANY, 'Service', 'service_organisation(organisation_id, service_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'create_at' => 'Create At',
			'modified_at' => 'Modified At',
			'deleted_at' => 'Deleted At',
			'active' => 'Active',
			'system_active' => 'System Active',
			'name' => 'Name',
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
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('deleted_at',$this->deleted_at,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('system_active',$this->system_active);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		$this->modified_at =  new CDbExpression('NOW()');
		return parent::beforeSave();		
	}
	
}