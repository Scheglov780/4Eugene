<?php
/*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Controller.php">
 * </description>
 **********************************************************************************************************************/
?>
<?= '<?' ?>
/*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
<description file="<?= $this->controllerClass ?>.php">
  *
</description>
**********************************************************************************************************************/
<?= '?>' ?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass . "\n"; ?>
{
public $breadcrumbs;
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='main';

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
/** @var <?php echo $this->modelClass; ?> $model */
$model=new <?php echo $this->modelClass; ?>;

// Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model,"<?php echo strtolower($this->modelClass); ?>-create-form");
if(Yii::app()->request->isAjaxRequest) {
if(isset($_POST['<?php echo $this->modelClass; ?>']))
{
$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
if($model->save())          {
echo Yii::t('admin', 'Данные сохранены');
} else {
echo Yii::t('admin', 'Ошибка сохранения данных');
}
return;
}
} else {
if(isset($_POST['<?php echo $this->modelClass; ?>'])) {
$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
$model->save();
}

$this->render('create',array(
'model'=>$model,
));
}
}

/**
* Performs the AJAX validation.
* @param CModel the model to be validated
*/
protected function performAjaxValidation($model,$form_id)
{
if(isset($_POST['ajax']) && $_POST['ajax']===$form_id)
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}

/**
* Deletes a particular model.
* If deletion is successful, the browser will be redirected to the 'admin' page.
* @param integer $id the ID of the model to be deleted
*/
public function actionDelete()
{
$id=$_POST["id"];

if(Yii::app()->request->isPostRequest)
{
// we only allow deletion via POST request
$this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
if(!isset(Yii::app()->request->isAjaxRequest)) {
$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
} else {
echo "true";
}
} else {
if(!isset($_GET['ajax'])) {
throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
} else {
echo "false";
}
}
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=<?php echo $this->modelClass; ?>::model()->findByPkEx($id);
if($model===null) {
throw new CHttpException(404,'The requested page does not exist.');
}
return $model;
}

/**
* Lists all models.
*/
public function actionIndex()
{
/** @var <?php echo $this->modelClass; ?> $model */
$model=new <?php echo $this->modelClass; ?>('search');
$model->unsetAttributes();  // clear any default values

if(isset($_GET['<?php echo $this->modelClass; ?>'])) {
$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];
}
$this->renderPartial(
'index',
array(
'model' => $model,
),
false,
true
);
}

/**
* Updates a particular model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id the ID of the model to be updated
*/
public function actionUpdate($id = false)
{
/** @var <?php echo $this->modelClass; ?> $model */
if ($id === false) {
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:$_REQUEST["<?php echo $this->modelClass; ?>"]["<?php echo $this->tableSchema->primaryKey; ?>"];
}
$model=$this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model,"<?php echo strtolower($this->modelClass); ?>-update-form");

if(Yii::app()->request->isAjaxRequest)
{

if(isset($_POST['<?php echo $this->modelClass; ?>'])) {
unset($_POST['<?php echo $this->modelClass; ?>']['created']);
$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
if($model->save()) {
echo Yii::t('admin', 'Параметры сохранены');
} else {
echo Yii::t('admin', 'Ошибка сохранения параметров');
}
return;
}

$this->renderPartial('_ajax_update_form',array(
'model'=>$model,
));
return;

}

if(isset($_POST['<?php echo $this->modelClass; ?>'])) {
$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
$model->save();
}

$this->render('update',array(
'model'=>$model,
));
}

/**
* Displays a particular model.
* @param integer $id the ID of the model to be displayed
*/
public function actionView($id = false)
{
if (!isset($id) || $id === false) {
$id=$_REQUEST["id"];
}
$model = $this->loadModel($id);
$this->renderPartial(
'update',
array(
'model' => $model
),
false,
true
);
}

public function actionGenerateExcel()
{
if(Yii::app()->session->contains('<?php echo $this->modelClass; ?>_records'))
{
$model=Yii::app()->session->get('<?php echo $this->modelClass; ?>_records');
}
else
$model = <?php echo $this->modelClass; ?>::model()->findAll();

Yii::app()->request->sendFile('<?php echo $this->modelClass; ?>-'.date('YmdHis').'.xls',
$this->renderPartial('excelReport', array(
'model'=>$model
), true,false,true)
);
}
}
