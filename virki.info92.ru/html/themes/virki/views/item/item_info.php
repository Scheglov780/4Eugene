<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_info.php">
 * </description>
 * Рендеринг блока табов описания товара
 **********************************************************************************************************************/
?>
<ul itemprop="description">
    <? foreach ($item->top_item->item_attributes as $attribute) { ?>
      <li><span><?= $attribute->prop; ?>: </span><?= $attribute->val; ?></li>
    <? } ?>
</ul>
