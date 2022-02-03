<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="page.php">
 * </description>
 * Впомогательный рендеринг подменю категорий. Как на старых сайтах с АПИ.
 * Когда сама по себе категория ничего не может икать, выдавался список её подкатегорий.
 * В нашем случае давно не используется.
 **********************************************************************************************************************/
?>
<div class="page-title">
    <?= $this->pageTitle ?>
</div>
<? $seo_catalog_depth = DSConfig::getVal('seo_catalog_depth'); ?>
<div class="content">
  <ul>
      <? foreach ($links as $submenu) { ?>
        <li>
          <a href="<?= Yii::app()->createUrl(
            '/category/index',
            ['name' => $submenu['url']]
          ) ?>" <?= ($seo_catalog_depth > 0 ? '' : 'rel="nofollow"') ?>>
              <?= $submenu['view_text'] ?>
          </a>
            <? if (isset($submenu['children'])) { ?>
              <ul>
                  <? foreach ($submenu['children'] as $submenu2) { ?>
                    <li>
                      <a href="<?=
                      Yii::app()->createUrl(
                        '/category/index',
                        ['name' => $submenu2['url']]
                      ) ?>" <?= ($seo_catalog_depth > 1 ? '' : 'rel="nofollow"') ?>>
                          <?= $submenu2['view_text'] ?>
                          <? if (isset($submenu2['children'])) { ?>
                            <ul>
                                <? foreach ($submenu2['children'] as $submenu3) { ?>
                                  <li>
                                    <a href="<?=
                                    Yii::app()->createUrl(
                                      '/category/index',
                                      ['name' => $submenu3['url']]
                                    ) ?>" <?= ($seo_catalog_depth > 2 ? '' : 'rel="nofollow"') ?>>
                                        <?= $submenu3['view_text'] ?>
                                  </li>
                                <? } ?>
                            </ul>
                          <? } ?>
                    </li>
                  <? } ?>
              </ul>
            <? } ?>
        </li>
      <? } ?>
  </ul>
</div>
