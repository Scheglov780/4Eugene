<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="menuItem.php">
 * </description>
 **********************************************************************************************************************/
?>
<div class="col-lg-4 col-xs-12 col-sm-6">
  <div class="singleProject">
    <a title="<?= Yii::t('main', 'Перейти к категории') ?>: <?= $data['view_text'] ?>"
       href="<?= Yii::app()->createUrl('/category/index', ['name' => $data['url']]) ?>">
      <div class="projectImg">
        <img src="<?= $data['decorate'] ?>"
             alt="<?= Yii::t(
               'main',
               $data['view_text']
             ) ?>"
        >
      </div>
    </a>
    <h1 style="font-family: 'gost' !important; font-size: 24px !important; font-weight: 400 !important; line-height: 30px !important;"><?= $data['view_text'] ?></h1>
  </div>
</div>

