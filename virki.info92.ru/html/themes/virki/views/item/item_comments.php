<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="debug.php">
 * </description>
 * Рендеринг работы парсера в режиме отладки
 * var $debugMessages - dataProvider
 **********************************************************************************************************************/
?>
<div class="item-comments">
    <? // Re Init Jquery for Translatrer - no more needed in Yii 1.17
    /* $cs = Yii::app()->clientScript;
    $cs->scriptMap['jquery.js'] = $this->frontThemePath .'/js/jquery-1.11.3.js';
    $cs->scriptMap['jquery.min.js'] = $this->frontThemePath .'/js/jquery-1.11.3.min.js';
    */
    ?>
  <div class="item-comments-stat">
      <?
      if (isset($itemComments->DSGItemCommentsRes->stat) && is_array($itemComments->DSGItemCommentsRes->stat)) {
          foreach ($itemComments->DSGItemCommentsRes->stat as $stat) {
              ?>
            <div class="item-comment-stat<?= ($stat->positive ? ' green' : ' red') ?>"><?=
                Yii::app()->DVTranslator->translateText(
                  $stat->name,
                  'zh-CHS',
                  Utils::appLang(),
                  true
                );
                ?>(<?= $stat->count ?>)
            </div>
              <?
          }
      }
      ?>
  </div>
    <?
    $appLang = Utils::appLang();
    $magicZoomIds = [];
    if ($appLang != 'zh') {
        // Собственно, вызываем перевод через 1 сек.
        // Microsoft.Translator.Widget.TranslateElement = function (from, to, document.documentElement, onProgress(), onError(), onComplete(), onRestoreOriginal(), timeOut, showFloater)
        Yii::app()->clientScript->registerScript(
          'ms-translator-comments-run',
          "
        function itemCommentsTranslate() {
            $('#item-comments-grid .summary').attr('translate','no');
            $('#item-comments-grid .pager').attr('translate','no');
            $('#item-comments-grid .pagination').attr('translate','no');
            $('#item-comments-grid .items > thead').attr('translate','no');
            try {
                Microsoft.Translator.Widget.TranslateElement('zh-CHS', '" . $appLang . "', 
                document.documentElement, null, null, null, null, 100000, false);
            } catch (err) {
                console.log('Problems with online translation detected');
            }
        }          
            $('#item-comments-grid .summary').attr('translate','no');
            $('#item-comments-grid .pager').attr('translate','no');
            $('#item-comments-grid .pagination').attr('translate','no');            
            $('#item-comments-grid .items > thead').attr('translate','no');
            $('.item-comments-stat').attr('translate','no');
            if (typeof deferredTranslateComments != 'undefined') {
            deferredTranslateComments.resolve(true);
            }
        ",
          CClientScript::POS_READY
        );
    }
    $this->widget(
      'booster.widgets.TbGridView',
      [
        'id'              => 'item-comments-grid',
        'type'            => 'striped',
        'dataProvider'    => $itemComments->dataProvider(),
        'enableSorting'   => false,
          /*        'pager'         => array(
                    'header'         => '',
                    'firstPageLabel' => '&lt;&lt;',
                    'prevPageLabel'  => '&lt;',
                    'nextPageLabel'  => '&gt;',
                    'lastPageLabel'  => '&gt;&gt;',
                  ),
          */
          /*
        'pagerCssClass'   => 'pagination',
        'pager'           => array(
          'class'           => 'CSEOLinkPager',
          'header'          => false,
          'maxButtonCount'  => 10,
          'firstPageLabel'  => '',
          'lastPageLabel'   => '',
          'linkHtmlOptions' => array('rel' => 'nofollow'),
//    'cssFile'=>false,
          'prevPageLabel'   => '&lt;',
          'nextPageLabel'   => '&gt;',
        ),
          */
        'pagerCssClass'   => 'pagerNoClass',
        'summaryText'     => Yii::t('main', 'Комментарии') . ' {start}-{end} ' . Yii::t('main', 'из') . ' {count}',
        'template'        => '{summarypager}{items}{pager}',
        'afterAjaxUpdate' => "function(id, data){itemCommentsTranslate();}", //MagicZoomPlus.start();
        'columns'         => [
          [
            'name'   => 'data',
            'type'   => 'raw',
            'header' => Yii::t('main', 'Дата'),
            'value'  => function ($data) {
                if (!$data) {
                    return '';
                }
                $result = $data->date->format('Y-m-d H:i');
                if (isset($data->ratePic) && $data->ratePic) {
                    $result =
                      $result .
                      "<br/><img style='height:12px !important; width:auto !important;' src='{$data->ratePic}'/>";
                }
                return $result;
            },
          ],
          [
            'name'   => 'comment',
            'type'   => 'raw',
            'header' => Yii::t('main', 'Комментарий'),
            'value'  => function ($data) use (&$magicZoomIds) {
                if (!$data) {
                    return;
                }
            if ($data->sku) {
                ?>
              <div style="width: 100% !important;">
                <strong><?= $data->sku ?></strong>
              </div>
            <?
            }
            $comment = $data->comment;
            if ($data->reply) {
                $comment = "<div id='icomment-" . $data->id . "'>" . $comment . '<br/>' . $data->comment . "</div>";
            }
            ?>
              <div>
                  <?= $comment; ?>
              </div>
            <?
            if (isset($data->userImages) && is_array($data->userImages)) {
            foreach ($data->userImages as $userImage) {
            $magicZoomIds[] = $userImage;
            //zoomCaption: off;
            ?>
              <div style="float:left; margin: 5px;">
                <a id="ZoomerComments-<?= md5($userImage) ?>"
                   href="<?= Img::getImagePath($userImage, '', false) ?>"
                   class="MagicZoomComments"
                   data-options="zoomMode: off;
                                             zoomWidth: 240; zoomHeight: 240; zoomPosition: top; zoomDistance: 10
                                             lazyZoom: true;
                                             rightClick: true;
                                             expandCaption: false;
                                             textHoverZoomHint: <?= Yii::t('main', '') ?>;
                                             textClickZoomHint: <?= Yii::t('main', '') ?>;
                                             textExpandHint: <?= Yii::t('main', '') ?>"
                   data-mobile-options="textTouchZoomHint: <?= Yii::t('main', '') ?>;
                                            textClickZoomHint: <?= Yii::t('main', '') ?>;
                                            textExpandHint: <?= Yii::t('main', '') ?>"
                   title="">
                  <img src="<?= Img::getImagePath($userImage, '_80x80.jpg', false) ?>"/>
                </a>
              </div>
              <script>
                  try {
                      MagicZoom.start('ZoomerComments-<?= md5($userImage) ?>');
                  } catch (err) {
                      console.log('Problems with zooming detected');
                  }
              </script>
            <? }
            }
            },

          ],
        ],
      ]
    );
    ?>
</div>