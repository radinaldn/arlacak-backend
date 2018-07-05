<?php

class LokasiPentingController extends Controller
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
			// NON AKTIF KAN BUAT AKSI DELETE
			// 'postOnly + delete', // we only allow deletion via POST request
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
				'users'=>array('@'),
				//'expression'=>'Yii:app()->user->isAdmin',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','admin','delete', 'datalokasi'),
				'users'=>array('@'),
				// expession masih error
				//'expression'=>'Yii:app()->user->isAdmin',
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
		$model=new LokasiPenting;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LokasiPenting']))
		{
			$rnd = rand(0,9999);
			$model->attributes=$_POST['LokasiPenting'];
			$model->image='polsek/tes.jpg';

			if($model->save())
			{
			if(CUploadedFile::getInstance($model,'image'))
					{
						$newfilename='polsek/'.$model->id.'.jpg';
						$model->image=CUploadedFile::getInstance($model,'image');
						$model->image->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newfilename);
						$model->image=$newfilename;
						$model->save();
					}
					if(CUploadedFile::getInstance($model,'image'))  // check if uploaded file is set or not
					{
						//todo
					}
				
				}
				if(!empty ($uploadedFile))
					{
						$fileName = "{$rnd}-{$uploadedFile}";
						$var = '';
						$model->image = $var.'/images/img'.$fileName;
						$model->save();
						
						$name=Yii::app()->basePath.'/../images/img'.$fileName;
						$uploadedFile->saveAs($name);
					}	
					$this->redirect(array('admin'));
				//direct to detail view	
				//$this->redirect(array('view','id'=>$model->id));
			
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LokasiPenting']))
		{
			$rnd = rand(0,9999);
			$model->attributes=$_POST['LokasiPenting'];
			$model->image='polsek/tes.jpg';
			
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
			{
				if(CUploadedFile::getInstance($model,'image'))
					{
						$newfilename='polsek/'.$model->id.'.jpg';
						$model->image=CUploadedFile::getInstance($model,'image');
						$model->image->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newfilename);
						$model->image=$newfilename;
						$model->save();
					}
					if(CUploadedFile::getInstance($model,'image'))  // check if uploaded file is set or not
					{
						//todo
					}
				
				}
				if(!empty ($uploadedFile))
					{
						$fileName = "{$rnd}-{$uploadedFile}";
						$var = '';
						$model->image = $var.'/images/img'.$fileName;
						$model->save();
						
						$name=Yii::app()->basePath.'/../images/img'.$fileName;
						$uploadedFile->saveAs($name);
					}	
					$this->redirect(array('admin'));	
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('LokasiPenting');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));

		// direct to admin page
		$this->redirect("admin");
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$db=new LokasiPenting('search');
		$db->unsetAttributes();  // clear any default values
		if(isset($_GET['LokasiPenting']))
			$db->attributes=$_GET['LokasiPenting'];

		$model = LokasiPenting::model()->findAll();

		$this->render('admin',array(
			'model'=>$model,
			'db'=>$db,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LokasiPenting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LokasiPenting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LokasiPenting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lokasi-penting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}