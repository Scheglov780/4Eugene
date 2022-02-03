<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="main.php">
 * </description>
 * Главная страница сайта (не путать с лэйаутом)
 * var $itemsPopular = true
 * var $itemsRecommended = true
 * var $itemsRecentUser = false
 * var $itemsRecentAll = true
 **********************************************************************************************************************/
?>
<!-- our Teammates Start-->
<section class="teammatesSec  bggray">
  <div class="container">
      <?= cms::customContent('kd:testimonials2') ?>
  </div>
</section>
<!-- our Teammates End-->

<section class="toprowSec">
  <div class="container">
      <?= cms::customContent('kd:ourTech') ?>
  </div>
</section>
<section class="commonSection bggray">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
          <?= cms::customContent('kd:transport') ?>
      </div>
    </div>
  </div>
</section>
<!--Call to Action Start-->
<section class="commonSection callToaction overlay85">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1">
        <div class="commonHeadding">
            <?= cms::customContent('kd:companyPromise') ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Call to Action End-->
<!--Client Start -->
<section class="clientSec">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
          <?= cms::customContent('kd:brands') ?>
      </div>
    </div>
  </div>
</section>

<!--Blog News Start-->
<? if (DSConfig::getVal('blogs_enabled') == 1) { ?>
  <section class="blogNews">
    <div class="container">
      <div class="newsBlogIn">
          <?
          $this->widget(
            'application.components.widgets.BlogGalleryBlock',
            [
              'pageSize' => 3,
              'template' => '{items} {pager}',
                // 'ajaxUrl' => '/site/index',
                /*            'condition' =>'t.enabled=1 and (t.start_date is null or t.start_date <= Now()) and (t.end_date is null or t.start_date >= Now())'
                            'condition' =>'t.category_id=123',
                            или
                            'condition' =>'t.category_id in (123,14,125)',
                            или даже, если не ошибаюсь, так
                            'condition' =>"categoryName in ('категория 1','категория 2','категория 3')",
                */
            ]
          );
          ?>
      </div>
    </div>
  </section>
<? } ?>
<!--Blog News End -->
