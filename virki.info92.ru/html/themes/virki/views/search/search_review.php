<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_images.php">
 * </description>
 * Рендеринг фото товара
 **********************************************************************************************************************/
?>
<strong><?= Yii::t('main', 'Ссылка на категорию или товары продавца') ?>:</strong><a
    href="<?= $this->createUrl($this->route, $_GET); ?>" target="_blank">
    <?= $this->createAbsoluteUrl($this->route, $_GET); ?>
</a>