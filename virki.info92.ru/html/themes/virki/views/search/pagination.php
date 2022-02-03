<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="pagination.php">
 * </description>
 * Рендеринг переключателя страниц
 * var $pages
 **********************************************************************************************************************/
?>
<?
$this->widget(
  'application.components.TbSEOLinkPager',
  [
    'pages'           => $pages,
    'header'          => '',
    'htmlOptions'     => ['class' => 'pagination pagination-lg'],
    'linkHtmlOptions' => ['rel' => 'nofollow',],
    'prevPageLabel'   => '<i class="fa fa-angle-left fa-fw"></i>',
    'nextPageLabel'   => '<i class="fa fa-angle-right fa-fw"></i>',
    'lastPageLabel'   => '',//'<i class="fa icon-double-angle-right fa-fw"></i>',
    'firstPageLabel'  => '',//'<i class="fa icon-double-angle-left fa-fw"></i>',
  ]
);
/*'pagerCssClass' => 'box-heading',
    'pager' =>array(
  'class'=>'CLinkPager',
  'cssFile'=>false,
  'prevPageLabel'=>'<i class="fa fa-angle-left fa-fw"></i>',
  'nextPageLabel'=>'<i class="fa fa-angle-right fa-fw"></i>',
  'firstPageLabel' => '',
  'lastPageLabel' => '',
  'header'=>$this->title,
), */