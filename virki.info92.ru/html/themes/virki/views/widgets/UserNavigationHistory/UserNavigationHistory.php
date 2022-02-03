<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserNavigationHistory.php">
 * </description>
 * Рендеринг блока истории просмотра для текущего пользователя
 * var $links
 **********************************************************************************************************************/
?>
<div class="container" style="display: none">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <? if ($links) { ?>
          <ul>
              <? foreach ($links as $link) { ?>
                <li><a href="<?= Yii::app()->createUrl($link->url) ?>"
                       title="<?= $link->label ?>"><?= $link->label ?></a></li>
              <? } ?>
          </ul>
        <? } ?>
    </div><!--End:Col-->
  </div><!--End:Row-->
</div><!--End:Container-->