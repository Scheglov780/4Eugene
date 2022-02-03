<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="list.php">
 * </description>
 * Рендеринг списка категорий
 * http://<domain.ru>/ru/category/list
 * var $categories = array - массив, описывающий категории
 * ( 0 => array (
 * 'pkid' => '2'
 * 'cid' => '0'
 * 'parent' => '1'
 * 'status' => '1'
 * 'url' => 'mainmenu-odezhda'
 * 'query' => '女装男装'
 * 'level' => '2'
 * 'order_in_level' => '200'
 * 'view_text' => 'Одежда'
 * 'children' => array
 * (
 * 3 => array(...)
 * 18 => array(...)
 * 31 => array(...)
 * 41 => array(...)
 * 49 => array(...)
 * 60 => array(...)
 * 70 => array(...)
 * 81 => array(...)
 * )
 * )
 **********************************************************************************************************************/
?>
<!--Project Fillter Start-->
<section class="commonSection">
  <div class="container">
    <div class="row">
      <div class="filterCont">
          <? $this->widget(
            'application.components.widgets.CategoriesMenuBlock',
            [
              'lang'          => (isset($lang) ? $lang : false),
              'topLevelCount' => (isset($topLevelCount) ? $topLevelCount : 1000),
            ]
          ); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="headMiddBtn pull-right">
            <? $this->widget(
              'application.components.widgets.SendMessageBlock',
              [
                'label'    => Yii::t('main', 'Закажите проект'),
                'asButton' => true,
              ]
            ); ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Project Fillter End-->
