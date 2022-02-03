<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/* @var $this UpdateController */

$this->breadcrumbs = [
  'Utilites',
];
?>

<h1><?= Yii::t('main', 'Обновления') ?></h1>
<hr/>
<!-- ================================================ -->
<div class="form">
  <form id="command1">
    <div class="row">
        <?= Yii::t('main', 'Сформировать обновление') ?>
    </div>
    <div class="row buttons">
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'info',
            'icon'        => 'legal white',
            'label'       => Yii::t('main', 'Сделать обновление'),
//    'loadingText'=>Yii::t('main','Выполняется...'),
//    'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/update/command',
              ['cmd' => 'make_update']
            ),
            'htmlOptions' => ['class' => 'btn-block'],
            'ajaxOptions' => ['update' => '#resultBlock1', 'timeout' => '300000'],
          ]
        );
        ?>
    </div>
    <div id="resultBlock1"></div>
  </form>
</div>
<!-- ================================================ -->
<div class="form">
  <form id="command2">
    <div class="row">
        <?= Yii::t('main', 'Отмена изменений') ?>
    </div>
    <div class="row buttons">
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'success',
            'icon'        => 'cloud-download white',
            'label'       => Yii::t('main', 'Откатить изменения'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/update/command',
              ['cmd' => 'get_update']
            ),
            'htmlOptions' => ['class' => 'btn-block'],
            'ajaxOptions' => ['update' => '#resultBlock2', 'timeout' => '300000'],
          ]
        );
        ?>
    </div>
    <select size="3" name="backup">
        <?php
        $dir = realpath(Yii::app()->basePath . '/..') . '/backup';
        if (is_dir($dir)) {
            $files = scandir($dir);    //сканируем (получаем массив файлов)
            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            for ($i = 0; $i < sizeof($files); $i++) {
                if ($i == 0) {
                    //$s = substr($files[$i],0,strpos($files[$i],'_'));
                    echo '<option selected value="' . $files[$i] . '">' . $files[$i] . '</option>';
                } else {
                    echo '<option value="' . $files[$i] . '">' . $files[$i] . '</option>';
                }
            }
        };
        ?>
    </select>
    <div id="resultBlock2"></div>
  </form>
</div>
<!-- ================================================ -->
<div class="form">
  <form id="command3">
    <div class="row">
        <?= Yii::t('main', 'Применить обновление') ?>
    </div>
    <div class="row buttons">
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajaxSubmit',
            'type'        => 'danger',
            'icon'        => 'play white',
            'label'       => Yii::t('main', 'Применить обновление'),
//      'loadingText'=>Yii::t('main','Выполняется...'),
//      'completeText'=>Yii::t('main','Выполнено'),
            'url'         => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/update/command',
              ['cmd' => 'apply_update']
            ),
            'htmlOptions' => ['class' => 'btn-block'],
            'ajaxOptions' => ['update' => '#resultBlock3', 'timeout' => '300000'],
          ]
        );
        ?>
    </div>
    <div id="resultBlock3"></div>
  </form>
</div>