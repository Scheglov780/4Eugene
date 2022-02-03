<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  'Cms Pages Contents' => ['index'],
  $model->title        => ['view', 'id' => $model->id],
  'Update',
];

?>

  <h1><?= Yii::t('main', 'Контент страницы') ?> #<?php echo $model->page_id; ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>