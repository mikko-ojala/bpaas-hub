<?php

class OrganisationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','admindelete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Organisation;		
		$relation=new OrganisationUsers;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Organisation'], $_POST['OrganisationUsers']))
		{			
			$transaction=$model->dbConnection->beginTransaction();
			
			$model->attributes=$_POST['Organisation'];			
			$model->create_at =  new CDbExpression('NOW()');
			
			$model->save();	
			
			$command = Yii::app()->db->createCommand('SHOW TABLE STATUS LIKE "organisation"');
			$res=$command->queryRow();      
			$current_id=$res['Auto_increment']-1;
			
			$relation->attributes=$_POST['OrganisationUsers'];
			$relation->organisation_id=$current_id;
			$relation->users_id=Yii::app()->user->id;
			$relation->reserved1=1;
			$relation->reserved2=1;
			$relation->owner=1;
			

			
			
			if($relation->save()) {
				$transaction->commit();				
				$this->redirect(array('view','id'=>$model->id));							
			}			
			else {
				print_r($model->getErrors());
				echo Yii::trace('can not save model');
				echo Yii::trace(CVarDumper::dumpAsString($model),'vardump');
				echo Yii::trace(CVarDumper::dumpAsString($relation),'vardump');
				
				$transaction->rollback();

			}

		}
		

		$this->render('create',array(
			'model'=>$model,
			'relation'=>$relation
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$relation=$this->loadModelUsers($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Organisation'], $_POST['OrganisationUsers']))
		{			
			$transaction=$model->dbConnection->beginTransaction();
			$created=$model->create_at;
			$model->attributes=$_POST['Organisation'];			
			$model->create_at =  $created;
			
			$model->save();	

/*			$command = Yii::app()->db->createCommand('SHOW TABLE STATUS LIKE "organisation"');
			$res=$command->queryRow();      
			$current_id=$res['Auto_increment']-1;*/

			$relation->attributes=$_POST['OrganisationUsers'];
			/*$relation->organisation_id=$current_id;
			$relation->users_id=Yii::app()->user->id;*/
			$relation->reserved1=1;
			$relation->reserved2=1;
			$relation->owner=1;		
			
			if($relation->save()) {
				$transaction->commit();				
				$this->redirect(array('view','id'=>$model->id));							
			}			
			else {
				print_r($model->getErrors());
				echo Yii::trace('can not save model');
				echo Yii::trace(CVarDumper::dumpAsString($model),'vardump');
				echo Yii::trace(CVarDumper::dumpAsString($relation),'vardump');
				
				$transaction->rollback();
			}
			
		}

		$this->render('update',array(
			'model'=>$model,
			'relation'=>$relation
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionAdminDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Organisation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Organisation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Organisation']))
			$model->attributes=$_GET['Organisation'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Organisation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Returns the data model for users table based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModelUsers($id)
	{
		$model=  OrganisationUsers::model()->findByAttributes(array('organisation_id'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='organisation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
}
