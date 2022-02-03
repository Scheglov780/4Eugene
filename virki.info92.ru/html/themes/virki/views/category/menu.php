<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="menu.php">
 * </description>
 * Рендеринг меню категорий
 **********************************************************************************************************************/
?>
<? $this->widget(
  'application.components.widgets.CategoriesMenuBlock',
  [
    'lang' => (isset($lang) ? $lang : false),
    'topLevelCount' => (isset($topLevelCount) ? $topLevelCount : 1000),
  ]
); ?>