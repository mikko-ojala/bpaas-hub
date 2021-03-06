<?php

class ServiceController extends Controller
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
				'actions'=>array('admin', 'delete'),
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
		$model=new Service;
		$user_relation = new ServiceUsers();
		$org_relation = new ServiceOrganisation();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Service'],$_POST['ServiceUsers'],$_POST['ServiceOrganisation']))
		{
			
			$transaction=$model->dbConnection->beginTransaction();
			
			$model->attributes=$_POST['Service'];			
			$model->create_at =  new CDbExpression('NOW()');
			
			$model->save();	
			
			$current_id=$model->id;
			
			$user_relation->attributes=$_POST['ServiceUsers'];
			$user_relation->service_id=$current_id;
			$user_relation->users_id=Yii::app()->user->id;
			$user_relation->reserved1=1;
			$user_relation->reserved2=1;
			$user_relation->owner=1;
			

			$org_relation->attributes=$_POST['ServiceOrganisation'];			
			$org_relation->service_id=$current_id;
			$org_relation->reserved1=1;
			$org_relation->reserved2=1;

			
			
			if($user_relation->save() && $org_relation->save()) {
				$transaction->commit();				
				$this->redirect(array('view','id'=>$model->id));							
			}			
			else {
				print_r($model->getErrors());
				echo Yii::trace('can not save model');
				echo Yii::trace(CVarDumper::dumpAsString($model),'vardump');
				echo Yii::trace(CVarDumper::dumpAsString($org_relation),'vardump');
				echo Yii::trace(CVarDumper::dumpAsString($user_relation),'vardump');
				
				$transaction->rollback();

			}

		}				

		$this->render('create',array(
			'model'=>$model,
			'user_relation'=>$user_relation,
			'org_relation'=>$org_relation
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
		
		$user_relation=$this->loadServiceUsers($id);
		$org_relation = $this->loadServiceOrganisation($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		echo Yii::trace('What');
		if(isset($_POST['Service'])) echo  Yii::trace('Service');
		if(isset($_POST['ServiceUsers'])) echo  Yii::trace('ServiceUsers');
		if(isset($_POST['ServiceOrganisation'])) echo  Yii::trace('ServiceOrganisation');
		
		if(isset($_POST['Service'],$_POST['ServiceUsers'],$_POST['ServiceOrganisation']))
		{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
			
			echo Yii::trace('Transaction');
			$transaction=$model->dbConnection->beginTransaction();
			
			$model->attributes=$_POST['Service'];			
			$model->create_at =  new CDbExpression('NOW()');
			
			$model->save();	
			
			//$current_id=$model->id;
			
			$user_relation->attributes=$_POST['ServiceUsers'];
			$user_relation->service_id=$id;
			$user_relation->users_id=Yii::app()->user->id;
			$user_relation->reserved1=1;
			$user_relation->reserved2=1;
			$user_relation->owner=1;
			

			$org_relation->attributes=$_POST['ServiceOrganisation'];			
			$org_relation->service_id=$id;
			$org_relation->reserved1=1;
			$org_relation->reserved2=1;

			
			
			if($user_relation->save() && $org_relation->save()) {
				$transaction->commit();				
				echo Yii::trace('Model saved and relations also');
				$this->redirect(array('view','id'=>$model->id));							
			}			
			else {
				print_r($model->getErrors());
				echo Yii::trace('can not save model');
				echo Yii::trace(CVarDumper::dumpAsString($model),'vardump');
				echo Yii::trace(CVarDumper::dumpAsString($relation),'vardump');
				
				$transaction->rollback();

			}			
			

//			$model->attributes=$_POST['Service'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'user_relation'=>$user_relation,
			'org_relation'=>$org_relation			
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
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
		$dataProvider=new CActiveDataProvider('Service');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Service('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Service']))
			$model->attributes=$_GET['Service'];

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
		$model=Service::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
	public function loadServiceOrganisation($id)
	{
		$model= ServiceOrganisation::model()->findByAttributes(array('service_id'=>$id));
		if($model===null)
			throw new CHttpException(500,'The server encountered an unexpected condition which prevented it from fulfilling the request.');
		return $model;
	}
	
	
	public function loadServiceUsers($id)
	{
		$model= ServiceUsers::model()->findByAttributes(array('service_id'=>$id));
		if($model===null)
			throw new CHttpException(500,'The server encountered an unexpected condition which prevented it from fulfilling the request.');
		return $model;
	}
	

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='service-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}
