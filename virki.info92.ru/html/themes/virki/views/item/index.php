<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 * Рендеринг карты товара
 **********************************************************************************************************************/
?>
<?
Yii::app()->clientScript->registerCssFile(
  $this->frontThemePath . '/css/' . (YII_DEBUG ? 'magiczoomplus.css' : 'magiczoomplus.min.css'),
  'screen'
);
Yii::app()->clientScript->registerCssFile(
  $this->frontThemePath . '/css/' . (YII_DEBUG ? 'magicscroll.css' : 'magicscroll.min.css'),
  'screen'
);
Yii::app()->clientScript->registerScriptFile(
  $this->frontThemePath . '/js/' . (YII_DEBUG ? 'magicscroll.js' : 'magicscroll.min.js'),
  CClientScript::POS_HEAD
);
Yii::app()->clientScript->registerScriptFile(
  $this->frontThemePath . '/js/' . (YII_DEBUG ? 'magiczoomplus.js' : 'magiczoomplus.min.js'),
  CClientScript::POS_HEAD
);
?>
<? $seo_disable_items_index = false;//DSConfig::getVal('seo_disable_items_index') == 1; ?>
<section class="projectSingleSec">
  <div class="container">
        <span itemscope itemtype="http://schema.org/Product" itemref="_description3 _offers4" translate="no">
        <div class="row">
            <div class="col-lg-8">
                <div class="singleProCaro singleProCaroItemCard">
            <? Yii::app()->controller->renderPartial(
              'item_images',
              [
                'item' => $item,
              ],
              false,
              false
            ); ?>
               </div>
                <div class="projectDetais">
                    <? /*
                    <h2 class="proDetaTitle">More Project Details</h2>
                    <p>
                        Fusce sapien metus, iaculis ac consectetur ut, blandit eu magna.
                        In sodales laoreet eros, eu feugiat odio. Nullam mi dolor,
                        vulputate sed laoreet vitae, posuere faucibus tellus. Nullam nulla leo,
                        mattis vel vulputate et, faucibus id felis. Vivamus id eros malesuada velit auctor venenatis.
                        Aliquam mollis pulvinar elit, tempus ultrices nisi. Maecenas in viverra elit. Cras at
                        consectetur ante.
                        Maecenas ac faucibus est, et accumsan nisi. Curabitur eget sollicitudin metus.
                        Nunc quis elit volutpat, posuere tortor sit amet, vestibulum dolor.
                    </p>
                    <p>
                        Donec laoreet enim augue, ut molestie magna lacinia vitae.
                        Duis vitae ullamcorper ante, eu vulputate est. Suspendisse bibendum, quam sed congue sodales,
                        mi ligula fermentum magna, nec posuere metus quam eu odio. Cras vehicula pulvinar urna, sed
                        dapibus arcu rhoncus tristique.
                        Phasellus tempus urna eu sagittis egestas. Fusce commodo velit eu mauris pellentesque euismod.
                        Pellentesque faucibus enim ut vehicula ornare.
                        Vestibulum porta justo a rutrum feugiat. Integer tincidunt congue ligula nec elementum.
                    </p>
                    <p>
                        Fusce metus est, dapibus eu elit vitae, luctus convallis ligula. Sed tempus ut odio id posuere.
                        Cras condimentum ante turpis, quis ullamcorper est tincidunt quis. Praesent a suscipit diam.
                        Curabitur ac commodo lacus.
                        Sed auctor nulla quis quam tincidunt euismod. Sed sollicitudin sapien viverra arcu tincidunt
                        imperdiet.
                        Cras at luctus lacus. Integer ultricies est eros,
                        quis varius est elementum a. Aenean congue rhoncus mi, ut bibendum risus suscipit eu.
                        Curabitur non interdum ligula. Nulla facilisi.
                    </p>
                    <p>
                        Sed a dignissim nunc. Nulla nec sem pulvinar,
                        vehicula nisl sed, maximus felis. Curabitur fringilla laoreet sem et convallis.
                        Maecenas vestibulum sapien ex. Vivamus elementum sodales quam, sed porttitor risus suscipit
                        quis.
                        Maecenas dictum erat vitae leo molestie, vestibulum fermentum lacus imperdiet. Sed venenatis
                        metus eu hendrerit ultricies.
                        Praesent consequat nisi non velit laoreet egestas. Fusce laoreet augue nibh, sit amet tempor
                        mauris mollis in. Nulla facilisi.
                        Nullam tempor tortor et ex dignissim viverra. Ut aliquam egestas ante, quis facilisis tortor
                        sagittis eu. Vivamus in ipsum sit amet enim ultricies mattis.
                        Aliquam feugiat, lorem eget dapibus euismod,diam, quis imperdiet lorem turpis quis nisi. Vivamus
                        mauris urna,
                        placerat a auctor interdum, dignissim nec lorem. Mauris at elementum quam, ac accumsan elit.
                    </p>
                  */ ?>
                   <h2 class="proDetaTitle"><?= Yii::t('main', 'Популярные проекты') ?></h2>
                    <? if (!Yii::app()->user->isGuest or true) { ?>
                        <? include_once __DIR__ . '/_ajaxRecentAllItemslistForItem.php' ?>
                    <? } ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="projectSingleInfo">
                    <h2 itemprop="name" class="projectSininTitle"><?= $item->top_item->title ?></h2>
                                <? if (!$this->preLoading) {
                                    Yii::app()->controller->renderPartial(
                                      'item_info',
                                      ['item' => $item],
                                      false,
                                      false
                                    );
                                } ?>
                </div>
                <div class="projectSingleText">
                                    <? /*
                    <h2 class="projectSininTitle two">Project Details</h2>
                    <p>
                        Nullam sed ex tempus velit dignissim tincidunt eu non tellus. Aliquam mollis quam ex, nec
                        pharetra dolor mattis nec.
                        Morbi ac scelerisque mauris. Sed ornare elementum ligula sed fermentum. Donec posuere efficitur
                        erat quis tempor.
                        Nam rutrum augue in lorem vehicula interdum. Sed molestie dolor malesuada lobortis ullamcorper.
                        Donec varius augue ipsum, id fermentum metus aliquam sed. Etiam malesuada magna quis justo
                        laoreet faucibus.
                    </p>
              */ ?>
                    <div class="headMiddBtn pull-right">
                    <? $this->widget(
                      'application.components.widgets.SendMessageBlock',
                      [
                        'label' => Yii::t('main', 'Закажите проект'),
                        'asButton' => true,
                          //'subj' => 'Хочу заказать проект '.$item->title,
                        'message' => 'Хочу заказать проект: ' . $item->top_item->title,
                      ]
                    ); ?>
                </div>
                </div>
            </div>
        </div>
        </span>
  </div>
</section>