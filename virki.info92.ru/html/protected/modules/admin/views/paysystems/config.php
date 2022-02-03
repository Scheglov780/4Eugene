<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="config.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var customCmsMenus $model */ ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Конфигурация платёжной системы') ?> #<?php echo $model->name_en; ?>
  </h1>
</section>
<!-- Main content -->
<section class="content">
    <?php $this->renderPartial('_form_config', ['model' => $model]); ?>
</section>
