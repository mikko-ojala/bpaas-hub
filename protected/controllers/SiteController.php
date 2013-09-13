<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Service', array(
			'criteria'=>array(
				'condition'=>'active=1',
				'order'=>'modified_at DESC',
				'limit'=>'15'
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function actionSearch()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$model=new SearchForm;
		if(isset($_POST['SearchForm']))
		{
			$model->attributes=$_POST['SearchForm'];			
			if($model->validate())
			{
				$service=new Service;
				$criteria=new CDbCriteria;
				$criteria->condition='name LIKE :keyword';
				$criteria->params=array(':keyword'=>'%'.$model->searchquery.'%');
				// renders the view file 'protected/views/site/index.php'
				// using the default layout 'protected/views/layouts/main.php'
				$dataProvider=new CActiveDataProvider('Service', array('criteria'=>$criteria));
				//$this->render(array('search',array('dataProvider'=>$dataProvider, 'model'=>$model)));											
				//$this->render('search',array('model'=>$model));		
				$this->render('search',array('model'=>$model,'dataProvider'=>$dataProvider));		

			}
		}
		else
		{
			$dataProvider=new CActiveDataProvider('Service', array(
				'criteria'=>array(
					'condition'=>'active=1',
					'order'=>'modified_at DESC',
					'limit'=>'10'
				),
				'pagination'=>array(
					'pageSize'=>20,
				),
			));
			$this->render('search',array('model'=>$model,'dataProvider'=>$dataProvider));		
		}
	}




	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	/*****************************************************************************************************/

	public function actionViewservice($id)
	{
		
		$this->render('viewservice',array(
			'model'=>$this->loadServiceModel($id),
			'users'=>$this->loadServiceUsers($id),
			'organisations'=>$this->loadServiceOrganisation($id),
		));
	}	
	
	public function actionViewuser($id)
	{
		
		$this->render('viewuser',array(
			'model'=>$this->loadUserModel($id),
			'organisations'=>$this->loadUserOrganisations($id),
			'services'=>$this->loadUserServices($id),
		));
	}		
	
	public function actionVieworganisation($id)
	{
		
		$this->render('vieworganisation',array(
			'model'=>$this->loadOrganisationModel($id),
			'users'=>$this->loadOrganisationUsers($id),
			'services'=>$this->loadOrganisationServices($id),
		));
	}	
	
	/*----------------------------------------------------------------------------------------------------------------------------------------------*/
	
	public function loadServiceModel($id)
	{
		$model=Service::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadUserModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	
	
	public function loadOrganisationModel($id)
	{
		$model=Organisation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	
	

	/*----------------------------------------------------------------------------------------------------------------------------------------------*/
	public function loadServiceOrganisation($id)
	{
		$dataProvider=new CActiveDataProvider('Organisation', array(
			'criteria'=>array(
				'with'=>array('services'=>array(	
				'on'=>'services.id=' .$id,
				'together'=>true,
				'joinType'=>'INNER JOIN', 
				)),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
		return $dataProvider;
	}
	
	
	public function loadServiceUsers($id)
	{		
		$criteria=new CDbCriteria;
		$criteria->with = array('users'=>array('user_id'=>':ID', array(':ID'=>$id)), 'id', 'name');
		
		$dataProvider=new CActiveDataProvider('Users', array(
			'criteria'=>array(
				'with'=>array('services'=>array(
				'on'=>'services.id=' .$id,
				'together'=>true,
				'joinType'=>'INNER JOIN', 
				)),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		return $dataProvider;
	}	
	
	/*----------------------------------------------------------------------------------------------------------------------------------------------*/
	public function loadOrganisationUsers($id)
	{		
		$criteria=new CDbCriteria;
		$criteria->with = array('users'=>array('user_id'=>':ID', array(':ID'=>$id)), 'id', 'name');
		
		$dataProvider=new CActiveDataProvider('Users', array(
			'criteria'=>array(
				'with'=>array('organisations'=>array(
				'on'=>'organisations.id=' .$id,
				'together'=>true,
				'joinType'=>'INNER JOIN', 
				)),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		return $dataProvider;
	}		
	
	public function loadOrganisationServices($id)
	{		
		$criteria=new CDbCriteria;
		$criteria->with = array('users'=>array('user_id'=>':ID', array(':ID'=>$id)), 'id', 'name');
		
		$dataProvider=new CActiveDataProvider('Service', array(
			'criteria'=>array(
				'with'=>array('organisations'=>array(
				'on'=>'organisations.id=' .$id,
				'together'=>true,
				'joinType'=>'INNER JOIN', 
				)),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		return $dataProvider;
	}		
	/*----------------------------------------------------------------------------------------------------------------------------------------------*/
	public function loadUserServices($id)
	{		
		$criteria=new CDbCriteria;
		$criteria->with = array('users'=>array('user_id'=>':ID', array(':ID'=>$id)), 'id', 'name');
		
		$dataProvider=new CActiveDataProvider('Service', array(
			'criteria'=>array(
				'with'=>array('users'=>array(
				'on'=>'users.id=' .$id,
				'together'=>true,
				'joinType'=>'INNER JOIN', 
				)),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		return $dataProvider;
	}		
	
	public function loadUserOrganisations($id)
	{		
		$criteria=new CDbCriteria;
		$criteria->with = array('users'=>array('user_id'=>':ID', array(':ID'=>$id)), 'id', 'name');
		
		$dataProvider=new CActiveDataProvider('Organisation', array(
			'criteria'=>array(
				'with'=>array('users'=>array(
				'on'=>'users.id=' .$id,
				'together'=>true,
				'joinType'=>'INNER JOIN', 
				)),
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		return $dataProvider;
	}				
		
}